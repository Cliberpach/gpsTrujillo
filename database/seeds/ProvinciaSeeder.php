<?php

use App\Mantenimiento\Ubigeo\Provincia;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvinciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('provincias')->delete();
        $file = database_path("data/ubigeo/provincias.json");
        $json = file_get_contents($file);
        $data = json_decode($json);
        foreach ($data as $obj) {
            Provincia::create(array(
                'id' => $obj->id,
                'nombre' => $obj->nombre,
                'departamento_id' => $obj->departamento_id
            ));
        }
    }
}
