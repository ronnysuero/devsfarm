<!DOCTYPE html>
<html lang='en'>
    <head>
        <meta charset="UTF-8" />
    		<meta http-equiv="X-UA-Compatible" content="IE=edge">
    		<meta name="viewport" content="width=device-width, initial-scale=1">
        <title>TeamLand</title>
        <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="css/style.css" />
        <script type="text/javascript" src="js/bootstrap.js"></script>
        <script type="text/javascript" src="js/jquery-2.1.3.js"></script>
    </head>
<body>
    <nav class="navbar" style="background: #0097A7;">
      <div class="container">
    		<a href="{{URL::to('register')}}" class="pull-right" style="font-size: 16px; color: white; text-decoration: none; margin-top: 15px;">Register</a>
    		<div class="navbar-header header_page">
          <a class="navbar-brand" href="{{URL::to('/')}}">TeamLand</a>
        </div>
      </div>
    </nav>
    <div class="container">
      <div class="row">
        <div class="col-xs-12 col-md-6 col-md-offset-3" style="background: #26A69A;">
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

            {{ Form::open(array('url' => 'login')) }}
              <h1>Log In</h1>
              <hr>
              <div class="form-group">
                  {{ Form::label('email', 'Email') }}
                  {{ Form::email('email', Input::old('email'), array('placeholder' => 'Ingrese su correo electronico',
                                                                     'class'       => 'form-control',
                                                                     'id'          => 'user_email',
                                                                     'name'        => 'user_email',
                                                                     'required'    => '')) }}
              </div>
              <div class="form-group">
                  {{ Form::label('password', 'Password') }}
                  {{ Form::password('password', array('placeholder' => 'Ingrese su password',
                                                      'class'       => 'form-control',
                                                      'id'          => 'user_password',
                                                      'name'        => 'user_password',
                                                      'required'    => '',
                                                      'title'       => 'Debe escribir su password')) }}
              </div>
              <div class="checkbox">
                <label>
                    {{ Form::checkbox('check_user', 'remember_me') }} Remember me
                <label>
              </div>
            {{Form::submit('Login', array('class' => 'btn btn-primary pull-right'))}}
            <a href="" class="text-center forgot_pw">Forgot your password?</a>
            {{ Form::close() }}
        </div>
      </div>
    </div>
    <footer style="background: #0097A7; color: white; padding: 30px; position: absolute; width:100%; bottom: 0px; left:0px;">
        <p class="text-muted text-center" style="color: white;">Copyright TeamLand - {{Date('Y')}}</p>
    </footer>
</body>
</html>
