@extends('layouts.admin')

@section('page-title', 'Puntos de Reunión')

@section('navbar')
  @include('partials.navbar.admin')
@endsection

@section('content')
  <section>
    <h1>Puntos de Reunión</h1>
    @include('partials.panel.map-options')

    <div class="create">
      <a href="{{ route('admin.map.meeting-point.create') }}">Crear</a>
    </div>
    
    <div class="container">
      <p>Resultados: {{ $totalCount }}</p>
      <div class="table-responsive">
        <table class="table table-hover table-bordered">
          <thead>
            <tr>
              <th scope="col">Id</th>
              <th scope="col">Descripción</th>
              <th scope="col">Coordenadas</th>
              <th scope="col">Foto</th>
              <th scope="col">Ver</th>
            </tr>
          </thead>
          <tbody class="table-group-divider">
            @foreach($meetingPoint as $unit)
              <tr>
                <th scope="row">{{ $unit->id }}</th>
                <td>{{ $unit->description }}</td>
                <td>
                  {{ $unit->latitude }} <br>
                  {{ $unit->longitude }}
                </td>
                <td>
                  @if($unit->img_path)
                    <img src="{{ $unit->img_path }}" alt="Imagen de la porteria" style="width: 100px; height: auto;">
                  @else
                    No disponible
                  @endif
                </td>
                <td>
                  <a class="d-block" href="{{ route('admin.map.meeting-point.show', $unit->id) }}">Ver Unidad</a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      {{ $meetingPoint->links() }}
    </div>
  </section>
@endsection
