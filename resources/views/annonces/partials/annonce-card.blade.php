<div class="bg-white rounded-lg shadow-md p-4 mb-4 relative hover:shadow-lg transition-shadow">
    @if($annonce->premium)
        <span class="absolute top-2 right-2 bg-yellow-400 text-xs font-bold px-2 py-1 rounded-full">
            PREMIUM
        </span>
    @endif

    <!-- Image de l'objet - Version sécurisée -->
    @if($annonce->objet && $annonce->objet->images && $annonce->objet->images->isNotEmpty())
        <div class="w-full h-48 overflow-hidden rounded-t-lg mb-4">
            <img src="{{ asset($annonce->objet->images->first()->url) }}" 
                 alt="{{ $annonce->objet->nom ?? 'Image produit' }}"
                 class="w-full h-full object-cover"
                 onerror="this.onerror=null; this.src='{{ asset('images/default.jpg') }}'">
        </div>
    @else
        <div class="w-full h-48 bg-gray-200 flex items-center justify-center rounded-t-lg mb-4">
            <img src="{{ asset('images/default.jpg') }}" 
                 alt="Image par défaut" 
                 class="h-full object-cover">
        </div>
    @endif

    <!-- Contenu - Version sécurisée -->
    <div class="p-4">
        @if($annonce->objet)
            <h3 class="text-xl font-bold">{{ $annonce->objet->nom ?? 'Nom non disponible' }}</h3>
            <p class="text-gray-600 mt-1">{{ Str::limit($annonce->objet->description ?? '', 80) }}</p>
            
            <div class="mt-3 space-y-1">
                <p class="text-sm">
                    <span class="font-semibold">Ville:</span> 
                    {{ $annonce->objet->ville ?? 'Non spécifiée' }}
                </p>
                
                @if($annonce->objet->categorie)
                <p class="text-sm">
                    <span class="font-semibold">Catégorie:</span> 
                    {{ $annonce->objet->categorie->nom }}
                </p>
                @endif
                
                <p class="text-sm">
                    <span class="font-semibold">Prix:</span> 
                    {{ $annonce->objet->prix_journalier ?? '0' }} €/jour
                </p>
                
                <p class="text-sm">
                    <span class="font-semibold">Disponible:</span> 
                    {{ $annonce->date_debut->format('d/m/Y') }} - {{ $annonce->date_fin->format('d/m/Y') }}
                </p>
                
                @php
                    $avgRating = $annonce->objet->evaluations->avg('note_objet') ?? 0;
                @endphp
                
                @if($avgRating > 0)
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
        @else
            <div class="text-red-500">Objet associé non trouvé</div>
        @endif

        <a href="{{ route('annonces.show', $annonce->id) }}"
            class="mt-4 inline-block w-full text-center bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
            Voir détails
        </a>
    </div>

    <!-- Carte Interactive - Version sécurisée -->
    @if($annonce->objet && $annonce->objet->latitude && $annonce->objet->longitude)
        <div class="mt-4 border-t pt-4">
            <h4 class="font-semibold mb-2">Localisation</h4>
            <div id="map-{{ $annonce->id }}" class="h-48 rounded-lg bg-gray-100 z-0"></div>
        </div>
    @endif
</div>

@once
@push('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    @foreach($annonces as $annonce)
        @if($annonce->objet && $annonce->objet->latitude && $annonce->objet->longitude)
            try {
                const map{{ $annonce->id }} = L.map('map-{{ $annonce->id }}').setView([
                    {{ $annonce->objet->latitude }}, 
                    {{ $annonce->objet->longitude }}
                ], 14);
                
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap'
                }).addTo(map{{ $annonce->id }});
                
                L.marker([
                    {{ $annonce->objet->latitude }},
                    {{ $annonce->objet->longitude }}
                ]).addTo(map{{ $annonce->id }})
                .bindPopup("<b>{{ addslashes($annonce->objet->nom) }}</b>");
            } catch (e) {
                console.error("Erreur initialisation carte {{ $annonce->id }}:", e);
            }
        @endif
    @endforeach
});
</script>
@endpush
@endonce