@extends('university.master')
@section('title', Lang::get('university_title.show_subject'))
@section('content')
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header"><i class="fa fa-list"></i> {{Lang::get('list_subject.subject')}}</h1>
			<div class="panel-body">
				@if (count($subjects) > 0)
					<div class="table-responsive">
						@include('alert')
						<table id="tableOrder" class="table table-striped table-bordered table-hover tablesorter">
							<thead>
								<tr>
									<th>#</th>
									<th>{{Lang::get('list_subject.subject')}}</th>
									<th>{{Lang::get('list_subject.school')}}</th>
									<th>{{Lang::get('list_subject.section')}}</th>
									<th>{{Lang::get('list_subject.edit')}}</th>
									<th>{{Lang::get('list_subject.delete')}}</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($subjects as $index => $subject)
								<tr id="{{$index}}">
									<td>{{$index + 1}}</td>
									<td id="name{{$index+1}}">{{ $subject->name }}</td>
									<td>{{ $subject->school }}</td>
									<td>
										<?php $sections = $subject->sections()->whereNull('deleted_at')->get();?>
										@foreach ($sections as $item => $section)
											@if($item === 0)
												{{ $section->code }}
											@else
												, {{ $section->code }}
											@endif
										@endforeach
									</td>
									<td style="width: 6%">
										<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModal" onclick="fillModal('{{$index+1}}')"> 
											{{Lang::get('list_subject.edit')}}
										</button>
									</td>
									<td style="width: 6%">
										<button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal" onclick="$('#_id').val('{{$subject->_id}}'); $('#tr').val('{{$index}}')"> 
											{{Lang::get('list_subject.delete')}}
										</button>
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
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
		<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="Editar Asignatura" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myModalLabel"><i class="fa fa-edit"></i> {{Lang::get('list_subject.modify_subject')}}</h4>
					</div>
					<div class="modal-body">
						{{ Form::open(array('url' => Lang::get('routes.update_subject'), 'id' => 'register_form', 'role' => 'form')) }}
							<div class="form-group">
								<label>{{Lang::get('add_subject.name')}}</label>
								<input data-validate="required,size(5, 35),characterspace" class="form-control" id="subject_name" name="subject_name" placeholder="{{Lang::get('add_subject.name_placeholder')}}">
							</div>
							<div class="form-group">
								<label>{{Lang::get('add_subject.school')}}</label>
								<input data-validate="required,size(5, 35),characterspace" class="form-control" id="school" name="school" placeholder="{{Lang::get('add_subject.school_placeholder')}}">
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">{{Lang::get('list_subject.discard')}}</button>
								<button type="submit" class="btn btn-primary">{{Lang::get('list_subject.save')}}</button>
							</div>
							<input type="hidden" id="_id", name="_id" value="">            
						{{ Form::close() }}
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="Eliminar asignatura" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myModalLabel"><i class="fa fa-trash-o"></i> {{Lang::get('list_subject.delete_subject')}}</h4>
					</div>
					<div class="modal-body">
						{{Lang::get('list_subject.agree')}}
						<input type="hidden" value="" id="tr" />
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">{{Lang::get('list_subject.cancel')}}</button>
						<button onclick="dropSubject()" type="button" class="btn btn-danger">{{Lang::get('list_subject.delete')}}</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		function fillModal (x) 
		{
			$.post("{{Lang::get('routes.find_subject')}}",
			{ 
				name: $('#name'+x).html() 
			})
			.done(function( data ) 
			{
				$('#subject_name').val(data.name);
				$('#school').val(data.school);       
				$('#_id').val(data._id);
			});
		}

		function dropSubject()
		{
			$.post("{{Lang::get('routes.drop_subject')}}",
			{ 
				subject_id: $('#_id').val(), 
			})
			.done(function( data ) 
			{
				$('#deleteModal').modal('hide');

				if(data === '00')
					$('#' + $('#tr').val()).remove();
				else
					alertify.alert(data);
			});
		}
	</script>
@stop
