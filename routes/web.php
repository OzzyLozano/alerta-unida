<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\AlertsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BrigadeController;
use Illuminate\Support\Facades\Route;

Route::domain(env('APP_URL'))->group(function() {
  Route::get('/', function () {
    return view('welcome');
  });
  Route::get('/apis', function () {
    return view('api.test');
  });
  Route::resource('/apis/controller', ApiController::class);
  Route::resource('/apis/alerts', AlertsController::class);
  Route::resource('/apis/users', UserController::class);
  Route::resource('/apis/brigades', BrigadeController::class);
  
  Route::get('/email/verify', function () {
    return view('auth.verify-email');
  })->middleware('auth')->name('verification.notice');
  
  Route::get('/dashboard', function () {
    return view('dashboard');
  })->middleware(['auth', 'verified'])->name('dashboard');
});

Route::domain('api.' . env('APP_URL'))->group(function() {
  Route::get('/', function () {
    return view('api.test');
  });
  Route::get('/hello', function () {
    return 'hello';
  });
});

Route::middleware('auth')->group(function () {
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
