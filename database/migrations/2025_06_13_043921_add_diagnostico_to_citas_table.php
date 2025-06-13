<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('citas', function (Blueprint $table) {
            $table->string('diagnostico', 500)
                  ->nullable()
                  ->after('notas');
        });
    }

    public function down()
    {
        Schema::table('citas', function (Blueprint $table) {
            $table->dropColumn('diagnostico');
        });
    }
};
