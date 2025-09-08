<?php

namespace App\Http\Controllers;

use App\Models\Alerts;
use App\Models\Brigade;
use App\Models\Message;
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
    \Log::info('📨 SendMessage called', $request->all());

    $request->validate([
      'alert_id' => 'required|exists:alerts,id',
      'message' => 'required|string|max:1000',
    ]);
    \Log::info('✅ Validation passed');

    $message = Message::create([
      'alert_id' => $request->alert_id,
      'brigade_id'  => $id,
      'message'  => $request->message,
    ]);
    \Log::info('📝 Message created', ['id' => $message->id]);
    
    $message->load('brigade:id,name,lastname');
    \Log::info('🔔 Dispatching NewChatMessage event');
    
    try {
      event(new NewChatMessage($message));
      \Log::info('✅ Event dispatched successfully');
    } catch (\Exception $e) {
      \Log::error('❌ Event failed: ' . $e->getMessage());
    }

    return response()->json([
      'success' => true,
      'message' => 'Mensaje enviado.',
      'data'    => $message,
    ]);
  }
}
