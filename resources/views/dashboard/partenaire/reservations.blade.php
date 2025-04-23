@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <header class="bg-white shadow">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <img src="{{ asset('storage/' . Auth::user()->img_profil) }}" 
                     alt="Photo de profil"
                     class="w-12 h-12 rounded-full border-2 border-indigo-100 shadow-md object-cover">
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Mes Réservations</h2>
                    <p class="text-sm text-indigo-600 font-medium">Partenaire MediaRent</p>
                </div>
            </div>
            <a href="{{ route('partenaire.dashboard') }}" class="btn btn-indigo">
                <i class="fas fa-arrow-left mr-2"></i> Retour
            </a>
        </div>
    </header>

    <main class="container mx-auto px-4 py-8">
        <!-- Carte de revenu total -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-700">Revenu total généré</h3>
                    <p class="text-3xl font-bold text-green-600 mt-1">
                        {{ number_format($revenuTotal, 2) }} DH
                    </p>
                </div>
                <div class="bg-green-100 p-4 rounded-full">
                    <i class="fas fa-coins text-green-600 text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Liste des réservations -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Objet</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Client</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Dates</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Montant</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($reservations as $reservation)
                        <tr>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <img class="h-10 w-10 rounded-full object-cover" 
                                             src="{{ asset('storage/' . $reservation->annonce->objet->images->first()->path) }}" 
                                             alt="{{ $reservation->annonce->objet->nom }}">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $reservation->annonce->objet->nom }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ $reservation->annonce->objet->categorie->nom ?? 'Non catégorisé' }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $reservation->client->prenom }}</div>
                                <div class="text-sm text-gray-500">{{ $reservation->client->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    {{ $reservation->date_debut->format('d/m/Y') }} - 
                                    {{ $reservation->date_fin->format('d/m/Y') }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ number_format($reservation->montant_total, 2) }} DH
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                Aucune réservation trouvée.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>
@endsection