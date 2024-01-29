<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario
    $tipoleche = $_POST['tipoleche'];
    $datosmaximos = $_POST['datosmaximos'];
    $datosminimos = $_POST['datosminimos'];
    $totalplantamax = $_POST['totalmax'];
    $totalplantamin = $_POST['totalmin'];
    $totalColumnaMax = $_POST['totalcolumnamaximos'];
    $totalColumnaMin = $_POST['totalcolumnaminimos'];
    $totalGeneralMax = $_POST['totalgeneralmax'];
    $totalGeneralMin = $_POST['totalgeneralmin'];

    echo "<h2>Tipo de leche: $tipoleche</h2>";
    // DATOS MAXIMOS
    echo "<h2>Datos maximos recibidos:</h2>";

    // Datos mensuales
    foreach ($datosmaximos as $planta => $meses) {
        echo "<p>$planta:</p>";
        foreach ($meses as $mes => $valor) {
            echo "<p>$mes: $valor</p>";
        }
        //MOSTRAR $totalplantamax correspondiente a $planta
        echo "<p>Total para $planta: $totalplantamax[$planta]</p>";
    }

    // Totales de columna
    echo "<p>Total de Columna:</p>";
    foreach ($totalColumnaMax as $mes => $valor) {
        echo "<p>$mes: $valor</p>";
    }

    // Total General
    echo "<p>Total General: $totalGeneralMax</p>";

    // DATOS MINIMOS
    echo "<h2>Datos minimos recibidos:</h2>";

    // Datos mensuales
    foreach ($datosminimos as $planta => $meses) {
        echo "<p>$planta:</p>";
        foreach ($meses as $mes => $valor) {
            echo "<p>$mes: $valor</p>";
        }
        //MOSTRAR $totalplantamin correspondiente a $planta
        echo "<p>Total para $planta: $totalplantamin[$planta]</p>";
    }

    // Totales de columna
    echo "<p>Total de Columna:</p>";
    foreach ($totalColumnaMin as $mes => $valor) {
        echo "<p>$mes: $valor</p>";
    }

    // Total General
    echo "<p>Total General: $totalGeneralMin</p>";
} else {
    echo "<p>No se han enviado datos del formulario.</p>";
}
?>
