@extends('university.master')
@section('title', Lang::get('university_profile.title'))
@stop
@section('content')
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">{{Lang::get('university_profile.profile')}}</h1>
		<div class="panel panel-default">
			<div class="panel-heading">
				{{Lang::get('university_profile.profile')}}
			</div>
			<div class="panel-body" id="crop-avatar">
				<div class="row">
					@include('alert')
					{{ Form::open(array('url' => Lang::get('routes.update_university'), 'enctype' => 'multipart/form-data', 'id' => 'form')) }}
						<div class="col-lg-2" style="overflow: hidden;">
							<div id="photo_display" name="photo_display" title="{{Lang::get('crop.change_avatar')}}" class="avatar-view avatar-preview preview-lg" style="width:140px; height:140px">
								@if($university->profile_image == null)
									<img src="images/140x140.png" alt="Avatar">
								@else
									<img src="{{Lang::get('show_image').'?src='.storage_path().$university->profile_image}}" alt="Avatar" />
								@endif	
							</div>					
						</div>
						<div class="col-lg-6" style="overflow: hidden;">
							<div class="form-group">
								<label>{{Lang::get('university_profile.name')}}</label>
								<input data-validate="required,size(5, 40),characterspace" class="form-control" id="university_name" name="university_name" value="{{$university->name}}" >
							</div>
							<div class="form-group">
								<label>{{Lang::get('university_profile.acronym')}}</label>
								<input data-validate="required,size(3, 10),character" class="form-control"  value= "{{$university->acronym}}" id="university_acronym" name="university_acronym" >
							</div>
							<div class="form-group">
								<label>{{Lang::get('university_profile.email')}}</label>
								<input data-validate="required,email" class="form-control" id="university_email" name="university_email"
	                                   value="{{$university->email}}" readonly>
							</div>
							<hr/>
							<a href="#" id="show_password_fields"><h5>{{Lang::get('university_profile.change_password')}}</h5></a>
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
							<button type="submit" class="btn btn-default pull-right">{{Lang::get('university_profile.update')}}</button>
						</div>
                    {{Form::close()}}
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

		$("#show_password_fields").click(function(){
			$("#password_fields").toggle("slow");
		});
	});
</script>
@stop