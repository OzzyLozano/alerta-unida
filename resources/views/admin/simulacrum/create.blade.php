@extends('layouts.admin')

@section('page-title', 'Create Simulacrum')

@section('navbar')
  @include('partials.navbar.admin')
@endsection

@section('content')
  <h1>Crear un Simulacro</h1>
  <div class="container">
    <form action="{{ route('admin.simulacrums.store') }}" method="POST">
      @csrf
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <div class="form-group mb-2">
        <label for="title">Título:</label>
        <input type="text" name="title" id="title" class="form-control" required>
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
      <div class="form-group">
        <button type="submit" class="btn btn-success">Enviar</button>
      </div>
    </form>
  </div>
@endsection
