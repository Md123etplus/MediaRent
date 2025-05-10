@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6 text-center">Carte Interactive des Annonces</h1>
    
    <!-- Liste des annonces -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        @foreach($annonces as $annonce)
            @include('annonces.partials.card', ['annonce' => $annonce])
        @endforeach
    </div>

    <!-- Carte interactive full width -->
    <div class="bg-white rounded-xl shadow-xl overflow-hidden mb-8 border border-gray-200">
        <h2 class="text-2xl font-bold p-4 border-b">Localisation des annonces</h2>
        <div id="annonces-map" class="w-full h-[600px]"></div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css" />

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialiser la carte
    const map = L.map('annonces-map').setView([31.7917, -7.0926], 6);
    
    // Ajouter la couche OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    // Créer un groupe de marqueurs
    const markers = L.markerClusterGroup();

    // Ajouter les marqueurs pour chaque annonce
    @foreach($annonces as $annonce)
        @if($annonce->objet->latitude && $annonce->objet->longitude)
            const marker{{ $annonce->id }} = L.marker([
                {{ $annonce->objet->latitude }}, 
                {{ $annonce->objet->longitude }}
            ]).bindPopup(`
                <div class="popup-content" style="width: 250px;">
                    <div class="w-full h-32 overflow-hidden mb-2">
                        <img src="{{ $annonce->objet->images->first() ? asset($annonce->objet->images->first()->url) : asset('images/default.jpg') }}" 
                             alt="{{ $annonce->objet->nom }}"
                             class="w-full h-full object-cover"
                             onerror="this.onerror=null; this.src='{{ asset('images/default.jpg') }}'">
                    </div>
                    <h4 class="font-bold text-lg">{{ $annonce->objet->nom }}</h4>
                    <p class="text-gray-600 text-sm">{{ Str::limit($annonce->objet->description, 60) }}</p>
                    <p class="text-sm mt-1"><span class="font-semibold">📍</span> {{ $annonce->adress }}</p>
                    <p class="text-blue-600 font-bold mt-1">{{ $annonce->objet->prix_journalier }} €/jour</p>
                    <div class="flex justify-between items-center mt-2">
                        <a href="{{ route('annonces.show', $annonce->id) }}" 
                           class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm transition">
                            Voir détails
                        </a>
                        @if($annonce->premium)
                            <span class="bg-yellow-400 text-black text-xs font-bold px-2 py-1 rounded-full">
                                PREMIUM
                            </span>
                        @endif
                    </div>
                </div>
            `);
            markers.addLayer(marker{{ $annonce->id }});
        @endif
    @endforeach

    // Ajouter les marqueurs à la carte
    map.addLayer(markers);

    // Ajuster la vue pour afficher tous les marqueurs
    if (markers.getLayers().length > 0) {
        map.fitBounds(markers.getBounds(), { padding: [50, 50] });
    } else {
        // Vue par défaut si aucun marqueur
        map.setView([31.7917, -7.0926], 6);
    }
});
</script>
@endsection