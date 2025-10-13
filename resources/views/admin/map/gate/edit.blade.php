@extends('layouts.admin')

@section('page-title', 'Editar Portería')

@section('navbar')
  @include('partials.navbar.admin')
@endsection

@section('content')
  <div class="container">
    <h1>Editar Portería {{ $gate->id }}</h1>
    
    <form action="{{ route('admin.map.gate.update', $gate->id) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <div class="form-group">
        <label for="description">Descripción</label>
        <textarea name="description" id="description" class="form-control" rows="5">{{ $gate->description }}</textarea>
        @error('description')
          <div class="alert alert-danger">{{ $message }}</div>
        @enderror
      </div>

      <div class="form-group mb-2">
        <label for="latitude">Latitud</label>
        <input type="number" step="0.0000000001" name="latitude" id="latitude" class="form-control" value="{{ $gate->latitude }}" required>
        @error('latitude')
          <div class="alert alert-danger">{{ $message }}</div>
        @enderror
      </div>

      <div class="form-group mb-2">
        <label for="longitude">Longitud</label>
        <input type="number" step="0.0000000001" name="longitude" id="longitude" class="form-control" value="{{ $gate->longitude }}" required>
        @error('longitude')
          <div class="alert alert-danger">{{ $message }}</div>
        @enderror
      </div>

      <div class="form-group mb-2">
        <label for="img">Imagen</label>
        <input type="file" name="img" id="img" class="form-control">
        @error('img')
          <div class="alert alert-danger">{{ $message }}</div>
        @enderror
      </div>
      <div class="form-group mb-2">
        <p>Imagen actual:</p>
        <img src="{{ $gate->img_path }}" alt="img.jpg" style="width: 200px; height: auto;">
      </div>

      <button type="submit" class="btn btn-primary">Guardar Cambios</button>
    </form>
  </div>
@endsection
