<?php

namespace App\Http\Controllers;

use App\Models\Brigade;
use Illuminate\Http\Request;

class BrigadeController extends Controller {
  /**
   * Display a listing of the resource.
   */
  public function index() {
    $brigades = Brigade::with('trainingInfo')->get();
    return view('admin.brigades.index', compact('brigades'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create() {
    return view('admin.brigades.create');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request) {
    $brigade = new Brigade();

    $request->validate([
      'name' => 'required',
      'lastname' => 'required',
      'email' => 'required',
      'password' => 'required',
      'training' => 'required',
      'role' => 'required',
    ]);

    $entrenamientos = [
      'evacuacion' => false,
      'prevencion_combate' => false,
      'busqueda_rescate' => false,
      'primeros_auxilios' => false,
    ];

    $brigade->name = $request->name;
    $brigade->lastname = $request->lastname;
    $brigade->email = $request->email;
    $brigade->password = bcrypt($request->password);
    $brigade->role = $request->role;
    $brigade->save();

    foreach ($request->input('training', []) as $tipo) {
      if ($tipo === 'evacuacion') $entrenamientos['evacuacion'] = true;
      if ($tipo === 'prevencion/combate de fuego') $entrenamientos['prevencion_combate'] = true;
      if ($tipo === 'busqueda y rescate') $entrenamientos['busqueda_rescate'] = true;
      if ($tipo === 'primeros auxilios') $entrenamientos['primeros_auxilios'] = true;
    }
    $brigade->trainingInfo()->create($entrenamientos, ['brigade_id' => $brigade->id]);

    return redirect()->route('brigades.index');
  }

  /**
   * Display the specified resource.
   */
  public function show(Brigade $brigade) {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Brigade $brigade) {
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
