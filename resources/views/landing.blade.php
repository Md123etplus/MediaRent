@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <section class="relative overflow-hidden bg-gradient-to-b from-white to-blue-50 dark:from-gray-900 dark:to-gray-800 py-12 md:py-24 lg:py-32">
        @include('landing.hero')
    </section>

    <!-- Comment ça marche Section -->
    <section id="how-it-works" class="py-16 bg-white dark:bg-gray-900">
        
            @include('landing.comment-ca-marche')
       
    </section>

   <!-- how it works-->
    <section class="bg-white dark:bg-gray-900 py-12 md:py-24 lg:py-32">
        @include('landing.how-it-works')
    </section>
    <!-- categories Section -->
    <!-- Categories Section -->
<section id="categories" class="bg-white dark:bg-gray-900 py-12 md:py-24 lg:py-32">
    <div class="container px-4 md:px-6 mx-auto">  <!-- Added mx-auto here -->
       @include('landing.categories')
    </div>
</section>
    <!-- Pricing Section -->

    <section id="pricing" class="bg-white dark:bg-gray-900 py-12 md:py-24 lg:py-32">
        <div class="container px-4 md:px-6 mx-auto">
            @include('landing.pricing')
        </div>
    </section>
    <!-- Features Section -->
    <section id="features" class="bg-gray-50 dark:bg-gray-800 py-12 md:py-24 lg:py-32">
        <div class="container px-4 md:px-6 mx-auto">
            <!-- Contenu features -->
            @include('landing.features')
        </div>
    </section>
@endsection