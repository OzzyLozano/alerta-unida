<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Alerts;
use Illuminate\Http\Request;

class ReportsFlutterController extends Controller {
  public function getOnWaitReports() {
    return Report::where('status', 'on_wait')->get();
  }

  public function authorizeReport($id) {
    $report = Report::find($id);

    if (!$report) {
      return response()->json(['error' => 'Reporte no encontrado'], 404);
    }

    $report->status = 'accepted';
    $report->save();

    return response()->json([
      'message' => 'Reporte autorizado con éxito.',
      'report' => $report,
    ], 200);
  }
  
  public function cancelReport($id) {
    $report = Report::find($id);

    if (!$report) {
      return response()->json(['error' => 'Reporte no encontrado'], 404);
    }

    $report->status = 'cancelled';
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
        'img' => 'required|image|mimes:jpeg,png,jpg,gif',
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
