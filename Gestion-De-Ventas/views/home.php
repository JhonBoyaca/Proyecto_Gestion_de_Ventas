<?php
$cdns = file_get_contents("plugins/encabezados.php");
$scripts = file_get_contents("plugins/scripts.php");
$menu = include("plugins/menu.php");
$rol = $_SESSION["rol"];
$usuarioID = $_SESSION["usuarioID"];
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <?= $cdns ?>
    <title>Home</title>
</head>

<body>
    <!-- Main container -->
    <main class="full-box main-container">
        <?= $menu ?>
        <!-- Page content -->
        <section class="full-box page-content">
            <nav class="full-box navbar-info">
                <a href="#" style="float: left;" class="show-nav-lateral">
                    <i class="fas fa-exchange-alt"></i>
                </a>

            </nav>

            <!-- Page header -->
            <div class="full-box page-header">
                <div class="container" id="content-container">

                    <h1>Bienvenido, <?php echo $correo; ?></h1>
                    <p>Rol: <?php echo $rol; ?> </p>
                    <!-- Aquí colocas el contenido de tu página -->
                </div>
                <!-- Content of the page header, such as titles, etc. -->
            </div>

            <!-- Content -->
            <div class="full-box content">
                <!-- Aquí debes colocar el contenido de tu página -->
                <div class="container" id="content-container">

                </div>

            </div>



        </section>
    </main>
    <script>

    </script>

    <?= $scripts ?>

    <script src="./js/codigo.js"></script>
</body>

</html>