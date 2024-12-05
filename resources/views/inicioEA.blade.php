<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio Encargado Almacen</title>
    @vite(['resources/css/styleinicioEA.css', 'resources/css/style-components/styleComponents.css'])
</head>
<body>
    <x-menu link="{{ url('/inicioAlmacen') }}"/>
    <div class="content">
        <h1>Elija su Almacén</h1>
        <div class="options">
            <button class="box" onclick="window.location.href='{{ url('/informacionAlmacen/Calidad') }}'">
                Calidad
                <img src="{{ asset('img/mango_calidad.png') }}" alt="Calidad" class="btn-img">
            </button>
            <button class="box" onclick="window.location.href='{{ url('/informacionAlmacen/NoCalidad') }}'">
                No Calidad
                <img src="{{ asset('img/mango_nocalidad.png') }}" alt="No Calidad" class="btn-img">
            </button>
        </div>
    </div>

</body>
</html>
