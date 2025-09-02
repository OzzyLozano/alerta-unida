<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Kreait\Firebase\Factory;
use App\Services\NotificationService;
use App\Services\RealtimeChatService;

class FirebaseServiceProvider extends ServiceProvider {
  /**
   * Register services.
   */
  public function register(): void {
    // Registrar Firebase Factory como singleton
    // $this->app->singleton(Factory::class, function ($app) {
      // return (new Factory)->withServiceStorage(base_path('firebase_credentials.json'));
    // });

    $this->app->singleton(Factory::class, function ($app) {
        return (new Factory)->withServiceAccount(base_path('firebase_credentials.json'));
    });

    // Registrar Notification Service
    $this->app->singleton(NotificationService::class, function ($app) {
      $factory = $app->make(Factory::class);
      return new NotificationService($factory);
    });

    // Registrar Realtime Service (para chat)
    $this->app->singleton(RealtimeChatService::class, function ($app) {
      $factory = $app->make(Factory::class);
      return new RealtimeChatService($factory);
    });
  }

  /**
   * Bootstrap services.
   */
  public function boot(): void {
    //
  }
}
