<?php

namespace App\Models\Map;

use Illuminate\Database\Eloquent\Model;

class MeetingPoint extends Model {
  protected $fillable = [
    'description',
    'latitude',
    'longitude',
    'img_path',
  ];
}
