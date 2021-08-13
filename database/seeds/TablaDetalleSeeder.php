<?php

use App\Mantenimiento\Tabla\Detalle;
use Illuminate\Database\Seeder;

class TablaDetalleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Bancos

        $detalle = new Detalle();
        $detalle->descripcion = "BANCO DE LA NACION";
        $detalle->simbolo = "BN";
        $detalle->estado = 'ACTIVO';
        $detalle->tabla_id = 2;
        $detalle->save();

        $detalle = new Detalle();
        $detalle->descripcion = "INTERCONTINENTAL";
        $detalle->simbolo = "INTERCONTINENTAL";
        $detalle->estado = 'ACTIVO';
        $detalle->tabla_id = 2;
        $detalle->save();

        $detalle = new Detalle();
        $detalle->descripcion = "MI BANCO";
        $detalle->simbolo = "MI BANCO";
        $detalle->estado = 'ACTIVO';
        $detalle->tabla_id = 2;
        $detalle->save();

        // Tipo de Monedas

        $detalle = new Detalle();
        $detalle->descripcion = "SOLES";
        $detalle->simbolo = 'S/.';
        $detalle->parametro = 'PEN';
        $detalle->estado = 'ACTIVO';
        $detalle->tabla_id = 1;
        $detalle->save();

        $detalle = new Detalle();
        $detalle->descripcion = "DOLARES";
        $detalle->simbolo = '$';
        $detalle->parametro = 'USD';
        $detalle->estado = 'ACTIVO';
        $detalle->tabla_id = 1;
        $detalle->save();




        // TIPO DE DOCUMENTO

        $detalle = new Detalle();
        $detalle->descripcion = "DOCUMENTO NACIONAL DE IDENTIDAD";
        $detalle->simbolo = 'DNI';
        $detalle->estado = 'ACTIVO';
        $detalle->tabla_id = 3;
        $detalle->save();

        $detalle = new Detalle();
        $detalle->descripcion = "CARNET DE EXTRANJERIA";
        $detalle->simbolo = 'CARNET EXT.';
        $detalle->estado = 'ACTIVO';
        $detalle->tabla_id = 3;
        $detalle->save();

        $detalle = new Detalle();
        $detalle->descripcion = "REGISTRO UNICO DE CONTRIBUYENTES";
        $detalle->simbolo = 'RUC';
        $detalle->estado = 'ACTIVO';
        $detalle->tabla_id = 3;
        $detalle->save();

        $detalle = new Detalle();
        $detalle->descripcion = "PASAPORTE";
        $detalle->simbolo = 'PASAPORTE';
        $detalle->estado = 'ACTIVO';
        $detalle->tabla_id = 3;
        $detalle->save();

        $detalle = new Detalle();
        $detalle->descripcion = "PARTIDA DE NACIMIENTO";
        $detalle->simbolo = 'P. NAC.';
        $detalle->estado = 'ACTIVO';
        $detalle->tabla_id = 3;
        $detalle->save();

        // SEXO
        $detalle = new Detalle();
        $detalle->descripcion = "HOMBRE";
        $detalle->simbolo = 'H';
        $detalle->estado = 'ACTIVO';
        $detalle->tabla_id = 4;
        $detalle->save();

        $detalle = new Detalle();
        $detalle->descripcion = "MUJER";
        $detalle->simbolo = 'M';
        $detalle->estado = 'ACTIVO';
        $detalle->tabla_id = 4;
        $detalle->save();

        // ESTADO CIVIL
        $detalle = new Detalle();
        $detalle->descripcion = "SOLTERO";
        $detalle->simbolo = 'S';
        $detalle->estado = 'ACTIVO';
        $detalle->tabla_id = 5;
        $detalle->save();

        $detalle = new Detalle();
        $detalle->descripcion = "CASADO";
        $detalle->simbolo = 'C';
        $detalle->estado = 'ACTIVO';
        $detalle->tabla_id = 5;
        $detalle->save();

        $detalle = new Detalle();
        $detalle->descripcion = "DIVORCIADO";
        $detalle->simbolo = 'D';
        $detalle->estado = 'ACTIVO';
        $detalle->tabla_id = 5;
        $detalle->save();

        $detalle = new Detalle();
        $detalle->descripcion = "VIUDO";
        $detalle->simbolo = 'V';
        $detalle->estado = 'ACTIVO';
        $detalle->tabla_id = 5;
        $detalle->save();


        $detalle = new Detalle();
        $detalle->descripcion = "CLARO";
        $detalle->simbolo = 'CLARO';
        $detalle->estado = 'ACTIVO';
        $detalle->tabla_id = 6;
        $detalle->save();

        $detalle = new Detalle();
        $detalle->descripcion = "MOVISTAR";
        $detalle->simbolo = 'MOVISTAR';
        $detalle->estado = 'ACTIVO';
        $detalle->tabla_id = 6;
        $detalle->save();

        $detalle = new Detalle();
        $detalle->descripcion = "GERENCIA GENERAL";
        $detalle->simbolo = 'GERENCIA GENERAL';
        $detalle->estado = 'ACTIVO';
        $detalle->tabla_id = 7;
        $detalle->save();

        $detalle = new Detalle();
        $detalle->descripcion = "CONTABILIDAD";
        $detalle->simbolo = 'CONTABILIDAD';
        $detalle->estado = 'ACTIVO';
        $detalle->tabla_id = 7;
        $detalle->save();

        $detalle = new Detalle();
        $detalle->descripcion = "ALMACÉN";
        $detalle->simbolo = 'ALMACÉN';
        $detalle->estado = 'ACTIVO';
        $detalle->tabla_id = 7;
        $detalle->save();

        $detalle = new Detalle();
        $detalle->descripcion = "FÁBRICA";
        $detalle->simbolo = 'FÁBRICA';
        $detalle->estado = 'ACTIVO';
        $detalle->tabla_id = 7;
        $detalle->save();

        $detalle = new Detalle();
        $detalle->descripcion = "COMERCIAL";
        $detalle->simbolo = 'COMERCIAL';
        $detalle->estado = 'ACTIVO';
        $detalle->tabla_id = 7;
        $detalle->save();

        //CARGOS
        $detalle = new Detalle();
        $detalle->descripcion = "GERENTE GENERAL";
        $detalle->simbolo = 'GERENTE GENERAL';
        $detalle->estado = 'ACTIVO';
        $detalle->tabla_id = 8;
        $detalle->save();

        $detalle = new Detalle();
        $detalle->descripcion = "ASISTENTE DE CONTABILIDAD";
        $detalle->simbolo = 'ASISTENTE DE CONTABILIDAD';
        $detalle->estado = 'ACTIVO';
        $detalle->tabla_id = 8;
        $detalle->save();

        $detalle = new Detalle();
        $detalle->descripcion = "ASISTENTE DE ALMACÉN";
        $detalle->simbolo = 'ASISTENTE DE ALMACÉN';
        $detalle->estado = 'ACTIVO';
        $detalle->tabla_id = 8;
        $detalle->save();

        $detalle = new Detalle();
        $detalle->descripcion = "OPERARIO DE FÁBRICA";
        $detalle->simbolo = 'OPERARIO DE FÁBRICA';
        $detalle->estado = 'ACTIVO';
        $detalle->tabla_id = 8;
        $detalle->save();
         //PROFESIONES
         $detalle = new Detalle();
         $detalle->descripcion = "INGENIERO(A) INDUSTRIAL";
         $detalle->simbolo = 'ING. INDUSTRIAL';
         $detalle->estado = 'ACTIVO';
         $detalle->tabla_id = 9;
         $detalle->save();
 
         $detalle = new Detalle();
         $detalle->descripcion = "INGENIERO(A) DE SISTEMAS";
         $detalle->simbolo = 'ING. SISTEMAS';
         $detalle->estado = 'ACTIVO';
         $detalle->tabla_id = 9;
         $detalle->save();
 
         $detalle = new Detalle();
         $detalle->descripcion = "INGENIERO(A) AGROINDUSTRIAL";
         $detalle->simbolo = 'ING. AGROINDUSTRIAL';
         $detalle->estado = 'ACTIVO';
         $detalle->tabla_id = 9;
         $detalle->save();
 
         $detalle = new Detalle();
         $detalle->descripcion = "CONTADOR PÚBLICO";
         $detalle->simbolo = 'CONTADOR PÚBLICO';
         $detalle->estado = 'ACTIVO';
         $detalle->tabla_id = 9;
         $detalle->save();
 
         $detalle = new Detalle();
         $detalle->descripcion = "ADMINISTRADOR";
         $detalle->simbolo = 'ADMINISTRADOR';
         $detalle->estado = 'ACTIVO';
         $detalle->tabla_id = 9;
         $detalle->save();
 
         $detalle = new Detalle();
         $detalle->descripcion = "TÉCNICO DE MAQUINARIA";
         $detalle->simbolo = 'TÉCNICO DE MAQUINARIA';
         $detalle->estado = 'ACTIVO';
         $detalle->tabla_id = 9;
         $detalle->save();

         // Grupos sanguíneos
        $detalle = new Detalle();
        $detalle->descripcion = "O NEGATIVO";
        $detalle->simbolo = 'O-';
        $detalle->estado = 'ACTIVO';
        $detalle->tabla_id = 10;
        $detalle->save();

        $detalle = new Detalle();
        $detalle->descripcion = "O POSITIVO";
        $detalle->simbolo = 'O+';
        $detalle->estado = 'ACTIVO';
        $detalle->tabla_id = 10;
        $detalle->save();

        $detalle = new Detalle();
        $detalle->descripcion = "A NEGATIVO";
        $detalle->simbolo = 'A-';
        $detalle->estado = 'ACTIVO';
        $detalle->tabla_id = 10;
        $detalle->save();

        $detalle = new Detalle();
        $detalle->descripcion = "A POSITIVO";
        $detalle->simbolo = 'A+';
        $detalle->estado = 'ACTIVO';
        $detalle->tabla_id = 10;
        $detalle->save();

        $detalle = new Detalle();
        $detalle->descripcion = "B NEGATIVO";
        $detalle->simbolo = 'B-';
        $detalle->estado = 'ACTIVO';
        $detalle->tabla_id = 10;
        $detalle->save();

        $detalle = new Detalle();
        $detalle->descripcion = "B POSITIVO";
        $detalle->simbolo = 'B+';
        $detalle->estado = 'ACTIVO';
        $detalle->tabla_id = 10;
        $detalle->save();

        //TIPO DE DOCUMENTO (VENTA)

        $detalle = new Detalle();
        $detalle->descripcion = "FACTURA";
        $detalle->simbolo = '01';
        $detalle->parametro = 'F';
        $detalle->operacion = '0101';
        $detalle->estado = 'ACTIVO';
        $detalle->tabla_id = 11;
        $detalle->save();

        $detalle = new Detalle();
        $detalle->descripcion = "BOLETA DE VENTA";
        $detalle->simbolo = '03';
        $detalle->parametro = 'B';
        $detalle->operacion = '0101';
        $detalle->estado = 'ACTIVO';
        $detalle->tabla_id = 11;
        $detalle->save();


        $detalle = new Detalle();
        $detalle->descripcion = "Trailer";
        $detalle->simbolo = 'Trailer';
        $detalle->estado = 'ACTIVO';
        $detalle->tabla_id = 12;
        $detalle->save();

        $detalle = new Detalle();
        $detalle->descripcion = "BUS";
        $detalle->simbolo = 'BUS';
        $detalle->estado = 'ACTIVO';
        $detalle->tabla_id = 12;
        $detalle->save();

        $detalle = new Detalle();
        $detalle->descripcion = "MINI-BAN";
        $detalle->simbolo = 'MINI-BAN';
        $detalle->estado = 'ACTIVO';
        $detalle->tabla_id = 12;
        $detalle->save();

        $detalle = new Detalle();
        $detalle->descripcion = "CAMIONETA";
        $detalle->simbolo = 'CAMIONETA';
        $detalle->estado = 'ACTIVO';
        $detalle->tabla_id = 12;
        $detalle->save();

        $detalle = new Detalle();
        $detalle->descripcion = "AUTO-PERSONAL";
        $detalle->simbolo = 'AUTO-PERSONAL';
        $detalle->estado = 'ACTIVO';
        $detalle->tabla_id = 12;
        $detalle->save();

        //MARCAS
        $detalle = new Detalle();
        $detalle->descripcion = "SEDAN";
        $detalle->simbolo = 'SEDAN';
        $detalle->estado = 'ACTIVO';
        $detalle->tabla_id = 13;
        $detalle->save();

        $detalle = new Detalle();
        $detalle->descripcion = "SCANIA";
        $detalle->simbolo = 'SCANIA';
        $detalle->estado = 'ACTIVO';
        $detalle->tabla_id = 13;
        $detalle->save();

        $detalle = new Detalle();
        $detalle->descripcion = "IVECO";
        $detalle->simbolo = 'IVECO';
        $detalle->estado = 'ACTIVO';
        $detalle->tabla_id = 13;
        $detalle->save();

        $detalle = new Detalle();
        $detalle->descripcion = "VOLVO";
        $detalle->simbolo = 'VOLVO';
        $detalle->estado = 'ACTIVO';
        $detalle->tabla_id = 13;
        $detalle->save();

        $detalle = new Detalle();
        $detalle->descripcion = "MAN";
        $detalle->simbolo = 'MAN';
        $detalle->estado = 'ACTIVO';
        $detalle->tabla_id = 13;
        $detalle->save();

        $detalle = new Detalle();
        $detalle->descripcion = "NISSAN";
        $detalle->simbolo = 'NISSAN';
        $detalle->estado = 'ACTIVO';
        $detalle->tabla_id = 13;
        $detalle->save();

        $detalle = new Detalle();
        $detalle->descripcion = "ISUZU";
        $detalle->simbolo = 'ISUZU';
        $detalle->estado = 'ACTIVO';
        $detalle->tabla_id = 13;
        $detalle->save();
     


    }
}
