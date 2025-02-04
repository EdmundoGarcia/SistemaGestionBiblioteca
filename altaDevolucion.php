<?php
include 'conexion.php';

function verificarPrestamo($conexion, $codigo_usuario, $id_libro, $ejemplar, $tipo_usuario) {
    if ($tipo_usuario === 'Estudiante') {
        $tabla = 'prestamo_student';
    } elseif ($tipo_usuario === 'Profesor') {
        $tabla = 'prestamo_profe';
    }
    $query = "SELECT COUNT(*) AS num_prestamos FROM $tabla 
                WHERE codigo_usuario = '$codigo_usuario' 
                    AND id_libro = '$id_libro' 
                    AND ejemplar = '$ejemplar' 
                    AND devuelto = FALSE";
    $resultado = pg_query($conexion, $query);
    return pg_fetch_assoc($resultado)['num_prestamos'];
}

function obtenerFechasPrestamo($conexion, $codigo_usuario, $id_libro, $ejemplar, $tipo_usuario) {
    if ($tipo_usuario === 'Estudiante') {
        $tabla = 'prestamo_student';
    } elseif ($tipo_usuario === 'Profesor') {
        $tabla = 'prestamo_profe';
    }
    $query = "SELECT fecha_salida, fecha_limite FROM $tabla 
                WHERE codigo_usuario = '$codigo_usuario' 
                    AND id_libro = '$id_libro' 
                    AND ejemplar = '$ejemplar' 
                    AND devuelto = FALSE";
    $resultado = pg_query($conexion, $query);
    return pg_fetch_assoc($resultado);
}

function calcularMulta($fecha_devolucion, $fecha_limite) {
    $diferencia_dias = max(0, (strtotime($fecha_devolucion) - strtotime($fecha_limite)) / (60 * 60 * 24));
    return $diferencia_dias * 5; // $5 por cada día de retraso
}

function actualizarDevolucion($conexion, $codigo_usuario, $id_libro, $ejemplar, $fecha_devolucion, $multa, $tipo_usuario) {
    if ($tipo_usuario === 'Estudiante') {
        $tabla = 'prestamo_student';
    } elseif ($tipo_usuario === 'Profesor') {
        $tabla = 'prestamo_profe';
    }
    $query = "UPDATE $tabla 
                SET devuelto = TRUE, 
                    fecha_devolucion = '$fecha_devolucion', 
                    multa = $multa 
                WHERE codigo_usuario = '$codigo_usuario' 
                    AND id_libro = '$id_libro' 
                    AND ejemplar = '$ejemplar' 
                    AND devuelto = FALSE";
    return pg_query($conexion, $query);
}

function actualizarDisponibilidadLibro($conexion, $id_libro, $ejemplar) {
    $query = "UPDATE books 
                SET disponible = TRUE 
                WHERE isbn = '$id_libro' 
                    AND ejemplar = '$ejemplar'";
    return pg_query($conexion, $query);
}

function actualizarPrestamosAlumno($conexion, $codigo_usuario, $tipo_usuario) {
    if ($tipo_usuario === 'Estudiante') {
        $query = "UPDATE students 
                    SET num_prestamos = num_prestamos - 1 
                    WHERE codigo = '$codigo_usuario'";
    } elseif ($tipo_usuario === 'Profesor') {
        $query = "UPDATE profesores 
                    SET num_prestamos = num_prestamos - 1 
                    WHERE codigo_profesor = '$codigo_usuario'";
    }
    return pg_query($conexion, $query);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $codigo_usuario = $_POST['codigo_usuario'];
    $id_libro = $_POST['id_libro'];
    $ejemplar = $_POST['ejemplar'];
    $fecha_devolucion = $_POST['fecha_devolucion'];
    $tipo_usuario = $_POST['tipo_usuario'];

    // Verificar que todos los campos del formulario estén completos
    if (!empty($codigo_usuario) && !empty($id_libro) && !empty($ejemplar) && !empty($fecha_devolucion) && !empty($tipo_usuario)) {
        $num_prestamos = verificarPrestamo($conexion, $codigo_usuario, $id_libro, $ejemplar, $tipo_usuario);

        if ($num_prestamos > 0) {
            $fechas_prestamo = obtenerFechasPrestamo($conexion, $codigo_usuario, $id_libro, $ejemplar, $tipo_usuario);
            $fecha_salida = $fechas_prestamo['fecha_salida'];
            $fecha_limite = $fechas_prestamo['fecha_limite'];

            $multa = calcularMulta($fecha_devolucion, $fecha_limite);

            if (actualizarDevolucion($conexion, $codigo_usuario, $id_libro, $ejemplar, $fecha_devolucion, $multa, $tipo_usuario)) {
                if (actualizarDisponibilidadLibro($conexion, $id_libro, $ejemplar)) {
                    if (actualizarPrestamosAlumno($conexion, $codigo_usuario, $tipo_usuario)) {
                        echo '<script>alert("Devolución registrada exitosamente."); window.location.href = "devolución.html";</script>';
                        exit;
                    } else {
                        echo '<script>alert("Error al actualizar el número de préstamos."); window.history.back();</script>';
                        exit;
                    }
                } else {
                    echo '<script>alert("Error al actualizar la disponibilidad del libro."); window.history.back();</script>';
                    exit;
                }
            } else {
                echo '<script>alert("Error al registrar la devolución."); window.history.back();</script>';
                exit;
            }
        } else {
            echo '<script>alert("No se encontraron registros de préstamo activos para este usuario y libro."); window.history.back();</script>';
            exit;
        }
    } else {
        // Si algún campo está vacío, muestra un mensaje de error
        echo '<script>alert("Todos los campos son obligatorios."); window.history.back();</script>';
        exit;
    }
}

// Cerrar la conexión
pg_close($conexion);
?>
