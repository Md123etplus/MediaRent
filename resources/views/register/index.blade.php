@extends('layouts.app')

@section('title', 'Inscription')
@section('content')
<div class="max-w-md mx-auto py-12">
    <h1 class="text-2xl font-bold mb-8 text-center">Créer un compte</h1>
    
    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf
        <input type="hidden" name="plan" value="{{ request()->plan }}">

        <div>
            <label for="name" class="block mb-1">Nom complet</label>
            <input id="name" type="text" name="name" required autofocus
                   class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500">
        </div>

        <div>
            <label for="email" class="block mb-1">Email</label>
            <input id="email" type="email" name="email" required
                   class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500">
        </div>

        <div>
            <label for="password" class="block mb-1">Mot de passe</label>
            <input id="password" type="password" name="password" required
                   class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500">
        </div>

        <button type="submit" class="w-full bg-indigo-600 text-white py-3 rounded-lg hover:bg-indigo-700">
            S'inscrire
        </button>
    </form>
</div>
@endsection