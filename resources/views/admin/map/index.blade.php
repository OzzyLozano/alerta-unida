@extends('layouts.admin')

@section('page-title', 'Maps')

@section('navbar')
  @include('partials.navbar.admin')
@endsection

@section('content')
  <section>
    <h1>Mapa</h1>
    @include('partials.panel.map-options')
  </section>
@endsection
