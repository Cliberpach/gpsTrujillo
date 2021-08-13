<?php
use App\Mantenimiento\Ubigeo\Departamento;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class DepartamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departamentos')->delete();
        $file = database_path("data/ubigeo/departamentos.json");
        $json = file_get_contents($file);
        $data = json_decode($json);
        foreach ($data as $obj) {
            Departamento::create(array(
                'id' => $obj->id,
                'nombre' => $obj->nombre,
                'zona' => $obj->zona,
            ));
        }
    }
}
