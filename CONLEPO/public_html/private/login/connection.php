<?php
//USAR ESTE SCRIPT PARA CONECTAR A LA BASE DE DATOS CUANDO SEA NECESARIO INSERTAR DATOS, CONSULTARLOS O ACTUALIZARLOS
$usuario = "ADMILK";
$password = "4dmilk_2024!";
$host = "193.0.0.34";
$puerto = "1521"; 
$sid = "conlepo";

$connection = oci_connect($this -> usuario, $this -> password, $this -> host . '/' . $this -> sid, 'AL32UTF8');

if(!$connection){
	//OBTENEMOS EL MENSAJE DEL ERROR
	$error = oci_error();
	//IMPRIMIMOS EL MENSAJE DEL ERROR E INTERRUMPIMOS EL FLUJO DE LA FUNCION
	trigger_error(htmlentities($error['message'], ENT_QUOTES), E_USER_ERROR);
    }
?>