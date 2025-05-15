@extends('client.dashboard')

@section('client-content')
<div class="dashboard-card p-6 space-y-6">
    <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
        Suivi des Livraisons
    </h2>

    @if($livraisons->count() > 0)
        <div class="grid gap-6">
            @foreach($livraisons as $reservation)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <img src="{{ asset('images/objet_'.$reservation->annonce->objet->id.'.jpg') }}" 
                                     alt="{{ $reservation->annonce->objet->nom }}"
                                     class="h-16 w-16 rounded-lg object-cover">
                            </div>
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                                    {{ $reservation->annonce->objet->nom }}
                                </h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $reservation->adresse_livraison }}
                                </p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="px-4 py-2 rounded-full text-sm font-semibold 
                                {{ $reservation->statut_livraison === 'en_attente' ? 'bg-yellow-100 text-yellow-800' : 
                                   ($reservation->statut_livraison === 'en_cours' ? 'bg-blue-100 text-blue-800' : 
                                   'bg-green-100 text-green-800') }}">
                                {{ ucfirst($reservation->statut_livraison) }}
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-12">
            <p class="text-gray-500 dark:text-gray-400">
                Aucune livraison en cours pour le moment.
            </p>
        </div>
    @endif
</div>
@endsection
