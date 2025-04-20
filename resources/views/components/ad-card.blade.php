<div class="bg-white rounded-lg shadow-md overflow-hidden transition-transform duration-300 hover:shadow-lg hover:-translate-y-1">
    <!-- Image -->
    <div class="h-48 bg-gray-100 overflow-hidden relative">
        @if(isset($ad->images) && $ad->images->isNotEmpty())
            <img src="{{ $ad->images->first()->path }}" 
                 alt="{{ $ad->title }}" 
                 class="w-full h-full object-cover">
        @else
            <div class="w-full h-full flex items-center justify-center text-gray-400">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
        @endif
        
        <!-- Badge Premium -->
        @if($ad->is_premium)
            <span class="absolute top-2 right-2 bg-yellow-400 text-yellow-800 text-xs font-bold px-2 py-1 rounded-full">
                Premium
            </span>
        @endif
    </div>

    <!-- Contenu -->
    <div class="p-4">
        <h3 class="font-bold text-lg mb-1 truncate">{{ $ad->title }}</h3>
        
        <div class="flex items-center mb-2">
            <span class="text-yellow-400 mr-1">
                ★
            </span>
            <span class="text-gray-700">
                {{ number_format($ad->rating, 1) }} ({{ $ad->reviews_count }} avis)
            </span>
        </div>

        <p class="text-indigo-600 font-bold text-lg mb-2">
            {{ number_format($ad->price_per_day, 2) }} €/jour
        </p>

        <div class="flex justify-between items-center text-sm text-gray-500">
            <span>{{ $ad->city }}</span>
            <span>{{ $ad->category->name }}</span>
        </div>

        <a href="{{ route('ads.show', $ad) }}" 
           class="block mt-4 text-center bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 transition">
            Voir détails
        </a>
    </div>
</div>