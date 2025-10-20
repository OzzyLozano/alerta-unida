<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BrigadeLoginController extends Controller {
  public function index() {
    return view('auth.brigade-login');
  }

  public function login(Request $request) {
    $credentials = $request->only('email', 'password');

    if (Auth::guard('brigade')->attempt($credentials)) {
      $request->session()->regenerate();
      return redirect()->intended('/admin/brigades');
    }

    return back()->withErrors([
      'email' => 'Las credenciales no coinciden.',
    ]);
  }

  public function logout(Request $request) {
    Auth::guard('brigade')->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect(route('brigade.show-login'));
  }
}
