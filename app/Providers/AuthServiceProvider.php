<?php
namespace App\Providers;

use App\Models\User;
use App\Models\Objet;
use App\Policies\UserPolicy;
use App\Policies\ObjetPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        User::class => UserPolicy::class,
        Objet::class => ObjetPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
        //
    }
}