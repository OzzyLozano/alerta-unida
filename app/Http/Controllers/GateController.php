<?php

namespace App\Http\Controllers;

use App\Models\Map\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GateController extends Controller {
  public function index() {
    $query = Gate::query();

    $totalCount = $query->count();
    $gate = $query->orderBy('created_at', 'desc')
                  ->paginate(15);
    return view('admin.map.gate.index', compact('gate', 'totalCount'));
  }

  public function create() {
    return view('admin.map.gate.create');
  }

  public function store(Request $request) {
    $validated = $request->validate([
      'description' => 'required|string',
      'latitude' => 'required|numeric|between:-90,90',
      'longitude' => 'required|numeric|between:-180,180',
      'img' => 'required|image|mimes:jpeg,png,jpg,gif',
    ]);

    // $imgPath = $request->file('img')->store('images/map/gate', 'public');
    $imgUrl = null;
    if ($request->hasFile('img')) {
      $file = $request->file('img');
      $fileName = time() . '_' . $file->getClientOriginalName();
      $imgPath = Storage::disk('r2')->putFileAs('map/gate', $file, $fileName);

      if (!empty($imgPath)) {
        $imgUrl = Storage::disk('r2')->url($imgPath);
      } else {
        return back()->withErrors(['img' => 'No se pudo generar la URL del archivo']);
      }

      \Log::info('Archivo subido a R2: ' . $imgPath);
    } else {
      return back()->withErrors(['img' => 'Archivo no recibido']);
    }

    $report = Gate::create([
      'description' => $validated['description'],
      'latitude' => $validated['latitude'],
      'longitude' => $validated['longitude'],
      'img_path' => $imgPath,
    ]);

    return redirect()->route('admin.map.gate.index')->with('success', 'Unidad creada exitosamente');
  }

  public function show($id) {
    $gate = Gate::with('equipments')->findOrFail($id);
    return view('admin.map.gate.show', compact('gate'));
  }

  public function edit($id) {
    $gate = Gate::with('equipments')->findOrFail($id);
    $equipments = \App\Models\Map\Equipment::all();
    return view('admin.map.gate.edit', compact('gate', 'equipments'));
  }

  public function update(Request $request, $id) {
    $gate = Gate::findOrFail($id);
    
    $validated = $request->validate([
      'description' => 'string',
      'latitude' => 'numeric|between:-90,90',
      'longitude' => 'numeric|between:-180,180',
      'img' => 'image|mimes:jpeg,png,jpg,gif',
    ]);

    $gate->latitude = $validated['latitude'];
    $gate->longitude = $validated['longitude'];
    $gate->description = $validated['description'];
    
    if ($request->hasFile('img')) {
      $file = $request->file('img');
      $fileName = time() . '_' . $file->getClientOriginalName();
      $imgPath = Storage::disk('r2')->putFileAs('map/gate', $file, $fileName);
      
      if (!empty($imgPath)) {
        $imgUrl = Storage::disk('r2')->url($imgPath);

        $oldUrl = $gate->img_path;
        $gate->img_path = $imgUrl;
        if (!empty($oldUrl)) {
          $oldPath = str_replace(Storage::disk('r2')->url(''), '', $oldUrl);
          $deleted = Storage::disk('r2')->delete($oldPath);
          \Log::info('Imagen eliminada: ' . $oldPath);
        }
      } else {
        return back()->withErrors(['img' => 'No se pudo generar la URL del nuevo archivo.']);
      }

      \Log::info('Archivo subido a R2: ' . $imgPath);
    }
    // if ($request->hasFile('img')) {
    //   $imgPath = $request->file('img')->store('images/map/gate', 'public');
    //   $gate->img_path = $imgPath;
    // }

    $gate->save();

    return redirect()->route('admin.map.gate.index');
  }

  public function destroy($id) {
    $gate = Gate::findOrFail($id);
    $gate->delete();
    Storage::disk('r2')->delete($gate->img_path);

    return redirect()->route('admin.map.gate.index');
  }

  // custom
  public function addEquipment($id) {
    $gate = Gate::with('equipments')->findOrFail($id);
    $equipments = \App\Models\Map\Equipment::all();
    return view('admin.map.gate.add.equipment', compact('gate', 'equipments'));
  }

  public function submitEquipment(Request $request, $id) {
    $gate = Gate::findOrFail($id);

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
        $gate->equipments()->attach($equipmentId, [
          'latitude' => $latitudes[$index] ?? 0,
          'longitude' => $longitudes[$index] ?? 0,
          'created_at' => now(),
          'updated_at' => now(),
        ]);
      }
    }

    $gate->save();

    return redirect()->route('admin.map.gate.index')->with('success', 'Portería actualizada correctamente.');
  }
}
