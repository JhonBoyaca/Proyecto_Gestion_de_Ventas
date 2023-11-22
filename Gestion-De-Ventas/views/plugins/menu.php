<?php

session_start();

if (!isset($_SESSION["correo"])) {
    header("Location:index.php");
}

$correo = $_SESSION["correo"];
$rol = $_SESSION["rol"];
$usuarioID = $_SESSION["usuarioID"];
?>

<section class="full-box nav-lateral">
    <div class="full-box nav-lateral-bg show-nav-lateral"></div>
    <div class="full-box nav-lateral-content">
        <figure class="full-box nav-lateral-avatar">
            <i class="far fa-times-circle show-nav-lateral"></i>
            <img src="./assets/avatar/Avatar.png" class="img-fluid" alt="Avatar">
            <figcaption class="roboto-medium text-center">Correo: <?php echo $correo; ?>
                <br><?php echo $rol; ?>

            </figcaption>
        </figure>
        <div class="full-box nav-lateral-bar"></div>
        <nav class="full-box nav-lateral-menu">
            <ul>
                <li>
                    <a href="home.php"><i class="fab fa-dashcube fa-fw"></i> &nbsp; Home </a>
                </li>
                <li>
                    <a href="#" class="nav-btn-submenu"><i class="fas fa-pallet fa-fw"></i> &nbsp; Productos <i class="fas fa-chevron-down"></i></a>
                    <ul>
                        <li>
                            <a href="productos.php"><i class="fas fa-plus fa-fw"></i> &nbsp; CRUD Productos</a>
                        </li>

                    </ul>
                </li>

                <?php
                // Suponiendo que $rol contiene el valor del rol actual del usuario

                if ($rol == 'gerente' || $rol == 'vendedor' || $rol == 'admin') {
                    // Solo muestra el menú si el rol no es 'empleado'
                ?>
                    <li>
                        <a href="#" class="nav-btn-submenu"><i class="fas fa-file-invoice-dollar fa-fw"></i> &nbsp;
                            Ventas <i class="fas fa-chevron-down"></i></a>
                        <ul>
                            <li>
                                <a href="#nada" id="nueva-venta"><i class="fas fa-plus fa-fw"></i> &nbsp; Nueva Venta </a>
                            </li>
                        </ul>
                    </li>
                <?php
                }
                ?>

                <?php
                // Suponiendo que $rol contiene el valor del rol actual del usuario

                if ($rol == 'gerente' || $rol == 'admin') {
                    // Muestra el menú solo si el rol es 'gerente' o 'admin'
                ?>
                    <li>
                        <a href="#" class="nav-btn-submenu"><i class="fas  fa-user-secret fa-fw"></i> &nbsp;
                            Reportes<i class="fas fa-chevron-down"></i></a>
                        <ul>
                            <li>
                                <a href="reportes.php"><i class="fas fa-plus fa-fw"></i> &nbsp;Productos Existentes</a>
                            </li>
                            <li>
                                <a href="reportesStockMin.php"><i class="fas fa-plus fa-fw"></i> &nbsp;PROD Stock & Ventas Rango</a>
                            </li>
                        </ul>
                    </li>
                <?php
                }
                ?>



                <li>
                    <a href="index.php?cerrar=true"><i class="fas  fa-user-secret fa-fw"></i> &nbsp; Cerrar Sesion</a>
                </li>
            </ul>
        </nav>
    </div>
</section>
<input type="hidden" id="usuarioID" value="<?php echo $usuarioID; ?>">
<input type="hidden" id="rolUsuario" value="<?php echo $rol; ?>">
<script>
    var usuarioID = document.getElementById('usuarioID').value;
    var rolUsuario = document.getElementById('rolUsuario').value;
</script>