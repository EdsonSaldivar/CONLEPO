<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado del formulario en tabla</title>
    <link rel="stylesheet" href="style2.css">
    <script>
        document.addEventListener('input', function(e) {
            // Verificar si el elemento que ha cambiado es un input de número
            if (e.target.tagName.toLowerCase() === 'input' && e.target.type === 'number') {
                // Obtener la fila del input cambiado
                var row = e.target.closest('tr');

                // Actualizar el total de la fila
                actualizarTotalFila(row);

                // Actualizar el total de la columna
                actualizarTotalColumnas(row);
            }
        });

        function actualizarTotalFila(row) {
            var inputs = row.querySelectorAll('input[type=number]');
            var total = 0;

            for (var i = 0; i < inputs.length - 1; i++) {
                total += parseFloat(inputs[i].value) || 0;
            }

            row.cells[row.cells.length - 1].querySelector('input').value = total.toFixed(2);
        }

        function actualizarTotalColumnas(row) {
            var table = row.closest('table');

            for (var i = 1; i < row.cells.length; i++) {
                var colTotal = 0;

                for (var j = 1; j < table.rows.length - 1; j++) {
                    colTotal += parseFloat(table.rows[j].cells[i].querySelector('input').value) || 0;
                }

                table.rows[table.rows.length - 1].cells[i].querySelector('input').value = colTotal.toFixed(2);
            }
        }
    </script>
</head>
<body>

    <h1>Ingrese los valores máximos</h1>

    <?php
    // Verificar si se han enviado datos del formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtener las fechas del formulario
        $fechaInicio = new DateTime($_POST["fechaInicio"]);
        $fechaFin = new DateTime($_POST["fechaFin"]);

        // Obtener las plantas seleccionadas
        $plantasSeleccionadas = isset($_POST["plantas"]) ? $_POST["plantas"] : [];

        // Nombres de los meses en español
        $meses = [
            'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio',
            'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'
        ];

        // Mostrar la tabla
        echo "<form action='#' method='post'>";
        echo "<table border='1'>";
        echo "<tr><th>PLANTAS</th>";

        // Mostrar encabezados de columna con meses
        $fechaActual = clone $fechaInicio;
        while ($fechaActual <= $fechaFin) {
            echo "<th>" . ucfirst($meses[$fechaActual->format('n') - 1]) . " " . $fechaActual->format('Y') . "</th>";
            $fechaActual->add(new DateInterval('P1M'));
        }

        echo "<th>TOTAL</th></tr>";

        // Mostrar filas de datos
        foreach ($plantasSeleccionadas as $planta) {
            echo "<tr><td>$planta</td>";

            // Mostrar campos de entrada para cada mes
            $fechaActual = clone $fechaInicio;
            while ($fechaActual <= $fechaFin) {
                $nombreCampo = "datos[$planta][" . $fechaActual->format('Y-m') . "]";
                echo "<td><input type='number' name='$nombreCampo' value='' required/></td>";
                $fechaActual->add(new DateInterval('P1M'));
            }

            // Mostrar el total al final de la fila
            echo "<td><input type='number' name='total[$planta]' value='' readonly/></td></tr>";
        }

        // Agregar la fila TOTAL al final
        echo "<tr><td>TOTAL</td>";

        // Reiniciar la fechaActual y mostrar celdas para cada mes
        $fechaActual = clone $fechaInicio;
        while ($fechaActual <= $fechaFin) {
            echo "<td><input type='number' name='totalcolumna' value='' readonly/></td>"; // Puedes poner algún valor predeterminado si es necesario
            $fechaActual->add(new DateInterval('P1M'));
        }

        echo "<td><input type='number' name='totalgeneral' value='' readonly/></td></tr>";

        echo "</table>";
        echo "<h1>Ingrese los valores mínimos</h1>";
        
        echo "<table border='1'>";
        echo "<tr><th>PLANTAS</th>";

        // Mostrar encabezados de columna con meses
        $fechaActual = clone $fechaInicio;
        while ($fechaActual <= $fechaFin) {
            echo "<th>" . ucfirst($meses[$fechaActual->format('n') - 1]) . " " . $fechaActual->format('Y') . "</th>";
            $fechaActual->add(new DateInterval('P1M'));
        }

        echo "<th>TOTAL</th></tr>";

        // Mostrar filas de datos
        foreach ($plantasSeleccionadas as $planta) {
            echo "<tr><td>$planta</td>";

            // Mostrar campos de entrada para cada mes
            $fechaActual = clone $fechaInicio;
            while ($fechaActual <= $fechaFin) {
                $nombreCampo = "datos[$planta][" . $fechaActual->format('Y-m') . "]";
                echo "<td><input type='number' name='$nombreCampo' value='' required/></td>";
                $fechaActual->add(new DateInterval('P1M'));
            }

            // Mostrar el total al final de la fila
            echo "<td><input type='number' name='total[$planta]' value='' readonly/></td></tr>";
        }

        // Agregar la fila TOTAL al final
        echo "<tr><td>TOTAL</td>";

        // Reiniciar la fechaActual y mostrar celdas para cada mes
        $fechaActual = clone $fechaInicio;
        while ($fechaActual <= $fechaFin) {
            echo "<td><input type='number' name='totalcolumna' value='' readonly/></td>"; // Puedes poner algún valor predeterminado si es necesario
            $fechaActual->add(new DateInterval('P1M'));
        }

        echo "<td><input type='number' name='totalgeneral' value='' readonly/></td></tr>";

        echo "</table>";

        echo "<br><input type='submit' value='Guardar Datos'>";
        echo "</form>";
    } else {
        echo "<p>No se han enviado datos del formulario.</p>";
    }
    ?>

</body>
</html>