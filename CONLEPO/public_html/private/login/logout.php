<?php
session_start();

if (isset($_SESSION['name'])) {
    session_destroy(); // Destruye la sesión actual
    header("Location: ../../public_html/login/Index.html"); // Redirige a la página de inicio de sesión
    exit();
}
?>