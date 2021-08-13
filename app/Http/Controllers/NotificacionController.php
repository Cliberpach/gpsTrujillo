<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

class NotificacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('notificacion.index');
    }
    public function getTable()
    {
        $user = Auth::user();
        $data = DB::table('notificaciones as n')
            ->join('dispositivo as d', 'd.imei', '=', 'n.extra')
            ->select('n.user_id', 'n.informacion', 'n.read_user as readuser', 'n.creado', 'd.placa')
            ->where('n.user_id', $user->id)
            ->orderByRaw('n.id DESC')
            ->get();
        return Datatables::of($data)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function leer(Request $request)
    {
        $user = Auth::user();
        return DB::table('notificaciones as n')
            ->join('dispositivo as d', 'd.imei', '=', 'n.extra')
            ->select('n.user_id', 'n.informacion', 'n.read_user as readuser', 'n.creado', 'd.placa')
            ->where('n.user_id', $user->id)
            ->orderByRaw('n.id DESC')
            ->get();
    }
    public function data(Request $request)
    {
        $user = Auth::user();
        return  DB::update('update notificaciones set read_user = "1" where user_id= ?', [$user->id]);
    }
}
