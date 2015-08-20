@extends('student.master')
@stop
@section('content')
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header"><i class="fa fa-plus"></i> {{Lang::get('register_group.register')}}</h1>
		 <div class="row">
			<div class="col-lg-8 col-lg-offset-2">
				<div class="panel panel-default">
					<div class="panel-heading">
						{{Lang::get('register_group.register')}}
					</div>
					@include('alert')
					<div class="panel-body" id="crop-avatar">
						<div class="row">
							<div class="col-lg-12">
								{{ Form::open(array('url' => Lang::get('routes.register_group'), 'id' => 'register_form', 'role' => 'form','enctype' => 'multipart/form-data')) }}
								<div class="form-group">
									<label>{{Lang::get('register_group.name')}}</label>
									<input data-validate="required,size(3, 20),characterspace" type="text" class="form-control" id="name" name="name" placeholder="{{Lang::get('register_group.name_placeholder')}}" >
								</div>

								<div class="form-group">
									<label>{{Lang::get('register_group.Code_secction')}}</label>
									<input data-validate="required,size(3, 20)" type="text" class="form-control" id="sectionCode" name="sectionCode" placeholder="{{Lang::get('register_group.sectionCode_placeholer')}}" >
								</div>

								<div class="form-group">
									<label>{{Lang::get('register_group.project_name')}}</label>
									<input data-validate="required,size(3, 50),characterspace" type="text" class="form-control" id="project_name" name="project_name" placeholder="{{Lang::get('register_group.name_placeholder')}}" >
								</div>

								<div class="form-group tooltip-bottom" data-tooltip="{{Lang::get('crop.change_avatar')}}" style="width:140px">
									<div id="photo_display" name="photo_display" class="avatar-view avatar-preview preview-lg" style="width:140px; height:140px">
										<img src="images/140x140.png" alt="Avatar">
									</div>
								</div>

								<button type="submit" class="btn btn-default pull-right">{{Lang::get('register_group.register')}}</button>
								{{ Form::close() }}
							</div>
						</div>
						@include('crop')
					</div>
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
</script>
@stop
