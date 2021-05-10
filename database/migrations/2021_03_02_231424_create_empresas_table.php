<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresas', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->bigInteger('ruc');
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('razon_social');
            $table->string('nombre_comercial');
            $table->mediumText('direccion_fiscal');
            $table->string('direccion');

            $table->string('ruta_logo')->nullable();
            $table->string('nombre_logo')->nullable();
            $table->longText('base64_logo')->nullable();
            
            $table->string('tipo_documento_contacto')->nullable();
            $table->string('documento_contacto')->nullable();
            $table->string('telefono_movil');
            $table->mediumText('nombre_contacto')->nullable();
            $table->string('correo_electronico'); 
            $table->string('whatsapp')->nullable();
            $table->string('facebook')->nullable();
            $table->string('activo')->default('SIN VERIFICAR');
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
        Schema::dropIfExists('dispositivoempresa');
        Schema::dropIfExists('empresas');
   
        
    }
}
