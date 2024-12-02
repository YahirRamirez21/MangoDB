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
            
            </section>
            <section id="sectionBotonesHectarea">
                <button class="boton">Cambiar Estado Hectarea</button>
                <button class="boton" onclick="window.location.href='{{ url('/crearCajaMangos') }}'">Crear Cajas</button>
            </section>
        </section>
        <a href="{{ route('hectareas.index') }}">Volver a la lista de hectáreas</a>
    </main>
</body>
</html>