<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
    Schema::create('alerts', function (Blueprint $table) {
      $table->id();
      $table->foreignId('brigade_id')->nullable()->constrained('brigade')->onDelete('cascade')->change();
      $table->string('title');
      $table->text('content');
      $table->enum('type', ['evacuacion', 'prevencion/combate de fuego', 'busqueda y rescate', 'primeros auxilios']);
      $table->enum('status', ['active', 'resolved', 'cancelled']);
      $table->boolean('simulacrum');
      $table->timestamps();
    });
  }

  public function down(): void {
    Schema::dropIfExists('alerts');
  }
};
