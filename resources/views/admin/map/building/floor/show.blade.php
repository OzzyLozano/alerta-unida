@extends('layouts.admin')

@section('page-title', 'Editar Piso - Edificio')

@section('navbar')
  @include('partials.navbar.admin')
@endsection

@section('content')
  <div class="container">
    <h1>Planta: {{ $floor->level }}</h1>
    
    <a href="{{ route('admin.map.floor.add.equipment', ['building' => $building->id, 'id' => $floor->id]) }}">Agregar equipamiento a este piso</a>
    <a href="{{ route('admin.map.floor.edit', ['building' => $building->id, 'id' => $floor->id]) }}" class="btn btn-secondary">Editar Piso</a>
  </div>

@endsection
