<?php

namespace App\Models\Map;

use Illuminate\Database\Eloquent\Model;

class Building extends Model {
  protected $fillable = [
    'name',
    'latitude_1',
    'longitude_1',
    'latitude_2',
    'longitude_2',
    'latitude_3',
    'longitude_3',
    'latitude_4',
    'longitude_4',
    'img_path',
  ];

  public function floors() {
    return $this->hasMany(Floor::class);
  }
}
