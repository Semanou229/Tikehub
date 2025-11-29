<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Billet - {{ $ticket->code }}</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .ticket { border: 2px solid #000; padding: 20px; max-width: 600px; margin: 0 auto; }
        .header { text-align: center; margin-bottom: 20px; }
        .qr-code { text-align: center; margin: 20px 0; }
        .info { margin: 10px 0; }
        .code { font-size: 24px; font-weight: bold; text-align: center; margin: 20px 0; }
    </style>
</head>
<body>
    <div class="ticket">
        <div class="header">
            <h1>Tikehub</h1>
            <h2>{{ $ticket->event->title }}</h2>
        </div>
        <div class="info">
            <p><strong>Type:</strong> {{ $ticket->ticketType->name }}</p>
            <p><strong>Date:</strong> {{ $ticket->event->start_date->format('d/m/Y H:i') }}</p>
            @if($ticket->event->is_virtual)
                <p><strong>Type:</strong> Événement virtuel ({{ ucfirst(str_replace('_', ' ', $ticket->event->platform_type ?? 'Visioconférence')) }})</p>
            @else
                <p><strong>Lieu:</strong> {{ $ticket->event->venue_name }}, {{ $ticket->event->venue_city }}</p>
            @endif
            <p><strong>Acheteur:</strong> {{ $ticket->buyer_name }}</p>
        </div>
        <div class="code">
            Code: {{ $ticket->code }}
        </div>
        @if($ticket->qr_code)
            <div class="qr-code">
                <img src="{{ public_path('storage/' . $ticket->qr_code) }}" alt="QR Code" style="width: 200px;">
            </div>
        @endif
        @if($ticket->event->is_virtual && $ticket->virtual_access_token)
            <div style="background-color: #f0f9ff; border: 2px solid #3b82f6; padding: 15px; margin: 20px 0; border-radius: 8px;">
                <h3 style="color: #1e40af; margin-top: 0;">Accès à l'événement virtuel</h3>
                <p style="margin: 10px 0;"><strong>Lien d'accès:</strong></p>
                <p style="word-break: break-all; color: #1e40af; font-size: 12px;">
                    {{ $ticket->getVirtualAccessUrl() }}
                </p>
                @if($ticket->event->virtual_access_instructions)
                    <p style="margin-top: 10px; font-size: 11px; color: #666;">
                        <strong>Instructions:</strong> {{ $ticket->event->virtual_access_instructions }}
                    </p>
                @endif
                @if($ticket->event->meeting_password)
                    <p style="margin-top: 10px; font-size: 11px; color: #666;">
                        <strong>Mot de passe:</strong> {{ $ticket->event->meeting_password }}
                    </p>
                @endif
            </div>
        @endif
        <p style="text-align: center; font-size: 12px; color: #666;">
            @if($ticket->event->is_virtual)
                Utilisez le lien ci-dessus pour accéder à l'événement virtuel
            @else
                Présentez ce billet à l'entrée de l'événement
            @endif
        </p>
    </div>
</body>
</html>

