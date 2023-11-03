
$(document).ready(function () {

    $("#nueva-venta").on("click", function (event) {

        event.preventDefault(); 

        // Cargar el contenido de ventas.php y mostrarlo en el contenedor
        $("#content-container").load("ventas/ventas.php");
    });


});