@extends('layouts.admin')

@section('page-title', 'Editar Piso - Edificio')

@section('navbar')
  @include('partials.navbar.admin')
@endsection

@section('content')
  <div class="container">
    <h1>Editar: {{ $floor->id }}</h1>

    <form action="{{ route('admin.map.floor.update', $floor->id) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <div class="form-group mb-3">
        <label>Nombre <span>(ejemplo, planta 1)</span></label>
        <input name="level" id="level" class="form-control" rows="5" value="{{ $floor->level }}" required>
        @error('level')
          <div class="alert alert-danger">{{ $message }}</div>
        @enderror
      </div>

      <button type="submit" class="btn btn-primary">Guardar Cambios</button>
    </form>
  </div>

@endsection
