<?php

use Dompdf\Dompdf;

require_once 'vendor/autoload.php';
require_once '../../model/DAOProductos.php';
$dao = new DAOProductos();
$tabla_productos = $dao->rptStockMin();
$pdf = new Dompdf();

date_default_timezone_set('America/El_Salvador');
$imagen = file_get_contents('../assets/img/Zephyrus.jpg');
$imagen_data = base64_encode($imagen);
$imagenPath = '<img src="data:image/png;base64, ' . $imagen_data . '"class="logo">';

$html = "
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>PROD. CON STOCK AL MINIMO</title>
    <style>
    .logo{
        width: 150px;
        height: 120px;
         }
    .table, tr{
    border-top: 1px solid;
    border-bottom: 1px solid;
    border-collapse: collapse;
    }
    .table > thead > th{
    text-align: center;
    }
    .fecha{font-size: 15px;}
    .table{font-size: 16px;width:100%;}
    .scope{padding-right: 90.5%;margin-left:1px;border-bottom: 1px solid black;padding-bottom: 5px;}
    @page { margin: 40px 70px; }
    #footer { position: fixed; left: 2px; bottom: -110px; right: Opx; height: 140px; }
    #footer .page:after { content: counter(page, upper-number) ; }
    </style>
    <div id='footer'>
        
    <p class='page'>
    <span class='fecha' >Fecha Impresion: " . date('d-m-y h:i:s A') . "</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <a href='#' style='text-decoration:none;'>Pag. </a> 
    </p>
    </div>
</head>
<body>
    <main class='content'>
    <!-- ENCABEZADOS EN FORMATO DE TABLA -->
    <table>
        <tr style='text-align:center; font-weight: bold;'>
        <td>PROYECTO FINAL</td>
        <td>Gestion De Ventas</td>
        <td>ITCA-FEPADE</td>
    </tr>
    <tr>
        <td style='width:25%;'>" . $imagenPath . "</td>
        <td style='width:750%; ' colspan='2'>
            <h3>REPORTE DE PRODUCTOS CON STOCK AL MINIMO DE 50</h3>
        </td>
    </tr>
    </table>
    <hr>
    <div>
        <br>
        <p>Este el Reporte PDF donde se entrega la informacion de los productos con stock al minimo 50 und</p>
        <hr>
        <!--EEn este div pondremos las tablas de datos-->
        <div style='height:auto;'>
            " . $tabla_productos[0] . "
        </div>
        <h4 style='text-align: right;'><b>Total Productos con Stock al Minimo " . $tabla_productos[1] . "</b></h4>
    </div>
    </main>
</body>
</html>

";

$pdf->loadHtml($html);
$pdf->setPaper('letter', 'portrait');
$pdf->render();
$pdf->stream("RPT_Productos_Stock_Al_Minimo", ['Attachment' => false]);
