<?php
include 'conexion.php';

// Obtener los datos del formulario
$username = $_POST["username"];
$password = $_POST["password"];

// Validar el usuario en la base de datos
$query = "SELECT * FROM usuarios WHERE username = '$username' AND password = '$password'";
$result = pg_query($conexion, $query);

if (!$result) {
    echo "Error al ejecutar la consulta: " . pg_last_error($conexion);
    exit();
}

// Si el usuario existe, iniciar sesión
if (pg_num_rows($result) > 0) {
    $user = pg_fetch_assoc($result);

    // Comprobar el tipo de usuario y redireccionar
    if ($user["tipo_usuario"] === "admin") {
        header("Location: inicioAdmin.html"); // Asume que el archivo se llama indexAdmin.html
    } elseif ($user["tipo_usuario"] === "empleado") {
        header("Location: inicioEmpleado.html");
    } else {
        // Redireccionar a una página de error o página principal si no es ni admin ni empleado
        header("Location: index.php?error=tipo_incorrecto");
    }
} else {
    // Redireccionar a index.php con mensaje de error
    header("Location: index.php?error=1");
}

?>
