<?php
$cdns = file_get_contents("plugins/encabezados.php");
$scripts = file_get_contents("plugins/scripts.php");
$menu = file_get_contents("plugins/menu.php");

session_start();

if (!isset($_SESSION["correo"])) {
    header("Location:index.php");
}

if ($_POST) {
    if (isset($_POST["txtDesde"]) && isset($_POST["txtHasta"])) {
        $desde = $_POST["txtDesde"];
        $hasta = $_POST["txtHasta"];
        header("location:Reportes/rptVentasRango.php?desde=$desde&hasta=$hasta");
    } else {
        echo 'No estas enviando alguna de la fechas.....';
    }
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <?= $cdns ?>

    <title>Reportes Con Stock Min</title>
</head>

<body>
    <style>
        .custom-input {
            background-image: url('assets/img/PDF.png');
            background-size: 30px 30px;
            background-repeat: no-repeat;
            background-position: left center;
            padding-left: 40px;
            border: 1px solid #dc3545;
        }
    </style>
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
                <!-- Content of the page header, such as titles, etc. -->
            </div>

            <!-- Content -->
            <div class="full-box content">
                <!-- Aquí debes colocar el contenido de tu página -->
                <div class="container" id="content-container">
                    <h1 class="text-center">GESTION DE REPORTES</h1>
                    <hr>
                    <hr>
                    <h3>Gestion de reportes de Productos con stock al minimo</h3>
                    <hr>
                    <h5>Aqui podras realizar la descarga de los reportes en PDF o EXCEL de los Productos con al minino de 50 UND</h5>
                    <hr>
                    <a href="Reportes/rptStockMin.php" target="_blank" class="btn btn-outline-danger btn-sm">
                        <img src="assets/img/PDF.png" style="width: 30px; height: 30px;">
                        Reporte Productos Con Stock al Min
                    </a>
                    <hr>
                    <form method="post" action="../controller/ProductosController.php" target="_blank">
                        <input type="hidden" name="key" value="getExcelStockMin">
                        <button class="btn btn-outline-success btn-sm">
                            <img src="assets/img/excel.png" style="width: 30px; height: 30px;">
                            Reporte Productos Con al Stock Min
                        </button>
                    </form>
                    <hr>
                    <hr>
                    <h3>Gestion de reportes de Ventas por rango de fecha</h3>
                    <hr>
                    <h5>Aqui podras realizar la descarga de los reportes en PDF o EXCEL de las ventas por rango de fecha</h5>
                    <hr>
                    <form action="reportesStockMin.php" method="post" target="_blank">
                        <label for="">Desde la Fecha</label>
                        <input type="date" name="txtDesde" id="txtDesde" class="form-control">
                        <label for="">Hasta la Fecha</label>
                        <input type="date" name="txtHasta" id="txtHasta" class="form-control">
                        <br>
                        <input type="submit" value="Reporte Ventas Por Rangos" class="btn btn-outline-danger custom-input">
                    </form>
                    <script>
                        $("#txtHasta").blur(function() {
                            var desde = $("#txtDesde").val();
                            var hasta = $("#txtHasta").val();
                            $("#desde").val(desde);
                            $("#hasta").val(hasta);
                        });
                    </script>
                    <form method="post" action="../controller/VentaController.php" target="_blank">
                        <input type="hidden" name="key" value="getExcelVentaRango">
                        <input type="hidden" name="desde" id="desde">
                        <input type="hidden" name="hasta" id="hasta"><br>
                        <button class="btn btn-outline-success btn-sm">
                            <img src="assets/img/excel.png" style="width: 30px; height: 30px;">
                            Reporte Ventas Por Rangos
                        </button>
                    </form>
                    <hr>
                    <hr>
                </div>
            </div>



        </section>
    </main>


    <?= $scripts ?>

    <script src="./js/codigo.js"></script>

</body>

</html>