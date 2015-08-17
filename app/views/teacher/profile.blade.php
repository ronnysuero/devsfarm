@extends('teacher.master')
@section('title', Lang::get("teacher_profile.title") )
@section('content')
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header"><i class="fa fa-user"></i> {{Lang::get('teacher_profile.profile')}}</h1>
		<div class="panel panel-default">
			<div class="panel-heading">
				{{Lang::get('teacher_profile.profile')}}
			</div>
			<div class="panel-body" id="crop-avatar">
				<div class="row">
					@include('alert')
					<div class="col-lg-3" style="overflow: hidden;">
						<div id="photo_display" name="photo_display" title="{{Lang::get('teacher_profile.teacher_photo')}}"
							 class="avatar-view avatar-preview preview-lg" style="width:140px; height:140px">
							@if($teacher->profile_image == null)
								<img src="images/140x140.png" alt="Avatar">
							@else
								<img src="{{Lang::get('show_image').'?src='.storage_path().$teacher->profile_image}}" alt="Avatar" />
							@endif
						</div>
					</div>
					<div class="col-lg-6" style="overflow: hidden;">
						{{ Form::open(array('url' => Lang::get('routes.update_teacher'), 'enctype' => 'multipart/form-data', 'id' => 'form')) }}
							<div class="form-group">
								<label>{{Lang::get('teacher_profile.teacher_name')}}</label>
								<input type="text" class="form-control" id="teacher_name" name="teacher_name"
									   placeholder="Nombres" value="{{$teacher->name}}" required>
							</div>
							<div class="form-group">
								<label>{{Lang::get('teacher_profile.teacher_last_name')}}</label>
								<input type="text" class="form-control" id="teacher_last_name" name="teacher_last_name"
									   placeholder="Apellidos" value="{{$teacher->last_name}}" required>
							</div>
							<div class="form-group">
								<label>{{Lang::get('teacher_profile.teacher_phone')}}</label>
								<input type="text" class="form-control" id="teacher_phone" name="teacher_phone"
									   placeholder="Telefono" value="{{$teacher->phone}}">
							</div>
							<div class="form-group">
								<label>{{Lang::get('teacher_profile.teacher_cellphone')}}</label>
								<input type="text" class="form-control" id="teacher_cellphone" name="teacher_cellphone"
									   placeholder="Celular" value="{{$teacher->cellphone}}">
							</div>
							<div class="form-group">
								<label>{{Lang::get('teacher_profile.teacher_email')}}</label>
								<input type="email" class="form-control" id="teacher_email" name="teacher_email"
									   placeholder="Email" value="{{$teacher->email}}" readonly required>
							</div>

							<hr/>
							<a href="#" id="show_password_fields"><h5>{{Lang::get('teacher_profile.change_password')}}</h5></a>
							<hr/>
							<div id="password_fields" style="display: none;">
								<div class="form-group">
									<label>{{Lang::get('teacher_profile.current_password')}}</label>
									<input data-validate="required,password" class="form-control" id="current_password" name="current_password" type="password">
								</div>
								<div class="form-group">
									<label>{{Lang::get('teacher_profile.new_password')}}</label>
									<input data-validate="required,password" class="form-control" id="new_password" name="new_password" type="password">
								</div>
								<div class="form-group">
									<label>{{Lang::get('teacher_profile.confirm_new_password')}}</label>
									<input data-validate="required,min(6),verifyPassword(new_password, confirm_new_password)"
										   class="form-control" id="confirm_new_password" name="confirm_new_password" type="password">
								</div>
							</div>
							<button type="submit" class="btn btn-default pull-right">{{Lang::get('teacher_profile.update')}}</button>
						{{Form::close()}}
					</div>
				</div>
				@include('crop')
			</div>
		</div>
	</div>
</div>
<script>
	$('document').ready(function()
	{
		$("#crop").on("click", function()
		{
			$('#photo_display').html($('#preview').html());
			$('#avatar-modal').modal('hide');
		});

		$("#show_password_fields").click(function()
		{
			$("#password_fields").toggle("slow");
		});
	});
</script>
@stop