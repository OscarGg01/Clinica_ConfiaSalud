<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('citas', function (Blueprint $table) {
            // Asegúrate de usar el nombre exacto de la columna
            $table->dropColumn('imagen');
        });
    }

    public function down()
    {
        Schema::table('citas', function (Blueprint $table) {
            // Si quieres restaurarla en un rollback, define el tipo
            $table->string('imagen')->nullable();
        });
    }
};
