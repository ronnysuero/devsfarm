@extends('university.master')
@section('content')
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header"><i class="fa fa-plus"></i> {{Lang::get('register_teacher.register')}}</h1>
		<div class="row">
			<div class="col-lg-8 col-lg-offset-2">
				<div class="panel panel-default">
					<div class="panel-heading">
						{{Lang::get('register_teacher.register')}}
					</div>
					@include('alert')
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-12">
								{{ Form::open(array('url' => Lang::get('routes.add_teacher'), 'id' => 'register_form', 'role' => 'form','enctype' => 'multipart/form-data')) }}
								<div class="form-group">
									<label>{{Lang::get('register_teacher.name')}}</label>
									<input data-validate="required,size(3, 20),characterspace" type="text" class="form-control" id="name" name="name" placeholder="{{Lang::get('register_teacher.name_placeholder')}}" >
								</div>
								<div class="form-group">
									<label>{{Lang::get('register_teacher.last_name')}}</label>
									<input data-validate="required,size(3, 20),characterspace" type="text" class="form-control" id="last_name" name="last_name" placeholder="{{Lang::get('register_teacher.last_name_placeholder')}}" >
								</div>
								<div class="form-group">
									<label>{{Lang::get('register_teacher.phone')}}</label>
									<input data-validate="required,phone" type="text" class="form-control" id="phone" name="phone" placeholder="{{Lang::get('register_teacher.phone_placeholder')}}">
								</div>
								<div class="form-group">
									<label>{{Lang::get('register_teacher.cellphone')}}</label>
									<input data-validate="required,phone" type="text" class="form-control" id="cellphone" name="cellphone" placeholder="{{Lang::get('register_teacher.cellphone_placeholder')}}">
								</div>
								<div class="form-group">
									<label>{{Lang::get('register_teacher.email')}}</label>
									<input onfocus="generateEmail()" data-validate="required,email" type="email" class="form-control" id="email" name="email" placeholder="{{Lang::get('register_teacher.email_placeholder')}}" >
								</div>
								<div class="form-group">
									<label>{{Lang::get('register_teacher.photo')}}</label>
									<input data-validate="image" type="file" id="photo" name="photo" accept="image/x-png, image/gif, image/jpeg" onchange="PreviewImage()">
								</div>
								<div class="form-group">
									<img src="images/140x140.png" alt="" style="width: 140px; height: 140px;" id="photo_display" name="photo_display">
								</div>
								<input type="hidden" id="domain" value="{{substr(Auth::user()->user, strpos(Auth::user()->user, '@')+1)}}">
								<button type="submit" class="btn btn-default pull-right">{{Lang::get('register_teacher.register')}}</button>
								{{ Form::close() }}
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	function generateEmail() 
	{
		var email = $('#email').val();
		var first_letter = $('#name').val().charAt(0);
		var last_name = $('#last_name').val().split(' ')[0];

		if (email == "")
		{
			email = first_letter + last_name + '@' + $('#domain').val();
			$('#email').val(email.toLowerCase());
		}
	}
</script>
@stop
