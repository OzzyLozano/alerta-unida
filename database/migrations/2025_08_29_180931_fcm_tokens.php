<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void {
    Schema::create('fcm_tokens', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
      $table->foreignId('brigade_id')->nullable()->constrained('brigade')->onDelete('cascade');
      $table->string('token')->unique();
      $table->string('device_id')->nullable();
      $table->string('platform')->nullable();
      $table->timestamps();
      
      $table->index(['user_id', 'brigade_id']);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void {
    Schema::dropIfExists('fcm_tokens');
  }
};
