<?php

require_once "../model/DAOProductos.php"; // Ajusta la ruta según la ubicación real de tu clase
require_once "../model/Productos.php"; // Ajusta la ruta según la ubicación real de tu clase

$dao = new DAOProductos();
$producto = new Productos();

$respuesta = null;
$data = array();

if ($_POST) {
    if (isset($_POST["key"])) {
        $key = $_POST["key"];
        switch ($key) {
            case "get":
                $respuesta = $dao->seleccionarProductos();
                break;
            case "getObjProducto":
                if (isset($_POST["codigo"])) {
                    $codigo = $_POST["codigo"];
                    $producto = $dao->encontrarProductoPorCodigo($codigo);
                    if ($producto) {
                        $respuesta = $producto;
                    } else {
                        $respuesta = "Producto no encontrado"; // O un mensaje de error adecuado
                    }
                } else {
                    $respuesta = "Código de producto no proporcionado"; // Manejar el caso en que no se proporciona el código
                }
                break;
        }
    }
}

echo json_encode($respuesta);
