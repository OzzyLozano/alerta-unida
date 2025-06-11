<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alerts extends Model {
  protected $fillable = [
    'brigade_id',
    'title',
    'content',
    'type',
    'status',
    'simulacrum',
  ];

  public function brigade() {
    return $this->belongsTo(Brigade::class);
  }
}
