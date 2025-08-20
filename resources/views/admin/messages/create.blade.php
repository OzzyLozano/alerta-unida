@extends('layouts.app')

@section('content')
    <h1>Enviar mensaje</h1>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.messages.store') }}" method="POST">
        @csrf
        <label for="email">Correo electrónico:</label><br>
        <input type="email" name="email" id="email" value="{{ old('email') }}" required><br><br>

        <label for="message">Mensaje:</label><br>
        <textarea name="message" id="message" cols="30" rows="5" required>{{ old('message') }}</textarea><br><br>

        <button type="submit">Enviar</button>
    </form>

    <br>
    
@endsection