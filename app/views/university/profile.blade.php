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
					<div class="col-lg-2" style="overflow: hidden;" title="Change the avatar">
						<div id="photo_display" name="photo_display" class="avatar-view avatar-preview preview-lg" style="width:140px; height:140px">
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
							<input data-validate="required,email" class="form-control" id="university_email" name="university_email" value="{{$university->email}}">
						</div>
						<hr/>
						<a href="#" id="show_password_fields"><h5>{{Lang::get('university_profile.change_password')}}</h5></a>
						<hr/>
						<div id="password_fields" style="display: none;">
							<div class="form-group">
								<label>{{Lang::get('university_profile.current_password')}}</label>
								<input data-validate="required,password" class="form-control" id="current_password" name="current_password">
							</div>
							<div class="form-group">
								<label>{{Lang::get('university_profile.new_password')}}</label>
								<input data-validate="required,password" class="form-control" id="new_password" name="new_password">
							</div>
							<div class="form-group">
								<label>{{Lang::get('university_profile.confirm_new_password')}}</label>
								<input data-validate="required,password" class="form-control" id="confirm_new_password" name="confirm_new_password">
							</div>
						</div>
						<button type="submit" class="btn btn-default pull-right">{{Lang::get('university_profile.update')}}</button>
					</div>
					{{Form::close()}}
				</div>
				<div class="modal fade" id="avatar-modal" aria-hidden="true" aria-labelledby="avatar-modal-label" role="dialog" tabindex="-1" >
					<div class="modal-dialog modal-lg" style="width:700px">
						<div class="modal-content">
							<div class="avatar-form">
								<div class="modal-header">
									<button class="close" data-dismiss="modal" type="button">&times;</button>
									<h4 class="modal-title" id="avatar-modal-label">Change Avatar</h4>
								</div>
								<div class="modal-body">
									<div class="avatar-body">
										<div class="avatar-upload">
											<input form="form" class="avatar-src" name="avatar_src" type="hidden">
											<input form="form" class="avatar-data" name="avatar_data" type="hidden">
											<label for="avatarInput">Busque el archivo</label>
											<input form="form" data-validate="image" class="avatar-input" id="avatarInput" name="avatar_file" type="file" accept="image/x-png, image/gif, image/jpeg">
										</div>
										<div class="row">
											<div class="col-md-9">
												<div class="avatar-wrapper"></div>
											</div>
											<div class="col-md-2">
												<div id="preview" style="width:140px; height:140px" class="avatar-preview preview-lg"></div>
											</div>
										</div>
										<div class="row avatar-btns">
											<div class="col-md-9">
											</div>
											<div class="col-md-3">
												<button id="crop" class="btn btn-primary btn-block avatar-save" type="submit">Done</button>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
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