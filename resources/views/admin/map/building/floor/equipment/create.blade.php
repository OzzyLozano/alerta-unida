@extends('layouts.admin')

@section('page-title', 'Editar Piso - Equipamiento')

@section('navbar')
  @include('partials.navbar.admin')
@endsection

@section('content')
  <div class="container">
    <h1>Editar Equipamiento de Piso: {{ $floor->level }}</h1>

    <form action="{{ route('admin.map.floor.submit.equipment', ['building' => $building->id, 'id' => $floor->id]) }}" method="POST" enctype="multipart/form-data">
      @csrf

      <div id="equipments-container">
        <div class="equipment-entry mb-3 p-3 border rounded">
          <label>Equipamiento</label>
          <select name="equipments_ids[]" class="form-control mb-2" required>
            <option value="">Seleccione un equipamiento</option>
            @foreach($equipments as $equipment)
              <option value="{{ $equipment->id }}">{{ $equipment->description }}</option>
            @endforeach
          </select>
          <div class="row">
            <div class="col">
              <label>Latitud</label>
              <input type="number" step="0.0000000001" name="equipments_latitude[]" class="form-control" required>
            </div>
            <div class="col">
              <label>Longitud</label>
              <input type="number" step="0.0000000001" name="equipments_longitude[]" class="form-control" required>
            </div>
          </div>
          <button type="button" class="btn btn-sm btn-danger mt-2 remove-equipment">Eliminar</button>
        </div>
      </div>

      <button type="button" class="btn btn-outline-primary mb-3" id="add-equipment">Agregar otro equipamiento</button>

      <button type="submit" class="btn btn-primary">Guardar Cambios</button>
    </form>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const container = document.getElementById('equipments-container');
      const addBtn = document.getElementById('add-equipment');

      addBtn.addEventListener('click', function() {
        const newEntry = document.querySelector('.equipment-entry').cloneNode(true);

        // Limpiar valores
        newEntry.querySelectorAll('select, input').forEach(input => {
          if(input.tagName === 'SELECT') input.selectedIndex = 0;
          else input.value = '';
        });

        container.appendChild(newEntry);
      });

      // Delegación para eliminar bloques
      container.addEventListener('click', function(e) {
        if(e.target.classList.contains('remove-equipment')) {
          const entries = container.querySelectorAll('.equipment-entry');
          if(entries.length > 1) {
            e.target.closest('.equipment-entry').remove();
          } else {
            alert('Debe quedar al menos un equipamiento.');
          }
        }
      });
    });
  </script>
@endsection
