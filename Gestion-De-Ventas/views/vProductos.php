<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    <!-- Incluye las hojas de estilo de Bootstrap y DataTables -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="../views/css/style.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

    <?php include_once './sidebar.php';   ?>

    <div class="content">
        <div class="container mt-5">

            <div class="row mb-4">
                <h1 class="col-12 col-lg-4">Lista de Productos</h1>
                <!-- Botón para mostrar el modal de agregar producto -->

                <?php
                // Mostrar diferentes opciones según el rol
                if ($_SESSION['rol'] == 'Admin') {
                    echo '<button type="button" class="btn btn-primary mt-3 col-12 col-lg-3 m-2" data-bs-toggle="modal" data-bs-target="#modalAgregarProducto">
                            Agregar Producto
                            </button>
                            <button type="button" id="restablecer" class="btn btn-primary mt-3 col-12 col-lg-3 m-2">
                                Restablecer
                            </button>';
                }
                ?>

                
            </div>
            <hr>

            <div class="row mb-4 mt-2 d-flex align-items-center">
                <!-- Botón para mostrar el modal de agregar producto -->
                <button type="button" id="btn_stockminimo" class="btn btn-primary mt-3 col-12 col-lg-3 m-2">
                    Reporte Stock Al Mínimo
                </button>

                <?php
                // Mostrar diferentes opciones según el rol
                if ($_SESSION['rol'] != 'Admin') {
                    echo '
                            <button type="button" id="restablecer" class="btn btn-primary mt-3 col-12 col-lg-3 m-2">
                                Productos Existentes
                            </button>';
                }
                ?>
            </div>

            <!-- Tabla de productos -->
            <table id="tablaProductos" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th scope="col">Código</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Precio Compra</th>
                        <th scope="col">Precio Venta</th>
                        <th scope="col">Stock</th>
                        <th scope="col">Stock Minimo</th>
                        <th scope="col">CategoríaID</th>
                        <th scope="col">ProveedorID</th>
                        <th scope="col">Categoría</th>
                        <th scope="col">Proveedor</th>

                        <?php
                        // Mostrar diferentes opciones según el rol
                        if ($_SESSION['rol'] == 'Admin') {
                            echo '<th scope="col">Editar</th>
                                <th scope="col">Eliminar</th>';
                        }
                        ?>

                    </tr>
                </thead>
            </table>
        </div>

        <!-- Modal para agregar un nuevo producto -->
        <div class="modal fade" id="modalAgregarProducto" tabindex="-1" aria-labelledby="modalAgregarProductoLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAgregarProductoLabel">Agregar Producto</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Formulario para agregar un nuevo producto -->
                        <form id="formularioAgregarProducto">
                            <div class="mb-3">
                                <label for="nombreProducto" class="form-label">Nombre del Producto:</label>
                                <input type="text" class="form-control" id="nombreProducto" name="nombre" required>
                            </div>
                            <div class="mb-3">
                                <label for="precioCompra" class="form-label">Precio Compra:</label>
                                <input type="number" class="form-control" id="precioCompra" name="precioCompra" step="0.01" required>
                            </div>
                            <div class="mb-3">
                                <label for="precioVenta" class="form-label">Precio Venta:</label>
                                <input type="number" class="form-control" id="precioVenta" name="precioVenta" step="0.01" required>
                            </div>
                            <div class="mb-3">
                                <label for="stock" class="form-label">Stock:</label>
                                <input type="number" class="form-control" id="stock" name="stock" required>
                            </div>
                            <div class="mb-3">
                                <label for="stockMinimo" class="form-label">Stock Minimo:</label>
                                <input type="number" class="form-control" id="stockMinimo" name="stockMinimo" required>
                            </div>
                            <div class="mb-3">
                                <label for="proveedorProducto" class="form-label">Proveedor:</label>
                                <input list="Proveedor" name="proveedorid" class="form-control" id="proveedorid" placeholder="Seleccione un proveedor" autofocus required>
                                <datalist id="Proveedor">
                                    <option value="Selecione un proveedor" data-value="">
                                </datalist>
                            </div>
                            <div class="mb-3">
                                <label for="categoriaProducto" class="form-label">Categoría:</label>
                                <input list="Categoria" name="categoriaid" class="form-control" id="categoriaid" placeholder="Seleccione una categoria" autofocus required>
                                <datalist id="Categoria">
                                    <option value="Selecione un categoria" data-value="">
                                </datalist>
                            </div>
                            <!-- Agrega más campos según tus necesidades -->
                            <button type="submit" class="btn btn-primary">Guardar Producto</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para editar un producto -->
        <div class="modal fade" id="modalEditarProducto" tabindex="-1" aria-labelledby="modalEditarProductoLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditarProductoLabel">Editar Producto</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Formulario para editar un producto -->
                        <form id="formularioEditarProducto">
                            <!-- Campo oculto para almacenar el código del producto -->
                            <input type="hidden" id="editCodigoProducto" name="codigo">
                            <div class="mb-3">
                                <label for="editnombreProducto" class="form-label">Nombre del Producto:</label>
                                <input type="text" class="form-control" id="editnombreProducto" name="nombre" required>
                            </div>
                            <div class="mb-3">
                                <label for="editprecioCompra" class="form-label">Precio Compra:</label>
                                <input type="number" class="form-control" id="editprecioCompra" name="precioCompra" step="0.01" required>
                            </div>
                            <div class="mb-3">
                                <label for="editprecioVenta" class="form-label">Precio Venta:</label>
                                <input type="number" class="form-control" id="editprecioVenta" name="precioVenta" step="0.01" required>
                            </div>
                            <div class="mb-3">
                                <label for="editstock" class="form-label">Stock:</label>
                                <input type="number" class="form-control" id="editstock" name="stock" required>
                            </div>
                            <div class="mb-3">
                                <label for="editstockMinimo" class="form-label">Stock Minimo:</label>
                                <input type="number" class="form-control" id="editstockMinimo" name="stockMinimo" required>
                            </div>
                            <div class="mb-3">
                                <label for="editProveedorProducto" class="form-label">Proveedor:</label>
                                <input list="editProveedor" name="editproveedorid" class="form-control" id="editproveedorid" placeholder="Seleccione un proveedor" autofocus required>
                                <datalist id="editProveedor">
                                    <option value="Selecione un proveedor" data-value="">
                                </datalist>
                            </div>
                            <div class="mb-3">
                                <label for="editCategoriaProducto" class="form-label">Categoría:</label>
                                <input list="editCategoria" name="editcategoriaid" class="form-control" id="editcategoriaid" placeholder="Seleccione una categoria" autofocus required>
                                <datalist id="editCategoria">
                                    <option value="Selecione un categoria" data-value="">
                                </datalist>
                            </div>
                            <!-- Agrega más campos según tus necesidades -->
                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Incluye las bibliotecas de jQuery, DataTables y Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.colVis.min.js"></script>
    <!-- Agrega aquí las funciones JavaScript necesarias, similares a las de vProveedores.php y vCategorias.php -->
    <script>
        $(document).ready(function() {
            let tablaProductos = $('#tablaProductos').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                },
                "columns": [{
                        "data": "codigo"
                    },
                    {
                        "data": "nombre"
                    },
                    {
                        "data": "preciocompra"
                    },
                    {
                        "data": "precioventa"
                    },
                    {
                        "data": "stock"
                    },
                    {
                        "data": "stockminimo"
                    },
                    {
                        "data": "categoriaid"
                    },
                    {
                        "data": "proveedorid"
                    },
                    {
                        "data": "NombreCategoria"
                    },
                    {
                        "data": "NombreProveedor"
                    },
                    <?php

                    if ($_SESSION['rol'] == 'Admin') {

                        echo '{
                                "targets": -2,
                                "data": null,
                                "defaultContent": `<button type="button" id="btn-editar" class="btn btn-warning btn-editar">Editar</button>`
                            },
                            {
                                "targets": -1,
                                "data": null,
                                "defaultContent": `<button type="button" id="btn-eliminar" class="btn btn-danger btn-eliminar">Eliminar</button>`
                            }';
                    }


                    ?>

                ],
                "dom": 'Bfrtip',
                "columnDefs": [{
                    "targets": [0, 6, 7], // Índice de la columna que se desea ocultar (empezando desde 0)
                    "visible": false,
                    "searchable": false
                }],
                "buttons": [{
                        extend: 'copy',
                        title: 'Productos Ingresados',
                        text: '<i class="fas fa-copy"></i> Copiar',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6]
                        }
                    },
                    {
                        extend: 'excel',
                        title: 'Productos Ingresados',
                        text: '<i class="fas fa-file-excel"></i> Excel',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6]
                        }
                    },
                    {
                        extend: 'csv',
                        title: 'Productos Ingresados',
                        text: '<i class="fas fa-file-csv"></i> CSV',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6]
                        }
                    },
                    {
                        extend: 'pdf',
                        title: 'Productos Ingresados',
                        text: '<i class="fas fa-file-pdf"></i> PDF',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6]
                        }
                    },
                    {
                        extend: 'print',
                        title: 'Productos Ingresados',
                        text: '<i class="fas fa-print"></i> Imprimir',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6]
                        }
                    },
                    // {
                    //     extend: 'colvis',
                    //     text: '<i class="fas fa-eye"></i> Mostrar/Ocultar Columnas',
                    // },
                    {
                        extend: 'pageLength',
                        text: '<i class="fas fa-eye"></i> Cantidad de Filas'
                    }
                ]
            });


            function actualizarTabla() {
                $.ajax({
                    url: '../controller/ProductosController.php',
                    type: 'post',
                    data: {
                        key: "obtenerTodos",
                    },
                    success: function(result) {
                        result = JSON.parse(result);
                        console.log(result);
                        tablaProductos.clear().rows.add(result).draw();
                    }
                });
            }
            actualizarTabla();

            $("#restablecer").on("click", function(event) {
                event.preventDefault();
                if ($.fn.DataTable.isDataTable('#tablaProductos')) {
                    $('#tablaProductos').DataTable().destroy();
                }

                tablaProductos = $('#tablaProductos').DataTable({
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                    },
                    "columns": [{
                            "data": "codigo"
                        },
                        {
                            "data": "nombre"
                        },
                        {
                            "data": "preciocompra"
                        },
                        {
                            "data": "precioventa"
                        },
                        {
                            "data": "stock"
                        },
                        {
                            "data": "stockminimo"
                        },
                        {
                            "data": "categoriaid"
                        },
                        {
                            "data": "proveedorid"
                        },
                        {
                            "data": "NombreCategoria"
                        },
                        {
                            "data": "NombreProveedor"
                        },
                        <?php

                        if ($_SESSION['rol'] == 'Admin') {

                            echo '{
                                "targets": -2,
                                "data": null,
                                "defaultContent": `<button type="button" id="btn-editar" class="btn btn-warning btn-editar">Editar</button>`
                            },
                            {
                                "targets": -1,
                                "data": null,
                                "defaultContent": `<button type="button" id="btn-eliminar" class="btn btn-danger btn-eliminar">Eliminar</button>`
                            }';
                        }


                        ?>
                    ],
                    "dom": 'Bfrtip',
                    "columnDefs": [{
                        "targets": [0, 6, 7], // Índice de la columna que se desea ocultar (empezando desde 0)
                        "visible": false,
                        "searchable": false
                    }],
                    "buttons": [{
                            extend: 'copy',
                            title: 'Productos Ingresados',
                            text: '<i class="fas fa-copy"></i> Copiar',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5, 6]
                            }
                        },
                        {
                            extend: 'excel',
                            title: 'Productos Ingresados',
                            text: '<i class="fas fa-file-excel"></i> Excel',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5, 6]
                            }
                        },
                        {
                            extend: 'csv',
                            title: 'Productos Ingresados',
                            text: '<i class="fas fa-file-csv"></i> CSV',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5, 6]
                            }
                        },
                        {
                            extend: 'pdf',
                            title: 'Productos Ingresados',
                            text: '<i class="fas fa-file-pdf"></i> PDF',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5, 6]
                            }
                        },
                        {
                            extend: 'print',
                            title: 'Productos Ingresados',
                            text: '<i class="fas fa-print"></i> Imprimir',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5, 6]
                            }
                        },
                        // {
                        //     extend: 'colvis',
                        //     text: '<i class="fas fa-eye"></i> Mostrar/Ocultar Columnas',
                        // },
                        {
                            extend: 'pageLength',
                            text: '<i class="fas fa-eye"></i> Cantidad de Filas'
                        }
                    ]
                });

                actualizarTabla();
            });


            $('#btn_stockminimo').on('click', function(event) {
                event.preventDefault();
                if ($.fn.DataTable.isDataTable('#tablaProductos')) {
                    $('#tablaProductos').DataTable().destroy();
                }

                tablaProductos = $('#tablaProductos').DataTable({
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                    },
                    "columns": [{
                            "data": "codigo"
                        },
                        {
                            "data": "nombre"
                        },
                        {
                            "data": "preciocompra"
                        },
                        {
                            "data": "precioventa"
                        },
                        {
                            "data": "stock"
                        },
                        {
                            "data": "stockminimo"
                        },
                        {
                            "data": "categoriaid"
                        },
                        {
                            "data": "proveedorid"
                        },
                        {
                            "data": "NombreCategoria"
                        },
                        {
                            "data": "NombreProveedor"
                        },
                        <?php

                        if ($_SESSION['rol'] == 'Admin') {

                            echo '{
                                "targets": -2,
                                "data": null,
                                "defaultContent": `<button type="button" id="btn-editar" class="btn btn-warning btn-editar">Editar</button>`
                            },
                            {
                                "targets": -1,
                                "data": null,
                                "defaultContent": `<button type="button" id="btn-eliminar" class="btn btn-danger btn-eliminar">Eliminar</button>`
                            }';
                        }


                        ?>
                    ],
                    "dom": 'Bfrtip',
                    "columnDefs": [{
                        "targets": [0, 6, 7], // Índice de la columna que se desea ocultar (empezando desde 0)
                        "visible": false,
                        "searchable": false
                    }],
                    "buttons": [{
                            extend: 'copy',
                            title: 'Stock Mínimo',
                            text: '<i class="fas fa-copy"></i> Copiar',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5, 6]
                            }
                        },
                        {
                            extend: 'excel',
                            title: 'Stock Mínimo',
                            text: '<i class="fas fa-file-excel"></i> Excel',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5, 6]
                            }
                        },
                        {
                            extend: 'csv',
                            title: 'Stock Mínimo',
                            text: '<i class="fas fa-file-csv"></i> CSV',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5, 6]
                            }
                        },
                        {
                            extend: 'pdf',
                            title: 'Stock Mínimo',
                            text: '<i class="fas fa-file-pdf"></i> PDF',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5, 6]
                            }
                        },
                        {
                            extend: 'print',
                            title: 'Stock Mínimo',
                            text: '<i class="fas fa-print"></i> Imprimir',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5, 6]
                            }
                        },
                        // {
                        //     extend: 'colvis',
                        //     text: '<i class="fas fa-eye"></i> Mostrar/Ocultar Columnas',
                        // },
                        {
                            extend: 'pageLength',
                            text: '<i class="fas fa-eye"></i> Cantidad de Filas'
                        }
                    ]
                });


                $.ajax({
                    url: '../controller/ProductosController.php',
                    type: 'post',
                    data: {
                        key: "stockminimo",
                    },
                    success: function(result) {
                        result = JSON.parse(result);
                        console.log(result);
                        tablaProductos.clear().rows.add(result).draw();
                    }
                });
            })




            // Procesa el formulario con Ajax cuando se envía
            $("#formularioAgregarProducto").on("submit", function(event) {
                event.preventDefault();
                var formData = $(this).serialize();
                console.log(formData);

                const proveedores = jQuery('#proveedorid').val()
                var selectedproveedor = $('#Proveedor option[value="' + proveedores + '"]');
                var proveedorValue = selectedproveedor.attr('data-value');

                const categorias = jQuery('#categoriaid').val()
                var selectedCategoria = $('#Categoria option[value="' + categorias + '"]');
                var categoriaValue = selectedCategoria.attr('data-value');

                const nombreProducto = jQuery('#nombreProducto').val();
                const precioCompra = jQuery('#precioCompra').val();
                const precioVenta = jQuery('#precioVenta').val();
                const stock = jQuery('#stock').val();
                const stockMinimo = jQuery('#stockMinimo').val();

                console.log(`nombre=${nombreProducto}&precioCompra=${precioCompra}&precioVenta=${precioVenta}&stock=${stock}&stockMin=${stockMinimo}&categoriaID=${categoriaValue}&proveedorID=${proveedorValue}&key=crear`)
                $.ajax({
                    url: "../controller/ProductosController.php",
                    type: "POST",
                    data: `nombre=${nombreProducto}&precioCompra=${precioCompra}&precioVenta=${precioVenta}&stock=${stock}&stockMin=${stockMinimo}&categoriaID=${categoriaValue}&proveedorID=${proveedorValue}&key=crear`,
                    success: function(response) {
                        actualizarTabla();
                        console.log(response);
                        // Cierra el modal después de agregar un libro
                        $("#modalAgregarProducto").modal("hide");
                    }
                });
            });



            $('#tablaProductos').on('click', '#btn-editar', function() {
                let data = tablaProductos.row($(this).parents('tr')).data()
                console.log(data)
                // Mostrar el modal de edición y cargar los datos del libro
                mostrarModalEdicion(data);

            });

            $('#tablaProductos').on('click', '#btn-eliminar', function() {
                let data = tablaProductos.row($(this).parents('tr')).data();
                console.log(data)
                // Muestra un mensaje de confirmación usando SweetAlert2
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: 'Esta acción eliminará el producto seleccionado. ¿Deseas continuar?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'No, cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // El usuario ha confirmado, enviar la solicitud Ajax para eliminar el libro
                        eliminarProducto(data);
                    }
                });
            });



            $("#formularioEditarProducto").on("submit", function(event) {
                event.preventDefault();

                const codigo = jQuery('#editCodigoProducto').val()

                const proveedores = jQuery('#editproveedorid').val()
                var selectedproveedor = $('#editProveedor option[value="' + proveedores + '"]');
                var proveedorValue = selectedproveedor.attr('data-value');

                const categorias = jQuery('#editcategoriaid').val()
                var selectedCategoria = $('#editCategoria option[value="' + categorias + '"]');
                var categoriaValue = selectedCategoria.attr('data-value');

                const nombreProducto = jQuery('#editnombreProducto').val();
                const precioCompra = jQuery('#editprecioCompra').val();
                const precioVenta = jQuery('#editprecioVenta').val();
                const stock = jQuery('#editstock').val();
                const stockMinimo = jQuery('#editstockMinimo').val();

                console.log(`&codigo=${codigo}&nombre=${nombreProducto}&precioCompra=${precioCompra}&precioVenta=${precioVenta}&stock=${stock}&stockMin=${stockMinimo}&categoriaID=${categoriaValue}&proveedorID=${proveedorValue}&key=crear`)

                $.ajax({
                    url: "../controller/ProductosController.php",
                    type: "POST",
                    data: `&codigo=${codigo}&nombre=${nombreProducto}&precioCompra=${precioCompra}&precioVenta=${precioVenta}&stock=${stock}&stockMin=${stockMinimo}&categoriaID=${categoriaValue}&proveedorID=${proveedorValue}&key=actualizar`,
                    success: function(response) {
                        actualizarTabla();
                        console.log(response);
                        // Cierra el modal después de agregar un libro
                        $('#modalEditarProducto').modal('hide');
                    }
                });

            });




            $.ajax({
                url: '../controller/CategoriasController.php',
                type: 'post',
                data: {
                    key: "obtenerTodas",
                },
                success: function(result) {
                    const categorias = JSON.parse(result)
                    updateDatalistCategorias(categorias);
                }
            });

            $.ajax({
                url: '../controller/ProveedoresController.php',
                type: 'post',
                data: {
                    key: "obtenerTodos",
                },
                success: function(result) {
                    const proveedores = JSON.parse(result)
                    updateDatalistProveedores(proveedores);
                }
            });



            function mostrarModalEdicion(data) {
                // Obtener los datos del libro
                var codigo = data.codigo;
                var cliente = data.nombre;
                var precioCompra = data.precioCompra;
                var precioVenta = data.precioVenta;
                var stock = data.stock;
                var stockMinimo = data.stockMinimo;
                var categoriaid = data.categoriaid;
                var proveedorid = data.proveedorid;
                var nombrecategoria = data.nombrecategoria;
                var nombreproveedor = data.nombreproveedor;

                const proveedores = jQuery('#editproveedorid').val()
                var selectedproveedor = $('#editProveedor option[value="' + proveedores + '"]');
                var proveedorValue = selectedproveedor.attr('data-value');

                const categorias = jQuery('#editcategoriaid').val()
                var selectedCategoria = $('#editCategoria option[value="' + categorias + '"]');
                var categoriaValue = selectedCategoria.attr('data-value');

                jQuery('#editnombreProducto').val(data.nombre);
                jQuery('#editprecioCompra').val(data.preciocompra);
                jQuery('#editprecioVenta').val(data.precioventa);
                jQuery('#editstock').val(data.stock);
                jQuery('#editstockMinimo').val(data.stockminimo);
                jQuery('#editcategoriaid').val(data.NombreCategoria)
                jQuery('#editproveedorid').val(data.NombreProveedor)



                $('#editCodigoProducto').val(codigo);
                $('#modalEditarProductoLabel').text(`Editar Producto #${data.codigo} - ${data.nombre}`)
                // Mostrar el modal de edición
                $('#modalEditarProducto').modal('show');

            }

            function eliminarProducto(data) {
                console.log(data.codigo)
                $.ajax({
                    url: '../controller/ProductosController.php',
                    type: 'post',
                    data: `productoID=${data.codigo}&key=eliminar`,
                    success: function(response) {
                        // Actualizar la tabla de libros o mostrar un mensaje de éxito/error
                        actualizarTabla();
                        console.log(response);
                    }
                });
            }

            function updateDatalistCategorias(categoria) {
                let datalist = $('#Categoria')
                datalist.empty()
                datalist.append('<option value="">Seleccione una categoria</option>')
                let datalist2 = $('#editCategoria')
                datalist2.empty()
                datalist2.append('<option value="">Seleccione una categoria</option>')

                $.each(categoria, function(index, categoria) {
                    console.log(categoria.NombreCategoria)
                    datalist.append('<option value="' + categoria.NombreCategoria + '" data-value="' + categoria.Codigo + '">' + categoria.Descripcion + '</option>')
                    datalist2.append('<option value="' + categoria.NombreCategoria + '" data-value="' + categoria.Codigo + '">' + categoria.Descripcion + '</option>')

                })
            }

            function updateDatalistProveedores(proveedores) {
                let datalist = $('#Proveedor')
                datalist.empty()
                datalist.append('<option value="">Seleccione un proveedor</option>')
                let datalist2 = $('#editProveedor')
                datalist2.empty()
                datalist2.append('<option value="">Seleccione un proveedor</option>')

                $.each(proveedores, function(index, prove) {
                    datalist.append('<option value="' + prove.Nombre + '" data-value="' + prove.Codigo + '">' + prove.Contacto + '</option>')
                    datalist2.append('<option value="' + prove.Nombre + '" data-value="' + prove.Codigo + '">' + prove.Contacto + '</option>')
                })
            }




        });
    </script>

</body>

</html>