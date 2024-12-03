<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio Encargado Almacen</title>
    <link rel="stylesheet" >
    @vite('resources/css/styleinicioEA.css')
</head>
<body>
    <div class="navbar">
        <div class="title">MangoDB</div>
        <button class="logout">Log Out</button>
    </div>
    <div class="content">
        <h1>Elija su Almacén</h1>
        <div class="options">
            <button class="box" onclick="window.location.href='{{ url('/ingresoCajasAlmacen/Calidad') }}'">Calidad</button>
            <button class="box" onclick="window.location.href='{{ url('/ingresoCajasAlmacen/NoCalidad') }}'">No Calidad</button>
        </div>
    </div>
</body>
</html>