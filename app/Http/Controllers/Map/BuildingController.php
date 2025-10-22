<?php

namespace App\Http\Controllers\Map;

use App\Http\Controllers\Controller;
use App\Models\Map\Building;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
      'latitude_1' => 'required|numeric|between:-90,90',
      'longitude_1' => 'required|numeric|between:-180,180',
      'latitude_2' => 'required|numeric|between:-90,90',
      'longitude_2' => 'required|numeric|between:-180,180',
      'latitude_3' => 'required|numeric|between:-90,90',
      'longitude_3' => 'required|numeric|between:-180,180',
      'latitude_4' => 'required|numeric|between:-90,90',
      'longitude_4' => 'required|numeric|between:-180,180',
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
      'latitude_1' => $validated["latitude_1"],
      'longitude_1' => $validated["longitude_1"],
      'latitude_2' => $validated["latitude_2"],
      'longitude_2' => $validated["longitude_2"],
      'latitude_3' => $validated["latitude_3"],
      'longitude_3' => $validated["longitude_3"],
      'latitude_4' => $validated["latitude_4"],
      'longitude_4' => $validated["longitude_4"],
      'img_path' => $imgUrl,
      // 'img_path' => $imgPath,
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
      'latitude_1' => 'numeric|between:-90,90',
      'longitude_1' => 'numeric|between:-180,180',
      'latitude_2' => 'numeric|between:-90,90',
      'longitude_2' => 'numeric|between:-180,180',
      'latitude_3' => 'numeric|between:-90,90',
      'longitude_3' => 'numeric|between:-180,180',
      'latitude_4' => 'numeric|between:-90,90',
      'longitude_4' => 'numeric|between:-180,180',
      'img' => 'image|mimes:jpeg,png,jpg,gif',
    ]);

    $building->latitude_1 = $validated["latitude_1"];
    $building->longitude_1 = $validated["longitude_1"];
    $building->latitude_2 = $validated["latitude_2"];
    $building->longitude_2 = $validated["longitude_2"];
    $building->latitude_3 = $validated["latitude_3"];
    $building->longitude_3 = $validated["longitude_3"];
    $building->latitude_4 = $validated["latitude_4"];
    $building->longitude_4 = $validated["longitude_4"];
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
