<!-- resources/views/processus-simple.blade.php -->


        <!-- Title -->
        <h2 class="text-3xl md:text-4xl font-bold text-center mb-12 text-gray-800">
            Comment ça marche
        </h2>
        
        <p class="text-xl text-center text-gray-600 mb-16">
            Louer ou proposer du matériel audiovisuel n'a jamais été aussi simple.
        </p>
        
        <!-- Steps -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Step 1 -->
            <div class="flex flex-col items-center text-center p-6 rounded-lg bg-gray-50 hover:bg-gray-100 transition">
                <div class="w-16 h-16 rounded-full bg-blue-500 flex items-center justify-center text-white text-2xl font-bold mb-4">
                    1
                </div>
                <h3 class="text-xl font-semibold mb-3 text-gray-800">Créez votre compte</h3>
                <p class="text-gray-600">
                    Inscrivez-vous gratuitement en quelques clics et complétez votre profil pour commencer.
                </p>
            </div>
            
            <!-- Step 2 -->
            <div class="flex flex-col items-center text-center p-6 rounded-lg bg-gray-50 hover:bg-gray-100 transition">
                <div class="w-16 h-16 rounded-full bg-blue-500 flex items-center justify-center text-white text-2xl font-bold mb-4">
                    2
                </div>
                <h3 class="text-xl font-semibold mb-3 text-gray-800">Trouvez ou proposez du matériel</h3>
                <p class="text-gray-600">
                    Parcourez les annonces ou publiez votre matériel avec photos et description détaillée.
                </p>
            </div>
            
            <!-- Step 3 -->
            <div class="flex flex-col items-center text-center p-6 rounded-lg bg-gray-50 hover:bg-gray-100 transition">
                <div class="w-16 h-16 rounded-full bg-blue-500 flex items-center justify-center text-white text-2xl font-bold mb-4">
                    3
                </div>
                <h3 class="text-xl font-semibold mb-3 text-gray-800">Réservez et profitez</h3>
                <p class="text-gray-600">
                    Effectuez votre réservation, récupérez le matériel et réalisez vos projets créatifs.
                </p>
            </div>
        </div>
        
        <!-- CTA Button -->
        <div class="text-center mt-16">
            <a href="/register" class="inline-block px-8 py-4 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-600 transition duration-300">
                Commencer maintenant
            </a>
        </div>
