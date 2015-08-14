@extends('university.master')
@section('title', Lang::get('university_profile.title'))
@stop
@section('content')
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">{{Lang::get('list_subject.subject')}}</h1>
		@if (count($subjects) >= 1)
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th>#</th>
								<th>{{Lang::get('list_subject.subject')}}</th>
								<th>{{Lang::get('list_subject.school')}}</th>
								<th>{{Lang::get('list_subject.section')}}</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($subjects as $index => $subject)
								<tr>
									<td>{{$index + 1}}</td>
									<td>{{ $subject->name }}</td>
									<td>{{ $subject->school }}</td>
									<td>
										<?php $sections = $subject->sections()->whereNull('deleted_at')->get();?>
										@foreach ($sections as $i => $section)
											@if($i === 0)
												{{ $section->code }}
											@else 
												, {{ $section->code }}
											@endif
										@endforeach
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		@else
			<p>
				<a href="{{Lang::get('routes.add_subject')}}">
					<i class="fa fa-plus" style="color: #0097A7;"></i>
					{{Lang::get('list_subject.add_subject')}}
				</a>
			</p>
		@endif
	</div>
</div>
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">{{Lang::get('list_teacher.teacher')}}</h1>
		@if (count($teachers) >= 1)
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th>{{Lang::get('list_teacher.photo')}}</th>
								<th>{{Lang::get('list_teacher.name')}}</th>
								<th>{{Lang::get('list_teacher.last_name')}}</th>
								<th>{{Lang::get('list_teacher.phone')}}</th>
								<th>{{Lang::get('list_teacher.cellphone')}}</th>
								<th>{{Lang::get('list_teacher.email')}}</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($teachers as $index => $teacher)
								<tr>
									<td width="140px;">
										@if($teacher->profile_image == null)
											<img id="image{{$index}}" src="images/140x140.png" alt="profesor"></td>
										@else
											<img id="image{{$index}}" src="{{Lang::get('show_image').'?src='.storage_path().$teacher->profile_image}}"/>
										@endif
									</td>
									<td>{{ $teacher->name }}</td>
									<td>{{ $teacher->last_name }}</td>
									<td>{{ $teacher->phone }}</td>
									<td>{{ $teacher->cellphone }}</td>
									<td id="email{{$index}}">{{ $teacher->email }}</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		@else
			<p>
				<a href="{{Lang::get('routes.add_teacher')}}">
					<i class="fa fa-plus" style="color: #0097A7;"></i> 
					{{Lang::get('list_teacher.add')}}
				</a>
			</p>
		@endif
	</div>
</div>
@stop
