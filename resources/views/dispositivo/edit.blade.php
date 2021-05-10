@extends('layout')
@section('content')
@section('gps-active', 'active')
@section('dispositivo-active', 'active')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10 col-md-10">
       <h2  style="text-transform:uppercase"><b>Actualizar Dispositivo</b></h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Panel de Control</a>
            </li>
            <li class="breadcrumb-item active">
                <a href="{{ route('dispositivo.index') }}">Dispositivo</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Actualizar</strong>
            </li>
        </ol>
    </div>
</div>
@include('dispositivo._form')
@stop
