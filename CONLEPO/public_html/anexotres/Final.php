<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado del formulario en tabla</title>
    <link rel="stylesheet" href="style2.css">
    <link rel="shortcut icon" href="../../images/liconsa_logo.jpeg" type="image/x-icon">
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

    <?php
    // Verificar si se han enviado datos del formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtener las fechas del formulario
        $fechaInicio = new DateTime($_POST["fechaInicio"]);
        $fechaFin = new DateTime($_POST["fechaFin"]);
        $tipoleche = $_POST["tipoleche"];

        // Obtener las plantas seleccionadas
        $plantasSeleccionadas = isset($_POST["plantas"]) ? $_POST["plantas"] : [];

        // Nombres de los meses en español
        $meses = [
            'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio',
            'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'
        ];

        echo "<h2>Tipo de leche: $tipoleche</h2>";
        echo "<h1>Ingrese los valores máximos</h1>";
        // Mostrar la tabla
        echo "<form action='save.php' method='post'>";
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
                $nombreCampo = "[$planta][" . $fechaActual->format('Y-m') . "]";
                echo "<td><input type='number' name='max[$nombreCampo]' value='' required/></td>";
                $fechaActual->add(new DateInterval('P1M'));
            }

            // Mostrar el total al final de la fila
            echo "<td><input type='number' name='maxtotal[$planta]' value='' readonly/></td></tr>";
        }

        // Agregar la fila TOTAL al final
        echo "<tr><td>TOTAL</td>";

        // Reiniciar la fechaActual y mostrar celdas para cada mes
        $fechaActual = clone $fechaInicio;
        while ($fechaActual <= $fechaFin) {
            echo "<td><input type='number' name='maxtotalcolumna[" . $fechaActual->format('Y-m') . "]' value='' readonly/></td>";
            $fechaActual->add(new DateInterval('P1M'));
        }

        echo "<td><input type='number' name='maxtotalgeneral' value='' readonly/></td></tr>";

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
                $nombreCampo = "[$planta][" . $fechaActual->format('Y-m') . "]";
                echo "<td><input type='number' name='min[$nombreCampo]' value='' required/></td>";
                $fechaActual->add(new DateInterval('P1M'));
            }

            // Mostrar el total al final de la fila
            echo "<td><input type='number' name='mintotal[$planta]' value='' readonly/></td></tr>";
        }

        // Agregar la fila TOTAL al final
        echo "<tr><td>TOTAL</td>";

        // Reiniciar la fechaActual y mostrar celdas para cada mes
        $fechaActual = clone $fechaInicio;
        while ($fechaActual <= $fechaFin) {
            echo "<td><input type='number' name='mintotalcolumna[" . $fechaActual->format('Y-m') . "]' value='' readonly/></td>";
            $fechaActual->add(new DateInterval('P1M'));
        }

        echo "<td><input type='number' name='mintotalgeneral' value='' readonly/></td></tr>";

        echo "</table>";

        echo "<br><input type='submit' value='Guardar Datos'>";
        echo "</form>";
    } else {
        echo "<p>No se han enviado datos del formulario.</p>";
    }
    ?>

</body>
</html>

<!-- 
___________________¶¶_______________________
____________________¶¶__¶_5¶¶_______________
____________5¶5__¶5__¶¶_5¶__¶¶¶5____________
__________5¶¶¶__¶¶5¶¶¶¶¶5¶¶__5¶¶¶5__________
_________¶¶¶¶__¶5¶¶¶¶¶¶¶¶¶¶¶__5¶¶¶¶5________
_______5¶¶¶¶__¶¶¶¶¶¶¶¶¶¶¶_5¶¶__5¶¶¶¶¶5______
______¶¶¶¶¶5_¶¶¶¶¶¶¶¶¶¶¶¶¶5¶¶¶__¶¶¶¶5¶5_____
_____¶¶¶¶¶¶_¶¶¶¶¶¶¶¶¶¶¶¶¶¶¶¶¶¶¶_¶¶¶¶¶¶¶5____
____¶¶¶¶¶¶¶_¶¶¶5¶¶¶¶5_¶¶¶¶¶5_5¶_¶¶¶¶¶¶¶¶5___
___¶¶¶¶¶¶¶¶__5¶¶¶¶¶¶5___5¶¶¶¶__5¶¶¶¶¶¶¶¶¶5__
__¶¶¶¶¶¶¶¶¶¶5__5¶¶¶¶¶¶5__5¶¶5_5¶¶¶¶¶¶¶¶¶¶¶__
_5¶¶¶¶¶¶¶¶¶¶¶¶_5¶¶¶¶¶¶¶¶¶5__5¶¶¶¶¶¶¶¶¶¶¶¶¶5_
_¶¶¶¶¶¶¶¶¶¶¶¶¶¶¶¶¶¶¶¶¶¶¶¶¶¶¶¶¶¶¶¶¶¶¶¶_5¶¶¶¶_
5¶¶¶¶¶¶¶¶¶¶¶¶5___5¶¶¶¶¶¶¶5__¶¶¶¶5_¶¶¶5_¶¶¶¶_
¶¶¶¶¶¶¶¶_¶¶5_5¶5__¶¶¶¶¶¶¶¶¶5_5¶¶¶_5¶¶¶_5¶¶¶5
¶5¶¶¶¶¶5_¶¶_5¶¶¶¶¶_¶¶¶¶¶¶¶¶¶¶5_5¶¶_5¶¶¶_¶¶¶5
¶¶¶¶_¶¶__¶__¶¶¶¶¶¶5_5¶¶¶¶¶¶¶¶¶¶5_¶¶_5¶¶_5¶¶¶
¶¶¶5_5¶______5¶¶5¶¶¶¶¶¶¶¶¶¶¶¶¶¶¶5_¶¶_5¶5_¶5¶
5¶¶____5¶¶¶¶5_____5¶¶¶¶¶¶¶5_¶¶¶¶¶5_¶__¶¶_5¶¶
_¶¶__5¶¶¶¶¶¶¶¶¶¶5____5¶¶¶¶¶¶_¶¶¶¶¶_____¶5_¶¶
_¶¶___5¶¶¶¶¶¶¶¶¶__________5¶5_¶¶¶¶¶____¶¶_¶¶
_¶¶_______5¶¶¶¶¶¶5____________¶¶¶¶¶_____¶_¶¶
_5¶5________5¶¶_¶¶¶¶5________5¶¶¶¶¶_______¶¶
__¶¶__________¶___¶¶¶¶¶5___5¶¶¶¶¶¶5_______¶5
__¶¶____________5¶¶¶¶¶¶¶¶¶¶¶¶¶¶¶¶¶________¶_
___¶________________5¶¶¶¶¶¶¶¶5_¶¶___________
___¶__________5¶¶¶¶¶¶¶¶5¶¶¶5__5¶5___________
_____________________5¶¶¶5____¶5____________
        Edson Sebastian Saldivar Mujica
 -->
