@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">
        @if(request()->anyFilled(['q', 'ville', 'categorie', 'date_debut', 'date_fin', 'min_rating', 'prix_min', 'prix_max']))
            Résultats de recherche
            @if(request('q')) pour "{{ request('q') }}"@endif
            @if(request('ville')) à {{ request('ville') }}@endif
        @else
            Toutes les annonces
        @endif
    </h1>

    <!-- Formulaire de filtrage -->
    <form action="{{ route('client.annonces.search') }}" method="GET" class="mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
            <!-- Recherche par mot-clé -->
            <div>
                <input type="text" name="q" value="{{ request('q') }}" 
                    class="w-full px-4 py-2 border rounded" 
                    placeholder="Rechercher...">
            </div>
            
            <!-- Filtre par ville -->
            <div>
                <select name="ville" class="w-full px-4 py-2 border rounded">
                    <option value="">-- Sélectionner une ville --</option>
                    <option value="Casablanca" {{ request('ville') == 'Casablanca' ? 'selected' : '' }}>Casablanca</option>
                    <option value="Rabat" {{ request('ville') == 'Rabat' ? 'selected' : '' }}>Rabat</option>
                    <option value="Marrakech" {{ request('ville') == 'Marrakech' ? 'selected' : '' }}>Marrakech</option>
                    <option value="Fès" {{ request('ville') == 'Fès' ? 'selected' : '' }}>Fès</option>
                    <option value="Tanger" {{ request('ville') == 'Tanger' ? 'selected' : '' }}>Tanger</option>
                    <option value="Agadir" {{ request('ville') == 'Agadir' ? 'selected' : '' }}>Agadir</option>
                    <option value="Meknès" {{ request('ville') == 'Meknès' ? 'selected' : '' }}>Meknès</option>
                    <option value="Oujda" {{ request('ville') == 'Oujda' ? 'selected' : '' }}>Oujda</option>
                    <option value="Kenitra" {{ request('ville') == 'Kenitra' ? 'selected' : '' }}>Kenitra</option>
                    <option value="Tétouan" {{ request('ville') == 'Tétouan' ? 'selected' : '' }}>Tétouan</option>
                    <option value="Safi" {{ request('ville') == 'Safi' ? 'selected' : '' }}>Safi</option>
                    <option value="El Jadida" {{ request('ville') == 'El Jadida' ? 'selected' : '' }}>El Jadida</option>
                    <option value="Khouribga" {{ request('ville') == 'Khouribga' ? 'selected' : '' }}>Khouribga</option>
                    <option value="Béni Mellal" {{ request('ville') == 'Béni Mellal' ? 'selected' : '' }}>Béni Mellal</option>
                    <option value="Nador" {{ request('ville') == 'Nador' ? 'selected' : '' }}>Nador</option>
                    <option value="Taza" {{ request('ville') == 'Taza' ? 'selected' : '' }}>Taza</option>
                    <option value="Khémisset" {{ request('ville') == 'Khémisset' ? 'selected' : '' }}>Khémisset</option>
                    <option value="Settat" {{ request('ville') == 'Settat' ? 'selected' : '' }}>Settat</option>
                    <option value="Larache" {{ request('ville') == 'Larache' ? 'selected' : '' }}>Larache</option>
                    <option value="Ksar El Kebir" {{ request('ville') == 'Ksar El Kebir' ? 'selected' : '' }}>Ksar El Kebir</option>
                    <!-- Ajoute d'autres villes si besoin -->
                </select>
            </div>
            
            <!-- Filtre par catégorie -->
            <div>
                <select name="categorie" class="w-full px-4 py-2 border rounded">
                    <option value="">Toutes catégories</option>
                    @foreach($categories as $categorie)
                        <option value="{{ $categorie->nom }}" {{ request('categorie') == $categorie->nom ? 'selected' : '' }}>
                            {{ $categorie->nom }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
            <!-- Dates -->
            <div>
                <label class="block text-sm mb-1">Date début</label>
                <input type="date" name="date_debut" value="{{ request('date_debut') }}" 
                    class="w-full px-4 py-2 border rounded">
            </div>
            <div>
                <label class="block text-sm mb-1">Date fin</label>
                <input type="date" name="date_fin" value="{{ request('date_fin') }}" 
                    class="w-full px-4 py-2 border rounded">
            </div>
            
            <!-- Filtre par prix -->
            <div>
                <label class="block text-sm mb-1">Prix min (€)</label>
                <input type="number" name="prix_min" value="{{ request('prix_min') }}" 
                    class="w-full px-4 py-2 border rounded" min="0" step="0.01">
            </div>
            <div>
                <label class="block text-sm mb-1">Prix max (€)</label>
                <input type="number" name="prix_max" value="{{ request('prix_max') }}" 
                    class="w-full px-4 py-2 border rounded" min="0" step="0.01">
            </div>
        </div>
        
        <div class="flex items-center mb-6">
            <div class="mr-4">
                <label class="block text-sm mb-1">Note minimum</label>
                <select name="min_rating" class="px-4 py-2 border rounded">
                    <option value="">Toutes</option>
                    @for($i = 1; $i <= 5; $i++)
                        <option value="{{ $i }}" {{ request('min_rating') == $i ? 'selected' : '' }}>
                            {{ $i }}+ étoiles
                        </option>
                    @endfor
                </select>
            </div>
            
            <div class="mt-auto">
                <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                    Filtrer
                </button>
                <a href="{{ route('client.annonces.search') }}" class="ml-2 text-blue-600 hover:underline">
                    Réinitialiser
                </a>
            </div>
        </div>
    </form>

    <!-- Affichage des filtres actifs -->
    @if(request()->anyFilled(['ville', 'categorie', 'date_debut', 'date_fin', 'min_rating', 'prix_min', 'prix_max']))
        <div class="mb-6 flex flex-wrap gap-2">
            @if(request('ville'))
                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">
                    Ville: {{ request('ville') }}
                </span>
            @endif
            @if(request('categorie'))
                <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">
                    Catégorie: {{ request('categorie') }}
                </span>
            @endif
            @if(request('date_debut') && request('date_fin'))
                <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">
                    Période: {{ \Carbon\Carbon::parse(request('date_debut'))->format('d/m/Y') }} - 
                    {{ \Carbon\Carbon::parse(request('date_fin'))->format('d/m/Y') }}
                </span>
            @endif
            @if(request('min_rating'))
                <span class="bg-purple-100 text-purple-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-purple-900 dark:text-purple-300">
                    Note: {{ request('min_rating') }}+
                </span>
            @endif
            @if(request('prix_min') || request('prix_max'))
                <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">
                    Prix: 
                    @if(request('prix_min')){{ request('prix_min') }}€ @endif
                    @if(request('prix_min') && request('prix_max'))-@endif
                    @if(request('prix_max')){{ request('prix_max') }}€ @endif
                </span>
            @endif
        </div>
    @endif

    @if($annonces->isEmpty())
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 text-center">
            <p class="text-gray-600 dark:text-gray-400">Aucun résultat trouvé pour votre recherche.</p>
            <a href="{{ route('client.annonces.search') }}" class="mt-4 inline-block text-blue-600 dark:text-blue-400 hover:underline">
                Réinitialiser les filtres
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($annonces as $annonce)
                @include('annonces.partials.annonce-card', ['annonce' => $annonce])
            @endforeach
        </div>
        
        <div class="mt-6">
            {{ $annonces->appends(request()->except('page'))->links() }}
        </div>
    @endif
</div>
@endsection