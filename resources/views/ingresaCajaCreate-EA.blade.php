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
    @vite('resources/css/styleIngresaCaja-EA.css')
</head>
<body>
    <div class="navbar">
        <div class="title">MangoDB</div>
        <button class="logout" onclick="alert('Saliendo')">Log Out</button>
    </div>
    <div class="content">
        <h1>Introducir Cajas</h1>
        <div class="search-container">
            <div class="search-box">
                <label for="box-id">ID:</label>
                <input type="text" id="box-id" placeholder="Buscar caja">
                <button onclick="showLabelScreen()">Buscar</button>
            </div>
        </div>
    </div>

    <div class="content">
        <h1>Etiquetas</h1>
        <div class="form-container">
            <label for="id">Id:</label>
            <input type="text" id="id">
            <label for="kg">Kg:</label>
            <input type="text" id="kg">
            <label for="fecha">Fecha:</label>
            <input type="text" id="fecha">
            <button onclick="alert('Guardando etiqueta')">Guardar</button>
        </div>
    </div>
</body>
</html>