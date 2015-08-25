@extends('student.master')
@section('title', Lang::get('student_title.show_all_assignment'))
@section('content')
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">
				<i class="fa fa-plus"></i>
				Show All Assignments, {{$group->name}}
			</h1>
			@include('alert')	
			@if(count($tasks) > 0)
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th></th>
								<th>{{Lang::get('list_assignment.description')}}</th>
								<th>{{Lang::get('list_assignment.state')}}</th>
								<th>{{Lang::get('list_assignment.rated')}}</th>
								<th>{{Lang::get('list_assignment.score')}}</th>
								<th>{{Lang::get('list_assignment.deadline')}}</th>
								<th>{{Lang::get('list_assignment.assigned_by')}}</th>
								<th>{{Lang::get('list_assignment.assigned_to')}}</th>
								<th>
									<a href="#" data-toggle="modal" data-target="#registerModal">
										<i class="fa fa-plus"></i>
									</a>
									<a href="#" data-toggle="modal" data-target="#deleteModal">
										<i class="fa fa-minus"></i>
									</a>
								</th>
								<th></th>
							</tr>
						</thead>
					 	<tbody>
							@if(strcasecmp(Auth::id(), $group->teamleader_id) === 0)
								<input name="disable" id="disable" type="hidden" value="1" />
							@else
								<input name="disable" id="disable" type="hidden" value="0" />
							@endif

							@foreach ($tasks as $index => $task)
								<?php 
									$assigned_by = Student::find($task->assigned_by);
									$assigned_to = Student::find($task->assigned_to); 
								?>
								<tr>
									<input type="hidden" id="id{{$index+1}}" value="{{$task->_id}}">
									<div class="checkboxs">
									<td>
										<label>
											<input type="checkbox" id="message_id{{$index+1}}"> 
										</label>
									</td>
									</div>
									<td>
										<span style="text-transform: capitalize; margin-left: 5px;">
											{{$task->description}}
										</span>
									</td>
									<td>{{$task->state}}</td>
									<td>{{$task->rated}}</td>
									<td>{{$task->score}}</td>
									<td>{{date('d-m-Y h:i A',$task->deadline->sec)}}</td>
									<td>
										{{$assigned_by->name.' '.$assigned_by->last_name.' ('.$assigned_by->number_id.')'}}
									</td>
									<td>
										{{$assigned_to->name.' '.$assigned_to->last_name.' ('.$assigned_to->number_id.')'}}
									</td>
									<td>
										<button type="button" class="btn btn-warning  btn-sm dis" onclick="$('#assignModal').modal('show');useTask('{{$task->_id}}');">
											{{Lang::get('show_groups.btnrated')}}
										</button>
									</td>
									<td>
										<button type="button"  class="btn btn-warning  btn-sm dis" onclick="$('#editModal').modal('show');find_task('{{$task->_id}}');">
											{{Lang::get('show_groups.btnedit')}}
										</button>
									</td>
								</tr>
					 		@endforeach
					 	</tbody>  
					</table>
				</div>
			@else
				<p>
					@if(strcasecmp($group->teamleader_id, Auth::id()) === 0)
						<a href="#" data-toggle="modal" data-target="#registerModal">
							<i class="fa fa-plus" style="color: #0097A7;"></i> 
							Agregar una asignacion
						</a>
					@else
						No tienes tareas registradas aun
					@endif
				</p>
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
							{{Lang::get("register_assignment.registerAssignment")}}
						</h4>
					</div>
					<div class="modal-body">
						{{ Form::open(array('url' => Lang::get('routes.register_assignment'), 'id' => 'register_form', 'role' => 'form')) }}
							<div class="form-group">
								<label>
									{{Lang::get('register_assignment.description')}}
								</label>
								<input data-validate="required,size(3, 50),characterspace" type="text" class="form-control" id="description" name="description" placeholder="" >
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
								<input data-validate="required,decimal" type="decimal" class="form-control" id="score" name="score" placeholder="" >
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
		<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="Eliminar mensaje" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
							&times;
						</button>
						<h4 class="modal-title" id="Eliminar mensaje">
							<i class="fa fa-trash-o"></i> {{Lang::get('show_groups.delete_msg')}}
						</h4>
					</div>
					<div class="modal-body">
						{{Lang::get('show_groups.detete_message')}}
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">
							{{Lang::get('show_groups.cancel')}}
						</button>
						<button type="button" class="btn btn-primary" id="delete_btn">
							{{Lang::get('show_groups.disable')}}
						</button>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="assignModal">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="modal-title">{{Lang::get("show_groups.btnrated")}}</h4>	
					</div>
					<div class="modal-body">
						@if($errors->has('error'))
							<div class="alert alert-danger alert-dismissable">
								<button type="button" class="close" data-dismiss="alert"
									aria-hidden="true" onclick="$('.alert.alert-danger.alert-dismissable').hide('slow')">
									&times;
								</button>
								{{ $errors->first('error') }}
							</div>
						@endif
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
		<div class="modal fade" id="editModal">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="modal-title">{{Lang::get("show_groups.titleEdit")}}</h4>
					</div>
					<div class="modal-body">
						@if($errors->has('error'))
							<div class="alert alert-danger alert-dismissable">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true" onclick="$('.alert.alert-danger.alert-dismissable').hide('slow')">
									&times;
								</button>
								{{ $errors->first('error') }}
							</div>
						@endif
						{{ Form::open(array('url' => Lang::get('routes.update_task'), 'id' => 'register_form', 'role' => 'form','enctype' => 'multipart/form-data')) }}
							<input name="taskedit" id="taskedit" type="hidden" />
							<input name="group_id" id="group_id" type="hidden"  value="{{$group->_id}}"/>
							<div class="form-group">
								<label>{{Lang::get('register_assignment.description')}}</label>
								<input data-validate="required,size(3, 50),characterspace" type="text" class="form-control" id="descriptionedit" name="descriptionedit" placeholder="" >
							</div>
							<div class="form-group">
								<label>{{Lang::get('register_assignment.assignmentTo')}}</label>	
								<select data-validate="required" class="form-control" id="studentsedit" name="studentsedit">
									<option value="">{{Lang::get('show_groups.student_placehold')}}</option>
								</select>
							</div>
							<div class="form-group">
								<label>{{Lang::get('register_assignment.deadline')}}</label>
								<input data-validate="required" type="text" class="form-control" id="deadlineedit" name="deadlineedit" placeholder="" >
							</div>
							<div class="form-group">
								<label>{{Lang::get('register_assignment.score')}}</label>
								<input data-validate="required" type="decimal" class="form-control" id="scoreedit" name="scoreedit" placeholder="" >
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
		$('document').ready(function()
		{
			// $.post("{{Lang::get('routes.find_students')}}",
			// { 
			// 	group: $('#id').val() 
			// })
			// .done(function( data )
			// {
			// 	if(data !== "")
			// 	{
			// 		for(var item in data.students)
			// 		{
			// 			$('#students').append
			// 			( 
			// 				new Option(data.students[item].name, data.students[item]._id) 
			// 			);
			// 		}
					
			// 		$('#group').val(data.id);
			// 	}
			// });		

			// $.post("{{Lang::get('routes.find_students')}}",
			// { 
			// 	group: $('#id').val() 
			// })
			// .done(function( data )
			// {
			// 	if(data !== "")
			// 	{
			// 		for(var item in data.students)
			// 		{
			// 			$('#studentsedit').append
			// 			( 
			// 				new Option(data.students[item].name, data.students[item]._id) 
			// 			);
			// 		}
					
			// 		$('#group').val(data.id);
			// 	}
			// });

			if($('#disable').val() != 1)
				$('.dis').attr("disabled", true);		
		});

		$('#delete_btn').on('click', function()
		{
			var idsArray = [];

			$('input[type=checkbox]').each(function () 
			{
				if(this.checked && $(this).attr('id'))
					idsArray.push($("#" + $(this).attr("id").replace('message_id', 'id')).val());
			});

			$.post("{{Lang::get('routes.drop_tasks')}}",
			{ 
				_ids: idsArray
			})
			.done(function( data ) 
			{    
				if(data === "00")
					location.reload();
			});
		});

		function useTask(id)
	 	{	
			$('#task').val(id);
		}

		function find_task(x)
		{
			$('#taskedit').val(x);

	 		$.post("{{Lang::get('routes.find_task')}}",
			{ 
				code: x,	
			})
			.done(function(data) 
			{
				console.log(data);
		   		$('#descriptionedit').val(data.description);
		   		$('#scoreedit').val(data.score);
		  		
		  		$("#studentsedit").find('option').each(function( i, opt ) 
		  		{
					if( opt.value === data.assigned_to ) 
						$(opt).attr('selected', 'selected');
		   		});
			});
		}
	</script>
@stop