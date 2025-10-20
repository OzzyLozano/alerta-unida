<?php

namespace App\Http\Controllers\Flutter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FcmToken;
use Illuminate\Support\Facades\Validator;

class FcmController extends Controller {
  public function index() {
    $tokens = FcmToken::with(['user', 'brigade'])
              ->orderBy('created_at', 'desc')
              ->get();
    return view('admin.fcm.index', compact('tokens'));
  }

  public function storeToken(Request $request) {
    $validator = Validator::make($request->all(), [
      'token' => 'required|string',
      'device_id' => 'required|string',
      'user_type' => 'required|in:user,brigade',
      'user_id' => 'required|integer'
    ]);

    if ($validator->fails()) {
      return response()->json(['error' => $validator->errors()], 400);
    }

    try {
      $data = [
        'token' => $request->token,
        'device_id' => $request->device_id,
        'platform' => $request->header('User-Agent', 'unknown')
      ];

      if ($request->user_type === 'user') {
        $data['user_id'] = $request->user_id;
      } else {
        $data['brigade_id'] = $request->user_id;
      }

      // Actualizar o crear el token
      FcmToken::updateOrCreate(
        ['device_id' => $request->device_id],
        $data
      );

      return response()->json(['message' => 'Token almacenado exitosamente']);
    } catch (\Exception $e) {
      return response()->json(['error' => 'Error al almacenar el token'], 500);
    }
  }
  
  public function refreshToken(Request $request) {
    $validator = Validator::make($request->all(), [
      'device_id' => 'required|string',
      'user_type' => 'required|in:user,brigade',
      'user_id' => 'required|integer'
    ]);

    if ($validator->fails()) {
      return response()->json(['error' => $validator->errors()], 400);
    }

    try {
      $token = FcmToken::where('device_id', $request->device_id)->first();

      if ($token) {
        if ($request->user_type === 'user') {
          $token->user_id = $request->user_id;
          $token->brigade_id = null;
        } else {
          $token->brigade_id = $request->user_id;
          $token->user_id = null;
        }
        
        $token->save();
        
        return response()->json(['message' => 'Relación token actualizada']);
      }
      return response()->json(['error' => 'Token no encontrado'], 404);
    } catch (\Exception $e) {
      return response()->json(['error' => 'Error actualizando token'], 500);
    }
  }

  public function removeToken(Request $request) {
    $validator = Validator::make($request->all(), [
      'device_id' => 'required|string'
    ]);

    if ($validator->fails()) {
      return response()->json(['error' => $validator->errors()], 400);
    }

    FcmToken::where('device_id', $request->device_id)->delete();

    return response()->json(['message' => 'Token eliminado exitosamente']);
  }

  public function destroy($id) {
    try {
      $token = FcmToken::findOrFail($id);
      $token->delete();
      
      return redirect()->route('admin.fcm.index')
            ->with('success', 'Token eliminado exitosamente');
    } catch (\Exception $e) {
      return redirect()->route('admin.fcm.index')
            ->with('error', 'Error al eliminar el token');
    }
  }
}
