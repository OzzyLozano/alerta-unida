<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MyEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function broadcastOn()
    {
        return new Channel('my-channel');
    }

    public function broadcastAs()
    {
        return 'my-event';
    }

    // AÑADE ESTO para asegurar que los datos se envíen correctamente
    public function broadcastWith()
    {
        return [
            'message' => $this->message,
            'time' => now()->toDateTimeString()
        ];
    }
    
    public function broadcastQueue()
    {
        return null; // Enviar inmediatamente
    }
}
