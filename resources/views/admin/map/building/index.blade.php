@extends('layouts.admin')

@section('page-title', 'Edificios')

@section('navbar')
  @include('partials.navbar.admin')
@endsection

@section('content')
  <section>
    <h1>Edificios</h1>
    @include('partials.panel.map-options')

    <div class="create">
      <a href="{{ route('admin.map.building.create') }}">Crear</a>
    </div>
    
    <div class="container">
      <p>Resultados: {{ $totalCount }}</p>
      <div class="table-responsive">
        <table class="table table-hover table-bordered">
          <thead>
            <tr>
              <th scope="col">Nombre</th>
              <th scope="col">Coordenadas</th>
              <th scope="col">Foto</th>
              <th scope="col">Ver</th>
            </tr>
          </thead>
          <tbody class="table-group-divider">
            @foreach($buildings as $building)
              <tr>
                <td>{{ $building->name }}</td>
                <td>
                  {{ $building->latitude_1 }} <br>
                  {{ $building->ongitude_1 }}
                  {{ $building->latitude_2 }} <br>
                  {{ $building->longitude_2 }}
                  {{ $building->latitude_3 }} <br>
                  {{ $building->longitude_3 }}
                  {{ $building->latitude_4 }} <br>
                  {{ $building->longitude_4 }}
                </td>
                <td>
                  @if($building->img_path)
                    <img src="{{ $building->img_path }}" alt="Imagen del edificio" style="width: 100px; height: auto;">
                  @else
                    No disponible
                  @endif
                </td>
                <td>
                  <a class="d-block" href="{{ route('admin.map.building.show', $building->id) }}">Ver Edificio</a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      {{ $buildings->links() }}
    </div>
  </section>
@endsection
