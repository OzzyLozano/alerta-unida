@extends('layouts.app')

@section('page-title', 'Brigades')

@section('navbar')
  @include('components.navbar.admin')
@endsection

@section('content')
  <h1>Alertas</h1>
  <div class="container">
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
