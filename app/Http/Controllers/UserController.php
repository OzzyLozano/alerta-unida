<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller {
  public function index() {
    $users = User::all();
    return view('admin.users.index', compact('users'));
  }

  public function create() {
    return view('admin.users.create');
  }

  public function store(Request $request) {
    try {
      $user = new User();
      $user->name = $request->name;
      $user->lastname = $request->lastname;
      $user->email = $request->email;
      $user->password = $request->password;
      $user->type = $request->type;
      $user->save();
  
      return response()->json([
        'success' => true,
        'message' => 'Usuario creado exitosamente',
        'data'    => $user,
      ], 201); 
    } catch (\Exception $exception) {
      return response()->json([
        'success' => false,
        'message' => 'Error al crear usuario',
        'error'   => $exception->getMessage(),
      ], 400);
    }
  }

  public function show(User $user) {
    //
  }

  public function edit(User $user) {
    //
  }

  public function update(Request $request, User $user) {
    //
  }

  public function destroy(User $user) {
    //
  }
}
