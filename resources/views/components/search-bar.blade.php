<div class="search-bar">
    <form action="{{ route('search') }}" method="GET">
        <div class="flex">
            <input 
                type="text" 
                name="q" 
                placeholder="Rechercher des objets..." 
                class="flex-grow px-4 py-2 border rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                value="{{ request('q') }}"
            >
            <button 
                type="submit" 
                class="bg-blue-600 text-white px-6 py-2 rounded-r-lg hover:bg-blue-700 transition"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </button>
        </div>
    </form>
</div>