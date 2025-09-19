@extends('layouts.app')

@section('page-title', 'Brigades')

@section('navbar')
  @include('partials.navbar.admin')
@endsection

@section('content')
  <h1>Brigadistas</h1>
  <nav class="api-options container">
    <a href="{{ route('admin.brigades.create') }}">Create</a>
    <p>Filtrar por:</p>
    
    <form action="{{ route('admin.brigades.index') }}" method="get" class="filter-options">
      
      @php
        $types = [
          'evacuacion' => 'Evacuación',
          'prevencion_combate' => 'Prevención/Combate de fuego',
          'busqueda_rescate' => 'Búsqueda y rescate',
          'primeros_auxilios' => 'Primeros auxilios',
        ];
      @endphp
      @foreach ($types as $value => $label)
        <input type="checkbox"
              class="btn-check"
              id="type-{{ $value }}"
              name="type[]"
              value="{{ $value }}"
              {{ in_array($value, (array) request('type')) ? 'checked' : '' }}>
        <label class="btn" for="type-{{ $value }}">
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
            <th scope="col">Nombre y Apellidos</th>
            <th scope="col">Correo</th>
            <th scope="col">Entrenamiento</th>
            <th scope="col">Rol</th>
          </tr>
        </thead>
        <tbody class="table-group-divider">
          @foreach($brigades as $brigade)
            <tr>
              <th scope="row">{{ $brigade->id }}</th>
              <td>{{ $brigade->name }} {{ $brigade->lastname }}</td>
              <td>{{ $brigade->email }}</td>
              @foreach($brigade->trainingInfo as $training)
                <td>
                @if($training->evacuacion)Evacuación<br>@endif
                @if($training->prevencion_combate)Prevención/Combate de fuego<br>@endif
                @if($training->busqueda_rescate)Búsqueda y rescate<br>@endif
                @if($training->primeros_auxilios)Primeros auxilios<br>@endif
                </td>
              @endforeach
              <td>{{ $brigade->role }}</td>
            </tr>    
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection
