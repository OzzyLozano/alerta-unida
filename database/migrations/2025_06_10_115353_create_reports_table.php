<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void {
    Schema::create('reports', function (Blueprint $table) {
      $table->id();
      $table->string('title');
      $table->text('description');
      $table->string('img_path');
      $table->enum('status', ['accepted', 'on_wait', 'cancelled']);
      $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
      $table->foreignId('brigadist_id')->nullable()->constrained('brigade')->onDelete('cascade')->change();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void {
    Schema::dropIfExists('reports');
  }
};
