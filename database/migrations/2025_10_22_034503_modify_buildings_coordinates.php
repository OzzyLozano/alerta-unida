<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('buildings', function (Blueprint $table) {
            $table->decimal('latitude_1', 14, 10);
            $table->decimal('longitude_1', 14, 10);
            $table->decimal('latitude_2', 14, 10);
            $table->decimal('longitude_2', 14, 10);
            $table->decimal('latitude_3', 14, 10);
            $table->decimal('longitude_3', 14, 10);
            $table->decimal('latitude_4', 14, 10);
            $table->decimal('longitude_4', 14, 10);
            $table->dropColumn('initial_latitude');
            $table->dropColumn('initial_longitude');
            $table->dropColumn('final_latitude');
            $table->dropColumn('final_longitude');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('buildings', function (Blueprint $table) {
            $table->dropColumn('latitude_1');
            $table->dropColumn('longitude_1');
            $table->dropColumn('latitude_2');
            $table->dropColumn('longitude_2');
            $table->dropColumn('latitude_3');
            $table->dropColumn('longitude_3');
            $table->dropColumn('latitude_4');
            $table->dropColumn('longitude_4');
            $table->decimal('initial_latitude', 14, 10);
            $table->decimal('initial_longitude', 14, 10);
            $table->decimal('final_latitude', 14, 10);
            $table->decimal('final_longitude', 14, 10);
        });
    }
};
