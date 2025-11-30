<?php

namespace App\Services;

use App\Models\Contest;
use App\Models\ContestCandidate;
use App\Models\Vote;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class VoteService
{
    protected MonerooService $moneroo;
    protected PaymentService $paymentService;

    public function __construct(MonerooService $moneroo, PaymentService $paymentService)
    {
        $this->moneroo = $moneroo;
        $this->paymentService = $paymentService;
    }

    public function castVote(User $user, ContestCandidate $candidate, int $quantity, ?string $ipAddress = null): Payment
    {
        $contest = $candidate->contest;

        if (!$contest->isActive()) {
            throw new \Exception('Ce concours n\'est plus actif');
        }

        // Vérification anti-fraude
        $this->validateVoteLimits($user, $contest, $ipAddress);

        return DB::transaction(function () use ($user, $candidate, $contest, $quantity, $ipAddress) {
            $totalAmount = $contest->price_per_vote * $quantity;
            $totalPoints = $contest->points_per_vote * $quantity;

            $commissionRate = get_commission_rate();
            $platformCommission = ($totalAmount * $commissionRate) / 100;
            $organizerAmount = $totalAmount - $platformCommission;

            $payment = Payment::create([
                'user_id' => $user->id,
                'event_id' => $contest->event_id,
                'paymentable_type' => Contest::class,
                'paymentable_id' => $contest->id,
                'amount' => $totalAmount,
                'currency' => 'XOF',
                'status' => 'pending',
                'platform_commission' => $platformCommission,
                'organizer_amount' => $organizerAmount,
            ]);

            // Créer le paiement Moneroo
            $monerooPayment = $this->moneroo->createPayment([
                'amount' => $totalAmount,
                'currency' => 'XOF',
                'description' => "{$quantity} vote(s) pour {$candidate->name} dans le concours {$contest->name}",
                'payment_id' => $payment->id,
                'customer' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                ],
                'return_url' => route('payments.return', ['payment' => $payment->id]),
                'metadata' => [
                    'payment_id' => (string) $payment->id,
                    'contest_id' => (string) $contest->id,
                    'candidate_id' => (string) $candidate->id,
                    'type' => 'vote',
                ],
            ]);

            // Log pour déboguer la structure de la réponse
            \Log::info('Moneroo payment response for vote', [
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
                \Log::info('Checkout URL stored for vote payment', ['payment_id' => $payment->id, 'checkout_url' => $checkoutUrl]);
            } else {
                \Log::warning('No checkout URL found in Moneroo response for vote', [
                    'payment_id' => $payment->id,
                    'response' => is_object($monerooPayment) ? (array) $monerooPayment : $monerooPayment,
                ]);
            }

            // Créer les votes (en attente de paiement)
            for ($i = 0; $i < $quantity; $i++) {
                Vote::create([
                    'contest_id' => $contest->id,
                    'candidate_id' => $candidate->id,
                    'user_id' => $user->id,
                    'payment_id' => $payment->id,
                    'points' => $contest->points_per_vote,
                    'ip_address' => $ipAddress,
                    'user_agent' => request()->userAgent(),
                ]);
            }

            return $payment;
        });
    }

    public function confirmVotes(Payment $payment): void
    {
        if ($payment->status !== 'completed') {
            return;
        }

        // Les votes sont déjà créés lors de la création du paiement
        // Ici on peut ajouter d'autres actions si nécessaire (notifications, etc.)
        $votes = $payment->votes;
        
        // Mettre à jour les points du candidat si nécessaire
        foreach ($votes as $vote) {
            // Les votes sont déjà comptabilisés dans le classement
            // On peut ajouter des notifications ou autres actions ici
        }
    }

    protected function validateVoteLimits(User $user, Contest $contest, ?string $ipAddress): void
    {
        $maxPerUser = config('platform.max_votes_per_user', 100);
        $maxPerIp = config('platform.max_votes_per_ip', 1000);
        $cooldown = config('platform.vote_cooldown_minutes', 1);

        // Limite par utilisateur
        $userVotesCount = Vote::where('contest_id', $contest->id)
            ->where('user_id', $user->id)
            ->whereHas('payment', function ($q) {
                $q->where('status', 'completed');
            })
            ->count();

        if ($userVotesCount >= $maxPerUser) {
            throw new \Exception("Limite de votes atteinte pour cet utilisateur ({$maxPerUser})");
        }

        // Limite par IP
        if ($ipAddress) {
            $ipVotesCount = Vote::where('contest_id', $contest->id)
                ->where('ip_address', $ipAddress)
                ->whereHas('payment', function ($q) {
                    $q->where('status', 'completed');
                })
                ->where('created_at', '>', now()->subMinutes($cooldown))
                ->count();

            if ($ipVotesCount >= $maxPerIp) {
                throw new \Exception("Trop de votes depuis cette adresse IP. Veuillez réessayer plus tard.");
            }
        }

        // Cooldown
        $lastVote = Vote::where('contest_id', $contest->id)
            ->where('user_id', $user->id)
            ->latest()
            ->first();

        if ($lastVote && $lastVote->created_at->addMinutes($cooldown)->isFuture()) {
            throw new \Exception("Veuillez attendre {$cooldown} minute(s) avant de voter à nouveau");
        }
    }
}


