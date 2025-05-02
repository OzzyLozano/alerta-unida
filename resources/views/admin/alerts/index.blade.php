@extends('layouts.app')

@section('page-title', 'Alerts')

@section('navbar')
  @include('components.navbar.admin')
@endsection

@section('content')
  <h1>Alertas</h1>
  <nav class="api-options">
    <a href="{{ route('admin.alerts.create') }}">Create</a>
  </nav>
  <div class="container">
    <div class="table-responsive">
      <table class="table table-hover table-bordered">
        <thead>
          <tr>
            <th scope="col">Id</th>
            <th scope="col">Titulo</th>
            <th scope="col">Contenido</th>
            <th scope="col">Tipo</th>
            <th scope="col">Estado</th>
          </tr>
        </thead>
        <tbody class="table-group-divider">
          @foreach($alerts as $alert)
            <tr>
              <th scope="row">{{ $alert->id }}</th>
              <td>{{ $alert->title }}</td>
              <td>{{ $alert->content }}</td>
              <td>{{ $alert->type }}</td>
              <td>{{ $alert->status }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection
