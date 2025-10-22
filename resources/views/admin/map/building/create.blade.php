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
        <label for="latitude_1">Latitud 1</label>
        <input type="number" step="0.0000000001" name="latitude_1" id="latitude_1" class="form-control" required>
        @error('latitude_1')
          <div class="alert alert-danger">{{ $message }}</div>
        @enderror
      </div>

      <div class="form-group mb-2">
        <label for="longitude_1">Longitud 1</label>
        <input type="number" step="0.0000000001" name="longitude_1" id="longitude_1" class="form-control" required>
        @error('longitude_1')
          <div class="alert alert-danger">{{ $message }}</div>
        @enderror
      </div>

      <div class="form-group mb-2">
        <label for="latitude_2">Latitud 2</label>
        <input type="number" step="0.0000000001" name="latitude_2" id="latitude_2" class="form-control" required>
        @error('latitude_2')
          <div class="alert alert-danger">{{ $message }}</div>
        @enderror
      </div>

      <div class="form-group mb-2">
        <label for="longitude_2">Longitud 2</label>
        <input type="number" step="0.0000000001" name="longitude_2" id="longitude_2" class="form-control" required>
        @error('longitude_2')
          <div class="alert alert-danger">{{ $message }}</div>
        @enderror
      </div>

      <div class="form-group mb-2">
        <label for="latitude_3">Latitud 3</label>
        <input type="number" step="0.0000000001" name="latitude_3" id="latitude_3" class="form-control" required>
        @error('latitude_3')
          <div class="alert alert-danger">{{ $message }}</div>
        @enderror
      </div>

      <div class="form-group mb-2">
        <label for="longitude_3">Longitud 3</label>
        <input type="number" step="0.0000000001" name="longitude_3" id="longitude_3" class="form-control" required>
        @error('longitude_3')
          <div class="alert alert-danger">{{ $message }}</div>
        @enderror
      </div>

      <div class="form-group mb-2">
        <label for="latitude_4">Latitud 4</label>
        <input type="number" step="0.0000000001" name="latitude_4" id="latitude_4" class="form-control" required>
        @error('latitude_4')
          <div class="alert alert-danger">{{ $message }}</div>
        @enderror
      </div>

      <div class="form-group mb-2">
        <label for="longitude_4">Longitud 4</label>
        <input type="number" step="0.0000000001" name="longitude_4" id="longitude_4" class="form-control" required>
        @error('longitude_4')
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
