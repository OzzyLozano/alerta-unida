<?php

namespace App\Http\Controllers;

use App\Models\Alerts;
use Illuminate\Http\Request;

class AlertsController extends Controller {
  /**
   * Display a listing of the resource.
   */
  public function index() {
    $alerts = Alerts::paginate(10);
    return view('admin.alerts.index', compact('alerts'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create() {
    return view('admin.alerts.create');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request) {
    try {
      $alert = new Alerts();
      $alert->title = $request->title;
      $alert->content = $request->content;
      $alert->type = $request->type;
      $alert->status = $request->status;
      $alert->save();
  
      return redirect()->route('admin.alerts.index'); 
    } catch (\Exception $exception) {
      return response()->json([
        'success' => false,
        'message' => 'Error al crear usuario',
        'error'   => $exception->getMessage(),
      ], 400);
    }
  }

  /**
   * Display the specified resource.
   */
  public function show(Alerts $alerts) {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Alerts $alerts) {
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
