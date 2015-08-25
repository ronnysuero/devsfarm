@extends('student.master')
@section('title', Lang::get('student_title.approval'))
@section('content')
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">
				<i class="fa fa-compress"></i> {{Lang::get('teacher_master.approval')}}
			</h1>
			<div class="panel-body">
				@include('alert')
				@if (count($pending) > 0)
					<h4>{{Lang::get('register_group.approve_title')}}</h4>
					<div class="table-responsive">
						<table id="tableOrder" class="table table-striped table-bordered table-hover tablesorter">
							<thead>
								<tr>
									<th>#</th>
									<th>{{Lang::get('register_group.subject')}}</th>
									<th>{{Lang::get('register_group.section_code')}}</th>
									<th>{{Lang::get('register_group.group_name')}}</th>
									<th>{{Lang::get('register_group.student')}}</th>
									<th>{{Lang::get('register_group.approve')}}</th>
									<th>{{Lang::get('register_group.deny')}}</th>
								</tr>
							</thead>
							<tbody>
								@foreach($pending as $index => $item)
									<?php 
										$section_code = SectionCode::find($item->section_code_id);
										$subject = Subject::find($section_code->subject_id);
										$section = $subject->sections()->find($section_code->section_id);
										$student = Student::find($item->student_id);
										$group = Group::find($item->group_id);
									?>
									<tr id="{{$index+1}}">
										<td>{{$index+1}}</td>
										<td>{{$subject->name}}</td>
										<td>{{$section->code}}</td>
										<td>{{$group->name}}</td>
										<td>{{$student->name.' '.$student->last_name.' - ('.$student->id_number.')'}}</td>
										<td style="width:6%">
											<a onclick="approve('{{$item->_id}}', {{$index+1}})" href="#" class="pull-right">
												<i class="fa fa-check-square-o" style="color:#337ab7;"></i>
											</a>
										</td>
										<td style="width:6%">
											<a onclick="deny('{{$item->_id}}', {{$index+1}})" class="pull-right">
												<i class="fa fa-trash-o" style="color:#d9534f;"></i>
											</a>
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>	
				@endif
			</div>
		</div>
	</div>
	<script type="text/javascript">
		function approve(id, pos)
		{
			$.post("{{Lang::get('routes.approve_group')}}",
			{ 
				id: id,
			})
			.done(function( data ) 
			{
				if(data.code === '00')
				{
					$('#'+pos).remove();

					if(data.stats.join > 0)
						$('#join').html(data.stats.join);
					else
						$('#join_li').remove();
				}
			});
		}

		function deny(id, pos)
		{
			$.post("{{Lang::get('routes.drop_join')}}",
			{ 
				id: id,
			})
			.done(function( data ) 
			{
				if(data === '00')
					$('#'+pos).remove();
			});
		}
	</script>
@stop
