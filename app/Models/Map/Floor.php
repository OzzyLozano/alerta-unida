<?php

namespace App\Models\Map;

use Illuminate\Database\Eloquent\Model;

class Floor extends Model {
  protected $fillable = [
    'level',
    'building_id',
  ];

  public function equipments() {
    return $this->belongsToMany(Equipment::class, 'equipment_floor', 'floor_id', 'equipment_id');
  }
  public function building() {
    return $this->belongsTo(Building::class);
  }
}
