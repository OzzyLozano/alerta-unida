@extends('layouts.app')

@section('page-title', 'Alert Check In')

@section('navbar')
  @include('partials.navbar.admin')
@endsection

@section('content')
  <h1>Check-In: {{ $alert->title }}</h1>
  <div class="container">
    <div class="table-responsive">
      <table class="table table-hover table-bordered">
        <thead>
          <tr>
            <th scope="col">Id</th>
            <th scope="col">Usuario</th>
            <th scope="col">Punto de reunión</th>
            <th scope="col">¿Está bien?</th>
            <th scope="col">Fecha</th>
          </tr>
        </thead>
        <tbody class="table-group-divider">
          @foreach($alert->checkins as $checkin)
            <tr>
              <th scope="row">{{ $checkin->id }}</th>
              <td>{{ $checkin->user->id }}</td>
              <td>{{ $checkin->meeting_point }}</td>
              <td>{{ $checkin->are_you_okay }}</td>
              <td>{{ $checkin->created_at->format('d/m/Y H:i') }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection
