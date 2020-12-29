<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link active" href="#"><i class="icon-speedometer"></i> Escritorio</a>
            </li>
            <li class="nav-title">
                <i class="fas fa-ice-cream"></i> HELADERIA RMR
            </li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="fa fa-line-chart"></i> Ventas</a>
                <ul class="nav-dropdown-items">
                    <li @click="menu=5" class="nav-item">
                        <a class="nav-link" href="#"><i class="fa fa-cart-arrow-down"></i> Facturas</a>
                    </li>
                    <li @click="menu=1" class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-ice-cream"></i>Clientes</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-pie-chart"></i> Reportes</a>
                <ul class="nav-dropdown-items">
                    <li @click="menu=11" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-chart"></i> Reporte Ventas</a>
                    </li>
                </ul>
            </li>
            <li @click="menu=12" class="nav-item">
                <a class="nav-link" href="#"><i class="icon-book-open"></i> Ayuda <span
                        class="badge badge-danger">PDF</span></a>
            </li>
            <li @click="menu=13" class="nav-item">
                <a class="nav-link" href="#"><i class="icon-info"></i> Acerca de...<span
                        class="badge badge-info">IT</span></a>
            </li>
        </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>
