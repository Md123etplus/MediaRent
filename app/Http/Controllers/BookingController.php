<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ad;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NewBookingNotification;

use Illuminate\Routing\Controller;

class BookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Ad $ad)
    {
        return view('bookings.create', compact('ad'));
    }

    public function store(Request $request, Ad $ad)
    {
        $validated = $request->validate([
            'start_date' => 'required|date|after:today',
            'end_date' => 'required|date|after:start_date',
            'delivery_option' => 'required|in:pickup,delivery',
            'delivery_address' => 'required_if:delivery_option,delivery',
        ]);

        $booking = new Booking();
        $booking->ad_id = $ad->id;
        $booking->client_id = Auth::id();
        $booking->start_date = $validated['start_date'];
        $booking->end_date = $validated['end_date'];
        $booking->delivery_option = $validated['delivery_option'];
        $booking->delivery_address = $validated['delivery_address'] ?? null;
        $booking->status = 'pending';
        $booking->save();

        // Notifier le partenaire
        $ad->partner->notify(new NewBookingNotification($booking));

        return redirect()->route('bookings.show', $booking)
            ->with('success', 'Votre réservation a été enregistrée!');
    }

    public function show(Booking $booking)
    {
        $this->authorize('view', $booking);
        return view('bookings.show', compact('booking'));
    }

    public function confirm(Booking $booking)
    {
        $this->authorize('confirm', $booking);
        $booking->update(['status' => 'confirmed']);
        
        // Envoyer les détails au partenaire
        // Mail::to($booking->ad->partner->email)->send(new BookingConfirmedMail($booking));
        
        return back()->with('success', 'Réservation confirmée!');
    }
}