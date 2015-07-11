@extends('login.master')
@stop
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
						{{ Form::open(array('url' => Lang::get('routes.reset_password'), 'class' => 'register_form', 'id' => 'register_form')) }}
						<input data-validate="required,min(6),password(password, email)" type="password" name="password" id="password" placeholder="{{Lang::get('register_student.password_placeholder')}}">
						<input data-validate="required,min(6),verifyPassword(password, confirm_password)" type="password" name="password_confirm" id="confirm_password" placeholder="{{Lang::get('register_student.confirm_password')}}"> 
						<button type="submit" class="btn btn-red btn-reset">{{lang::get('register_student.reset')}}</button> 
						<input type="hidden" id="email" value="{{$user->user}}"> 
						<input type="hidden" name="_id" value="{{$user->_id}}"> 
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