@extends('layouts.app')

@section('page-title', 'Users')

@section('navbar')
  @include('partials.navbar.admin')
@endsection

@section('content')
  <section>
    <h1>Usuarios</h1>
    <nav class="api-options container">
      <a href="{{ route('admin.users.create') }}">Create</a>
    </nav>
    <div class="container">
      <div class="table-responsive">
        <table class="table table-hover table-bordered">
          <thead>
            <tr>
              <th scope="col">Id</th>
              <th scope="col">Nombre y Apellidos</th>
              <th scope="col">Correo</th>
              <th scope="col">Teléfono</th>
              <th scope="col">Tipo</th>
            </tr>
          </thead>
          <tbody class="table-group-divider">
            @foreach($users as $user)
              <tr>
                <th scope="row">{{ $user->id }}</th>
                <td>{{ $user->name }} {{ $user->lastname }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->phone }}</td>
                <td>{{ $user->type }}</td>
                <td>{{ $user->email_verified_at }}</td>
              </tr>    
            @endforeach
          </tbody>
        </table>
      </div>
      {{ $users->links() }}
    </div>
  </section>
@endsection
