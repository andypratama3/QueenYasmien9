<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\PemesananController;



// Route::get('/', function () {
//     return view('beranda');
// });

Route::get('/',[HomeController::class, 'index'])->name('home');
Route::group(['prefix' => 'dashboard', 'middleware' => 'auth'], function () {
// Route::group(['prefix' => 'dashboard'], function () {
    Route::get('/', DashboardController::class)->name('dashboard');

    Route::resource('category', CategoryController::class, ['names' => 'dashboard.category']);
    Route::resource('product', ProductController::class, ['names' => 'dashboard.product']);
    Route::get('products/datas', [ProductController::class, 'data_table'])->name('dashboard.products.data_table');
    Route::post('products/upload/image', [ProductController::class, 'uploadImage'])->name('dashboard.post.upload.image');


    Route::resource('pemesanan', PemesananController::class, ['names' => 'dashboard.pesanan']);
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
