<?php

namespace App\Providers;

use App\Models\Chart;
use App\Models\ProductReseller;
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

            $totalPrice = $charts->sum(function ($chart) {
                $product = $chart->product;
                $price = $product->price ?? 0;

                // Jika harga produk 0, cari harga dari product_resellers
                if ($price == 0) {
                    $resellerPrice = ProductReseller::where('product_id', $product->id)->value('price_reseller');
                    $price = $resellerPrice ?? 0; // Gunakan harga reseller jika ada
                }

                return (float) $price * ($chart->qty ?? 1);
            });

            $view->with([
                'charts' => $charts,
                'totalPrice' => $totalPrice, // Passing total price to all views
            ]);
        });

    }
}
