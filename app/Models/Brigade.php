<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brigade extends Model {
  protected $table = 'brigade';

  protected $fillable = [
    'name',
    'lastname',
    'email',
    'password',
    'role',
  ];

  public function trainingInfo() {
    return $this->hasMany(TrainingInfo::class);
  }

  protected $hidden = [
    'password',
    'remember_token',
  ];

  protected function casts(): array {
    return [
      'email_verified_at' => 'datetime',
      'password' => 'hashed',
    ];
  }
}
