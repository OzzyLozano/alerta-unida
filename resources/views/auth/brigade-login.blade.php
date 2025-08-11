@extends('layouts.app')

@section('page-title', 'Iniciar sesión como Brigadista')

@section('content')
  <div class="container mt-5 w-25">
    <h2 class="text-center mb-4">Ingreso de Brigadistas</h2>
    
    @if ($errors->any())
      <div class="alert alert-danger">
        <strong>¡Ups!</strong> Hay algunos problemas con tus datos:<br><br>
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('brigade.login') }}">
      @csrf
      <div class="form-group mb-3">
        <label for="email">Correo electrónico</label>
        <input type="email" class="form-control" name="email" id="email" required autofocus>
      </div>

      <div class="form-group mb-3">
        <label for="password">Contraseña</label>
        <input type="password" class="form-control" name="password" id="password" required>
      </div>

      <div class="form-group mb-3 form-check">
        <input type="checkbox" name="remember" class="form-check-input" id="remember">
        <label class="form-check-label" for="remember">Recordarme</label>
      </div>

      <button type="submit" class="btn btn-primary w-100">Iniciar Sesión</button>
    </form>
  </div>
@endsection
