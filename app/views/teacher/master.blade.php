<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>@yield('title')</title>

    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="css/sb-admin.css">

    <!-- Custom Fonts -->
    <link rel="stylesheet" type="text/css" href="css/font-awesome.css">
    <script type="text/javascript" src="js/jquery-2.1.3.js"></script>
    <script type="text/javascript" src="js/sb-admin.js"></script>
    <script type="text/javascript" src="js/bootstrap.js"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-default  navbar-fixed-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{URL::to('teacher')}}">DevsFarm</a>
        </div>
        <!-- /.navbar-header -->

        <ul class="nav navbar-top-links navbar-right ">
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-envelope fa-fw" style="color: #0097A7;"></i><i class="fa fa-caret-down" style="color: #0097A7;"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li><a href="{{Lang::get('register.show_all_messages')}}"><i class="fa fa-list-alt fa-fw"></i> Listar</a>
                    </li>
                    <li class="divider"></li>
                    <li><a href="{{Lang::get('routes.send_message')}}"><i class="fa fa-sign-out fa-space-shuttle"></i> Enviar</a>
                    </li>
                </ul>
            </li>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user fa-fw" style="color: #0097A7;"></i>  <i class="fa fa-caret-down" style="color: #0097A7;"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li><a href="{{Lang::get('routes.teacher_profile')}}"><i class="fa fa-user fa-fw" ></i> User Profile</a>
                    </li>
                    <li class="divider"></li>
                    <li><a href="{{Lang::get('routes.logout')}}"><i class="fa fa-sign-out fa-fw" ></i> Logout</a>
                    </li>
                </ul>
            </li>
        </ul>
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <li>
                        <a href="{{Lang::get('routes.teacher')}}" class="nav_home_categoria"><i class="fa fa-home"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="#" class="nav_categoria"><i class="fa fa-list"></i> Asignaturas</a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="#"><i class="fa fa-eye" style="color: #0097A7;"></i> Programacion III</a>
                                <ul class="nav nav-third-level">
                                    <li>
                                        <a href="{{Lang::get('routes.subject_details')}}"><i class="fa fa-arrow-right" style="color: #0097A7;"></i> Seccion S1</a>
                                    </li>
                                    <li>
                                        <a href="{{Lang::get('routes.subject_details')}}"><i class="fa fa-arrow-right" style="color: #0097A7;"></i> Seccion S2</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div id="page-wrapper">
        @yield('content')
    </div>

</div>

</body>

</html>
