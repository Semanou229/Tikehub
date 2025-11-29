<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $organizerId = $user->id;

        // Notifications système (simulées - à remplacer par un système de notifications réel)
        $notifications = [
            [
                'type' => 'event',
                'icon' => 'calendar',
                'title' => 'Nouveau billet vendu',
                'message' => 'Un billet a été vendu pour votre événement "Concert Live"',
                'time' => now()->subMinutes(15),
                'read' => false,
            ],
            [
                'type' => 'payment',
                'icon' => 'credit-card',
                'title' => 'Paiement reçu',
                'message' => 'Vous avez reçu un paiement de 5 000 XOF',
                'time' => now()->subHours(2),
                'read' => false,
            ],
            [
                'type' => 'contest',
                'icon' => 'trophy',
                'title' => 'Nouveau vote',
                'message' => 'Un nouveau vote a été enregistré pour votre concours',
                'time' => now()->subDays(1),
                'read' => true,
            ],
        ];

        // Statistiques des notifications
        $unreadCount = collect($notifications)->where('read', false)->count();

        return view('dashboard.organizer.notifications.index', compact('notifications', 'unreadCount'));
    }

    public function markAsRead(Request $request, $id)
    {
        // À implémenter avec un système de notifications réel
        return back()->with('success', 'Notification marquée comme lue.');
    }

    public function markAllAsRead()
    {
        // À implémenter avec un système de notifications réel
        return back()->with('success', 'Toutes les notifications ont été marquées comme lues.');
    }
}


