@extends('university.master')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><i class="fa fa-group"></i> Profesores</h1>
        <div class="panel-body">
        	@if (count($teachers) >= 1)
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Foto</th>
                            <th>Nombres</th>
                            <th>Apellidos</th>
                            <th>Telefono</th>
                            <th>Celular</th>
                            <th>Email</th>
                            <th>Modificar Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                    	<?php $i=1 ?>
                        @foreach ($teachers as $teacher)
                        <tr>
                            <td width="150px;"><img src="http://placehold.it/140x140" alt="profesor"></td>
                            <td>{{ $teacher->name }}</td>
                            <td>{{ $teacher->last_name }}</td>
                            <td>{{ $teacher->phone }}</td>
                            <td>{{ $teacher->cellphone }}</td>
                            <td>{{ $teacher->email }}</td>
                            <td width="80px;">
                                <a href="#"><i class="fa fa-edit" data-toggle="modal" data-target="#editModal" style="color:#337ab7;"></i></a>
                                <a href="#" class="pull-right"><i class="fa fa-trash-o" data-toggle="modal" data-target="#deleteModal" style="color:#d9534f;"></i></a>
                            </td>
                        </tr>
                        <?php $i++ ?>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
                <p><a href="{{URL::to('add_teacher')}}"><i class="fa fa-plus" style="color: #0097A7;"></i> Agregar profesor</a></p>
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
                {{ Form::open(array('url' => 'update_teacher', 'id' => 'register_form', 'role' => 'form')) }}
                <div class="form-group col-lg-6">
                    <label>Nombres</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Nombres" required>
                </div>
                <div class="form-group col-lg-6">
                    <label>Apellidos</label>
                    <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Apellidos" required>
                </div>
                <div class="form-group col-lg-6">
                    <label>Telefono</label>
                    <input type="text" class="form-control" id="phone" name="phone" placeholder="Telefono">
                </div>
                <div class="form-group col-lg-6">
                    <label>Celular</label>
                    <input type="text" class="form-control" id="cellphone" name="cellphone" placeholder="Celular">
                </div>
                <div class="form-group col-lg-12">
                    <label>Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                </div>
                <div class="form-group col-lg-12">
                    <label>Foto</label>
                    <input type="file" id="photo" name="photo">
                </div>
                <div class="form-group">
                    <label></label>
                    <img src="http://placehold.it/140x140" alt="" id="photo_display" name="photo_display">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Discard</button>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
            {{ Form::close() }}

        </div>
    </div>
</div>
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="Eliminar profesor" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="Eliminar profesor"><i class="fa fa-trash-o"></i> Eliminar este profesor?</h4>
            </div>
            <div class="modal-body">
                Al eliminar este profesor no podra ser asignado a ninguna asignatura ni mostrado en los profesores.
                Pero esto no afectara a las secciones que ya han realizado este profesor.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary">Delete</button>
            </div>
        </div>
    </div>
</div>
@stop