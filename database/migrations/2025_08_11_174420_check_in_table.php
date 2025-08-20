<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('check_ins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alert_id') // 🔗 Relación con la alerta activa
                  ->constrained('alerts') // referencia a tabla alerts
                  ->onDelete('cascade');  // si se borra la alerta, se borran check-ins
            $table->string('name'); // Nombre del estudiante
            $table->string('email'); // Correo del estudiante
            $table->tinyInteger('meeting_point')->nullable(); // 1 a 4 o futura geolocalización
            $table->enum('are_you_okay', ['Si', 'No']); // Estado del estudiante
            $table->timestamps(); // Fecha y hora del check-in
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('check_ins');
    }
};
