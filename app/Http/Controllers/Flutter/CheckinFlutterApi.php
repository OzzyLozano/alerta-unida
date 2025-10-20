<?php

namespace App\Http\Controllers\Flutter;

use App\Http\Controllers\Controller;
use App\Models\Alerts\Checkin;
use Illuminate\Http\Request;

class CheckinFlutterApi extends Controller {
  public function checkIn(Request $request) {
    $request->validate([
      'alert_id' => 'required|integer|exists:alerts,id',
      'user_id' => 'required|integer|exists:users,id',
      'meeting_point' => 'nullable|integer|min:1|max:4',
      'are_you_okay' => 'required|string|in:Si,No',
    ]);

    // updateOrCreate evita duplicados y actualiza si ya existe
    $checkin = Checkin::updateOrCreate(
      [
        'alert_id' => $request->alert_id,
        'user_id' => $request->user_id,
      ],
      [
        'meeting_point' => $request->meeting_point,
        'are_you_okay' => $request->are_you_okay,
      ]
    );

    return response()->json([
      'message' => 'Check-in registrado correctamente',
      'data' => $checkin
    ], 201);
  }
}
