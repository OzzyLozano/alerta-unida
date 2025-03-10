<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
      Schema::create('simulacrum', function (Blueprint $table) {
      $table->id();
      $table->string('title');
      $table->enum('type', ['evacuacion', 'prevencion/combate de fuego', 'busqueda y rescate', 'primeros auxilios']);
      $table->timestamps();
    });
  }

  public function down(): void {
    Schema::dropIfExists('simulacrum');
  }
};
