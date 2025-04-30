<div class="flex flex-col md:flex-row gap-6">
    <!-- Gallery -->
    <div class="w-full md:w-2/5">
        <div class="relative h-64 md:h-80 bg-gray-100 rounded-lg overflow-hidden flex items-center justify-center">
            @foreach($annonce->objet->images as $key => $image)
                <img src="{{ asset($image->url) }}"
                     class="absolute inset-0 w-full h-full object-contain transition-opacity duration-300 {{ $loop->first ? 'opacity-100' : 'opacity-0' }}"
                     data-index="{{ $key }}"
                     alt="{{ $annonce->objet->nom }}">
            @endforeach

            @if($annonce->premium)
                <span class="absolute top-3 right-3 bg-gradient-to-r from-yellow-400 to-yellow-600 text-black text-xs font-bold px-3 py-1 rounded-full">
                    Premium
                </span>
            @endif
        </div>

        @if($annonce->objet->images->count() > 1)
            <div class="flex flex-wrap gap-2 mt-3 justify-center">
                @foreach($annonce->objet->images as $key => $image)
                    <button onclick="changeMainImage({{ $key }})"
                            class="w-16 h-16 rounded border-2 border-transparent hover:border-blue-400 overflow-hidden transition-all"
                            data-index="{{ $key }}">
                        <img src="{{ asset($image->url) }}" class="w-full h-full object-cover" alt="Miniature">
                    </button>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Details -->
    <div class="w-full md:w-3/5">
        <h1 class="text-2xl font-bold text-gray-800 mb-2">{{ $annonce->objet->nom }}</h1>
        <div class="text-xl text-green-600 font-semibold mb-4">
            {{ number_format($annonce->objet->prix_journalier, 2) }} € / jour
        </div>

        <div class="space-y-2 mb-6">
            <div class="flex items-center">
                <span class="text-gray-600 w-24">📍 Ville</span>
                <span class="font-medium">{{ $annonce->objet->ville }}</span>
            </div>
            <!-- ... autres métadonnées ... -->
        </div>

        <div class="mb-6">
            <h3 class="text-lg font-semibold border-b pb-1 mb-2">Description</h3>
            <p class="text-gray-700">{{ $annonce->objet->description }}</p>
        </div>

        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
            <h4 class="font-semibold mb-2">👤 {{ $annonce->proprietaire->full_name }}</h4>
            <p class="text-sm text-gray-600">Membre depuis {{ $annonce->proprietaire->created_at->diffForHumans() }}</p>
        </div>
    </div>
</div>

<script>
function changeMainImage(index) {
    $('#annonce-modal-content img[data-index]').each(function() {
        $(this).css('opacity', $(this).data('index') == index ? 1 : 0);
    });
}
</script>
