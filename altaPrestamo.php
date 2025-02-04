<?php
include 'conexion.php';

function calcularFechaLimite($fecha_salida) {
    return date('Y-m-d', strtotime($fecha_salida . ' + 8 days'));
}

function obtenerNumeroPrestamos($conexion, $codigo_usuario, $tipo_usuario) {
    if ($tipo_usuario === 'Estudiante') {
        $query = "SELECT num_prestamos FROM students WHERE codigo = '$codigo_usuario'";
    } elseif ($tipo_usuario === 'Profesor') {
        $query = "SELECT num_prestamos FROM profesores WHERE codigo_profesor = '$codigo_usuario'";
    }
    $resultado = pg_query($conexion, $query);
    return pg_fetch_assoc($resultado)['num_prestamos'];
}

function obtenerNombreUsuario($conexion, $codigo_usuario, $tipo_usuario) {
    if ($tipo_usuario === 'Estudiante') {
        $query = "SELECT nombre FROM students WHERE codigo = '$codigo_usuario'";
    } elseif ($tipo_usuario === 'Profesor') {
        $query = "SELECT nombre FROM profesores WHERE codigo_profesor = '$codigo_usuario'";
    }
    $resultado = pg_query($conexion, $query);
    return pg_fetch_assoc($resultado)['nombre'];
}

function obtenerTituloLibro($conexion, $id_libro) {
    $query = "SELECT titulo FROM books WHERE isbn = '$id_libro'";
    $resultado = pg_query($conexion, $query);
    return pg_fetch_assoc($resultado)['titulo'];
}

function verificarEjemplarDisponible($conexion, $id_libro, $ejemplar) {
    $query = "SELECT * FROM books WHERE isbn = '$id_libro' AND ejemplar = '$ejemplar' AND disponible = TRUE";
    $resultado = pg_query($conexion, $query);
    return pg_num_rows($resultado) > 0;
    
}

// Definir la función obtenerCorreoUsuario
function obtenerCorreoUsuario($conexion, $codigo_usuario, $tipo_usuario) {
    if ($tipo_usuario === 'Estudiante') {
        $query = "SELECT correo FROM students WHERE codigo = '$codigo_usuario'";
    } elseif ($tipo_usuario === 'Profesor') {
        $query = "SELECT correo FROM profesores WHERE codigo_profesor = '$codigo_usuario'";
    }
    $resultado = pg_query($conexion, $query);
    return pg_fetch_assoc($resultado)['correo'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $tipo_usuario = $_POST['tipo_usuario'];
    $codigo_usuario = $_POST['codigo_usuario'];
    $id_libro = $_POST['id_libro'];
    $ejemplar = $_POST['ejemplar'];
    $fecha_salida = $_POST['fecha_salida'];

    // Verificar que todos los campos del formulario estén completos
    if (!empty($tipo_usuario) && !empty($codigo_usuario) && !empty($id_libro) && !empty($ejemplar) && !empty($fecha_salida)) {
        // Verificar si el usuario existe y tiene préstamos disponibles
        $num_prestamos = obtenerNumeroPrestamos($conexion, $codigo_usuario, $tipo_usuario);
        if ($num_prestamos === null) {
            echo '<script>alert("Error: El código de usuario ingresado es incorrecto. Por favor, inténtelo de nuevo."); window.history.back();</script>';
            exit;
        } elseif ($num_prestamos >= 5) {
            echo '<script>alert("Error: El usuario ' . obtenerNombreUsuario($conexion, $codigo_usuario, $tipo_usuario) . ' ya ha alcanzado el límite de préstamos permitidos (5)."); window.history.back();</script>';
            exit;
        }

        // Verificar si el libro existe y está disponible
        if (!verificarEjemplarDisponible($conexion, $id_libro, $ejemplar)) {
            echo '<script>alert("Error: El ejemplar ' . $ejemplar . ' del libro con ISBN ' . $id_libro . ' no está disponible actualmente."); window.history.back();</script>';
            exit;
        }

        $fecha_limite = calcularFechaLimite($fecha_salida);

        // Insertar el préstamo
        if ($tipo_usuario === 'Estudiante') {
            $query_insertar = "INSERT INTO prestamo_student (codigo_usuario, id_libro, ejemplar, fecha_salida, fecha_limite) 
                                    VALUES ('$codigo_usuario', '$id_libro', '$ejemplar', '$fecha_salida', '$fecha_limite')";
        } elseif ($tipo_usuario === 'Profesor') {
            $query_insertar = "INSERT INTO prestamo_profe (codigo_usuario, id_libro, ejemplar, fecha_salida, fecha_limite) 
                                    VALUES ('$codigo_usuario', '$id_libro', '$ejemplar', '$fecha_salida', '$fecha_limite')";
        }
        
        if (pg_query($conexion, $query_insertar)) {
            // Actualizar disponibilidad del libro
            $query_actualizar_disponibilidad = "UPDATE books SET disponible = FALSE WHERE isbn = '$id_libro' AND ejemplar = '$ejemplar'";
            if (pg_query($conexion, $query_actualizar_disponibilidad)) {
                // Incrementar el número de préstamos del usuario
                if ($tipo_usuario === 'Estudiante') {
                    $query_incrementar_prestamos = "UPDATE students SET num_prestamos = num_prestamos + 1 WHERE codigo = '$codigo_usuario'";
                } elseif ($tipo_usuario === 'Profesor') {
                    $query_incrementar_prestamos = "UPDATE profesores SET num_prestamos = num_prestamos + 1 WHERE codigo_profesor = '$codigo_usuario'";
                }
                
                if (pg_query($conexion, $query_incrementar_prestamos)) {
                    // Enviar correo electrónico al usuario
                    $to = obtenerCorreoUsuario($conexion, $codigo_usuario, $tipo_usuario);
                    $titulo_libro = obtenerTituloLibro($conexion, $id_libro);
                    
                    if ($to) {
                        $subject = "Recordatorio de Fecha Límite de Préstamo";
                        $message = "Tu préstamo se completó exitosamente. Recuerda que tu fecha límite de devolución es: $fecha_limite\nDATOS DEL LIBRO:\nISBN: $id_libro\nTitulo: $titulo_libro\nEjemplar: $ejemplar";
                        $headers = "From: bibliotecauniversidadtecnologi@gmail.com\r\n" .
                                   "Reply-To: bibliotecauniversidadtecnologi@gmail.com";

                        if (mail($to, $subject, $message, $headers)) {
                            echo '<script>alert("Préstamo registrado exitosamente. Se ha enviado un correo electrónico al usuario con la fecha límite de devolución."); window.location.href = "altaPrestamo.html";</script>';
                            exit;
                        } else {
                            echo '<script>alert("Error: No se pudo enviar el correo electrónico. Por favor, inténtelo de nuevo."); window.history.back();</script>';
                            exit;
                        }
                    } else {
                        echo '<script>alert("Error: No se pudo obtener la dirección de correo electrónico del usuario. Por favor, inténtelo de nuevo."); window.history.back();</script>';
                        exit;
                    }
                } else {
                    echo '<script>alert("Error: No se pudo incrementar el número de préstamos del usuario. Por favor, inténtelo de nuevo."); window.history.back();</script>';
                    exit;
                }
            } else {
                echo '<script>alert("Error: No se pudo actualizar la disponibilidad del libro. Por favor, inténtelo de nuevo."); window.history.back();</script>';
                exit;
            }
        } else {
            echo '<script>alert("Error: No se pudo insertar el préstamo. Por favor, inténtelo de nuevo."); window.history.back();</script>';
            exit;
        }
    } else {
        // Si algún campo está vacío, muestra un mensaje de error
        echo '<script>alert("Error: Todos los campos son obligatorios."); window.history.back();</script>';
        exit;
    }
}

// Cerrar la conexión
pg_close($conexion);
?>
