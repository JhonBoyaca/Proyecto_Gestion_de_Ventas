<?php
require_once "config.php";
require_once "Productos.php";
class DAOProductos
{
    private $con;


    private function conectar()
    {
        try {
            $this->con = new mysqli(SRV, USR, PWD, SCHEMA);
        } catch (Exception $ex) {
            echo "<script>console.log('Ocurrio un error de conexión...')</script>";
        }
    }
    private function desconectar()
    {
        $this->con->close();
    }

    public function seleccionarProductos()
    {
        $productos = array();
        $sql = "SELECT * FROM productos WHERE activo = 1";
        $this->conectar();
        $res = $this->con->query($sql);

        if (mysqli_num_rows($res) < 1) {
            $this->desconectar();
            return $productos;
        }

        while ($fila = mysqli_fetch_assoc($res)) {
            $producto = new Productos();
            $producto->setProductosID($fila["productosID"]);
            $producto->setNombre($fila["nombre"]);
            $producto->setCodigo($fila["codigo"]);
            $producto->setPrecioCompra($fila["precio_compra"]);
            $producto->setPrecioVenta($fila["precio_venta"]);
            $producto->setStock($fila["stock"]);
            $producto->setStockMin($fila["stock_min"]);
            $producto->setProveedoresID($fila["ProveedoresID"]);
            $producto->setCategoriasID($fila["categoriasID"]);
            $producto->setActivo($fila["activo"]);
            $productos[] = $producto;
        }

        $this->desconectar();
        $res->close();
        return $productos;
    }

    // Crear un arreglo asociativo con los datos





    public function encontrarProductoPorCodigo($codigo)
    {
        $producto = null;
        $sql = "SELECT * FROM productos WHERE codigo = '$codigo' AND activo = 1";
        $this->conectar();
        $res = $this->con->query($sql);

        if (mysqli_num_rows($res) === 1) {
            $fila = mysqli_fetch_assoc($res);


            $productoSend = array(
                "codigo" => $fila["codigo"],
                "nombre" => $fila["nombre"],
                "precio" => $fila["precio_venta"]
            );

            // Convertir el arreglo a formato JSON
            $productoJSON = json_encode($productoSend);
        }


        $this->desconectar();
        $res->close();
        return  $productoJSON;
    }
}
