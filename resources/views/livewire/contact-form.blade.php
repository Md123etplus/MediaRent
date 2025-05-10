<form wire:submit.prevent="submit" class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <label for="name" class="block text-sm font-medium mb-1">Nom</label>
        <input type="text" id="name" wire:model="name" class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded">
    </div>
    <div>
        <label for="email" class="block text-sm font-medium mb-1">Email</label>
        <input type="email" id="email" wire:model="email" class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded">
    </div>
    <div class="md:col-span-2">
        <label for="subject" class="block text-sm font-medium mb-1">Sujet</label>
        <input type="text" id="subject" wire:model="subject" class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded">
    </div>
    <div class="md:col-span-2">
        <label for="message" class="block text-sm font-medium mb-1">Message</label>
        <textarea id="message" wire:model="message" rows="4" class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded"></textarea>
    </div>
    <div class="md:col-span-2">
        <button type="submit" class="px-6 py-3 bg-blue-600 text-white font-medium rounded hover:bg-blue-700 transition">
            Envoyer le message
        </button>
    </div>
    @if($success)
        <div class="md:col-span-2 text-green-500 font-semibold">
            Message envoyé avec succès !
        </div>
    @endif
</form>
