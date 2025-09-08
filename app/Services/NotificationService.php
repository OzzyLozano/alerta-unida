<?php

namespace App\Services;

use App\Models\FcmToken;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Illuminate\Support\Facades\Log;

class NotificationService {
  /**
   * Create a new class instance.
   */
  protected $messaging;

  public function __construct() {
    try {
      // $factory = (new Factory)->withServiceStorage(base_path('firebase_credentials.json'));
      $factory = (new Factory)->withServiceAccount(base_path('firebase_credentials.json'));
      $this->messaging = $factory->createMessaging();
    } catch (\Exception $e) {
      Log::error('Error inicializando Firebase: ' . $e->getMessage());
      $this->messaging = null;
    }
  }

  public function sendToAll($title, $body, $data = []) {
    if (!$this->messaging) {
      Log::error('Firebase Messaging no inicializado');
      return false;
    }

    try {
      $tokens = FcmToken::whereNotNull('token')
        ->pluck('token')
        ->toArray();

      if (empty($tokens)) {
        Log::info('No hay tokens FCM registrados');
        return false;
      }

      $message = CloudMessage::new()
        ->withNotification(Notification::create($title, $body))
        ->withData(array_merge($data, [
          'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
          'type' => 'alert'
        ]));
      
      $sendReport = $this->messaging->sendMulticast($message, $tokens);
      
      Log::info('Notificación enviada a ' . count($tokens) . ' dispositivos');
      
      return $sendReport;
      
    } catch (\Exception $e) {
      Log::error('Error enviando notificación FCM: ' . $e->getMessage());
      return false;
    }
  }
}
