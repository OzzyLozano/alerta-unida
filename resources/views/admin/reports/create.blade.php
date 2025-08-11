@extends('layouts.app')

@section('page-title', 'Crear Reporte')

@section('navbar')
  @include('components.navbar.admin')
@endsection

@section('content')
  <div class="container">
    <h1>Crear Nuevo Reporte</h1>
    
    <form action="{{ route('admin.reports.store') }}" method="POST" enctype="multipart/form-data">
      @csrf

      <div class="form-group">
        <label for="title">Título</label>
        <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required>
        @error('title')
          <div class="alert alert-danger">{{ $message }}</div>
        @enderror
      </div>

      <div class="form-group">
        <label for="description">Descripción</label>
        <textarea name="description" id="description" class="form-control" rows="5" required>{{ old('description') }}</textarea>
        @error('description')
          <div class="alert alert-danger">{{ $message }}</div>
        @enderror
      </div>

      <div class="form-group">
        <label for="img">Imagen</label>
        <input type="file" name="img" id="img" class="form-control" required>
        @error('img')
          <div class="alert alert-danger">{{ $message }}</div>
        @enderror
      </div>
      
      <div class="form-group mb-2">
        <label for="status">Estado:</label>
          <select name="status" id="status" class="form-control" required>
            <option value="accepted">Aceptado</option>
            <option value="on_wait">En Espera</option>
            <option value="cancelled">Cancelada</option>
          </select>
      </div>

      <div class="form-group">
        <label for="user_id">Usuario</label>
        <select name="user_id" id="user_id" class="form-control" required>
          <option value="">Seleccione un usuario</option>
          @foreach($users as $user)
            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
              {{ $user->name }} ({{ $user->email }})
            </option>
          @endforeach
        </select>
        @error('user_id')
          <div class="alert alert-danger">{{ $message }}</div>
        @enderror
      </div>

      <div class="form-group">
        <label for="brigadist_id">Brigadista (Opcional)</label>
        <select name="brigadist_id" id="brigadist_id" class="form-control">
          <option value="">Seleccione un brigadista (opcional)</option>
          @foreach($brigadists as $brigadist)
            <option value="{{ $brigadist->id }}" {{ old('brigadist_id') == $brigadist->id ? 'selected' : '' }}>
              {{ $brigadist->name }}
            </option>
          @endforeach
        </select>
        @error('brigadist_id')
          <div class="alert alert-danger">{{ $message }}</div>
        @enderror
      </div>

      <button type="submit" class="btn btn-primary">Crear Reporte</button>
    </form>
  </div>
@endsection
