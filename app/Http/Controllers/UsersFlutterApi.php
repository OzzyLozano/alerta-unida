<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersFlutterApi extends Controller {
  /**
   * Display a listing of the resource.
   */
  public function index() {
    try {
      $users = User::all();
  
      return response()->json([
        'success' => true,
        'message' => 'Usuarios obtenidos exitosamente',
        'data' => $users,
      ], 200); 
    } catch (\Exception $exception) {
      return response()->json([
        'success' => false,
        'message' => 'Error al obtener usuarios',
        'error' => $exception->getMessage(),
      ], 400);
    }
  }

  /**
   * Store a newly created resource in storage.
   */
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

  /**
   * Display the specified resource.
   */
  public function show(User $user) {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, User $user) {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(User $user) {
    //
  }
}
