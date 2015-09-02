@extends('student.master')
@section('title', Lang::get('student_title.home'))
@section('content')
	<div class="row">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					 <h1 class="page-header">Diagrama de Gantt</h1>
				</div>
			</div>
			<div class="row">
				<div class="col-md-2 col-md-push-10">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">{{Lang::get('student_home.gantt_info')}}</h3>
						</div>
						<div class="panel-body">
							<ul class="nav nav-pills nav-stacked" id="gantt_info"></ul>
						</div>
					</div>
				</div>
				<div class="col-md-10 col-md-pull-2">
					<div class="gantt_wrapper panel" id="gantt_here"></div>
				</div>
			</div>
		</div>
	</div>
	@if(count($groups) > 0)
		<div class="row">    
			<div class="col-lg-12">
				<h1 class="page-header">
					<i class="fa fa-list"></i> {{Lang::get('show_groups.my_groups')}}
				</h1>
				<div class="panel-body">
					<div class="table-responsive">
						@include('alert')
						<table id="tableOrder" class="table table-striped table-bordered table-hover tablesorter">
							<thead>
								<tr>
									<th>#</th>
									<th>{{Lang::get('register_group.name')}}</th>
									<th>{{Lang::get('register_group.project_name')}}</th>
									<th>{{Lang::get('show_groups.see')}}</th>
									<th>{{Lang::get('show_groups.edit')}}</th>
									<th>{{Lang::get('show_groups.delete')}}</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($groups as $index =>$group)    
									<tr id="{{$index}}">
										<td style="width: 1%">{{$index + 1}}</td>
										<td>{{$group->name}}</td>
										<td>{{$group->project_name}}</td>
						   				<td style="width: 3%">
											<button type="button" class="btn btn-info btn-sm" onclick="findGroup('{{$group->_id}}')"> 
												{{Lang::get('show_groups.see')}}
											</button>
										</td>	
						   				<td style="width: 6%">
						   					@if(strcasecmp($group->teamleader_id, Auth::id()) === 0)
							   					<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModal" onclick="fillModal('{{$group->_id}}')"> 
													{{Lang::get('show_groups.edit')}}
												</button>
											@endif
										</td>
										<td style="width: 6%">
											@if(strcasecmp($group->teamleader_id, Auth::id()) === 0)
											   <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal" onclick="$('#group_id').val('{{$group->_id}}'); $('#pos').val('{{$index}}');"> 
													{{Lang::get('show_groups.delete')}}
												</button>
											@endif
										</td>							
									</tr>
								@endforeach
								 {{ Form::open(array('url' => Lang::get('routes.show_all_assignment'), 'id' => 'form_group')) }}
									<div class="form-group">
										<input type="hidden" id="group_code", name="group_code" value="">
									</div>
								{{Form::close()}}
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="Eliminar grupo" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
							&times;
						</button>
						<h4 class="modal-title" id="Eliminar grupo">
							<i class="fa fa-trash-o"></i> {{Lang::get('show_groups.deleteGroup')}}
						</h4>
					</div>
					<div class="modal-body">
						{{Lang::get('show_groups.detete_message')}}
					</div>
					<input type="hidden" value="{{storage_path()}}" id="url">
					<input type="hidden" value="" id="pos">
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">
							{{Lang::get('show_groups.cancel')}}
						</button>
						<button onclick="dropGroup()" type="button" class="btn btn-danger">
							{{Lang::get('show_groups.disable')}}
						</button>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="Editar grupo" aria-hidden="true">
			<div class="modal-dialog custom-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
							&times;
						</button>
						<h4 class="modal-title" id="Eliminar profesor">
							<i class="fa fa-edit"></i>{{Lang::get('show_groups.modify_group')}}
						</h4>
					</div>
					<div class="panel-body" id="crop-avatar">
						<div class="modal-body">
							{{ Form::open(array('url' => Lang::get('routes.update_group'), 'id' => 'form', 'role' => 'form','enctype' => 'multipart/form-data')) }}				
								<div class="form-group">
									<label>{{Lang::get('register_group.name')}}</label>
									<input data-validate="required,size(3, 50),characterspace" type="text" class="form-control" id="name" name="name" >
								</div>
								<div class="form-group">
									<label>{{Lang::get('register_group.project_name')}}</label>
									<input data-validate="required,size(3, 50),characterspace" type="text" class="form-control" id="project_name" name="project_name" >
								</div>
								<div class="form-group tooltip-bottom" data-tooltip="{{Lang::get('crop.change_avatar')}}" style="width:140px">
									<div id="photo_display" name="photo_display" class="avatar-view avatar-preview preview-lg" style="width:140px; height:140px">
										<img src="images/140x140.png" alt="Avatar">
									</div>
								</div>
								<input type="hidden" value="" id="group_id" name="group_id">
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">
										{{Lang::get('show_groups.cancel')}}
									</button>
									<button type="submit" class="btn btn-primary">
										{{Lang::get('list_teacher.save')}}
									</button>
								</div>
					 		{{ Form::close() }}
						</div>
						@include('crop')
					</div>
				</div>
			</div>
		</div>
	@endif
	<script type="text/javascript" src="js/dhtmlxgantt.js"></script>
	<script type="text/javascript">

		$('document').ready(function() 
		{
			$("#crop").on("click", function()
			{
				$('#photo_display').html($('#preview').html());
				$('#avatar-modal').modal('hide');
			});
		});

		function fillModal(groupId)
		{
			$.post("{{Lang::get('routes.find_Group_By_Section')}}",
			{ 
				group_id: groupId  
			})
			.done(function( data ) 
			{
				$('#name').val(data.name);
				$('#project_name').val(data.project_name);
				$('#group_id').val(data._id);

				if(data.logo != null)
				{
					$('#photo_display').html
					(
						'<img src="{{Lang::get("show_image")."?src="}}' + 
						$('#url').val() + data.logo + '" alt="Avatar" >'
					);
				}
				else
					$('#photo_display').html('<img src="images/140x140.png" alt="Avatar" >');
			});
		}

		function dropGroup()
		{
			$.post("{{Lang::get('routes.drop_group')}}",
			{ 
				group_id: $('#group_id').val()
			})
			.done(function( data ) 
			{
				if(data === '00')
				{
					$('#deleteModal').modal('hide');
					$('#' + $('#pos').val()).remove();				
				}
			});
		}

		function findGroup(group_id)
		{
			$("#group_code").val(group_id);
			$("#form_group").submit();
		}

		var demo_tasks = {
			data:[
				@foreach($data as $json)
					{{GanttController::removeQuotes($json)}},
				@endforeach
			],
			links:[
				{{implode(',', $links)}}
			]
		};

		var getListItemHTML = function (type, count, active) 
		{
			return '<li'+(active?' class="active"':'') + 
				   '><a href="#">' + type + 's <span class="badge">' +
				   count + '</span></a></li>';
		};

		var updateInfo = function() 
		{
			var state = gantt.getState(),
				tasks = gantt.getTaskByTime(state.min_date, state.max_date),
				types = gantt.config.types,
				result = {},
				html = "",
				active = false;

			for (var t in types)
				result[types[t]] = 0;
			
			for (var i=0, l=tasks.length; i<l; i++) 
			{
				if (tasks[i].type && result[tasks[i].type] != "undefined")
					result[tasks[i].type] += 1;
				else
					result[types.task] += 1;
			}
			
			for (var j in result) 
			{
				if (j == types.task)
					active = true;
				else
					active = false;
				
				html += getListItemHTML(j, result[j], active);
			}

			document.getElementById("gantt_info").innerHTML = html;
		};

		gantt.templates.scale_cell_class = function(date)
		{
			if(date.getDay() == 0 || date.getDay() == 6)
				return "weekend";
		};
		
		gantt.templates.task_cell_class = function(item,date)
		{
			if(date.getDay() == 0 || date.getDay() == 6)
				return "weekend" ;
		};

		gantt.templates.rightside_text = function(start, end, task)
		{
			if(task.type == gantt.config.types.milestone)
				return task.text;
	
			return "";
		};

		gantt.config.columns = [
			{name:"text", label:"{{Lang::get('student_home.task_name')}}", width:"*", tree:true},
			{name:"start_time", label:"{{Lang::get('student_home.start')}}", template:function(obj){
				return gantt.templates.date_grid(obj.start_date);
			}, align: "center", width:50 },
			{name:"duration", label:"{{Lang::get('student_home.duration')}}", align:"center", width:50},
			{name:"add", label:"", width:25 }
		];

		gantt.config.grid_width = 350;
		gantt.config.date_grid = "%F %d";
		gantt.config.scale_height  = 90;
		gantt.config.subscales = [
			{ unit:"week", step:1, date:"{{Lang::get('student_home.week')}} #%W"}
		];

		gantt.attachEvent("onAfterTaskAdd", function(id,item){
			updateInfo();
		});

		gantt.attachEvent("onAfterTaskDelete", function(id,item){
			updateInfo();
		});

		gantt.init("gantt_here");
		gantt.parse(demo_tasks);
		updateInfo();

	</script>
@stop