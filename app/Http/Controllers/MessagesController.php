<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    // Mostrar todos los mensajes ordenados cronológicamente
    public function index()
    {
        $messages = Message::orderBy('created_at', 'asc')->get();
        return view('admin.messages.index', compact('messages'));
    }

    // Mostrar formulario para crear mensaje
    public function create()
    {
        return view('admin.messages.create');
    }

    // Guardar mensaje
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', function ($attribute, $value, $fail) {
                if (!User::where('email', $value)->exists()) {
                    $fail('El correo electrónico no está registrado.');
                }
            }],
            'message' => 'required|string|max:1000',
        
        ]);

        Message::create($request->only('email', 'message'));

        return redirect()->route('admin.messages.index')
            ->with('success', 'Mensaje enviado correctamente.');
    }
}
