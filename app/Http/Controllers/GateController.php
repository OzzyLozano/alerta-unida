<?php

namespace App\Http\Controllers;

use App\Models\Map\Gate;
use Illuminate\Http\Request;

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
      'img_path' => $imgUrl,
    ]);

    return redirect()->route('admin.map.gate.index')->with('success', 'Unidad creada exitosamente');
  }

  public function show($id) {
    $gate = Gate::findOrFail($id);
    return view('admin.map.gate.show', compact('gate'));
  }

  public function edit($id) {
    $gate = Gate::findOrFail($id);
    return view('admin.map.gate.edit', compact('gate'));
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
    $gate->save();

    return redirect()->route('admin.map.gate.index');
  }

  public function destroy($id) {
    $gate = Gate::findOrFail($id);
    $gate->delete();
    Storage::disk('r2')->delete($gate->img_path);

    return redirect()->route('admin.map.gate.index');
  }
}
