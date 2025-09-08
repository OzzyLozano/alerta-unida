<?php

namespace App\Http\Controllers;
use App\Models\Checkin;

use Illuminate\Http\Request;

class CheckinFlutterApi extends Controller {
  public function checkIn(Request $request) {
    $request->validate([
      'alert_id' => 'required|integer',
      'user_id' => 'required|integer',
      'meeting_point' => 'nullable|string',
      'are_you_okay' => 'nullable|boolean',
    ]);

    $checkin = Checkin::firstOrNew([
      'alert_id' => $request->alert_id,
      'user_id' => $request->user_id
    ]);

    $checkin->meeting_point = $request->meeting_point ?? $checkin->meeting_point;
    $checkin->are_you_okay = $request->are_you_okay ?? $checkin->are_you_okay;

    $checkin->save();

    return response()->json([
        'message' => 'Check-in registrado correctamente',
        'data' => $checkin
    ], 200);
  }
}
