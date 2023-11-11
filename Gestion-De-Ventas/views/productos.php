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
                    }
                });

            }).fail(function() {
                console.log("Error al recuperar datos (funcion get())")
            });

        }

        function getComboProveedores() {
            $.ajax({
                url: "../controller/ProductosController.php",
                type: "post",
                data: {
                    key: "getComboProveedores"
                }
            }).done(function(resp) {
                $("#cmbIdProveedor").empty();
                $("#cmbIdProveedor").append(resp);

            }).fail(function() {
                console.log("Error al recuperar datos (funcion getcmbIdProveedor())")
            });
        }

        function getComboCategorias() {
            $.ajax({
                url: "../controller/ProductosController.php",
                type: "post",
                data: {
                    key: "getComboCategorias"
                }
            }).done(function(resp) {
                $("#cmbIdCategoria").empty();
                $("#cmbIdCategoria").append(resp);

            }).fail(function() {
                console.log("Error al recuperar datos (funcion getComboCategorias())")
            });
        }

        function limpiarform() {
            $("#formNuevoProducto")[0].reset();
        }
        $(document).ready(function() {

            getTabla();
            getComboProveedores();
            getComboCategorias();

            $("#btnNuevo").click(function() {
                $("#btnModificar").hide();
                $("#btnGuardar").show();
                limpiarform();
            });
            $("#btnGuardar").click(function() {
                var formulario = $("#formNuevoProducto").serialize();

                $.ajax({
                    url: '../controller/ProductosController.php',
                    type: 'post',
                    data: {
                        key: 'agregar',
                        data: formulario
                    }
                }).done(function(resp) {
                    console.log(resp);
                    if (resp == true) {
                        swal("¡Bien!", "El producto fue guardado con exito!", "success");
                        $("#btnCerrarModal").click();
                        getTabla();
                        limpiarform();
                    } else {
                        swal("Advertencia", "El registro no se guardo!", "warning");
                    }
                }).fail(function(resp) {
                    console.log(resp);
                });
            });

        });
    </script>
    <title>CRUD PRODUCTOS</title>
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
                    <h3>Gestion de productos</h3>
                    <hr />
                    <input type="button" class="btn btn-success" value="Nuevo" id="btnNuevo" data-bs-toggle="modal" data-bs-target="#formIngresoProductos">
                    <hr>
                    <div id="tablaHtml">
                    </div>

                </div>



        </section>
    </main>


    <?= $scripts ?>

    <script src="./js/codigo.js"></script>
</body>

</html>

<!--Modal Ingreso Productos-->

<!-- Modal -->
<div class="modal fade" id="formIngresoProductos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Registro de productos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <form id="formNuevoProducto">
                    <input type="hidden" id="txtIdProducto" name="txtIdProducto">
                    <input type="text" placeholder="Nombre Producto" class="form-control" name="txtNombre" id="txtNombre"><br>
                    <input type="number" placeholder="Precio Compra" class="form-control" name="txtprecioCom" id="txtprecioCom"><br>
                    <input type="number" placeholder="Precio Venta" class="form-control" name="txtprecioVen" id="txtprecioVen"><br>
                    <input type="number" placeholder="Stock" class="form-control" name="txtStock" id="txtStock"><br>
                    <input type="number" placeholder="Stock Minimo" class="form-control" name="txtStockMin" id="txtStockMin"><br>
                    <label class="badge bg-success">Categoria de Producto</label>
                    <select name="cmbIdCategoria" id="cmbIdCategoria" class="form-control">

                    </select><br>
                    <label class="badge bg-success">Nombre Proveedor</label>
                    <select name="cmbIdProveedor" id="cmbIdProveedor" class="form-control">

                    </select>


                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnGuardar">Guardar</button>
                <button type="button" class="btn btn-primary" id="btnModificar">Modificar</button>
                <button type="button" class="btn btn-secondary" id="btnCerrarModal" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>