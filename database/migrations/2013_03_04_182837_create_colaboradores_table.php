<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateColaboradoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('colaboradores', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->foreignId('persona_id')->references('id')->on('personas')->onDelete('cascade');
            $table->string('area');
            $table->string('profesion');
            $table->string('cargo');
            $table->string('telefono_referencia')->nullable();
            $table->string('contacto_referencia')->nullable();
            $table->string('grupo_sanguineo')->nullable();
            $table->text('alergias')->nullable();
            $table->unsignedTinyInteger('numero_hijos')->nullable();
            $table->unsignedDecimal('sueldo', 15,2);
            $table->unsignedDecimal('sueldo_bruto', 15,2);
            $table->unsignedDecimal('sueldo_neto', 15,2);
            $table->string('moneda_sueldo');
            $table->string('tipo_banco')->nullable();
            $table->string('numero_cuenta', 20)->nullable();
            $table->date('fecha_inicio_actividad');
            $table->date('fecha_fin_actividad')->nullable();
            $table->date('fecha_inicio_planilla')->nullable();
            $table->date('fecha_fin_planilla')->nullable();
            $table->string('ruta_imagen')->nullable();
            $table->string('nombre_imagen')->nullable();
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
        Schema::dropIfExists('colaboradores');
    }
}
