@extends('layouts.admin')

@section('page-title', 'Equipment')

@section('navbar')
  @include('partials.navbar.admin')
@endsection

@section('content')
  <section>
    <h1>Equipamiento</h1>
    @include('partials.panel.map-options')

    <div class="create">
      <a href="{{ route('admin.map.equipment.create') }}">Crear</a>
    </div>
    
    <div class="container">
      <p>Resultados: {{ $totalCount }}</p>
      <div class="table-responsive">
        <table class="table table-hover table-bordered">
          <thead>
            <tr>
              <th scope="col">Id</th>
              <th scope="col">Descripción</th>
              <th scope="col">Foto</th>
              <th scope="col">Ver</th>
            </tr>
          </thead>
          <tbody class="table-group-divider">
            @foreach($equipment as $unit)
              <tr>
                <th scope="row">{{ $unit->id }}</th>
                <th scope="row">{{ $unit->description }}</th>
                <td>
                  @if($unit->img_path)
                    <img src="{{ $unit->img_path }}" alt="Imagen del equipo" style="width: 100px; height: auto;">
                  @else
                    No disponible
                  @endif
                </td>
                <td>
                  <a class="d-block" href="{{ route('admin.map.equipment.show', $unit->id) }}">Ver Unidad</a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      {{ $equipment->links() }}
    </div>
  </section>
@endsection
