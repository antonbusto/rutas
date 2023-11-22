<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Rutas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h1>Gestión de Rutas</h1>
    
    <form action="agregar_ruta.php" method="post">
        <div class="mb-3">
            <label for="lugarInicio" class="form-label">Lugar de Inicio</label>
            <input type="text" class="form-control" id="lugarInicio" name="lugarInicio" required>
        </div>
        <div class="mb-3">
            <label for="distanciaTotal" class="form-label">Distancia Total</label>
            <input type="number" step="0.01" class="form-control" id="distanciaTotal" name="distanciaTotal" required>
        </div>
        <div class="mb-3">
            <label for="lugarTermino" class="form-label">Lugar de Término</label>
            <input type="text" class="form-control" id="lugarTermino" name="lugarTermino" required>
        </div>
        <div class="mb-3">
            <label for="lugaresDestacados" class="form-label">Lugares Destacados</label>
            <div class="input-group">
                <input type="text" class="form-control" id="lugarDestacado" placeholder="Nombre del lugar">
                <input type="number" step="0.01" class="form-control" id="distanciaLugar" placeholder="Distancia desde el inicio">
                <button type="button" class="btn btn-primary" id="agregarLugar">Agregar Lugar</button>
            </div>
            <div id="lugaresList" class="mt-2"></div>
        </div>
        <input type="hidden" name="lugaresDestacados" id="lugaresDestacados" value="">
        <button type="submit" class="btn btn-success">Agregar Ruta</button>
    </form>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const agregarLugarButton = document.getElementById("agregarLugar");
        const lugaresList = document.getElementById("lugaresList");
        const lugaresDestacadosInput = document.getElementById("lugaresDestacados");

        const lugaresDestacados = [];

        agregarLugarButton.addEventListener("click", function () {
            const lugarDestacado = document.getElementById("lugarDestacado").value;
            const distanciaLugar = document.getElementById("distanciaLugar").value;

            if (lugarDestacado && distanciaLugar) {
                lugaresDestacados.push({ nombre: lugarDestacado, distancia: distanciaLugar });

                const lugarHtml = `
                    <div class="mb-2">
                        <strong>${lugarDestacado}</strong> - Distancia: ${distanciaLugar} km
                    </div>
                `;

                lugaresList.innerHTML += lugarHtml;
                document.getElementById("lugarDestacado").value = "";
                document.getElementById("distanciaLugar").value = "";

                lugaresDestacadosInput.value = JSON.stringify(lugaresDestacados);
            }
        });
    });
</script>

</body>
</html>
