<!DOCTYPE html>
<html lang="es">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>@yield('title', 'App Empleados')</title>

        <!-- Fonts & Icons -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">
        <!-- Bootstrap 5 -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">


        <!-- Styles -->
        <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
        @stack('styles')
    </head>

    <body id="page-top">

        <!-- Page Wrapper -->
        <div id="wrapper">

            <!-- Sidebar -->
            <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

                <!-- Sidebar - Brand -->
                <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/') }}">
                    <div class="sidebar-brand-icon">
                        <i class="fas fa-laptop"></i> <!-- Ícono de computador -->
                    </div>
                    <div class="sidebar-brand-text mx-3">App Computadores</div>
                </a>

                <hr class="sidebar-divider my-0">

                <!-- Dashboard -->
                <li class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('/dashboard') }}">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <!-- Empleados -->
                <li class="nav-item {{ request()->is('empleados*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('/empleados') }}">
                        <i class="fas fa-fw fa-id-badge"></i>
                        <span>Empleados</span>
                    </a>
                </li>

                <!-- Ventas -->
                <li class="nav-item {{ request()->is('ventas*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('/ventas') }}">
                        <i class="fas fa-fw fa-cart-plus"></i>
                        <span>Ventas</span>
                    </a>
                </li>
                <!-- Computadores -->
                <li class="nav-item {{ request()->is('computadores*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('/computadores') }}">
                        <i class="fas fa-fw fa-desktop"></i>
                        <span>Computadores</span>
                    </a>
                </li>
                <!-- Categorías -->
                <li class="nav-item {{ request()->is('categorias*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('/categorias') }}">
                        <i class="bi bi-tags"></i>
                        <span>Categorías</span>
                    </a>
                </li>
            </ul>
            <!-- End of Sidebar -->

            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">

                <!-- Main Content -->
                <div id="content">

                    <!-- Topbar -->
                    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    </nav>
                    <!-- End of Topbar -->

                    <!-- Page Content -->
                    <div class="container-fluid">
                        @yield('content')
                        <div class="container-fluid">

                            <div class="container-fluid">
                            </div>
                            <!-- End Page Content -->

                        </div>
                        <!-- End Main Content -->

                        <!-- Footer -->
                        <footer class="sticky-footer bg-white">
                            <div class="container my-auto">
                                <div class="copyright text-center my-auto">
                                    <span>Copyright &copy; App Empleados {{ date('Y') }}</span>
                                </div>
                            </div>
                        </footer>
                    </div>
                    <!-- End Content Wrapper -->

                </div>
                <!-- End Page Wrapper -->

                <!-- Scroll to Top -->
                <a class="scroll-to-top rounded" href="#page-top">
                    <i class="fas fa-angle-up"></i>
                </a>

                <!-- Scripts -->
                <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
                <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
                <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
                <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

                @yield('javascript')
    </body>
</html>
