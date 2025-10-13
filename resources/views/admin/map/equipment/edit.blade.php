@extends('layouts.admin')

@section('page-title', 'Editar Equipo')

@section('navbar')
  @include('partials.navbar.admin')
@endsection

@section('content')
  <div class="container">
    <h1>Editar Equipo {{ $equipment->id }}</h1>
    
    <form action="{{ route('admin.map.equipment.update') }}" method="POST" enctype="multipart/form-data">
      @csrf

      <div class="form-group">
        <label for="description">Descripción</label>
        <textarea name="description" id="description" class="form-control" rows="5">{{ old('description') }}</textarea>
        @error('description')
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

      <button type="submit" class="btn btn-primary">Guardar Cambios</button>
    </form>
  </div>
@endsection
