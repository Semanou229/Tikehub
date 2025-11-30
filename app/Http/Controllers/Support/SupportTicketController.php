<?php

namespace App\Http\Controllers\Support;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use App\Models\SupportMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SupportTicketController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = SupportTicket::where('user_id', auth()->id())
            ->with(['messages' => function($q) {
                $q->latest()->limit(1);
            }]);

        // Filtres
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        $tickets = $query->latest()->paginate(15);

        return view('support.tickets.index', compact('tickets'));
    }

    public function create()
    {
        return view('support.tickets.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high,urgent',
        ]);

        $user = auth()->user();
        $type = $user->isOrganizer() ? 'organizer' : 'client';

        $ticket = SupportTicket::create([
            'user_id' => auth()->id(),
            'type' => $type,
            'subject' => $validated['subject'],
            'description' => $validated['description'],
            'priority' => $validated['priority'],
            'status' => 'open',
        ]);

        // Créer le premier message avec la description
        SupportMessage::create([
            'ticket_id' => $ticket->id,
            'user_id' => auth()->id(),
            'message' => $validated['description'],
            'attachments' => null,
        ]);

        return redirect()->route('support.tickets.show', $ticket)
            ->with('success', 'Ticket créé avec succès. Notre équipe vous répondra bientôt.');
    }

    public function show(SupportTicket $ticket)
    {
        // Vérifier que l'utilisateur est propriétaire du ticket
        if ($ticket->user_id !== auth()->id()) {
            abort(403, 'Accès non autorisé');
        }

        $ticket->load(['messages.user', 'assignedTo']);

        // Marquer les messages non lus comme lus
        $ticket->messages()
            ->where('user_id', '!=', auth()->id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return view('support.tickets.show', compact('ticket'));
    }

    public function reply(Request $request, SupportTicket $ticket)
    {
        // Vérifier que l'utilisateur est propriétaire du ticket
        if ($ticket->user_id !== auth()->id()) {
            abort(403, 'Accès non autorisé');
        }

        // Ne pas permettre de répondre à un ticket fermé
        if ($ticket->isClosed()) {
            return back()->with('error', 'Ce ticket est fermé. Vous ne pouvez plus y répondre.');
        }

        $validated = $request->validate([
            'message' => 'required|string',
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
        ]);

        // Mettre à jour la date de dernière réponse et le statut
        $ticket->updateLastRepliedAt();
        if ($ticket->status === 'resolved') {
            $ticket->update(['status' => 'open']);
        }

        return back()->with('success', 'Votre message a été envoyé.');
    }

    public function close(SupportTicket $ticket)
    {
        // Vérifier que l'utilisateur est propriétaire du ticket
        if ($ticket->user_id !== auth()->id()) {
            abort(403, 'Accès non autorisé');
        }

        $ticket->markAsClosed();

        return back()->with('success', 'Ticket fermé avec succès.');
    }
}
