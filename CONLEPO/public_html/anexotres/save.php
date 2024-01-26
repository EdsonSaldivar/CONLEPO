<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario
    $maximos = $_POST['max'];
    $minimos = $_POST['min'];
    $maxTotalColumna = $_POST['maxtotalcolumna'];
    $minTotalColumna = $_POST['mintotalcolumna'];
    $maxTotalGeneral = $_POST['maxtotalgeneral'];
    $minTotalGeneral = $_POST['mintotalgeneral'];

    // Procesar datos de la tabla de máximos
    echo "<h2>Datos de valores máximos:</h2>";
    echo "<h3>Valores mensuales:</h3>";
    foreach ($maximos as $planta => $meses) {
        echo "<p>$planta:</p>";
        foreach ($meses as $mes => $valor) {
            echo "<p>$mes: $valor</p>";
        }
        // Mostrar el total de cada planta
        $nombreCampo = "maxtotal[$planta]";
        echo "<p>Total de $planta: " . $_POST[$nombreCampo] . "</p>";
    }

    echo "<h3>Totales de Columna:</h3>";
    foreach ($maxTotalColumna as $mes => $valor) {
        echo "<p>$mes: $valor</p>";
    }

    echo "<h3>Total General:</h3>";
    echo "<p>$maxTotalGeneral</p>";

    // Procesar datos de la tabla de mínimos
    echo "<h2>Datos de valores mínimos:</h2>";
    echo "<h3>Valores mensuales:</h3>";
    foreach ($minimos as $planta => $meses) {
        echo "<p>$planta:</p>";
        foreach ($meses as $mes => $valor) {
            echo "<p>$mes: $valor</p>";
        }
        // Mostrar el total de cada planta
        $nombreCampo = "mintotal[$planta]";
        echo "<p>Total de $planta: " . $_POST[$nombreCampo] . "</p>";
    }

    echo "<h3>Totales de Columna:</h3>";
    foreach ($minTotalColumna as $mes => $valor) {
        echo "<p>$mes: $valor</p>";
    }

    echo "<h3>Total General:</h3>";
    echo "<p>$minTotalGeneral</p>";
} else {
    echo "<p>No se han enviado datos del formulario.</p>";
}

echo "<pre>";
print_r($_POST['maxtotal']);
echo "</pre>";

echo "<pre>";
print_r($maximos);
echo"</pre>";

echo "<pre>";
print_r($maxTotalColumna);
echo"</pre>";
?>
