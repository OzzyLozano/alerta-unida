<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AlertsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BrigadeController;
use App\Http\Controllers\SimulacrumController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\FcmController;
use App\Http\Controllers\EquipmentController;

use App\Http\Controllers\AlertsFlutterApi;
use App\Http\Controllers\BrigadesFlutterApi;
use App\Http\Controllers\UsersFlutterApi;
use App\Http\Controllers\ReportsFlutterController;
use App\Http\Controllers\CheckinFlutterApi;
use App\Http\Controllers\MessagesFlutterController;

use App\Http\Controllers\BrigadeLoginController;
use App\Http\Controllers\AuthFlutterController;
use Illuminate\Support\Facades\Route;

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
  Route::resource('users', UserController::class);
  Route::resource('brigades', BrigadeController::class);
  Route::resource('simulacrums', SimulacrumController::class);
  Route::resource('reports', ReportsController::class);
  Route::resource('messages', MessagesController::class);

  // customs
  Route::get('alerts/{alert}/chat', [AlertsController::class, 'chat'])->name('alerts.chat');
  Route::get('fcm', [FcmController::class, 'index'])->name('fcm.index');
  Route::delete('fcm/delete/{id}', [FcmController::class, 'destroy'])->name('fcm.destroy');
  Route::get('alerts/{alert}/check-in', [AlertsController::class, 'checkIn'])->name('alerts.checkin');

  // map databasee management
  Route::prefix('map')->name('map.')->group(function() {
    Route::get('/', function () {
      return view('admin.map.index');
    })->name('index');
    Route::resource('equipment', EquipmentController::class);
  });
});

Route::get('/api', function () {
  return view('api.test');
});

Route::prefix('api')
->name('api.')
->group(function() {
  // active alerts
  Route::get('/alerts/active', [AlertsFlutterApi::class, 'getActiveAlerts']);
  // on wait reports
  Route::get('/reports/on-wait', [ReportsFlutterController::class, 'getOnWaitReports']);
  // show reports
  Route::get('/reports/{id}/show', [AlertsFlutterApi::class, 'show']);
  // authorize/cancel/send reports
  Route::put('/reports/{id}/authorize', [ReportsFlutterController::class, 'authorizeReport']);
  Route::put('/reports/{id}/cancel', [ReportsFlutterController::class, 'cancelReport']);
  Route::post('/reports/send-report/', [ReportsFlutterController::class, 'sendReport']);
  // get chat from an alert
  Route::get('alerts/{id}/chat', [MessagesFlutterController::class, 'chatJson']);
  // send messages flutter
  Route::post('messages/send/{id}', [MessagesFlutterController::class, 'sendMessage']);
  // get user
  Route::get('users/get-data/{id}', [UsersFlutterApi::class, 'getUser']);
  // get brigade
  Route::get('brigades/get-data/{id}', [BrigadesFlutterApi::class, 'getBrigadeMember']);
  
  // FCM tokens
  Route::post('/fcm/token', [FcmController::class, 'storeToken']);
  Route::post('/fcm/refresh-token', [FcmController::class, 'refreshToken']);
  Route::delete('/fcm/token', [FcmController::class, 'removeToken']);
  
  // Check In
  Route::post('/alerts/{alert}/check-in/{user}', [CheckinFlutterApi::class, 'checkIn']);
  
  Route::apiResources([
    '/alerts' => AlertsFlutterApi::class,
    '/brigades' => BrigadesFlutterApi::class,
    '/users' => UsersFlutterApi::class,
  ]);
});

Route::get('/dashboard', function () {
  return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/brigade/login', [BrigadeLoginController::class, 'index'])->name('brigade.show-login');
Route::post('/brigade/login', [BrigadeLoginController::class, 'login'])->name('brigade.login');
Route::post('/brigade/logout', [BrigadeLoginController::class, 'logout'])->name('brigade.logout');

Route::middleware('auth')->group(function () {
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
