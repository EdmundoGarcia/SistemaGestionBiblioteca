<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style/estiloLogin.css" rel="stylesheet" type="text/css">
    <title>Login</title>
</head>
<body>
    <div class="login">
        <form class= "formLogin" method="post" action="altaLogin.php"> 
            <h1>¡Bienvenido!</h1>
            <input id="user" type="text" name="username" placeholder="Usuario">
            <input id="pass" type="password" name="password" placeholder="Contraseña">
            <?php
                // Verificar si hay un error en la autenticación
                if (isset($_GET['error']) && $_GET['error'] == 1) {
                    echo "<p style='color: red; font-weight: bold; text-align: center;'>Usuario o Contraseña Incorrectos. <br>Intentelo de nuevo</p>";
                }
            ?>
            <input class="btn" type="submit" name="login" value="Iniciar Sesión">
        </form>
    </div>
</body>
</html>
