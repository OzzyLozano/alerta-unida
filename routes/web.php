<?php

use Illuminate\Support\Facades\Route;

// controllers
// web
use App\Http\Controllers\Web\AlertsController;
use App\Http\Controllers\Web\BrigadeController;
use App\Http\Controllers\Web\BrigadeLoginController;
use App\Http\Controllers\Web\MessagesController;
use App\Http\Controllers\Web\ReportsController;
use App\Http\Controllers\Web\SimulacrumController;
use App\Http\Controllers\Web\UserController;

// map
use App\Http\Controllers\Map\EquipmentController;
use App\Http\Controllers\Map\GateController;
use App\Http\Controllers\Map\BuildingController;
use App\Http\Controllers\Map\MeetingPointController;
use App\Http\Controllers\Map\FloorController;

// flutter
use App\Http\Controllers\Flutter\AlertsFlutterApi;
use App\Http\Controllers\Flutter\AuthFlutterController;
use App\Http\Controllers\Flutter\BrigadesFlutterApi;
use App\Http\Controllers\Flutter\CheckinFlutterApi;
use App\Http\Controllers\Flutter\FcmController;
use App\Http\Controllers\Flutter\MessagesFlutterController;
use App\Http\Controllers\Flutter\ReportsFlutterController;
use App\Http\Controllers\Flutter\UsersFlutterApi;

// other
// use App\Http\Controllers\ProfileController;

// rutas
// inicio
Route::get('/', function () {
  return view('welcome');
});

// administracion
Route::prefix('admin')
->name('admin.')
->group(function() {
  Route::get('/', function () { return view('admin.index'); })->name('index');
  Route::resource('alerts', AlertsController::class);
  Route::resource('users', UserController::class);
  Route::resource('brigades', BrigadeController::class);
  Route::resource('simulacrums', SimulacrumController::class);
  Route::resource('reports', ReportsController::class);
  Route::resource('messages', MessagesController::class);

  // alerts content
  Route::get('alerts/{alert}/chat', [AlertsController::class, 'chat'])->name('alerts.chat');
  Route::get('alerts/{alert}/check-in', [AlertsController::class, 'checkIn'])->name('alerts.checkin');

  // FCM
  Route::get('fcm', [FcmController::class, 'index'])->name('fcm.index');
  Route::delete('fcm/delete/{id}', [FcmController::class, 'destroy'])->name('fcm.destroy');

  // map databasee management
  Route::prefix('map')->name('map.')->group(function() {
    Route::get('/', function () {
      return view('admin.map.index');
    })->name('index');
    Route::resource('equipment', EquipmentController::class);
    Route::resource('gate', GateController::class);
    Route::resource('building', BuildingController::class);
    Route::resource('meeting-point', MeetingPointController::class);

    // floor
    Route::prefix('building/{building}/floors')->name('floor.')->group(function () {
      // CRUD
      Route::get('/create', [FloorController::class, 'create'])->name('create');
      Route::post('/', [FloorController::class, 'store'])->name('store');

      Route::get('/{id}', [FloorController::class, 'show'])->name('show');

      Route::get('/{id}/edit', [FloorController::class, 'edit'])->name('edit');
      Route::put('/{id}', [FloorController::class, 'update'])->name('update');
      
      Route::delete('/{id}', [FloorController::class, 'destroy'])->name('destroy');

      // equipment
      Route::get('/{id}/equipment/create', [FloorController::class, 'addEquipment'])->name('add.equipment');
      Route::post('/{id}/submit-equipment', [FloorController::class, 'submitEquipment'])->name('submit.equipment');
    });

    // custom
    Route::get('/gate/{id}/add-equipment', [GateController::class, 'addEquipment'])->name('gate.add.equipment');
    Route::post('/gate/{id}/submit-equipment', [GateController::class, 'submitEquipment'])->name('gate.submit.equipment');
  });
});

// flutter
Route::post('/flutter/login', [AuthFlutterController::class, 'login']);
Route::post('/flutter/brigade-login', [AuthFlutterController::class, 'brigadeLogin']);

Route::prefix('api')
->name('api.')
->group(function() {
  // active alerts
  Route::get('/alerts/active', [AlertsFlutterApi::class, 'getActiveAlerts']);
  Route::get('alerts/{id}/chat', [MessagesFlutterController::class, 'chatJson']);

  // reports
  Route::get('/reports/on-wait', [ReportsFlutterController::class, 'getOnWaitReports']);
  Route::get('/reports/{id}/show', [AlertsFlutterApi::class, 'show']);
  Route::put('/reports/{id}/authorize', [ReportsFlutterController::class, 'authorizeReport']);
  Route::put('/reports/{id}/cancel', [ReportsFlutterController::class, 'cancelReport']);
  Route::post('/reports/send-report/', [ReportsFlutterController::class, 'sendReport']);
  
  // send messages flutter
  Route::post('messages/send/{id}', [MessagesFlutterController::class, 'sendMessage']);
  // get user data
  Route::get('users/get-data/{id}', [UsersFlutterApi::class, 'getUser']);
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

// Route::get('/brigade/login', [BrigadeLoginController::class, 'index'])->name('brigade.show-login');
// Route::post('/brigade/login', [BrigadeLoginController::class, 'login'])->name('brigade.login');
// Route::post('/brigade/logout', [BrigadeLoginController::class, 'logout'])->name('brigade.logout');

Route::middleware('auth')->group(function () {
  // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
