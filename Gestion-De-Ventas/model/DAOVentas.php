<?php
require_once "config.php";
require_once "Ventas.php";
require_once "DetalleVentas.php";
require_once "DAOProductos.php"; // Ajusta la ruta según la ubicación real de tu clase

//para lo de excel
require_once __DIR__ . '/../views/Reportes/vendor/autoload.php';

use FontLib\Table\Type\head;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
///////////////////////////////////////////////////////////
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


    public function encontrarVentaPorID($ventaID)
    {
        $this->conectar();

        // Prepara la consulta SQL
        $stmt = $this->con->prepare("SELECT * FROM ventas WHERE ventasID = ?");

        // Vincula el parámetro
        $stmt->bind_param("i", $ventaID);

        // Ejecuta la consulta
        $stmt->execute();

        // Obtiene el resultado de la consulta
        $resultado = $stmt->get_result();

        // Verifica si se encontró una venta
        if ($resultado->num_rows > 0) {
            // Obtén los datos de la venta
            $venta = $resultado->fetch_assoc();
            $this->desconectar();
            return $venta;
        } else {
            // No se encontró una venta con el ID proporcionado
            $this->desconectar();
            return null;
        }
    }


    public function obtenerDetallesVentaPorID($ventaID)
    {
        $this->conectar();

        // Prepara la consulta SQL para obtener detalles de venta con información de productos
        $sql = "SELECT DV.*, P.* FROM Detalle_ventas DV
                INNER JOIN Productos P ON DV.productosID = P.productosID
                WHERE DV.ventasID = ?";

        $stmt = $this->con->prepare($sql);

        // Vincula el parámetro
        $stmt->bind_param("i", $ventaID);

        // Ejecuta la consulta
        $stmt->execute();

        // Obtiene el resultado de la consulta
        $resultado = $stmt->get_result();

        // Inicializa un array para almacenar los detalles de venta
        $detallesVenta = array();

        // Recorre los resultados y agrega los detalles de venta al array
        while ($fila = $resultado->fetch_assoc()) {
            $detalleVenta = new DetalleVentas();
            $detalleVenta->setDetalleID($fila['detalleID']);
            $detalleVenta->setVentasID($fila['ventasID']);
            $detalleVenta->setProductosID($fila['productosID']);
            $detalleVenta->setCantidad($fila['cantidad']);
            $detalleVenta->setActivo($fila['activo']);

            // Setea las variables del producto en el objeto DetalleVentas
            $detalleVenta->setNombreProducto($fila['nombre']);
            $detalleVenta->setCodigoProducto($fila['codigo']);
            $detalleVenta->setPrecioVenta($fila['precio_venta']);


            $detallesVenta[] = $detalleVenta;
        }

        $this->desconectar();

        return $detallesVenta;
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
        $daoProductos = new DAOProductos();
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
                //Actualizamos el precio venta
                $daoProductos->actualizarPrecioDeVenta($detalle["id"], $detalle["precio"]);
                //calculamos el nuevo stock
                $newStock =  $detalle["stock"] -  $detalle["cantidad"];
                //actualizar stock
                $daoProductos->actualizarStock($detalle["id"], $newStock);
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

    public function rptVentasPorRango($desde, $hasta)
    {
        $sql = "SELECT v.ventasID, v.fecha, v.total, u.nombre as nombre_usuario ";
        $sql .= "FROM Ventas v ";
        $sql .= "INNER JOIN Usuario u ON v.usuarioID = u.usuarioID ";
        $sql .= "WHERE v.fecha BETWEEN '$desde' AND '$hasta'";

        $this->conectar();
        $res = $this->con->query($sql);

        $html = "<table class='table'><thead>";
        $html .= "<th>ID</th><th>NOMBRE</th><th>FECHA</th><th>TOTAL</th>";
        $html .= "</thead><tbody>";

        $cont = 0;
        while ($fila = mysqli_fetch_assoc($res)) {
            $html .= "<tr>";
            $html .= "<td>" . $fila["ventasID"] . "</td>";
            $html .= "<td>" . $fila["nombre_usuario"] . "</td>";
            $html .= "<td>" . $fila["fecha"] . "</td>";
            $html .= "<td>$" . $fila["total"] . "</td>";
            $html .= "</tr>";
            $cont++;
        }
        $html .= "</tbody></table>";
        $res->close();
        $this->desconectar();
        $data = array();
        $data[] = $html;
        $data[] = $cont;

        return $data;
    }

    public function getExcelVentaRango($desde, $hasta)
    {
        $sql = "SELECT v.ventasID, v.fecha, v.total, u.nombre as nombre_usuario ";
        $sql .= "FROM Ventas v ";
        $sql .= "INNER JOIN Usuario u ON v.usuarioID = u.usuarioID ";
        $sql .= "WHERE v.fecha BETWEEN '$desde' AND '$hasta'";

        $this->conectar();
        $res = $this->con->query($sql);

        $excel = new Spreadsheet();
        $hojaActiva = $excel->getActiveSheet();
        $hojaActiva->setTitle("VENTAS POR RANGO DE FECHA");
        $hojaActiva->getStyle('A4:D4')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

        //ENCABEZADO
        $hojaActiva->setCellValue("A2", "PROYECTO FINAL");
        $hojaActiva->setCellValue("B2", "GESTION DE VENTAS");
        $hojaActiva->setCellValue("C2", "GRUPO DS39A");

        //ENCABEZADOS DE LA TABLA 
        $hojaActiva->getColumnDimension("A")->setWidth(25);
        $hojaActiva->setCellValue("A4", "ID VENTA");
        $hojaActiva->getColumnDimension("B")->setWidth(25);
        $hojaActiva->setCellValue("B4", "NOMBRE");
        $hojaActiva->getColumnDimension("C")->setWidth(25);
        $hojaActiva->setCellValue("C4", "FECHA");
        $hojaActiva->getColumnDimension("D")->setWidth(30);
        $hojaActiva->setCellValue("D4", "TOTAL");

        //LOS REGISTROS DE LA BASE DE DATOS
        $fila = 5;
        while ($filas = $res->fetch_assoc()) {
            $hojaActiva->setCellValue("A" . $fila, $filas["ventasID"]);
            $hojaActiva->setCellValue("B" . $fila, $filas["nombre_usuario"]);
            $hojaActiva->setCellValue("C" . $fila, $filas["fecha"]);
            $hojaActiva->setCellValue("D" . $fila, $filas["total"]);
            $fila++;
        }

        //ENVIAR ENCABEZADOS
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="ReporteVentasPorRangoFecha.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = IOFactory::createWriter($excel, "Xlsx");
        $writer->save('php://output');
        exit;
    }
}
