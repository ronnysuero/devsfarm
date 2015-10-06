@extends('teacher.master')
@section('title', 'Ver reporte')
@section('content')
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">{{Lang::get('report.report_generate')}}</h1>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<span class="pull-right">
				<a id="download">{{Lang::get('report.download_pdf')}}</a>
			</span>
			<h3>
				<i class="fa fa-group"></i> 
				<a href="{{Lang::get('routes.report')}}">{{Lang::get('report.back')}}</a>
			</h3>
			<hr/>
		</div>
	</div>
	@if (count($report) > 0)
		<div class="row" id="report">
			<div class="col-lg-12">
				<div class="panel-body">
					<div class="table-responsive">
						<table id="tableOrder" class="table table-striped table-bordered table-hover tablesorter">
							<thead>
								<tr>
									<th>
										@if(array_key_exists('students', $report))
											{{Lang::get('report.id_number')}}
										@else
											{{Lang::get('report.group_name')}}
										@endif 
									</th>
									<th>
										@if(array_key_exists('students', $report))
											{{Lang::get('report.name')}}
										@else
											{{Lang::get('report.project_name')}}
										@endif 
									</th>
									<th>{{Lang::get('report.subject')}}</th>
									<th>{{Lang::get('report.section_code')}}</th>
									<th>{{Lang::get('report.tags')}}</th>
									<th>{{Lang::get('report.total_task')}}</th>
									<th>{{Lang::get('report.total_pending')}}</th>
									<th>{{Lang::get('report.total_current')}}</th>
									<th>{{Lang::get('report.total_not_completed')}}</th>
									<th>{{Lang::get('report.total_completed')}}</th>
									<th>{{Lang::get('report.total_score')}}</th>
									<th>{{Lang::get('report.total_rated')}}</th>
								</tr>
							</thead>
							<tbody>
								<?php $data = array_key_exists('students', $report) ? $report['students'] : $report['groups']; ?>
								@foreach ($data as $value)
									<tr>
										<td>
											@if(array_key_exists('id_number', $value))
												{{$value['id_number']}}
											@else
												{{$value['group_name']}}
											@endif 
										</td>
										<td>
											@if(array_key_exists('name', $value))
												{{$value['name']}}
											@else
												{{$value['project_name']}}
											@endif 
										</td>
										<td>{{$value['subject']}}</td>
										<td>{{$value['sectionCode']}}</td>
										<td>
											{{$value['tag']}}
										</td>
										<td>{{$value['total_task']}}</td>
										<td>{{$value['total_task_pending']}}</td>
										<td>{{$value['total_task_current']}}</td>
										<td>{{$value['total_task_not_completed']}}</td>
										<td>{{$value['total_task_completed']}}</td>
										<td>{{$value['total_score']}}</td>
										<td>{{$value['total_rated']}}</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	@endif
	<script type="text/javascript">
		$('document').ready(function()
		{
			$("#download").attr("href", "{{Lang::get('download_report').'?data='}}" + $('#report').html());
		});
	</script>
@stop