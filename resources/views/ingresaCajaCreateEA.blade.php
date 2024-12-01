<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Introducir Cajas</title>
    <script>
        function showLabelScreen() {
            window.location.href = '/label';
        }
    </script>
    @vite(['resources/css/styleIngresaCajaEA.css', 'resources/css/style-components/styleComponents.css'])
</head>

<body>
    <x-menu />


    <div class="content">
        <h1>Introducir Cajas</h1>
        <div class="search-container">
            <div class="search-box">
                <form action="{{ url('/caja') }}" method="GET">
                    <label for="box-id">ID:</label>
                    <input type="text" id="box-id" name="box-id" placeholder="Buscar caja">
                    <button type="submit">Buscar</button>
                </form>
            </div>
        </div>
    </div>

    <main>
        <div class="content">
            <section class="formulario">
                <h2>Etiqueta</h2>

                @if (isset($caja))
                <form action=" " method="POST">
                    <div class="campo">
                        <label for="id">ID:</label>
                        <input type="text" id="id" name="id" value="{{ $caja->id }}" readonly required>
                    </div>
                    <div class="campo">
                        <label for="hectarea">Hectárea:</label>
                        <input type="text" id="hectarea" name="hectarea" value="{{ $caja->hectarea->id }}" readonly required>
                    </div>
                    <div class="campo">
                        <label for="calidad">Calidad:</label>
                        <input type="text" id="calidad" name="calidad" value="{{ $caja->calidad }}" readonly required>
                    </div>
                    <div class="campo">
                        <label for="kilogramos">Kilogramos:</label>
                        <input type="number" id="kilogramos" name="kilogramos" value="{{ $caja->kilogramos }}" readonly required>
                    </div>
                    <div class="campo">
                        <label for="fechaR">Fecha de recolección:</label>
                        <input type="text" id="fechaR" name="fechaR" value="{{ $caja->fecha_cosecha }}" readonly required>
                    </div>
                    <div class="campo">
                        <label for="fechaA">Fecha de ingreso a almacén:</label>
                        <input type="text" id="fechaA" name="fechaA" value="{{ $caja->fecha_ingreso_almacen }}" readonly required>
                    </div>
                    <div class="campo">
                        <label for="posicion">Posición:</label>
                        <input type="text" id="posicion" name="posicion" value="Estante {{ $caja->posicion->estante ?? 'N/A' }} - División {{ $caja->posicion->division ?? 'N/A' }}" readonly required>
                    </div>
                    <button class="boton">Imprimir</button>
                </form>
                @endif
            </section>
        </div>
    </main>
</body>

</html>