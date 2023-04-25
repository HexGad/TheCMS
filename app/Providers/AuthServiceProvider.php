<?php

namespace App\Providers;

 use HexGad\Permissions\Providers\PermissionsServiceProvider;
 use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::before(function ($user, string $ability) {
            //Only enable Permissions if permissions module is enabled and activated
            if(! $this->app->providerIsLoaded(PermissionsServiceProvider::class))
                return true;
        });
    }
}
