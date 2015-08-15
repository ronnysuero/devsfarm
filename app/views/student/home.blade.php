@extends('student.master')
@section('title', 'Dashboard - Student')
@stop
<style type="text/css">
	@media only screen and (max-width: 604px)
	{
		.container-fluid {display: none;}
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
        <h1 class="page-header"><i class="fa fa-list"></i> {{Lang::get('show_groups.my_groups')}}</h1>
        <div class="panel-body">
            @if (count($groups) >= 1)
                <div class="table-responsive">
                    @include('alert')
                    <table id="tableOrder" class="table table-striped table-bordered table-hover tablesorter">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{Lang::get('show_groups.edit')}}</th>
                                <th>{{Lang::get('register_group.name')}}</th>
                                <th>{{Lang::get('register_group.project_name')}}</th>
                                <th>{{Lang::get('show_groups.delete')}}</th>
                                <th>{{Lang::get('show_groups.see')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($groups as $index =>$group)    
                            <tr>
                                <td>{{$index + 1}}</td>
                                <td>
                                    <a href="#">
                                        <i class="fa fa-edit" data-toggle="modal" data-target="#editModal" style="color:#337ab7;"></i>
                                    </a>
                                </td>
                                <td>{{$group->name}}</td>
                                <td>{{$group->project_name}}</td>
                   
                                <td>
                                   <a onclick="$('#_id').val('{{$group->_id}}')" class="pull-right">
                                            <i class="fa fa-trash-o" data-toggle="modal" data-target="#deleteModal" style="color:#d9534f;"></i>
                                    </a>
                                </td>

                                <td>

                                <div class="see">
                                    <a href="#" onclick="findGroup('{{$group->_id}}')">
                                       <i class="fa fa-eye" style="color: #0097A7;"></i>
                                    </a>
                                </div>
                                </td>

                                
                            </tr>
                            @endforeach
                             {{ Form::open(array('url' => Lang::get('routes.find_Group'), 'id' => 'form_groups', 'class' => 'hide')) }}
                                <div class="form-group">
                                <input type="hidden" id="group_code" name="group_code" value="" >
                                <input type="hidden" id="_id", name="_id" value="">
                                
                            </div>
                            {{Form::close()}}
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="Eliminar Grupo" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="Eliminar grupo"><i class="fa fa-trash-o"></i> {{Lang::get('list_teacher.confirm')}}</h4>
            </div>
            <div class="modal-body">
                {{Lang::get('list_teacher.agree')}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{Lang::get('list_teacher.cancel')}}</button>
                <button onclick="dropGroup();" type="button" class="btn btn-primary">{{Lang::get('list_teacher.disable')}}</button>
            </div>
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

		 function findGroup(x){

		    var group =  x;
		    $("#group_code").val(group);
		    $("#form_groups").submit();
		}
		function dropGroup()
	    {
	        $.post("{{Lang::get('routes.drop_group')}}",
	        { 
	            group_id: $('#_id').val()
	        })
	        .done(function( data ) 
	        {
	            if(data === '00')
	                location.reload();
	        });
	    }
	</script>
@stop