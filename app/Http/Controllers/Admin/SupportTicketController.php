<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use App\Models\SupportMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SupportTicketController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function index(Request $request)
    {
        $query = SupportTicket::with(['user', 'assignedTo', 'messages' => function($q) {
            $q->latest()->limit(1);
        }]);

        // Filtres
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('assigned_to')) {
            if ($request->assigned_to === 'unassigned') {
                $query->whereNull('assigned_to');
            } else {
                $query->where('assigned_to', $request->assigned_to);
            }
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('subject', 'like', '%' . $search . '%')
                  ->orWhere('ticket_number', 'like', '%' . $search . '%')
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%');
                  });
            });
        }

        $tickets = $query->latest()->paginate(20);

        // Récupérer les admins pour le filtre
        $admins = User::role('admin')->get();

        return view('admin.support.index', compact('tickets', 'admins'));
    }

    public function show(SupportTicket $ticket)
    {
        $ticket->load(['messages.user', 'user', 'assignedTo']);

        // Marquer les messages non lus comme lus pour l'admin actuel
        $ticket->messages()
            ->where('user_id', '!=', auth()->id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return view('admin.support.show', compact('ticket'));
    }

    public function assign(Request $request, SupportTicket $ticket)
    {
        $validated = $request->validate([
            'assigned_to' => 'required|exists:users,id',
        ]);

        $ticket->update([
            'assigned_to' => $validated['assigned_to'],
            'status' => 'in_progress',
        ]);

        return back()->with('success', 'Ticket assigné avec succès.');
    }

    public function updateStatus(Request $request, SupportTicket $ticket)
    {
        $validated = $request->validate([
            'status' => 'required|in:open,in_progress,resolved,closed',
        ]);

        $status = $validated['status'];
        
        switch ($status) {
            case 'in_progress':
                $ticket->markAsInProgress();
                break;
            case 'resolved':
                $ticket->markAsResolved();
                break;
            case 'closed':
                $ticket->markAsClosed();
                break;
            case 'open':
                $ticket->update(['status' => 'open']);
                break;
        }

        return back()->with('success', 'Statut du ticket mis à jour.');
    }

    public function updatePriority(Request $request, SupportTicket $ticket)
    {
        $validated = $request->validate([
            'priority' => 'required|in:low,medium,high,urgent',
        ]);

        $ticket->update(['priority' => $validated['priority']]);

        return back()->with('success', 'Priorité du ticket mise à jour.');
    }

    public function reply(Request $request, SupportTicket $ticket)
    {
        $validated = $request->validate([
            'message' => 'required|string',
            'is_internal' => 'nullable|boolean',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|max:5120', // 5MB max
        ]);

        $attachments = null;
        if ($request->hasFile('attachments')) {
            $attachments = [];
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('support/attachments', 'public');
                $attachments[] = [
                    'name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'size' => $file->getSize(),
                ];
            }
        }

        SupportMessage::create([
            'ticket_id' => $ticket->id,
            'user_id' => auth()->id(),
            'message' => $validated['message'],
            'attachments' => $attachments,
            'is_internal' => $request->has('is_internal') && $validated['is_internal'],
        ]);

        // Mettre à jour la date de dernière réponse
        $ticket->updateLastRepliedAt();

        // Si le ticket était résolu, le rouvrir
        if ($ticket->status === 'resolved' && !$request->has('is_internal')) {
            $ticket->update(['status' => 'open']);
        }

        // Si pas encore assigné, s'assigner automatiquement
        if (!$ticket->assigned_to) {
            $ticket->update([
                'assigned_to' => auth()->id(),
                'status' => 'in_progress',
            ]);
        }

        return back()->with('success', 'Message envoyé avec succès.');
    }

    public function destroy(SupportTicket $ticket)
    {
        // Supprimer les messages et leurs pièces jointes
        foreach ($ticket->messages as $message) {
            if ($message->attachments) {
                foreach ($message->attachments as $attachment) {
                    if (isset($attachment['path'])) {
                        Storage::disk('public')->delete($attachment['path']);
                    }
                }
            }
        }

        $ticket->delete();

        return redirect()->route('admin.support.index')
            ->with('success', 'Ticket supprimé avec succès.');
    }
}
