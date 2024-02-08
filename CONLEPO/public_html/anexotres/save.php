<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guardar y descargar tabla</title>
    <link rel="stylesheet" href="style3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Enlace a la biblioteca FileSaver.js -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
    <!-- Biblioteca para generar excel -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx-populate/1.21.0/xlsx-populate.min.js"></script>
    <!-- Biblioteca para generar PDF -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/vfs_fonts.js"></script>
    <script>
        function exportarExcel() {
            // Crear un nuevo libro de trabajo
            var workbook = XlsxPopulate.fromBlankAsync();

            // Función para convertir una tabla HTML en una hoja de trabajo con título
            function tablaAExcel(tabla, nombreHoja, titulo) {
                // Crear una nueva hoja de trabajo
                workbook.then(function (workbook) {
                    var ws = workbook.addSheet(nombreHoja);

                    // Agregar título y subtítulo
                    ws.cell("A1").value(titulo).style({ bold: true, fontSize: 14 });

                    // Obtener el valor de tipoLeche
                    var tipoLeche = document.getElementById("tipodeleche").value;
                    ws.cell("A2").value("Tipo de leche: " + tipoLeche);

                    // Copiar datos de la tabla a la hoja de trabajo
                    var filas = tabla.rows;
                    for (var i = 0; i < filas.length; i++) {
                        var celdas = filas[i].cells;
                        for (var j = 0; j < celdas.length; j++) {
                            ws.cell(i + 3, j + 1).value(celdas[j].innerText);
                        }
                    }

                    // Ajustar las fechas manualmente
                    ws.usedRange().forEach(function (celda) {
                        if (celda.value() instanceof Date) {
                            // Restar 1 mes a la fecha para corregir el problema
                            celda.value(new Date(celda.value().getFullYear(), celda.value().getMonth() - 1, celda.value().getDate()));
                        }
                    });
                    // Aplicar estilo a todas las celdas
                    ws.usedRange().style({ fontName: "Arial", fontSize: 12, horizontalAlignment: "center", verticalAlignment: "middle" });
                });
            }

            // Obtener las tablas y agregarlas al libro de trabajo con títulos
            tablaAExcel(document.getElementById("tablaMaximos"), "DatosMaximos", "Datos Máximos");
            tablaAExcel(document.getElementById("tablaMinimos"), "DatosMinimos", "Datos Mínimos");

            // Eliminar la hoja "Sheet 1"
            workbook.then(function (workbook) {
                workbook.deleteSheet("Sheet1");
            });

            // Guardar el libro de trabajo como un archivo Excel
            workbook.then(function (workbook) {
                workbook.outputAsync().then(function (blob) {
                    saveAs(blob, 'conlepo_anexotres_excel.xlsx');
                });
            });
        }

        function generarPDF() {
            var tipoLeche = document.getElementById("tipodeleche").value;

            var docDefinition = {
                content: [
                    { text: 'Datos de AnexoTres para el tipo de leche: ', fontSize: 18, bold: true, margin: [0, 0, 0, 10], alignment: 'center' },
                    { text: tipoLeche, fontSize: 17, bold: true, margin: [0, 0, 0, 10], alignment: 'center' },
                    { text: 'Datos Máximos', fontSize: 16, bold: true, margin: [0, 0, 0, 10], alignment: 'center' },
                    { table: { body: obtenerDatosTabla('tablaMaximos')}, margin: [0, 0, 0, 10], alignment: 'center' },
                    { text: 'Datos Mínimos', fontSize: 16, bold: true, margin: [0, 0, 0, 10], alignment: 'center' },
                    { table: { body: obtenerDatosTabla('tablaMinimos')}, margin: [0, 0, 0, 10], alignment: 'center' }
                ]
            };

            pdfMake.createPdf(docDefinition).download('conlepo_anexotres_pdf.pdf');
        }

        function obtenerDatosTabla(idTabla) {
            var tabla = document.getElementById(idTabla);
            var data = [];

            for (var i = 0; i < tabla.rows.length; i++) {
                var row = [];
                for (var j = 0; j < tabla.rows[i].cells.length; j++) {
                    row.push(tabla.rows[i].cells[j].innerText);
                }
                data.push(row);
            }

            return data;
        }
    </script>
</head>
<body>
<div class="ocultar-etiqueta">
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
    echo "<input type='text' id='tipodeleche' name='tipodeleche' value='$tipoleche' readonly/>";

    // DATOS MAXIMOS
    echo "<h2>Datos maximos recibidos:</h2>";
    echo "<table id='tablaMaximos' border='1'>";
    echo "<tr><th>Planta</th>";

    // Encabezados de Meses
    foreach ($datosmaximos[key($datosmaximos)] as $mes => $valor) {
        echo "<th>$mes</th>";
    }

    echo "<th>Total</th></tr>";

    // Datos mensuales
    foreach ($datosmaximos as $planta => $meses) {
        echo "<tr><td>$planta</td>";

        foreach ($meses as $valor) {
            echo "<td>$valor</td>";
        }

        //MOSTRAR $totalplantamax correspondiente a $planta
        echo "<td>$totalplantamax[$planta]</td></tr>";
    }

    // Totales de columna
    echo "<tr><td>Total</td>";
    foreach ($totalColumnaMax as $valor) {
        echo "<td>$valor</td>";
    }
    echo "<td>$totalGeneralMax</td></tr>";

    echo "</table>";

    // DATOS MINIMOS
    echo "<h2>Datos minimos recibidos:</h2>";
    echo "<table id='tablaMinimos' border='1'>";
    echo "<tr><th>Planta</th>";

    // Encabezados de Meses
    foreach ($datosminimos[key($datosminimos)] as $mes => $valor) {
        echo "<th>$mes</th>";
    }

    echo "<th>Total</th></tr>";

    // Datos mensuales
    foreach ($datosminimos as $planta => $meses) {
        echo "<tr><td>$planta</td>";

        foreach ($meses as $valor) {
            echo "<td>$valor</td>";
        }

        //MOSTRAR $totalplantamin correspondiente a $planta
        echo "<td>$totalplantamin[$planta]</td></tr>";
    }

    // Totales de columna
    echo "<tr><td>Total</td>";
    foreach ($totalColumnaMin as $valor) {
        echo "<td>$valor</td>";
    }
    echo "<td>$totalGeneralMin</td></tr>";

    echo "</table>";

} else {
    echo "<p>No se han enviado datos del formulario.</p>";
}
?>
</div>
<h1>¡Datos guardados exitosamente!</h1>
<h2>Seleccione el formato de archivo que desea descargar</h2>
<div class="contenedor-botones">
    <button onclick="exportarExcel()"><i class="fas fa-file-excel"></i></button>
    <button onclick="generarPDF()"><i class="fas fa-file-pdf"></i></button>
</div>
</body>
</html>
