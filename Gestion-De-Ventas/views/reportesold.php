<?php
$cdns = file_get_contents("plugins/encabezados.php");
$scripts = file_get_contents("plugins/scripts.php");
$menu = file_get_contents("plugins/menu.php");

session_start();

if (!isset($_SESSION["correo"])) {
    header("Location:index.php");
}


?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <?= $cdns ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.7.1/jspdf.plugin.autotable.js"></script>
    <script>
        function getTabla() {

            $.ajax({
                url: "../controller/ProductosController.php",
                type: "post",
                data: {
                    key: "get1"
                }
            }).done(function(resp) {
                $("#tablaHtml").empty();
                $("#tablaHtml").append(resp);
                $("#tabla").DataTable({
                    searching: true,
                    language: {
                        "info": "Mostrando _START_ a _END_ de _TOTAL_ Registros",
                        "lengthMenu": "Mostrar _MENU_ Registros",
                        "Search": "Buscar",
                        "paginate": {
                            "first": "Primero",
                            "last": "Ultima",
                            "next": "Siguiente",
                            "previous": "Anterior"
                        }
                    },
                    buttons: [{
                            extend: 'copy',
                            text: 'Copiar',
                            className: 'btn btn-primary'
                        },
                        {
                            extend: 'excel',
                            text: 'Exportar a Excel',
                            className: 'btn btn-success'
                        },
                        {
                            extend: 'pdf',
                            text: 'Exportar a PDF',
                            className: 'btn btn-danger'
                        },
                        {
                            extend: 'print',
                            text: 'Imprimir',
                            className: 'btn btn-info'
                        },
                    ],
                });

            }).fail(function() {
                console.log("Error al recuperar datos (funcion get())")
            });

        }

        $(document).ready(function() {

            getTabla();

        });
    </script>
    <title>Reportes</title>
</head>

<body>

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
                    <h3>Gestion de reportes</h3>
                    <hr>
                    <button id="export-pdf" class="btn btn-danger" onclick="exportToPDF()">Exportar a PDF</button>
                    <button class="btn btn-warning" onclick="exportToExcel()">Exportar a Excel</button>
                    <hr>
                    <div id="tablaHtml">
                    </div>

                </div>



        </section>
    </main>


    <?= $scripts ?>

    <script src="./js/codigo.js"></script>
    <script>
        // Función para exportar a Excel
        // Función para exportar a Excel
        function exportToExcel() {
            var dataTable = $('#tabla').DataTable();

            // Utiliza la función buttons.exportData() para exportar los datos
            var data = dataTable.buttons.exportData({
                modifier: {
                    search: 'applied'
                }
            });

            var header = data.header;
            var body = data.body;

            // Crear una tabla HTML para exportar a Excel
            var table = $('<table></table>');
            var headerRow = $('<thead></thead>').appendTo(table);

            // Agrega la fila de encabezado
            var headerCells = headerRow.append('<tr></tr>');
            for (var i = 0; i < header.length; i++) {
                headerCells.append('<th>' + header[i] + '</th>');
            }

            var bodyRows = $('<tbody></tbody>').appendTo(table);

            // Agrega las filas de datos
            for (var i = 0; i < body.length; i++) {
                var rowData = body[i];
                var bodyRow = $('<tr></tr>').appendTo(bodyRows);

                for (var j = 0; j < rowData.length; j++) {
                    bodyRow.append('<td>' + rowData[j] + '</td>');
                }
            }

            // Crea un archivo Excel
            var excelData = 'data:application/vnd.ms-excel;base64,' + btoa(table[0].outerHTML);
            var link = document.createElement("a");
            link.href = excelData;
            link.download = "reporte_excel.xls";
            link.click();
        }

        function exportToPDF() {
            var dataTable = $('#tabla').DataTable();

            // Obtén los datos de la tabla
            var data = dataTable.buttons.exportData({
                modifier: {
                    search: 'applied'
                }
            });

            // Obtén los encabezados de la tabla
            var header = data.header;

            // Genera la tabla PDF
            var doc = new jsPDF();
            doc.autoTable({
                head: header,
                body: data.data,
            });
            doc.save("reporte_pdf.pdf");
        }
    </script>
</body>

</html>