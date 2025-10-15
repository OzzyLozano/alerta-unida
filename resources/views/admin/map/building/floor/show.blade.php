@extends('layouts.admin')

@section('page-title', 'Editar Piso - Edificio')

@section('navbar')
  @include('partials.navbar.admin')
@endsection

@section('content')
  <div class="container">
    <h1>Planta: {{ $floor->level }}</h1>
    
    <h2>Equipamiento relacionado</h2>
    @if($floor->equipments->isEmpty())
      <p>No hay equipamiento asignado a esta portería.</p>
    @else
      <div class="table-responsive">
        <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <th>Descripción</th>
              <th>Coordenadas</th>
              <th>Imagen</th>
            </tr>
          </thead>
          <tbody>
            @foreach($floor->equipments as $equipment)
              <tr>
                <td>{{ $equipment->description }}</td>
                <td>
                  {{ $equipment->pivot->latitude }}<br>
                  {{ $equipment->pivot->longitude }}
                </td>
                <td>
                  @if($equipment->img_path)
                    <img src="{{ $equipment->img_path }}" alt="Imagen" style="width:100px; height:auto;">
                  @else
                    No disponible
                  @endif
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @endif

    <a href="{{ route('admin.map.floor.add.equipment', ['building' => $building->id, 'id' => $floor->id]) }}">Agregar equipamiento a este piso</a>
    <a href="{{ route('admin.map.floor.edit', ['building' => $building->id, 'id' => $floor->id]) }}" class="btn btn-secondary">Editar Piso</a>
  </div>

@endsection
