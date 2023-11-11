<?php
session_start();
require_once "../model/DAOUsuarios.php";
$cdns = file_get_contents("plugins/encabezados.php");
$scripts = file_get_contents("plugins/scripts.php");

if ($_POST) {
    if (isset($_POST["btnRestablecer"])) {
        $correo = $_POST["txtCorreo"];
        $nuevaContrasena = $_POST["txtNuevaContrasena"];
        $confirmarContrasena = $_POST["txtConfirmarContrasena"];

        if ($nuevaContrasena === $confirmarContrasena) {
            $dao = new DAOUsuarios();
            $usuario = $dao->getCorreo($correo);

            if ($usuario) {
                // Actualizar la contraseña en la base de datos
                $dao->updatePassword($usuario['correo'], $nuevaContrasena);
                echo "Contraseña restablecida con éxito. Ahora puedes iniciar sesión con tu nueva contraseña.";
            } else {
                echo "No se encontró ningún usuario con ese correo.";
            }
        } else {
            echo "Las contraseñas no coinciden. Inténtalo de nuevo.";
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
    <title>Restablecer Contraseña</title>
</head>

<body>
    <div class="login-container">
        <div class="login-content">
            <p class="text-center">
                <i class="fas fa-unlock fa-5x"></i>
            </p>
            <p class="text-center">
                Restablecer Contraseña
            </p>
            <form action="reset_password_process.php" method="post">
                <div class="form-group">
                    <label for="UserEmail" class="bmd-label-floating">
                        <i class="fas fa-envelope"></i> &nbsp;Correo Electrónico
                    </label>
                    <input type="text" class="form-control" id="txtCorreo" name="txtCorreo" pattern="[^@]+@gmail\.com" title="Ingresa un correo de Gmail válido" required>
                </div><br>
                <div class="form-group">
                    <label for="NewPassword" class="bmd-label-floating">
                        <i class="fas fa-key"></i> &nbsp;Nueva Contraseña
                    </label>
                    <input type="password" class="form-control" id="txtNuevaContrasena" name="txtNuevaContrasena" minlength="7" required>
                    <small class="form-text text-muted">La contraseña debe tener al menos 7 caracteres.</small>
                </div>
                <div class="form-group">
                    <label for="ConfirmPassword" class="bmd-label-floating">
                        <i class="fas fa-key"></i> &nbsp;Confirmar Contraseña
                    </label>
                    <input type="password" class="form-control" id="txtConfirmarContrasena" name="txtConfirmarContrasena" minlength="7" required>
                </div><br>
                <input type="submit" name="btnRestablecer" value="Restablecer Contraseña" class="btn btn-danger">
            </form>
        </div>
    </div>

    <?= $scripts ?>

</body>

</html>