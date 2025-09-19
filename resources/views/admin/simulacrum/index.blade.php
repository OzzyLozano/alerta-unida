@extends('layouts.app')

@section('page-title', 'Simulacrum')

@section('navbar')
  @include('partials.navbar.admin')
@endsection

@section('content')
  <h1>Simulacros</h1>
  <nav class="api-options container">
    <a href="{{ route('admin.simulacrums.create') }}">Create</a>
  </nav>
  <div class="container">
    <div class="table-responsive">
      <table class="table table-hover table-bordered">
        <thead>
          <tr>
            <th scope="col">Id</th>
            <th scope="col">Titulo</th>
            <th scope="col">Tipo</th>
          </tr>
        </thead>
        <tbody class="table-group-divider">
          @foreach($simulacrums as $simulacrum)
            <tr>
              <th scope="row">{{ $simulacrum->id }}</th>
              <td>{{ $simulacrum->title }}</td>
              <td>{{ $simulacrum->type }}</td>
            </tr>    
          @endforeach
        </tbody>
      </table>
    </div>
    {{ $simulacrums->links() }}
  </div>
@endsection
