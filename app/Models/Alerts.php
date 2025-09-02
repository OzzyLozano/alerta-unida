<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alerts extends Model {
  protected $fillable = [
    'brigade_id',
    'title',
    'content',
    'type',
    'status',
    'simulacrum',
  ];

  public function brigade() {
    return $this->belongsTo(Brigade::class);
  }
  public function messages() {
    return $this->hasMany(Message::class, 'alert_id');
  }
  
  protected static function booted() {
    static::created(function ($alert) {
      // Solo enviar notificación si la alerta está activa
      if ($alert->status === 'active') {
        $notificationService = new \App\Services\NotificationService();
        $notificationService->sendToAll(
          '🚨 ' . $alert->title,
          $alert->content, [
            'alert_id' => $alert->id,
            'type' => $alert->type,
            'status' => $alert->status,
            'action' => 'view_alert'
          ]
        );
      }
    });
  }
}
