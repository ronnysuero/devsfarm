@extends('login.master')
@section('title', Lang::get('login_title.forget'))
@section('content')
	<div class="container" id="login-block">
		<div class="row">
			<div class="col-sm-6 col-md-4 col-sm-offset-3 col-md-offset-4">
				<h2 class=" animated bounceInDown">{{lang::get('register_student.reset_password')}}</h2>
				<div class="login-box  clearfix animated flipInY">
					<div class="login-logo">
						<img src="images/logo.png" alt="Company Logo" style="width:151px; height=96px ">
					</div> 
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
