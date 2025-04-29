<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Simulacrum extends Model {
  protected $table = 'simulacrum';

  protected $fillable = [
    'title',
    'type',
  ];

  public function brigade() {
    return $this->hasMany(Brigade::class);
  }
}
