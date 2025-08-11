<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\AlertsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BrigadeController;
use App\Http\Controllers\SimulacrumController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\MessagesController;

use App\Http\Controllers\AlertsFlutterApi;
use App\Http\Controllers\BrigadesFlutterApi;
use App\Http\Controllers\UsersFlutterApi;
use App\Http\Controllers\ReportsFlutterController;

use App\Http\Controllers\BrigadeLoginController;
use App\Http\Controllers\AuthFlutterController;
use Illuminate\Support\Facades\Route;

// Route::domain(env('APP_URL'))->group(function() {
  Route::get('/', function () {
    return view('welcome');
  });

  Route::post('/flutter/login', [AuthFlutterController::class, 'login']);
  Route::post('/flutter/brigade-login', [AuthFlutterController::class, 'brigade_login']);

  Route::get('/admin', function () {
    return view('admin.index');
  });
  
  Route::prefix('admin')
  ->name('admin.')
  ->group(function() {
    Route::resource('alerts', AlertsController::class);
    Route::resource('controller', ApiController::class);
    Route::resource('users', UserController::class);
    Route::resource('brigades', BrigadeController::class);
    Route::resource('simulacrums', SimulacrumController::class);
    Route::resource('reports', ReportsController::class);
    Route::resource('messages', MessagesController::class);
  });
  



  Route::get('/api', function () {
    return view('api.test');
  });
  
  Route::prefix('api')
  ->name('api.')
  ->group(function() {
    // active alerts for flutter app
    Route::get('/alerts/active', [App\Http\Controllers\AlertsFlutterApi::class, 'getActiveAlerts']);
    // on wait reports
    Route::get('/reports/on-wait', [App\Http\Controllers\ReportsFlutterController::class, 'getOnWaitReports']);
    // authorize/cancel reports
    Route::put('/reports/{id}/authorize', [ReportsFlutterController::class, 'authorizeReport']);
    Route::put('/reports/{id}/cancel', [ReportsFlutterController::class, 'cancelReport']);
    Route::post('/reports/send-report/', [ReportsFlutterController::class, 'sendReport']);
    
    Route::apiResources([
      '/alerts' => AlertsFlutterApi::class,
      '/brigades' => BrigadesFlutterApi::class,
      '/users' => UsersFlutterApi::class,
    ]);
  });
  
  Route::get('/dashboard', function () {
    return view('dashboard');
  })->middleware(['auth', 'verified'])->name('dashboard');


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
