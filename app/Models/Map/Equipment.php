<?php

namespace App\Models\Map;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model {
  protected $fillable = [
    'description',
    'img_path',
  ];

  public function floors() {
    return $this->belongsToMany(Floor::class, 'equipment_floor', 'equipment_id', 'floor_id');
  }

  public function gates() {
    return $this->belongsToMany(Gate::class, 'equipment_gate', 'equipment_id', 'gate_id');
  }
}
