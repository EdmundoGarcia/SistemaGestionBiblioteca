<?php
    include 'conexion.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style/estiloprueba.css" rel="stylesheet" type="text/css">
    <title>Consultas</title>
</head>
<body>
<header>
        <div class="container">
            <div class="logo">

                <a href="inicioAdmin.html"><img src="img/biblioteca.jpg" alt="Logo"></a>



                <h3>Biblioteca Universidad Tecnológica</h3>

            </div>
            <div class="navbar">
                <nav>
                    <ul class="menu">
                        <li class="submenu">
                            <a href="#">Alumnos</a>
                            <ul class="submenu-content">
                                <li><a href="consultasAlumnos.php">Cosulta</a></li>
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="#">Profesores</a>
                            <ul class="submenu-content">
                                <li><a href="consultaProfesor.php">Consulta</a></li>
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="#">Libros</a>
                            <ul class="submenu-content">
                                <li><a href="consultaLibros.php">Consulta</a></li>
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="#">Prestamo</a>
                            <ul class="submenu-content">
                                <li><a href="consultaPrestamoAlumno.php">Consulta Alumnos</a></li>
                                <li><a href="consultaPrestamoProfe.php">Consulta Profesores</a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <br>
    <br>
    <br>
    <br>
 
    <h2>Consultas</h2>
    <br>
    <br>
    
    <?php
        $resultado = pg_query($conexion, "SELECT isbn, titulo, autor, editorial, anio_public, ejemplar, disponible FROM books ORDER BY titulo, ejemplar");
        if(!$resultado){
            echo'Ocurrió un error';
            exit;
        }
    ?>

    <table>
        <tr>
            <th>ISBN</th>
            <th>Titulo</th>
            <th>Autor</th>
            <th>Editorial</th>
            <th>Año Publicación</th>
            <th>Ejemplar</th>
            <th>Disponible</th>
        </tr>

        <?php
        while($fila=pg_fetch_assoc($resultado)){
            // Convertir el valor almacenado en la base de datos a un formato legible
            $disponible = $fila['disponible'] === 't' ? 'Sí' : 'No'; // 't' representa true, 'f' representa false
            echo"
                <tr>
                    <td>$fila[isbn]</td>
                    <td>$fila[titulo]</td>
                    <td>$fila[autor]</td>
                    <td>$fila[editorial]</td>
                    <td>$fila[anio_public]</td>
                    <td>$fila[ejemplar]/$fila[isbn]</td>
                    <td>$disponible</td>
                </tr>
            ";
        }
        ?>
        
    </table>

</body>
</html>
