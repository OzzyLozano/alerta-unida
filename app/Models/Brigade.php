<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Brigade extends Authenticatable {
  use Notifiable;
  
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

  protected $casts = [
    'email_verified_at' => 'datetime',
    'password' => 'hashed',
  ];  
}
