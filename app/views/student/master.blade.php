<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DevsFarm</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/sb-admin.css">
    <link rel="stylesheet" type="text/css" href="css/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="css/dhtmlxgantt.css">
    <script type="text/javascript" src="js/jquery-2.1.3.js"></script>
    <script type="text/javascript" src="js/sb-admin.js"></script>
    <script type="text/javascript" src="js/bootstrap.js"></script>
    <script type="text/javascript" src="js/metisMenu.min.js"></script>
    <script type="text/javascript" src="js/dhtmlxgantt.js"></script>
</head>
<body>
    <div id="wrapper">
        <nav class="navbar navbar-default  navbar-fixed-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="">DevsFarm</a>
            </div>
            <ul class="nav navbar-top-links navbar-right ">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-envelope fa-fw" style="color: #0097A7;"></i><i class="fa fa-caret-down" style="color: #0097A7;"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="{{Lang::get('routes.send_message')}}"><i class="fa fa-sign-out fa-space-shuttle"></i> {{Lang::get('university_master.send_message')}}</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="{{Lang::get('routes.show_all_messages')}}"><i class="fa fa-list-alt fa-fw"></i> {{Lang::get('university_master.received_message')}}</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="{{Lang::get('routes.mail_sent')}}"><i class="fa fa-envelope-o"></i> {{Lang::get('university_master.mail_sent')}}</a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw" style="color: #0097A7;"></i>  <i class="fa fa-caret-down" style="color: #0097A7;"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="{{Lang::get('routes.student_profile')}}"><i class="fa fa-user fa-fw" ></i> User Profile</a>
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
                            <a href="" class="nav_home_categoria"><i class="fa fa-home"></i> Dashboard</a>
                        </li>
                        <li>

                            <a href="#" class="nav_categoria"><i class="fa fa-list"></i></a>
                            <ul class="nav nav-second-level">



                                <li>
                                    <a href=""><i class="fa fa-arrow-right" style="color: #0097A7;"></i>Proyecto S2</a>

                                </li>



                                <li>
                                    <a href=""><i class="fa fa-arrow-right" style="color: #0097A7;"></i>Proyecto S2</a>

                                </li>

                                <li>
                                    <a href=""><i class="fa fa-arrow-right" style="color: #0097A7;"></i> Proyecto S3</a>

                                </li>

                                <li>
                                    <a href=""><i class="fa fa-arrow-right" style="color: #0097A7;"></i> Proyecto S4</a>

                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="" class="nav_categoria"><i class="fa fa-users"> Group</i></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{Lang::get('routes.register_group')}}"><i class="fa fa-plus" style="color: #0097A7;"></i> New Group</a>
                                </li>

                                <li>
                                    <a href="{{Lang::get('routes.join_to_group')}}"><i class="fa fa-plus" style="color: #0097A7;"> Join To group</i></a>
                                </li>

                                <li>
                                    <a href="{{Lang::get('routes.show_groups')}}"><i class="fa fa-plus" style="color: #0097A7;"> Show Groups</i></a>
                                </li>

                            </ul>
                        </li>
                    </ul>
                </div>
            </div>

        </nav>
    </div>
    <div id="page-wrapper">
        @yield('content')
    </div>
</body>
</html>
