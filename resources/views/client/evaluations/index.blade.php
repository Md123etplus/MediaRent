@extends('client.dashboard')

@section('client-content')
<div class="dashboard-card">
    <h2 class="dashboard-card-header">Mes évaluations</h2>
    
    <div class="overflow-x-auto">
        <table class="responsive-table w-full">
            <thead>
                <tr>
                    <th>Objet</th>
                    <th>Propriétaire</th>
                    <th>Note objet</th>
                    <th>Note propriétaire</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @forelse($recentReservations ?? [] as $reservation)
                    <tr>
                        <td>
                            <div class="flex items-center">
                                <img src="{{ $evaluation->reservation->annonce->objet->images->first()->url ?? '/images/placeholder.png' }}" 
                                     alt="{{ $evaluation->reservation->annonce->objet->nom }}" 
                                     class="w-10 h-10 rounded-full object-cover mr-3">
                                <div>
                                    <p class="font-medium">{{ $evaluation->reservation->annonce->objet->nom }}</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ \Carbon\Carbon::parse($evaluation->reservation->date_debut)->format('d/m/Y') }} - 
                                        {{ \Carbon\Carbon::parse($evaluation->reservation->date_fin)->format('d/m/Y') }}
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td>
                            {{ $evaluation->reservation->annonce->proprietaire->prenom }} {{ $evaluation->reservation->annonce->proprietaire->nom }}
                        </td>
                        <td>
                            <div class="flex">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $evaluation->note_objet)
                                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                    @else
                                        <svg class="w-5 h-5 text-gray-300 dark:text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                    @endif
                                @endfor
                            </div>
                        </td>
                        <td>
                            <div class="flex">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $evaluation->note_proprietaire)
                                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                    @else
                                        <svg class="w-5 h-5 text-gray-300 dark:text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                    @endif
                                @endfor
                            </div>
                        </td>
                        <td>
                            {{ \Carbon\Carbon::parse($evaluation->date)->format('d/m/Y') }}
                        </td>
                        <td>
                            <a href="{{ route('client.evaluations.show', $evaluation->id) }}" 
                               class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 mr-2">
                                Voir
                            </a>
                            <a href="{{ route('client.evaluations.edit', $evaluation->id) }}" 
                               class="text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300">
                                Modifier
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-gray-500 dark:text-gray-400">
                            Aucune évaluation trouvée
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
    @if(isset($evaluations))
    {{ $evaluations->links() }}
@endif

    </div>
</div>
@endsection