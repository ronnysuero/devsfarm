@extends('teacher.master')
@section('title', 'Report - Farm')
@section('content')
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Report</h1>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			{{--<span class="pull-right">Descargar PDF</span>--}}
			<h3><i class="fa fa-group"></i> Integrantes</h3>
			<hr/>
		</div>
	</div>
	<div class="row">
        @foreach($students as $student)
		<div class="col-lg-4" style="overflow: hidden; margin-bottom: 5px;">
			<div class="pull-left" style="margin-right: 5px;">
				<img src="{{ Lang::get('show_image').'?src='.storage_path().$student->profile_image  }}" alt=""/>
			</div>
			<div style="margin-left: 5px; ">
                {{ $student->name }} {{ $student->last_name  }}
                @if($student->is_teamleader)
                     (TL)
                @endif
                <br/>
				{{ $student->id_number  }}<br/>
				{{ $student->email }}<br/>
				<strong>Trabaja:</strong>
                @if($student->has_a_job == 1)
                    Si
                @else
                    No
                @endif<br/>
				<strong>Telefono:</strong> {{ $student->phone  }}<br/>
				<strong>Celular:</strong> {{ $student->cellphone  }}
			</div>
		</div>
        @endforeach
	</div>
	<div class="row">
		<div class="col-lg-12">
			<h3><i class="fa fa-list-alt"></i> Total Asignaciones</h3>
			<hr/>
		</div>
	</div>
	<div class="well well-sm" style="padding-left: 25px;">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">

					<div class="co-lg-4"><strong>Total de asignaciones:</strong> {{ $total_assignments  }} </div>
					<div class="co-lg-4"><strong>Total completadas:</strong> {{ $total_completed  }}</div>
                    <div class="co-lg-4"><strong>Total no completadas:</strong> {{ $total_incompleted  }}</div>
					<div class="co-lg-4"><strong>Total pendientes:</strong> {{ $total_pending  }}</div>
				</div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-list-alt"></i> Asignaciones</h3>
            <hr/>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
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

                            @if(strcasecmp($group->teamleader_id, Auth::id()) === 0)
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

                                @if(strcasecmp($group->teamleader_id, Auth::id()) === 0)
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
                @if(strcasecmp($group->teamleader_id, Auth::id()) !== 0)
                    <p>{{Lang::get('register_assignment.no_assigned')}}</p>
                @endif
            @endif

        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-pie-chart"></i> Student Assignments</h3>
            <hr/>
        </div>
    </div>

	<div class="row" id="graphs" >
		<div class="col-lg-6 pie-chart" style="overflow: hidden">
			<div class="panel panel-default">
				<div class="panel-heading">
					<span class="student_name">Narciso Nunez</span>
				</div>
				<div class="panel-body">
					<div style="margin-bottom: 15px;">
                        <canvas class="myChart" width="400%" height="400"></canvas>
						<span id="total_assignment"></span>
					</div>
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

	<script type="text/javascript">

        var student_data = '';
        var data = [];
        var ctx = '';
        var labels = ['Completed', 'ToDo', 'Pending', 'Rated'];

        @foreach($student_task as $index => $json)

            student_data = JSON.parse('{{ json_encode($json) }}');

            ctx = document.getElementsByClassName("myChart")['{{ $index  }}'];
//            $(ctx).closest('span').html('<p>jajaja</p>');

            @if(count($student_task)-1 != $index)
            $('#graphs').append('<div class="col-lg-6 pie-chart">\
                                        <div class="panel panel-default">\
                                        <div class="panel-heading">\
                                            <span class="student_name">Narciso Nunez</span>\
                                        </div>\
                                        <div class="panel-body">\
                                            <div style="margin-bottom: 15px;">\
                                            <canvas class="myChart" width="400" height="400"></canvas>\
                                            <span id="total_assignment"></span>\
                                            </div>\
                                            </div>\
                                        </div>\
                                    </div>');
            @endif

            var student = [{
                        value: student_data.total_task_completed,
                        color: '{{ $colors[rand(0,14) ]  }}',
                        highlight: "#FF5A5E",
                        label: labels[0]
                    },
                    {
                        value: student_data.total_task_not_completed,
                        color: '{{ $colors[rand(0,14) ]  }}',
                        highlight: "#FF5A5E",
                        label: labels[1]
                    },
                    {
                        value: student_data.total_task_pending,
                        color: '{{ $colors[rand(0,14) ]  }}',
                        highlight: "#FF5A5E",
                        label: labels[2]
                    },
                    {
                        value: student_data.total_rated,
                        color: '{{ $colors[rand(0,14) ]  }}',
                        highlight: "#FF5A5E",
                        label: labels[3]
                    }]

            var myPieChart = new Chart(ctx.getContext("2d")).Pie(student, {animateRotate : true,animateScale : false});
        @endforeach


        function viewAssignment(assignment_id)
        {
            $('#attach').html("<label>{{Lang::get('register_assignment.attachs')}}</label>");
            $('#details').data("wysihtml5").editor.setValue(' ');

            $.post("{{Lang::get('routes.find_assignment')}}",
                    {
                        code: assignment_id
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

	</script>
@stop