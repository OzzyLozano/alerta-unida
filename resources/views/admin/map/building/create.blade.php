@extends('layouts.admin')

@section('page-title', 'Crear Edificio')

@section('navbar')
  @include('partials.navbar.admin')
@endsection

@section('content')
  <div class="container">
    <h1>Crear Nuevo Edificio</h1>
    
    <form action="{{ route('admin.map.building.store') }}" method="POST" enctype="multipart/form-data">
      @csrf

      <div class="form-group">
        <label for="name">Nombre</label>
        <textarea name="name" id="name" class="form-control" rows="5" required></textarea>
        @error('name')
          <div class="alert alert-danger">{{ $message }}</div>
        @enderror
      </div>

      <div class="form-group mb-2">
        <label for="initial_latitude">Latitud Inicial</label>
        <input type="number" step="0.0000000001" name="initial_latitude" id="initial_latitude" class="form-control" required>
        @error('initial_latitude')
          <div class="alert alert-danger">{{ $message }}</div>
        @enderror
      </div>

      <div class="form-group mb-2">
        <label for="initial_longitude">Longitud Inicial</label>
        <input type="number" step="0.0000000001" name="initial_longitude" id="initial_longitude" class="form-control" required>
        @error('initial_longitude')
          <div class="alert alert-danger">{{ $message }}</div>
        @enderror
      </div>

      <div class="form-group mb-2">
        <label for="final_latitude">Latitud Final</label>
        <input type="number" step="0.0000000001" name="final_latitude" id="final_latitude" class="form-control" required>
        @error('final_latitude')
          <div class="alert alert-danger">{{ $message }}</div>
        @enderror
      </div>

      <div class="form-group mb-2">
        <label for="final_longitude">Longitud Final</label>
        <input type="number" step="0.0000000001" name="final_longitude" id="final_longitude" class="form-control" required>
        @error('final_longitude')
          <div class="alert alert-danger">{{ $message }}</div>
        @enderror
      </div>

      <div class="form-group mb-2">
        <label for="img">Imagen</label>
        <input type="file" name="img" id="img" class="form-control" required>
        @error('img')
          <div class="alert alert-danger">{{ $message }}</div>
        @enderror
      </div>

      <button type="submit" class="btn btn-primary">Crear</button>
    </form>
  </div>
@endsection
