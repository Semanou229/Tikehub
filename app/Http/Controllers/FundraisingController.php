<?php

namespace App\Http\Controllers;

use App\Models\Fundraising;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FundraisingController extends Controller
{
    public function index(Request $request)
    {
        $query = Fundraising::where('is_published', true)
            ->where('is_active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now());

        $fundraisings = $query->orderBy('current_amount', 'desc')
            ->paginate(12);

        return view('fundraisings.index', compact('fundraisings'));
    }

    public function show(Fundraising $fundraising)
    {
        if (!$fundraising->is_published && $fundraising->organizer_id !== auth()->id()) {
            abort(404);
        }

        $fundraising->load(['donations.user', 'organizer']);

        return view('fundraisings.show', compact('fundraising'));
    }

    public function create()
    {
        $this->authorize('create', Fundraising::class);
        return view('fundraisings.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Fundraising::class);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'goal_amount' => 'required|numeric|min:0',
            'start_date' => 'required|date|after:now',
            'end_date' => 'required|date|after:start_date',
            'show_donors' => 'boolean',
            'cover_image' => 'nullable|image|max:2048',
            'event_id' => 'nullable|exists:events,id',
        ]);

        $validated['organizer_id'] = auth()->id();
        $validated['slug'] = Str::slug($validated['name']);
        $validated['current_amount'] = 0;
        $validated['is_published'] = false;
        $validated['is_active'] = true;
        $validated['show_donors'] = $request->has('show_donors');

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('fundraisings', 'public');
        }

        $fundraising = Fundraising::create($validated);

        return redirect()->route('fundraisings.show', $fundraising)
            ->with('success', 'Collecte de fonds créée avec succès. Vous pouvez maintenant la publier et ajouter des paliers.');
    }

    public function edit(Fundraising $fundraising)
    {
        $this->authorize('update', $fundraising);
        
        $events = \App\Models\Event::where('organizer_id', auth()->id())->get();
        
        return view('fundraisings.edit', compact('fundraising', 'events'));
    }

    public function update(Request $request, Fundraising $fundraising)
    {
        $this->authorize('update', $fundraising);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'goal_amount' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'show_donors' => 'boolean',
            'cover_image' => 'nullable|image|max:2048',
            'event_id' => 'nullable|exists:events,id',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['show_donors'] = $request->has('show_donors');

        if ($request->hasFile('cover_image')) {
            if ($fundraising->cover_image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($fundraising->cover_image);
            }
            $validated['cover_image'] = $request->file('cover_image')->store('fundraisings', 'public');
        }

        $fundraising->update($validated);

        return redirect()->route('organizer.fundraisings.index')
            ->with('success', 'Collecte de fonds mise à jour avec succès.');
    }

    public function publish(Fundraising $fundraising)
    {
        $this->authorize('update', $fundraising);

        $fundraising->update(['is_published' => true]);

        return back()->with('success', 'Collecte de fonds publiée');
    }

    public function donate(Request $request, Fundraising $fundraising)
    {
        if (!$fundraising->isActive()) {
            return back()->with('error', 'Cette collecte est terminée');
        }

        $request->validate([
            'amount' => 'required|numeric|min:100',
            'message' => 'nullable|string|max:500',
            'is_anonymous' => 'boolean',
        ]);

        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour contribuer');
        }

        try {
            $donationService = app(\App\Services\DonationService::class);
            $payment = $donationService->createDonation(
                auth()->user(),
                $fundraising,
                $request->amount,
                $request->message,
                $request->has('is_anonymous')
            );

            // Récupérer l'URL de paiement depuis la réponse Moneroo
            $monerooService = app(\App\Services\MonerooService::class);
            $monerooPayment = $monerooService->getPaymentStatus($payment->moneroo_transaction_id);
            
            if (isset($monerooPayment['payment_url'])) {
                return redirect($monerooPayment['payment_url']);
            }

            return redirect()->route('fundraisings.show', $fundraising)->with('error', 'Erreur lors de la création du paiement');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}

