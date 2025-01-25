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
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('about')->nullable();
            $table->string('horario')->nullable();
            $table->string('tarifa', 50)->nullable();
            $table->string('whatsapp', 20)->nullable();
            $table->string('telegram', 50)->nullable();
            $table->text('mapa')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('people');
    }
};
