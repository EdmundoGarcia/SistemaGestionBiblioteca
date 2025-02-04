<?php
include 'conexion.php';

function insertarLibro($conexion, $isbn, $titulo, $autor, $editorial, $anio_public, $ejemplar) {
    $query = "INSERT INTO books(isbn, titulo, autor, editorial, anio_public, ejemplar) VALUES ('$isbn', '$titulo', '$autor', '$editorial', '$anio_public', '$ejemplar')";
    return pg_query($conexion, $query);
}

function actualizarDisponibilidadLibro($conexion, $isbn, $ejemplar) {
    $query = "UPDATE books SET disponible = TRUE WHERE isbn = '$isbn' AND ejemplar = '$ejemplar'";
    return pg_query($conexion, $query);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $isbn = $_POST['isbn'];
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $editorial = $_POST['editorial'];
    $anio_public = $_POST['anio_public'];
    $ejemplar = $_POST['ejemplar'];

    // Iniciar transacción
    pg_query($conexion, "BEGIN");

    // Verificar si el ISBN y el ejemplar ya existen en la base de datos
    $query_existencia = "SELECT * FROM books WHERE isbn = '$isbn' AND ejemplar = '$ejemplar'";
    $resultado_existencia = pg_query($conexion, $query_existencia);

    if (pg_num_rows($resultado_existencia) > 0) {
        // Si ya existe un libro con ese ISBN y ejemplar, mostrar un mensaje de error
        echo '<script>alert("Error: El libro con ISBN ' . $isbn . ' y ejemplar ' . $ejemplar . ' ya existe en la base de datos."); window.history.back();</script>';
        exit();
    } else {
        // Si el libro no existe, proceder con la inserción
        if (insertarLibro($conexion, $isbn, $titulo, $autor, $editorial, $anio_public, $ejemplar)) {
            // Actualizar la disponibilidad del libro a TRUE (disponible)
            if (actualizarDisponibilidadLibro($conexion, $isbn, $ejemplar)) {
                // Confirmar transacción
                pg_query($conexion, "COMMIT");
                // Redirigir a la página de altas con un parámetro de éxito en la URL
                echo '<script>alert("Libro registrado exitosamente."); window.location.href = "altaLibros.html?success=true";</script>';
                exit();
            } else {
                // Si ocurre un error al actualizar la disponibilidad, hacer rollback
                pg_query($conexion, "ROLLBACK");
                // Mostrar un mensaje de error
                echo '<script>alert("Error al establecer la disponibilidad del libro."); window.history.back();</script>';
                exit();
            }
        } else {
            // Si ocurre un error en la inserción, hacer rollback
            pg_query($conexion, "ROLLBACK");
            // Mostrar un mensaje de error
            echo '<script>alert("Error: ' . pg_last_error() . '"); window.history.back();</script>';
            exit();
        }
    }
}

// Cerrar conexión
pg_close($conexion);
?>
