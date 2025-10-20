<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Simulacrum;
use Illuminate\Http\Request;

class SimulacrumController extends Controller {
  /**
   * Display a listing of the resource.
   */
  public function index() {
    $simulacrums = Simulacrum::paginate(15);
    return view('admin.simulacrum.index', compact('simulacrums'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create() {
    return view('admin.simulacrum.create');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request) {
    $simulacrum = new Simulacrum();
    $simulacrum->title = $request->title;
    $simulacrum->type = $request->type;
    $simulacrum->save();

    return redirect()->route('admin.simulacrums.index');
  }

  /**
   * Display the specified resource.
   */
  public function show(Simulacrum $simulacrum) {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Simulacrum $simulacrum) {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Simulacrum $simulacrum) {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Simulacrum $simulacrum) {
    //
  }
}
