<?php

namespace App\Models\UserType;

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
  public function reports() {
    return $this->hasMany(Report::class);
  }
  public function alerts() {
    return $this->hasMany(Alerts::class);
  }
  public function messages() {
    return $this->hasMany(Message::class, 'brigade_id');
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
