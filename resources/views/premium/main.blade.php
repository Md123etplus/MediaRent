@extends('layouts.app')
@section('content')
<!-- Hero Section -->
<section class="relative overflow-hidden bg-gradient-to-b from-white to-blue-50 dark:from-gray-900 dark:to-gray-800 py-12 md:py-24 lg:py-32">
    <div class="container mx-auto px-4 md:px-6">
        @include('premium.components.hero')
    </div>
</section>
  <!-- Priority Ads Section -->
  <section class="py-16 bg-white dark:bg-gray-900">
    <div class="container mx-auto px-4 md:px-6">
        @include('premium.components.priority-ads')
    </div>
</section>
    <!-- Premium Features Section -->
    <section id="features" class="bg-gray-50 dark:bg-gray-800 py-16">
        <div class="container mx-auto px-4 md:px-6">
            @include('premium.components.premium-features')
        </div>
    </section>
      <!-- CTA Section -->
      <section class="py-16 bg-white dark:bg-gray-900">
        <div class="container mx-auto px-4 md:px-6">
            @include('premium.components.cta')
        </div>
    </section>
 <!-- FAQ Section -->
 <section id="faq" class="py-16 bg-gray-50 dark:bg-gray-800">
    <div class="container mx-auto px-4 md:px-6">
        @include('premium.components.faq')
    </div>
</section>


@endsection