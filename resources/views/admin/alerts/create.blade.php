@extends('layouts.admin')

@section('page-title', 'Create Alert')

@section('navbar')
  @include('partials.navbar.admin')
@endsection

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
        <div class="form-group mb-2">
            <label for="status">Estado:</label>
            <select name="status" id="status" class="form-control" required>
              <option value="active">Activa</option>
              <option value="resolved">Resuelta</option>
              <option value="cancelled">Cancelada</option>
            </select>
        </div>
        <div class="form-group mb-2">
            <label for="simulacrum">Es un simulacro?</label>
            <select name="simulacrum" id="simulacrum" class="form-control" required>
              <option value="true">Simulacro</option>
              <option value="false">Alerta</option>
            </select>
        </div>
        <div class="form-group">
          <button type="submit" class="btn btn-success">Enviar</button>
        </div>
    </form>
  </div>
@endsection
