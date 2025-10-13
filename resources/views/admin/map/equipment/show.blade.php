@extends('layouts.admin')

@section('page-title', 'Equipamiento')

@section('navbar')
  @include('partials.navbar.admin')
@endsection

@section('content')
  <div class="pt-4 px-4">
    <a href="{{ route('admin.map.equipment.index') }}" class="d-inline-flex align-items-center gap-2 link-underline">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
      </svg>
      Ver Todos
    </a>
    <h1>Equipment Id: {{ $equipment->id }}</h1>
  </div>

  <div class="m-4">
    <h2>{{ $equipment->description }}</h2>
    <img src="{{ $equipment->img_path }}" alt="img.jpg" style="width: 400px; height: auto;">
    <a href="{{ route('admin.map.equipment.edit', $equipment->id) }}" class="btn btn-secondary">Edit</a>
    <form action="{{ route('admin.map.equipment.destroy', $equipment->id) }}" method="POST" style="display:inline;">
      @csrf
      @method('DELETE')
      <button type="submit" class="btn btn-danger">Delete</button>
    </form>
  </div>
@endsection
