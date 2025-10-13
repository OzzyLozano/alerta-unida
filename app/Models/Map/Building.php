<?php

namespace App\Models\Map;

use Illuminate\Database\Eloquent\Model;

class Building extends Model {
  protected $fillable = [
    'name',
    'initial_latitude',
    'initial_longitude',
    'final_latitude',
    'final_longitude',
    'img_path',
  ];

  public function floors() {
    return $this->hasMany(Floor::class);
  }
}
