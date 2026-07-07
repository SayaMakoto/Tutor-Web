<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
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
    public function boot()
    {
        Paginator::useTailwind();

        // Inject $layout dynamically based on the authenticated user's role.
        // Views should use @extends($layout) so that 'both' users
        // automatically see their own dedicated layout.
        View::composer('*', function ($view) {
            $layout = 'layouts.student'; // default

            if (Auth::check()) {
                $layout = match (Auth::user()->role) {
                    'tutor'  => 'layouts.tutor',
                    'both'   => 'layouts.both',
                    default  => 'layouts.student',
                };
            }

            $view->with('layout', $layout);
        });
    }
}