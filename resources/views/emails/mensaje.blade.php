<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
 
</head>
<body>
    <img class="logo" src="{{$message->embed(storage_path('app/'.$path))}}" width="550" style="height:800px;">
    <br>
   {{$mensaje}}
   <br>
   USER:{{$user}}
   <br>
   password:{{$contraseña}}

</body>
</html>