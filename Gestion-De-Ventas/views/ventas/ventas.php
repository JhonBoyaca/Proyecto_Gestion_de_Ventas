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

<body>
    <h3>SISTEMA DE VENTAS</h3>
    <input type="text" list="productos" id="miInput">
    <datalist id="productos">
        <?php echo $productosOptions; ?>
    </datalist>

    <input id="cantidadProducto" type="text">

    <button id="btnAgregarProducto">Agregar Producto</button>

    <table id="tablaProductos">
        <thead>
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Precio</th>
                <!-- Agrega más encabezados de columna si es necesario -->
            </tr>
        </thead>
        <tbody>
            <!-- Aquí se cargarán los productos -->
        </tbody>
    </table>

    <!-- Resto de tu código aquí -->

</body>

<script>
    document.getElementById('btnAgregarProducto').addEventListener('click', function() {
        var codigoProducto = document.getElementById('miInput').value;
        var productoEncontrado = encontrarProductoPorCodigo(codigoProducto);

    });

    // Función para agregar una fila HTML a la tabla
    function agregarProductoATabla(producto) {
        // Obtén los datos del producto desde la respuesta JSON
        var codigo = producto.codigo;
        var nombre = producto.nombre;
        var precio = producto.precio;

        // Obtén la referencia a la tabla
        var tabla = $("#tablaProductos");

        // Crea una nueva fila
        var nuevaFila = $("<tr></tr>");

        // Crea las celdas para cada columna
        var celdaCodigo = $("<td>" + codigo + "</td>");
        var celdaNombre = $("<td>" + nombre + "</td>");
        var celdaPrecio = $("<td>" + precio + "</td>");

        // Agrega las celdas a la fila
        nuevaFila.append(celdaCodigo);
        nuevaFila.append(celdaNombre);
        nuevaFila.append(celdaPrecio);

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

                    agregarProductoATabla(producto);
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