<div class="max-w-4xl mx-auto" x-data="{ 
    openFaq: null,
    toggleFaq(index) {
        this.openFaq = this.openFaq === index ? null : index;
    }
}">
    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-12 text-center">
        Questions fréquentes
    </h2>
    
    <div class="space-y-6">
        <!-- FAQ Item 1 -->
        <div class="bg-white dark:bg-gray-900 rounded-lg shadow-sm overflow-hidden">
            <button @click="toggleFaq(1)" class="w-full flex justify-between items-center p-6 text-left">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                    Puis-je annuler mon abonnement à tout moment ?
                </h3>
                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400 transition-transform duration-200" 
                     :class="{ 'rotate-180': openFaq === 1 }"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div x-show="openFaq === 1" x-collapse class="px-6 pb-6 pt-0">
                <p class="text-gray-600 dark:text-gray-300">
                    Oui, vous pouvez annuler votre abonnement Premium à tout moment depuis votre compte. Aucun frais supplémentaire ne vous sera facturé.
                </p>
            </div>
        </div>
        
        <!-- FAQ Item 2 -->
        <div class="bg-white dark:bg-gray-900 rounded-lg shadow-sm overflow-hidden">
            <button @click="toggleFaq(2)" class="w-full flex justify-between items-center p-6 text-left">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                    Comment fonctionnent les annonces mises en avant ?
                </h3>
                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400 transition-transform duration-200" 
                     :class="{ 'rotate-180': openFaq === 2 }"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div x-show="openFaq === 2" x-collapse class="px-6 pb-6 pt-0">
                <p class="text-gray-600 dark:text-gray-300">
                    Les annonces Premium apparaissent en tête des résultats de recherche avec un badge distinctif. Elles bénéficient également d'un meilleur positionnement algorithmique.
                </p>
            </div>
        </div>
        
        <!-- FAQ Item 3 -->
        <div class="bg-white dark:bg-gray-900 rounded-lg shadow-sm overflow-hidden">
            <button @click="toggleFaq(3)" class="w-full flex justify-between items-center p-6 text-left">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                    Quelles statistiques sont disponibles avec le compte Premium ?
                </h3>
                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400 transition-transform duration-200" 
                     :class="{ 'rotate-180': openFaq === 3 }"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div x-show="openFaq === 3" x-collapse class="px-6 pb-6 pt-0">
                <p class="text-gray-600 dark:text-gray-300">
                    Vous avez accès à des statistiques détaillées sur les vues de vos annonces, le taux de conversion, les périodes les plus actives, et bien plus encore.
                </p>
            </div>
        </div>
        
        <!-- FAQ Item 4 -->
        <div class="bg-white dark:bg-gray-900 rounded-lg shadow-sm overflow-hidden">
            <button @click="toggleFaq(4)" class="w-full flex justify-between items-center p-6 text-left">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                    Comment fonctionne le support prioritaire ?
                </h3>
                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400 transition-transform duration-200" 
                     :class="{ 'rotate-180': openFaq === 4 }"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div x-show="openFaq === 4" x-collapse class="px-6 pb-6 pt-0">
                <p class="text-gray-600 dark:text-gray-300">
                    Les membres Premium bénéficient d'une file d'attente prioritaire avec un temps de réponse garanti de moins de 4 heures pendant les heures d'ouverture.
                </p>
            </div>
        </div>
        
        <!-- FAQ Item 5 -->
        <div class="bg-white dark:bg-gray-900 rounded-lg shadow-sm overflow-hidden">
            <button @click="toggleFaq(5)" class="w-full flex justify-between items-center p-6 text-left">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                    Y a-t-il une période d'engagement minimum ?
                </h3>
                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400 transition-transform duration-200" 
                     :class="{ 'rotate-180': openFaq === 5 }"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div x-show="openFaq === 5" x-collapse class="px-6 pb-6 pt-0">
                <p class="text-gray-600 dark:text-gray-300">
                    Non, il n'y a aucun engagement. Vous pouvez annuler à tout moment sans frais supplémentaires.
                </p>
            </div>
        </div>
    </div>
</div>