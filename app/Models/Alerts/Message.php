<?php

namespace App\Models\Alerts;

use App\Models\UserType\Brigade;
use Illuminate\Database\Eloquent\Model;

class Message extends Model {
  protected $fillable = [
    'brigade_id',
    'alert_id',
    'message',
  ];
  
  public function brigade() {
    return $this->belongsTo(Brigade::class);
  }

  public function alert() {
    return $this->belongsTo(Alerts::class);
  }
}
