<div class="max-w-3xl mx-auto text-center">
    <h2 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-4xl">
        Restez informé
    </h2>
    <p class="mt-4 text-lg text-gray-600 dark:text-gray-400">
        Abonnez-vous à notre newsletter pour recevoir les dernières annonces directement dans votre boîte de réception.
    </p>
    <form wire:submit.prevent="subscribe"
      class="mt-8 sm:mx-auto sm:max-w-md">
    <div class="flex flex-col sm:flex-row gap-2">
        <input
            wire:model="email"
            type="email"
            required
            placeholder="Entrez votre email"
            class="px-4 py-3 w-full rounded-md border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
        >
        <button 
            type="submit" 
            wire:loading.attr="disabled"
            class="px-6 py-3 rounded-md bg-blue-600 text-white font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed"
        >
            <span wire:loading.remove>S'abonner</span>
            <span wire:loading class="inline-flex items-center">
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                En cours...
            </span>
        </button>
    </div>
    
    @error('email')
        <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
    @enderror
    
    @if($error)
        <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $error }}</p>
    @endif
    
    @if($submitted)
        <p class="mt-4 text-green-600 dark:text-green-500">
            Merci pour votre abonnement ! Vous recevrez un email de confirmation.
        </p>
    @endif
    
    <p class="mt-4 text-sm text-gray-500 dark:text-gray-400">
        En vous abonnant, vous acceptez de recevoir nos dernières annonces tous les 5 jours.
    </p>
</form>
</div>