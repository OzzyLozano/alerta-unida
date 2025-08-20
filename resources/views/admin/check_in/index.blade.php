@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Lista de Check-ins</h1>

    @if(isset($alert))
        <h4>Mostrando Check-ins para alerta: <strong>{{ $alert->title }}</strong></h4>
        <a href="{{ route('admin.check_in.create', ['alert_id' => $alert->id]) }}" class="btn btn-primary mb-3">
            Nuevo Check-in para esta alerta
        </a>
    @else
        <a href="{{ route('admin.check_in.create') }}" class="btn btn-primary mb-3">
            Nuevo Check-in
        </a>
    @endif

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Formulario de filtro -->
    <form method="GET" action="{{ route('admin.check_in.index') }}" class="mb-3 row g-3 align-items-center">
        @if(isset($alert))
            <input type="hidden" name="alert_id" value="{{ $alert->id }}">
        @endif
        <div class="col-auto">
            <label for="start_date" class="col-form-label">Desde:</label>
        </div>
        <div class="col-auto">
            <input type="date" name="start_date" id="start_date" class="form-control" value="{{ $startDate ?? '' }}">
        </div>
        <div class="col-auto">
            <label for="end_date" class="col-form-label">Hasta:</label>
        </div>
        <div class="col-auto">
            <input type="date" name="end_date" id="end_date" class="form-control" value="{{ $endDate ?? '' }}">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-success">Filtrar</button>
            <a href="{{ route('admin.check_in.index') }}" class="btn btn-secondary">Limpiar</a>
        </div>
    </form>

    <!-- Mostrar conteos -->
    <div class="mb-3">
        <strong>Total Check-ins:</strong> {{ $totalCheckins }} <br>
        <strong>Mostrando:</strong> {{ $filteredCount }}
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Punto de reunión</th>
                <th>¿Está bien?</th>
                <th>Fecha y hora</th>
            </tr>
        </thead>
        <tbody>
            @forelse($checkins as $checkin)
            <tr>
                <td>{{ $checkin->name }}</td>
                <td>{{ $checkin->email }}</td>
                <td>{{ $checkin->meeting_point ?? 'N/A' }}</td>
                <td>{{ $checkin->are_you_okay }}</td>
                <td>{{ $checkin->created_at->format('d/m/Y H:i') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">No hay registros para mostrar.</td>
            </tr> 
            @endforelse
        </tbody>
    </table>
</div>
@endsection
