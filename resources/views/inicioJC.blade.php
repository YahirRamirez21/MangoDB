<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio Jefe Cuadrilla</title>
    <link rel="stylesheet">
    @vite(['resources/css/styleInicioJC.css', 'resources/js/listaHectareas.js', 'resources/css/style-components/styleComponents.css'])

</head>

<body>
    <x-menu />
    <main>
        <x-inputBusqueda />
        <section>
            @if($hectareas->isEmpty())
            <p>No tienes hectáreas asignadas.</p>
            @else
            <div class="listaHectareas">
                @foreach($hectareas as $hectarea)
                <div class="itemHectarea">
                    <strong>Hectárea:</strong> {{ $hectarea->id ?? 'Sin id' }}<br>
                    <strong>Renta:</strong> {{ $hectarea->renta ?? 'Sin renta' }}<br>
                    <strong>Porcentaje:</strong> {{ $hectarea->porcentaje_general ?? 'Sin Porcentaje general' }}<br>
                    <a class="botonVerInfo" href="{{ route('hectareas.info', $hectarea->id) }}">Ver Información</a>
                </div>
                @endforeach
            </div>

            @endif
        </section>

    </main>
</body>

</html>