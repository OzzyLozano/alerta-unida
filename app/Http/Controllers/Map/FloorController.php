<?php

namespace App\Http\Controllers\Map;

use App\Http\Controllers\Controller;
use App\Models\Map\Floor;
use App\Models\Map\Building;
use Illuminate\Http\Request;

class FloorController extends Controller {
  public function create($building) {
    $building = Building::with('floors')->findOrFail($building);
    return view('admin.map.building.floor.create', compact('building'));
  }

  public function store(Request $request, $building) {
    $building = Building::with('floors')->findOrFail($building);
    $validated = $request->validate([
      'level' => 'required|string',
    ]);

    $floor = Floor::create([
      'level' => $validated['level'],
      'building_id' => $building->id,
    ]);

    return redirect()->route('admin.map.building.show', $building->id)->with('success', 'Piso creado exitosamente');
  }

  public function show($building, $id) {
    $floor = Floor::with('equipments')->findOrFail($id);
    $building = Building::findOrFail($building);
    return view('admin.map.building.floor.show', compact('floor', 'building'));
  }

  public function edit($building, $id) {
    $floor = Floor::with('building')->findOrFail($id);
    $building = $floor->building;
    return view('admin.map.building.floor.edit', compact('floor', 'building'));
  }

  public function update(Request $request, $building, $id) {
    $floor = Floor::findOrFail($id);
    $validated = $request->validate([
      'level' => 'required|string',
    ]);

    $floor->level = $validated['level'];
    $floor->save();
    
    $building = Building::with('floors')->findOrFail($floor->building_id);

    return redirect()->route('admin.map.building.show', compact('building'))->with('success', 'Piso modificado exitosamente');
  }

  public function destroy($building, $id) {
    $floor = Floor::findOrFail($id);
    $floor->delete();

    return redirect()->route('admin.map.building.show', $building)->with('success', 'Piso eliminado exitosamente');
  }
  
  public function addEquipment($building, $id) {
    $floor = Floor::with('equipments')->findOrFail($id);
    $equipments = \App\Models\Map\Equipment::all();
    $building = Building::findOrFail($building);
    return view('admin.map.building.floor.equipment.create', compact('floor', 'equipments', 'building'));
  }
  
  public function submitEquipment(Request $request, $building, $id) {
    $floor = Floor::findOrFail($id);

    $validated = $request->validate([
      'equipments_ids.*' => 'required|exists:equipments,id',
      'equipments_latitude.*' => 'required|numeric|between:-90,90',
      'equipments_longitude.*' => 'required|numeric|between:-180,180',
    ]);
    
    // Guardar equipamientos
    $equipmentIds = $request->input('equipments_ids', []);
    $latitudes = $request->input('equipments_latitude', []);
    $longitudes = $request->input('equipments_longitude', []);

    foreach ($equipmentIds as $index => $equipmentId) {
      if ($equipmentId) {
        $floor->equipments()->attach($equipmentId, [
          'latitude' => $latitudes[$index] ?? 0,
          'longitude' => $longitudes[$index] ?? 0,
          'created_at' => now(),
          'updated_at' => now(),
        ]);
      }
    }

    $floor->save();

    return redirect()->route('admin.map.floor.show', [
      'building' => $building,
      'id' => $id
    ])->with('success', 'Piso actualizada correctamente.');
  }
}
