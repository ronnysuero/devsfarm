@extends('student.master')
@section('title', Lang::get('student_title.show_all_group'))
@section('content')
<div class="col-lg-12">
	<div class="row">
		<div class="col-lg-12">
            <h1 class="page-header"><i class="fa fa-group"></i> {{Lang::get('show_groups.my_groups')}}</h1>
			<div class="row">
				@if(count($groups) > 0)
					@foreach ($groups as $index => $group)
						<div class="col-lg-6 col-md-6">
							<div class="panel" style="background-color: {{ $colors[$index] }}; color: white;">
								<div class="panel-heading">
									<div class="row">
										<div class="col-xs-3">
											<i class="fa fa-group fa-5x"></i>
											<input type="hidden" value="{{storage_path()}}" id="url">
										</div>
										<div class="col-xs-9 text-right">
											<div class="huge">
												<a href="#" id="{{$group->_id}}" class="group_name" style="text-transform: none; color: white;">{{$group->name}}</a></div>
												<?php
													$sectionCode = SectionCode::find($group->section_code_id);
													$subject = Subject::find($sectionCode->subject_id);
													$section = $subject->sections()->find($sectionCode->section_id);
													$name = $subject->name.' - '.$section->code;
												?>
												<div>
													<span style="text-transform: uppercase;">{{$name}}</span>
												</div>
										</div>
									</div>
								</div>
								<div class="panel-footer" style="color: #000000;">
                                    <?php $students = Student::whereIn('_id', $group->students_id)->get(); ?>
                                    @foreach ($students as $user)
                                        @if(strcmp($group->teamleader_id, $user->_id) === 0)
                                            {{$user->name.' '.$user->last_name.' ('.Lang::get('teamleader.tm').')'}}
                                        @else
                                            {{$user->name.' '.$user->last_name}}
                                        @endif
                                        <a onclick="fillModal('{{$user->_id}}')" href="#" data-toggle="modal" data-target="#studentDetailsModal">
                                            <i class="fa fa-external-link"></i></a>
                                        <br>
                                    @endforeach
                                        {{ Form::open(array('url' => Lang::get('routes.show_all_assignment'), 'id' => 'form_group')) }}
                                        <div class="form-group">
                                            <input type="hidden" id="group_code", name="group_code" value="">
                                        </div>
                                        {{Form::close()}}
								</div>
							</div>
						</div>
					@endforeach
				@else
                    <div class="col-lg-12">
					<p>
						<a href="{{Lang::get('routes.add_group')}}">
							<i class="fa fa-plus" style="color: #0097A7;"></i>
							{{Lang::get('register_group.add_group')}}
						</a>
					</p>
                    </div>
				@endif
			</div>
		</div>
	</div>
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
								<tr><th>{{Lang::get('student_profile.name')}}</th><td id="name" name="name"></td></tr>
								<tr><th>{{Lang::get('student_profile.nip')}}</th><td id="last_name" name="last_name"></td></tr>
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
		function fillModal(id) 
		{
			var yes = "{{Lang::get('student_profile.yes')}}",
				no = "{{Lang::get('student_profile.no')}}",
				male = "{{Lang::get('student_profile.male')}}",
				female = "{{Lang::get('student_profile.female')}}",
				other = "{{Lang::get('student_profile.other')}}",
				genre = "";

			$.post("{{Lang::get('routes.find_student')}}",
			{
				id: id 
			})
			.done(function( data ) 
			{
				$("#name").html(data.name);
				$("#last_name").html(data.last_name);
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


	    $('.group_name').on('click', function(){
	        $("#group_code").val( $(this).attr('id') );
	        $("#form_group").submit();
	    });
	</script>
@stop
