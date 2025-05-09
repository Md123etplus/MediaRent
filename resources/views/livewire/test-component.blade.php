<div class="p-4 border border-blue-500 rounded-lg">
    <h2 class="text-lg font-bold mb-2">Livewire Test Component</h2>
    
    <button 
        wire:click="testAction"
        class="px-4 py-2 bg-blue-500 text-white rounded"
    >
        Test Livewire
    </button>
    
    <div class="mt-4">
        @if($clicked)
            <p class="text-green-600 font-bold">{{ $message }}</p>
            <p class="text-sm text-gray-600">Component state updated without page reload</p>
        @else
            <p class="text-gray-500">Click the button to test</p>
        @endif
    </div>
</div>