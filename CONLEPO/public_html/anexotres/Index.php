<?php
include("../../private/catalogos/plantas/obtener_plantas.php");

$plantas = obtenerPlantas();

session_start();

if(!isset($_SESSION['sagcdaUsuario'])){
			   header('Location: ../Login/Index.html');
               exit;
}else{
  $ctc = $_SESSION['sagcdaCentroCostosU'];   //CENTRO DE COSTO
  $centro = $_SESSION['sagcdaCentroTrabU'];  //CENTRO DE TRABAJO
  $rol = $_SESSION['sagcdaRolUsuario'];      //ROL DE USUARIO
  $mail = $_SESSION['sagcdaUsuario'];        //CORREO DE USUARIO
  $nombre = $_SESSION['sagcdaNombreU'];      //NOMBRE DE USUARIO
  $nombre1 = substr($nombre, 0, 7);
 
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ANEXO TRES</title>
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="../../images/liconsa_logo.jpeg" type="image/x-icon">
</head>
<body>

    <h1>ANEXO TRES</h1>

    <form action="final.php" method="post">

        <fieldset>
            <legend>Selecciona un rango de fechas</legend>
            <div class="date-container">
                <div class="date-row">
                    <div class="date-item">
                        <label for="fechaInicio">Fecha inicial</label>
                        <input type="date" id="fechaInicio" name="fechaInicio" required>
                    </div>
                    
                    <div class="date-item">
                        <label for="fechaFin">Fecha final</label>
                        <input type="date" id="fechaFin" name="fechaFin" required>
                    </div>
                </div>
            </div>
        </fieldset>

        <fieldset>
            <legend>Selecciona el tipo de leche</legend>
            <select name="tipoleche" id="tipoleche" required>
                <option value="" disabled selected>▼</option>
                <option value="DESCREMADA EN POLVO INSTANTÁNEA, ADICIONADA CON VITAMINAS A Y D PARA ENVASADO DIRECTO">1 DESCREMADA EN POLVO INSTANTÁNEA, ADICIONADA CON VITAMINAS A Y D PARA ENVASADO DIRECTO</option>
                <option value="DESCREMADA EN POLVO NO INSTANTÁNEA SIN FORTIFICAR">2 DESCREMADA EN POLVO NO INSTANTÁNEA SIN FORTIFICAR</option>
                <option value="DESCREMADA EN POLVO NO INSTANTÁNEA SIN FORTIFICAR, PARA EL PROCESO DE ULTRAPASTEURIZACIÓN">3 DESCREMADA EN POLVO NO INSTANTÁNEA SIN FORTIFICAR, PARA EL PROCESO DE ULTRAPASTEURIZACIÓN</option>
                <option value="DESCREMADA EN POLVO NO INSTANTÁNEA, FORTIFICADA CON VITAMINAS Y MINERALES">4 DESCREMADA EN POLVO NO INSTANTÁNEA, FORTIFICADA CON VITAMINAS Y MINERALES</option>
                <option value="EN POLVO INSTANTÁNEA, FORTIFICADA CON VITAMINAS Y MINERALES ADICIONADA CON 26% DE GRASA VEGETAL">5 EN POLVO INSTANTÁNEA, FORTIFICADA CON VITAMINAS Y MINERALES ADICIONADA CON 26% DE GRASA VEGETAL</option>
                <option value="ENTERA EN POLVO INSTANTÁNEA SIN FORTIFICAR">6 ENTERA EN POLVO INSTANTÁNEA SIN FORTIFICAR</option>
                <option value="ENTERA EN POLVO INSTANTÁNEA, FORTIFICADA CON VITAMINAS Y MINERALES PARA ENVASADO DIRECTO">7 ENTERA EN POLVO INSTANTÁNEA, FORTIFICADA CON VITAMINASY MINERALES PARA ENVASADO DIRECTO</option>
                <option value="SEMIDESCREMADA EN POLVO INSTANTÁNEA, FORTIFICADA, CON VITAMINAS Y MINERALES PARA ENVASADO DIRECTO">8 SEMIDESCREMADA EN POLVO INSTANTÁNEA, FORTIFICADA, CON VITAMINAS Y MINERALES PARA ENVASADO DIRECTO</option>
                <option value="EN POLVO INSTANTÁNEA, FORTIFICADA CON VITAMINAS Y MINERALES ADICIONADA CON 8% A 9% DE GRASA VEGETAL">9 EN POLVO INSTANTÁNEA, FORTIFICADA CON VITAMINAS Y MINERALES ADICIONADA CON 8% A 9% DE GRASA VEGETAL</option>
                <option value="DESCREMADA EN POLVO NO INSTANTÁNEA, FORTIFICADA CON VITAMINAS Y MINERALES">10 DESCREMADA EN POLVO NO INSTANTÁNEA, FORTIFICADA CON VITAMINAS Y MINERALES</option>
                <option value="ENTERA EN POLVO INSTANTÁNEA, FORTIFICADA CON VITAMINAS Y MINERALES, PARA ENVASADO DIRECTO">11 ENTERA EN POLVO INSTANTÁNEA, FORTIFICADA CON VITAMINAS Y MINERALES, PARA ENVASADO DIRECTO</option>
                <option value="DESCREMADA EN POLVO NO INSTANTÁNEA SIN FORTIFICAR">12 DESCREMADA EN POLVO NO INSTANTÁNEA SIN FORTIFICAR</option>
            </select>
            
        </fieldset>

        <fieldset>
            <legend>Selecciona las plantas de producción</legend>
            <div class="plantas-container">
                <?php
                    if ($plantas) {
                        foreach ($plantas as $planta) {
                            $nombrePlanta = $planta['NOMBRE'];
                            $idPlanta = $planta['ID'];
                            $estatusPlanta = $planta['ESTATUS'];
                            
                            // Verificar el estado de la planta
                            if ($estatusPlanta == 'Activo') {
                                echo "<input type='checkbox' id='$idPlanta' name='plantas[]' value='$nombrePlanta'>";
                                echo "<label for='$idPlanta'>$nombrePlanta</label><br>";
                            }
                        }
                    } else {
                        echo "No se encontraron plantas";
                    }
                ?>
            </div>
        </fieldset>

        <br>
        <input type="submit" value="ACEPTAR">
    </form>

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