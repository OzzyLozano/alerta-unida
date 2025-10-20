<?php

namespace App\Http\Controllers\Flutter;

use App\Http\Controllers\Controller;
use App\Models\UserType\Brigade;
use Illuminate\Http\Request;

class BrigadesFlutterApi extends Controller {
  /**
   * Display a listing of the resource.
   */
  public function index() {
    try {
      $brigades = Brigade::all();
  
      return response()->json([
        'success' => true,
        'message' => 'Brigadistas obtenidos exitosamente',
        'data' => $brigades,
      ], 200); 
    } catch (\Exception $exception) {
      return response()->json([
        'success' => false,
        'message' => 'Error al obtener brigadistas',
        'error' => $exception->getMessage(),
      ], 400);
    }
  }
  
  public function getBrigadeMember($id) {
    $brigade = Brigade::with('traininginfo')->findOrFail($id);
    return response()->json([
      'success' => true,
      'data' => $brigade
    ]);
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
  public function show(Brigade $brigade) {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Brigade $brigade) {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Brigade $brigade) {
    //
  }
}
