
<?php
// Equipo 3
// Flores GRanero MArio Zahit
// Garcia Gutierrez Juan José
// Garcia Valdes Edmundo
//Godinez FLores Jonatan
//Seccion D03
//Calendario 2024A
// Definir los datos de conexión a la base de datos
$dbhost = "localhost";
$dbport = "5432";
$dbname = "Biblioteca"; #Aqui ingresa el nombre de tu base de datos
$dbuser = "postgres";
$dbpass = "admin"; #Ingresa la cotraseña de tu servidor

// Conectar a la base de datos
$conexion = pg_connect("host=$dbhost port=$dbport dbname=$dbname user=$dbuser password=$dbpass");

if (!$conexion) {
    echo "Error al conectar a la base de datos: " . pg_last_error();
    exit();
}

?>
