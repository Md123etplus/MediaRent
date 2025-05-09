<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('register.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:191',
            'prenom' => 'required|string|max:191',
            'email' => 'required|email|max:191|unique:users,email',
            'mot_de_passe' => 'required|string|min:8|confirmed',
            'CIN' => 'required|string|max:191',
            'img_profil' => 'required|file|mimes:jpg,jpeg,png|max:2048',
            'img_cin_front' => 'required|file|mimes:jpg,jpeg,png|max:2048',
            'img_cin_back' => 'required|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Handle file uploads
        $imgProfilPath = $request->file('img_profil')->store('profils', 'public');
        $imgCinFrontPath = $request->file('img_cin_front')->store('cin_front', 'public');
        $imgCinBackPath = $request->file('img_cin_back')->store('cin_back', 'public');


        $user = User::create([
        'nom' => $request->nom,
        'prenom' => $request->prenom,
        'email' => $request->email,
        'mot_de_passe' => Hash::make($request->mot_de_passe),
        'CIN' => $request->CIN,
        'img_profil' => $imgProfilPath,
        'img_cin_front' => $imgCinFrontPath,
        'img_cin_back' => $imgCinBackPath,
    ]);

        event(new Registered($user));

        return redirect()->route('verification.notice');
    }
}
