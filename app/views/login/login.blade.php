@extends('login.master')
@stop
@section('content')
	<div class="container" id="login-block">
		<div class="row">
			<div class="col-sm-6 col-md-4 col-sm-offset-3 col-md-offset-4">
				<h2 class="animated bounceInDown">{{Lang::get('login.login')}}</h2>
				<div class="login-box clearfix animated flipInY">
					<div class="login-logo">
						<img src="images/logo.png" alt="Company Logo" style="width:151px; height=96px ">
					</div> 
					<hr>
					<div class="login-form">
						@include('alert')
						{{ Form::open(array('url' => Lang::get('routes.login'))) }}
							<input data-validate="required,email" type="email" name="user_email" placeholder="{{Lang::get('login.email_placeholder')}}">
							<input data-validate="required" type="password" name="user_password" placeholder="{{Lang::get('login.password_placeholder')}}"> 
							<button type="submit" class="btn btn-red">{{Lang::get('login.login')}}</button> 
						{{ Form::close() }}
						<div class="login-links"> 
							<a href="{{Lang::get('routes.forget_password')}}">
								{{Lang::get('login.forget_password')}}
							</a>
							<br>
							<a href="{{Lang::get('routes.register')}}">
								{{Lang::get('login.register')}}
							</a>
						</div>      		
					</div> 			        	
				</div>
			</div>
		</div>
	</div>
@stop
