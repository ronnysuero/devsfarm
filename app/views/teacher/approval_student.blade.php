@extends('teacher.master')
@section('title', Lang::get('teacher_title.approval'))
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
									<th>{{Lang::get('register_group.section')}}</th>
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
									?>
									<tr id="{{$index+1}}">
										<td>{{$index+1}}</td>
										<td>{{$subject->name}}</td>
										<td>{{$section->code}}</td>
										<td>{{$section_code->code}}</td>
										<td>{{$student->name.' '.$student->last_name.' - ('.$student->id_number.')'}}</td>
										<td style="width:6%">
											<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#deleteModal" onclick="approve('{{$item->_id}}', {{$index+1}})"> 
												{{Lang::get('register_group.approve')}}
											</button>
										</td>
										<td style="width:6%">
											<button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal" onclick="deny('{{$item->_id}}', {{$index+1}})"> 
												{{Lang::get('register_group.deny')}}
											</button>
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
			$.post("{{Lang::get('routes.approve_enroll')}}",
			{ 
				id: id,
			})
			.done(function( data ) 
			{
				if(data.code === '00')
				{
					$('#'+pos).remove();

					if(data.stats.approve > 0)
						$('#approve').html(data.stats.approve);
					else
						$('#approve_li').remove();
				}
			});
		}

		function deny(id, pos)
		{
			$.post("{{Lang::get('routes.drop_enroll')}}",
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
