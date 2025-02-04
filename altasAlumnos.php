<?php
include 'conexion.php';

function insertarAlumno($conexion, $codigo, $nombre, $apellido, $carrera, $correo) {
    $query = "INSERT INTO students(codigo, nombre, apellido, carrera, correo, num_prestamos) VALUES ('$codigo', '$nombre', '$apellido', '$carrera', '$correo', 0)";
    return pg_query($conexion, $query);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigo = $_POST['codigo'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $carrera = $_POST['carrera'];
    $correo = $_POST['correo'];

    if (!empty($codigo) && !empty($nombre) && !empty($apellido) && !empty($carrera) && !empty($correo)) {
        if (insertarAlumno($conexion, $codigo, $nombre, $apellido, $carrera, $correo)) {
            echo '<script>alert("Alumno registrado exitosamente."); window.location.href = "altasAlumnos.html?success=true";</script>';
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
