<?php
require_once "config.php";
require_once "Ventas.php";
require_once "DetalleVentas.php";
class DAOVentas
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

    public function guardarDetalleVenta(DetalleVentas $detalle)
    {
        $ventasID = $detalle->getVentasID();
        $productosID = $detalle->getProductosID();
        $cantidad = $detalle->getCantidad();
        $activo = $detalle->isActivo() ? 1 : 0;
        // Prepara la declaración
        $this->conectar();
        $stmt = $this->con->prepare("INSERT INTO Detalle_ventas (ventasID, productosID, cantidad, activo) VALUES (?, ?, ?, ?)");

        // Vincula los parámetros
        $stmt->bind_param("iiii", $ventasID, $productosID, $cantidad, $activo);

        // Ejecuta la consulta
        if ($stmt->execute()) {
            $this->desconectar();
            return true; // Éxito
            
        } else {
            $this->desconectar();
            return false; // Error
        }
    }
    public function registrarVenta($array, $totalVenta, $usuarioID)
    {
        // Crear un objeto Ventas 
        $venta = new Ventas();
        $venta->setFecha(date("Y-m-d")); 
        $venta->setTotal($totalVenta);
        $venta->setUsuarioID($usuarioID);
        $venta->setActivo(true);

        // Llamar a guardarVenta para insertar la venta en la base de datos
       
        $ventaID = $this->guardarVenta($venta);

        if ($ventaID) {

            foreach ($array as $detalle) {
                $detalleVenta = new DetalleVentas();
                $detalleVenta->setVentasID($ventaID);
                $detalleVenta->setProductosID($detalle["id"]); 
                $detalleVenta->setCantidad($detalle["cantidad"]);
                $detalleVenta->setActivo(true); 

                // Llamar a guardarDetalleVenta para insertar el detalle en la base de datos
                $this->guardarDetalleVenta($detalleVenta);
            }
            // Devuelve el ID de la venta recién insertada
            return $ventaID;
        } else {
            // Ocurrió un error al guardar la venta
            return false;
        }
    }

    public function guardarVenta(Ventas $venta)
    {
        $fecha = $venta->getFecha();
        $total = $venta->getTotal();
        $usuarioID = $venta->getUsuarioID();
        $activo = $venta->isActivo() ? 1 : 0;
        // Prepara la consulta SQL
     

        // Prepara la declaración
        $this->conectar();
        $stmt = $this->con->prepare("INSERT INTO ventas (fecha, total, usuarioID, activo) VALUES (?, ?, ?, ?)");
       

        // Vincula los parámetros
        $stmt->bind_param("sdis", $fecha, $total, $usuarioID, $activo);

        // Ejecuta la consulta
        if ($stmt->execute()) {
            // Obtén el ID de la venta recién insertada
            $ventaID = $this->con->insert_id;

            // Retorna el ID de la venta
            $this->desconectar();
            return $ventaID;
        } else {
            $this->desconectar();
            return false; // Error
        }
    }
}
