<?php

namespace App\Models\Alerts;

use App\Models\UserType\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkin extends Model {
  use HasFactory;

  // Nombre explícito de la tabla
  protected $table = 'check_ins';

  // Campos que se pueden asignar masivamente
  protected $fillable = [
    'alert_id',
    'user_id',
    'meeting_point',
    'are_you_okay',
  ];

  // Casts para asegurar tipos correctos
  protected $casts = [
    'meeting_point' => 'integer',
    'are_you_okay' => 'string',
  ];

  // Opcional: scope para filtrar por estado
  public function scopeOnlyOk($query) {
    return $query->where('are_you_okay', 'Si');
  }

  public function scopeOnlyNotOk($query) {
    return $query->where('are_you_okay', 'No');
  }
  
  public function user() {
    return $this->belongsTo(User::class);
  }

  public function alert() {
    return $this->belongsTo(Alerts::class);
  }
}
