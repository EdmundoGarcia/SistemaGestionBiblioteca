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
        $resultado = pg_query($conexion, "SELECT p.codigo_usuario, s.nombre, s.apellido, p.id_libro, p.ejemplar, p.fecha_salida, p.fecha_limite, p.multa, p.fecha_devolucion 
                                          FROM prestamo_profe p 
                                          JOIN profesores s ON p.codigo_usuario = s.codigo_profesor
                                          ORDER BY s.apellido");
        if(!$resultado){
            echo'Ocurrió un error';
            exit;
        }
    ?>

    <table>
        <tr>
            <th>Código Usuario</th>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>ISBN</th>
            <th>Ejemplar</th>
            <th>Fecha Salida</th>
            <th>Fecha Límite</th>
            <th>Multa</th>
            <th>Fecha Devolución</th>
        </tr>
        <?php
        while($fila=pg_fetch_assoc($resultado)){
            echo"
                <tr>
                    <td>$fila[codigo_usuario]</td>
                    <td>$fila[nombre]</td>
                    <td>$fila[apellido]</td>
                    <td>$fila[id_libro]</td>
                    <td>$fila[ejemplar]</td>
                    <td>$fila[fecha_salida]</td>
                    <td>$fila[fecha_limite]</td>
                    <td>$fila[multa]</td>
                    <td>$fila[fecha_devolucion]</td>
                </tr>
            ";
        }
        ?>
    </table>

</body>
</html>
