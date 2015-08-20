@extends('university.master')
@section('title', Lang::get('university_title.add_teacher'))
@section('content')
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header"><i class="fa fa-plus"></i> {{Lang::get('register_teacher.register')}}</h1>
			<div class="row">
				<div class="col-lg-8 col-lg-offset-2">
					<div class="panel panel-default" id="crop-avatar">
						<div class="panel-heading">
							{{Lang::get('register_teacher.register')}}
						</div>
						@include('alert')
						<div class="panel-body">
							<div class="row">
								<div class="col-lg-12">
									{{ Form::open(array('url' => Lang::get('routes.add_teacher'), 'id' => 'form', 'role' => 'form','enctype' => 'multipart/form-data')) }}
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
										</div>
										<div class="form-group tooltip-bottom" data-tooltip="{{Lang::get('crop.change_avatar')}}" style="width:140px">
											<div id="photo_display" name="photo_display" class="avatar-view avatar-preview preview-lg" style="width:140px; height:140px">
												<img src="images/140x140.png" alt="Avatar">
											</div>
										</div>
										<button type="submit" class="btn btn-default pull-right">{{Lang::get('register_teacher.register')}}</button>
									{{ Form::close() }}
								</div>
							</div>
						</div>
						@include('crop')
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		$('document').ready(function() 
		{
			$("#crop").on("click", function()
			{
				$('#photo_display').html($('#preview').html());
				$('#avatar-modal').modal('hide');
			});
		});

		function generateEmail() 
		{
			var email = $('#email').val();
			var first_letter = $('#name').val().charAt(0);
			var last_name = $('#last_name').val().split(' ')[0];
			
			if (email == "")
			{
				email = first_letter + last_name;

				$.post("{{Lang::get('routes.generate_user')}}",
				{ 
					email: email 
				})
				.done(function( data )
				{
					$('#email').val(data);
				}); 
			}
		}
	</script>
@stop
