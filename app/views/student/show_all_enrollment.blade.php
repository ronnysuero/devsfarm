@extends('student.master')
@section('title', Lang::get('student_title.join_section'))
@section('content')
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">
				<i class="fa fa-compress"></i> {{Lang::get('student_master.join_subject')}}
			</h1>
			<div class="panel-body">
				@include('alert')
				<p>
					<a href="#" id="enroll">
						<i class="fa fa-plus" style="color: #0097A7;"></i> 
						{{Lang::get('list_enroll.add')}}
					</a>
				</p>
				<br />
				@if (count($pending) > 0)
					<h4>{{Lang::get('register_group.approve_title')}}</h4>
					<div class="table-responsive">
						<table id="tableOrder" class="table table-striped table-bordered table-hover tablesorter">
							<thead>
								<tr>
									<th>#</th>
									<th>{{Lang::get('register_group.subject')}}</th>
									<th>{{Lang::get('register_group.section')}}</th>
									<th>{{Lang::get('register_group.section_code')}}</th>
									<th>{{Lang::get('register_group.teacher')}}</th>
									<th>{{Lang::get('register_group.cancel')}}</th>
								</tr>
							</thead>
							<tbody>
								@foreach($pending as $index => $item)
									<?php 
										$section_code = SectionCode::find($item->section_code_id);
										$subject = Subject::find($section_code->subject_id);
										$section = $subject->sections()->find($section_code->section_id);
										$teacher = Teacher::find($section_code->teacher_id); 
									?>
									<tr>
										<td>{{$index+1}}</td>
										<td>{{$subject->name}}</td>
										<td>{{$section->code}}</td>
										<td>{{$section_code->code}}</td>
										<td>{{$teacher->name.' '.$teacher->last_name}}</td>
										<td style="width: 6%">
											<a onclick="$('#enrollId').val('{{$item->_id}}');" class="pull-right">
												<i class="fa fa-trash-o" data-toggle="modal" data-target="#deleteModal" style="color:#d9534f;"></i>
											</a>
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
					<br />	
				@endif
				@if (count($sections) > 0)
					<h4>{{Lang::get('register_group.active')}}</h4>
					<div class="table-responsive">
						<table id="tableOrder" class="table table-striped table-bordered table-hover tablesorter">
							<thead>
								<tr>
									<th>#</th>
									<th>{{Lang::get('register_group.subject')}}</th>
									<th>{{Lang::get('register_group.section')}}</th>
									<th>{{Lang::get('register_group.section_code')}}</th>
									<th>{{Lang::get('register_group.teacher')}}</th>
								</tr>
							</thead>
							<tbody>
								@foreach($sections as $index => $section_code)
									<?php 
										$subject = Subject::find($section_code->subject_id);
										$section = $subject->sections()->find($section_code->section_id);
										$teacher = Teacher::find($section_code->teacher_id); 
									?>
									<tr>
										<td>{{$index+1}}</td>
										<td>{{$subject->name}}</td>
										<td>{{$section->code}}</td>
										<td>{{$section_code->code}}</td>
										<td>{{$teacher->name.' '.$teacher->last_name}}</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>	
				@endif
				<div class="modal fade" id="enrollModal" tabindex="-1" role="dialog" aria-labelledby="Enviar mensaje" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h4 class="modal-title" id="Enviar mensaje"><i class="fa fa-send"></i> {{Lang::get('student_master.join_subject')}}</h4>
							</div>
							{{ Form::open(array('url' => Lang::get('routes.enroll_section'), 'id' => 'enrollSectionForm')) }}
								<div class="modal-body">
									<div id="alert"></div>
									<div class="form-group">
										<label>{{Lang::get('join_to_group.section_code')}}</label>
										<input data-validate="required,min(5)" class="form-control" id="code" name="code" placeholder="{{Lang::get('join_to_group.section_placeholder')}}">
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">
										{{Lang::get('list_teacher.cancel')}}
									</button>
									<button type="submit" class="btn btn-primary pull-right" >
										{{Lang::get('student_master.join_subject')}} 
									</button>
								</div>
							{{ Form::close() }}
						</div>
					</div>
				</div>
				<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="Eliminar profesor" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h4 class="modal-title" id="Eliminar peticion"><i class="fa fa-trash-o"></i> {{Lang::get('register_group.drop_enroll')}}</h4>
							</div>
							<div class="modal-body">
								{{Lang::get('register_group.drop_message')}}
							</div>
							<input type="hidden" value="" id="enrollId" />
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">{{Lang::get('list_teacher.cancel')}}</button>
								<button onclick="dropEnroll();" type="button" class="btn btn-primary">{{Lang::get('list_teacher.disable')}}</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">

		$(document).ready(function() 
		{
			$('#enroll').on('click', function()
			{
				$('#enrollModal').modal('show');
			});	
		});

		function dropEnroll()
		{
			$.post("{{Lang::get('routes.drop_enroll')}}",
			{ 
				id: $('#enrollId').val(),
			})
			.done(function( data ) 
			{
				if(data === '00')
					location.reload();
			});
		}
	</script>
@stop
