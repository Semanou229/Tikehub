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
            <p><strong>Lieu:</strong> {{ $ticket->event->venue_name }}, {{ $ticket->event->venue_city }}</p>
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
        <p style="text-align: center; font-size: 12px; color: #666;">
            Présentez ce billet à l'entrée de l'événement
        </p>
    </div>
</body>
</html>

