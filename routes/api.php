<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['middleware'=>'auth:api'], function(){
    Route::get('/clientesgps','UsersController@clientes');
    Route::get('/dispositivosgps','UsersController@dispositivos');
    Route::get('/usertoken','UsersController@usertoken');
    Route::get('/dispositivosprueba','UsersController@dispositivos_prueba');
    //mapas
    Route::get('/notificaciones','MapaController@notificaciones');
    Route::get('/notificacion_vista','MapaController@notificacion_vista');
});
Route::group(['prefix' => 'v1'], function () {
    Route::post('/login', 'UsersController@login');
    Route::get('/dispositivosgps','UsersController@dispositivosprueba');
   // Route::post('/register', 'UsersController@register');
   // Route::get('/logout', 'UsersController@logout')->middleware('auth:api');
  });