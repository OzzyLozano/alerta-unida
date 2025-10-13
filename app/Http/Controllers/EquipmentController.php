<?php

namespace App\Http\Controllers;

use App\Models\Map\Equipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EquipmentController extends Controller {
  public function index() {
    $query = Equipment::query();

    $totalCount = $query->count();
    $equipment = $query->orderBy('created_at', 'desc')
                      ->paginate(15);
    return view('admin.map.equipment.index', compact('equipment', 'totalCount'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create() {
    return view('admin.map.equipment.create');
  }

  /**
   * Store a newly created resource in storage.
   */
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

    $report = Report::create([
      'description' => $validated['description'],
      'img_path' => $imgUrl,
    ]);

    return redirect()->route('admin.map.equipment.index')->with('success', 'Unidad creada exitosamente');
  }

  /**
   * Display the specified resource.
   */
  public function show(Equipment $equipment) {
    
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Equipment $equipment) {
    
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Equipment $equipment) {
    
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Equipment $equipment) {
    
  }
}
