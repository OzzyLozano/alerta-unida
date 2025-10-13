<?php

namespace App\Models\Map;

use Illuminate\Database\Eloquent\Model;

class Gate extends Model {
  protected $fillable = [
    'description',
    'latitude',
    'longitude',
    'img_path',
  ];

  public function equipments() {
    return $this->belongsToMany(Equipment::class, 'equipment_gate', 'gate_id', 'equipment_id')->withPivot('latitude', 'longitude');
  }
}
