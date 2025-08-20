@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Registrar Check-in</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.check_in.store') }}" method="POST">
        @csrf

        <!-- Selección de alerta -->
        <div class="mb-3">
            <label for="alert_id">Alerta</label>
            <select name="alert_id" id="alert_id" class="form-control" required>
                <option value="">-- Selecciona una alerta --</option>
                @foreach($alerts as $alert)
                    <option value="{{ $alert->id }}" 
                        {{ (isset($alertId) && $alertId == $alert->id) ? 'selected' : '' }}>
                        {{ $alert->title }} ({{ $alert->status }})
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Nombre -->
        <div class="mb-3">
            <label for="name">Nombre</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>

        <!-- Correo -->
        <div class="mb-3">
            <label for="email">Correo</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>

        <!-- Punto de reunión -->
        <div class="mb-3">
            <label for="meeting_point">Punto de reunión (1 a 4)</label>
            <input type="number" name="meeting_point" id="meeting_point" class="form-control" min="1" max="4">
        </div>

        <!-- Estado del usuario -->
        <div class="mb-3">
            <label for="are_you_okay">¿Estás bien?</label>
            <select name="are_you_okay" id="are_you_okay" class="form-control" required>
                <option value="Si">Sí</option>
                <option value="No">No</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Enviar Check-in</button>
        <a href="{{ route('admin.check_in.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
