<?php

namespace App\Http\Controllers;
use App\Models\Checkin;

use Illuminate\Http\Request;

class CheckinFlutterApi extends Controller {
  public function storeApi(Request $request) {
    $checkin = new Checkin();
    $checkin->alert_id = $request->alert_id;
    $checkin->user_id = $request->user_id;
    $checkin->meeting_point = $request->meeting_point;
    $checkin->are_you_okay = $request->are_you_okay;
    $checkin->save();

    return response()->json([
        'message' => 'Check-in registrado correctamente',
        'data' => $checkin
    ], 201);
  }
}
