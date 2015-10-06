@extends('teacher.master')
@section('title', Lang::get('teacher_title.subject'))
@section('content')
	<div class="row" style="color: #000000;">
		<h1 class="page-header"><i class="fa fa-group"></i> {{ Lang::get('teacher_section_groups.section_groups_header') }}</h1>
		<div class="col-lg-12">
			<div class="row">
				@if(count($groups) > 0)
					@foreach($groups as $index => $group)
						<div class="col-lg-6">
							<div class="panel" style="background-color: {{ $colors[$index] }}; color: white;">
								<div class="panel-heading">
									<div class="row">
										<div class="col-xs-3">
											<i class="fa fa-group fa-5x"></i>
										</div>
										<div class="col-xs-9 text-right">
											<div class="huge">{{ $group->name }}</div>
											<div>{{ strtoupper($group->project_name) }}</div>
										</div>
									</div>
								</div>
								<div class="panel-footer" style="color: #000000;">
									@foreach($group->students_id as $student)
										<?php $member = Student::find($student); ?>
										{{ $member->name.' '.$member->last_name }}
										@if($student == $group->teamleader_id)
												- TeamLeader
										@endif
										<a href="#" onclick="fillModal('{{$member->email}}')" data-toggle="modal" data-target="#studentDetailsModal">
										<i class="fa fa-external-link"></i></a><br>
									@endforeach
									<br><br>
									<a href="#" class="show_group_detail" id="{{ $group->_id  }}">
										<span class="pull-left">
											{{ Lang::get('teacher_section_groups.show_details') }}
										</span>
										<span class="pull-right">
											<i class="fa fa-arrow-circle-right"></i>
										</span>
										<div class="clearfix"></div>
									</a>
								</div>
							</div>
						</div>
					@endforeach
					<input type="hidden" value="{{storage_path()}}" id="url">
				@else
					<h4>{{ Lang::get('teacher_section_groups.no_groups') }}</h4>
				@endif
			</div>
		</div>
	</div>
	{{ Form::open(array('url' => Lang::get('routes.get_farm_report'), 'id' => 'form_groups_report', 'class' => 'hide')) }}
		<div class="form-group">
			<input type="text" class="form-control" id="group_id" name="group_id" value="">
		</div>
	{{Form::close()}}
	<div class="modal fade" id="studentDetailsModal" tabindex="-1" role="dialog" aria-labelledby="Register University" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="myModalLabel" style="color: #26A69A;"><i class="fa fa-eye"></i> {{Lang::get('show_groups.information')}} </h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div id="photo_display" class="col-lg-3">
							<img src="images/140x140.png" alt="Avatar">
						</div>
						<div class="col-lg-8" style="margin-left: 10px; font-size: 1.2em;">
							<table class="table">
								<tr><th>{{Lang::get('student_profile.name')}}</th><td id="name2" name="name2"></td></tr>
								<tr><th>{{Lang::get('student_profile.nip')}}</th><td id="last_name2" name="last_name2"></td></tr>
								<tr><th>{{Lang::get('student_profile.email')}}</th> <td id="mail" name="mail"></td></tr>
								<tr><th>{{Lang::get('student_profile.job')}}</th> <td id="job" name="job"></td></tr>
								<tr><th>{{Lang::get('student_profile.genre')}}</th> <td id="genre" name="genre"></td></tr>
							</table>
						</div>
					</div>
					<hr/>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		function fillModal (email) 
		{
			var yes = "{{Lang::get('student_profile.yes')}}",
				no = "{{Lang::get('student_profile.no')}}",
				male = "{{Lang::get('student_profile.male')}}",
				female = "{{Lang::get('student_profile.female')}}",
				other = "{{Lang::get('student_profile.other')}}",
				genre = "";

			$.post("{{Lang::get('routes.find_member_information')}}",
			{
				email:email
			})
			.done(function( data ) 
			{
				$("#name2").html(data.name);
				$("#last_name2").html(data.last_name);
				$('#mail').html(data.email);
				$("#job").html((data.has_a_job == 1) ? yes : no);

				if(data.genre == 'm')
					genre = male;
				else if (data.genre == 'f')
					genre = female;
				else if (data.genre == 'o')
					genre = other;

				$("#genre").html(genre);

				if(data.profile_image != null)
					$('#photo_display').html('<img src="{{Lang::get("show_image")."?src="}}' + $('#url').val() + data.profile_image + '" alt="Avatar" >');
				else
					$('#photo_display').html('<img src="images/140x140.png" alt="Avatar" >');
			});
		}

		$(".show_group_detail").on("click", function()
		{
			var group = $(this).attr("id");
			$("#group_id").val(group);
			$("#form_groups_report").submit();
		});
	</script>
@stop
