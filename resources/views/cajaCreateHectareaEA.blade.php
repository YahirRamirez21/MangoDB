<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MangoDB - CajaCreate</title>
    @vite(['resources/css/styleCajaCreateHectareaEA.css', 'resources/css/style-components/styleComponents.css'])
</head>

<body>
    <x-menu />
    <main>
        <section class="formulario">
            <h2>Etiqueta</h2>
            <form action="{{ route('hectareas.registrarCaja') }}" method="POST">
                @csrf
                <div class="campo">
                    <label for="id">ID:</label>
                    <input type="text" id="id" name="id" value="{{ old('id', $cajaCreadaBD->id ?? '') }}" readonly required>
                </div>
                <div class="campo">
                    <label for="hectarea">Hectárea:</label>
                    <input type="text" id="hectarea" name="hectarea" value="{{ old('hectarea', $hectarea_id) }}" readonly required>
                </div>
                <div class="campo">
                    <label for="calidad">Calidad:</label>
                    <select id="calidad" name="calidad" required>
                        <option value="" disabled selected>Seleccione la calidad</option>
                        <option value="Calidad" {{ old('calidad', $cajaCreadaBD->calidad ?? '') == 'Calidad' ? 'selected' : '' }}>Calidad</option>
                        <option value="No Calidad" {{ old('calidad', $cajaCreadaBD->calidad ?? '') == 'No Calidad' ? 'selected' : '' }}>No Calidad</option>
                    </select>
                </div>
                <div class="campo">
                    <label for="kilogramos">Kilogramos:</label>
                    <input type="number" id="kilogramos" name="kilogramos" value="{{ old('kilogramos', $cajaCreadaBD->kilogramos ?? '') }}" required min="0">
                </div>
                <div class="campo">
                    <label for="fechaR">Fecha de recolección:</label>
                    <input type="text" id="fechaR" name="fechaR" value="{{ old('fechaR', $cajaCreadaBD->fecha_cosecha ?? '') }}" readonly required>
                </div>
                <button name="action" value="crear" type="submit" class="boton">Crear Caja</button>
                <br>
                <button name="action" type="imprimir" onclick="showAlert()" class="boton" {{ empty($cajaCreadaBD->fecha_cosecha) ? 'disabled' : '' }}>Imprimir</button>
            </form>
        </section>
    </main>
    <a href="{{ route('hectareas.index') }}">
        <button class="botonV" type="button">Volver</button>
    </a>

    <x-footer />

    <script>
        function showAlert() {
            event.preventDefault();
            alert('Imprimiendo Etiqueta de Caja ...');
        }
    </script>
</body>

</html>