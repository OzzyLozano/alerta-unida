<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Database;
use Illuminate\Support\Facades\Log;

class RealtimeChatService {
  protected $database;

  public function __construct(Factory $factory) {
    try {
      $this->database = $factory->createDatabase();
    } catch (\Exception $e) {
      Log::error('Error inicializando Firebase Database: ' . $e->getMessage());
      $this->database = null;
    }
  }

  /**
   * Enviar mensaje de chat para una alerta
   */
  public function sendChatMessage($alertId, $userId, $userType, $message, $userName = null) {
    if (!$this->database) return false;

    $chatRef = $this->database->getReference("alerts/{$alertId}/chat");
    
    $newMessage = $chatRef->push([
      'user_id' => $userId,
      'user_type' => $userType,
      'user_name' => $userName,
      'message' => $message,
      'timestamp' => time(),
      'created_at' => now()->toISOString()
    ]);

    return $newMessage->getKey();
  }

  /**
   * Obtener mensajes de chat de una alerta
   */
  public function getChatMessages($alertId, $limit = 50) {
    if (!$this->database) return [];

    $chatRef = $this->database->getReference("alerts/{$alertId}/chat")
      ->orderByChild('timestamp')
      ->limitToLast($limit);

    $messages = $chatRef->getValue() ?? [];
    
    // Ordenar por timestamp
    usort($messages, function($a, $b) {
      return $a['timestamp'] <=> $b['timestamp'];
    });

    return $messages;
  }

  /**
   * Actualizar estado de alerta en tiempo real
   */
  public function updateAlertStatus($alertId, $status) {
    if (!$this->database) return false;

    $this->database->getReference("alerts/{$alertId}/status")
      ->set($status);

    return true;
  }

  /**
   * Obtener estado de alerta en tiempo real
   */
  public function getAlertStatus($alertId) {
    if (!$this->database) return null;

    return $this->database->getReference("alerts/{$alertId}/status")
      ->getValue();
  }

  /**
   * Escuchar cambios en una alerta en tiempo real
   */
  public function listenToAlert($alertId, callable $callback) {
    if (!$this->database) return;

    $this->database->getReference("alerts/{$alertId}")
      ->onValueChanged(function ($snapshot) use ($callback) {
          $callback($snapshot->getValue());
      });
  }
}
