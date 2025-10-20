<?php

namespace App\Http\Controllers\Flutter;

use App\Http\Controllers\Controller;
use App\Models\Map\MeetingPoint;
use App\Models\Map\Gate;
use App\Models\Map\Building;
use Illuminate\Http\Request;

class MapController extends Controller {
  public function getMeetingPoints() {
    try {
      $meetingPoints = MeetingPoint::all();
  
      return response()->json([
        'success' => true,
        'message' => 'Puntos de reunion obtenidos exitosamente',
        'data' => $meetingPoints,
      ], 200); 
    } catch (\Exception $exception) {
      return response()->json([
        'success' => false,
        'message' => 'Error al obtener los puntos de reunion',
        'error' => $exception->getMessage(),
      ], 400);
    }
  }

  public function getGates() {
    try {
      $gates = Gate::with('equipments')->get();
  
      return response()->json([
        'success' => true,
        'message' => 'Puntos de reunion obtenidos exitosamente',
        'data' => $gates,
      ], 200); 
    } catch (\Exception $exception) {
      return response()->json([
        'success' => false,
        'message' => 'Error al obtener los puntos de reunion',
        'error' => $exception->getMessage(),
      ], 400);
    }
  }

  public function getBuildings() {
    try {
      $buildings = Building::with('floors.equipments')->get();
  
      return response()->json([
        'success' => true,
        'message' => 'Puntos de reunion obtenidos exitosamente',
        'data' => $buildings,
      ], 200); 
    } catch (\Exception $exception) {
      return response()->json([
        'success' => false,
        'message' => 'Error al obtener los puntos de reunion',
        'error' => $exception->getMessage(),
      ], 400);
    }
  }
}
