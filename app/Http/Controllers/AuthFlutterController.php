<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthFlutterController extends Controller {
  public function login(Request $request) {
    $credentials = $request->only('email', 'password');
  
    if (! Auth::attempt($credentials)) {
      return response()->json([
        'status' => 'error',
        'message' => 'Credenciales incorrectas',
      ], 401);
    }
  
    $user = Auth::user();
  
    return response()->json([
      'status' => 'success',
      'user' => $user,
    ]);
  }
}
