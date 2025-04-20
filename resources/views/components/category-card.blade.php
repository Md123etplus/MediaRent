@props(['title', 'description', 'link'])

<div class="border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow">
    <div class="p-6">
        <h3 class="text-xl font-semibold mb-2">{{ $title }}</h3>
        <p class="text-gray-600 dark:text-gray-400 mb-4">{{ $description }}</p>
        <a href="{{ $link }}" class="inline-flex items-center text-primary font-medium hover:text-primary/80">
            Explorer
            <svg class="ml-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
    </div>
</div>