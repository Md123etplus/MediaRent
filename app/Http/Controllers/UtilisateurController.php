<?php

namespace App\Http\Controllers;

use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use App\Http\Controllers\Controller;

class UtilisateurController extends Controller
{
    // Affiche la liste des utilisateurs
    public function index()
    {
        $utilisateurs = Utilisateur::all();
        return view('utilisateurs.index', compact('utilisateurs'));
    }

    // Formulaire d'inscription
    public function create()
    {
        return view('utilisateurs.create');
    }

    // Enregistre un nouvel utilisateur
    public function store(Request $request)
    {
        $data = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:Utilisateur,email',
            'mot_de_passe' => 'required|string|min:6',
            'role' => 'required|string|in:client,admin',
            'CIN' => 'required|string|unique:Utilisateur,CIN',
            'img_profil' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'img_cin_front' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'img_cin_back' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        Utilisateur::create($data);
        return redirect()->route('login')->with('success', 'Compte créé avec succès. Connectez-vous.');
    }

    // Affiche le formulaire de connexion
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Processus de connexion
    public function login(Request $request)
    {
        // Limitation des tentatives de connexion
        $maxAttempts = 5;
        if (RateLimiter::tooManyAttempts('login:'.$request->ip(), $maxAttempts)) {
            $seconds = RateLimiter::availableIn('login:'.$request->ip());
            return back()->withErrors([
                'email' => "Trop de tentatives. Réessayez dans $seconds secondes.",
            ]);
        }

        $credentials = $request->validate([
            'email' => 'required|email',
            'mot_de_passe' => 'required|string'
        ]);

        $utilisateur = Utilisateur::where('email', $credentials['email'])->first();

        if ($utilisateur && $utilisateur->mot_de_passe === $credentials['mot_de_passe']) {
            RateLimiter::clear('login:'.$request->ip());
            Auth::login($utilisateur);
            return redirect()->intended('/')->with('success', 'Connexion réussie');
        }

        RateLimiter::hit('login:'.$request->ip());
        return back()->withErrors([
            'email' => 'Identifiants incorrects',
        ]);
    }

    // Déconnexion
    public function logout()
    {
        Auth::logout();
        return redirect('/')->with('success', 'Déconnexion réussie');
    }

    // Affiche le profil d'un utilisateur
    public function show($id)
    {
        $utilisateur = Utilisateur::findOrFail($id);
        return view('utilisateurs.show', compact('utilisateur'));
    }

    // Vérification de mot de passe (pour usage spécifique)
    public function verifyPassword(Request $request, $id)
    {
        $utilisateur = Utilisateur::findOrFail($id);
        
        if ($utilisateur->mot_de_passe === $request->password_to_verify) {
            return back()->with('success', 'Mot de passe correct');
        }
        
        return back()->with('error', 'Mot de passe incorrect');
    }

    // Formulaire d'édition
    public function edit($id)
    {
        $utilisateur = Utilisateur::findOrFail($id);
        return view('utilisateurs.edit', compact('utilisateur'));
    }

    // Met à jour un utilisateur existant
    public function update(Request $request, $id)
    {
        $utilisateur = Utilisateur::findOrFail($id);
        
        $data = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => "required|email|unique:Utilisateur,email,$id",
            'mot_de_passe' => 'sometimes|string|min:6',
            'role' => 'required|string|in:client,admin',
            'CIN' => "required|string|unique:Utilisateur,CIN,$id",
        ]);

        $utilisateur->update($data);
        return redirect()->route('utilisateurs.show', $id)
                       ->with('success', 'Profil mis à jour');
    }

    // Supprime un utilisateur
    public function destroy($id)
    {
        $utilisateur = Utilisateur::findOrFail($id);
        $utilisateur->delete();
        return redirect()->route('utilisateurs.index')
                       ->with('success', 'Utilisateur supprimé');
    }
}