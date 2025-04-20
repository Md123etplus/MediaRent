
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold tracking-tight sm:text-4xl dark:text-white">Explorez nos catégories</h2>
            <p class="mt-4 text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                Découvrez une large gamme d'équipements audiovisuels disponibles à la location.
            </p>
        </div>

        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3 dark:text-white">
            <x-category-card 
                title="Caméras" 
                description="Des caméras professionnelles pour tous vos projets vidéo." 
                link="/categories/cameras"
            />
            
            <x-category-card 
                title="Drones" 
                description="Capturez des images aériennes époustouflantes avec nos drones." 
                link="/categories/drones"
            />
            
            <x-category-card 
                title="Éclairage" 
                description="Tout l'équipement d'éclairage pour vos tournages et séances photo." 
                link="/categories/lighting"
            />
        </div>

        <div class="text-center mt-10">
            <a href="/categories" class="inline-flex items-center text-primary font-medium hover:text-primary/80">
                Voir tout le matériel
                <svg class="ml-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
