@extends('layouts.admin')

@section('page-title', 'Editar Edificio')

@section('navbar')
  @include('partials.navbar.admin')
@endsection

@section('content')
  <div class="container">
    <h1>Editar Edificio {{ $building->id }}</h1>
    
    <form action="{{ route('admin.map.building.update', $building->id) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <div class="form-group">
        <label for="name">Nombre</label>
        <textarea name="name" id="name" class="form-control" rows="5">{{ $building->name }}</textarea>
        @error('name')
          <div class="alert alert-danger">{{ $message }}</div>
        @enderror
      </div>

      <div class="form-group mb-2">
        <label for="initial_latitude">Latitud Inicial</label>
        <input type="number" step="0.0000000001" name="initial_latitude" id="initial_latitude" class="form-control" value="{{ $building->initial_latitude }}" required>
        @error('initial_latitude')
          <div class="alert alert-danger">{{ $message }}</div>
        @enderror
      </div>

      <div class="form-group mb-2">
        <label for="initial_longitude">Longitud Inicial</label>
        <input type="number" step="0.0000000001" name="initial_longitude" id="initial_longitude" class="form-control" value="{{ $building->initial_longitude }}" required>
        @error('initial_longitude')
          <div class="alert alert-danger">{{ $message }}</div>
        @enderror
      </div>

      <div class="form-group mb-2">
        <label for="final_latitude">Latitud Final</label>
        <input type="number" step="0.0000000001" name="final_latitude" id="final_latitude" class="form-control" value="{{ $building->final_latitude }}" required>
        @error('final_latitude')
          <div class="alert alert-danger">{{ $message }}</div>
        @enderror
      </div>

      <div class="form-group mb-2">
        <label for="final_longitude">Longitud Final</label>
        <input type="number" step="0.0000000001" name="final_longitude" id="final_longitude" class="form-control" value="{{ $building->final_longitude }}" required>
        @error('final_longitude')
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
        <img src="{{ $building->img_path }}" alt="img.jpg" style="width: 200px; height: auto;">
      </div>

      <button type="submit" class="btn btn-primary">Guardar Cambios</button>
    </form>
  </div>
@endsection
