@extends('layouts.app')

@section('page-title', 'Alerts')

@section('navbar')
  @include('components.navbar.admin')
@endsection

@section('content')
  <h1>Alertas</h1>
  <nav class="api-options container">
    <a href="{{ route('admin.alerts.create') }}">Create</a>
    <p>Filtrar por:</p>
    
    <form action="{{ route('admin.alerts.index') }}" method="get" class="filter-options">
      @php
        $types = [
          'evacuacion' => 'Evacuación',
          'prevencion/combate de fuego' => 'Prevención/Combate de fuego',
          'busqueda y rescate' => 'Búsqueda y rescate',
          'primeros auxilios' => 'Primeros auxilios',
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

      @php
        $states = [
          'active' => 'Activa',
          'resolved' => 'Resuelta',
          'cancelled' => 'Cancelada'
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

      @php
        $simulacrum_bool = [
          'false' => 'Alerta',
          'true' => 'Simulacro'
        ];
      @endphp

      @foreach($simulacrum_bool as $value => $label)
        <input  type="checkbox"
                class="btn-check"
                id="is-a-{{ $value }}"
                name="simulacrum[]"
                value="{{ $value }}"
                {{ in_array($value, (array) request('simulacrum')) ? 'checked' : '' }}>
        <label class="btn" for="is-a-{{ $value }}">
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
            <th scope="col">Id Brigadista</th>
            <th scope="col">Titulo</th>
            <th scope="col">Contenido</th>
            <th scope="col">Tipo</th>
            <th scope="col">Estado</th>
            <th scope="col">Es Simulacro</th>
            <th scope="col">Chat</th>
            <th scope="col">Check In</th>
          </tr>
        </thead>
        <tbody class="table-group-divider">
          @foreach($alerts as $alert)
            <tr>
              <th scope="row">{{ $alert->id }}</th>
              <td>{{ $alert->brigade_id ?? "admin" }}</td>
              <td>{{ $alert->title }}</td>
              <td>{{ $alert->content }}</td>
              <td>{{ $alert->type }}</td>
              <td>{{ $alert->status }}</td>
              <td>{{ $alert->simulacrum  }}</td>
              <td>
                <a href="{{ route('admin.alerts.chat', $alert->id) }}" class="btn btn-primary btn-sm">
                  Ver Chat
                </a>
              </td>
              <td>
                <a href="{{ route('admin.alerts.checkin', $alert->id) }}" class="btn btn-primary btn-sm"> 
                  Ir a Check-in 
                </a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection
