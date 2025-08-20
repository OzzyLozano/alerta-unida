<?php

namespace App\Http\Controllers;

use App\Models\Checkin;
use App\Models\Alerts;
use Illuminate\Http\Request;

class CheckinController extends Controller
{
    /**
     * Muestra la lista de check-ins (WEB)
     */
    public function index(Request $request, $alertId = null)
    {
        // Si llega por parámetro directo (ej: desde botón en alerts.index)
        $alertId = $alertId ?? $request->input('alert_id');

        $startDate = $request->input('start_date');
        $endDate   = $request->input('end_date');

        // Consulta base
        $query = Checkin::query();

        // 🔗 Filtro por alerta
        if ($alertId) {
            $query->where('alert_id', $alertId);
        }

        // Filtros de fecha
        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }
        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        // Obtener resultados
        $checkins = $query->orderBy('created_at', 'desc')->get();

        // Contadores
        $totalCheckins = Checkin::count();
        $filteredCount = $checkins->count();

        // Si existe alerta seleccionada, la pasamos a la vista
        $alert = $alertId ? Alerts::find($alertId) : null;

        return view('admin.check_in.index', compact(
            'checkins',
            'totalCheckins',
            'filteredCount',
            'startDate',
            'endDate',
            'alertId',
            'alert'
        ));
    }

    /**
     * Muestra el formulario de registro (WEB)
     */
    public function create(Request $request)
    {
        // 🔗 Pasamos también las alertas activas al formulario
        $alerts = Alerts::where('status', 'active')->get();

        // Si viene con ?alert_id=... lo usamos como preseleccionado
        $alertId = $request->input('alert_id');

        return view('admin.check_in.create', compact('alerts', 'alertId'));
    }

    /**
     * Guarda un nuevo check-in desde WEB
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'alert_id' => 'required|exists:alerts,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'meeting_point' => 'nullable|integer|min:1|max:4',
            'are_you_okay' => 'required|in:Si,No',
        ]);

        $checkin = Checkin::create($validated);

        return redirect()
            ->route('admin.check_in.index', ['alertId' => $checkin->alert_id])
            ->with('success', 'Check-in registrado correctamente.');
    }

    /**
     * Guarda un nuevo check-in desde API (Flutter)
     */
    public function storeApi(Request $request)
    {
        $validated = $request->validate([
            'alert_id' => 'required|exists:alerts,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'meeting_point' => 'nullable|integer|min:1|max:4',
            'are_you_okay' => 'required|in:Si,No',
        ]);

        $checkin = Checkin::create($validated);

        return response()->json([
            'message' => 'Check-in registrado correctamente',
            'data' => $checkin
        ], 201);
    }
}
