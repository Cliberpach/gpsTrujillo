<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstadodispositivoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estadodispositivo', function (Blueprint $table) {
            $table->id();
            $table->string('imei');
            $table->string('estado');
            $table->dateTime('fecha');
            $table->string('movimiento');
            $table->string('cadena')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('estadodispositivo');
    }
}
