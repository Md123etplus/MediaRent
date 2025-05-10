@extends('layouts.app')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="max-w-2xl mx-auto py-10 px-4">
    <div class="bg-white shadow-lg rounded-xl p-8 border border-gray-200">

        @isset($annonce)
            <h1 class="text-3xl font-bold text-gray-800 mb-6">
                Réserver : <span class="text-blue-600">{{ $annonce->titre }}</span>
            </h1>

            @auth
                <!-- Formulaire si connecté -->
                <form action="{{ route('reservations.store', ['annonce' => $annonce->id]) }}" method="POST" class="space-y-6">
                    @csrf
                    <input type="hidden" name="annonce_id" value="{{ $annonce->id }}">
                    <input type="hidden" name="statut" value="en_attente">

                    <div>
                        <label for="date_debut" class="block text-sm font-medium text-gray-700 mb-1">Date de début</label>
                        <input type="date" name="date_debut" id="date_debut" required 
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="date_fin" class="block text-sm font-medium text-gray-700 mb-1">Date de fin</label>
                        <input type="date" name="date_fin" id="date_fin" required 
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <button type="submit"
                            class="w-full bg-blue-800 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-600 transition duration-200">
                            Réserver maintenant
                        </button>
                    </div>
                </form>
            @endauth

            @guest
                <!-- Script de redirection avec popup si non connecté -->
                <script>
                    Swal.fire({
                        icon: 'warning',
                        title: 'Connexion requise',
                        text: 'Vous devez être connecté pour effectuer une réservation.',
                        confirmButtonText: 'Se connecter',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "{{ route('login') }}";
                        }
                    });
                </script>
            @endguest

        @else
            <div class="text-red-600 font-semibold">
                Cette annonce n'est pas disponible.
                <a href="{{ url()->previous() }}" class="text-blue-600 hover:underline ml-2">Retour</a>
            </div>
        @endisset
    </div>
</div>
@endsection
