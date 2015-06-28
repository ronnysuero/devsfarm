<!DOCTYPE html>
<html lang='en'>
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DevsFarm</title>
    <script type="text/javascript" src="js/jquery-2.1.3.js"></script>
    <script type="text/javascript" src="js/bootstrap.js"></script>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/style.css" />
  </head>
<body>
	<nav class="navbar" style="background-color: #f8f8f8;  border-color: #e7e7e7;">
    <div class="container">
  	  <a href="{{Lang::get('routes.register')}}" class="pull-right" style="font-size: 16px; color: #0097A7; text-decoration: none; margin-top: 15px;">{{Lang::get('login.register')}}</a>
    	<div class="navbar-header header_page">
        <a class="navbar-brand" style="color: #0097A7;" href="{{URL::to('/')}}">DevsFarm</a>
      </div>
    </div>
  </nav>
  <div class="container">
    <div class="row">
      <div class="col-xs-10 col-xs-offset-1 col-md-6 col-md-offset-3" style="  background-color: #f8f8f8; border: 1px solid #e7e7e7; color: #0097A7;">
        @if($errors->has('error'))
          <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert"
              aria-hidden="true" onclick="$('.alert.alert-danger.alert-dismissable').hide('slow')">
              &times;
            </button>
            {{ $errors->first('error') }}
          </div>
        @endif
        @if(Session::has('message'))
          <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"
              onclick="$('.alert.alert-success.alert-dismissable').hide('slow')">
              &times;
            </button>
            {{Session::get('message')}}
          </div>
        @endif
          {{ Form::open(array('url' => Lang::get('routes.login'))) }}
          <h1>{{Lang::get('login.login')}}</h1>
          <hr>
          <div class="form-group">
            {{ Form::label('email', Lang::get('login.email')) }}
            {{ Form::email('email', Input::old('email'), array( 'placeholder' => Lang::get('login.email_placeholder'),
                                                                'class'       => 'form-control',
                                                                'id'          => 'user_email',
                                                                'name'        => 'user_email',
                                                                'required'    => '')) }}
          </div>
          <div class="form-group">
            {{ Form::label('password', Lang::get('login.password')) }}
            {{ Form::password('password', array('placeholder' => Lang::get('login.password_placeholder'),
                                                'class'       => 'form-control',
                                                'id'          => 'user_password',
                                                'name'        => 'user_password',
                                                'required'    => '' )) }}
          </div>
          <div class="checkbox">
            <label>
              {{ Form::checkbox('check_user', 'remember_me') }} {{Lang::get('login.remember_me')}}
            </label>
          </div>
          {{Form::submit(Lang::get('login.login'), array('class' => 'btn btn-primary pull-right'))}}
            <a href="" class="text-center forgot_pw">{{Lang::get('login.forget_password')}}</a>
          {{ Form::close() }}
        </div>
      </div>
    </div>
  </body>
</html>
