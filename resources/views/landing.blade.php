<x-layouts.app>
    @include('landing.hero')
    @include('landing.features')
    @include('landing.categories')
    @include('landing.pricing')
    
    <!-- CTA Section -->
    <section class="bg-blue-600 py-12 md:py-24">
        <div class="container px-4 md:px-6">
            <div class="text-center">
                <h2 class="text-3xl font-bold text-white sm:text-4xl md:text-5xl">
                    Prêt à louer ou proposer du matériel ?
                </h2>
                <div class="mt-6 flex justify-center gap-4">
                    <a href="/register" class="px-6 py-3 bg-white text-blue-600 rounded-md font-medium hover:bg-gray-100">
                        S'inscrire gratuitement
                    </a>
                    <a href="#how-it-works" class="px-6 py-3 border border-white text-white rounded-md font-medium hover:bg-white/10">
                        En savoir plus
                    </a>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>