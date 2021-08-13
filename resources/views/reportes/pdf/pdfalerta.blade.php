<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<style>
    #customers {
      font-family: Arial, Helvetica, sans-serif;
      border-collapse: collapse;
      width: 100%;
    }

    #customers td, #customers th {
      border: 1px solid #ddd;
      text-align:center;
      padding: 8px;
    }

    #customers tr{background-color:rgba(255, 255, 255) }
    td{
        font-size:12px;
    }

    #customers th {
      padding-top: 5px;
      padding-bottom: 5px;
      text-align: center;
      font-size:15px;
      font-family: Courier, "Lucida Console", monospace;
      background-color: #f2f2f2;;
      color: rgb(31, 30, 30);
    }
    </style>
<body>
    <div style="position: absolute;width:100px;height:100px;top:0px;">
        <img src="{{asset('img/gps.png')}}" width="60" >
    </div>
    <div style="position: absolute;font-size:25px;left:16%;">
        REPORTE DE ALERTAS
    </div>
    <div style="position: absolute;font-size:15px;top:55px;">
        CLIENTE : {{$cliente}}
    </div>
    <div style="position: absolute;left:70%;font-size:12px;">
          <div>
        DISPOSITIVO : {{$dispositivo}}
    </div>
    <div>
        PLACA : {{$placa}}
    </div>
    <div>
      COLOR : {{$color}}
  </div>


    <div>
        FECHA INICIAL.R : {{$fecha." ".$hinicio}}
    </div>

    <div>
        FECHA FINAL.R : {{$fecha." ".$hfinal}}
    </div>
    <div>
        FECHA EMISION : {{date("Y/m/d H:i:s", time())}}
    </div>

    </div>

    <br>
    <br>

    <br>
    <br>
    <br>
    <table id="customers">
        <tr>
          <th>FECHA</th>
          <th>TIPO ALERTA</th>
          <th>MOVIMIENTO</th>
          <th>LAT/LONG</th>
          <th>DIRECCION</th>
          <th style="width:100px;">VELOCIDAD</th>
        </tr>

       <?php for($i = 0; $i < count($arreglodispositivo); $i++){?>
       <tr>
        <td>{{$arreglodispositivo[$i]->fecha}}</td>
        <td>{{$arreglodispositivo[$i]->tipoalerta}}</td>
        <td>{{$arreglodispositivo[$i]->movimiento}}</td>
        <td>{{$arreglodispositivo[$i]->latlng}}</td>
        <td>{{$arreglodispositivo[$i]->direccion}}</td>
        <td>{{$arreglodispositivo[$i]->velocidad}}</td>

      </tr>
      <?php } ?>
      </table>
</body>
</html>
