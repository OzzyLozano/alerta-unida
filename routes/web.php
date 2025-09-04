<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\AlertsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BrigadeController;
use App\Http\Controllers\SimulacrumController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\FcmController;

use App\Http\Controllers\AlertsFlutterApi;
use App\Http\Controllers\BrigadesFlutterApi;
use App\Http\Controllers\UsersFlutterApi;
use App\Http\Controllers\ReportsFlutterController;
use App\Http\Controllers\MessagesFlutterController;

use App\Http\Controllers\BrigadeLoginController;
use App\Http\Controllers\AuthFlutterController;
use Illuminate\Support\Facades\Route;

// Route::domain(env('APP_URL'))->group(function() {
  Route::get('/', function () {
    return view('welcome');
  });
//   Route::get('/chat', function() {
//     return view('chat');
//   });
//   use App\Events\MyEvent;

// Route::get('/test-pusher', function () {
//     // Usar config() en lugar de env()
//     $config = [
//         'PUSHER_APP_KEY' => config('broadcasting.connections.pusher.key'),
//         'PUSHER_APP_CLUSTER' => config('broadcasting.connections.pusher.options.cluster'),
//         'PUSHER_APP_ID' => config('broadcasting.connections.pusher.app_id'),
//         'PUSHER_APP_SECRET' => config('broadcasting.connections.pusher.secret'),
//     ];
    
//     dump($config);
    
//     // Enviar evento de prueba
//     try {
//         event(new MyEvent('Mensaje de prueba desde Laravel ' . now()));
//         dump('Evento enviado exitosamente');
//     } catch (\Exception $e) {
//         dump('Error al enviar evento: ' . $e->getMessage());
//     }
    
//     return "Revisa la consola de PHP para ver los detalles";
// });

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
    Route::get('alerts/{alert}/chat', [AlertsController::class, 'chat'])->name('alerts.chat');
    Route::get('fcm', [FcmController::class, 'index'])->name('fcm.index');
    Route::delete('fcm/delete/{id}', [FcmController::class, 'destroy'])->name('fcm.destroy');
  });

  Route::get('/api', function () {
    return view('api.test');
  });
  
  // flutter app api
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
    
    // FCM tokens
    Route::post('/fcm/token', [FcmController::class, 'storeToken']);
    Route::post('/fcm/refresh-token', [FcmController::class, 'refreshToken']);
    Route::delete('/fcm/token', [FcmController::class, 'removeToken']);

    Route::apiResources([
      '/alerts' => AlertsFlutterApi::class,
      '/brigades' => BrigadesFlutterApi::class,
      '/users' => UsersFlutterApi::class,
    ]);
  });
  
  Route::get('/dashboard', function () {
    return view('dashboard');
  })->middleware(['auth', 'verified'])->name('dashboard');
// }

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
