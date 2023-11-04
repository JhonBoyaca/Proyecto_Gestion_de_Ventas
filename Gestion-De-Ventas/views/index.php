<?php
session_start();
require_once "../model/DAOUsuarios.php";
$cdns = file_get_contents("plugins/encabezados.php");
$scripts = file_get_contents("plugins/scripts.php");
if ($_POST) {
    if (isset($_POST["btnLogin"])) {
        $dao = new DAOUsuarios();
        $us = new Usuario();

        $us->setCorreo($_POST["txtUsuario"]);
        $us->setContrasena($_POST["txtContrasena"]);

        $datos = $dao->login($us);
        if ($datos != null) {
            $_SESSION["correo"] = $datos["correo"];
            $_SESSION["nombre"] = $datos["nombre"];
            $_SESSION["rol"] = $datos["rol"];
            $_SESSION["usuarioID"] = $datos["usuarioID"];
            header("Location:home.php");
        } else {
            echo "No se encontraron datos de inicio de sesión válidos."; // Agregar un mensaje de depuración
        }
    }
}

if ($_GET) {

    if (isset($_GET["cerrar"])) {
        session_destroy();
        header("Location:index.php");
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <?= $cdns ?>
    <title>Login</title>
</head>

<body>
    <div class="login-container">
        <div class="login-content">
            <p class="text-center">
                <i class="fas fa-user-circle fa-5x"></i>
            </p>
            <p class="text-center">
                Inicia sesión con tu cuenta
            </p>
            <form action="index.php" method="post">
                <div class="form-group">
                    <label for="UserName" class="bmd-label-floating"><i class="fas fa-user-secret"></i> &nbsp;Correo Usuario</label>
                    <input type="text" class="form-control" id="txtUsuario" name="txtUsuario" pattern="[^@]+@gmail\.com" title="Ingresa un correo de Gmail válido" required>
                </div>
                <div class="form-group">
                    <label for "UserPassword" class="bmd-label-floating"><i class="fas fa-key"></i> &nbsp;Contraseña</label>
                    <input type="password" class="form-control" id="txtContrasena" name="txtContrasena" minlength="7" required>
                    <small class="form-text text-muted">La contraseña debe tener al menos 7 caracteres.</small>
                </div>
                <input type="submit" name="btnLogin" value="Iniciar Sesion" class="btn-login text-center">
            </form>
        </div>
    </div>


    <?= $scripts ?>

</body>

</html>


</script>