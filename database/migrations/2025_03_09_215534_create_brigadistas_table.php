<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('brigade', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->string('lastname');
      $table->string('email')->unique();
      $table->string('password');
      $table->enum('role', ['lider', 'miembro'])->default('miembro');
      $table->rememberToken();
      $table->timestamps();
    });
  }

  public function down(): void {
    Schema::dropIfExists('brigade');
  }
};
