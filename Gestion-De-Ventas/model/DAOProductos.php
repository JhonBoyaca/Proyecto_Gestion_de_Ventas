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

    public function actualizarPrecioDeVenta($idProducto, $nuevoPrecio)
    {
        $sql = "UPDATE productos SET precio_venta = '$nuevoPrecio' WHERE productosID = $idProducto";
        $this->conectar();

        if ($this->con->query($sql)) {
            // Éxito al actualizar el precio
            $resultado = array(
                "success" => true,
                "message" => "Precio de venta actualizado con éxito"
            );
        } else {
            // Error al actualizar el precio
            $resultado = array(
                "success" => false,
                "message" => "Error al actualizar el precio de venta"
            );
        }

        $this->desconectar();
        return json_encode($resultado);
    }

    public function actualizarStock($idProducto, $nuevoStock)
    {
        $sql = "UPDATE productos SET stock = '$nuevoStock' WHERE productosID = $idProducto";
        $this->conectar();

        if ($this->con->query($sql)) {
            // Éxito al actualizar el stock
            $resultado = array(
                "success" => true,
                "message" => "Stock actualizado con éxito"
            );
        } else {
            // Error al actualizar el stock
            $resultado = array(
                "success" => false,
                "message" => "Error al actualizar el stock del producto"
            );
        }

        $this->desconectar();
        return json_encode($resultado);
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
                "id" => $fila["productosID"],
                "codigo" => $fila["codigo"],
                "nombre" => $fila["nombre"],
                "stock" => $fila["stock"],
                "precio" => $fila["precio_venta"]
            );

            // Convertir el arreglo a formato JSON
            $productoJSON = json_encode($productoSend);
        }


        $this->desconectar();
        $res->close();
        return  $productoJSON;
    }

    public function get1()
    {
        $sql = "select p.categoriasID, p.ProveedoresID, p.productosID,p.nombre, p.precio_compra,p.precio_venta, p.stock, p.stock_min, c.nombre_categoria, ";
        $sql .= "pro.nombre_proveedor from productos p inner join categorias c on ";
        $sql .= "p.categoriasID = c.categoriasID inner join proveedores pro on p.ProveedoresID= ";
        $sql .= "pro.ProveedoresID";

        $this->conectar();
        $res = $this->con->query($sql);

        $html = "<table id='tabla' class='table table-hover table-sm'><thead>";
        $html .= "<th>ID</th><th>NOMBRE</th><th>Precio Compra</th><th>Precio Venta</th><th>STOCK</th><th>STOCK MIN</th><th>CATEGORIA</th><th>PROVEEDOR</th>";
        $html .= "</thead><tbody>";

        while ($fila = mysqli_fetch_assoc($res)) {
            $html .= "<tr>";
            $html .= "<td>" . $fila["productosID"] . "</td>";
            $html .= "<td>" . mb_convert_encoding($fila["nombre"], 'UTF-8') . "</td>";
            $html .= "<td>" . $fila["precio_compra"] . "</td>";
            $html .= "<td>" . $fila["precio_venta"] . "</td>";
            $html .= "<td>" . $fila["stock"] . "</td>";
            $html .= "<td>" . $fila["stock_min"] . "</td>";
            $html .= "<td>" . mb_convert_encoding($fila["nombre_categoria"], 'UTF-8') . "</td>";
            $html .= "<td>" . mb_convert_encoding($fila["nombre_proveedor"], 'UTF-8') . "</td>";
            $html .= "</tr>";
        }
        $html .= "</tbody></table>";
        $res->close();
        $this->desconectar();
        return $html;
    }
    public function getComboProveedores()
    {
        $sql = "select ProveedoresID, nombre_proveedor from proveedores";
        $this->conectar();
        $res = $this->con->query($sql);
        $html = "";
        while ($fila = mysqli_fetch_assoc($res)) {
            $html .= "<option value='" . $fila["ProveedoresID"] . "'>";
            $html .= $fila["nombre_proveedor"];
            $html .= "</option>";
        }
        $res->close();
        $this->desconectar();
        return $html;
    }
    public function getComboCategorias()
    {
        $sql = "select categoriasID, nombre_categoria from categorias";
        $this->conectar();
        $res = $this->con->query($sql);
        $html = "";
        while ($fila = mysqli_fetch_assoc($res)) {
            $html .= "<option value='" . $fila["categoriasID"] . "'>";
            $html .= $fila["nombre_categoria"];
            $html .= "</option>";
        }
        $res->close();
        $this->desconectar();
        return $html;
    }
    public function agregar(Productos $pro)
    {
        $this->conectar();
        $statement = $this->con->prepare("insert into productos (nombre, precio_compra, precio_venta, stock, stock_min, categoriasID, ProveedoresID)values(?,?,?,?,?,?,?)");
        $nombre = $pro->getNombre();
        $precio_compra = $pro->getPrecioCompra();
        $precio_venta = $pro->getPrecioVenta();
        $stock = $pro->getStock();
        $stockMin = $pro->getstockMin();
        $idCategoria = $pro->getCategoriasID();
        $idProveedor = $pro->getProveedoresID();

        $statement->bind_param(
            "sssiiii",
            $nombre,
            $precio_compra,
            $precio_venta,
            $stock,
            $stockMin,
            $idCategoria,
            $idProveedor

        );

        if ($statement->execute()) {
            $statement->close();
            $this->desconectar();
            return true;
        } else {
            $statement->close();
            $this->desconectar();
            return false;
        }
    }
}
