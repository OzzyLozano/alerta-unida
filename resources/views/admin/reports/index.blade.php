@extends('layouts.app')

@section('page-title', 'Reports')

@section('navbar')
  @include('partials.navbar.admin')
@endsection

@section('content')
  <h1>Reportes</h1>
  <nav class="api-options container">
    <a href="{{ route('admin.reports.create') }}">Create</a>
    <p>Filtrar por:</p>
    
    <form action="{{ route('admin.reports.index') }}" method="get" class="filter-options">

      @php
        $states = [
          'accepted' => 'Aceptado',
          'on_wait' => 'En Espera',
          'cancelled' => 'Cancelado'
        ];
      @endphp
      @foreach($states as $value => $label)
        <input  type="checkbox"
                class="btn-check"
                id="status-{{$label}}"
                name="status[]"
                value="{{ $value }}"
                {{ in_array($value, (array) request('status')) ? 'checked' : '' }}>
        <label class="btn" for="status-{{$label}}">
          {{ $label }}
        </label>
      @endforeach

      <button type="submit" class="btn btn-primary">Aplicar filtros</button>
    </form>
  </nav>
  <div class="container">
    <p>Resultados: {{ $totalCount }}</p>
    <div class="table-responsive">
      <table class="table table-hover table-bordered">
        <thead>
          <tr>
            <th scope="col">Id</th>
            <th scope="col">Titulo</th>
            <th scope="col">Descripción</th>
            <th scope="col">Estado</th>
            <th scope="col">Usuario</th>
            <th scope="col">Brigadista</th>
            <th scope="col">Imagen</th>
          </tr>
        </thead>
        <tbody class="table-group-divider">
          @foreach($reports as $report)
            <tr>
              <th scope="row">{{ $report->id }}</th>
              <td>{{ $report->title }}</td>
              <td>{{ $report->description }}</td>
              <td>{{ $report->status }}</td>
              <td>{{ $report->user_id }}</td>
              <td>{{ $report->brigadist_id ?? "en espera" }}</td>
              <td>
                @if($report->img_path)
                  <img src="{{ asset('storage/' . $report->img_path) }}" alt="Imagen del reporte" style="width: 100px; height: auto;">
                @else
                  No disponible
                @endif
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection
