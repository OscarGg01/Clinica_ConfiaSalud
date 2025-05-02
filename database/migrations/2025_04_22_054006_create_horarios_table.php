<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('horarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('especialista_id')->constrained('especialistas')->onDelete('cascade');
            $table->date('fecha');
            $table->time('hora');
            $table->timestamps();
            
            // Índices para mejor rendimiento
            $table->index(['especialista_id', 'fecha']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('horarios');
    }
};