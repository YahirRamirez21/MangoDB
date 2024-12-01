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
    <x-menu/>

    
    <div class="content">
        <h1>Introducir Cajas</h1>
        <div class="search-container">
            <div class="search-box">
                <label for="box-id">ID:</label>
                <input type="text" id="box-id" placeholder="Buscar caja">
                <button>Buscar</button>
            </div>
        </div>
    </div>

    <main>
        <div class="content">
            <section class="formulario">
                <h2>Etiqueta</h2>
                <form action=" " method="POST">
                    <div class="campo">
                        <label for="id">ID:</label>
                        <input type="text" id="id" name="id" readonly required>
                    </div>
                    <div class="campo">
                        <label for="hectarea">Hectárea:</label>
                        <input type="text" id="hectarea" name="hectarea" readonly required>
                    </div>
                    <div class="campo">
                        <label for="calidad">Calidad:</label>
                        <input type="text" id="calidad" name="calidad" readonly required>
                </div>
                    <div class="campo">
                        <label for="kilogramos">Kilogramos:</label>
                        <input type="number" id="kilogramos" name="kilogramos" readonly required>
                    </div>
                    <div class="campo">
                        <label for="fechaR">Fecha de recolección:</label>
                        <input type="text" id="fechaR" name="fechaR" readonly required>
                    </div>
                    <div class="campo">
                        <label for="fechaA">Fecha de ingreso a almacén:</label>
                        <input type="text" id="fechaA" name="fechaA" readonly required>
                    </div>
                    <div class="campo">
                        <label for="posicion">Posición:</label>
                        <input type="text" id="posicion" name="posicion" readonly required>
                    </div>
                    <button class="boton">Imprimir</button>
                </form>
            </section>
        </div>
    </main>    
</body>
</html>