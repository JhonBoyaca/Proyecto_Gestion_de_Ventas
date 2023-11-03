<?php
require_once "../../model/DAOProductos.php"; // Ajusta la ruta según la ubicación real de tu clase
require_once "../../model/Productos.php"; // Ajusta la ruta según la ubicación real de tu clase

// Aquí puedes utilizar la clase DAOProductos
$daoProductos = new DAOProductos();

$productos = $daoProductos->seleccionarProductos(); // Llama a la función para obtener productos

// Convierte los resultados a un formato JSON
$productosJSON = json_encode($productos);
// Genera las opciones del dataList
$productosOptions = '';
foreach ($productos as $producto) {
    $productosOptions .= "<option value='{$producto->getCodigo()}'>'{$producto->getNombre()}'</option>";
}

?>


<h3>SISTEMA DE VENTAS</h3>

<div class="row">
    <div class="col-4">
        <input type="text" list="productos" placeholder="productos" class="form-control" id="miInput">
        <datalist id="productos">
            <?php echo $productosOptions; ?>
        </datalist>
    </div>
    <div class="col-4">
        <input id="cantidadProducto" type="text" value="" placeholder="cantidad" class="form-control">
    </div>

    <div class="col-2">
        <button id="btnAgregarProducto" class="btn btn-success">Agregar Producto</button>
    </div>
</div>
<hr>
<div class="row">
    <table id="tablaProductos" class="table" style="width: 100%;">
        <thead>
            <tr class="table-dark">
                <th>Código</th>
                <th>Nombre</th>
                <th>Precio</th>
                <input>
                <th>Cantidad Venta</th>
            </tr>
        </thead>
        <tbody>
            <!-- Aquí se cargarán los productos -->
        </tbody>
    </table>
</div>




<!-- Resto de tu código aquí -->


<script>
    document.getElementById('btnAgregarProducto').addEventListener('click', function() {
        var codigoProducto = document.getElementById('miInput').value;
        var cantidadProducto = document.getElementById('cantidadProducto').value;


        validarYAgregarProducto(codigoProducto, cantidadProducto)
    });

    function validarYAgregarProducto(codigo, cantidad) {
        // Verificar si los valores son nulos o vacíos
        if (!codigo || !cantidad || codigo.trim() == '' || cantidad.trim() == '') {
            // Mostrar una alerta dulce
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Por favor, ingrese un código de producto y una cantidad válida.',
            });
        } else {

            encontrarProductoPorCodigo(codigo, cantidad);
        }
    }
    // Función para agregar una fila HTML a la tabla
    function agregarProductoATabla(producto, cantidad) {
        // Obtén los datos del producto desde la respuesta JSON
        var codigo = producto.codigo;
        var nombre = producto.nombre;
        var precio = producto.precio;
        var productoId = producto.id;
        // Obtén la referencia a la tabla
        var tabla = $("#tablaProductos");

        // Crea una nueva fila
        var nuevaFila = $("<tr></tr>");

        // Crea las celdas para cada columna
        var celdaCodigo = $("<td>" + codigo + "</td>");
        var celdaNombre = $("<td>" + nombre + "</td>");
        var celdaPrecio = $("<td>" + precio + "</td>");
        // Crea una celda para la cantidad con un input
        var celdaCantidad = $("<td><input type='number' id='" + productoId + "' class='cantidad-input' value='" + cantidad + "'></td>");

        // Agrega las celdas a la fila
        nuevaFila.append(celdaCodigo);
        nuevaFila.append(celdaNombre);
        nuevaFila.append(celdaPrecio);
        nuevaFila.append(celdaCantidad);

        celdaCantidad.find('input').on('change', function() {
            // Aquí puedes manejar el cambio de cantidad
            var nuevaCantidad = $(this).val();
            var inputId = $(this).attr('id');
         
        });
        // Agrega la fila a la tabla
        tabla.find('tbody').append(nuevaFila);
    }




    function encontrarProductoPorCodigo(codigo, cantidad) {
        $.ajax({
            type: "POST",
            url: "../controller/ProductosController.php", // Ajusta la ruta a tu controlador
            data: {
                key: "getObjProducto",
                codigo: codigo
            },
            dataType: "json",
            success: function(producto) {
                if (producto) {
                    var producto = JSON.parse(producto);

                    agregarProductoATabla(producto, cantidad);
                } else {
                    // Manejar el caso en el que no se encontró el producto
                    console.log('Producto no encontrado.');
                }
            },
            error: function(error) {
                // Manejar errores en la solicitud
                console.error('Error:', error);
            }
        });
    }
</script>