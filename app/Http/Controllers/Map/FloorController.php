<?php

namespace App\Http\Controllers\Map;

use App\Http\Controllers\Controller;
use App\Models\Map\Floor;
use App\Models\Map\Building;
use Illuminate\Http\Request;

class FloorController extends Controller {
  public function create($id) {
    $building = Building::with('floors')->findOrFail($id);
    return view('admin.map.building.floor.create', compact('building'));
  }

  public function store(Request $request, $id) {
    $building = Building::with('floors')->findOrFail($id);
    $validated = $request->validate([
      'level' => 'required|string',
    ]);

    $floor = Floor::create([
      'level' => $validated['level'],
      'building_id' => $id,
    ]);

    return redirect()->route('admin.map.building.show', compact('building'))->with('success', 'Piso creado exitosamente');
  }

  public function edit($floor_id) {
    $floor = Floor::findOrFail($floor_id);
    return view('admin.map.building.floor.edit', compact('floor'));
  }

  public function update(Request $request, $id) {
    $floor = Floor::findOrFail($id);
    $validated = $request->validate([
      'level' => 'required|string',
    ]);

    $floor->level = $validated['level'];
    $floor->save();
    
    $building = Building::with('floors')->findOrFail($floor->building_id);

    return redirect()->route('admin.map.building.show', compact('building'))->with('success', 'Piso modificado exitosamente');
  }

  public function destroy($id) {
    $floor = Floor::findOrFail($id);
    $floor->delete();

    $building = Building::with('floors')->findOrFail($floor->building_id);

    return redirect()->route('admin.map.building.show', compact('building'))->with('success', 'Piso eliminado exitosamente');
  }
}
