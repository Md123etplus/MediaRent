<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function confirm($token)
    {
        $subscriber = Subscriber::where('confirmation_token', $token)->firstOrFail();
        
        $subscriber->update([
            'is_confirmed' => true,
            'confirmation_token' => null
        ]);
        
        return view('newsletter.confirmed');
    }
}