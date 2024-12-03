<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informacion Hectarea</title>
    @vite(['resources/css/styleInfoHectarea.css', 'resources\css\style-components\styleComponents.css'])
</head>

<body>
    <x-menu />
    <main>
        <section id="contenedor">
            <section id="sectionInfoHectarea">
                <h2>Hectarea {{ $hectarea->id ?? 'Sin id' }}</h2>
                <p><strong>Renta:</strong> {{ $hectarea->renta ?? 'Sin Renta' }}</p>
                <p><strong>Porcentaje General:</strong> {{ $hectarea->porcentaje_general ?? 'Sin Porcentaje' }}</p>
                <p><strong>Estado Cosecha: </strong> {{ $hectarea->fecha_recoleccion ? 'Autorizada' :'No autorizada' }}</p>

            </section>
            <section id="sectionBotonesHectarea">
                <form action="{{ route('hectareas.autorizar', $hectarea->id) }}" method="POST" style="display:inline;">
                    @csrf
                    <button class="boton" type="submit" name="action" value="registrar">Registrar Caja</button>
                </form>
                <button class="boton" onclick="window.location.href='{{ route('cajas.crear', $hectarea->id) }}'">Crear Cajas</button>
            </section>
        </section>
        <a href="{{ route('hectareas.index') }}">Volver a la lista de hectáreas</a>
    </main>
</body>

</html>