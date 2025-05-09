<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use App\Models\User;

class NotificationController extends Controller
{
    public function index()
    {
        // $notifications = Auth::user()->notifications()
        //     ->orderBy('date_creation', 'desc')
        //     ->paginate(10);
        $testUser = User::find(Auth::id()); // Remplace 123 par l'ID de test
$notifications = $testUser->notifications()
    ->orderBy('date_creation', 'desc')
    ->paginate(10);
            
        return view('client.notifications.index', compact('notifications'));
    }

    public function markAsRead(Notification $notification)
    {
        // Vérifier que la notification appartient bien à l'utilisateur connecté
        if ($notification->utilisateur_id !== Auth::id()) {
            abort(403);
        }
        
        $notification->update(['lue' => true]);
        
        return back()->with('success', 'Notification marquée comme lue.');
    }

    public function markAllAsRead()
    {
        // Auth::user()->unreadNotifications()->get()->each(function ($notification) {
        //     $notification->update(['lue' => true]);
        // });
        $userId = 1; // ID de l'utilisateur de test
$user = User::find($userId);

$user->unreadNotifications()->get()->each(function ($notification) {
    $notification->update(['lue' => true]);
});
        
        return back()->with('success', 'Toutes les notifications ont été marquées comme lues.');
    }
}