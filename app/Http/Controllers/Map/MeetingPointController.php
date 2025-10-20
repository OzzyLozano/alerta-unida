<?php

namespace App\Http\Controllers\Map;

use App\Http\Controllers\Controller;
use App\Models\Map\MeetingPoint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MeetingPointController extends Controller {
  public function index() {
    $query = MeetingPoint::query();

    $totalCount = $query->count();
    $meetingPoint = $query->orderBy('created_at', 'desc')
                    ->paginate(15);
    return view('admin.map.meeting-point.index', compact('meetingPoint', 'totalCount'));
  }

  public function create() {
    return view('admin.map.meeting-point.create');
  }

  public function store(Request $request) {
    $validated = $request->validate([
      'description' => 'required|string',
      'latitude' => 'required|numeric|between:-90,90',
      'longitude' => 'required|numeric|between:-180,180',
      'img' => 'required|image|mimes:jpeg,png,jpg,gif',
    ]);

    // $imgPath = $request->file('img')->store('images/map/meeting-point', 'public');
    $imgUrl = null;
    if ($request->hasFile('img')) {
      $file = $request->file('img');
      $fileName = time() . '_' . $file->getClientOriginalName();
      $imgPath = Storage::disk('r2')->putFileAs('map/meeting-point', $file, $fileName);

      if (!empty($imgPath)) {
        $imgUrl = Storage::disk('r2')->url($imgPath);
      } else {
        return back()->withErrors(['img' => 'No se pudo generar la URL del archivo']);
      }

      \Log::info('Archivo subido a R2: ' . $imgPath);
    } else {
      return back()->withErrors(['img' => 'Archivo no recibido']);
    }

    $meetingPoint = MeetingPoint::create([
      'description' => $validated['description'],
      'latitude' => $validated['latitude'],
      'longitude' => $validated['longitude'],
      'img_path' => $imgUrl,
      // 'img_path' => $imgPath,
    ]);

    return redirect()->route('admin.map.meeting-point.index')->with('success', 'Unidad creada exitosamente');
  }

  public function show($id) {
    $meetingPoint = MeetingPoint::findOrFail($id);
    return view('admin.map.meeting-point.show', compact('meetingPoint'));
  }

  public function edit($id) {
    $meetingPoint = MeetingPoint::findOrFail($id);
    return view('admin.map.meeting-point.edit', compact('meetingPoint'));
  }

  public function update(Request $request, $id) {
    $meetingPoint = MeetingPoint::findOrFail($id);
    
    $validated = $request->validate([
      'description' => 'string',
      'latitude' => 'numeric|between:-90,90',
      'longitude' => 'numeric|between:-180,180',
      'img' => 'image|mimes:jpeg,png,jpg,gif',
    ]);

    $meetingPoint->latitude = $validated['latitude'];
    $meetingPoint->longitude = $validated['longitude'];
    $meetingPoint->description = $validated['description'];
    
    if ($request->hasFile('img')) {
      $file = $request->file('img');
      $fileName = time() . '_' . $file->getClientOriginalName();
      $imgPath = Storage::disk('r2')->putFileAs('map/meeting-point', $file, $fileName);
      
      if (!empty($imgPath)) {
        $imgUrl = Storage::disk('r2')->url($imgPath);

        $oldUrl = $meetingPoint->img_path;
        $meetingPoint->img_path = $imgUrl;
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
    //   $imgPath = $request->file('img')->store('images/map/meeting-point', 'public');
    //   $meetingPoint->img_path = $imgPath;
    // }

    $meetingPoint->save();

    return redirect()->route('admin.map.meeting-point.index');
  }

  public function destroy($id) {
    $meetingPoint = MeetingPoint::findOrFail($id);
    $meetingPoint->delete();
    Storage::disk('r2')->delete($meetingPoint->img_path);

    return redirect()->route('admin.map.meeting-point.index');
  }
}
