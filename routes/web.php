<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\AlertsController;
use App\Http\Controllers\AlertsFlutterApi;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BrigadeController;
use App\Http\Controllers\BrigadeLoginController;
use Illuminate\Support\Facades\Route;

Route::domain(env('APP_URL'))->group(function() {
  Route::get('/', function () {
    return view('welcome');
  });
  Route::get('/admin', function () {
    return view('admin.test');
  });
  
  Route::prefix('admin')
  ->name('admin.')
  ->group(function() {
    Route::resource('alerts', AlertsController::class);
    Route::resource('controller', ApiController::class);
    Route::resource('users', UserController::class);
    Route::resource('brigades', BrigadeController::class);
  });

  Route::get('/api', function () {
    return view('api.test');
  });
  
  Route::prefix('api')
  ->name('api.')
  ->group(function() {
    Route::apiResources([
      '/api/alerts' => AlertsFlutterApi::class,
    ]);
  });
  
  Route::get('/dashboard', function () {
    return view('dashboard');
  })->middleware(['auth', 'verified'])->name('dashboard');
});

Route::domain('api.' . env('APP_URL'))->group(function() {
  Route::get('/', function () {
    return view('api.test');
  });
});

Route::get('/brigade/login', [BrigadeLoginController::class, 'index'])->name('brigade.show-login');
Route::post('/brigade/login', [BrigadeLoginController::class, 'login'])->name('brigade.login');
Route::post('/brigade/logout', [BrigadeLoginController::class, 'logout'])->name('brigade.logout');

Route::middleware('auth')->group(function () {
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
