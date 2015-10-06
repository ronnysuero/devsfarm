@extends('teacher.master')
@section('title', Lang::get('teacher_title.home'))
@section('content')
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header" id="home_content_title"><i class="fa fa-home"></i> Home</h1>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">

            <h3>Last Assignments</h3>
            <div class="table-responsive">
                <table class="table table-bodered">
                    <thead>
                        <th>#</th>
                        <th>{{Lang::get('list_assignment.description')}}</th>
                        <th>{{Lang::get('register_assignment.date_assigned')}}</th>
                        <th>{{Lang::get('list_assignment.deadline')}}</th>
                        <th>{{Lang::get('list_assignment.assigned_to')}}</th>
                        <th>{{Lang::get('list_assignment.state')}}</th>
                        <th>{{Lang::get('list_assignment.score')}}</th>
                        <th>{{Lang::get('list_assignment.rated')}}</th>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>

		</div>
	</div>

	<div class="row">
		<div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Grafico de Barra
                </div>
                <div class="panel-body" id="crop-avatar">
                    Aqui el grafico
                    {{ $assignments  }}
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