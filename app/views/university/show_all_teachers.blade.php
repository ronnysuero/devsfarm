@extends('university.master')
@section('content')
<script type="text/javascript">
	function fillModal (x) {
		$.post("{{Lang::get('routes.find_teacher')}}",{ email: $('#email'+x).html() }).done(function( data ) {
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
</script>
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header"><i class="fa fa-group"></i> {{Lang::get('list_teacher.teacher')}}</h1>
		<div class="panel-body">
			@if (count($teachers) >= 1)
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
							<th>{{Lang::get('list_teacher.modify_disable')}}</th>
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

							</td>
							<td>{{ $teacher->name }}</td>
							<td>{{ $teacher->last_name }}</td>
							<td>{{ $teacher->phone }}</td>
							<td>{{ $teacher->cellphone }}</td>
							<td id="email{{$index}}">{{ $teacher->email }}</td>
							<td width="80px;">
								<a onclick="fillModal('{{$index}}')" href="#"><i class="fa fa-edit" data-toggle="modal" data-target="#editModal" style="color:#337ab7;"></i></a>
								<a href="#" class="pull-right"><i class="fa fa-trash-o" data-toggle="modal" data-target="#deleteModal" style="color:#d9534f;"></i></a>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			@else
			<p><a href="{{Lang::get('routes.add_teacher')}}"><i class="fa fa-plus" style="color: #0097A7;"></i>{{Lang::get('list_teacher.add')}}</a></p>
			@endif
		</div>
	</div>
</div>
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="Modificar profesor" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="Eliminar profesor"><i class="fa fa-edit"></i> Modificar profesor</h4>
			</div>
			<div class="modal-body">
				{{ Form::open(array('url' => Lang::get('routes.update_teacher'), 'id' => 'register_form', 'role' => 'form', 'enctype' => 'multipart/form-data')) }}
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
				<div class="form-group col-lg-12">
					<label>{{Lang::get('list_teacher.photo')}}</label>
					<input data-validate="image" type="file" id="photo" name="photo" accept="image/x-png, image/gif, image/jpeg" onchange="PreviewImage()">
				</div>
				<div class="form-group">
					<label></label>
					<img src="images/140x140.png" alt="" style="width: 140px; height: 140px;" id="photo_display" name="photo_display">
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Discard</button>
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
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">{{Lang::get('list_teacher.cancel')}}</button>
				<button type="button" class="btn btn-primary">{{Lang::get('list_teacher.disable')}}</button>
			</div>
		</div>
	</div>
</div>
@stop
