@extends('university.master')
@section('title', Lang::get('university_title.show_teacher'))
@section('content')
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header"><i class="fa fa-group"></i> {{Lang::get('list_teacher.teacher')}}</h1>
			<div class="panel-body">
				@if (count($teachers) > 0)
					<div class="table-responsive">
						@include('alert')
						<table id="tableOrder" class="table table-striped table-bordered table-hover tablesorter">
							<thead>
								<tr>
									<th>{{Lang::get('list_teacher.photo')}}</th>
									<th>{{Lang::get('list_teacher.name')}}</th>
									<th>{{Lang::get('list_teacher.last_name')}}</th>
									<th>{{Lang::get('list_teacher.phone')}}</th>
									<th>{{Lang::get('list_teacher.cellphone')}}</th>
									<th>{{Lang::get('list_teacher.email')}}</th>
									<th>{{Lang::get('list_subject.edit')}}</th>
									<th>{{Lang::get('list_subject.delete')}}</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($teachers as $index => $teacher)
									<tr id="{{$index}}">
										<td width="140px;">
											@if(is_null($teacher->profile_image))
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
										<td style="width: 6%">
											<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModal" onclick="fillModal('{{$index}}')"> 
												{{Lang::get('list_subject.edit')}}
											</button>
										</td>
										<td style="width: 6%">
											<button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal" onclick="$('#_id').val('{{$teacher->_id}}'); $('#tr').val('{{$index}}')"> 
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
						<a href="{{Lang::get('routes.add_teacher')}}">
							<i class="fa fa-plus" style="color: #0097A7;"></i>
							{{Lang::get('list_teacher.add')}}
						</a>
					</p>
				@endif
			</div>
		</div>
	</div>
	<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="Modificar profesor" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
						&times;
					</button>
					<h4 class="modal-title" id="Eliminar profesor">
						<i class="fa fa-edit"></i>{{Lang::get('list_teacher.modify_teacher')}}
					</h4>
				</div>
				<div class="modal-body">
					{{ Form::open(array('url' => Lang::get('routes.update_teachers'), 'id' => 'register_form', 'role' => 'form', 'enctype' => 'multipart/form-data')) }}
						<div class="form-group col-lg-6">
							<label>{{Lang::get('list_teacher.name')}}</label>
							<input data-validate="required,size(3, 20),characterspace" type="text" class="form-control" id="name" name="name" placeholder="{{Lang::get('register_teacher.name_placeholder')}}" >
						</div>
						<div class="form-group col-lg-6">
							<label>{{Lang::get('list_teacher.last_name')}}</label>
							<input data-validate="required,size(3, 20),characterspace" type="text" class="form-control" id="last_name" name="last_name" placeholder="{{Lang::get('register_teacher.last_name_placeholder')}}" >
						</div>
						<div class="form-group col-lg-6">
							<label>{{Lang::get('list_teacher.phone')}}</label>
							<input data-validate="required,phone" type="text" class="form-control" id="phone" name="phone" placeholder="{{Lang::get('register_teacher.phone_placeholder')}}">
						</div>
						<div class="form-group col-lg-6">
							<label>{{Lang::get('list_teacher.cellphone')}}</label>
							<input data-validate="required,phone" type="text" class="form-control" id="cellphone" name="cellphone" placeholder="{{Lang::get('register_teacher.cellphone_placeholder')}}">
						</div>
						<div class="form-group col-lg-12">
							<label>{{Lang::get('list_teacher.email')}}</label>
							<input data-validate="required,email" type="email" class="form-control" id="email" name="email" placeholder="{{Lang::get('register_teacher.email_placeholder')}}" >
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">{{Lang::get('list_teacher.cancel')}}</button>
						<button type="submit" class="btn btn-primary">{{Lang::get('list_teacher.save')}}</button>
					</div>
					<input type="hidden" id="_id", name="_id" value="">
				{{ Form::close() }}
			</div>
		</div>
	</div>
	<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="Eliminar profesor" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="Eliminar profesor"><i class="fa fa-trash-o"></i> {{Lang::get('list_teacher.confirm')}}</h4>
				</div>
				<div class="modal-body">
					{{Lang::get('list_teacher.agree')}}
					<input type="hidden" value="" id="tr" />
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">{{Lang::get('list_teacher.cancel')}}</button>
					<button onclick="dropTeacher();" type="button" class="btn btn-danger">{{Lang::get('list_teacher.disable')}}</button>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		function fillModal (x) 
		{
			$.post("{{Lang::get('routes.find_teacher')}}",
			{ 
				email: $('#email'+x).html() 
			})
			.done(function( data ) 
			{
				$('#name').val(data.name);
				$('#last_name').val(data.last_name);       
				$('#phone').val(data.phone);
				$('#cellphone').val(data.cellphone);
				$('#email').val(data.email);
				$('#photo_display').attr('src', $('#image'+x).attr('src'));
				$('#photo').val('');
				$('#_id').val(data._id);
			});
		}

		function dropTeacher()
		{
			$.post("{{Lang::get('routes.drop_teacher')}}",
			{ 
				teacher_id: $('#_id').val()
			})
			.done(function( data ) 
			{
				if(data === '00')
				{
					$('#' + $('#tr').val()).remove();
					$('#deleteModal').modal('hide');
				}
			});
		}
	</script>
@stop
	