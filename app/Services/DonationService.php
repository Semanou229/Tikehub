<?php

namespace App\Services;

use App\Models\Fundraising;
use App\Models\Donation;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DonationService
{
    protected MonerooService $moneroo;
    protected PaymentService $paymentService;

    public function __construct(MonerooService $moneroo, PaymentService $paymentService)
    {
        $this->moneroo = $moneroo;
        $this->paymentService = $paymentService;
    }

    public function createDonation(User $user, Fundraising $fundraising, float $amount, ?string $message = null, bool $isAnonymous = false): Payment
    {
        if (!$fundraising->isActive()) {
            throw new \Exception('Cette collecte est terminée');
        }

        return DB::transaction(function () use ($user, $fundraising, $amount, $message, $isAnonymous) {
            $commissionRate = config('platform.commission_rate', 5);
            $platformCommission = ($amount * $commissionRate) / 100;
            $organizerAmount = $amount - $platformCommission;

            $payment = Payment::create([
                'user_id' => $user->id,
                'event_id' => $fundraising->event_id,
                'paymentable_type' => Fundraising::class,
                'paymentable_id' => $fundraising->id,
                'amount' => $amount,
                'currency' => 'XOF',
                'status' => 'pending',
                'platform_commission' => $platformCommission,
                'organizer_amount' => $organizerAmount,
            ]);

            // Créer le paiement Moneroo
            $monerooPayment = $this->moneroo->createPayment([
                'amount' => $amount,
                'currency' => 'XOF',
                'description' => "Don de " . number_format($amount, 0, ',', ' ') . " XOF pour {$fundraising->name}",
                'payment_id' => $payment->id,
                'customer' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                ],
                'return_url' => route('fundraisings.donate.return', ['payment' => $payment->id]),
            ]);

            // Le SDK Moneroo retourne un objet (data de la réponse)
            $transactionId = $monerooPayment->transaction_id ?? $monerooPayment->id ?? null;
            $checkoutUrl = $monerooPayment->checkout_url ?? $monerooPayment->checkoutUrl ?? null;
            
            $payment->update([
                'moneroo_transaction_id' => $transactionId,
                'moneroo_reference' => $monerooPayment->reference ?? $transactionId,
            ]);

            // Stocker l'URL de checkout dans la session pour redirection
            if ($checkoutUrl) {
                session(['moneroo_checkout_url_' . $payment->id => $checkoutUrl]);
            }

            // Créer le don (en attente de paiement)
            Donation::create([
                'fundraising_id' => $fundraising->id,
                'user_id' => $user->id,
                'payment_id' => $payment->id,
                'amount' => $amount,
                'is_anonymous' => $isAnonymous,
                'message' => $message,
            ]);

            return $payment;
        });
    }

    public function confirmDonation(Payment $payment): void
    {
        if ($payment->status !== 'completed') {
            return;
        }

        $donation = $payment->donation;
        if ($donation) {
            // Mettre à jour le montant collecté
            $fundraising = $donation->fundraising;
            $fundraising->increment('current_amount', $donation->amount);
        }
    }
}


