@extends('student.master')
@section('title', 'Dashboard - Student')
@stop
<style type="text/css">
	@media only screen and (max-width: 604px) 
	{
    	.container-fluid { display: none; }
	}
</style>
@section('content')
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
	<div class="col-lg-12">
		<h1 class="page-header">Nombre del Proyecto</h1>
		<div class="table-responsive">
			<table class="table">
				<thead>
					<tr>
						<th></th>
						<th>{{Lang::get('list_assignment.description')}}</th>
						<th>{{Lang::get('list_assignment.state')}}</th>
						<th>{{Lang::get('list_assignment.assigned_to')}}</th>
						<th>{{Lang::get('list_assignment.assigned_by')}}</th>
						<th>{{Lang::get('list_assignment.deadline')}}</th>
						<th>
							<a href="#" data-toggle="modal" data-target="#registerModal"><i class="fa fa-plus"></i></a>
							<i class="fa fa-minus"></i>
							<i class="fa fa-pencil"></i>
						</th>
						<th></th>
					</tr>
				</thead>
				<tbody >
					<tr>
						<td><label> <input type="checkbox" id=""> </label></td>
						<td>Realizar Diagrama de Actividades</td>
						<td>Completada</td>
						<td>Leticia </td>
						<td>Narciso</td>
						<td>12/05/2015</td>
						<td><button type="button" class="btn btn-warning  btn-sm">Asignar</button></td>
						<td></td>
					</tr>
					<tr>
						<td><label> <input type="checkbox" id=""> </label></td>
						<td>Realizar Diagrama de Actividades</td>
						<td>Completada</td>
						<td>Leticia </td>
						<td>Narciso</td>
						<td>12/05/2015</td>
						<td><button type="button" class="btn btn-warning  btn-sm">Asignar</button></td>
						<td></td>
					</tr>
					<tr>
						<td><label> <input type="checkbox" id=""> </label></td>
						<td>Realizar Diagrama de Actividades</td>
						<td>Completada</td>
						<td>Leticia </td>
						<td>Narciso</td>
						<td>12/05/2015</td>
						<td><button type="button" class="btn btn-warning btn-sm" >Asignar</button></td>
						<td></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<script type="text/javascript">
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
			return '<li'+(active?' class="active"':'')+'><a href="#">'+type+'s <span class="badge">'+count+'</span></a></li>';
		};

		var updateInfo = function () 
		{
			var state = gantt.getState(),
					tasks = gantt.getTaskByTime(state.min_date, state.max_date),
					types = gantt.config.types,
					result = {},
					html = "",
					active = false;

			// get available types
			for (var t in types)
				result[types[t]] = 0;
			
			// sort tasks by type
			for (var i=0, l=tasks.length; i<l; i++) 
			{
				if (tasks[i].type && result[tasks[i].type] != "undefined")
					result[tasks[i].type] += 1;
				else
					result[types.task] += 1;
			}
			
			// render list items for each type
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
			if(date.getDay()==0||date.getDay()==6){
				return "weekend";
			}
		};
		gantt.templates.task_cell_class = function(item,date)
		{
			if(date.getDay()==0||date.getDay()==6)
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
			}, align: "center", width:60 },
			{name:"duration", label:"{{Lang::get('student_home.duration')}}", align:"center", width:60},
			{name:"add", label:"", width:44 }
		];

		gantt.config.grid_width = 390;
		gantt.config.date_grid = "%F %d";
		gantt.config.scale_height  = 60;
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