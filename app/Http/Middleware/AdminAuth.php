<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Dans votre middleware ou contrôleur
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            return response('Authentification requise', 401)
                ->header('WWW-Authenticate', 'Basic realm="Accès Admin", charset="UTF-8"');
        }

        // Vérification des credentials
        if (
            $_SERVER['PHP_AUTH_USER'] !== config('auth.basic.username') || 
            !Hash::check($_SERVER['PHP_AUTH_PW'], config('auth.basic.password_hash'))
        ) {
            return response('Identifiants invalides', 401)
                ->header('WWW-Authenticate', 'Basic realm="Accès Admin", charset="UTF-8"');
        }
        // Vérification session Laravel
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login');
        }

        return $next($request);
    }
}
