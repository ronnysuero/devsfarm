@extends('student.master')
@section('title', 'Profile - Student')
@stop
@section('content')
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header"><i class="fa fa-user"></i>{{Lang::get("student_profile.mi_profile")}}</h1>
		<div class="panel panel-default">
			<div class="panel-heading">
				{{Lang::get("student_profile.information")}}
			</div>
			<div class="panel-body" id="crop-avatar">
				<div class="row">
					@include('alert')
					{{ Form::open(array('url' => Lang::get('routes.update_student'), 'enctype' => 'multipart/form-data', 'id' => 'form')) }}
						<div class="col-lg-3" style="overflow: hidden;">
							<div id="photo_display" name="photo_display" title="{{Lang::get('teacher_profile.teacher_photo')}}"
								 class="avatar-view avatar-preview preview-lg" style="width:140px; height:140px">
								@if(is_null($student->profile_image))
									<img src="images/140x140.png" alt="Avatar">
								@else
									<img src="{{Lang::get('show_image').'?src='.storage_path().$student->profile_image}}" alt="Avatar" />
								@endif
							</div>
						</div>
						<div class="col-lg-6" style="overflow: hidden;">
							<div class="form-group">
								<label>{{Lang::get("student_profile.name")}}</label>
								<input data-validate="required,size(3, 10),character" type="text" class="form-control" id="name" name="name" value="{{$student->name}}" required >
							</div>
							<div class="form-group">
								<label>{{Lang::get("student_profile.last_name")}}</label>
								<input data-validate="required,size(3, 10),character" type="text" class="form-control" id="last_name" name="last_name" value="{{$student->last_name}}" required>
							</div>
							<div class="form-group">
								<label>{{Lang::get("student_profile.nip")}}</label>
								<input data-validate="required,alphanumeric,size(6, 9)" type="text" class="form-control" id="nip" name="nip" value="{{$student->id_number}}" >
							</div>
							<div class="form-group">
								<label for="genre">{{Lang::get("student_profile.genre")}}</label>
								<select class="form-control" id="genre" name="genre">
									<option value="m">{{Lang::get("student_profile.male")}}</option>
									<option value="f">{{Lang::get("student_profile.female")}}</option>
									<option value="o">{{Lang::get("student_profile.other")}}</option>
								</select>
							</div>
							<div class="form-group">
								<label for="job">{{Lang::get("student_profile.job")}}</label>
								<select class="form-control" id="job" name="job">
									<option value="0">{{Lang::get("student_profile.no")}}</option>
									<option value="1">{{Lang::get("student_profile.yes")}}</option>
								</select>
							</div>
							<div class="form-group">
								<label>{{Lang::get("student_profile.email")}}</label>
								<input data-validate="required,email" type="email" class="form-control" id="email" name="email" value="{{$student->email}}" readonly>
							</div>
							<hr/>
							<a href="#" id="show_password_fields"><h5>{{Lang::get("student_profile.change_password")}}</h5></a>
							<hr/>
							<div id="password_fields" style="display: none;">
								<div class="form-group">
									<label>{{Lang::get('university_profile.current_password')}}</label>
									<input data-validate="required" class="form-control" id="current_password" name="current_password" type="password">
								</div>
								<div class="form-group">
									<label>{{Lang::get('university_profile.new_password')}}</label>
									<input data-validate="required,min(6),password(new_password, university_email),passwordEquals(new_password, current_password)" class="form-control" id="new_password" name="new_password" type="password">
								</div>
								<div class="form-group">
									<label>{{Lang::get('university_profile.confirm_new_password')}}</label>
									<input data-validate="required,min(6),verifyPassword(new_password, confirm_new_password)" class="form-control" id="confirm_new_password" name="confirm_new_password" type="password">
								</div>
							</div>
							<button type="submit" class="btn btn-default pull-right">{{Lang::get("student_profile.update")}}</button>
						</div>
					{{Form::close()}}
				</div>
				@include('crop')
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

		$("#show_password_fields").click(function() {
			$("#password_fields").toggle("slow");
		});

		$('#genre > option[value="{{$student->genre}}"]').attr('selected', 'selected');
		$('#job > option[value="{{$student->has_a_job}}"]').attr('selected', 'selected');
	});
</script>
@stop