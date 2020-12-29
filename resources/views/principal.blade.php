<!DOCTYPE html>
<html lang="ES">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Sistema Libros Laravel Vue Js">
    <meta name="author" content="adsi.com">
    <meta name="keyword" content="Sistema libros Laravel Vue Js">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="img/Hela.png">
    <title>Heladeria RMR</title>
    <!-- Icons -->
    <link rel="stylesheet" href="css/plantilla.css">
    {{-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script> --}}
</head>

<body class="app header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden">
    <div id="app">
        <header class="app-header navbar">
            <button class="navbar-toggler mobile-sidebar-toggler d-lg-none mr-auto" type="button">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="#"></a>
            <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button">
                <span class="navbar-toggler-icon"></span>
            </button>
            <ul class="nav navbar-nav d-md-down-none">
                <li class="nav-item px-3">
                    <a class="nav-link" href="#">Escritorio</a>
                </li>
                <li class="nav-item px-3">
                    <a class="nav-link" href="#">Configuraciones</a>
                </li>
            </ul>
            <ul class="nav navbar-nav ml-auto">
                <li class="nav-item d-md-down-none">
                    <a class="nav-link" href="#" data-toggle="dropdown">
                        <i class="icon-bell"></i>
                        <span class="badge badge-pill badge-danger">5</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <div class="dropdown-header text-center">
                            <strong>Notificaciones</strong>
                        </div>
                        <a class="dropdown-item" href="#">
                            <i class="fa fa-envelope-o"></i> Heladeria
                            <span class="badge badge-success">3</span>
                        </a>
                        <a class="dropdown-item" href="#">
                            <i class="fa fa-tasks"></i> New
                            <span class="badge badge-danger">2</span>
                        </a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle nav-link" data-toggle="dropdown" href="#" role="button"
                        aria-haspopup="true" aria-expanded="false">
                        <img src="img/logo.png" class="img-avatar" alt="#">
                        <span class="d-md-down-none">{{Auth::user()->usuario}} </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <div class="dropdown-header text-center">
                            <strong>Cuenta</strong>
                        </div>
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fa fa-lock"></i> Cerrar sesión</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </div>
                </li>
            </ul>
        </header>
        <div class="app-body">
            @if (Auth::check())
                @if (Auth::user()->id_rol == 1)
                    @include('plantilla.sidebaradministrador')
                @elseif (Auth::user()->id_rol == 2)
                    @include('plantilla.sidebarvendedor')
                @endif
            @endif
            @yield('contenido')
        </div>
    </div>
    <footer class="app-footer">
        <span><a href="https://www.instagram.com/el.royy/?hl=es">Roy M Rodriguez</a> &copy; 2020</span>
        <!-- /Fin del contenido principal -->
        <span class="ml-auto">Desarrollado por <a href="https://www.instagram.com/el.royy/?hl=es">Roy</a></span>
    </footer>
    <script src="js/app.js"></script>
    <script src="js/plantilla.js"></script>
</body>

</html>
