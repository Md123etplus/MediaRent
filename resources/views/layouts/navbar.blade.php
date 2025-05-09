<form action="{{ route('search.annonces') }}" method="GET" class="flex gap-2">
    <input type="text" name="ville" placeholder="Ville" class="input input-sm border rounded px-2" />
    <input type="text" name="type" placeholder="Type" class="input input-sm border rounded px-2" />
    <input type="number" name="prix_min" placeholder="Prix min" class="input input-sm border rounded px-2 w-24" />
    <input type="number" name="prix_max" placeholder="Prix max" class="input input-sm border rounded px-2 w-24" />
    <input type="number" step="0.1" name="note_min" placeholder="Note min" class="input input-sm border rounded px-2 w-24" />
    <button type="submit" class="btn bg-blue-600 text-white px-3 rounded hover:bg-blue-700">Rechercher</button>
</form>
