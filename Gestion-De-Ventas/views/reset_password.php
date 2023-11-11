<?php
session_start();
require_once "../model/DAOUsuarios.php";
$cdns = file_get_contents("plugins/encabezados.php");
$scripts = file_get_contents("plugins/scripts.php");

if ($_POST) {
    if (isset($_POST["btnResetPassword"])) {
        $dao = new DAOUsuarios();
        $correo = $_POST["txtCorreo"];
        $usuario = $dao->getCorreo($correo);

        if ($usuario) {
            // Redirige al usuario a la página de restablecimiento de contraseña
            header("Location: reset_password_process.php?correo=" . urlencode($correo));
        } else {
            echo "No se encontró ningún usuario con ese correo.";
        }
    }
}

if ($_GET) {
    if (isset($_GET["cerrar"])) {
        session_destroy();
        header("Location: index.php");
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <?= $cdns ?>
    <title>Confirmacion de Correo</title>
</head>

<body>
    <div class="login-container">
        <div class="login-content">
            <p class="text-center">
                <i class="fas fa-user-circle fa-5x"></i>
            </p>
            <p class="text-center">
                Restablecer Contraseña
            </p>
            <form action="reset_password.php" method="post">
                <div class="form-group">
                    <label for="UserEmail" class="bmd-label-floating">
                        <i class="fas fa-envelope"></i> &nbsp;Correo Electrónico
                    </label>
                    <input type="text" class="form-control" id="txtCorreo" name="txtCorreo" pattern="[^@]+@gmail\.com" title="Ingresa un correo de Gmail válido" required>
                </div><br>
                <input type="submit" name="btnResetPassword" value="Restablecer Contraseña" class="btn btn-danger">
            </form>
        </div>
    </div>

    <?= $scripts ?>

</body>

</html>