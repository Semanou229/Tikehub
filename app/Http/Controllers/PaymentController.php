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
            $status = $this->monerooService->getPaymentStatus($payment->moneroo_transaction_id);
            if (isset($status['status'])) {
                $payment->update(['status' => $status['status']]);
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

