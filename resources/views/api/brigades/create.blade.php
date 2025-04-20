@extends('layouts.app')

@section('page-title', 'Create Brigade')

@section('content')
  <h1>Agrega un Brigadista</h1>
  <div class="container">
    <form action="{{ route('brigades.store') }}" method="POST">
        @csrf
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group mb-2">
            <label for="name">Nombre(s):</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="form-group mb-2">
            <label for="lastname">Apellidos:</label>
            <input type="text" name="lastname" id="lastname" class="form-control" required>
        </div>
        <div class="form-group mb-2">
            <label for="email">Correo:</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>
        <div class="form-group mb-2">
            <label for="password">Contraseña:</label>
            <input type="password" name="password" id="password" class="form-control" required>
            <span>Debe contener al menos 8 caracteres</span>
        </div>
        <div class="form-group mb-2">
          <label for="training">Entrenamientos:</label>
          <div class="form-check">
            <input type="checkbox" name="training[]" value="evacuacion" class="form-check-input" id="evacuacion">
            <label class="form-check-label" for="evacuacion">Evacuación</label>
          </div>
          <div class="form-check">
            <input type="checkbox" name="training[]" value="prevencion/combate de fuego" class="form-check-input" id="fuego">
            <label class="form-check-label" for="fuego">Prevención/Combate de fuego</label>
          </div>
          <div class="form-check">
            <input type="checkbox" name="training[]" value="busqueda y rescate" class="form-check-input" id="rescate">
            <label class="form-check-label" for="rescate">Búsqueda y rescate</label>
          </div>
          <div class="form-check">
            <input type="checkbox" name="training[]" value="primeros auxilios" class="form-check-input" id="auxilios">
            <label class="form-check-label" for="auxilios">Primeros auxilios</label>
          </div>
        </div>
        <div class="form-group mb-2">
            <label for="role">Rol:</label>
            <select name="role" id="role" class="form-control" required>
              <option value="lider">Líder</option>
              <option value="miembro">Miembro</option>
            </select>
        </div>
        <div class="form-group">
          <button type="submit" class="btn btn-success">Enviar</button>
        </div>
    </form>
    @if($errors->any())
      <ul>
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    @endif
  </div>
@endsection
