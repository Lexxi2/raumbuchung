<?php

namespace App\Providers;

use App\Models\Room;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

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
        // Should return TRUE or FALSE
        Gate::define('is_admin', function(User $user) {
            return $user->is_admin == true;
        });

        view()->share('all_rooms', Room::all());
    }
}
