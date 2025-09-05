@extends('layouts.app')

@section('page-title', 'Tokens FCM')

@section('navbar')
  @include('components.navbar.admin')
@endsection

@section('content')
  <h1>Tokens FCM Registrados</h1>
  
  <div class="container">
    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif
    
    @if(session('error'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    <div class="container">
      <div class="table-responsive">
        <table class="table table-hover table-bordered">
          <thead>
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Usuario/Brigadista</th>
              <th scope="col">Tipo</th>
              <th scope="col">Token</th>
              <th scope="col">Device ID</th>
              <th scope="col">Plataforma</th>
              <th scope="col">Registrado</th>
              <th scope="col">Modificado</th>
              <th scope="col">Acciones</th>
            </tr>
          </thead>
          <tbody class="table-group-divider">
            @foreach($tokens as $token)
              <tr>
                <th scope="row">{{ $token->id }}</th>
                <td>
                  @if($token->user_id)
                    {{ $token->user->name ?? 'N/A' }} {{ $token->user->lastname ?? '' }}
                  @elseif($token->brigade_id)
                    {{ $token->brigade->name ?? 'N/A' }} {{ $token->brigade->lastname ?? '' }}
                  @else
                    <span class="text-muted">No asociado</span>
                  @endif
                </td>
                <td>
                  @if($token->user_id)
                    <span class="badge bg-success">Usuario</span>
                  @else
                    <span class="badge bg-warning text-dark">Brigadista</span>
                  @endif
                </td>
                <td>
                  <small class="font-monospace" style="font-size: 0.8em;">
                    {{ Str::limit($token->token, 30) }}
                  </small>
                  <button class="btn btn-sm btn-outline-secondary ms-1" 
                          onclick="copyToClipboard('{{ $token->token }}')"
                          title="Copiar token">
                    <i class="bi bi-clipboard"></i>
                  </button>
                </td>
                <td>
                  <small class="font-monospace">{{ $token->device_id }}</small>
                </td>
                <td>{{ $token->platform }}</td>
                <td>
                  {{ $token->created_at->format('d/m/Y H:i') }}
                  <br><small class="text-muted">{{ $token->created_at->diffForHumans() }}</small>
                </td>
                <td>
                  {{ $token->updated_at->format('d/m/Y H:i') }}
                  <br><small class="text-muted">{{ $token->updated_at->diffForHumans() }}</small>
                </td>
                <td>
                  <form action="{{ route('admin.fcm.destroy', $token->id) }}" 
                        method="POST" 
                        onsubmit="return confirm('¿Estás seguro de eliminar este token?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" title="Eliminar">
                      <i class="bi bi-trash"></i>
                    </button>
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>

    @if($tokens->isEmpty())
      <div class="alert alert-info mt-3">
        No hay tokens FCM registrados aún.
      </div>
    @endif
  </div>
@endsection

@push('scripts')
  <script>
    function copyToClipboard(text) {
      navigator.clipboard.writeText(text).then(() => {
        alert('Token copiado al portapapeles');
      }).catch(err => {
        console.error('Error al copiar: ', err);
      });
    }

    // Auto-ocultar alerts después de 5 segundos
    setTimeout(() => {
      const alerts = document.querySelectorAll('.alert');
      alerts.forEach(alert => {
        const bsAlert = new bootstrap.Alert(alert);
        bsAlert.close();
      });
    }, 5000);
  </script>
@endpush