<?php

namespace App\Console\Commands;
use App\Historial;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
class MovimientoUbicacion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ubicacion:movimiento';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Truncate table ubicacion and pass data for other table';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $ubicaciones=DB::table('ubicacion')->get();

	foreach($ubicaciones as $ubicacion)
	{ 
	  
        $historial =new Historial();
        $historial->imei=$ubicacion->imei;
        $historial->lat=$ubicacion->lat;
        $historial->lng=$ubicacion->lng;
        $historial->cadena=$ubicacion->cadena;
        $historial->fecha=$ubicacion->fecha;
        $historial->direccion=$ubicacion->direccion;
        $historial->save();
	  	
	  
	}
	DB::table('ubicacion')->delete();
    }
}
