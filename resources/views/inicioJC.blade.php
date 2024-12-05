<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio Jefe Cuadrilla</title>
    <link rel="stylesheet" href="{{ asset('css/styleInicioJC.css') }}">
    @vite(['resources/css/styleInicioJC.css', 'resources/js/listaHectareas.js', 'resources/css/style-components/styleComponents.css'])
</head>

<body>
    
<x-menu />


    <main>
        @if($hectareas->isEmpty())
            <p>No tienes hectáreas asignadas.</p>
        @else
            <!-- Formulario de Filtro -->
            <form method="GET" action="{{ route('hectareas.filtrar') }}">
                <section class="contenedor_inputs">
                    <div class="inputs">
                        <label><strong>Seleccione la opción para filtrar:</strong></label>
                        <label>
                            <input type="radio" name="tipo" value="autorizada" {{ old('tipo') == 'autorizada' ? 'checked' : '' }}>
                            Autorizada
                        </label>
                        <label>
                            <input type="radio" name="tipo" value="no_autorizada" {{ old('tipo') == 'no_autorizada' ? 'checked' : '' }}>
                            No Autorizada
                        </label>
                    </div>
                </section>
            </form>

            <!-- Lista de Hectáreas -->
            <div class="listaHectareas">
                @foreach($hectareas as $hectarea)
                    <div class="itemHectarea">
                        <!-- Imagen Representativa -->
                        <img src="{{ $hectarea->imagen_url ?? 'https://via.placeholder.com/300x150' }}" alt="Imagen de Hectárea">

                        <!-- Información de la Hectárea -->
                        <strong>Hectárea ID:</strong> {{ $hectarea->id ?? 'Sin ID' }}
                        <div class="info">
                            <strong>Renta:</strong> {{ $hectarea->renta ?? 'Sin renta' }}<br>
                            <strong>Porcentaje:</strong> {{ $hectarea->porcentaje_general ?? 'Sin Porcentaje' }}
                        </div>
                        <a class="botonVerInfo" href="{{ route('hectareas.info', $hectarea->id) }}">Ver Información</a>
                    </div>
                @endforeach
            </div>
        @endif
    </main>

    <x-footer />

    <script>
        document.querySelectorAll('input[name="tipo"]').forEach(function(input) {
            input.addEventListener('change', function() {
                this.form.submit();
            });
        });
    </script>
</body>

</html>
