<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Services\PaymentService;
use App\Services\MonerooService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    protected PaymentService $paymentService;
    protected MonerooService $monerooService;

    public function __construct(PaymentService $paymentService, MonerooService $monerooService)
    {
        $this->paymentService = $paymentService;
        $this->monerooService = $monerooService;
    }

    public function return(Request $request, Payment $payment)
    {
        if ($payment->user_id !== auth()->id()) {
            abort(403);
        }

        // Vérifier le statut avec Moneroo
        if ($payment->moneroo_transaction_id) {
            try {
                $monerooPayment = $this->monerooService->verifyPayment($payment->moneroo_transaction_id);
                
                // Mapper les statuts Moneroo vers nos statuts
                $monerooStatus = $monerooPayment->status ?? '';
                $status = match($monerooStatus) {
                    'success', 'completed', 'paid' => 'completed',
                    'failed', 'declined' => 'failed',
                    'cancelled', 'canceled' => 'cancelled',
                    'pending', 'processing' => 'processing',
                    default => $payment->status,
                };

                if ($status !== $payment->status) {
                    $payment->update(['status' => $status]);
                    
                    // Si le paiement est complété, traiter selon le type
                    if ($status === 'completed') {
                        $this->paymentService->handlePaymentCallback([
                            'transaction_id' => $monerooPayment->transaction_id ?? $monerooPayment->id ?? $payment->moneroo_transaction_id,
                            'status' => $monerooStatus,
                        ]);
                        
                        // Rediriger selon le type de paiement
                        if ($payment->paymentable_type === \App\Models\Contest::class) {
                            $contest = \App\Models\Contest::find($payment->paymentable_id);
                            if ($contest) {
                                return redirect()->route('contests.show', $contest)
                                    ->with('success', 'Votre vote a été enregistré avec succès !');
                            }
                        } elseif ($payment->paymentable_type === \App\Models\Fundraising::class) {
                            $fundraising = \App\Models\Fundraising::find($payment->paymentable_id);
                            if ($fundraising) {
                                return redirect()->route('fundraisings.show', $fundraising)
                                    ->with('success', 'Merci pour votre contribution !');
                            }
                        }
                    }
                }
            } catch (\Exception $e) {
                \Log::error('Error verifying payment with Moneroo', [
                    'payment_id' => $payment->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        return view('payments.return', compact('payment'));
    }

    public function callback(Request $request)
    {
        $signature = $request->header('X-Moneroo-Signature');
        $payload = $request->all();

        if (!$this->monerooService->verifyWebhook($signature, $payload)) {
            abort(401, 'Signature invalide');
        }

        $this->paymentService->handlePaymentCallback($payload);

        return response()->json(['success' => true]);
    }

    public function webhook(Request $request)
    {
        return $this->callback($request);
    }
}

