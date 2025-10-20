<?php

namespace App\Http\Controllers\Flutter;

use App\Http\Controllers\Controller;
use App\Models\Alerts\Alerts;
use App\Models\UserType\Brigade;
use App\Models\Alerts\Message;
use Illuminate\Http\Request;
use App\Events\NewChatMessage;

class MessagesFlutterController extends Controller {
  public function chatJson($id) {
    $alert = Alerts::with([
      'messages.brigade:id,name,lastname'
    ])->findOrFail($id);

    return response()->json([
      'id' => $alert->id,
      'title' => $alert->title,
      'content' => $alert->content,
      'messages' => $alert->messages->map(function ($msg) {
        return [
          'id' => $msg->id,
          'brigade_id' => $msg->brigade_id,
          'brigade_name' => $msg->brigade->name . ' ' . $msg->brigade->lastname,
          'message' => $msg->message,
          'created_at' => $msg->created_at->toDateTimeString(),
        ];
      }),
    ]);
  }

  public function sendMessage(Request $request, $id) {
    $request->validate([
      'alert_id' => 'required|exists:alerts,id',
      'message' => 'required|string|max:1000',
    ]);

    $message = Message::create([
      'alert_id' => $request->alert_id,
      'brigade_id'  => $id,
      'message'  => $request->message,
    ]);
    
    $message->load('brigade:id,name,lastname');
    
    try {
      event(new NewChatMessage($message));
    } catch (\Exception $e) {
      \Log::error('Event failed: ' . $e->getMessage());
    }

    return response()->json([
      'success' => true,
      'message' => 'Mensaje enviado.',
      'data'    => $message,
    ]);
  }
}
