<?php

namespace App\Http\Controllers;
use App\Models\Checkin;

use Illuminate\Http\Request;

class CheckinFlutterApi extends Controller {
  public function storeApi(Request $request) {
    $checkin = Checkin::updateOrCreate([
      'alert_id' => $request->alert_id,
      'user_id' => $request->user_id ], [
      'meeting_point' => $request->meeting_point,
      'are_you_okay' => $request->are_you_okay
      ]
    );
    
    return response()->json([
        'message' => 'Check-in registrado correctamente',
        'data' => $checkin
    ], 201);
  }
}
