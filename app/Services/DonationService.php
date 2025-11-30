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
            $commissionRate = get_commission_rate();
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
                'return_url' => route('payments.return', ['payment' => $payment->id]),
                'metadata' => [
                    'payment_id' => (string) $payment->id,
                    'fundraising_id' => (string) $fundraising->id,
                    'type' => 'donation',
                ],
            ]);

            // Log pour déboguer la structure de la réponse
            \Log::info('Moneroo payment response for donation', [
                'payment_id' => $payment->id,
                'response_type' => gettype($monerooPayment),
                'response' => is_object($monerooPayment) ? (array) $monerooPayment : $monerooPayment,
            ]);

            // Le SDK Moneroo retourne $payload->data ?? $payload
            // Donc la réponse peut être directement dans l'objet ou dans ->data
            $transactionId = null;
            $checkoutUrl = null;
            
            if (is_object($monerooPayment)) {
                // Essayer d'abord directement sur l'objet
                $transactionId = $monerooPayment->transaction_id ?? $monerooPayment->id ?? null;
                $checkoutUrl = $monerooPayment->checkout_url ?? $monerooPayment->checkoutUrl ?? $monerooPayment->url ?? null;
                
                // Si pas trouvé, essayer dans ->data
                if (!$transactionId && isset($monerooPayment->data)) {
                    $data = is_object($monerooPayment->data) ? $monerooPayment->data : (object) $monerooPayment->data;
                    $transactionId = $data->transaction_id ?? $data->id ?? $transactionId;
                    $checkoutUrl = $data->checkout_url ?? $data->checkoutUrl ?? $data->url ?? $checkoutUrl;
                }
            } elseif (is_array($monerooPayment)) {
                $transactionId = $monerooPayment['transaction_id'] ?? $monerooPayment['id'] ?? null;
                $checkoutUrl = $monerooPayment['checkout_url'] ?? $monerooPayment['checkoutUrl'] ?? $monerooPayment['url'] ?? null;
                
                if (!$transactionId && isset($monerooPayment['data'])) {
                    $data = $monerooPayment['data'];
                    $transactionId = $data['transaction_id'] ?? $data['id'] ?? $transactionId;
                    $checkoutUrl = $data['checkout_url'] ?? $data['checkoutUrl'] ?? $data['url'] ?? $checkoutUrl;
                }
            }
            
            $payment->update([
                'moneroo_transaction_id' => $transactionId,
                'moneroo_reference' => (is_object($monerooPayment) ? ($monerooPayment->reference ?? null) : ($monerooPayment['reference'] ?? null)) ?? $transactionId,
            ]);

            // Stocker l'URL de checkout dans la session pour redirection
            if ($checkoutUrl) {
                session(['moneroo_checkout_url_' . $payment->id => $checkoutUrl]);
                \Log::info('Checkout URL stored for donation payment', ['payment_id' => $payment->id, 'checkout_url' => $checkoutUrl]);
            } else {
                \Log::warning('No checkout URL found in Moneroo response for donation', [
                    'payment_id' => $payment->id,
                    'response' => is_object($monerooPayment) ? (array) $monerooPayment : $monerooPayment,
                ]);
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


