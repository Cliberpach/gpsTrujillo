<?php


use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ParametroController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\Mantenimiento\Tabla\DetalleController;
use App\Http\Controllers\Mantenimiento\Tabla\GeneralController;
use App\Http\Controllers\TipoDispositivoController;
use App\Http\Controllers\DispositivoController;
use App\Http\Controllers\Mantenimiento\Colaborador\ColaboradorController;
use App\Http\Controllers\Mantenimiento\Ubigeo\UbigeoController;
use App\Http\Controllers\ContratoController;
use App\Http\Controllers\RangoController;
use App\Http\Controllers\MapaController;
use App\Http\Controllers\EmpresaPersonalController;
use App\Http\Controllers\MensajeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\NotificacionController;
use App\Http\Controllers\RMapaController;
use App\Http\Controllers\SutranController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {

    return view('auth.login');
})->name('login');



Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth');

Route::get('parametro/getApiruc/{ruc}', [ParametroController::class, 'apiruc'])->name('getApiruc');
Route::get('parametro/getApidni/{dni}', [ParametroController::class, 'apidni'])->name('getApidni');

Route::prefix('clientes')->group(function () {
    Route::get('/', [ClienteController::class, 'index'])->name('cliente.index')->middleware('auth');
    Route::get('/getTable', [ClienteController::class, 'getTable'])->name('cliente.getTable')->middleware('auth');
    Route::get('/getTableDispositivo/{id}', [ClienteController::class, 'getTableDispositivo'])->name('cliente.getTabledispositivo');
    Route::get('/registrar', [ClienteController::class, 'create'])->name('cliente.create')->middleware('auth');
    Route::post('/registrar', [ClienteController::class, 'store'])->name('cliente.store')->middleware('auth');
    Route::get('/actualizar/{id}', [ClienteController::class, 'edit'])->name('cliente.edit')->middleware('auth');
    Route::put('/actualizar/{id}', [ClienteController::class, 'update'])->name('cliente.update')->middleware('auth');
    Route::get('/datos/{id}', [ClienteController::class, 'show'])->name('cliente.show')->middleware('auth');
    Route::get('/destroy/{id}', [ClienteController::class, 'destroy'])->name('cliente.destroy')->middleware('auth');
    Route::post('/getDocumento', [ClienteController::class, 'getDocumento'])->name('cliente.getDocumento');
});
Route::prefix('empresas')->group(function () {
    Route::get('/', [EmpresaController::class, 'index'])->name('empresas.index')->middleware('auth');
    Route::get('getTable', [EmpresaController::class, 'getTable'])->name('empresas.getTable');
    Route::get('create', [EmpresaController::class, 'create'])->name('empresas.create')->middleware('auth');
    Route::post('store', [EmpresaController::class, 'store'])->name('empresas.store')->middleware('auth');
    Route::get('destroy/{id}', [EmpresaController::class, 'destroy'])->name('empresas.destroy')->middleware('auth');
    Route::get('show/{id}', [EmpresaController::class, 'show'])->name('empresas.show')->middleware('auth');
    Route::get('edit/{id}', [EmpresaController::class, 'edit'])->name('empresas.edit')->middleware('auth');
    Route::put('update/{id}', [EmpresaController::class, 'update'])->name('empresas.update')->middleware('auth');
    Route::post('getDocumento', [EmpresaController::class, 'getDocumento'])->name('empresas.getDocumento');
    Route::post('getmensaje', [EmpresaController::class, 'getmensaje'])->name('empresas.getmensaje');
});
Route::prefix('mantenimiento/tablas/generales')->group(function () {
    Route::get('index', [GeneralController::class, 'index'])->name('mantenimiento.tabla.general.index')->middleware('auth');
    Route::get('getTable', [GeneralController::class, 'getTable'])->name('getTable');
    Route::put('update', [GeneralController::class, 'update'])->name('mantenimiento.tabla.general.update')->middleware('auth');
});
Route::prefix('mantenimiento/tablas/detalles')->group(function () {
    Route::get('index/{id}', [DetalleController::class, 'index'])->name('mantenimiento.tabla.detalle.index')->middleware('auth');
    Route::get('getTable/{id}', [DetalleController::class, 'getTable'])->name('mantenimiento.getTableDetalle');
    Route::get('destroy/{id}', [DetalleController::class, 'destroy'])->name('mantenimiento.tabla.detalle.destroy')->middleware('auth');
    Route::post('store', [DetalleController::class, 'store'])->name('mantenimiento.tabla.detalle.store')->middleware('auth');
    Route::put('update', [DetalleController::class, 'update'])->name('mantenimiento.tabla.detalle.update')->middleware('auth');
});

Route::prefix('tipodispositivo')->group(function () {
    Route::get('index', [TipoDispositivoController::class, 'index'])->name('tipodispositivo.index')->middleware('auth');
    Route::get('getTable', [TipoDispositivoController::class, 'getTable'])->name('tipodispositivo.getTable');
    Route::get('destroy/{id}', [TipoDispositivoController::class, 'destroy'])->name('tipodispositivo.destroy')->middleware('auth');
    Route::post('store', [TipoDispositivoController::class, 'store'])->name('tipodispositivo.store')->middleware('auth');
    Route::put('update', [TipoDispositivoController::class, 'update'])->name('tipodispositivo.update')->middleware('auth');
});

Route::prefix('dispositivo')->group(function () {
    Route::get('/', [DispositivoController::class, 'index'])->name('dispositivo.index')->middleware('auth');
    Route::get('getTable', [DispositivoController::class, 'getTable'])->name('dispositivo.getTable');
    Route::get('create', [DispositivoController::class, 'create'])->name('dispositivo.create')->middleware('auth');
    Route::post('store', [DispositivoController::class, 'store'])->name('dispositivo.store')->middleware('auth');
    Route::get('edit/{id}', [DispositivoController::class, 'edit'])->name('dispositivo.edit')->middleware('auth');
    Route::put('update/{id}', [DispositivoController::class, 'update'])->name('dispositivo.update')->middleware('auth');
    Route::get('show/{id}', [DispositivoController::class, 'show'])->name('dispositivo.show')->middleware('auth');
    Route::get('destroy/{id}', [DispositivoController::class, 'destroy'])->name('dispositivo.destroy')->middleware('auth');
    Route::post('getvalores', [DispositivoController::class, 'getvalores'])->name('dispositivo.getvalores')->middleware('auth');
});
// Colaboradores
Route::prefix('mantenimiento/colaboradores')->group(function () {
    Route::get('/', [ColaboradorController::class, 'index'])->name('mantenimiento.colaborador.index')->middleware('auth');
    Route::get('getTable', [ColaboradorController::class, 'getTable'])->name('mantenimiento.colaborador.getTable');
    Route::get('registrar', [ColaboradorController::class, 'create'])->name('mantenimiento.colaborador.create')->middleware('auth');
    Route::post('registrar', [ColaboradorController::class, 'store'])->name('mantenimiento.colaborador.store')->middleware('auth');
    Route::get('actualizar/{id}', [ColaboradorController::class, 'edit'])->name('mantenimiento.colaborador.edit')->middleware('auth');
    Route::put('actualizar/{id}', [ColaboradorController::class, 'update'])->name('mantenimiento.colaborador.update')->middleware('auth');
    Route::get('datos/{id}', [ColaboradorController::class, 'show'])->name('mantenimiento.colaborador.show')->middleware('auth');
    Route::get('destroy/{id}', [ColaboradorController::class, 'destroy'])->name('mantenimiento.colaborador.destroy')->middleware('auth');
    Route::post('getDNI', [ColaboradorController::class, 'getDNI'])->name('mantenimiento.colaborador.getDni');
});
// Ubigeo
Route::prefix('mantenimiento/ubigeo')->group(function () {
    Route::post('/provincias', [UbigeoController::class, 'provincias'])->name('mantenimiento.ubigeo.provincias')->middleware('auth');
    Route::post('/distritos', [UbigeoController::class, 'distritos'])->name('mantenimiento.ubigeo.distritos')->middleware('auth');
    Route::post('/api_ruc', [UbigeoController::class, 'api_ruc'])->name('mantenimiento.ubigeo.api_ruc');
});

Route::prefix('contratos')->group(function () {
    Route::get('/', [ContratoController::class, 'index'])->name('contrato.index')->middleware('auth');
    Route::get('/getTable', [ContratoController::class, 'getTable'])->name('contrato.getTable');
    Route::get('/registrar', [ContratoController::class, 'create'])->name('contrato.create')->middleware('auth');
    Route::post('/registrar', [ContratoController::class, 'store'])->name('contrato.store')->middleware('auth');
    Route::get('/actualizar/{id}', [ContratoController::class, 'edit'])->name('contrato.edit')->middleware('auth');
    Route::put('/actualizar/{id}', [ContratoController::class, 'update'])->name('contrato.update')->middleware('auth');
    Route::get('/datos/{id}', [ContratoController::class, 'show'])->name('contrato.show')->middleware('auth');
    Route::get('/destroy/{id}', [ContratoController::class, 'destroy'])->name('contrato.destroy')->middleware('auth');
    Route::post('/getDocumento', [ContratoController::class, 'getDocumento'])->name('contrato.getDocumento');
    Route::post('/rangospuntos', [ContratoController::class, 'rangospuntos'])->name('contrato.rangospuntos');
});
Route::prefix('rangos')->group(function () {
    Route::get('/', [RangoController::class, 'index'])->name('rangos.index')->middleware('auth');
    Route::get('/getTable', [RangoController::class, 'getTable'])->name('rangos.getTable');
    Route::get('/registrar', [RangoController::class, 'create'])->name('rangos.create')->middleware('auth');
    Route::post('/registrar', [RangoController::class, 'store'])->name('rangos.store')->middleware('auth');
    Route::get('/actualizar/{id}', [RangoController::class, 'edit'])->name('rangos.edit')->middleware('auth');
    Route::put('/actualizar/{id}', [RangoController::class, 'update'])->name('rangos.update')->middleware('auth');
    Route::get('/datos/{id}', [RangoController::class, 'show'])->name('rangos.show')->middleware('auth');
    Route::get('/destroy/{id}', [RangoController::class, 'destroy'])->name('rangos.destroy')->middleware('auth');
});

Route::prefix('mapas')->group(function () {
    Route::get('/', [MapaController::class, 'index'])->name('mapa.index')->middleware('auth');
});
Route::prefix('empresa')->group(function () {
    Route::get('/', [EmpresaPersonalController::class, 'index'])->name('empresa.index')->middleware('auth');
    Route::get('/getTable', [EmpresaPersonalController::class, 'getTable'])->name('empresa.getTable');
    Route::get('/registrar', [EmpresaPersonalController::class, 'create'])->name('empresa.create')->middleware('auth');
    Route::post('/registrar', [EmpresaPersonalController::class, 'store'])->name('empresa.store')->middleware('auth');
    Route::get('/destroy/{id}', [EmpresaPersonalController::class, 'destroy'])->name('empresa.destroy')->middleware('auth');
    Route::get('/datos/{id}', [EmpresaPersonalController::class, 'show'])->name('empresa.show')->middleware('auth');
    Route::get('/actualizar/{id}', [EmpresaPersonalController::class, 'edit'])->name('empresa.edit')->middleware('auth');
    Route::put('/actualizar/{id}', [EmpresaPersonalController::class, 'update'])->name('empresa.update')->middleware('auth');
    Route::post('/getDocumento', [EmpresaPersonalController::class, 'getDocumento'])->name('empresa.getDocumento');
});

Route::prefix('mensaje')->group(function () {
    Route::get('/', [MensajeController::class, 'index'])->name('mensaje.index')->middleware('auth');
    Route::get('/getTable', [MensajeController::class, 'getTable'])->name('mensaje.getTable');
    Route::get('/registrar', [MensajeController::class, 'create'])->name('mensaje.create')->middleware('auth');
    Route::post('/registrar', [MensajeController::class, 'store'])->name('mensaje.store')->middleware('auth');
    Route::get('/destroy/{id}', [MensajeController::class, 'destroy'])->name('mensaje.destroy')->middleware('auth');
    Route::get('/datos/{id}', [MensajeController::class, 'show'])->name('mensaje.show')->middleware('auth');
    Route::get('/actualizar/{id}', [MensajeController::class, 'edit'])->name('mensaje.edit')->middleware('auth');
    Route::put('/actualizar/{id}', [MensajeController::class, 'update'])->name('mensaje.update')->middleware('auth');
});
Route::prefix('role')->group(function () {
    Route::get('/', [RoleController::class, 'index'])->name('roles.index')->middleware('auth');
    Route::get('/getTable', [RoleController::class, 'getTable'])->name('roles.getTable');
    Route::get('/registrar', [RoleController::class, 'create'])->name('roles.create')->middleware('auth');
    Route::post('/registrar', [RoleController::class, 'store'])->name('roles.store')->middleware('auth');
    Route::get('/actualizar/{id}', [RoleController::class, 'edit'])->name('roles.edit')->middleware('auth');
    Route::put('/actualizar/{id}', [RoleController::class, 'update'])->name('roles.update')->middleware('auth');
    Route::get('/datos/{id}', [RoleController::class, 'show'])->name('roles.show')->middleware('auth');
    Route::get('/destroy/{id}', [RoleController::class, 'destroy'])->name('roles.destroy')->middleware('auth');
});
Route::prefix('usuario')->group(function () {
    Route::get('/', [UsuarioController::class, 'index'])->name('usuarios.index')->middleware('auth');
    Route::get('/getTable', [UsuarioController::class, 'getTable'])->name('usuarios.getTable');
    Route::get('/registrar', [UsuarioController::class, 'create'])->name('usuarios.create')->middleware('auth');
    Route::post('/registrar', [UsuarioController::class, 'store'])->name('usuarios.store')->middleware('auth');
    Route::get('/actualizar/{id}', [UsuarioController::class, 'edit'])->name('usuarios.edit')->middleware('auth');
    Route::put('/actualizar/{id}', [UsuarioController::class, 'update'])->name('usuarios.update')->middleware('auth');
    Route::get('/datos/{id}', [UsuarioController::class, 'show'])->name('usuarios.show')->middleware('auth');
    Route::get('/destroy/{id}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy')->middleware('auth');
    Route::post('/cambiarrol', [UsuarioController::class, 'cambiarrol'])->name('usuarios.cambiarrol');
});

/// llamado informacion mampa
Route::post('/gps', [DispositivoController::class, 'gps'])->name('gps')->middleware('auth');
Route::post('/gpsposicion', [DispositivoController::class, 'gpsposicion'])->name('gps')->middleware('auth');
Route::get('/gpsprueba', [DispositivoController::class, 'prueba'])->name('pruebagps')->middleware('auth');
Route::post('/gpsestado', [DispositivoController::class, 'gpsestado'])->name('gpsestado');
Route::post('/gpsmovimiento', [DispositivoController::class, 'movimiento'])->name('gpsmovimiento');
Route::post('/gpsruta', [DispositivoController::class, 'ruta'])->name('gpsruta');

Route::prefix('reporte')->group(function () {
    Route::get('/', [ReporteController::class, 'index'])->name('reportes.index')->middleware('auth');
    Route::get('/data', [ReporteController::class, 'data'])->name('reportes.data');
    Route::get('/alerta', [ReporteController::class, 'alerta'])->name('reportes.alerta')->middleware('auth');
    Route::get('/geozona', [ReporteController::class, 'geozona'])->name('reportes.geozona')->middleware('auth');
    Route::get('/geozonasalida', [ReporteController::class, 'geozonasalida'])->name('reportes.geozonasalida')->middleware('auth');
    Route::get('/clientescontrato', [ReporteController::class, 'clientescontrato'])->name('reportes.clientescontrato')->middleware('auth');
    Route::get('/geozonagrupo', [ReporteController::class, 'geozonagrupo'])->name('reportes.geozonagrupo')->middleware('auth');
    Route::post('/datageozona', [ReporteController::class, 'datageozona'])->name('reportes.datageozona')->middleware('auth');
    Route::get('/dispositivogeozona', [ReporteController::class, 'dispositivogeozona'])->name('reportes.dispositivogeozona')->middleware('auth');
    Route::get('/dispositivogeozonasalida', [ReporteController::class, 'dispositivogeozonasalida'])->name('reportes.dispositivogeozonasalida')->middleware('auth');
    Route::get('/dispositivogeozonagrupo', [ReporteController::class, 'dispositivogeozonagrupo'])->name('reportes.dispositivogeozonagrupo')->middleware('auth');
    Route::get('/datalerta', [ReporteController::class, 'datalerta'])->name('reportes.datalerta');
    Route::post('/reportemovimiento', [ReporteController::class, 'reportemovimiento'])->name('reportes.movimientopdf');
    Route::post('/reportealerta', [ReporteController::class, 'reportealerta'])->name('reportes.alertapdf');
});


Route::prefix('notificacion')->group(function () {
    Route::get('/', [NotificacionController::class, 'index'])->name('notificacion.index')->middleware('auth');
    Route::post('/leer', [NotificacionController::class, 'leer'])->name('notificacion.leer');
    Route::post('/data', [NotificacionController::class, 'data'])->name('notificacion.data');
    Route::get('/getTable', [NotificacionController::class, 'getTable'])->name('notificacion.getTable');
});
//-----------Api (passport library)
Route::get('/rango', [MapaController::class, 'rango'])->name('mapas.rango')->middleware('auth');
Route::post('/agregar_rango', [MapaController::class, 'agregar_rango'])->name('mapas.agregar_rango')->middleware('auth');
Route::post('/verificardispositivo', [DispositivoController::class, 'verificardispositivo'])->name('verificardispositivo')->middleware('auth');
Route::prefix('sutran')->group(function (){
    Route::get('/',[SutranController::class, 'index'])->name('sutran.index')->middleware('auth');
    Route::get('/reporte',[SutranController::class, 'reporte'])->name('sutran.reporte')->middleware('auth');
    Route::get('/reportelisten',[SutranController::class, 'reporteListen'])->name('sutran.reporte.listen')->middleware('auth');
});


Route::prefix('rmapa')->group(function () {
    Route::get('/', [RMapaController::class, 'index'])->name('rmapa.index')->middleware('auth');
    Route::post('/dispositivoruta', [RMapaController::class, 'dispositivoruta'])->name('rmapa.dispositivoruta');
    Route::post('/dispositivos', [RMapaController::class, 'dispositivos'])->name('rmapa.dispositivos');
});
