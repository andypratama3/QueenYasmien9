<?php

namespace App\Providers;

use App\Models\Chart;
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
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $charts = Auth::check() ? Chart::where('user_id', Auth::id())->get() : collect();
            $totalPrice = $charts->sum(fn($chart) => (optional($chart->product)->price ?? 0) * ($chart->qty ?? 1));

            $view->with([
                'charts' => $charts,
                'totalPrice' => $totalPrice, // Passing total price to all views
            ]);
        });
    }
}
