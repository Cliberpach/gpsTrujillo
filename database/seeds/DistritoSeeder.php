<?php

use App\Mantenimiento\Ubigeo\Distrito;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DistritoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('distritos')->delete();
        $file = database_path("data/ubigeo/distritos.json");
        $json = file_get_contents($file);
        $data = json_decode($json);
        foreach ($data as $obj) {
            Distrito::create(array(
                'id' => $obj->id,
                'departamento_id' => $obj->departamento_id,
                'departamento' => $obj->departamento,
                'provincia_id' => $obj->provincia_id,
                'provincia' => $obj->provincia,
                'nombre' => $obj->nombre,
                'nombre_legal' => $obj->nombre_legal
            ));
        }
    }
}
