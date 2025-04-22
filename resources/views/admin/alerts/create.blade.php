@extends('layouts.app')

@section('page-title', 'Create Alert')

@section('content')
  <h1>Crear una Alerta</h1>
  <div class="container">
    <form action="{{ route('admin.alerts.store') }}" method="POST">
        @csrf
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group mb-2">
            <label for="title">Título:</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>
        <div class="form-group mb-2">
            <label for="content">Contenido:</label>
            <textarea name="content" id="content" class="form-control" required></textarea>
        </div>
        <div class="form-group mb-2">
            <label for="type">Tipo:</label>
            <select name="type" id="type" class="form-control" required>
              <option value="evacuacion">Evacuacion</option>
              <option value="prevencion/combate de fuego">Prevencion/Combate de fuego</option>
              <option value="busqueda y rescate">Búsqueda y rescate</option>
              <option value="primeros auxilios">Primeros auxilios</option>
            </select>
        </div>
        <a href="">Buscabas crear un simulacro? Ir a creación de simulacros.</a>
        <div class="form-group">
          <button type="submit" class="btn btn-success">Enviar</button>
        </div>
    </form>
  </div>
@endsection
