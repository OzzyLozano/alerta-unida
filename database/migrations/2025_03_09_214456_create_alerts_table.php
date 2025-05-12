<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
    Schema::create('alerts', function (Blueprint $table) {
      $table->id();
      $table->foreignId('brigade_id')->constrained('brigade')->onDelete('cascade');
      $table->string('title');
      $table->text('content');
      $table->enum('type', ['evacuacion', 'prevencion/combate de fuego', 'busqueda y rescate', 'primeros auxilios']);
      $table->timestamps();
    });
  }

  public function down(): void {
    Schema::dropIfExists('alerts');
  }
};
