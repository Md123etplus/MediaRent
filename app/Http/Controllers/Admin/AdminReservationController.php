<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;

class AdminReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::with(['client', 'annonce.objet'])
                        ->latest()
                        ->paginate(10);

        $stats = [
            'total' => Reservation::count(),
            'confirmed' => Reservation::where('statut', 'confirmée')->count(),
            'pending' => Reservation::where('statut', 'en_attente')->count(),
            'cancelled' => Reservation::where('statut', 'annulée')->count(),
        ];

        return view('admin.reservations.index', compact('reservations', 'stats'));
    }
}
