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
		<div class="col-lg-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					Grafico de Barra
				</div>
				<div class="panel-body" id="crop-avatar">
					Aqui el grafico
				</div>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					Grafico de Pastel
				</div>
				<div class="panel-body" id="crop-avatar">
					Aqui el grafico
				</div>
			</div>
		</div>
	</div>
@stop