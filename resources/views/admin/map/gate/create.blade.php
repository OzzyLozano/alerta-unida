@extends('layouts.admin')

@section('page-title', 'Crear Portería')

@section('navbar')
  @include('partials.navbar.admin')
@endsection

@section('content')
  <div class="container">
    <h1>Crear Nuevo Portería</h1>
    
    <form action="{{ route('admin.map.gate.store') }}" method="POST" enctype="multipart/form-data">
      @csrf

      <div class="form-group">
        <label for="description">Descripción</label>
        <textarea name="description" id="description" class="form-control" rows="5" required></textarea>
        @error('description')
          <div class="alert alert-danger">{{ $message }}</div>
        @enderror
      </div>

      <div class="form-group mb-2">
        <label for="latitude">Latitud</label>
        <input type="number" step="0.0000000001" name="latitude" id="latitude" class="form-control" required>
        @error('latitude')
          <div class="alert alert-danger">{{ $message }}</div>
        @enderror
      </div>

      <div class="form-group mb-2">
        <label for="longitude">Longitud</label>
        <input type="number" step="0.0000000001" name="longitude" id="longitude" class="form-control" required>
        @error('longitude')
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

      <button type="submit" class="btn btn-primary">Crear Portería</button>
    </form>
  </div>
@endsection
