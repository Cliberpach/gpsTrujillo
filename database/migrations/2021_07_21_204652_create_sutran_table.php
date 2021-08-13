<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSutranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sutran', function (Blueprint $table) {
            $table->id();
            $table->string('placa');
            $table->string('latitud');
            $table->string('longitud');
            $table->string('rumbo');
            $table->string('velocidad');
            $table->string('evento');
            $table->dateTime('fecha');
            $table->dateTime('fechaemv');
            $table->string('estado');
            $table->mediumText('respuesta');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sutran');
    }
}
