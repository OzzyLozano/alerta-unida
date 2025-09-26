<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Alerts;
use Illuminate\Http\Request;

class ReportsFlutterController extends Controller {
  public function getOnWaitReports() {
    return Report::where('status', 'on_wait')->get();
  }

  public function show($id) {
    $report = Report::find($id);
    if (!$report) {
        return response()->json(['error' => 'Reporte no encontrado'], 404);
    }
    return response()->json($report, 200);
  }

  public function authorizeReport(Request $request, $id) {
    $report = Report::find($id);

    if (!$report) {
      return response()->json(['error' => 'Reporte no encontrado'], 404);
    }

    $validated = $request->validate([
      'title' => 'required|string|max:255',
      'description' => 'required|string',
      'type' => 'required|in:evacuacion,prevencion/combate de fuego,busqueda y rescate,primeros auxilios',
      'user_id' => 'required|integer|exists:brigade,id'
    ]);

    $report->status = 'accepted';
    $report->title = $validated['title'];
    $report->description = $validated['description'];
    $report->brigadist_id = $validated['user_id'];
    $report->save();

    $alert = Alerts::create([
      'brigade_id' => $report->brigadist_id ?? null,
      'title' => $validated['title'],
      'content' => $validated['description'],
      'type' => $validated['type'],
      'status' => 'active',
      'simulacrum' => false
    ]);

    return response()->json([
      'message' => 'Reporte autorizado con éxito. La nueva alerta ha sido enviada',
      'report'  => $report,
      'alert'   => $alert
    ], 200);
  }
  
  public function cancelReport(Request $request, $id) {
    $report = Report::find($id);

    if (!$report) {
      return response()->json(['error' => 'Reporte no encontrado'], 404);
    }

    $validated = $request->validate([
      'user_id' => 'required|integer|exists:brigade,id'
    ]);

    $report->status = 'cancelled';
    $report->brigadist_id = $validated['user_id'];
    $report->save();

    return response()->json([
      'message' => 'Reporte cancelado con éxito.',
      'report' => $report
    ], 200);
  }
  
  public function sendReport(Request $request) {
    try {
      $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'img' => 'required|image',
        'user_id' => 'required|integer|exists:users,id'
      ]);

      $imgPath = $request->file('img')->store('images/reports', 'public');

      $report = Report::create([
        'title' => $request->input('title'),
        'description' => $request->input('description'),
        'img_path' => $imgPath,
        'status' => 'on_wait',
        'user_id' => $request->input('user_id'),
        'brigadist_id' => null,
      ]);

      return response()->json([
        'success' => true,
        'message' => 'Reporte enviado exitosamente',
        'data' => $report
      ], 200);
    } catch (\Exception $exception) {
      return response()->json([
        'success' => false,
        'message' => 'Error al procesar el reporte',
        'error' => $exception->getMessage()
      ], 400);
    }
  }
}
