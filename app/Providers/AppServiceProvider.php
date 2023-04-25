<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

//use App\Extend\Modules\FileRepository;
//use Nwidart\Modules\Contracts\RepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //$this->app->bind(RepositoryInterface::class, FileRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

    }
}
