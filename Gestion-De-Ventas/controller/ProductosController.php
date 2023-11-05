<?php

require_once "../model/DAOProductos.php"; // Ajusta la ruta según la ubicación real de tu clase


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
            case "get1":
                $respuesta = $dao->get1();
                break;
            case "getComboProveedores":
                $respuesta = $dao->getComboProveedores();
                break;
            case "getComboCategorias":
                $respuesta = $dao->getComboCategorias();
                break;


            case "agregar":
                //vamos hacer que en la vista se envie la key "data" y trae la data del form
                parse_str($_POST["data"], $data);
                $producto->setNombre($data["txtNombre"]);
                $producto->setPrecioCompra($data["txtprecioCom"]);
                $producto->setPrecioVenta($data["txtprecioVen"]);
                $producto->setStock($data["txtStock"]);
                $producto->setStockMin($data["txtStockMin"]);
                $producto->setCategoriasID($data["cmbIdCategoria"]);
                $producto->setProveedoresID($data["cmbIdProveedor"]);

                if ($dao->agregar($producto)) {
                    $respuesta = true;
                } else {
                    $respuesta = false;
                }

                break;
        }
    }
}

echo $respuesta;
