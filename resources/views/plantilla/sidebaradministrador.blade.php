<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link active" href="#"><i class="icon-speedometer"></i> Escritorio</a>
            </li>
            <li class="nav-title">
                <i class="fa fa-home"></i> HELADERÍA RMR
            </li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="fa fa-user"></i>Clientes</a>
                <ul class="nav-dropdown-items">
                    <li @click="menu=1" class="nav-item" >
                        <a class="nav-link" href="#"><i class="icon-user"></i> Clientes</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="fa fa-cubes"></i>Productos</a>
                <ul class="nav-dropdown-items">
                    <li @click="menu=3" class="nav-item">
                        <a class="nav-link" href="#"><i class="fa fa-cubes"></i> Productos</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-basket-loaded"></i>Compras</a>
                <ul class="nav-dropdown-items">
                    <li @click="menu=8" class="nav-item">
                        <a class="nav-link" href="#"><i class="fa fa-cart-plus"></i> Compras</a>
                    </li>  
                    <li @click="menu=7" class="nav-item">
                        <a class="nav-link" href="#"><i class="fa fa-handshake-o"></i> Proveedores</a>
                    </li>     
                </ul>
            </li>   
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="fa fa-line-chart"></i>Ventas</a>
                <ul class="nav-dropdown-items">
                    <li @click="menu=5" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-basket-loaded"></i> Facturas</a>
                    </li>    
                </ul>
            </li>        
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="fa fa-user-plus"></i> Acceso</a>
                <ul class="nav-dropdown-items">
                    <li @click="menu=4" class="nav-item">
                        <a class="nav-link" href="#"><i class="fa fa-group"></i> Empleados</a>
                    </li>
                    <li @click="menu=2" class="nav-item">
                        <a class="nav-link" href="#"><i class="fa fa-cube"></i> Sucursales</a>
                    </li>
                    {{-- <li @click="menu=6" class="nav-item">
                        <a class="nav-link" href="#"><i class="fa fa-group"></i>Roles</a>
                    </li> --}}
                </ul>
            </li>
        </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>
