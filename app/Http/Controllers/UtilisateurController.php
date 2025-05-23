<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\Rules\Password;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UtilisateurController extends Controller
{
    // Affiche la liste des utilisateurs
    public function index()
    {
        $utilisateurs = User::all();
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

        User::create($data);
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

        $utilisateur = User::where('email', $credentials['email'])->first();

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
        $utilisateur = User::findOrFail($id);
        return view('utilisateurs.show', compact('utilisateur'));
    }

    // Vérification de mot de passe (pour usage spécifique)
    public function verifyPassword(Request $request, $id)
    {
        $utilisateur = User::findOrFail($id);
        
        if ($utilisateur->mot_de_passe === $request->password_to_verify) {
            return back()->with('success', 'Mot de passe correct');
        }
        
        return back()->with('error', 'Mot de passe incorrect');
    }

    // Formulaire d'édition
    public function edit($id)
    {
        $utilisateur = User::findOrFail($id);
        return view('utilisateurs.edit', compact('utilisateur'));
    }

    // Met à jour un utilisateur existant
    public function update(Request $request, $id)
    {
        $utilisateur = User::findOrFail($id);
        
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
        $utilisateur = User::findOrFail($id);
        $utilisateur->delete();
        return redirect()->route('utilisateurs.index')
                       ->with('success', 'Utilisateur supprimé');
    }

    //edit profil functionnality
    public function showProfile()
    {
        $user = User::find(Auth::id());
        return view('profile.show', compact('user'));
    }

    // Show profile edit form
    public function editProfile()
    {
        $user = Auth::user();
        if (!$user instanceof User) {
            return back()->withErrors(['error' => 'Utilisateur non trouvé']);
        }
        return view('profile.edit', compact('user'));
    }

    // Update profile information
    public function updateProfile(Request $request)
{
    $user = Auth::user();

    $validated = $request->validate([
        'nom' => 'required|string|max:255',
        'prenom' => 'required|string|max:255',
        'username' => 'required|string|max:255|unique:users,username,'.$user->id, // Changed to 'users'
        'email' => 'required|string|email|max:255|unique:users,email,'.$user->id, // Changed to 'users'
        'CIN' => 'required|string|max:255|unique:users,CIN,'.$user->id, // Changed to 'users'
    ]);

    // Alternative update syntax if update() still fails
    $user->username = $validated['username'];
    $user->nom = $validated['nom'];
    $user->prenom = $validated['prenom'];
    $user->email = $validated['email'];
    $user->CIN = $validated['CIN'];
    if ($user && $user instanceof User) {
        
            $user->save();
          
       
    } else {
        return back()->withErrors(['error' => 'Utilisateur non trouvé']);
    }

    return redirect()->route('profile.show')
        ->with('success', 'Profil mis à jour avec succès');
}

    // Update user password
    public function updatePasswordProfile(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $user = Auth::user();
        $user->mot_de_passe = Hash::make($request->password);
        if ($user && $user instanceof User) {
            $user->save();
        } else {
            return back()->withErrors(['error' => 'Utilisateur non trouvé']);
        }
        // $user->save();

        return back()->with('success', 'Mot de passe mis à jour avec succès');
    }

    // Update profile and CIN images
    public function updateImagesProfile(Request $request)
    {
        $user = Auth::user();
        $updates = [];

        $request->validate([
            'img_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'img_cin_front' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'img_cin_back' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Handle profile image upload
        if ($request->hasFile('img_profil')) {
            if ($user->img_profil) {
                Storage::delete($user->img_profil,'public');
            }
            $path = $request->file('img_profil')->store('profile_images', 'public');
            $updates['img_profil'] = $path;
        }

        // Handle CIN front image upload
        if ($request->hasFile('img_cin_front')) {
            if ($user->img_cin_front) {
                Storage::delete($user->img_cin_front,'public');
            }
            $path = $request->file('img_cin_front')->store('cin_images', 'public');
            $updates['img_cin_front'] = $path;
        }

        // Handle CIN back image upload
        if ($request->hasFile('img_cin_back')) {
            if ($user->img_cin_back) {
                Storage::delete($user->img_cin_back,'public');
            }
            $path = $request->file('img_cin_back')->store('cin_images','public');
            $updates['img_cin_back'] = $path;
        }

        if (!empty($updates)) {
            foreach ($updates as $key => $value) {
                $user->$key = $value;
            }
            if ($user && $user instanceof User) {
                $user->save();
            } else {
                return back()->withErrors(['error' => 'Utilisateur non trouvé']);
            }
            // $user->save();
            return back()->with('success', 'Images mises à jour avec succès');
        }

        return back()->with('info', 'Aucune image mise à jour');
    }
}