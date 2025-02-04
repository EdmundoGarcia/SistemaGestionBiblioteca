<?php
include 'conexion.php';

function insertarAlumno($conexion, $codigo_profesor, $nombre, $apellido, $carrera, $correo) {
    $query = "INSERT INTO profesores(codigo_profesor, nombre, apellido, carrera, correo, num_prestamos) VALUES ('$codigo_profesor', '$nombre', '$apellido', '$carrera', '$correo', 0)";
    return pg_query($conexion, $query);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigo_profesor = $_POST['codigo_profesor'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $carrera = $_POST['carrera'];
    $correo = $_POST['correo'];

    if (!empty($codigo_profesor) && !empty($nombre) && !empty($apellido) && !empty($carrera) && !empty($correo)) {
        if (insertarAlumno($conexion, $codigo_profesor, $nombre, $apellido, $carrera, $correo)) {
            echo '<script>alert("Profesor registrado exitosamente."); window.location.href = "altasAlumnos.html?success=true";</script>';
            exit();
        } else {
            echo '<script>alert("Error al insertar el alumno: '.pg_last_error().'"); window.history.back();</script>';
            exit();
        }
    } else {
        echo '<script>alert("Todos los campos son obligatorios."); window.history.back();</script>';
        exit();
    }
}

pg_close($conexion);
?>
