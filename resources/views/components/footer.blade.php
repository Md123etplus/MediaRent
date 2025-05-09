<footer class="bg-gray-900 text-gray-300 pt-16 pb-8">
    <div class="container mx-auto px-4 md:px-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
            <!-- Logo et description -->
            <div class="md:col-span-1">
                <div class="flex items-center gap-2">
                    <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span class="text-xl font-bold text-white">MediaRent</span>
                </div>
                <p class="mt-2">
                    La plateforme de location de matériel audiovisuel entre professionnels et particuliers.
                </p>
            </div>

            <!-- Colonne Matériel -->
            <div>
                <h3 class="text-lg font-semibold text-white mb-4">Matériel</h3>
                <ul class="space-y-2">
                    <li><a href="#" class="hover:text-white transition">Caméras</a></li>
                    <li><a href="#" class="hover:text-white transition">Drones</a></li>
                    <li><a href="#" class="hover:text-white transition">Éclairage</a></li>
                    <li><a href="#" class="hover:text-white transition">Audio</a></li>
                    <li><a href="#" class="hover:text-white transition">Accessoires</a></li>
                </ul>
            </div>

            <!-- Colonne Informations -->
            <div>
                <h3 class="text-lg font-semibold text-white mb-4">Informations</h3>
                <ul class="space-y-2">
                    <li><a href="#how-it-works" class="hover:text-white transition">Comment ça marche</a></li>
                    <li><a href="#pricing" class="hover:text-white transition">Tarifs</a></li>
                    <li><a href="#" class="hover:text-white transition">FAQ</a></li>
                    <li><a href="/blog" class="hover:text-white transition">Blog</a></li>
                    <li><a href="#" class="hover:text-white transition">Témoignages</a></li>
                </ul>
            </div>

            <!-- Colonne Légal + Contact -->
            <div>
                <h3 class="text-lg font-semibold text-white mb-4">Légal</h3>
                <ul class="space-y-2 mb-6">
                    <li><a href="#" class="hover:text-white transition">Conditions d'utilisation</a></li>
                    <li><a href="#" class="hover:text-white transition">Politique de confidentialité</a></li>
                    <li><a href="#" class="hover:text-white transition">Mentions légales</a></li>
                    <li><a href="#" class="hover:text-white transition">Cookies</a></li>
                </ul>

                <h3 class="text-lg font-semibold text-white mb-4">Contact</h3>
                <address class="not-italic space-y-2">
                    <div><span class="font-medium">Support :</span></div>
                    <div><a href="mailto:contact@mediarent.fr" class="hover:text-white transition">contact@mediarent.ma</a></div>
                    <div><a href="tel:+33123456789" class="hover:text-white transition">07 71 xx xx xx</a></div>
                    <div>03 Avenue de l'audiovisuel<br>93000 Tetouan, Maroc</div>
                </address>
            </div>
        </div>

        <!-- À propos et Formulaire de contact côte à côte -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 border-t border-gray-800 pt-8 mb-8">
            <!-- Section À propos -->
            <div id="about">
                <h3 class="text-lg font-semibold text-white mb-4">À propos de MediaRent</h3>
                <p class="mb-4">
                    MediaRent est une plateforme innovante qui connecte les professionnels et les particuliers pour la location de matériel audiovisuel. Notre mission est de rendre accessible à tous du matériel de qualité, tout en permettant aux propriétaires de rentabiliser leur équipement.
                </p>
                <p>
                    Fondée en 2025 par une équipe passionnée d'audiovisuel et de technologie, MediaRent s'engage à offrir une expérience utilisateur exceptionnelle et un service client de qualité.
                </p>
            </div>

            <!-- Formulaire de contact -->
            <div>
                <h3 class="text-lg font-semibold text-white mb-6">Envoyez-nous un message</h3>
                @livewire('contact-form')
            </div>
        </div>

        <!-- Copyright -->
        <div class="border-t border-gray-800 pt-8 text-center">
            <p>© 2025 MediaRent. Tous droits réservés.</p>
        </div>
    </div>
</footer>