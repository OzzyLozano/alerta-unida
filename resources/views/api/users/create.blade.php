@extends('layouts.app')

@section('page-title', 'Create User')

@section('content')
  <h1>Crear una Usuario</h1>
  <div class="container">
    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group mb-2">
            <label for="name">Nombre(s):</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="form-group mb-2">
            <label for="lastname">Apellidos:</label>
            <input type="text" name="lastname" id="lastname" class="form-control" required>
        </div>
        <div class="form-group mb-2">
            <label for="email">Correo:</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>
        <div class="form-group mb-2">
            <label for="password">Contraseña:</label>
            <input type="password" name="password" id="password" class="form-control" required>
            <span>Debe contener al menos 8 caracteres</span>
        </div>
        <div class="form-group mb-2">
            <label for="type">Tipo:</label>
            <select name="type" id="type" class="form-control" required>
              <option value="maestro">Maestro</option>
              <option value="estudiante">Estudiante</option>
            </select>
        </div>
        <div class="form-group">
          <button type="submit" class="btn btn-success">Enviar</button>
        </div>
    </form>
  </div>
@endsection
