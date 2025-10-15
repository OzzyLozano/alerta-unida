@extends('layouts.admin')

@section('page-title', 'Portería')

@section('navbar')
  @include('partials.navbar.admin')
@endsection

@section('content')
  <div>
    <a href="{{ route('admin.map.building.index') }}" class="d-inline-flex align-items-center gap-2 link-underline">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
      </svg>
      Ver Todos
    </a>
    <h1>Edificio: {{ $building->name }}</h1>
  </div>

  <h2>Pisos</h2>
  @if($building->floors->isEmpty())
    <p>No hay pisos asociados a este edificio.</p>
  @else
    <div class="table-responsive">
      <table class="table table-bordered table-hover">
        <thead>
          <tr>
            <th>Plantas</th>
            <th>Editar</th>
            <th>Eliminar</th>
          </tr>
        </thead>
        <tbody>
          @foreach($building->floors as $floor)
            <tr>
              <td>{{ $floor->level }}</td>
              <td>
                <a href="{{ route('admin.map.floor.show', ['building' => $building->id, 'id' => $floor->id]) }}">Ver</a>
              </td>
              <td>
                <form action="{{ route('admin.map.floor.destroy', ['building' => $building->id, 'id' => $floor->id]) }}" method="POST" style="display:inline;">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger">Borrar</button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  @endif
  <a href="{{ route('admin.map.floor.create', $building->id) }}">Agregar Piso a este edificio</a>

  <div class="my-4">
    <h2>{{ $building->description }}</h2>
    <img src="{{ $building->img_path }}" alt="img.jpg" style="width: 400px; height: auto;">
    <a href="{{ route('admin.map.building.edit', $building->id) }}" class="btn btn-secondary">Editar Edificio</a>
    <form action="{{ route('admin.map.building.destroy', $building->id) }}" method="POST" style="display:inline;">
      @csrf
      @method('DELETE')
      <button type="submit" class="btn btn-danger">Borrar</button>
    </form>
  </div>
@endsection
