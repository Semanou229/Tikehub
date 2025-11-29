<?php

namespace App\Services;

use App\Models\Ticket;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;

class QrCodeService
{
    public function generateForTicket(Ticket $ticket): string
    {
        $token = $ticket->generateQrToken();
        $qrData = route('tickets.validate', ['token' => $token]);
        
        $qrCode = QrCode::format('png')
            ->size(config('qrcode.size', 300))
            ->margin(config('qrcode.margin', 2))
            ->generate($qrData);

        $filename = 'tickets/qr-' . $ticket->id . '-' . time() . '.png';
        Storage::disk('public')->put($filename, $qrCode);

        $ticket->qr_code = $filename;
        $ticket->save();

        return Storage::url($filename);
    }

    public function validateToken(string $token): ?Ticket
    {
        $parts = explode('.', $token);
        if (count($parts) !== 2) {
            return null;
        }

        $payload = json_decode(base64_decode($parts[0]), true);
        if (!$payload || !isset($payload['ticket_id'])) {
            return null;
        }

        $ticket = Ticket::find($payload['ticket_id']);
        if (!$ticket) {
            return null;
        }

        if (!$ticket->validateQrToken($token)) {
            return null;
        }

        return $ticket;
    }
}


