@extends('layouts.admin')

@section('page-title', 'Portería')

@section('navbar')
  @include('partials.navbar.admin')
@endsection

@section('content')
  <div class="pt-4 px-4">
    <a href="{{ route('admin.map.gate.index') }}" class="d-inline-flex align-items-center gap-2 link-underline">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
      </svg>
      Ver Todos
    </a>
    <h1>Equipment Id: {{ $gate->id }}</h1>
  </div>

  <h2>Equipamiento relacionado</h2>
  @if($gate->equipments->isEmpty())
    <p>No hay equipamiento asignado a esta portería.</p>
  @else
    <table class="table table-bordered table-hover">
      <thead>
        <tr>
          <th>Id</th>
          <th>Descripción</th>
          <th>Coordenadas</th>
          <th>Imagen</th>
        </tr>
      </thead>
      <tbody>
        @foreach($gate->equipments as $equipment)
          <tr>
            <td>{{ $equipment->id }}</td>
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
  @endif

  <div class="m-4">
    <h2>{{ $gate->description }}</h2>
    <img src="{{ $gate->img_path }}" alt="img.jpg" style="width: 400px; height: auto;">
    <a href="{{ route('admin.map.gate.edit', $gate->id) }}" class="btn btn-secondary">Edit</a>
    <form action="{{ route('admin.map.gate.destroy', $gate->id) }}" method="POST" style="display:inline;">
      @csrf
      @method('DELETE')
      <button type="submit" class="btn btn-danger">Delete</button>
    </form>
  </div>
@endsection
