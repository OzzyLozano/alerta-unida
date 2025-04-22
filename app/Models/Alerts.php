<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alerts extends Model {
  protected $fillable = [
    'title',
    'content',
    'type',
  ];

  public function brigade() {
    return $this->hasMany(Brigade::class);
  }
}
