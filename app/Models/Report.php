<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model {
  protected $fillable = [
    'title',
    'description',
    'img_path',
    'status',
    'user_id',
    'brigadist_id',
  ];
  
  
  public function user() {
    return $this->belongsTo(User::class);
  }

  public function brigadeMember() {
    return $this->belongsTo(BrigadeMember::class);
  }
}
