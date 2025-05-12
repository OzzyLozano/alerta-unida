<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up() {
    Schema::table('brigade', function (Blueprint $table) {
      $table->dropColumn('training');
    });
    }

    public function down() {
    Schema::table('brigade', function (Blueprint $table) {
      $table->string('training');
    });
  }
};
