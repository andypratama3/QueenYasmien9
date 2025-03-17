<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Dashboard\RoleController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\PemesananController;
use App\Http\Controllers\Dashboard\CatalogController as DashboardCatalogController;



// Route::get('/', function () {
//     return view('beranda');
// });


Route::get('/',[HomeController::class, 'index'])->name('home');

Route::resource('catalog', CatalogController::class, ['names' => 'catalog']);


Route::group(['prefix' => '/', 'middleware' => 'auth','verified'], function () {
    Route::resource('cart', ChartController::class, ['names' => 'cart']);

    Route::get('pesanan', [PesananController::class, 'index'])->name('pesanan.index');
    Route::post('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');

});
Route::group(['prefix' => 'dashboard', 'middleware' => 'auth','verified'], function () {
// Route::group(['prefix' => 'dashboard'], function () {
    Route::get('/', DashboardController::class)->name('dashboard');

    Route::resource('category', CategoryController::class, ['names' => 'dashboard.category']);
    Route::resource('product', ProductController::class, ['names' => 'dashboard.product']);
    Route::get('products/datas', [ProductController::class, 'data_table'])->name('dashboard.products.data_table');
    Route::post('products/upload/image', [ProductController::class, 'uploadImage'])->name('dashboard.post.upload.image');


    Route::resource('catalog', DashboardCatalogController::class, ['names' => 'dashboard.catalog']);
    Route::post('catalogs/upload/image', [DashboardCatalogController::class, 'uploadImage'])->name('dashboard.catalog.upload.image');
    Route::get('catalos/datas', [DashboardCatalogController::class, 'data_table'])->name('dashboard.catalog.data_table');
    Route::resource('pemesanan', PemesananController::class, ['names' => 'dashboard.pesanan']);

    Route::group(['prefix' => 'settings'], function () {
        Route::resource('roles', RoleController::class, ['names' => 'dashboard.settings.roles']);
        Route::resource('users', UserController::class, ['names' => 'dashboard.settings.users']);

        Route::get('user/datas', [UserController::class, 'data_table'])->name('dashboard.settings.users.data_table');
        Route::get('rols/datas', [RoleController::class, 'data_table'])->name('dashboard.settings.roles.data_table');

    });

});



// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified',
// ])->group(function () {
//     Route::get('/dashboard', function () {
//         return Inertia::render('Dashboard');
//     })->name('dashboard');
// });
