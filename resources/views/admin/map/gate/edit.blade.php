@extends('layouts.admin')

@section('page-title', 'Editar Portería')

@section('navbar')
  @include('partials.navbar.admin')
@endsection

@section('content')
  <div class="container">
    <h1>Editar Portería {{ $gate->id }}</h1>
    
    <form action="{{ route('admin.map.gate.update', $gate->id) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <h2>Equipamiento relacionado</h2>
      <div class="mb-3">
        @foreach($equipments as $equipment)
          <div id="equipment-{{ $equipment->id }}-container">
            @php
              $pivots = $gate->equipments->where('id', $equipment->id);
            @endphp

            @foreach($pivots as $pivot)
              <div class="card mb-2 p-2 equipment-entry">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="equipments[{{ $equipment->id }}][{{ $loop->index }}][selected]" checked>
                  <label class="form-check-label">{{ $equipment->description }}</label>
                </div>

                <div class="row mt-1">
                  <div class="col">
                    <label>Latitud</label>
                    <input type="number" step="0.0000000001" class="form-control" name="equipments[{{ $equipment->id }}][{{ $loop->index }}][latitude]" value="{{ $pivot->pivot->latitude }}">
                  </div>
                  <div class="col">
                    <label>Longitud</label>
                    <input type="number" step="0.0000000001" class="form-control" name="equipments[{{ $equipment->id }}][{{ $loop->index }}][longitude]" value="{{ $pivot->pivot->longitude }}">
                  </div>
                </div>
              </div>
            @endforeach
          </div>
          <button type="button" class="btn btn-sm btn-outline-primary" onclick="addEquipment({{ $equipment->id }})">Agregar otro</button>
        @endforeach
      </div>

      <div class="form-group">
        <label for="description">Descripción</label>
        <textarea name="description" id="description" class="form-control" rows="5">{{ $gate->description }}</textarea>
        @error('description')
          <div class="alert alert-danger">{{ $message }}</div>
        @enderror
      </div>

      <div class="form-group mb-2">
        <label for="latitude">Latitud</label>
        <input type="number" step="0.0000000001" name="latitude" id="latitude" class="form-control" value="{{ $gate->latitude }}" required>
        @error('latitude')
          <div class="alert alert-danger">{{ $message }}</div>
        @enderror
      </div>

      <div class="form-group mb-2">
        <label for="longitude">Longitud</label>
        <input type="number" step="0.0000000001" name="longitude" id="longitude" class="form-control" value="{{ $gate->longitude }}" required>
        @error('longitude')
          <div class="alert alert-danger">{{ $message }}</div>
        @enderror
      </div>

      <div class="form-group mb-2">
        <label for="img">Imagen</label>
        <input type="file" name="img" id="img" class="form-control">
        @error('img')
          <div class="alert alert-danger">{{ $message }}</div>
        @enderror
      </div>
      <div class="form-group mb-2">
        <p>Imagen actual:</p>
        <img src="{{ $gate->img_path }}" alt="img.jpg" style="width: 200px; height: auto;">
      </div>

      <button type="submit" class="btn btn-primary">Guardar Cambios</button>
    </form>
  </div>
  
  <script>
    function addEquipment(equipmentId) {
      const container = document.getElementById(`equipment-${equipmentId}-container`);
      const index = container.querySelectorAll('.equipment-entry').length;
      const html = `
      <div class="card mb-2 p-2 equipment-entry">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="equipments[${equipmentId}][${index}][selected]" checked>
          <label class="form-check-label">Equipo adicional</label>
        </div>
        <div class="row mt-1">
          <div class="col">
            <label>Latitud</label>
            <input type="number" step="0.0000000001" class="form-control" name="equipments[${equipmentId}][${index}][latitude]" value="">
          </div>
          <div class="col">
            <label>Longitud</label>
            <input type="number" step="0.0000000001" class="form-control" name="equipments[${equipmentId}][${index}][longitude]" value="">
          </div>
        </div>
      </div>`;
      container.insertAdjacentHTML('beforeend', html);
    }
  </script>
@endsection
