<?php

namespace App\Http\Controllers\Map;

use App\Models\Map\Equipment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class EquipmentController extends Controller {
  public function index() {
    $query = Equipment::query();

    $totalCount = $query->count();
    $equipment = $query->orderBy('created_at', 'desc')
                      ->paginate(15);
    return view('admin.map.equipment.index', compact('equipment', 'totalCount'));
  }

  public function create() {
    return view('admin.map.equipment.create');
  }

  public function store(Request $request) {
    $validated = $request->validate([
      'description' => 'required|string',
      'img' => 'required|image|mimes:jpeg,png,jpg,gif',
    ]);

    $imgUrl = null;
    if ($request->hasFile('img')) {
      $file = $request->file('img');
      $fileName = time() . '_' . $file->getClientOriginalName();
      $imgPath = Storage::disk('r2')->putFileAs('map/equipment', $file, $fileName);

      if (!empty($imgPath)) {
        $imgUrl = Storage::disk('r2')->url($imgPath);
      } else {
        return back()->withErrors(['img' => 'No se pudo generar la URL del archivo']);
      }

      \Log::info('Archivo subido a R2: ' . $imgPath);
    } else {
      return back()->withErrors(['img' => 'Archivo no recibido']);
    }
    // $imgPath = $request->file('img')->store('images/map/equipment', 'public');

    $report = Equipment::create([
      'description' => $validated['description'],
      'img_path' => $imgUrl,
      // 'img_path' => $imgPath,
    ]);

    return redirect()->route('admin.map.equipment.index')->with('success', 'Unidad creada exitosamente');
  }

  public function show($id) {
    $equipment = Equipment::findOrFail($id);
    return view('admin.map.equipment.show', compact('equipment'));
  }

  public function edit($id) {
    $equipment = Equipment::findOrFail($id);
    return view('admin.map.equipment.edit', compact('equipment'));
  }

  public function update(Request $request, $id) {
    $equipment = Equipment::findOrFail($id);
    
    $validated = $request->validate([
      'description' => 'string',
      'img' => 'image|mimes:jpeg,png,jpg,gif',
    ]);

    $equipment->description = $validated['description'];
    
    if ($request->hasFile('img')) {
      $file = $request->file('img');
      $fileName = time() . '_' . $file->getClientOriginalName();
      $imgPath = Storage::disk('r2')->putFileAs('map/equipment', $file, $fileName);
      
      if (!empty($imgPath)) {
        $imgUrl = Storage::disk('r2')->url($imgPath);

        $oldUrl = $equipment->img_path;
        $equipment->img_path = $imgUrl;
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
    // $imgPath = $request->file('img')->store('images/map/equipment', 'public');
    // $equipment->img_path = $imgPath;
    $equipment->save();

    return redirect()->route('admin.map.equipment.index');
  }

  public function destroy($id) {
    $equipment = Equipment::findOrFail($id);
    $equipment->delete();
    Storage::disk('r2')->delete($equipment->img_path);

    return redirect()->route('admin.map.equipment.index');
  }
}
