@extends('layouts.app')

@section('page-title', 'Chat')

@section('navbar')
  @include('components.navbar.admin')
@endsection

@section('content')
  <div class="container">
    <h1 class="mb-4">Chat de la Alerta: {{ $alert->title }}</h1>
    <p><strong>Descripción:</strong> {{ $alert->content }}</p>

    <div class="card mt-4">
      <div class="card-body" style="max-height: 350px; overflow-y: auto;">
        @forelse($alert->messages as $message)
          <div class="m-0">
            <strong>{{ $message->brigade->name }} {{ $message->brigade->lastname }}:</strong>
            <p class="mb-2">{{ $message->message }}</p>
            <small class="text-muted">{{ $message->created_at->format('d/m/Y H:i') }}</small>
            <hr class="my-1">
          </div>
        @empty
          <p>No hay mensajes para esta alerta.</p>
        @endforelse
      </div>
    </div>

    <!-- Enviar un nuevo mensaje -->
    <form action="{{ route('admin.messages.store') }}" method="POST" class="mt-4">
      @csrf
      <div class="form-group">
        <label for="brigade_id">Brigadista</label>
        <select name="brigade_id" id="brigade_id" class="form-control" required>
          <option value="">Seleccione un brigadista</option>
          @foreach($brigadists as $brigadist)
            <option value="{{ $brigadist->id }}" {{ old('brigade_id') == $brigadist->id ? 'selected' : '' }}>
              {{ $brigadist->name }} {{ $brigadist->lastname }}
            </option>
          @endforeach
        </select>
        @error('brigade_id')
          <div class="alert alert-danger">{{ $message }}</div>
        @enderror
      </div>
      <input type="hidden" name="alert_id" value="{{ $alert->id }}">
      <div class="mb-3">
        <label for="message" class="form-label">Nuevo mensaje:</label>
        <textarea name="message" id="message" class="form-control" rows="3" required></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Enviar</button>
    </form>
  </div>
@endsection
