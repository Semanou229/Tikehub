<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function webhook(Request $request)
    {
        // Gérer les webhooks de Moneroo
        // TODO: Implémenter la logique de webhook
        return response()->json(['status' => 'ok']);
    }
}
