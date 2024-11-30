<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MangoDB - CajaCreate</title>
    @vite('resources/css/styleCajaCreateHectareaEA.css')
</head>
<body>
    <header>
        <div class="menu-landmark">
            <h1>MangoDB</h1>
            <a href=" " class="logout">LogOut</a>
        </div>
    </header>

    <main>
        <section class="formulario">
            <h2>Etiqueta</h2>
            <form action=" " method="POST">
                <div class="campo">
                    <label for="id">ID:</label>
                    <input type="text" id="id" name="id" required>
                </div>
                <div class="campo">
                    <label for="hectarea">Hectárea:</label>
                    <input type="text" id="hectarea" name="hectarea" required>
                </div>
                <div class="campo">
                    <label for="calidad">Calidad:</label>
                    <input type="text" id="calidad" name="calidad" required>
                </div>
                <div class="campo">
                    <label for="kilogramos">Kilogramos:</label>
                    <input type="number" id="kilogramos" name="kilogramos" required>
                </div>
                <button type="submit" class="boton">Imprimir</button>
            </form>
        </section>
    </main>
</body>
</html>
