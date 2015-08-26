@extends('student.master')
@section('title', Lang::get('student_title.show_all_assignment'))
@section('content')
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">
				<i class="fa fa-plus"></i>
				{{$group->name}}
			</h1>
			<p>
				@if(strcasecmp($group->teamleader_id, Auth::id()) === 0)
					<a href="#" data-toggle="modal" data-target="#registerModal">
						<i class="fa fa-plus" style="color: #0097A7;"></i> 
						{{Lang::get('register_assignment.add')}}
					</a>
				@endif

			</p>
			<br />
			@include('alert')	
			@if(count($tasks) > 0)
				<h4>{{Lang::get('register_assignment.assignment')}}</h4>
				<div class="table-responsive">
					<table id="tableOrder" class="table table-striped table-bordered table-hover tablesorter">
						<thead>
							<tr>
								<th>#</th>
								<th>{{Lang::get('list_assignment.description')}}</th>
								<th>{{Lang::get('register_assignment.date_assigned')}}</th>
								<th>{{Lang::get('list_assignment.deadline')}}</th>
								<th>{{Lang::get('list_assignment.assigned_by')}}</th>
								<th>{{Lang::get('list_assignment.assigned_to')}}</th>
								<th>{{Lang::get('list_assignment.state')}}</th>
								<th>{{Lang::get('list_assignment.score')}}</th>
								<th>{{Lang::get('list_assignment.rated')}}</th>

								@if(strcasecmp($group->teamleader_id, Auth::id()) === 0)
									<th>{{Lang::get('register_assignment.rate')}}</th>
									<th>{{Lang::get('register_assignment.edit')}}</th>
									<th>{{Lang::get('register_assignment.delete')}}</th>
									<th>{{Lang::get('register_assignment.re_assigned')}}</th>
								@endif
							</tr>
						</thead>
					 	<tbody>
							@foreach ($tasks as $index => $task)
								<?php 
									$assigned_by = Student::find($task->assigned_by);
									$assigned_to = Student::find($task->assigned_to); 
								?>
								<tr id="{{$index}}">
									<td>{{$index + 1}}</td>
									<td>{{$task->description}}</td>
									<td>{{date('d-m-Y',$task->date_assigned->sec)}}</td>
									<td>{{date('d-m-Y',$task->deadline->sec)}}</td>
									<td>{{$assigned_by->name.' '.$assigned_by->last_name}}</td>
									<td>
										{{$assigned_to->name.' '.$assigned_to->last_name.' ('.$assigned_to->id_number.')'}}
									</td>
									<td>{{Lang::get('register_assignment.'.$task->state)}}</td>
									<td>{{$task->score}}</td>
									<td>{{$task->rated}}</td>
									
									@if(strcasecmp($group->teamleader_id, Auth::id()) === 0)
										<td style="width: 6%">
											@if(strcasecmp($task->state, 'r') !== 0 && strcasecmp($task->state, 'c') !== 0)
												<button type="button" class="btn btn-primary btn-sm pull-right" data-toggle="modal" data-target="#ratedModal" onclick="useTask('{{$task->_id}}');"> 
													{{Lang::get('register_assignment.rate')}}
												</button>
											@endif
										</td>
										<td style="width: 6%"> 
											@if(strcasecmp($task->state, 'c') !== 0 && strcasecmp($task->state, 'n') !== 0)
												<button type="button" class="btn btn-warning btn-sm pull-right" data-toggle="modal" data-target="#editModal" onclick="findAssignment('{{$task->_id}}');"> 
													{{Lang::get('show_groups.btnedit')}}
												</button>
											@endif
										</td>
										<td style="width: 6%">
											@if(strcasecmp($task->state, 'c') !== 0 && strcasecmp($task->state, 'n') !== 0)
												<button type="button" class="btn btn-danger btn-sm  pull-right" data-toggle="modal" data-target="#deleteModal" onclick="$('#_id').val('{{$task->_id}}'); $('#tr').val('{{$index}}');">
													{{Lang::get('register_assignment.delete')}}
												</button>
											@endif
										</td>
										<td style="width: 6%">
											@if(strcasecmp($task->state, 'n') === 0) 
												<button type="button" class="btn btn-warning btn-sm pull-right" onclick="$('#editModal').modal('show');findAssignment('{{$task->_id}}');"> 
													{{Lang::get('register_assignment.re_assigned')}}
												</button>
											@endif
										</td>
									@endif
								</tr>
					 		@endforeach
					 	</tbody>  
					</table>
				</div>
			@else
				@if(strcasecmp($group->teamleader_id, Auth::id()) !== 0)
					<p>{{Lang::get('register_assignment.no_assigned')}}</p>
				@endif
			@endif
		</div>
	</div>
	@if(strcasecmp($group->teamleader_id, Auth::id()) === 0)
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
								<input data-validate="required,date" type="date" class="form-control" id="deadline" name="deadline" placeholder="" value="{{date('Y-m-d')}}">
							</div>
							<div class="form-group">
								<label>{{Lang::get('register_assignment.score')}}</label>
								<input data-validate="required,decimal" type="decimal" class="form-control" id="score" name="score" placeholder="{{Lang::get('register_assignment.score_placeholder')}}" >
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
								<input data-validate="required,date" type="date" class="form-control" id="deadlineEdit" name="deadlineEdit" value="{{date('Y-m-d')}}" >
							</div>
							<div class="form-group">
								<label>{{Lang::get('register_assignment.score')}}</label>
								<input data-validate="required" type="decimal" class="form-control" id="scoreEdit" name="scoreEdit" placeholder="{{Lang::get('register_assignment.score_placeholder')}}" >
							</div>                   
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">
									{{Lang::get("register_assignment.closeButton")}}
								</button>
								<button type="submit" id="ratedBtn" class="btn btn-primary">
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
						<h4 class="modal-title">{{Lang::get("show_groups.btnrated")}}</h4>	
					</div>
					<div class="modal-body">
						{{ Form::open(array('url' => Lang::get('routes.rated'), 'id' => 'register_form', 'role' => 'form','enctype' => 'multipart/form-data')) }}
							<input name="task" id="task" type="hidden" />
							<input name="group_id" id="group_id" type="hidden"  value="{{$group->_id}}"/>
							<div class="form-group">
								<label>{{Lang::get('show_groups.rated')}}</label>
								<input data-validate="required" type="decimal" class="form-control" id="rated" name="rated" placeholder="" >
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">
									{{Lang::get("register_assignment.closeButton")}}
								</button>
								<button id="ratedBtn" class="btn btn-primary">
									{{Lang::get("register_assignment.saveButton")}}
								</button>
							</div>
				 		{{ Form::close() }}
					</div>
				</div>
			</div>
		</div>
	@endif
	<script type="text/javascript">

		function findAssignment(task_id)
		{
			$('#taskedit').val(task_id);

	 		$.post("{{Lang::get('routes.find_assignment')}}",
			{ 
				code: task_id,	
			})
			.done(function(data) 
			{
				var date = new Date(data.deadline.sec*1000);

		   		$('#descriptionEdit').val(data.description);
		   		$('#scoreEdit').val(data.score);
		  		$('#deadlineEdit').val(formatDate(date));

		  		$("#studentsEdit").find('option').each(function( i, opt ) 
		  		{
					if( opt.value == data.assigned_to ) 
						$(opt).attr('selected', 'selected');
		   		});
			});
		}

		function formatDate(date) {
			return date.getFullYear() + "-" + ('0' + (date.getMonth()+1)).slice(-2) + "-" + date.getDate();
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

	</script>
@stop