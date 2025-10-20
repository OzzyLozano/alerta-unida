<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Alerts\Message;
use App\Models\UserType\User;
use Illuminate\Http\Request;

class MessagesController extends Controller {
  // Mostrar todos los mensajes ordenados cronológicamente
  public function index() {
    $messages = Message::orderBy('created_at', 'asc')->get();
    return view('admin.messages.index', compact('messages'));
  }

  // Mostrar formulario para crear mensaje
  public function create() {
    return view('admin.messages.create');
  }

  // Guardar mensaje
  public function store(Request $request) {
    $request->validate([
      'brigade_id' => 'required|exists:brigade,id',
      'alert_id' => 'required|exists:alerts,id',
      'message' => 'required|string|max:1000',
    ]);

    Message::create($request->only('brigade_id', 'alert_id', 'message'));

    return redirect()->back()->with('success', 'Mensaje enviado correctamente.');
  }
}
