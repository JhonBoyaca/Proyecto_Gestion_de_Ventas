<?php

use Dompdf\Options;
use Dompdf\Dompdf;

require_once '../../vendor/autoload.php';
require_once '../../model/DAOVentas.php'; // Asegúrate de ajustar la ruta correcta

// Recupera el ID de la venta desde la URL
if (isset($_GET['id'])) {
    $ventaID = $_GET['id'];

 

    $dompdf = new Dompdf();
    $dompdf->setPaper('b7', 'portrait');

    // Obtén los detalles de la venta por ID de venta
    $daoVentas = new DAOVentas();
    $detallesVenta = $daoVentas->obtenerDetallesVentaPorID($ventaID);
    $ventaOBJ = $daoVentas->encontrarVentaPorID($ventaID);

    // ... Código anterior ...
    // ... Código anterior ...

    // Genera el contenido HTML de la factura como un ticket
    $html = '<html>';
    $html .= '<head>';
    $html .= '<style>';
    $html .= 'body {';
    $html .= '  text-align: center;';
    $html .= '}';
    $html .= '.ticket {';
    $html .= '  width: <?php echo $medidaTicket ?>px;';
    $html .= '  max-width: <?php echo $medidaTicket ?>px;';
    $html .= '}';
    $html .= 'table {';
    $html .= '  width: 100%;';
    $html .= '  border-collapse: collapse;';
    $html .= '}';
    $html .= 'th, td {';
    $html .= '  border-top: 1px solid black;';
    $html .= '  border-collapse: collapse;';
    $html .= '  text-align: left;';
    $html .= '  padding: 0;';
    $html .= '}';
    $html .= 'td.producto {';
    $html .= '  text-align: center; font-size: 13px;  padding-right: 5px;';
    $html .= '}';
    $html .= 'th {';
    $html .= '  text-align: left;  font-size: 13px;  padding-right: 5px;';
    $html .= '}';
    $html .= '</style>';
    $html .= '</head>';
    $html .= '<body>';
    $html .= '<div class="ticket">'; // Agregamos una capa "ticket" para aplicar los estilos
    $html .= '<h1>VENTA</h1>';
    $html .= '<p>Fecha: '.$ventaOBJ['fecha'].'</p>';
    $html .= '<table>';
    $html .= '<tr>';
    $html .= '<th>Codigo</th>';
    $html .= '<th>Producto</th>';
    $html .= '<th>Cantidad</th>';
    $html .= '<th>Precio</th>';
    $html .= '<th>SubTotal</th>';
    // Agrega más encabezados de la tabla si es necesario
    $html .= '</tr>';

    // Agrega los detalles de la factura en filas de la tabla
    foreach ($detallesVenta as $detalle) {
        $html .= '<tr>';
        $html .= '<td class="producto">' . $detalle->getCodigoProducto() . '</td>';
        $html .= '<td class="producto">' . $detalle->getNombreProducto() . '</td>';
        $html .= '<td class="producto">' . $detalle->getCantidad() . '</td>';
        $html .= '<td class="producto">' . $detalle->getPrecioVenta() . '</td>';
        $html .= '<td class="producto">' . $detalle->getPrecioVenta()*$detalle->getCantidad() . '</td>';
        // Agrega más columnas con detalles si es necesario
        $html .= '</tr>';
    }
    $html .= '</table>';
    $html .= '<h4>TOTAL:'.$ventaOBJ['total'].'</h4>';
    $html .= '</div>'; // Cerramos la capa "ticket"
    $html .= '</body>';
    $html .= '</html';

    // ... Resto del código ...



    // Carga el contenido HTML en Dompdf
    $dompdf->loadHtml($html);

    // Genera el PDF
    $dompdf->render();

    // Envía el PDF generado al navegador
    $dompdf->stream('factura.pdf', ['Attachment' => false]);
} else {
    echo 'ID de venta no especificado.';
}
