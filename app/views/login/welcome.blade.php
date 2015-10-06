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
                    <div class="form-group">
                    	<label>
                    		{{ Form::checkbox('check_user', 'remember_me') }} {{Lang::get('login.remember_me')}}
                    	</label>
                    </div>

					<a href="{{Lang::get('routes.forget_password')}}" style="margin-left: 12px;">
						{{Lang::get('login.forget_password')}}
					</a>
				{{ Form::close() }}
			</div>
		</div>
	</nav>
	@if(Request::is('/') || Request::is(Lang::get('routes.forget_password')))
		<img src="images/header.jpg" alt="" width="100%" style="margin-top: 50px;">
		@include('alert')
		<div class="container">
			<div class="row">
				<div class="col-lg-6">
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
	                <div class="row">
	                    <div class="col-md-12">
	                        <h2>{{Lang::get('welcome.videotutorial_label')}}</h2>
	                        <p>{{Lang::get('welcome.videotutorial_definition')}}<br>
	                        <br>
	                            <a href="{{Lang::get('routes.video_tutorials')}}">{{Lang::get('welcome.videotutorial_label')}}</a>
	                        </p>
	                        <hr>
	                    </div>
	                </div>
	            </div>
				@if(Request::is('/'))
					@include('login.register')
					<script src="https://www.google.com/recaptcha/api.js?hl={{App::getLocale()}}&onload=myCallBack&render=explicit"></script>
				@else
					@yield('content')
				@endif
			</div>
			<input type="hidden" id="langGlobal" value="{{App::getLocale()}}">
			<hr>
			<footer>
				<p>© Devsfarm 2015-2016</p>
			</footer>
		</div>
	@else
		@yield('content')
	@endif
	<script type="text/javascript">
		$(document).ready(function()
		{
			$('ul.tabs li').click(function()
			{
				var tab_id = $(this).attr('data-tab');
				$('ul.tabs li').removeClass('current');
				$('.tab-content').removeClass('current');
				$(this).addClass('current');
				$("#"+tab_id).addClass('current');
			});
		})

		function validate_captcha()
		{
			var validate = grecaptcha.getResponse();

			if(validate.length == 0)
			{
				$('#captcha').html("{{Lang::get('register_student.error_captcha')}}");
				return false;
			}
			else if(validate.length != 0)
			{
				$('#captcha').html("");
				return true;
			}
		}

		function validate_captcha2()
		{
			var validate = grecaptcha.getResponse();

			if(validate.length == 0)
			{
				$('#captcha2').html("{{Lang::get('register_student.error_captcha')}}");
				return false;
			}
			else if(validate.length != 0)
			{
				$('#captcha2').html("");
				return true;
			}
		}
	</script>

	<script>
		var recaptcha1
			,recaptcha2;

		var myCallBack = function()
		{
			//Render the recaptcha1 on the element with ID "recaptcha1"
			recaptcha1 = grecaptcha.render('recaptcha1', {
				'sitekey' : "{{Config::get('recaptcha.public_key')}}",
				'theme' : 'light'
			});

			//Render the recaptcha2 on the element with ID "recaptcha2"
			recaptcha2 = grecaptcha.render('recaptcha2', {
				'sitekey' : "{{Config::get('recaptcha.public_key')}}",
				'theme' : 'light'
			});
		};
	</script>
	<script type="text/javascript" src="js/bootstrap.js"></script>
	<script type="text/javascript" src="js/custom.modernizr.js"></script>
	<script type="text/javascript" src="js/placeholder-shim.js"></script>
	<script type="text/javascript" src="js/custom.js"></script>
	<script type="text/javascript" src="js/verify.notify.js"></script>
</body>
</html>
