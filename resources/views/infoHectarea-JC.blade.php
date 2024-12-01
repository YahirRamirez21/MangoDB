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
            <h2>Hectarea 1</h2>
            <p>Informacion</p>
            <p>Informacion</p>
            <p>Informacion</p>
            <p>Informacion</p>
            <p>Informacion</p>
            </section>
            <section id="sectionBotonesHectarea">
                <botton class="boton">Cambiar Estado Hectarea</botton>
                <botton class="boton" onclick="window.location.href='{{ url('/cajaCreateHectareaEA') }}'">Crear Cajas</button>
            </section>
        </section>
    </main>
</body>
</html>