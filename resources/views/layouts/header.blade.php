<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Sistema de Gestión Kunaq</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{asset('image/favicon.png')}}">

        <!-- C3 Chart css -->
        <link href="{{ asset('assets/libs/c3/c3.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- Picker -->
        <link href="{{ asset('assets/libs/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">

        <!-- App css -->
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" id="bootstrap-stylesheet" />
        <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css"  id="app-stylesheet" />
        <!-- DataTables -->
        <link href="{{ asset('assets/libs/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/libs/datatables/buttons.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/libs/datatables/responsive.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
        <style>
            .btn-kunaq {
                font-weight: 600;
                background: #D5161E;
                border-radius: 10px;
                margin-right: 5px;
            }
            .btn-kunaq:hover {
                color: #fff;
            }
            .radio {
                border-radius: 10px;
            }
            .uri-seg {
                color: #D5161E;
                font-weight: 800;
            }
            .check-kunaq {
                background: #D5161E;
            }
            .table .thead-light th {
                color: #fff;
                background-color: #D5161E;
                border-color: #dee2e6;
            }
        </style>
        <!-- HIGHCHARTS -->
        <script src="{{ asset('highcharts/highcharts.js') }}"></script>
        <script src="{{ asset('highcharts/highcharts-3d.js') }}"></script>
        <script src="{{ asset('highcharts/cylinder.js') }}"></script>
        <script src="{{ asset('highcharts/exporting.js') }}"></script>
        <script src="{{ asset('highcharts/export-data.js') }}"></script>
        <script src="{{ asset('highcharts/accessibility.js') }}"></script>
    </head>

    <body class="content">

        <!-- Begin page -->
        <div id="wrapper">

            
            <!-- Topbar Start -->
            <div class="navbar-custom">
                <ul class="list-unstyled topnav-menu float-right mb-0">
                    <li class="dropdown notification-list">
                        <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <img src="{{ asset('assets/images/users/avatar-5.jpg') }}" alt="user-image" class="rounded-circle">
                            <span class="pro-user-name ml-1" style="color:#fff">
                                <b>{{ strtoupper(session('usuario')) }}</b><i class="mdi mdi-chevron-down"></i> 
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                            <!-- item-->
                            <div class="dropdown-header noti-title">
                                <h6 class="text-overflow m-0">Bienvenido !</h6>
                            </div>

                            <!-- item-->
                            <a href="{{ url('control-acceso') }}" class="dropdown-item notify-item">
                                <i class="fe-settings"></i>
                                <span>Control Acceso</span>
                            </a>

                            <div class="dropdown-divider"></div>

                            <!-- item-->
                            <a href="{{ url('logout') }}" class="dropdown-item notify-item">
                                <i class="fe-log-out" style="color: #D5161E;"></i>
                                <span style="color: #D5161E;"><b>Salir</b></span>
                            </a>

                        </div>
                    </li>
                </ul>

                <!-- LOGO -->
                <div class="logo-box">
                    <a href="javascript:void(0)" class="logo text-center">
                        <span class="logo-lg">
                            <img src="{{ asset('image/Logo_KQ_web.png') }}" height="110rem">
                            <!-- <span class="logo-lg-text-light">UBold</span> -->
                        </span>
                        <span class="logo-sm">
                            <!-- <span class="logo-sm-text-dark">U</span> -->
                            <img src="{{ asset('image/Logo_KQ_web.png') }}" alt="" height="35rem">
                        </span>
                    </a>
                </div>

                <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
                    <li>
                        <button class="button-menu-mobile waves-effect waves-light">
                            <i class="fe-menu"></i>
                        </button>
                    </li>
                </ul>
            </div>
            <!-- end Topbar -->

            
            <!-- ========== Left Sidebar Start ========== -->
            <div class="left-side-menu">

                <div class="slimscroll-menu">

                    <!--- Sidemenu -->
                    <div id="sidebar-menu">

                        <ul class="metismenu" id="side-menu">

                            <li class="menu-title text-center">Sistema de Gestión</li>

                            <!-- <li class="mm-active"> -->
                            <li>
                                <!-- <a href="javascript: void(0);" aria-expanded="true"> -->
                                <a href="javascript: void(0);">
                                    <i class="fe-airplay"></i>
                                    <span>  General </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <!-- <ul class="nav-second-level" aria-expanded="true"> -->
                                <ul class="nav-second-level">
                                    <!-- <li class="mm-active"><a href="{{ url('perfil') }}" aria-expanded="true">Perfil</a></li> -->
                                    <li><a href="{{ url('perfil') }}" aria-expanded="true">Perfil</a></li>
                                    <!-- <li><a href="javascript: void(0);">Control Clientes</a></li> -->
                                    <li><a href="{{ url('control-acceso') }}">Control Acceso</a></li>
                                </ul>
                            </li>

                            <li>
                                <a href="javascript: void(0);">
                                    <i class="fe-settings"></i>
                                    <span> Soporte Técnico </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul class="nav-second-level" aria-expanded="false">
                                    @if(session('rol') == 'SA' || session('rol') == 'SK' || session('rol') == 'JS')
                                    <!-- <li><a href="{{ url('soporte/atenciones') }}">Atenciones</a></li> -->
                                    @endif
                                    <li><a href="{{ url('soporte/gestion-equipo') }}">Gestión de Equipos</a></li>
                                    <li><a href="{{ url('soporte/resumen-inventario') }}">Resumen de Inventario</a></li>
                                    <li><a href="javascript: void(0);">Control de Licenciamiento</a></li>
                                    <li><a href="javascript: void(0);">Control de Visitas</a></li>
                                    <li><a href="{{ url('soporte/incidencias') }}">Gestión de Incidencias</a></li>
                                    <li>
                                        <a href="javascript: void(0);">
                                            <span>Resumen de Soporte Técnico</span>
                                            <span class="menu-arrow"></span>
                                        </a>
                                        <ul class="nav-second-level" aria-expanded="false">
                                            <li><a href="{{ url('soporte/resumen-soporte') }}">Resumen Técnico</a></li>
                                            <li><a href="{{ url('soporte/tipo-atencion') }}">Tipo Atención</a></li>
                                            <li><a href="{{ url('soporte/modalidad-atencion') }}">Modalidad Atención</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>

                            <li>
                                <a href="javascript: void(0);">
                                    <i class="fe-plus-square"></i>
                                    <span> SG5 Software ERP </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul class="nav-second-level" aria-expanded="false">
                                    <li><a href="javascript: void(0);">Control de Bolsa de Horas</a></li>
                                    <li><a href="javascript: void(0);">Documentación SG5</a></li>
                                </ul>
                            </li>
                            @if(session('rol') == 'SA')
                            <li>
                                <a href="{{ url('configuracion') }}">
                                    <i class="mdi mdi-settings"></i>
                                    <span> Configuración </span>
                                </a>
                            </li>
                            @endif
                        </ul>

                    </div>
                    <!-- End Sidebar -->

                    <div class="clearfix"></div>

                </div>
                <!-- Sidebar -left -->

            </div>
            <!-- Left Sidebar End -->

            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->

            <div class="content-page">
                <div class="content">
                    
                    <!-- Start Content-->
                    <div class="container-fluid">
                        <input type="hidden" id="tk" value="{{csrf_token()}}">
                        @yield('contenido')
                    </div>
                </div>
                <!-- Footer Start -->
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                            © 2022 | Todos los derechos reservados | Kunaq & Asociados S.A.C
                            </div>
                        </div>
                    </div>
                </footer>
                <!-- end Footer -->
            </div>
            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->
        </div>
        <!-- END wrapper -->
        @include('layouts.scripts')        
    </body>
</html>