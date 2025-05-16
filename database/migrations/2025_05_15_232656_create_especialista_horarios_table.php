<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('especialista_horarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('especialista_id')
                  ->constrained('especialistas')
                  ->cascadeOnDelete();
            $table->time('hora');           // ej. "08:30", "14:00"
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('especialista_horarios');
    }
};
