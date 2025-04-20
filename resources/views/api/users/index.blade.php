@extends('layouts.app')

@section('page-title', 'Users')

@section('navbar')
  @include('components.navbar.apis')
@endsection

@section('content')
  <h1>Usuarios</h1>
  <nav class="api-options">
    <a href="{{ route('users.create') }}">Create user</a>
  </nav>
  <div class="container">
    <div class="table-responsive">
      <table class="table table-hover table-bordered">
        <thead>
          <tr>
            <th scope="col">Id</th>
            <th scope="col">Nombre y Apellidos</th>
            <th scope="col">Correo</th>
            <th scope="col">Tipo</th>
          </tr>
        </thead>
        <tbody class="table-group-divider">
          @foreach($users as $user)
            <tr>
              <th scope="row">{{ $user->id }}</th>
              <td>{{ $user->name }} {{ $user->lastname }}</td>
              <td>{{ $user->email }}</td>
              <td>{{ $user->type }}</td>
              <td>{{ $user->email_verified_at }}</td>
            </tr>    
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection
