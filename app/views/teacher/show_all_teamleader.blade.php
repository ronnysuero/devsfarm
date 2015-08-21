@extends('teacher.master')
@section('title', Lang::get('teacher_title.show_all_tm'))
@section('content')
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header"><i class="fa fa-list-ol"></i> {{Lang::get('teamleader.show_all')}} </h1>
			<div class="panel-body">
				@if (count($subjects) > 0)
					<div class="table-responsive">
						@include('alert')
						@foreach ($subjects as $item => $subject)
							<h3>{{Lang::get('list_section.subject').ucfirst($subject->name)}}</h3>
							<table id="tableOrder" class="table table-striped table-bordered table-hover tablesorter">
								<thead>
									<tr>
										<th>#</th>
										<th>{{Lang::get('list_section.section')}}</th>
										<th>{{Lang::get('teamleader.section_code')}}</th>
										<th>{{Lang::get('teamleader.tm')}}</th>
										<th>{{Lang::get('list_subject.delete')}}</th>
									</tr>
								</thead>
								<tbody>
									<?php 
										$sectionCodes = SectionCode::where('subject_id', new MongoId($subject->_id))->get(); 
									?>
									@foreach ($sectionCodes as $sectionCode)
										<?php 
											$students = Student::whereIn('_id', $sectionCode->teamleaders_id)->get();
										?>
										@foreach ($students as $index => $student)
											<?php 
												$section = $subject->sections()->find($sectionCode->section_id);
											?>
											<tr id="{{$item.'_'.$index}}">
												<td>{{$index + 1}}</td>
												<td>{{$section->code}}</td>
												<td>{{$sectionCode->code}}</td>
												<td>{{'('.$student->id_number.') - '.$student->name.' '.$student->last_name}}</td>
												<td style="width: 6%">
													<a onclick="fillModal('{{$item.'_'.$index}}', '{{$sectionCode->_id}}', '{{$student->_id}}')" data-toggle="modal" data-target="#deleteModal" class="pull-right">
														<i class="fa fa-trash-o" style="color:#d9534f;"></i>
													</a>
												</td>
											</tr>
										@endforeach
									@endforeach
								</tbody>
							</table>
							<br />
						@endforeach
					</div>
				@else
					<p>
						<a href="{{Lang::get('routes.add_teamleader')}}">
							<i class="fa fa-plus" style="color: #0097A7;"></i>
							{{Lang::get('teamleader.add_teamleader')}}
						</a>
					</p>
				@endif
			</div>
		</div>
		<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="Eliminar asignatura" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myModalLabel"><i class="fa fa-trash-o"></i> 
							{{Lang::get('teamleader.drop_teamleader')}}
						</h4>
					</div>
					<input type="hidden" value="" id="sectionCode" />
					<input type="hidden" value="" id="student_id" />
					<input type="hidden" value="" id="position" />
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">{{Lang::get('list_subject.cancel')}}</button>
						<button onclick="dropTeamleader()" type="button" class="btn btn-primary">{{Lang::get('list_subject.delete')}}</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		function fillModal (position, code, student) 
		{
			$('#sectionCode').val(code);
			$('#student_id').val(student);
			$('#position').val(position);
		}

		function dropTeamleader()
		{
			$.post("{{Lang::get('routes.drop_teamleader')}}",
			{ 
				code: $('#sectionCode').val(), 
				student: $('#student_id').val() 
			})
			.done(function( data ) 
			{
				if(data === '00')
				{
					$('#' + $('#position').val()).remove();
					$('#position').val("");
					$('#deleteModal').modal('hide');
				}
			});
		}
	</script>
@stop