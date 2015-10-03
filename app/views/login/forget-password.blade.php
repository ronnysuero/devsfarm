@extends('login.welcome')
@section('title', Lang::get('login_title.forget'))
@section('content')
<div class="col-lg-5">
	<h2 class=" animated bounceInDown">{{lang::get('register_student.reset_password')}}</h2>
	<div class="login-box  clearfix animated flipInY">
		<hr>
		<div class="login-form">
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
@stop
