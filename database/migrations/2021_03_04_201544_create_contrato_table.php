<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContratoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contrato', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();

            $table->unsignedInteger('empresa_id');
            $table->unsignedInteger('cliente_id');

            $table->dateTime('fecha_inicio');
            $table->dateTime('fecha_fin');
            $table->unsignedDecimal('costo_contrato', 15, 2);
            $table->unsignedDecimal('pago_total', 15, 2);
            
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
        Schema::dropIfExists('contrato');
    }
}
