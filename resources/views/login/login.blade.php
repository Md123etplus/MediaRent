@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto py-12">
  <h2 class="text-2xl font-bold mb-6">Se connecter</h2>

  <form method="POST" action="{{ route('login.submit') }}" class="space-y-6">
    @csrf

    <div>
      <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
      <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
             class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
      @error('email')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
      @enderror
    </div>

    <div>
      <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe</label>
      <input id="password" name="password" type="password" required
             class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
      @error('password')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
      @enderror
    </div>

    <div class="flex items-center">
      <input id="remember" name="remember" type="checkbox" class="h-4 w-4">
      <label for="remember" class="ml-2 block text-sm text-gray-900">Se souvenir de moi</label>
    </div>

    <div>
      <button type="submit"
              class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm
                     text-white bg-blue-600 hover:bg-blue-700 focus:outline-none">
        Se connecter
      </button>
    </div>
  </form>
</div>
@endsection
