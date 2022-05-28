<?php

namespace App\Providers;

use App\Repository\EventInterface;
use App\Repository\EventRepository;
use App\Repository\UserRepository;
use App\Repository\UserInterface;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->bind(UserInterface::class, UserRepository::class);
        $this->app->bind(EventInterface::class, EventRepository::class);

        if(env('APP_ENV') !== 'local') { URL::forceScheme('https');}
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
