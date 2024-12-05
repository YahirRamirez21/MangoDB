<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <x-menu/>
    <main>
        <h2>ALMACEN {{ $almacen->capacidad }}</h2>
        <a href="{{ route('ingreso.cajas', str_replace(' ', '', $almacen->tipo)) }}">INGRESAR CAJAS</a>

    </main>
</body>
</html>