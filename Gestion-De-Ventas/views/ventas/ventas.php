<?php
require_once "../../model/DAOProductos.php"; // Ajusta la ruta según la ubicación real de tu clase
require_once "../../model/Productos.php"; // Ajusta la ruta según la ubicación real de tu clase

// Aquí puedes utilizar la clase DAOProductos
$daoProductos = new DAOProductos();

$productos = $daoProductos->seleccionarProductos();
// Convierte los resultados a un formato JSON
$productosJSON = json_encode($productos);
// Genera las opciones del dataList
$productosOptions = '';
foreach ($productos as $producto) {
    $productosOptions .= "<option value='{$producto->getCodigo()}' data-stock='{$producto->getStock()}'>{$producto->getNombre()}</option>";
}

?>


<h3>SISTEMA DE VENTAS</h3>

<div class="row">
    <div class="col-4">
        <label for="miInput">Digite el nombre o el codigo del producto</label>
        <input type="text" list="productos" placeholder="productos" class="form-control" id="miInput">
        <datalist id="productos">
            <?php echo $productosOptions; ?>
        </datalist>
        <span style="color: red;" id="stockDisplay"></span>
    </div>
    <div class="col-4">
        <label for="miIcantidadProductonput">Digite la cantidad vendida</label>
        <input id="cantidadProducto" type="text" value="" placeholder="cantidad" class="form-control">
        <span style="color: red;" id="cantidadError"></span>
    </div>

    <div class="col-2">
        <br>
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
                <th>Cantidad Venta</th>
                <th>Sub Total</th>
            </tr>
        </thead>
        <tbody>
            <!-- Aquí se cargarán los productos -->
        </tbody>
    </table>
    <h4 style="color: red;" id="totalVenta"></h4>
</div>
<div class="row">
    <div class="col-4">
        <button id="btnRegistrarVenta" class="btn btn-primary" onclick="registrarVenta()">Registrar Venta</button>
    </div>

</div>



<!-- Resto de tu código aquí -->


<script>
  

    function registrarVenta() {
        console.log(productosAgregados)
        console.log(totalVenta)
        console.log(usuarioID)
        $.ajax({
            type: "POST",
            url: "../controller/VentaController.php", // Ajusta la ruta a tu controlador
            data: {
                key: "registrarVenta",
                arrayProducto: productosAgregados,
                totalVenta: totalVenta,
                usuarioID: usuarioID
            },
            success: function(res) {
                console.LOG(res)
                console.log('exito: ' + res)
            },
            error: function(error) {
                // Manejar errores en la solicitud
                console.error('Error:', error);
            }
        });

    }

    document.getElementById('cantidadProducto').addEventListener('input', function() {
        var cantidad = parseInt(this.value);
        var selectedOption = document.querySelector('datalist option[value="' + document.getElementById('miInput').value + '');
        if (selectedOption) {
            var stock = parseInt(selectedOption.getAttribute('data-stock')); // Convierte el stock a un número entero

            if (cantidad > stock) {
                document.getElementById('cantidadError').textContent = 'La cantidad no puede ser mayor que el stock (' + stock + ')';
                document.getElementById('btnAgregarProducto').disabled = true;
            } else {
                document.getElementById('cantidadError').textContent = '';
                document.getElementById('btnAgregarProducto').disabled = false;
            }
        }
    });
    document.getElementById('miInput').addEventListener('input', function() {
        // Obtiene el valor seleccionado del datalist
        var selectedOption = document.querySelector('datalist option[value="' + this.value + '"]');
        if (selectedOption) {
            // Obtiene la cantidad en stock del atributo de datos "data-stock"
            var stock = selectedOption.getAttribute('data-stock');
            document.getElementById('stockDisplay').textContent = 'Cantidad en stock: ' + stock;
        } else {
            document.getElementById('stockDisplay').textContent = 'Cantidad en stock: N/A';
        }
    });

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
    // Array para almacenar los productos agregados a la tabla
    var productosAgregados = [];

    function productoYaAgregado(id) {
        return productosAgregados.some(function(producto) {
            return producto.id === id;
        });
    }
    // Función para agregar una fila HTML a la tabla
    var totalVenta = 0;


    function calcularTotalVenta() {
        var totalVenta = 0;
        productosAgregados.forEach(function(producto) {
            var subtotal = producto.precio * producto.cantidad;
            totalVenta += subtotal;
        });
        return totalVenta;
    }

    function agregarProductoATabla(producto, cantidad) {
        // Obtén los datos del producto desde la respuesta JSON
        var codigo = producto.codigo;
        var nombre = producto.nombre;
        var precio = producto.precio;
        var productoId = producto.id;


        if (productoYaAgregado(productoId)) {
            // Si el producto ya está en el array, muestra una alerta de SweetAlert
            swal({
                title: "Producto duplicado",
                text: "El producto con ID " + productoId + " ya ha sido agregado.",
                icon: "warning", // Puedes cambiar el icono según tus preferencias
            });
            return false;
        }

        // Crea un objeto con los datos del producto
        var productoAgregado = {
            id: productoId,
            codigo: codigo,
            nombre: nombre,
            precio: precio,
            cantidad: cantidad
        };

        //Agrega el producto al array
        productosAgregados.push(productoAgregado);

        var total = productoAgregado.precio * productoAgregado.cantidad;

        // Obtén la referencia a la tabla
        var tabla = $("#tablaProductos");

        // Crea una nueva fila
        var nuevaFila = $("<tr></tr>");

        // Crea las celdas para cada columna
        var celdaCodigo = $("<td>" + codigo + "</td>");

        var celdaNombre = $("<td>" + nombre + "</td>");

        var celdaPrecio = $("<td><input type='number' id='" + productoId + "' class='precio-input' value='" + precio + "'></td>");

        var celdaCantidad = $("<td><input type='number' id='" + productoId + "' class='cantidad-input' value='" + cantidad + "'></td>");

        var celdaSubTotal = $("<td>" + total + "</td>");
        // Agrega las celdas a la fila
        nuevaFila.append(celdaCodigo);
        nuevaFila.append(celdaNombre);
        nuevaFila.append(celdaPrecio);
        nuevaFila.append(celdaCantidad);
        nuevaFila.append(celdaSubTotal);

        celdaCantidad.find('input').on('change', function() {
            var nuevaCantidad = $(this).val();
            var nuevoPrecio = celdaPrecio.find('input').val();
            var subtotal = nuevaCantidad * nuevoPrecio;

            // Busca el objeto en el array con el mismo ID
            var productoAgregado = productosAgregados.find(function(producto) {
                return producto.id === productoId;
            });

            // Actualiza la cantidad y el subtotal en el objeto
            productoAgregado.cantidad = nuevaCantidad;

            celdaSubTotal.text(subtotal);

            // Actualiza el total de la venta
            actualizarTotalVenta();
        });

        celdaPrecio.find('input').on('change', function() {
            var nuevoPrecio = $(this).val();
            var nuevaCantidad = celdaCantidad.find('input').val();
            var subtotal = nuevaCantidad * nuevoPrecio;

            // Busca el objeto en el array con el mismo ID
            var productoAgregado = productosAgregados.find(function(producto) {
                return producto.id === productoId;
            });

            // Actualiza el precio y el subtotal en el objeto
            productoAgregado.precio = nuevoPrecio;

            celdaSubTotal.text(subtotal);

            // Actualiza el total de la venta
            actualizarTotalVenta();
        });


        totalVenta = totalVenta + total;

        document.getElementById('totalVenta').textContent = 'Total venta: ' + totalVenta;

        tabla.find('tbody').append(nuevaFila);

    }


    function actualizarTotalVenta() {
        totalVenta = 0;
        for (var i = 0; i < productosAgregados.length; i++) {
            totalVenta += productosAgregados[i].cantidad * productosAgregados[i].precio;
        }
        document.getElementById('totalVenta').textContent = 'Total venta: ' + totalVenta;
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