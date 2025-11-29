<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MonerooService
{
    protected ?string $apiKey;
    protected ?string $apiSecret;
    protected ?string $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('moneroo.api_key') ?? '';
        $this->apiSecret = config('moneroo.api_secret') ?? '';
        $this->baseUrl = config('moneroo.base_url') ?? '';
    }

    public function createPayment(array $data): array
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type' => 'application/json',
        ])->post($this->baseUrl . '/payments', [
            'amount' => $data['amount'],
            'currency' => $data['currency'] ?? 'XOF',
            'reference' => $data['reference'],
            'description' => $data['description'] ?? '',
            'customer' => $data['customer'] ?? [],
            'callback_url' => $data['callback_url'] ?? route('payments.callback'),
            'return_url' => $data['return_url'] ?? route('payments.return'),
        ]);

        if ($response->successful()) {
            return $response->json();
        }

        Log::error('Moneroo payment creation failed', [
            'status' => $response->status(),
            'body' => $response->body(),
        ]);

        throw new \Exception('Échec de la création du paiement Moneroo');
    }

    public function verifyWebhook(string $signature, array $payload): bool
    {
        $expectedSignature = hash_hmac('sha256', json_encode($payload), $this->apiSecret);
        return hash_equals($expectedSignature, $signature);
    }

    public function getPaymentStatus(string $transactionId): array
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])->get($this->baseUrl . '/payments/' . $transactionId);

        if ($response->successful()) {
            return $response->json();
        }

        return [];
    }

    public function refundPayment(string $transactionId, float $amount): array
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type' => 'application/json',
        ])->post($this->baseUrl . '/payments/' . $transactionId . '/refund', [
            'amount' => $amount,
        ]);

        if ($response->successful()) {
            return $response->json();
        }

        Log::error('Moneroo refund failed', [
            'status' => $response->status(),
            'body' => $response->body(),
        ]);

        throw new \Exception('Échec du remboursement Moneroo');
    }
}

