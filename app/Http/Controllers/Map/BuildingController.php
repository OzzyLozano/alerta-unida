<?php

namespace App\Http\Controllers\Map;

use App\Http\Controllers\Controller;
use App\Models\Map\Building;
use Illuminate\Http\Request;

class BuildingController extends Controller {
  public function index() {
    $query = Building::query();

    $totalCount = $query->count();
    $buildings = $query->orderBy('created_at', 'desc')
                      ->paginate(15);
    return view('admin.map.building.index', compact('buildings', 'totalCount'));
  }

  public function create() {
    return view('admin.map.building.create');
  }

  public function store(Request $request) {
    $validated = $request->validate([
      'name' => 'required|string',
      'initial_latitude' => 'required|numeric|between:-90,90',
      'initial_longitude' => 'required|numeric|between:-180,180',
      'final_latitude' => 'required|numeric|between:-90,90',
      'final_longitude' => 'required|numeric|between:-180,180',
      'img' => 'required|image|mimes:jpeg,png,jpg,gif',
    ]);

    $imgUrl = null;
    if ($request->hasFile('img')) {
      $file = $request->file('img');
      $fileName = time() . '_' . $file->getClientOriginalName();
      $imgPath = Storage::disk('r2')->putFileAs('map/building', $file, $fileName);
      
      if (!empty($imgPath)) {
        $imgUrl = Storage::disk('r2')->url($imgPath);
      } else {
        return back()->withErrors(['img' => 'No se pudo generar la URL del archivo']);
      }
      
      \Log::info('Archivo subido a R2: ' . $imgPath);
    } else {
      return back()->withErrors(['img' => 'Archivo no recibido']);
    }
    // $imgPath = $request->file('img')->store('images/map/building', 'public');

    $building = Building::create([
      'name' => $validated['name'],
      'initial_latitude' => $validated['initial_latitude'],
      'initial_longitude' => $validated['initial_longitude'],
      'final_latitude' => $validated['final_latitude'],
      'final_longitude' => $validated['final_longitude'],
      'img_path' => $imgPath,
    ]);

    return redirect()->route('admin.map.building.index')->with('success', 'Edificio creado exitosamente');
  }

  public function show($id) {
    $building = Building::with('floors')->findOrFail($id);
    return view('admin.map.building.show', compact('building'));
  }

  public function edit($id) {
    $building = Building::with('floors')->findOrFail($id);
    $floors = \App\Models\Map\Floor::all();
    return view('admin.map.building.edit', compact('building', 'floors'));
  }

  public function update(Request $request, $id) {
    $building = Building::findOrFail($id);
    
    $validated = $request->validate([
      'name' => 'string',
      'initial_latitude' => 'numeric|between:-90,90',
      'initial_longitude' => 'numeric|between:-180,180',
      'final_latitude' => 'numeric|between:-90,90',
      'final_longitude' => 'numeric|between:-180,180',
      'img' => 'image|mimes:jpeg,png,jpg,gif',
    ]);

    $building->initial_latitude = $validated['initial_latitude'];
    $building->initial_longitude = $validated['initial_longitude'];
    $building->final_latitude = $validated['final_latitude'];
    $building->final_longitude = $validated['final_longitude'];
    $building->name = $validated['name'];
    
    if ($request->hasFile('img')) {
      $file = $request->file('img');
      $fileName = time() . '_' . $file->getClientOriginalName();
      $imgPath = Storage::disk('r2')->putFileAs('map/building', $file, $fileName);
      
      if (!empty($imgPath)) {
        $imgUrl = Storage::disk('r2')->url($imgPath);

        $oldUrl = $building->img_path;
        $building->img_path = $imgUrl;
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
    //   $imgPath = $request->file('img')->store('images/map/building', 'public');
    //   $building->img_path = $imgPath;
    // }

    $building->save();

    return redirect()->route('admin.map.building.index');
  }

  public function destroy($id) {
    $building = Building::findOrFail($id);
    $building->delete();
    Storage::disk('r2')->delete($building->img_path);

    return redirect()->route('admin.map.building.index');
  }
}
