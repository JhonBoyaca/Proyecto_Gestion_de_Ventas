<?php

require_once "../model/DAOVentas.php"; // Ajusta la ruta según la ubicación real de tu clase


$daoVentas = new DAOVentas();


$respuesta = null;
$data = array();
if ($_POST) {
    if (isset($_POST["key"])) {
        $key = $_POST["key"];
        switch ($key) {


            case "registrarVenta":
                $productosAgregados = $_POST["arrayProducto"];
                $totalVenta = $_POST["totalVenta"];
                $usuarioID = $_POST["usuarioID"];
                $respuesta = $daoVentas->registrarVenta($productosAgregados, $totalVenta, $usuarioID);
                break;

            case "getExcelVentaRango":
                $desde = $_POST["desde"];
                $hasta = $_POST["hasta"];
                $daoVentas->getExcelVentaRango($desde, $hasta);
                break;
        }
    }
}

echo $respuesta;
