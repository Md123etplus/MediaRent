<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Livewire\Livewire; // Ensure Livewire is installed via Composer
use App\Http\Livewire\NewsletterSubscription;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
  

    public function boot(): void
    {
        Schema::defaultStringLength(191); // Définit la longueur par défaut des chaînes
       // Livewire::component('newsletter-subscription', NewsletterSubscription::class);
    
}

    }