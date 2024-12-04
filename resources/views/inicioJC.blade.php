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
        <form method="GET" action="{{ route('hectareas.filtrar') }}">
            <section class="contenedor_inputs">
                <div class="inputs">
                    <label>Seleccione la opción para filtrar:</label>
                    <label><input type="radio" name="tipo" value="autorizada" {{ old('tipo') == 'autorizada' ? 'checked' : '' }}>Autorizada</label>
                    <label><input type="radio" name="tipo" value="no_autorizada" {{ old('tipo') == 'no_autorizada' ? 'checked' : '' }}>No Autorizada</label>
                </div>
            </section>
        </form>

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

    <script>
        // Enviar formulario automáticamente cuando se cambia el radio button
        document.querySelectorAll('input[name="tipo"]').forEach(function(input) {
            input.addEventListener('change', function() {
                this.form.submit(); // Envía el formulario
            });
        });
    </script>
</body>

</html>