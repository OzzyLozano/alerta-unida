<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewChatMessage implements ShouldBroadcast {
  use Dispatchable, InteractsWithSockets, SerializesModels;

  public $message;

  public function __construct(Message $message) {
    $this->message = $message;
  }

  public function broadcastOn() {
    // Canal específico para esta alerta
    return new Channel('chat.alert.' . $this->message->alert_id);
  }

  public function broadcastWith() {
    return [
      'id' => $this->message->id,
      'alert_id' => $this->message->alert_id,
      'brigade_id' => $this->message->brigade_id,
      'brigade_name' => $this->message->brigade->name . ' ' . $this->message->brigade->lastname,
      'message' => $this->message->message,
      'created_at' => $this->message->created_at->toDateTimeString(),
    ];
  }
  
  public function broadcastAs() {
    return 'NewChatMessage';
  }
}
