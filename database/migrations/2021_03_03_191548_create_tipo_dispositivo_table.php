<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipoDispositivoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipodispositivo', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->string('nombre');
            $table->string('ruta_logo')->nullable();
            $table->string('nombre_logo')->nullable();
            $table->longText('base64_logo')->nullable();
            $table->unsignedDecimal('precio', 15, 2);
            $table->enum('activo',['VIGENTE','NO VIGENTE'])->default('VIGENTE');
            $table->enum('estado',['ACTIVO','ANULADO'])->default('ACTIVO');
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
        Schema::dropIfExists('tipodispositivo');
    }
}
