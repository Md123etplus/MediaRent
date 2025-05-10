@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-10 max-w-2xl bg-white text-gray-800 rounded-2xl shadow-xl">
    <h2 class="text-3xl font-bold mb-8 text-center text-blue-800">Informations du client</h2>

    @if($errors->any())
        <div class="mb-6 bg-red-100 text-red-800 rounded-lg p-4">
            <ul class="list-disc list-inside text-sm">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('reservations.storeClient') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div>
            <label for="nom" class="block text-sm font-semibold mb-1">Nom</label>
            <input type="text" name="nom" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 transition" required>
        </div>

        <div>
            <label for="prenom" class="block text-sm font-semibold mb-1">Prénom</label>
            <input type="text" name="prenom" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 transition" required>
        </div>

        <div>
            <label for="email" class="block text-sm font-semibold mb-1">Email</label>
            <input type="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 transition" required>
        </div>

        <div>
            <label for="CIN" class="block text-sm font-semibold mb-1">CIN</label>
            <input type="text" name="CIN" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 transition" required>
        </div>

        <div class="text-center pt-4">
            <button type="submit" class="bg-blue-800 hover:bg-blue-600 text-white font-semibold px-6 py-2 rounded-full shadow-md transition duration-300">
                Valider
            </button>
        </div>
    </form>
</div>
@endsection
