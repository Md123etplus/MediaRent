<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Affiche le formulaire de connexion.
     */
    public function showLoginForm()
    {
        return view('login.login');
    }

    /**
     * Traite la soumission du formulaire de connexion.
     */
    public function login(Request $request)
    {
        // Validation basique
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // Tentative d'authentification
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            // Régénère la session pour éviter fixation
            $request->session()->regenerate();
            return redirect()->route('client.index'); // ou ta route de dashboard
        }



        // En cas d’échec
        return back()
            ->withErrors(['email' => 'Ces identifiants ne correspondent pas.'])
            ->onlyInput('email');
    }

    /**
     * Déconnecte l’utilisateur.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/'); // ou route de landing
    }
}
