@foreach ($resultats as $annonce)
    <div class="border p-4 rounded shadow mb-4">
        <h2 class="text-lg font-semibold">{{ $annonce->titre }}</h2>
        <p>{{ $annonce->description }}</p>
        <p>Prix : {{ $annonce->prix }}€</p>
        <p>Ville : {{ $annonce->ville }}</p>
        <p>Note : {{ $annonce->note }}</p>
        <a href="{{ route('annonces.show', $annonce) }}" class="text-blue-600 hover:underline">Réserver</a>
    </div>
@endforeach
