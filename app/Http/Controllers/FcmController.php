<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FcmToken;
use Illuminate\Support\Facades\Validator;

class FcmController extends Controller {
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
}
