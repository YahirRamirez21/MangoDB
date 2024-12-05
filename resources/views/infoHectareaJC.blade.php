<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Información de Hectárea</title>
    @vite(['resources/css/styleInfoHectarea.css', 'resources/css/style-components/styleComponents.css'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Añadimos un tamaño adecuado a la gráfica */
        #graficaContenedor {
            width: 250px; /* Ajusta el tamaño según sea necesario */
            height: 250px; /* Ajusta el tamaño según sea necesario */
            margin: 0 auto; /* Centra la gráfica */
        }

        canvas {
            width: 100% !important;
            height: 100% !important;
        }
    </style>
</head>

<body>
    <x-menu />
    <main>
        <h2 id="titulo">Información Hectárea</h2>
        <section id="contenedor">
            <!-- Card de Información de la Hectárea -->
            <section id="sectionInfoHectarea">
                <h2>Hectárea {{ $hectarea->id }}</h2>
                <p><strong>Renta:</strong> {{ $hectarea->renta }}</p>
                <p><strong>Porcentaje General:</strong> {{ $hectarea->porcentaje_general }}%</p>
                <p><strong>Estado Cosecha:</strong> {{ $hectarea->fecha_recoleccion ? 'Autorizada' : 'No autorizada' }}</p>
                
                <!-- Gráfica de porcentaje dentro de la card -->
                <div id="graficaContenedor">
                    <canvas id="graficaPorcentaje"></canvas>
                </div>
            </section>

            <!-- Botones de acción -->
            <section id="sectionBotonesHectarea">
                <form action="{{ route('hectareas.autorizar', $hectarea->id) }}" method="POST" style="display:inline;" class="form">
                    @csrf
                    <button class="boton" type="submit" {{ $hectarea->porcentaje_general >= 80 ? '' : 'disabled' }} name="action" value="registrar">Autorizar Hectárea</button>
                </form>
                <button class="boton" {{ $hectarea->fecha_recoleccion ? '' : 'disabled' }} onclick="window.location.href='{{ route('cajas.crear', $hectarea->id) }}'">Crear Cajas</button>
            </section>

            <!-- Navegación entre hectáreas -->
            <section id="navegacion-hectarea">
                <div class="navegacion">
                    @if($currentIndex > 0)
                        <a href="{{ route('hectareas.info', $hectareasTipo[$currentIndex - 1]->id) }}" class="boton-subespacio">Anterior</a>
                    @else
                        <a href="#" class="boton-subespacio disabled">Anterior</a>
                    @endif

                    @if(isset($hectareasTipo[$currentIndex + 1]))
                        <a href="{{ route('hectareas.info', $hectareasTipo[$currentIndex + 1]->id) }}" class="boton-subespacio">Siguiente</a>
                    @else
                        <a href="#" class="boton-subespacio disabled">Siguiente</a>
                    @endif
                </div>
            </section>
        </section>

        <a href="{{ route('hectareas.index') }}">
            <button class="boton" type="button">Volver</button>
        </a>
    </main>

    <!-- JavaScript para inicializar la gráfica -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var ctx = document.getElementById('graficaPorcentaje').getContext('2d');
            
            var porcentaje = {{ $hectarea->porcentaje_general }};
            
            // Configuración de la gráfica
            var grafica = new Chart(ctx, {
                type: 'doughnut',  // Puede cambiar a 'bar' o 'pie'
                data: {
                    labels: ['Porcentaje General', 'Restante'],
                    datasets: [{
                        label: 'Porcentaje',
                        data: [porcentaje, 100 - porcentaje],
                        backgroundColor: ['#45a049', '#DAD7CD'],
                        borderColor: ['#15491a', '#DAD7CD'],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    return tooltipItem.raw + '%';
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
</body>

</html>
