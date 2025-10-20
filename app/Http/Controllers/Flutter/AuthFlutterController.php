<?php

namespace App\Http\Controllers\Flutter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserType\User;
use App\Models\UserType\Brigade;

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

  public function brigadeLogin(Request $request) {
    $credentials = $request->only('email', 'password');
  
    if (! Auth::guard('brigade')->attempt($credentials)) {
      return response()->json([
        'status' => 'error',
        'message' => 'Credenciales incorrectas',
      ], 401);
    }

    $request->session()->regenerate();
    $brigade_member = Auth::guard('brigade')->user();

    return response()->json([
      'status' => 'success',
      'brigade_user' => $brigade_member,
    ]);
  }
}
