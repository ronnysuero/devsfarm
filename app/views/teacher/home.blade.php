@extends('teacher.master')
@section('title', Lang::get('teacher_title.home'))
@section('content')
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header" id="home_content_title">
				<i class="fa fa-home"></i> 
				{{Lang::get('teacher_master.home')}}
			</h1>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<h3>{{Lang::get('teacher_master.last')}}</h3>
			<div class="table-responsive">
				@if(count($assignments) > 0)
					<table class="table table-bodered">
						<thead>
							<th>#</th>
							<th>{{Lang::get('list_assignment.description')}}</th>
							<th>{{Lang::get('register_assignment.date_assigned')}}</th>
							<th>{{Lang::get('list_assignment.deadline')}}</th>
							<th>{{Lang::get('list_assignment.assigned_to')}}</th>
							<th>{{Lang::get('list_assignment.assigned_by')}}</th>
							<th>{{Lang::get('list_assignment.score')}}</th>
						</thead>
						<tbody>
							@foreach ($assignments as $key => $assignment)
								<tr>
									<td>{{$key + 1}}</td>
									<td>{{$assignment->description}}</td>
									<td>{{MessageController::getDate($assignment->date_assigned)}}</td>
									<td>{{MessageController::getDate($assignment->deadline, false)}}</td>
									<td>
										<?php 
											$user = User::first($assignment->assigned_to);
											$user = UserController::getUser($user);
										?>
										{{$user->name.' '.$user->last_name}}
									</td>
									<td>
										<?php 
											$user = User::first($assignment->assigned_by);
											$user = UserController::getUser($user);
										?>
										{{$user->name.' '.$user->last_name}}
									</td>
									<td>{{$assignment->score}}</td>
									<td>{{$assignment->rated}}</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				@else
					<p>{{Lang::get('teacher_master.activity')}}</p>
				@endif
			</div>
		</div>
	</div>
	<br />
	<div class="row">
		<div class="col-lg-8 col-lg-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">
					{{Lang::get('teacher_master.legend_bar')}}
				</div>
				<div>
					<canvas id="barChart"></canvas>
				</div>
			</div>
		</div>
		<div class="col-lg-8 col-lg-offset-2" style="overflow: hidden">
			<div class="panel panel-default">
				<div class="panel-heading">
					{{Lang::get('teacher_master.legend_pie')}}
				</div>
				<div class="panel-body">
					<canvas id="pieChart"></canvas>
					<div class="pull-right" id="legendPie">
                    </div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		var ctxBar = document.getElementById("barChart").getContext("2d")
			,ctxPie = document.getElementById("pieChart").getContext("2d")
			,legendPie = $('#legendPie')
			,dataBar = 
			{
				labels:
				[
					@foreach($bar_data['names'] as $data)
						"{{$data}}",
					@endforeach
				],
				datasets: 
				[
					{
						label: "",
						fillColor: "rgba(220,220,220,0.5)",
						strokeColor: "rgba(220,220,220,0.8)",
						highlightFill: "rgba(220,220,220,0.75)",
						highlightStroke: "rgba(220,220,220,1)",
						data: 
						[
							@foreach($bar_data['score'] as $data)
								{{$data}},
							@endforeach
						]
					}
				]
			}	
			,dataPie = 
			[
				@foreach($pie_data as $data)
					{{json_encode($data)}},
				@endforeach
			]
			,options = {animateRotate : true, animateScale : true, responsive: true}
			,myPieChart = new Chart(ctxBar).Bar(dataBar, options)
			,myPieChart = new Chart(ctxPie).Pie(dataPie, options);
		
		legendPie.append("<ul>");

		@foreach($pie_data as $data)
			legendPie.append("<li>{{Lang::get('register_assignment.'.$data['label'])}} : {{$data['value']}}</li>");
		@endforeach
		
		legendPie.append("</ul>");
	</script>
@stop