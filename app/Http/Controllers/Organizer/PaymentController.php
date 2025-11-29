<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $organizerId = auth()->id();

        $payments = Payment::where(function ($q) use ($organizerId) {
            $q->whereHas('event', function ($query) use ($organizerId) {
                $query->where('organizer_id', $organizerId);
            })->orWhereHas('paymentable', function ($query) use ($organizerId) {
                $query->where('organizer_id', $organizerId);
            });
        })
        ->with(['event', 'paymentable'])
        ->latest()
        ->paginate(20);

        $stats = [
            'total' => $payments->total(),
            'completed' => Payment::where(function ($q) use ($organizerId) {
                $q->whereHas('event', function ($query) use ($organizerId) {
                    $query->where('organizer_id', $organizerId);
                })->orWhereHas('paymentable', function ($query) use ($organizerId) {
                    $query->where('organizer_id', $organizerId);
                });
            })->where('status', 'completed')->sum('organizer_amount'),
            'pending' => Payment::where(function ($q) use ($organizerId) {
                $q->whereHas('event', function ($query) use ($organizerId) {
                    $query->where('organizer_id', $organizerId);
                })->orWhereHas('paymentable', function ($query) use ($organizerId) {
                    $query->where('organizer_id', $organizerId);
                });
            })->where('status', 'pending')->count(),
        ];

        return view('dashboard.organizer.payments.index', compact('payments', 'stats'));
    }

    public function show(Payment $payment)
    {
        $organizerId = auth()->id();

        // Vérifier que le paiement appartient à l'organisateur
        $belongsToOrganizer = false;
        if ($payment->event && $payment->event->organizer_id === $organizerId) {
            $belongsToOrganizer = true;
        } elseif ($payment->paymentable && $payment->paymentable->organizer_id === $organizerId) {
            $belongsToOrganizer = true;
        }

        if (!$belongsToOrganizer) {
            abort(403);
        }

        return view('dashboard.organizer.payments.show', compact('payment'));
    }
}

