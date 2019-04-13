<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>AdminLTE 3 | Starter</title>
    <link href="/css/app.css" rel="stylesheet">


    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper" id="app">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
        <!-- Left navbar links -->

        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
            </li>

        </ul>
        <!-- SEARCH FORM -->
        <form class="form-inline ml-3">
            <div class="input-group input-group-sm">
                <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-navbar" type="submit">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>
        </form>

        <!-- Right navbar links -->

    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="index3.html" class="brand-link">
            <img src="img/download.jpeg" alt="Lara Start Logo" class="brand-image img-circle elevation-3"
                 style="opacity: .8">
            <span class="brand-text font-weight-light">Lara Start</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="img/prof.png" class="img-circle elevation-2" alt="{{ Auth::user()->name }}">
                </div>
                <div class="info">
                    <a href="#" class="d-block">{{ Auth::user()->name }}</a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->


                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-users blue"></i>
                            <p>
                                Groups <i class="fa fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview" style="display: none;">

                            <li class="nav-item">
                                <router-link to="/groups" class="nav-link">
                                    <i class="fas fa-circle-o nav-icon"></i>

                                    <p>
                                        Groups
                                        <!--<span class="right badge badge-danger">New</span>-->
                                    </p>
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <a href="../UI/buttons.html" class="nav-link">
                                    <i class="fas fa-circle-o nav-icon"></i>
                                    <p>Buttons</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../UI/sliders.html" class="nav-link">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>Sliders</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-envelope-square orange"></i>
                            <p>
                                Projects <i class="fa fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview" style="display: none;">

                            <li class="nav-item">
                                <router-link to="/projects" class="nav-link">
                                    <i class="fas fa-circle-o nav-icon"></i>

                                    <p>
                                        Projects
                                        <!--<span class="right badge badge-danger">New</span>-->
                                    </p>
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <a href="../UI/buttons.html" class="nav-link">
                                    <i class="fas fa-circle-o nav-icon"></i>
                                    <p>Buttons</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../UI/sliders.html" class="nav-link">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>Sliders</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-wallet orange"></i>
                            <p>
                                Wallets <i class="fa fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview" style="display: none;">

                            <li class="nav-item">
                                <router-link to="/wallets" class="nav-link">
                                    <i class="fas fa-circle-o nav-icon"></i>

                                    <p>
                                        Wallets
                                        <!--<span class="right badge badge-danger">New</span>-->
                                    </p>
                                </router-link>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-list red"></i>
                            <p>
                                Transactions <i class="fa fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview" style="display: none;">

                            <li class="nav-item">
                                <router-link to="/group" class="nav-link">
                                    <i class="fas fa-circle-o nav-icon"></i>

                                    <p>
                                        Transactions
                                        <!--<span class="right badge badge-danger">New</span>-->
                                    </p>
                                </router-link>
                            </li>
                            </li>
                        </ul>
                    </li>

                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->

        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <router-view></router-view>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->


    <!-- Main Footer -->
    <footer class="main-footer">
        <!-- To the right -->
        <div class="float-right d-none d-sm-inline">
            Anything you want
        </div>
        <!-- Default to the left -->
        <strong>Copyright &copy; 2019- <?php echo date('Y')?> <a href="#x">Wallet Chango</a>.</strong> All rights reserved.
    </footer>
</div>
<!-- ./wrapper -->

<script src="/js/app.js"></script>
</body>
</html>
