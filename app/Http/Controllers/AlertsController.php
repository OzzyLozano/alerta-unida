<?php

namespace App\Http\Controllers;

use App\Models\Alerts;
use App\Models\Brigade;
use App\Models\User;
use Illuminate\Http\Request;

class AlertsController extends Controller {
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request) {
    $query = Alerts::query();

    // Filtro por tipos múltiples
    if ($request->filled('type')) {
      $query->whereIn('type', $request->type);
    }

    // Filtro por estados múltiples
    if ($request->filled('status')) {
      $query->whereIn('status', $request->status);
    }

    // Filtro por simulacro
    if ($request->filled('simulacrum')) {
      $query->whereIn('simulacrum', $request->simulacrum);
    }

    $totalCount = $query->count();
    $alerts = $query->orderBy('created_at', 'desc')
                    ->paginate(15)
                    ->appends($request->query());
    return view('admin.alerts.index', compact('alerts', 'totalCount'));
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
    $alert = new Alerts();
    $alert->title = $request->title;
    $alert->content = $request->content;
    $alert->type = $request->type;
    $alert->status = $request->status;
    $alert->simulacrum = $request->simulacrum;
    $alert->save();
  
    return redirect()->route('admin.alerts.index');
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

  // personalized functions
  public function chat($id) {
    $brigadists = Brigade::with('trainingInfo')->get();
    $alert = Alerts::with('messages.brigade')->findOrFail($id);
    return view('admin.alerts.chat', compact('alert', 'brigadists'));
  }
  
  public function checkIn($id) {
    $alert = Alerts::with(['checkins.user'])->findOrFail($id);
    return view('admin.alerts.check-in', compact('alert'));
  }
}
