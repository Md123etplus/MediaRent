@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-10 max-w-2xl bg-white shadow-lg rounded-xl">
    <h2 class="text-2xl font-semibold mb-6 text-center text-primary">Informations personnelles du client</h2>

    @if($errors->any())
        <div class="mb-4 text-red-600">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('reservations.storeClient') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf

        <div>
            <label for="nom" class="block text-sm font-medium">Nom</label>
            <input type="text" name="nom" class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary" required>
        </div>

        <div>
            <label for="prenom" class="block text-sm font-medium">Prénom</label>
            <input type="text" name="prenom" class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary" required>
        </div>

        <div>
            <label for="email" class="block text-sm font-medium">Email</label>
            <input type="email" name="email" class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary" required>
        </div>

        <div>
            <label for="CIN" class="block text-sm font-medium">CIN</label>
            <input type="text" name="CIN" class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary" required>
        </div>

        <!--<div>
            <label for="img_profil" class="block text-sm font-medium">Image de profil</label>
            <input type="file" name="img_profil" accept="image/*" class="mt-1 w-full" required>
        </div>

        <div>
            <label for="img_cin_front" class="block text-sm font-medium">CIN Recto</label>
            <input type="file" name="img_cin_front" accept="image/*" class="mt-1 w-full" required>
        </div>

        <div>
            <label for="img_cin_back" class="block text-sm font-medium">CIN Verso</label>
            <input type="file" name="img_cin_back" accept="image/*" class="mt-1 w-full" required>
        </div>-->

        <div class="text-center">
            <button type="submit" class="btn-primary px-6 py-2">Valider</button>
        </div>
    </form>
</div>
@endsection
