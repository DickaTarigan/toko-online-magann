<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Seller\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Seller\ProductController;
use Illuminate\Support\Facades\Route;

//--Route publik '/' diarahkan ke HomeController@index
Route::get('/', [HomeController::class, 'index']) -> name('home');

//--Route autentikasi (hanya untuk guest/blum login)
Route::middleware('guest')->group(function() {
     Route::get('/register', [AuthController::class, 'showRegister']) -> name('register');
     Route::post('/register', [AuthController::class, 'register']);

     Route::get('/login', [AuthController::class, 'showLogin']) -> name('login');
     Route::post('/login', [AuthController::class, 'login']);
});

//--Route yang membutuhkan login
Route::middleware('auth')->group(function() {
     Route::post('/logout', [AuthController::class, 'logout']) -> name('logout');

     Route::get('/profile', [ProfileController::class, 'show']) -> name('profile');

     // Route Khusus Seller (auth + role seller)
     Route::middleware('role:seller')->prefix('seller') -> name('seller.') -> group(function() {
          Route::get('/dashboard', [DashboardController::class, 'index']) -> name('dashboard');

                  // Resource route: otomatis buat 7 route CRUD sekaligus
          Route::resource('products', ProductController::class);

     });
});
