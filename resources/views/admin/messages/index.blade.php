@extends('layouts.app') {{-- O el layout que uses --}}

@section('content')
    <h1>Mensajes</h1>
    

    @if(session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif
    
    <a href="{{ route('admin.messages.create') }}">Enviar nuevo mensaje</a>

    <ul>
        @forelse ($messages as $message)
            <li>
                <strong>{{ $message->email }}</strong> dijo:<br>
                {{ $message->message }}<br>
                <small>{{ $message->created_at->format('d/m/Y H:i') }}</small>
            </li>
        @empty
            <li>No hay mensajes.</li>
        @endforelse
    </ul>
@endsection
