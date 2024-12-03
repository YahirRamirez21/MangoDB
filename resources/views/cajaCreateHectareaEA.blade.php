<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MangoDB - CajaCreate</title>
    @vite(['resources/css/styleCajaCreateHectareaEA.css', 'resources/css/style-components/styleComponents.css'])
</head>
<body>
    <x-menu/>
    <main>
    <section class="formulario">
            <h2>Etiqueta</h2>
            <!-- Solo un formulario para todos los campos y el botón -->
            <form action="{{ route('hectareas.registrarCaja') }}" method="POST">
                @csrf   
                <div class="campo">
                    <label for="id">ID:</label>
                    <input type="text" id="id" name="id" value="{{ old('id', $cajaCreadaBD->id ?? '') }}" readonly required>
                </div>
                <div class="campo">
                    <label for="hectarea">Hectárea:</label>
                    <input type="text" id="hectarea" name="hectarea" value="{{ $hectarea_id }}" readonly required>
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
                    <input type="text" id="fechaR" name="fechaR" value="{{ $cajaCreada->fecha_ingreso ?? '' }}" readonly required>
                </div>

                <!-- Solo un botón para crear la caja -->
                <button name="action" value="crear" type="submit" class="boton">Crear Caja</button>
            </form>
        </section>
    </main>
</body>
</html>
