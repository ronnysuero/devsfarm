<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="DevsFarm">
    <link rel="shortcut icon" href="favicon.png">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/login.css" rel="stylesheet">
    <link href="css/animate-custom.css" rel="stylesheet">
    @if(Request::is('/'))
        <title>Devsfarm</title>
    @else
        <title>@yield('title')</title>
    @endif
</head>
<body>
<script type="text/javascript" src="js/jquery.min.js"></script>
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{URL::to('/')}}">DevsFarm</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            {{ Form::open(array('url' => Lang::get('routes.login'), 'class' => 'navbar-form navbar-right')) }}
            <div class="form-group">
                <input data-validate="required,email" class="form-control" type="email" name="user_email" placeholder="{{Lang::get('login.email_placeholder')}}">
            </div>
            <div class="form-group">
                <input data-validate="required" type="password" class="form-control" name="user_password" placeholder="{{Lang::get('login.password_placeholder')}}">
            </div>
            <button type="submit" class="btn btn-primary">{{Lang::get('login.login')}}</button>
            <br>
            <a href="{{Lang::get('routes.forget_password')}}">
                {{Lang::get('login.forget_password')}}
            </a>
            {{ Form::close() }}
        </div>
    </div>
</nav>
@include('alert')
<div class="container" style="margin-top: 60px;">
    <h2>{{Lang::get('videotutorial.video_tutorial')}}</h2>
    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-6">
                    <h3 style="background: #F7F3F3;padding: 8px;">{{Lang::get('videotutorial.university_workflow')}}</h3>
                    <video width="100%" controls>
                        <source src="video/university.mp4" type="video/mp4">
                        Your browser does not support mp4 videos.
                    </video>
                </div>

                <div class="col-lg-6">
                    <h3 style="background: #F7F3F3;padding: 8px;">{{Lang::get('videotutorial.student_workflow')}}</h3>
                    <video width="100%" controls>
                        <source src="video/student.mp4" type="video/mp4">
                        Your browser does not support mp4 videos.
                    </video>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <h3 style="background: #F7F3F3;padding: 8px;">{{Lang::get('videotutorial.teacher_workflow')}}</h3>
                    <video width="100%" controls>
                        <source src="video/teacher.mp4" type="video/mp4">
                        Your browser does not support mp4 videos.
                    </video>
                </div>

                <div class="col-lg-6">
                    <h3 style="background: #F7F3F3;padding: 8px;">{{Lang::get('videotutorial.recover_password')}}</h3>
                    <video width="100%" controls>
                        <source src="video/recover_password.mp4" type="video/mp4">
                        Your browser does not support mp4 videos.
                    </video>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <h3 style="background: #F7F3F3;padding: 8px;">{{Lang::get('videotutorial.blocking_user')}}</h3>
                    <video width="100%" controls>
                        <source src="video/blocking_user.mp4" type="video/mp4">
                        Your browser does not support mp4 videos.
                    </video>
                </div>

            </div>
        </div>

    </div>
    <input type="hidden" id="langGlobal" value="{{App::getLocale()}}">
    <hr>
    <footer>
        <p>© Devsfarm 2015-2016</p>
    </footer>
</div>
<script type="text/javascript" src="js/bootstrap.js"></script>
<script type="text/javascript" src="js/custom.modernizr.js"></script>
<script type="text/javascript" src="js/placeholder-shim.js"></script>
<script type="text/javascript" src="js/custom.js"></script>
<script type="text/javascript" src="js/verify.notify.js"></script>
</body>
</html>
