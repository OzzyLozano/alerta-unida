<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Brigade;

class TrainingInfo extends Model {
  protected $table = 'training_info';

  protected $fillable = [
    'brigade_id',
    'evacuacion',
    'prevencion_combate',
    'busqueda_rescate',
    'primeros_auxilios',
  ];

  public function brigade() {
    return $this->belongsTo(Brigade::class);
  }
}
