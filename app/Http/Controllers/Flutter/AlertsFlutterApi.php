<?php

namespace App\Http\Controllers\Flutter;

use App\Http\Controllers\Controller;
use App\Models\Alerts\Alerts;
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
    return Alerts::where('status', 'active')->get();
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
  public function update(Request $request, $id) {
    try {
      $alert = Alerts::FindOrFail($id);
      $alert->status = $request->status;
      $alert->save();

      return response()->json([
        'success' => true,
        'message' => 'Alertas modificada exitosamente',
      ], 200); 
    } catch (\Exception $exception) {
      return response()->json([
        'success' => false,
        'message' => 'Error :c',
        'error' => $exception->getMessage(),
      ], 400);
    }
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Alerts $alerts) {
    //
  }
}
