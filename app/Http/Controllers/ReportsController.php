<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\User;
use App\Models\Brigade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReportsController extends Controller {
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request) {
    $query = Report::query();

    // Filtro por tipos múltiples
    if ($request->filled('type')) {
      $query->whereIn('type', $request->type);
    }

    // Filtro por estados múltiples
    if ($request->filled('status')) {
      $query->whereIn('status', $request->status);
    }

    $totalCount = $query->count();
    $reports = $query->orderBy('created_at', 'desc')
                    ->paginate(15)
                    ->appends($request->query());
    return view('admin.reports.index', compact('reports', 'totalCount'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create() {
    
    $users = User::all();
    $brigadists = Brigade::all();
        
    return view('admin.reports.create', compact('users', 'brigadists'));
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request) {
    $validated = $request->validate([
      'title' => 'required|string|max:255',
      'description' => 'required|string',
      'img' => 'required|image|mimes:jpeg,png,jpg,gif',
      'status' => 'required|in:accepted,on_wait,cancelled',
      'user_id' => 'required|exists:users,id',
      'brigadist_id' => 'nullable|exists:brigade,id',
    ]);

    $imgPath = $request->file('img')->store('images/reports', 'r2');
    $imgUrl = Storage::disk('r2')->url($imgPath);

    $report = Report::create([
      'title' => $validated['title'],
      'description' => $validated['description'],
      'img_path' => $imgUrl,
      'status' => $validated['status'],
      'user_id' => $validated['user_id'],
      'brigadist_id' => $validated['brigadist_id'] ?? null,
    ]);

    return redirect()->route('admin.reports.index')->with('success', 'Reporte creado exitosamente');
  }

  /**
   * Display the specified resource.
   */
  public function show(Report $report) {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Report $report) {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Report $report) {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Report $report) {
    //
  }
}
