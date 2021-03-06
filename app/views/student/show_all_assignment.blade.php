@extends('student.master')
@section('title', Lang::get('student_title.show_all_assignment'))
@section('content')
<div class="col-lg-12">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">
				<i class="fa fa-th-large"></i>
				{{$group->name}}
			</h1>
			<p>
				<?php $flag = SectionCodeController::confirmTeamLeader($group->teamleader_id, $group->section_code_id) ?>
				@if(strcasecmp($group->teamleader_id, Auth::id()) === 0 && $flag)
					<a href="#" data-toggle="modal" data-target="#registerModal">
						<i class="fa fa-plus" style="color: #0097A7;"></i> 
						{{Lang::get('register_assignment.add')}}
					</a>
				@endif
			</p>
			<br />
			@include('alert')	
			@if(count($assignments) > 0)
				<h4>{{Lang::get('register_assignment.assignment')}}</h4>
				<div class="table-responsive">
					<table id="tableOrder" class="table table-striped table-bordered table-hover tablesorter">
						<thead>
							<tr>
								<th>#</th>
								<th>{{Lang::get('list_assignment.description')}}</th>
								<th>{{Lang::get('register_assignment.date_assigned')}}</th>
								<th>{{Lang::get('list_assignment.deadline')}}</th>
								<th>{{Lang::get('list_assignment.assigned_to')}}</th>
								<th>{{Lang::get('list_assignment.state')}}</th>
								<th>{{Lang::get('list_assignment.score')}}</th>
								<th>{{Lang::get('list_assignment.rated')}}</th>

								@if(strcasecmp($group->teamleader_id, Auth::id()) === 0 && $flag)
									<th>{{Lang::get('register_assignment.rate')}}</th>
									<th>{{Lang::get('register_assignment.edit')}}</th>
									<th>{{Lang::get('register_assignment.delete')}}</th>
									<th>{{Lang::get('register_assignment.re_assigned')}}</th>
								@endif

								<th>{{Lang::get('register_assignment.send')}}</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($assignments as $index => $assignment)
								<?php $assigned_to = Student::find($assignment->assigned_to); ?>

								<tr id="{{$index}}">
									<td>{{$index + 1}}</td>
									<td>{{$assignment->description}}</td>
									<td>{{date('d-m-Y',$assignment->date_assigned->sec)}}</td>
									<td>{{date('d-m-Y',$assignment->deadline->sec)}}</td>
									<td>
										{{$assigned_to->name.' '.$assigned_to->last_name}}
										{{'('.$assigned_to->id_number.')'}}
									</td>
									<td>{{Lang::get('register_assignment.'.$assignment->state)}}</td>
									<td>{{$assignment->score}}</td>
									<td>{{$assignment->rated}}</td>
									
									@if(strcasecmp($group->teamleader_id, Auth::id()) === 0 && $flag)
										<td style="width: 6%">
											@if(strcasecmp($assignment->state, 'p') === 0)
												<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#ratedModal" onclick="$('#scoreRated').val('{{$assignment->score}}'); $('#assignment_id').val('{{$assignment->_id}}');"> 
													{{Lang::get('register_assignment.rate')}}
												</button>
											@endif
										</td>
										<td style="width: 6%"> 
											@if(strcasecmp($assignment->state, 'a') === 0 || strcasecmp($assignment->state, 'r') === 0)
												<button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModal" onclick="findAssignment('{{$assignment->_id}}');"> 
													{{Lang::get('show_groups.btnedit')}}
												</button>
											@endif
										</td>
										<td style="width: 6%">
											@if(strcasecmp($assignment->state, 'a') === 0 || strcasecmp($assignment->state, 'r') === 0)
												<button type="button" class="btn btn-danger btn-sm " data-toggle="modal" data-target="#deleteModal" onclick="$('#_id').val('{{$assignment->_id}}'); $('#tr').val('{{$index}}');">
													{{Lang::get('register_assignment.delete')}}
												</button>
											@endif
										</td>
										<td style="width: 6%">
											@if(strcasecmp($assignment->state, 'n') === 0) 
												<button type="button" data-toggle="modal" data-target="#reassignedModal" class="btn btn-info btn-sm" onclick="findReAssignment('{{$assignment->_id}}');"> 
													{{Lang::get('register_assignment.re_assigned')}}
												</button>
											@endif
										</td>
									@endif
									<td style="width: 4%">
										@if(strcasecmp($assignment->assigned_to, Auth::id()) === 0)
											@if(strcasecmp($assignment->state, 'a') === 0 || strcasecmp($assignment->state, 'r') === 0)
												<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#completeModal" onclick="$('#taskupdate').val('{{$assignment->_id}}')"> 
													{{Lang::get('register_assignment.send')}}
												</button>
											@elseif(AssignmentController::enableViewDetailBtn($assignment))
												<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#viewDetailModal" onclick="viewAssignment('{{$assignment->_id}}')"> 
													{{Lang::get('register_assignment.view_details')}}
												</button>
											@endif
										@elseif(strcasecmp($assignment->state, 'c') === 0 || strcasecmp($assignment->state, 'n') === 0 || strcasecmp($assignment->state, 'nc') === 0)
											@if(AssignmentController::enableViewDetailBtn($assignment))
												<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#viewDetailModal" onclick="viewAssignment('{{$assignment->_id}}')"> 
													{{Lang::get('register_assignment.view_details')}}
												</button>
											@endif
										@endif
									</td>
								</tr>
							@endforeach
						</tbody>  
					</table>
				</div>
			@else
				@if(strcasecmp($group->teamleader_id, Auth::id()) != 0)
					<p>{{Lang::get('register_assignment.no_assigned')}}</p>
				@endif
			@endif
		</div>
	</div>
	@if(strcasecmp($group->teamleader_id, Auth::id()) === 0 && $flag)
		<div class="modal fade" id="registerModal">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="modal-title">
							<i class="fa fa-plus"></i>
							{{Lang::get("register_assignment.registerAssignment")}}
						</h4>
					</div>
					<div class="modal-body">
						{{ Form::open(array('url' => Lang::get('routes.register_assignment'), 'id' => 'register_form', 'role' => 'form')) }}
							<div class="form-group">
								<label>
									{{Lang::get('register_assignment.description')}}
								</label>
								<input data-validate="required,size(3, 50),characterspace" type="text" class="form-control" id="description" name="description" placeholder="{{Lang::get('register_assignment.description_placeholder')}}" >
							</div>
							<div class="form-group">
								<label>{{Lang::get('register_assignment.assignmentTo')}}</label>
								<select data-validate="required" class="form-control" id="students" name="students">
									<option value="">{{Lang::get('show_groups.student_placehold')}}</option>
									@foreach ($students as $student) 
										<option value="{{$student->_id}}">
											{{$student->name.' '.$student->last_name.' ('.$student->id_number.')'}}
										</option>
									@endforeach
								</select>
							</div>
							<div class="form-group">
								<label>{{Lang::get('register_assignment.deadline')}}</label>
								<input data-validate="required,date" type="text" class="form-control" id="deadline" name="deadline" placeholder="" value="{{date('Y-m-d')}}">
							</div>
							<div class="form-group">
								<label>{{Lang::get('register_assignment.score')}}</label>
								<input data-validate="required,decimal,max(3)" type="decimal" class="form-control" id="score" name="score" placeholder="{{Lang::get('register_assignment.score_placeholder')}}" >
							</div>
							<div class="form-group">
								<label>{{Lang::get('register_assignment.tag')}}</label>
								<select data-validate="required" class="form-control" id="tags" name="tags[]" multiple>
									<option value="analysis">{{Lang::get('register_assignment.analysis')}}</option>
									<option value="database">{{Lang::get('register_assignment.database')}}</option>
									<option value="design">{{Lang::get('register_assignment.design')}}</option>
									<option value="programming">{{Lang::get('register_assignment.programming')}}</option>
									<option value="testing">{{Lang::get('register_assignment.testing')}}</option>
								</select>
								<p>{{Lang::get('teamleader.message')}}</p>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">
									{{Lang::get("register_assignment.closeButton")}}
								</button>
								<button type="submit" class="btn btn-primary">
									{{Lang::get("register_assignment.saveButton")}}
								</button>
							</div>
							<input type="hidden" id="id" name="id" value="{{$group->_id}}">
							<input type="hidden" id="date" value="{{date('Y-m-d')}}">
						{{ Form::close() }}
					</div>
				</div>
			</div>	
		</div>
		<div class="modal fade" id="editModal">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="modal-title" id="myModalLabel"><i class="fa fa-edit"></i> {{Lang::get("show_groups.titleEdit")}}</h4>
					</div>
					<div class="modal-body">
						{{ Form::open(array('url' => Lang::get('routes.update_assignment'), 'id' => 'register_form', 'role' => 'form')) }}
							<input name="taskedit" id="taskedit" type="hidden" />
							<div class="form-group">
								<label>{{Lang::get('register_assignment.description')}}</label>
								<input data-validate="required,size(3, 50),characterspace" type="text" class="form-control" id="descriptionEdit" name="descriptionEdit" placeholder="{{Lang::get('register_assignment.description_placeholder')}}" >
							</div>
							<div class="form-group">
								<label>{{Lang::get('register_assignment.assignmentTo')}}</label>	
								<select data-validate="required" class="form-control" id="studentsEdit" name="studentsEdit">
									<option value="">{{Lang::get('show_groups.student_placehold')}}</option>
									@foreach ($students as $student) 
										<option value="{{$student->_id}}">
											{{$student->name.' '.$student->last_name.' ('.$student->id_number.')'}}
										</option>
									@endforeach
								</select>
							</div>
							<div class="form-group">
								<label>{{Lang::get('register_assignment.deadline')}}</label>
								<input data-validate="required,date" type="text" class="form-control" id="deadlineEdit" name="deadlineEdit" value="{{date('Y-m-d')}}" >
							</div>
							<div class="form-group">
								<label>{{Lang::get('register_assignment.score')}}</label>
								<input data-validate="required,decimal,max(3)" type="decimal" class="form-control" id="scoreEdit" name="scoreEdit" placeholder="{{Lang::get('register_assignment.score_placeholder')}}" >
							</div>
							<div class="form-group">
								<label>{{Lang::get('register_assignment.tag')}}</label>
								{{-- <input data-validate="characterspace,max(50)" type="text" class="form-control" id="tagsEdit" name="tagsEdit" placeholder="{{Lang::get('register_assignment.tag_placeholder')}}" > --}}
								<select data-validate="required" class="form-control" id="tagsEdit" name="tagsEdit[]" multiple>
									<option value="analysis">{{Lang::get('register_assignment.analysis')}}</option>
									<option value="database">{{Lang::get('register_assignment.database')}}</option>
									<option value="design">{{Lang::get('register_assignment.design')}}</option>
									<option value="programming">{{Lang::get('register_assignment.programming')}}</option>
									<option value="testing">{{Lang::get('register_assignment.testing')}}</option>
								</select>
							</div>                   
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">
									{{Lang::get("register_assignment.closeButton")}}
								</button>
								<button type="submit" class="btn btn-primary">
									{{Lang::get('register_assignment.update_btn')}}
								</button>
							</div>
						{{ Form::close() }}
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
							&times;
						</button>
						<h4 class="modal-title" id="Eliminar mensaje">
							<i class="fa fa-trash-o"></i> {{Lang::get('register_assignment.delete_title')}}
						</h4>
					</div>
					<div class="modal-body">
						{{Lang::get('register_assignment.delete_msg')}}
					</div>
					<input type="hidden" value="" id="_id">
					<input type="hidden" value="" id="tr">
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">
							{{Lang::get('show_groups.cancel')}}
						</button>
						<button type="button" class="btn btn-primary" id="delete_btn" onclick="dropAssignment();">
							{{Lang::get('show_groups.disable')}}
						</button>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="ratedModal">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="modal-title">{{Lang::get("show_groups.modal_rated")}}</h4>	
					</div>
					<div class="modal-body">
						{{ Form::open(array('url' => Lang::get('routes.rate_assignment'), 'id' => 'register_form', 'role' => 'form')) }}
							<input name="assignment_id" id="assignment_id" type="hidden" />
							<div class="form-group">
								<label>{{Lang::get('register_assignment.score')}}</label>
								<input data-validate="required,decimal,max(3)" type="decimal" class="form-control" readonly id="scoreRated" name="scoreRated" >
							</div>
							<div class="form-group">
								<label>{{Lang::get('show_groups.rated')}}</label>
								<input data-validate="required,decimal,max(3)" type="decimal" class="form-control" id="rated" name="rated" placeholder="{{Lang::get('show_groups.rate_placeholder')}}" >
							</div>
							<div class="form-group">
								<p>{{Lang::get('show_groups.evaluation_message')}}</p>		
								<label>
									{{Lang::get('show_groups.note')}} 
									<span id="note"></span>
								</label>
							</div>
							<div class="modal-footer">
								<button type="button" id="closeRated" class="btn btn-default" data-dismiss="modal">
									{{Lang::get("register_assignment.closeButton")}}
								</button>
								<button onclick="cancelRequest()" class="btn btn-danger">
									{{Lang::get('show_groups.cancel_rate')}}
								</button>
								<button type="submit" class="btn btn-primary">
									{{Lang::get('show_groups.rate')}}
								</button>
							</div>
						{{ Form::close() }}
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="reassignedModal">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="modal-title" id="myModalLabel">
							<i class="fa fa-edit"></i> 
							{{Lang::get('register_assignment.reassign_title')}}
						</h4>
					</div>
					<div class="modal-body">
						{{ Form::open(array('url' => Lang::get('routes.reassigned'), 'id' => 'register_form', 'role' => 'form')) }}
							<input name="taskReassined" id="taskReassigned" type="hidden" />
							<div class="form-group">
								<label>{{Lang::get('register_assignment.assignmentTo')}}</label>	
								<select data-validate="required" class="form-control" id="studentsReassigned" name="studentsReassigned">
									<option value="">{{Lang::get('show_groups.student_placehold')}}</option>
									@foreach ($students as $student) 
										<option value="{{$student->_id}}">
											{{$student->name.' '.$student->last_name.' ('.$student->id_number.')'}}
										</option>
									@endforeach
								</select>
							</div>
							<div class="form-group">
								<label>{{Lang::get('register_assignment.deadline')}}</label>
								<input data-validate="required,date" type="text" class="form-control" id="deadlineReassigned" name="deadlineReassigned" value="{{date('Y-m-d')}}" >
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">
									{{Lang::get("register_assignment.closeButton")}}
								</button>
								<button type="submit" class="btn btn-primary">
									{{Lang::get('register_assignment.re_assigned')}}
								</button>
							</div>
						{{ Form::close() }}
					</div>
				</div>
			</div>
		</div>
	@endif
	<div class="modal fade" id="completeModal">
		<div class="modal-dialog custom-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title" id="myModalLabel">
						<i class="fa fa-plus"></i>
						{{Lang::get('register_assignment.completed')}}
					</h4>
				</div>
				<div id="alert"></div>
				<div class="modal-body">
					{{ Form::open(array('url' => Lang::get('routes.upload_assignment'), 'id' => 'update_form', 'role' => 'form', 'enctype' => 'multipart/form-data')) }}
						<input name="taskupdate" id="taskupdate" type="hidden" />
						<div class="form-group">
							 <div class="col-md-12">
								<div class="panel panel-cascade">
									<div class="panel-body">
										<div>
											<textarea class="textarea" name="textarea" placeholder="{{Lang::get('register_assignment.write')}}" style="width: 100%; height: 200px"></textarea>
										</div>				
									</div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label>{{Lang::get('register_assignment.attach')}}</label>	
							<input multiple="1" name="files[]" id="files" type="file">
							<br/>
							<p>{{Lang::get('register_assignment.attach_placeholder')}}</p>
						</div>                  
						<div class="modal-footer">
							<button type="button" id="closeBtn" class="btn btn-default" data-dismiss="modal">
								{{Lang::get("register_assignment.closeButton")}}
							</button>
							<button type="button" id="updateBtn" class="btn btn-primary">
								{{Lang::get('register_assignment.send')}}
							</button>
						</div>
					{{ Form::close() }}
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="viewDetailModal">
		<div class="modal-dialog custom-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title" id="myModalLabel">
						<i class="fa fa-plus"></i> 
						{{Lang::get('register_assignment.view_details')}}
					</h4>
				</div>
				<div id="alert"></div>
				<div class="modal-body">
					<div class="form-group">
						 <div class="col-md-12">
								<div class="panel panel-cascade">
								<div class="panel-body">
									<div>
										<textarea readonly class="" id="details" name="textarea" placeholder="Escriba aqui" style="width: 100%; height: 200px"></textarea>
									</div>				
								</div>
							</div>
						</div>
					</div>
					<div class="form-group" id="attach"></div>                  
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">
							{{Lang::get("register_assignment.closeButton")}}
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
	<script type="text/javascript">

		$('document').ready(function() 
		{	
			$('#deadline').datetimepicker(
			{
				timepicker: false
				,format: 'Y-m-d'
				,lang: $('#langGlobal').val()
			});

			$('#deadlineEdit').datetimepicker(
			{
				timepicker: false
				,format: 'Y-m-d'
				,lang: $('#langGlobal').val()
			});

			$('#deadlineReassigned').datetimepicker(
			{
				timepicker: false
				,format: 'Y-m-d'
				,lang: $('#langGlobal').val()
			});

			$('.textarea').wysihtml5(
			{
				"font-styles": true,
				"emphasis": true, 
				"lists": true, 
				"html": true, 
				"link": false, 
				"image": false, 
				"color": true   
			});

			$('#details').wysihtml5(
			{
				"font-styles": true,
				"emphasis": true, 
				"lists": true, 
				"html": true, 
				"link": false, 
				"image": false, 
				"color": true   
			});

			$('#details').data("wysihtml5").editor.disable();

			$('#rated').keypress(function(event) 
			{
				var controlKeys = [8, 9, 13, 35, 36, 37, 39],
					isControlKey = controlKeys.join(",").match(new RegExp(event.which));
				
				if (!event.which || (48 <= event.which && event.which <= 57) || 
				   (48 == event.which && $(this).attr("value")) || isControlKey) 
					return;
				else
					event.preventDefault();
			});

			$('#rated').keyup(function(event) 
			{
				if(this.value > 100)
					this.value = 100;

				var note = ($('#scoreRated').val() * this.value)/100;
				$('#note').html(note);				
			});

			$('#score').keypress(function(event) 
			{
				var controlKeys = [8, 9, 13, 35, 36, 37, 39],
					isControlKey = controlKeys.join(",").match(new RegExp(event.which));
				
				if (!event.which || (48 <= event.which && event.which <= 57) || 
				   (48 == event.which && $(this).attr("value")) || isControlKey)
					return;
				else
					event.preventDefault();
			});

			$('#score').keyup(function(event) 
			{
				if(this.value > 100)
					this.value = 100;
			});

			$('#scoreEdit').keypress(function(event) 
			{
				var controlKeys = [8, 9, 13, 35, 36, 37, 39],
					isControlKey = controlKeys.join(",").match(new RegExp(event.which));
				
				if (!event.which || (48 <= event.which && event.which <= 57) || 
				   (48 == event.which && $(this).attr("value")) || isControlKey)
					return;
				else
					event.preventDefault();
			});

			$('#scoreEdit').keyup(function(event) 
			{
				if(this.value > 100)
					this.value = 100;
			});

			$('#closeRated').on('click', function()
			{
				$('#scoreRated').val('');
				$('#rated').val('');
				$('#note').html('');
				$('#assignment_id').val('');
			});
		});

		$('#closeBtn').on('click', function()
		{
			$('#files').val("");
			$('.textarea').data("wysihtml5").editor.setValue(" ");
		});

		$('#updateBtn').on('click', function()
		{
			var string = $('.textarea').val();
			string = string.replace(new RegExp('&nbsp;', 'g'), '').trim();

			if(string == '' && $('#files').val() == '')
			{
				$('#alert').html
				(
					'<div class="alert alert-danger alert-dismissable">' +
					'<button type="button" class="close" data-dismiss="alert" ' +
					'aria-hidden="true" onclick="$(".alert.alert-danger.alert-dismissable").hide("slow")">' +
					'&times;</button>{{Lang::get("register_assignment.failed_update")}}</div>'
				);
			}
			else
				$('#update_form').submit();
		});		

		function viewAssignment(assignment_id)
		{
			$('#attach').html("<label>{{Lang::get('register_assignment.attachs')}}</label>");
			$('#details').data("wysihtml5").editor.setValue(' ');

			$.post("{{Lang::get('routes.find_assignment')}}",
			{ 
				code: assignment_id,	
			})
			.done(function(data) 
			{
				if(data != "")
				{
					$('#details').data("wysihtml5").editor.setValue(data.body);

					for (var i = 0; i < data.attachments.length; i++) 
					{
						$('#attach').append
						(
							"<p><a href='{{Lang::get('download').'?flag='}}" + data._id + 
							"&filename=" + data.attachments[i] + "'>" + data.attachments[i] + 
							"</a></p>"
						);
					}
				}
			});
		}

		function findAssignment(assignment_id)
		{
			$('#taskedit').val(assignment_id);

			$.post("{{Lang::get('routes.find_assignment')}}",
			{ 
				code: assignment_id,	
			})
			.done(function(data) 
			{
				if(data != "")
				{
					console.log(data);

					var date = new Date(data.deadline.sec*1000),
						tags = "";

					$('#descriptionEdit').val(data.description);
					$('#scoreEdit').val(data.score);
					$('#deadlineEdit').val(formatDate(date));

					$("#studentsEdit").find('option').each(function( i, opt ) 
					{
						if( opt.value == data.assigned_to ) 
							$(opt).attr('selected', 'selected');
					});

					$("#tagsEdit").find('option').each(function( i, opt ) 
					{
						for (var i = 0; i < data.tags.length; i++)
						{ 
							if( opt.value == data.tags[i] ) 
								$(opt).attr('selected', 'selected');
						}
					});
				}
			});
		}

		function formatDate(date) 
		{
			return date.getFullYear() + "-" + ('0' + 
				   (date.getMonth()+1)).slice(-2) + 
				   "-" + date.getDate();
		}

		function dropAssignment()
		{
			$.post("{{Lang::get('routes.drop_assignment')}}",
			{ 
				id: $('#_id').val()
			})
			.done(function( data ) 
			{    
				if(data === "00")
				{
					$('#' + $('#tr').val()).remove();
					$('#deleteModal').modal('hide');
				}
			});
		}

		function findReAssignment(assignment_id)
		{
			$('#taskReassigned').val(assignment_id);

			$.post("{{Lang::get('routes.find_assignment')}}",
			{ 
				code: assignment_id,	
			})
			.done(function(data) 
			{
				if(data != "")
				{
					var date = new Date(data.deadline.sec*1000);

					$('#deadlineReassigned').val(formatDate(date));

					$("#studentsReassigned").find('option').each(function( i, opt ) 
					{
						if( opt.value == data.assigned_to ) 
							$(opt).attr('selected', 'selected');
					});
				}
			});
		}

		function cancelRequest()
		{
			$.post("{{Lang::get('routes.cancel_request')}}",
			{ 
				_id: $('#assignment_id').val(),	
			})
			.done(function(data) 
			{
				if(data == "00")
					location.reload();
			});
		}

	</script>
@stop