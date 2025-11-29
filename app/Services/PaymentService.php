<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Event;
use Illuminate\Support\Facades\DB;

class PaymentService
{
    protected MonerooService $moneroo;

    public function __construct(MonerooService $moneroo)
    {
        $this->moneroo = $moneroo;
    }

    public function processTicketPurchase(User $user, array $ticketData): Payment
    {
        return DB::transaction(function () use ($user, $ticketData) {
            $event = Event::findOrFail($ticketData['event_id']);
            $ticketType = $event->ticketTypes()->findOrFail($ticketData['ticket_type_id']);

            if (!$ticketType->isOnSale()) {
                throw new \Exception('Ce type de billet n\'est plus en vente');
            }

            $originalAmount = $ticketType->price * $ticketData['quantity'];
            $discountAmount = 0;
            $promoCodeId = null;

            // Appliquer le code promo si fourni
            if (!empty($ticketData['promo_code_id']) && !empty($ticketData['discount_amount'])) {
                $promoCode = \App\Models\PromoCode::find($ticketData['promo_code_id']);
                if ($promoCode && $promoCode->isValid() && $promoCode->meetsMinimumAmount($originalAmount)) {
                    $discountAmount = (float) $ticketData['discount_amount'];
                    $promoCodeId = $promoCode->id;
                }
            }

            $totalAmount = max(0, $originalAmount - $discountAmount);
            $commissionRate = config('platform.commission_rate', 5);
            $platformCommission = ($totalAmount * $commissionRate) / 100;
            $organizerAmount = $totalAmount - $platformCommission;

            $payment = Payment::create([
                'user_id' => $user->id,
                'event_id' => $event->id,
                'promo_code_id' => $promoCodeId,
                'amount' => $totalAmount,
                'discount_amount' => $discountAmount,
                'original_amount' => $originalAmount,
                'currency' => 'XOF',
                'status' => 'pending',
                'platform_commission' => $platformCommission,
                'organizer_amount' => $organizerAmount,
            ]);

            // Enregistrer l'utilisation du code promo
            if ($promoCodeId && $discountAmount > 0) {
                \App\Models\PromoCodeUsage::create([
                    'promo_code_id' => $promoCodeId,
                    'user_id' => $user->id,
                    'discount_amount' => $discountAmount,
                    'original_amount' => $originalAmount,
                    'final_amount' => $totalAmount,
                ]);

                // Incrémenter le compteur d'utilisation
                \App\Models\PromoCode::where('id', $promoCodeId)->increment('used_count');
            }

            // Créer les billets
            for ($i = 0; $i < $ticketData['quantity']; $i++) {
                Ticket::create([
                    'event_id' => $event->id,
                    'ticket_type_id' => $ticketType->id,
                    'buyer_id' => $user->id,
                    'price' => $ticketType->price,
                    'status' => 'pending',
                    'payment_id' => $payment->id,
                    'buyer_name' => $ticketData['buyer_name'] ?? $user->name,
                    'buyer_email' => $ticketData['buyer_email'] ?? $user->email,
                    'buyer_phone' => $ticketData['buyer_phone'] ?? $user->phone,
                ]);
            }

            // Mettre à jour les quantités
            $ticketType->increment('sold_quantity', $ticketData['quantity']);

            // Créer le paiement Moneroo
            $monerooPayment = $this->moneroo->createPayment([
                'amount' => $totalAmount,
                'currency' => 'XOF',
                'description' => "Achat de {$ticketData['quantity']} billet(s) pour {$event->title}" . ($discountAmount > 0 ? " (Réduction: -" . number_format($discountAmount, 0, ',', ' ') . " XOF)" : ''),
                'payment_id' => $payment->id,
                'event_id' => $event->id,
                'customer' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                ],
                'return_url' => route('payments.return', ['payment' => $payment->id]),
            ]);

            // Le SDK Moneroo retourne un objet (data de la réponse)
            // La réponse peut contenir: id, transaction_id, checkout_url, status, etc.
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

            return $payment;
        });
    }

    public function processMultipleTicketsPurchase(User $user, array $ticketData): Payment
    {
        return DB::transaction(function () use ($user, $ticketData) {
            $event = Event::findOrFail($ticketData['event_id']);
            $totalAmount = 0;
            $ticketsToCreate = [];

            // Calculer le total et préparer les tickets
            foreach ($ticketData['tickets'] as $ticketTypeId => $quantity) {
                if ($quantity <= 0) continue;
                
                $ticketType = $event->ticketTypes()->findOrFail($ticketTypeId);
                
                if (!$ticketType->isOnSale()) {
                    throw new \Exception("Le type de billet '{$ticketType->name}' n'est plus en vente");
                }

                if ($ticketType->available_quantity < $quantity) {
                    throw new \Exception("Il ne reste que {$ticketType->available_quantity} billet(s) disponible(s) pour '{$ticketType->name}'");
                }

                $typeTotal = $ticketType->price * $quantity;
                $totalAmount += $typeTotal;

                // Préparer les tickets à créer
                for ($i = 0; $i < $quantity; $i++) {
                    $ticketsToCreate[] = [
                        'event_id' => $event->id,
                        'ticket_type_id' => $ticketType->id,
                        'buyer_id' => $user->id,
                        'price' => $ticketType->price,
                        'status' => 'pending',
                        'buyer_name' => $ticketData['buyer_name'] ?? $user->name,
                        'buyer_email' => $ticketData['buyer_email'] ?? $user->email,
                        'buyer_phone' => $ticketData['buyer_phone'] ?? $user->phone,
                    ];
                }
            }

            if (empty($ticketsToCreate)) {
                throw new \Exception('Aucun billet sélectionné');
            }

            $originalAmount = $totalAmount;
            $discountAmount = 0;
            $promoCodeId = null;

            // Appliquer le code promo si fourni
            if (!empty($ticketData['promo_code_id']) && !empty($ticketData['discount_amount'])) {
                $promoCode = \App\Models\PromoCode::find($ticketData['promo_code_id']);
                if ($promoCode && $promoCode->isValid() && $promoCode->meetsMinimumAmount($originalAmount)) {
                    $discountAmount = (float) $ticketData['discount_amount'];
                    $promoCodeId = $promoCode->id;
                }
            }

            $totalAmount = max(0, $originalAmount - $discountAmount);
            $commissionRate = config('platform.commission_rate', 5);
            $platformCommission = ($totalAmount * $commissionRate) / 100;
            $organizerAmount = $totalAmount - $platformCommission;

            $payment = Payment::create([
                'user_id' => $user->id,
                'event_id' => $event->id,
                'promo_code_id' => $promoCodeId,
                'amount' => $totalAmount,
                'discount_amount' => $discountAmount,
                'original_amount' => $originalAmount,
                'currency' => 'XOF',
                'status' => 'pending',
                'platform_commission' => $platformCommission,
                'organizer_amount' => $organizerAmount,
            ]);

            // Enregistrer l'utilisation du code promo
            if ($promoCodeId && $discountAmount > 0) {
                \App\Models\PromoCodeUsage::create([
                    'promo_code_id' => $promoCodeId,
                    'user_id' => $user->id,
                    'discount_amount' => $discountAmount,
                    'original_amount' => $originalAmount,
                    'final_amount' => $totalAmount,
                ]);

                // Incrémenter le compteur d'utilisation
                \App\Models\PromoCode::where('id', $promoCodeId)->increment('used_count');
            }

            // Créer tous les tickets
            foreach ($ticketsToCreate as $ticketInfo) {
                $ticketInfo['payment_id'] = $payment->id;
                Ticket::create($ticketInfo);
            }

            // Mettre à jour les quantités vendues
            foreach ($ticketData['tickets'] as $ticketTypeId => $quantity) {
                if ($quantity > 0) {
                    $ticketType = $event->ticketTypes()->find($ticketTypeId);
                    if ($ticketType) {
                        $ticketType->increment('sold_quantity', $quantity);
                    }
                }
            }

            // Créer le paiement Moneroo
            $description = "Achat de " . count($ticketsToCreate) . " billet(s) pour {$event->title}";
            if ($discountAmount > 0) {
                $description .= " (Réduction: -" . number_format($discountAmount, 0, ',', ' ') . " XOF)";
            }
            
            $monerooPayment = $this->moneroo->createPayment([
                'amount' => $totalAmount,
                'currency' => 'XOF',
                'description' => $description,
                'payment_id' => $payment->id,
                'event_id' => $event->id,
                'customer' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                ],
                'return_url' => route('payments.return', ['payment' => $payment->id]),
            ]);

            // Le SDK Moneroo retourne un objet (data de la réponse)
            // La réponse peut contenir: id, transaction_id, checkout_url, status, etc.
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

            return $payment;
        });
    }

    /**
     * Récupérer les détails d'un paiement Moneroo
     * 
     * @param string $transactionId
     * @return object
     */
    public function getMonerooPayment(string $transactionId): object
    {
        return $this->moneroo->getPayment($transactionId);
    }

    public function handlePaymentCallback(array $data): void
    {
        // Le webhook Moneroo peut envoyer transaction_id ou reference
        $transactionId = $data['transaction_id'] ?? $data['id'] ?? null;
        $reference = $data['reference'] ?? null;

        $payment = null;
        if ($transactionId) {
            $payment = Payment::where('moneroo_transaction_id', $transactionId)->first();
        }
        if (!$payment && $reference) {
            $payment = Payment::where('moneroo_reference', $reference)->first();
        }

        if (!$payment) {
            \Log::warning('Payment not found for Moneroo callback', $data);
            return;
        }

        // Mapper les statuts Moneroo vers nos statuts
        $status = match($data['status'] ?? '') {
            'success', 'completed', 'paid' => 'completed',
            'failed', 'declined' => 'failed',
            'cancelled', 'canceled' => 'cancelled',
            'pending', 'processing' => 'processing',
            default => 'processing',
        };

        $payment->update(['status' => $status]);

        if ($status === 'completed') {
            $payment->tickets()->update(['status' => 'paid']);
            
            // Générer les QR codes et tokens d'accès virtuel
            foreach ($payment->tickets as $ticket) {
                app(\App\Services\QrCodeService::class)->generateForTicket($ticket);
                
                // Si l'événement est virtuel, générer le token d'accès
                if ($payment->event && $payment->event->is_virtual) {
                    $ticket->generateVirtualAccessToken();
                }
            }
        }
    }

    public function refundPayment(Payment $payment, ?float $amount = null): Payment
    {
        if (!$payment->canBeRefunded()) {
            throw new \Exception('Ce paiement ne peut pas être remboursé');
        }

        $refundAmount = $amount ?? $payment->amount;

        $this->moneroo->refundPayment(
            $payment->moneroo_transaction_id,
            $refundAmount
        );

        $payment->update([
            'refunded_at' => now(),
            'refund_amount' => $refundAmount,
        ]);

        if ($refundAmount >= $payment->amount) {
            $payment->tickets()->update(['status' => 'refunded']);
        }

        return $payment;
    }
}

