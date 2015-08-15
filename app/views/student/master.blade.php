<!DOCTYPE html>

<html lang='en'>
<head>

    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DevsFarm</title>


    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="css/sb-admin.css">
    <link rel="stylesheet" type="text/css" href="css/tablestyle.css" />
    <link rel="stylesheet" type="text/css" href="css/sb-admin.css">
    <link rel="stylesheet" type="text/css" href="css/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/cropper.min.css">
    <link rel="stylesheet" href="css/alertify.core.css" />
    <link rel="stylesheet" href="css/alertify.default.css" id="toggleCSS" />
    <link rel="stylesheet" type="text/css" href="css/font-awesome.css">
    <!-- DHTMLxgantt CSS-->
    <link href="css/dhtmlxgantt.css" rel="stylesheet">

    <!-- Custom Fonts -->
   
    <script type="text/javascript" src="js/jquery-2.1.3.js"></script>
    <script type="text/javascript" src="js/sb-admin.js"></script>
    <script type="text/javascript" src="js/bootstrap.js"></script>
    <script type="text/javascript" src="js/metisMenu.min.js"></script>
    <script type="text/javascript" src="js/verify.notify.js"></script>

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
            <a class="navbar-brand" href="">DevsFarm</a>
        </div>

        <!-- /.navbar-header -->
        <ul class="nav navbar-top-links navbar-right user-menu" id="user-menu">
                <li class="dropdown">
                    <a href="#" class="settings dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-envelope" style="color: #0097A7;"></i>
                        @if($stats['unread'] > 0)
                            <span id="unread" class="badge bg-pink">{{$stats['unread']}}</span>
                        @endif
                    </a>
                    <ul class="dropdown-menu inbox dropdown-user">
                        @foreach($unreadMessages as $index => $message)
                            <li class="popups" id="{{$index+1}}">
                                <a>
                                    <?php $user = UserController::getUser(User::first($message->from)); ?>

                                    @if($user->profile_image === null)
                                        <img src="images/140x140.png" class="avatar" alt="avatar"></td>
                                    @else
                                        <img src="{{Lang::get('show_image').'?src='.storage_path().$user->profile_image}}" class="avatar"/>
                                    @endif    
                                    <input type="hidden" id="id{{$index+1}}" value="{{$message->_id}}">
                                    <div>
                                        <span class="username">{{$user->name}}</span> 
                                        <span class="time pull-right"> 
                                            <i class="fa fa-clock-o"></i> 
                                            {{MessageController::getDate($message->sent_date)}}
                                        </span>
                                    </div>
                                    <div>
                                        <br/>
                                        <p>
                                            @if(strlen($message->body) > 50)
                                                {{substr($message->body, 0, 50)}} ...
                                            @else
                                                {{$message->body}}
                                            @endif
                                        </p>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                        <li>
                            <a href="{{Lang::get('routes.inbox')}}" class="btn bg-primary">
                                {{Lang::get('university_master.view')}}
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw" style="color: #0097A7;"></i>  
                        <i class="fa fa-caret-down" style="color: #0097A7;"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li>
                            <a href="{{Lang::get('routes.student_profile')}}">
                                <i class="fa fa-user fa-fw" ></i> 
                                {{Lang::get('university_master.student_profile')}}
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="{{Lang::get('routes.inbox')}}">
                                <i class="fa fa-envelope"></i>   
                                {{Lang::get('university_master.inbox')}}
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="{{Lang::get('routes.logout')}}">
                                <i class="fa fa-sign-out fa-fw text-danger" ></i> 
                                {{Lang::get('university_master.logout')}}
                            </a>
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

                        </ul>
                    </li>
                    <li>
                        <a href="" class="nav_categoria"><i class="fa fa-users"> Group</i></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href={{Lang::get('routes.register_group')}}><i class="fa fa-plus" style="color: #0097A7;"></i> New Group</a>
                            </li>

                            <li>
                                <a href={{Lang::get('routes.join_to_group')}}><i class="fa fa-plus" style="color: #0097A7;"> Join To group</i></a>
                            </li>

                            <li>
                                <a href={{Lang::get('routes.show_groups')}}><i class="fa fa-plus" style="color: #0097A7;"> Show Groups</i></a>
                            </li>

                        </ul>
                    </li>
                </ul>
            </div>
        </div>

    </nav>
</div>

<div class="row" id="page-wrapper">
    @yield('content')

</div>
@include('message.modals')
</body>
</html>

