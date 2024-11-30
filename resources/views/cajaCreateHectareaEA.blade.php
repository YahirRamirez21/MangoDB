<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MangoDB - CajaCreate</title>
    @vite('resources/css/styleCajaCreateHectareaEA.css')
</head>
<body>
    <main>
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
                    <select id="calidad" name="calidad" required>
                        <option value="Calidad">Calidad</option>
                        <option value="No Calidad">No Calidad</option>
                    </select>
               </div>
                <div class="campo">
                    <label for="kilogramos">Kilogramos:</label>
                    <input type="number" id="kilogramos" name="kilogramos" required>
                </div>
                <div class="campo">
                    <label for="fechaR">Fecha de recolección:</label>
                    <input type="number" id="fechaR" name="fechaR" readonly required>
                </div>
                <button type="submit" class="boton">Imprimir</button>
            </form>
        </section>
    </main>
</body>
</html>
