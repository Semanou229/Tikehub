<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\PromoCode;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PromoCodeController extends Controller
{
    public function __construct()
    {
        $this->middleware('organizer');
    }

    public function index()
    {
        $user = auth()->user();
        $promoCodes = PromoCode::where('organizer_id', $user->id)
            ->with('event')
            ->withCount('usages')
            ->latest()
            ->paginate(15);

        return view('dashboard.organizer.promo-codes.index', compact('promoCodes'));
    }

    public function create()
    {
        $user = auth()->user();
        $events = Event::where('organizer_id', $user->id)
            ->where('is_published', true)
            ->orderBy('start_date', 'desc')
            ->get();

        return view('dashboard.organizer.promo-codes.create', compact('events'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:promo_codes,code',
            'name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'event_id' => 'nullable|exists:events,id',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0.01',
            'minimum_amount' => 'nullable|numeric|min:0',
            'maximum_discount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'usage_limit_per_user' => 'nullable|integer|min:1',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
            'is_active' => 'boolean',
        ]);

        // Vérifier que l'événement appartient à l'organisateur
        if ($validated['event_id']) {
            $event = Event::where('id', $validated['event_id'])
                ->where('organizer_id', $user->id)
                ->firstOrFail();
        }

        // Validation supplémentaire pour les pourcentages
        if ($validated['discount_type'] === 'percentage' && $validated['discount_value'] > 100) {
            return back()->withErrors(['discount_value' => 'Le pourcentage ne peut pas dépasser 100%.'])->withInput();
        }

        $validated['organizer_id'] = $user->id;
        $validated['code'] = strtoupper($validated['code']);
        $validated['is_active'] = $request->has('is_active');

        PromoCode::create($validated);

        return redirect()->route('organizer.promo-codes.index')
            ->with('success', 'Code promo créé avec succès.');
    }

    public function show(PromoCode $promoCode)
    {
        $this->authorize('view', $promoCode);

        $promoCode->load(['event', 'usages.user', 'usages.payment']);

        return view('dashboard.organizer.promo-codes.show', compact('promoCode'));
    }

    public function edit(PromoCode $promoCode)
    {
        $this->authorize('update', $promoCode);

        $user = auth()->user();
        $events = Event::where('organizer_id', $user->id)
            ->where('is_published', true)
            ->orderBy('start_date', 'desc')
            ->get();

        return view('dashboard.organizer.promo-codes.edit', compact('promoCode', 'events'));
    }

    public function update(Request $request, PromoCode $promoCode)
    {
        $this->authorize('update', $promoCode);

        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:promo_codes,code,' . $promoCode->id,
            'name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'event_id' => 'nullable|exists:events,id',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0.01',
            'minimum_amount' => 'nullable|numeric|min:0',
            'maximum_discount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'usage_limit_per_user' => 'nullable|integer|min:1',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
            'is_active' => 'boolean',
        ]);

        // Vérifier que l'événement appartient à l'organisateur
        if ($validated['event_id']) {
            $event = Event::where('id', $validated['event_id'])
                ->where('organizer_id', auth()->user()->id)
                ->firstOrFail();
        }

        // Validation supplémentaire pour les pourcentages
        if ($validated['discount_type'] === 'percentage' && $validated['discount_value'] > 100) {
            return back()->withErrors(['discount_value' => 'Le pourcentage ne peut pas dépasser 100%.'])->withInput();
        }

        $validated['code'] = strtoupper($validated['code']);
        $validated['is_active'] = $request->has('is_active');

        $promoCode->update($validated);

        return redirect()->route('organizer.promo-codes.index')
            ->with('success', 'Code promo mis à jour avec succès.');
    }

    public function destroy(PromoCode $promoCode)
    {
        $this->authorize('delete', $promoCode);

        $promoCode->delete();

        return redirect()->route('organizer.promo-codes.index')
            ->with('success', 'Code promo supprimé avec succès.');
    }
}
