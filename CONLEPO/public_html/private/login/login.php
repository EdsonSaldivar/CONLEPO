<?php
session_start();
include "connection.php";

// Recibimos los datos del formulario de inicio de sesión
$user = $_POST['email'];
$password = $_POST['password'];

// Preparamos la consulta SQL utilizando marcadores de posición
$query = "SELECT name FROM users WHERE correo = :email AND password = :password";

// Preparamos la sentencia SQL
$stmt = oci_parse($connection, $query);

// Ligamos los valores a los marcadores de posición para evitar ataques de inyección de SQL
oci_bind_by_name($stmt, ":email", $user);
oci_bind_by_name($stmt, ":password", $password);

// Ejecutamos la sentencia SQL
if (oci_execute($stmt)) {
    // Verificamos si se encontraron resultados
    if ($row = oci_fetch_assoc($stmt)) {
        // Si hay resultados, almacenamos los datos en la sesión
        $_SESSION['name'] = $row['NAME'];
        // Redireccionamos al usuario a la página de inicio
        header("location: ../../menu/Index.php");
        exit; // Terminamos el script para evitar que se ejecute más código innecesario
    } else {
        // Si no se encontraron resultados, mostramos un mensaje de error
        echo "<script>alert('Correo o contraseña incorrectos. Por favor, inténtalo de nuevo.'); window.location = '../../login/Index.html';</script>";
    }
} else {
    // Si la ejecución de la sentencia SQL falla, mostramos un mensaje de error
    $error = oci_error($stmt);
    echo "Error: " . $error['message'];
}

// Cerramos la conexión con Oracle
oci_close($connection);
?>
