<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link active" href="main.html"><i class="icon-speedometer"></i> Escritorio</a>
            </li>
            <li class="nav-title">
                Maestras
            </li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-bag"></i> General</a>
                <ul class="nav-dropdown-items">
                    <li @click="menu=1" class="nav-item" >
                        <a class="nav-link" href="#"><i class="icon-user"></i> Clientes</a>
                    </li>
                    <li @click="menu=2" class="nav-item">
                        <a class="nav-link" href="#"><i class="fa fa-cube"></i> Sucursales</a>
                    </li>
                    <li @click="menu=3" class="nav-item">
                        <a class="nav-link" href="#"><i class="fa fa-bookmark"></i> Productos</a>
                    </li>
                    <li @click="menu=4" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-bag"></i> Empleados</a>
                    </li>
                    <li @click="menu=5" class="nav-item">
                        <a class="nav-link" href="#"><i class="fa fa-map-pin"></i> Facturas</a>
                    </li>                  
                </ul>
            </li>                   
        </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>