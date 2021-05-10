<?php

use App\Events\StockDisponibleEvent;
use App\Events\WebsocketDemoEvent;
use BeyondCode\LaravelWebSockets\Facades\WebSocketsRouter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\MyCustomWebSocketHandler;
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
//WebSocketsRouter::webSocket('/my-websocket',MyCustomWebSocketHandler::class);
Route::get('/', function () {
  
    return view('auth.login');
})->name('login');

Route::get('/test', function () {

  return view('welcome');
});

Route::get('/pruebamapas', function () {
broadcast(new WebsocketDemoEvent('Data')); 
    return view('welcomemapas');
  });


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');

Route::get('parametro/getApiruc/{ruc}', 'ParametroController@apiRuc')->name('getApiruc');
Route::get('parametro/getApidni/{dni}', 'ParametroController@apiDni')->name('getApidni');
Route::prefix('clientes')->group(function() 
{
  Route::get('/','ClienteController@index')->name('cliente.index')->middleware('auth');
  Route::get('/getTable', 'ClienteController@getTable')->name('cliente.getTable')->middleware('auth');
  Route::get('/getTabledispositivos/{id}', 'ClienteController@getTable_dispositivo')->name('cliente.getTabledispositivo');
  Route::get('/registrar', 'ClienteController@create')->name('cliente.create')->middleware('auth');
  Route::post('/registrar', 'ClienteController@store')->name('cliente.store')->middleware('auth');
  Route::get('/actualizar/{id}', 'ClienteController@edit')->name('cliente.edit')->middleware('auth');
  Route::put('/actualizar/{id}', 'ClienteController@update')->name('cliente.update')->middleware('auth');
  Route::get('/datos/{id}', 'ClienteController@show')->name('cliente.show')->middleware('auth');
  Route::get('/destroy/{id}', 'ClienteController@destroy')->name('cliente.destroy')->middleware('auth');
  Route::post('/getDocumento', 'ClienteController@getDocumento')->name('cliente.getDocumento');

}); 
Route::prefix('empresas')->group(function()
{
  Route::get('/', 'EmpresaController@index')->name('empresas.index')->middleware('auth');
  Route::get('/getTable', 'EmpresaController@getTable')->name('empresas.getTable');
  Route::get('/registrar','EmpresaController@create')->name('empresas.create')->middleware('auth');
  Route::post('/registrar', 'EmpresaController@store')->name('empresas.store')->middleware('auth');
  Route::get('/destroy/{id}', 'EmpresaController@destroy')->name('empresas.destroy')->middleware('auth');
  Route::get('/datos/{id}', 'EmpresaController@show')->name('empresas.show')->middleware('auth');
  Route::get('/actualizar/{id}', 'EmpresaController@edit')->name('empresas.edit')->middleware('auth');
  Route::put('/actualizar/{id}', 'EmpresaController@update')->name('empresas.update')->middleware('auth');
  Route::post('/getDocumento', 'EmpresaController@getDocumento')->name('empresas.getDocumento');
  Route::post('/getmensaje', 'EmpresaController@getmensaje')->name('empresas.getmensaje');

}); 
Route::prefix('mantenimiento/tablas/generales')->group(function() {
  Route::get('index', 'Mantenimiento\Tabla\GeneralController@index')->name('mantenimiento.tabla.general.index')->middleware('auth');
  Route::get('getTable','Mantenimiento\Tabla\GeneralController@getTable')->name('getTable');
  Route::put('update', 'Mantenimiento\Tabla\GeneralController@update')->name('mantenimiento.tabla.general.update')->middleware('auth');
});
Route::prefix('mantenimiento/tablas/detalles')->group(function() {
  Route::get('index/{id}', 'Mantenimiento\Tabla\DetalleController@index')->name('mantenimiento.tabla.detalle.index')->middleware('auth');
  Route::get('getTable/{id}','Mantenimiento\Tabla\DetalleController@getTable')->name('getTableDetalle');
  Route::get('destroy/{id}', 'Mantenimiento\Tabla\DetalleController@destroy')->name('mantenimiento.tabla.detalle.destroy')->middleware('auth');
  Route::post('store', 'Mantenimiento\Tabla\DetalleController@store')->name('mantenimiento.tabla.detalle.store')->middleware('auth');
  Route::put('update', 'Mantenimiento\Tabla\DetalleController@update')->name('mantenimiento.tabla.detalle.update')->middleware('auth');
});

Route::prefix('tipodispositivo')->group(function()
{
  Route::get('index', 'TipoDispositivoController@index')->name('tipodispositivo.index')->middleware('auth');
  Route::get('getTable','TipoDispositivoController@getTable')->name('tipodispositivo.getTable');
  Route::get('destroy/{id}', 'TipoDispositivoController@destroy')->name('tipodispositivo.destroy')->middleware('auth');
  Route::post('store', 'TipoDispositivoController@store')->name('tipodispositivo.store')->middleware('auth');
  Route::put('update', 'TipoDispositivoController@update')->name('tipodispositivo.update')->middleware('auth');
});

Route::prefix('dispositivo')->group(function()
{
  Route::get('/','DispositivoController@index')->name('dispositivo.index')->middleware('auth');
  Route::get('/getTable', 'DispositivoController@getTable')->name('dispositivo.getTable');
  Route::get('/registrar', 'DispositivoController@create')->name('dispositivo.create')->middleware('auth');
  Route::post('/registrar', 'DispositivoController@store')->name('dispositivo.store')->middleware('auth');
  Route::get('/actualizar/{id}', 'DispositivoController@edit')->name('dispositivo.edit')->middleware('auth');
  Route::put('/actualizar/{id}', 'DispositivoController@update')->name('dispositivo.update')->middleware('auth');
  Route::get('/datos/{id}', 'DispositivoController@show')->name('dispositivo.show')->middleware('auth');
  Route::get('/destroy/{id}', 'DispositivoController@destroy')->name('dispositivo.destroy')->middleware('auth');
  Route::post('/getvalores', 'DispositivoController@getvalores')->name('dispositivo.getvalores')->middleware('auth');
});
// Colaboradores
Route::prefix('mantenimiento/colaboradores')->group(function() {
  Route::get('/', 'Mantenimiento\Colaborador\ColaboradorController@index')->name('mantenimiento.colaborador.index')->middleware('auth');
  Route::get('/getTable', 'Mantenimiento\Colaborador\ColaboradorController@getTable')->name('mantenimiento.colaborador.getTable');
  Route::get('/registrar', 'Mantenimiento\Colaborador\ColaboradorController@create')->name('mantenimiento.colaborador.create')->middleware('auth');
  Route::post('/registrar', 'Mantenimiento\Colaborador\ColaboradorController@store')->name('mantenimiento.colaborador.store')->middleware('auth');
  Route::get('/actualizar/{id}', 'Mantenimiento\Colaborador\ColaboradorController@edit')->name('mantenimiento.colaborador.edit')->middleware('auth');
  Route::put('/actualizar/{id}', 'Mantenimiento\Colaborador\ColaboradorController@update')->name('mantenimiento.colaborador.update')->middleware('auth');
  Route::get('/datos/{id}', 'Mantenimiento\Colaborador\ColaboradorController@show')->name('mantenimiento.colaborador.show')->middleware('auth');
  Route::get('/destroy/{id}', 'Mantenimiento\Colaborador\ColaboradorController@destroy')->name('mantenimiento.colaborador.destroy')->middleware('auth');
  Route::post('/getDNI', 'Mantenimiento\Colaborador\ColaboradorController@getDNI')->name('mantenimiento.colaborador.getDni');
});
// Ubigeo
Route::prefix('mantenimiento/ubigeo')->group(function() {
  Route::post('/provincias', 'Mantenimiento\Ubigeo\UbigeoController@provincias')->name('mantenimiento.ubigeo.provincias')->middleware('auth');
  Route::post('/distritos', 'Mantenimiento\Ubigeo\UbigeoController@distritos')->name('mantenimiento.ubigeo.distritos')->middleware('auth');
  Route::post('/api_ruc', 'Mantenimiento\Ubigeo\UbigeoController@api_ruc')->name('mantenimiento.ubigeo.api_ruc');
});

Route::prefix('contratos')->group(function() 
{
  Route::get('/','ContratoController@index')->name('contrato.index')->middleware('auth');
  Route::get('/getTable', 'ContratoController@getTable')->name('contrato.getTable');
  Route::get('/registrar', 'ContratoController@create')->name('contrato.create')->middleware('auth');
  Route::post('/registrar', 'ContratoController@store')->name('contrato.store')->middleware('auth');
  Route::get('/actualizar/{id}', 'ContratoController@edit')->name('contrato.edit')->middleware('auth');
  Route::put('/actualizar/{id}', 'ContratoController@update')->name('contrato.update')->middleware('auth');
  Route::get('/datos/{id}', 'ContratoController@show')->name('contrato.show')->middleware('auth');
  Route::get('/destroy/{id}', 'ContratoController@destroy')->name('contrato.destroy')->middleware('auth');
  Route::post('/getDocumento', 'ContratoController@getDocumento')->name('contrato.getDocumento');
  Route::post('/rangospuntos', 'ContratoController@rangospuntos')->name('contrato.rangospuntos');

}); 
Route::prefix('rangos')->group(function() 
{
  Route::get('/','RangoController@index')->name('rangos.index')->middleware('auth');
  Route::get('/getTable', 'RangoController@getTable')->name('rangos.getTable');
  Route::get('/registrar', 'RangoController@create')->name('rangos.create')->middleware('auth');
  Route::post('/registrar', 'RangoController@store')->name('rangos.store')->middleware('auth');
  Route::get('/actualizar/{id}', 'RangoController@edit')->name('rangos.edit')->middleware('auth');
  Route::put('/actualizar/{id}', 'RangoController@update')->name('rangos.update')->middleware('auth');
  Route::get('/datos/{id}', 'RangoController@show')->name('rangos.show')->middleware('auth');
  Route::get('/destroy/{id}', 'RangoController@destroy')->name('rangos.destroy')->middleware('auth');

}); 

Route::prefix('mapas')->group(function() 
{
  Route::get('/','MapaController@index')->name('mapa.index')->middleware('auth');
});
Route::prefix('empresa')->group(function()
{
  Route::get('/', 'EmpresaPersonalController@index')->name('empresa.index')->middleware('auth');
  Route::get('/getTable', 'EmpresaPersonalController@getTable')->name('empresa.getTable');
  Route::get('/registrar','EmpresaPersonalController@create')->name('empresa.create')->middleware('auth');
  Route::post('/registrar', 'EmpresaPersonalController@store')->name('empresa.store')->middleware('auth');
  Route::get('/destroy/{id}', 'EmpresaPersonalController@destroy')->name('empresa.destroy')->middleware('auth');
  Route::get('/datos/{id}', 'EmpresaPersonalController@show')->name('empresa.show')->middleware('auth');
  Route::get('/actualizar/{id}', 'EmpresaPersonalController@edit')->name('empresa.edit')->middleware('auth');
  Route::put('/actualizar/{id}', 'EmpresaPersonalController@update')->name('empresa.update')->middleware('auth');
  Route::post('/getDocumento', 'EmpresaPersonalController@getDocumento')->name('empresa.getDocumento');

});

Route::prefix('mensaje')->group(function()
{
  Route::get('/', 'MensajeController@index')->name('mensaje.index')->middleware('auth');
  Route::get('/getTable', 'MensajeController@getTable')->name('mensaje.getTable');
  Route::get('/registrar','MensajeController@create')->name('mensaje.create')->middleware('auth');
  Route::post('/registrar', 'MensajeController@store')->name('mensaje.store')->middleware('auth');
  Route::get('/destroy/{id}', 'MensajeController@destroy')->name('mensaje.destroy')->middleware('auth');
  Route::get('/datos/{id}', 'MensajeController@show')->name('mensaje.show')->middleware('auth');
  Route::get('/actualizar/{id}', 'MensajeController@edit')->name('mensaje.edit')->middleware('auth');
  Route::put('/actualizar/{id}', 'MensajeController@update')->name('mensaje.update')->middleware('auth');

});
Route::prefix('role')->group(function() 
{
  Route::get('/','RoleController@index')->name('roles.index')->middleware('auth');
  Route::get('/getTable', 'RoleController@getTable')->name('roles.getTable');
  Route::get('/registrar', 'RoleController@create')->name('roles.create')->middleware('auth');
  Route::post('/registrar', 'RoleController@store')->name('roles.store')->middleware('auth');
  Route::get('/actualizar/{id}', 'RoleController@edit')->name('roles.edit')->middleware('auth');
  Route::put('/actualizar/{id}', 'RoleController@update')->name('roles.update')->middleware('auth');
  Route::get('/datos/{id}', 'RoleController@show')->name('roles.show')->middleware('auth');
  Route::get('/destroy/{id}', 'RoleController@destroy')->name('roles.destroy')->middleware('auth');

});
Route::prefix('usuario')->group(function() 
{
  Route::get('/','UsuarioController@index')->name('usuarios.index')->middleware('auth');
  Route::get('/getTable', 'UsuarioController@getTable')->name('usuarios.getTable');
  Route::get('/registrar', 'UsuarioController@create')->name('usuarios.create')->middleware('auth');
  Route::post('/registrar', 'UsuarioController@store')->name('usuarios.store')->middleware('auth');
  Route::get('/actualizar/{id}', 'UsuarioController@edit')->name('usuarios.edit')->middleware('auth');
  Route::put('/actualizar/{id}', 'UsuarioController@update')->name('usuarios.update')->middleware('auth');
  Route::get('/datos/{id}', 'UsuarioController@show')->name('usuarios.show')->middleware('auth');
  Route::get('/destroy/{id}', 'UsuarioController@destroy')->name('usuarios.destroy')->middleware('auth');
  Route::post('/cambiarrol', 'UsuarioController@cambiarrol')->name('usuarios.cambiarrol');
});

/// llamado informacion mampa
Route::post('/gps','DispositivoController@gps')->name('gps')->middleware('auth');
Route::get('/gpsprueba','DispositivoController@prueba')->name('pruebagps')->middleware('auth');
Route::post('/gpsestado','DispositivoController@gpsestado')->name('gpsestado');
Route::post('/gpsmovimiento','DispositivoController@movimiento')->name('gpsmovimiento');

Route::prefix('reporte')->group(function() 
{
  Route::get('/','ReporteController@index')->name('reportes.index')->middleware('auth');
  Route::post('/data', 'ReporteController@data')->name('reportes.data');
  Route::get('/alerta','ReporteController@alerta')->name('reportes.alerta')->middleware('auth');
  Route::post('/datalerta','ReporteController@datalerta')->name('reportes.datalerta');
  Route::post('/reportemovimiento','ReporteController@reportemovimiento')->name('reportes.movimientopdf');
  Route::post('/reportealerta','ReporteController@reportealerta')->name('reportes.alertapdf');
  
});
 

Route::prefix('notificacion')->group(function() 
{
  Route::get('/','NotificacionController@index')->name('notificacion.index')->middleware('auth');
  Route::post('/leer','NotificacionController@leer')->name('notificacion.leer');
  Route::post('/data','NotificacionController@data')->name('notificacion.data');
  Route::get('/getTable','NotificacionController@getTable')->name('notificacion.getTable');
});
//-----------Api (passport library)
Route::get('/rango','MapaController@rango')->name('mapas.rango')->middleware('auth');
Route::post('/agregar_rango','MapaController@agregar_rango')->name('mapas.agregar_rango')->middleware('auth');
Route::post('/verificardispositivo','DispositivoController@verificardispositivo')->name('verificardispositivo')->middleware('auth');



Route::prefix('rmapa')->group(function()
{
  Route::get('/','RMapaController@index')->name('rmapa.index')->middleware('auth');
  Route::post('/dispositivoruta','RMapaController@dispositivoruta')->name('rmapa.dispositivoruta');
  Route::post('/dispositivos','RMapaController@dispositivos')->name('rmapa.dispositivos');
});

