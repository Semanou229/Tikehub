<?php

namespace App\Services;

use Moneroo\Laravel\Payment;
use Moneroo\Laravel\Payout;
use Illuminate\Support\Facades\Log;

class MonerooService
{
    protected ?Payment $payment = null;
    protected ?Payout $payout = null;

    public function __construct()
    {
        // Initialiser le SDK Moneroo avec les clés de configuration
        // Le SDK utilise automatiquement les variables d'environnement MONEROO_PUBLIC_KEY et MONEROO_SECRET_KEY
        try {
            $this->payment = new Payment();
            $this->payout = new Payout();
        } catch (\Exception $e) {
            Log::error('Failed to initialize Moneroo SDK', ['error' => $e->getMessage()]);
        }
    }

    /**
     * Créer un paiement
     * 
     * @param array $data Données du paiement
     * @return object Objet de réponse Moneroo
     */
    public function createPayment(array $data): object
    {
        try {
            // Préparer les données selon le format Moneroo
            // Note: Selon la doc Moneroo, amount est un integer (montant en unité de base)
            // Pour XOF, c'est en francs, pas en centimes
            $paymentData = [
                'amount' => (int) round($data['amount']), // Montant en XOF (francs)
                'currency' => $data['currency'] ?? 'XOF',
                'description' => $data['description'] ?? '',
                'return_url' => $data['return_url'] ?? route('payments.return', ['payment' => $data['payment_id'] ?? '']),
                'customer' => [
                    'email' => $data['customer']['email'] ?? $data['customer']['name'] ?? '',
                    'first_name' => $this->extractFirstName($data['customer']['name'] ?? ''),
                    'last_name' => $this->extractLastName($data['customer']['name'] ?? ''),
                    'phone' => $this->normalizePhoneNumber($data['customer']['phone'] ?? null),
                ],
            ];

            // Ajouter les champs optionnels du client
            if (isset($data['customer']['address'])) {
                $paymentData['customer']['address'] = $data['customer']['address'];
            }
            if (isset($data['customer']['city'])) {
                $paymentData['customer']['city'] = $data['customer']['city'];
            }
            if (isset($data['customer']['country'])) {
                $paymentData['customer']['country'] = $data['customer']['country'];
            }

            // Ajouter les métadonnées si présentes
            if (isset($data['metadata'])) {
                $paymentData['metadata'] = $data['metadata'];
            } else {
                $paymentData['metadata'] = [
                    'payment_id' => $data['payment_id'] ?? null,
                    'event_id' => $data['event_id'] ?? null,
                ];
            }

            // Ajouter les méthodes de paiement autorisées si spécifiées
            if (isset($data['methods'])) {
                $paymentData['methods'] = $data['methods'];
            }

            // Initialiser le paiement avec la méthode init() du SDK
            $payment = $this->payment->init($paymentData);

            return $payment;
        } catch (\Exception $e) {
            Log::error('Moneroo payment creation failed', [
                'error' => $e->getMessage(),
                'data' => $data,
            ]);

            throw new \Exception('Échec de la création du paiement Moneroo: ' . $e->getMessage());
        }
    }

    /**
     * Vérifier un paiement
     * 
     * @param string $transactionId ID de la transaction
     * @return object Objet de réponse Moneroo
     */
    public function verifyPayment(string $transactionId): object
    {
        try {
            return $this->payment->verify($transactionId);
        } catch (\Exception $e) {
            Log::error('Moneroo payment verification failed', [
                'transaction_id' => $transactionId,
                'error' => $e->getMessage(),
            ]);

            throw new \Exception('Échec de la vérification du paiement Moneroo: ' . $e->getMessage());
        }
    }

    /**
     * Récupérer les détails d'un paiement
     * 
     * @param string $transactionId ID de la transaction
     * @return object Objet de réponse Moneroo
     */
    public function getPayment(string $transactionId): object
    {
        try {
            return $this->payment->get($transactionId);
        } catch (\Exception $e) {
            Log::error('Moneroo get payment failed', [
                'transaction_id' => $transactionId,
                'error' => $e->getMessage(),
            ]);

            throw new \Exception('Échec de la récupération du paiement Moneroo: ' . $e->getMessage());
        }
    }

    /**
     * Marquer un paiement comme traité
     * 
     * @param string $transactionId ID de la transaction
     * @return object Objet de réponse Moneroo
     */
    public function markPaymentAsProcessed(string $transactionId): object
    {
        try {
            return $this->payment->markAsProcessed($transactionId);
        } catch (\Exception $e) {
            Log::error('Moneroo mark payment as processed failed', [
                'transaction_id' => $transactionId,
                'error' => $e->getMessage(),
            ]);

            throw new \Exception('Échec du marquage du paiement comme traité: ' . $e->getMessage());
        }
    }

    /**
     * Créer un payout
     * 
     * @param array $data Données du payout
     * @return object Objet de réponse Moneroo
     */
    public function createPayout(array $data): object
    {
        try {
            $payoutData = [
                'amount' => (int) round($data['amount']), // Montant en XOF (francs)
                'currency' => $data['currency'] ?? 'XOF',
                'description' => $data['description'] ?? '',
                'method' => $data['method'], // Requis: mtn_bj, moov_bj, bank_transfer, etc.
                'return_url' => $data['return_url'] ?? route('organizer.wallet.index'),
                'customer' => [
                    'email' => $data['customer']['email'] ?? '',
                    'first_name' => $this->extractFirstName($data['customer']['name'] ?? ''),
                    'last_name' => $this->extractLastName($data['customer']['name'] ?? ''),
                    'phone' => $data['customer']['phone'] ?? null,
                ],
            ];

            // Ajouter les détails spécifiques à la méthode de payout
            if (isset($data['account_details'])) {
                $payoutData = array_merge($payoutData, $data['account_details']);
            }

            // Ajouter les métadonnées si présentes
            if (isset($data['metadata'])) {
                $payoutData['metadata'] = $data['metadata'];
            }

            // Initialiser le payout
            $payout = $this->payout->init($payoutData);

            return $payout;
        } catch (\Exception $e) {
            Log::error('Moneroo payout creation failed', [
                'error' => $e->getMessage(),
                'data' => $data,
            ]);

            throw new \Exception('Échec de la création du payout Moneroo: ' . $e->getMessage());
        }
    }

    /**
     * Vérifier un payout
     * 
     * @param string $transactionId ID de la transaction
     * @return object Objet de réponse Moneroo
     */
    public function verifyPayout(string $transactionId): object
    {
        try {
            return $this->payout->verify($transactionId);
        } catch (\Exception $e) {
            Log::error('Moneroo payout verification failed', [
                'transaction_id' => $transactionId,
                'error' => $e->getMessage(),
            ]);

            throw new \Exception('Échec de la vérification du payout Moneroo: ' . $e->getMessage());
        }
    }

    /**
     * Récupérer les détails d'un payout
     * 
     * @param string $transactionId ID de la transaction
     * @return object Objet de réponse Moneroo
     */
    public function getPayout(string $transactionId): object
    {
        try {
            return $this->payout->get($transactionId);
        } catch (\Exception $e) {
            Log::error('Moneroo get payout failed', [
                'transaction_id' => $transactionId,
                'error' => $e->getMessage(),
            ]);

            throw new \Exception('Échec de la récupération du payout Moneroo: ' . $e->getMessage());
        }
    }

    /**
     * Vérifier la signature d'un webhook
     * 
     * @param string $signature Signature reçue
     * @param array $payload Données du webhook
     * @return bool
     */
    public function verifyWebhook(string $signature, array $payload): bool
    {
        $webhookSecret = config('moneroo.webhook_secret');
        if (!$webhookSecret) {
            return false;
        }

        $expectedSignature = hash_hmac('sha256', json_encode($payload), $webhookSecret);
        return hash_equals($expectedSignature, $signature);
    }

    /**
     * Extraire le prénom d'un nom complet
     * 
     * @param string $fullName Nom complet
     * @return string
     */
    protected function extractFirstName(string $fullName): string
    {
        $parts = explode(' ', trim($fullName));
        return $parts[0] ?? '';
    }

    /**
     * Extraire le nom de famille d'un nom complet
     * 
     * @param string $fullName Nom complet
     * @return string
     */
    protected function extractLastName(string $fullName): string
    {
        $parts = explode(' ', trim($fullName));
        if (count($parts) > 1) {
            return implode(' ', array_slice($parts, 1));
        }
        return '';
    }

    /**
     * Normaliser un numéro de téléphone pour Moneroo
     * Moneroo attend un entier (sans espaces, sans caractères spéciaux)
     * 
     * @param string|null $phone Numéro de téléphone
     * @return int|null
     */
    protected function normalizePhoneNumber(?string $phone): ?int
    {
        if (empty($phone)) {
            return null;
        }

        // Supprimer tous les caractères non numériques (espaces, +, -, etc.)
        $cleaned = preg_replace('/[^0-9]/', '', $phone);
        
        // Convertir en entier
        $phoneInt = (int) $cleaned;
        
        // Retourner null si le numéro est invalide (trop court ou vide)
        if ($phoneInt <= 0 || strlen($cleaned) < 8) {
            return null;
        }

        return $phoneInt;
    }
}
