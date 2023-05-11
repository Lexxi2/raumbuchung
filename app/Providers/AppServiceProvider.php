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

        // returns a collection of all the rooms in the database
        // is shared by all Views
        // is used in the Navbar
        view()->share('all_rooms', Room::all());
    }
}
