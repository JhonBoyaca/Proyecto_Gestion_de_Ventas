<!-- Nav lateral -->
<section class="full-box nav-lateral">
    <div class="full-box nav-lateral-bg show-nav-lateral"></div>
    <div class="full-box nav-lateral-content">
        <figure class="full-box nav-lateral-avatar">
            <i class="far fa-times-circle show-nav-lateral"></i>
            <img src="./assets/avatar/Avatar.png" class="img-fluid" alt="Avatar">
            <figcaption class="roboto-medium text-center">
                <br><small class="roboto-condensed-light"></small>
            </figcaption>
        </figure>
        <div class="full-box nav-lateral-bar"></div>
        <nav class="full-box nav-lateral-menu">
            <ul>
                <li>
                    <a href="home.php"><i class="fab fa-dashcube fa-fw"></i> &nbsp; Home</a>
                </li>



                <li>
                    <a href="#" class="nav-btn-submenu"><i class="fas fa-pallet fa-fw"></i> &nbsp; Productos <i class="fas fa-chevron-down"></i></a>
                    <ul>
                        <li>
                            <a href="productos.php"><i class="fas fa-plus fa-fw"></i> &nbsp; CRUD Productos</a>
                        </li>
                        <li>
                            <a href="item-list.html"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; Lista de
                                items</a>
                        </li>
                        <li>
                            <a href="item-search.html"><i class="fas fa-search fa-fw"></i> &nbsp; Buscar
                                item</a>
                        </li>
                    </ul>
                </li>

                <?php
                // Suponiendo que $rol contiene el valor del rol actual del usuario

                if ($rol != 'empleado') {
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


                <li>
                    <a href="#" class="nav-btn-submenu"><i class="fas  fa-user-secret fa-fw"></i> &nbsp;
                        Reportes <i class="fas fa-chevron-down"></i></a>
                    <ul>
                        <li>
                            <a href="reportes.php"><i class="fas fa-plus fa-fw"></i> &nbsp;Productos Existentes</a>
                        </li>
                        <li>
                            <a href="reportesStockMin.php"><i class="fas fa-plus fa-fw"></i> &nbsp;Productos Stock Min</a>
                        </li>
                        <li>
                            <a href="reportesStockMin.php"><i class="fas fa-plus fa-fw"></i> &nbsp;Ventas</a>
                        </li>
                    </ul>
                </li>


                <li>
                    <a href="index.php?cerrar=true"><i class="fas  fa-user-secret fa-fw"></i> &nbsp; Cerrar Sesion</a>
                </li>
            </ul>
        </nav>
    </div>
</section>