<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void {
    Schema::create('training_info', function (Blueprint $table) {
      $table->id();
      $table->foreignId('brigade_id')->constrained('brigade')->onDelete('cascade');
      $table->boolean('evacuacion')->default(false);
      $table->boolean('prevencion_combate')->default(false);
      $table->boolean('busqueda_rescate')->default(false);
      $table->boolean('primeros_auxilios')->default(false);
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void {
    Schema::dropIfExists('training_info');
  }
};
