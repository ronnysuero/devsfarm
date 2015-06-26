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
    <script type="text/javascript" src="js/verify.notify.js"></script>
    <script type="text/javascript" src="js/sb-admin.js"></script>
    <script type="text/javascript" src="js/bootstrap.js"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script type="text/javascript">
      function PreviewImage() {
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("photo").files[0]);

        var file = document.getElementById("photo").value || "";

        oFReader.onload = function(oFREvent) {
          if(!file.match(/(\.jpg|\.jpeg|\.bmp|\.gif|\.png)$/))
            document.getElementById("photo_display").src = "images/140x140.png";
          else
            document.getElementById("photo_display").src = oFREvent.target.result;
        };
      };
    </script>

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
                <a class="navbar-brand" href="{{Lang::get('routes.university')}}">DevsFarm</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right ">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-envelope fa-fw" style="color: #0097A7;"></i><i class="fa fa-caret-down" style="color: #0097A7;"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="{{Lang::get('routes.show_all_messages')}}"><i class="fa fa-list-alt fa-fw"></i> {{Lang::get('university_master.list')}}</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="{{Lang::get('routes.send_message')}}"><i class="fa fa-sign-out fa-space-shuttle"></i> {{Lang::get('university_master.send')}}</a>
                        </li>
                    </ul>
                </li>
                <!-- /.dropdown -->
                {{--<li class="dropdown">--}}
                    {{--<a class="dropdown-toggle" data-toggle="dropdown" href="#">--}}
                        {{--<i class="fa fa-bell fa-fw" style="color: #0097A7;"></i>--}}
                    {{--</a>--}}
                {{--</li>--}}
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw" style="color: #0097A7;"></i>  <i class="fa fa-caret-down" style="color: #0097A7;"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="{{Lang::get('routes.university_profile')}}"><i class="fa fa-user fa-fw" ></i> {{Lang::get('university_master.profile')}}</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="{{Lang::get('routes.logout')}}"><i class="fa fa-sign-out fa-fw" ></i> {{Lang::get('university_master.logout')}}</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a href="{{Lang::get('routes.university')}}" class="nav_home_categoria"><i class="fa fa-home"></i> {{Lang::get('university_master.board')}}</a>
                        </li>
                        <li>
                            <a href="#" class="nav_categoria"><i class="fa fa-list"></i> {{Lang::get('university_master.subject')}}</a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{Lang::get('routes.add_subject')}}"><i class="fa fa-plus" style="color: #0097A7;"></i> {{Lang::get('university_master.add')}}</a>
                                </li>
                                <li>
                                    <a href="{{Lang::get('routes.show_all_subjects')}}"><i class="fa fa-eye" style="color: #0097A7;"></i> {{Lang::get('university_master.list')}}</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#" class="nav_categoria"><i class="fa fa-list-ol"></i> {{Lang::get('university_master.section')}}</a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{Lang::get('routes.add_section')}}"><i class="fa fa-plus" style="color: #0097A7;"></i> {{Lang::get('university_master.add')}}</a>
                                </li>
                                <li>
                                    <a href="{{Lang::get('routes.show_all_sections')}}"><i class="fa fa-eye" style="color: #0097A7;"></i> {{Lang::get('university_master.list')}}</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#" class="nav_categoria"><i class="fa fa-group"></i> {{Lang::get('university_master.teacher')}}</a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{Lang::get('routes.add_teacher')}}"><i class="fa fa-plus" style="color: #0097A7;"></i> {{Lang::get('university_master.add')}}</a>
                                </li>
                                <li>
                                    <a href="{{Lang::get('routes.show_all_teachers')}}"><i class="fa fa-eye" style="color: #0097A7;"></i> {{Lang::get('university_master.list')}}</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#" class="nav_categoria"><i class="fa fa-compress"></i> {{Lang::get('university_master.assignment')}}</a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{Lang::get('routes.add_enrollment')}}"><i class="fa fa-plus" style="color: #0097A7;"></i> {{Lang::get('university_master.assign_subject')}}</a>
                                </li>
                                <li>
                                    <a href="{{Lang::get('routes.show_all_enrollment')}}"><i class="fa fa-eye" style="color: #0097A7;"></i> {{Lang::get('university_master.list')}}</a>
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
