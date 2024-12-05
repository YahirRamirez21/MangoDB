<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @vite(['resources/css/styleInfoAlmacenEA.css', 'resources/css/style-components/styleComponents.css'])
</head>
<body>
    <x-menu/>
    <main>
        <section class="contenedor-boton">
            <a href="{{ url('/inicioAlmacen') }}" style="text-decoration: none;">
                <button class="boton" type="button">Volver</button>
            </a>
        </section>

        <section class="contenedor">
        <h2>Almacén {{ $almacen->tipo }}</h2>
        <img src="{{ asset('img/valores.png') }}" alt="imagen almacén" class="imagen">
        <label class="labels"><strong>Capacidad del Almacén: </strong> {{ $almacen->capacidad }}</label>
        <label class="labels"><strong>Inventario: </strong> {{ $almacen->capacidad }}</label>
        <label class="labels"><strong>Porcentaje de ocupación del Almacén</strong></label>

        <div class="progress-bar-container">
            @php
                $porcentajeInventario = ($almacen->inventario / $almacen->capacidad) * 100;
            @endphp
            <div class="progress-bar" style="--progress-width: {{ $porcentajeInventario }}%;">
                @if($porcentajeInventario > 0)
                    {{ $porcentajeInventario }} %
                @endif
            </div>
        </div>

        <a href="{{ route('ingreso.cajas', str_replace(' ', '', $almacen->tipo)) }}" class="boton">Ingresar Cajas</a>

        </section>
    </main>
</body>
</html>