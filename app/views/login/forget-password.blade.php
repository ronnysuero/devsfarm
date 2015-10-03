@extends('login.master')
@section('title', Lang::get('login_title.forget'))
@section('content')
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
            <a class="navbar-brand" href="/">DevsFarm</a>
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

        </div><!--/.navbar-collapse -->
    </div>
</nav>

<img src="images/header.jpg" alt="" width="100%" style="margin-top: 50px;">

<div class="container" id="login-block">
    <div class="row">
        <div class="col-lg-7">
            <div class="row">
                <div class="col-md-12">
                    <h2>{{Lang::get('welcome.devsfarm_label')}}</h2>
                    <p>{{Lang::get('welcome.devsfarm_definition')}}</p>
                    <hr>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <h2>{{Lang::get('welcome.chat_label')}}</h2>
                    <p>{{Lang::get('welcome.chat_definition')}}</p>
                    <hr>
                </div>
                <div class="col-md-6">
                    <h2>{{Lang::get('welcome.reports_label')}}</h2>
                    <p>{{Lang::get('welcome.reports_definition')}}<br><br></p>
                    <hr>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <h2>{{Lang::get('welcome.attach_files_label')}}</h2>
                    <p>{{Lang::get('welcome.attach_files_definition')}}<br><br></p>
                    <hr>
                </div>
                <div class="col-md-6">
                    <h2>{{Lang::get('welcome.client_mobile_label')}}</h2>
                    <p>{{Lang::get('welcome.client_mobile_definition')}}</p>
                    <hr>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <h2 class=" animated bounceInDown">{{lang::get('register_student.reset_password')}}</h2>
            <div class="login-box  clearfix animated flipInY">
                <hr>
                <div class="login-form">
                    @include('alert')
                    {{ Form::open(array('url' => Lang::get('routes.forget_password'), 'class' => 'register_form', 'id' => 'register_form')) }}
                        <p>{{lang::get('register_student.message_reset')}}</p>
                        <input data-validate="required,email" type="email" name="email" placeholder="{{Lang::get('login.email_placeholder')}}">
                        <button type="submit" class="btn btn-red btn-reset">{{lang::get('register_student.send_mail')}}</button>
                    {{ Form::close() }}
                    <div class="login-links">
                        <a href="{{URL::to('/')}}">
                            {{Lang::get('register_student.sign_in')}}
                        </a>
                        <br>
                        <a href="{{Lang::get('routes.register')}}">
                            {{lang::get('register_student.sign_up')}}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
