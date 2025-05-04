<?php

namespace App\Http\Controllers;

use App\Models\Alerts;
use Illuminate\Http\Request;

class AlertsFlutterApi extends Controller {
  /**
   * Display a listing of the resource.
   */
  public function index() {
    try {
      $alerts = Alerts::all();
  
      return response()->json([
        'success' => true,
        'message' => 'Alertas obtenidas exitosamente',
        'data' => $alerts,
      ], 200); 
    } catch (\Exception $exception) {
      return response()->json([
        'success' => false,
        'message' => 'Error al obtener las alertas',
        'error' => $exception->getMessage(),
      ], 400);
    }
  }

  public function getActiveAlerts() {
    return Alerts::whereIn('status', ['active', 'simulacrum'])->get();
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request) {
    //
  }

  /**
   * Display the specified resource.
   */
  public function show(Alerts $alerts) {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Alerts $alerts) {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Alerts $alerts) {
    //
  }
}
