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

    <x-menu link="{{ url('/inicioHectarea') }}" />


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
                        <svg class="autorizar" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                            <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
                        </svg>

                    </label>
                    <label>
                        <input type="radio" name="tipo" value="no_autorizada" {{ old('tipo') == 'no_autorizada' ? 'checked' : '' }}>
                        No Autorizada
                        <svg class="no_autorizar" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                            <path fill-rule="evenodd" d="m6.72 5.66 11.62 11.62A8.25 8.25 0 0 0 6.72 5.66Zm10.56 12.68L5.66 6.72a8.25 8.25 0 0 0 11.62 11.62ZM5.105 5.106c3.807-3.808 9.98-3.808 13.788 0 3.808 3.807 3.808 9.98 0 13.788-3.807 3.808-9.98 3.808-13.788 0-3.808-3.807-3.808-9.98 0-13.788Z" clip-rule="evenodd" />
                        </svg>

                    </label>
                </div>
            </section>
        </form>

        <!-- Lista de Hectáreas -->
        <div class="listaHectareas">
            @foreach($hectareas as $hectarea)
            <div class="itemHectarea">
                <!-- Imagen Representativa -->
                <img src="{{ $hectarea->imagen_url ?? 'https://img.freepik.com/fotos-premium/hay-muchos-arboles-mango-campo_941033-8221.jpg?w=1060' }}" alt="Imagen de Hectárea">

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