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
                'reference' => 'DON-' . $payment->id,
                'description' => "Don pour {$fundraising->name}",
                'customer' => [
                    'name' => $user->name,
                    'email' => $user->email,
                ],
                'return_url' => route('fundraisings.donate.return', ['payment' => $payment->id]),
            ]);

            $payment->update([
                'moneroo_transaction_id' => $monerooPayment['transaction_id'] ?? null,
                'moneroo_reference' => $monerooPayment['reference'] ?? null,
            ]);

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

