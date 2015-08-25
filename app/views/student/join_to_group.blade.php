@extends('student.master')
@section('title', Lang::get('student_title.join'))
@section('content')
	<div class="row">
		@if (count($pending) > 0)
			<h1 class="page-header"><i class="fa fa-plus"></i> {{Lang::get('register_group.approve_title')}}</h1>
			<div class="table-responsive">
				<table id="tableOrder" class="table table-striped table-bordered table-hover tablesorter">
					<thead>
						<tr>
							<th>#</th>
							<th>{{Lang::get('register_group.subject')}}</th>
							<th>{{Lang::get('register_group.section')}}</th>
							<th>{{Lang::get('register_group.teamleader')}}</th>
							<th>{{Lang::get('register_group.cancel')}}</th>
						</tr>
					</thead>
					<tbody>
						@foreach($pending as $index => $item)
							<?php 
								$group = Group::find($item->group_id);
								$section_code = SectionCode::find($item->section_code_id);
								$subject = Subject::find($section_code->subject_id);
								$section = $subject->sections()->find($section_code->section_id);
								$student = Student::find($group->teamleader_id); 
							?>
							<tr id="{{$index}}">
								<td>{{$index+1}}</td>
								<td>{{$subject->name}}</td>
								<td>{{$section->code}}</td>
								<td>{{$student->name.' '.$student->last_name}}</td>
								<td style="width: 6%">
									<a onclick="$('#enrollId').val('{{$item->_id}}');$('#tr').val({{$index}});" class="pull-right">
										<i class="fa fa-trash-o" data-toggle="modal" data-target="#deleteModal" style="color:#d9534f;"></i>
									</a>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="Eliminar profesor" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title" id="Eliminar peticion"><i class="fa fa-trash-o"></i> {{Lang::get('register_group.drop_enroll')}}</h4>
						</div>
						<div class="modal-body">
							{{Lang::get('register_group.drop_join')}}
						</div>
						<input type="hidden" value="" id="enrollId">
						<input type="hidden" value="" id="tr" />
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">{{Lang::get('list_teacher.cancel')}}</button>
							<button onclick="dropEnroll();" type="button" class="btn btn-primary">{{Lang::get('list_teacher.disable')}}</button>
						</div>
					</div>
				</div>
			</div>
			<br />	
		@endif
		<div class="col-lg-12">
			<h1 class="page-header"><i class="fa fa-plus"></i> {{Lang::get('join_to_group.joinHeading')}}</h1>
			<div class="row">
				<div class="col-lg-8 col-lg-offset-2">
					<div class="panel panel-default">
						<div class="panel-heading">
							{{Lang::get('join_to_group.joinHeading')}}
						</div>
						@include('alert')
						<div class="panel-body">
							<div class="row">
								<div class="col-lg-12">
									{{ Form::open(array('url' => Lang::get('routes.join_to_group'), 'id' => 'register_form', 'role' => 'form','enctype' => 'multipart/form-data')) }}
										<div class="form-group">
											<label>{{Lang::get('register_group.Code_secction')}}</label>
											<select data-validate="required" class="form-control" id="section" name="section">
												<option value="">{{Lang::get('register_group.sectionCode_placeholer')}}</option>
												@foreach($sections as $id => $section)
													<option value="{{ $id }}">{{ $section }}</option>
												@endforeach
											</select>
										</div>
										<div class="form-group">
											<label>{{Lang::get('join_to_group.groups')}}</label>
											<select data-validate="required" class="form-control" id="group" name="group">
												<option value="">{{Lang::get('join_to_group.group_placeholder')}}</option>
											</select>
										</div>
										<button type="submit" class="btn btn-default pull-right">{{Lang::get('join_to_group.join')}}</button>
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
		$('document').ready(function()
		{
			$('#section').on('change', function()
			{
				if($('#section').val() !== "")
				{
					$.post("{{Lang::get('routes.find_Group_By_Section')}}",
					{ 
						section_code: $('#section').val() 
					})
					.done(function( data )
					{
						var message = "";

						if(data === "")
							message = '<option value="">{{Lang::get("join_to_group.no_record")}}</option>';
						else
							message = '<option value="">{{Lang::get("join_to_group.group_placeholder")}}</option>';

						$('#group')
							.find('option')
							.remove()
							.end()
							.append(message);

						if(data !== "")
						{
							for(var item in data.groups)
								$('#group').append( new Option(data.groups[item].name, data.groups[item]._id) );

							$('#_id').val(data.subject);
						}
					});
				}
				else
				{
					$('#group')
							.find('option')
							.remove()
							.end();
					
					$('#group').html('<option value="">{{Lang::get("join_to_group.group_placeholder")}} </option>');
				}
			});
		});

		function dropEnroll()
		{
			$.post("{{Lang::get('routes.drop_join')}}",
			{ 
				id: $('#enrollId').val(),
			})
			.done(function( data ) 
			{
				if(data === '00')
				{
					$('#' + $('#tr').val()).remove();
					$('#deleteModal').modal('hide');
				}
			});
		}
	</script>
@stop
