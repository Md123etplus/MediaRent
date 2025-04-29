<div class="bg-white rounded-lg shadow-md p-4 mb-4 relative hover:shadow-lg transition-shadow">
    @if($annonce->premium)
        <span class="absolute top-2 right-2 bg-yellow-400 text-xs font-bold px-2 py-1 rounded-full">
            PREMIUM
        </span>
    @endif
    
    <!-- Contenu -->
    <div class="p-4">
        <h3 class="text-xl font-bold">{{ $annonce->objet->nom }}</h3>
        <p class="text-gray-600 mt-1">{{ Str::limit($annonce->objet->description, 80) }}</p>
        
        <div class="mt-3 space-y-1">
            <p class="text-sm">
                <span class="font-semibold">Ville:</span> 
                {{ $annonce->adress }}
            </p>
            <p class="text-sm">
                <span class="font-semibold">Catégorie:</span> 
                {{ $annonce->objet->categorie->nom }}
            </p>
            <p class="text-sm">
                <span class="font-semibold">Prix:</span> 
                {{ $annonce->objet->prix_journalier }} €/jour
            </p>
            <p class="text-sm">
                <span class="font-semibold">Disponible:</span> 
                {{ $annonce->date_debut->format('d/m/Y') }} - {{ $annonce->date_fin->format('d/m/Y') }}
            </p>
            
            <!-- Note moyenne -->
            @php
                $avgRating = $annonce->objet->evaluations->avg('note');
            @endphp
            @if($avgRating)
                <div class="flex items-center mt-1">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= floor($avgRating))
                            <span class="text-yellow-400">★</span>
                        @elseif($i == ceil($avgRating) && $avgRating - floor($avgRating) >= 0.5)
                            <span class="text-yellow-400">½</span>
                        @else
                            <span class="text-gray-300">★</span>
                        @endif
                    @endfor
                    <span class="ml-1 text-sm text-gray-600">({{ number_format($avgRating, 1) }})</span>
                </div>
            @endif
        </div>

        <a href="{{ route('annonces.show', $annonce->id) }}"
            class="mt-4 inline-block w-full text-center bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
            Voir détails
        </a>
    </div>
</div>