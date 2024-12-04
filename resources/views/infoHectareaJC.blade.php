<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Información de Hectárea</title>
    @vite(['resources/css/styleInfoHectarea.css', 'resources/css/style-components/styleComponents.css'])
</head>

<body>
    <x-menu />
    <main>
        <section id="contenedor">
            <section id="sectionInfoHectarea">
                <h2>Hectárea {{ $hectarea->id }}</h2>
                <p><strong>Renta:</strong> {{ $hectarea->renta }}</p>
                <p><strong>Porcentaje General:</strong> {{ $hectarea->porcentaje_general }}</p>
                <p><strong>Estado Cosecha: </strong> {{ $hectarea->fecha_recoleccion ? 'Autorizada' : 'No autorizada' }}</p>
            </section>

            <section id="sectionBotonesHectarea">
<<<<<<< Updated upstream
                <form action="{{ route('hectareas.autorizar', $hectarea->id) }}" method="POST" style="display:inline;" class="form">
=======
                <!-- Formulario para autorizar la hectárea -->
                <form action="{{ route('hectareas.autorizar', $hectarea->id) }}" method="POST" style="display:inline;">
>>>>>>> Stashed changes
                    @csrf
                    <button class="boton" type="submit" {{ $hectarea->porcentaje_general >= 80 ? '' : 'disabled' }} name="action" value="registrar">Autorizar Hectárea</button>
                </form>

                <!-- Botón para crear cajas -->
                <button class="boton" {{ $hectarea->fecha_recoleccion ? '' : 'disabled' }} onclick="window.location.href='{{ route('cajas.crear', $hectarea->id) }}'">Crear Cajas</button>
            </section>

            <!-- Navegación entre hectáreas del mismo tipo (subespacio cerrado) -->
            <section id="navegacion-hectarea">
                <div class="navegacion">
                    @if($currentIndex > 0)
                        <a href="{{ route('hectareas.info', $hectareasTipo[$currentIndex - 1]->id) }}">Anterior</a>
                    @endif
                    <a href="{{ route('hectareas.index') }}">Volver</a>
                    @if(isset($hectareasTipo[$currentIndex + 1]))
                        <a href="{{ route('hectareas.info', $hectareasTipo[$currentIndex + 1]->id) }}">Siguiente</a>
                    @endif
                </div>
            </section>
        </section>

        <a href="{{ route('hectareas.index') }}">
            <button class="boton" type="button">Volver</button>
        </a>
    </main>
</body>

</html>
