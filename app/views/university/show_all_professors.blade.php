@extends('master')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Profesores</h1>
        <div class="panel-body">
        	@if (count($professors) >= 1)
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
                        @foreach ($professors as $professor)
                        <tr>
                            <td width="150px;"><img src="http://placehold.it/140x140" alt="profesor"></td>
                            <td>{{ $professor->name }}</td>
                            <td>{{ $professor->last_name }}</td>
                            <td>{{ $professor->phone }}</td>
                            <td>{{ $professor->cellphone }}</td>
                            <td>{{ $professor->email }}</td>
                            <td width="80px;">
                                <a href=""><i class="fa fa-edit" style="color:#337ab7;"></i></a>
                                <a href="" class="pull-right"><i class="glyphicon glyphicon-remove" style="color:#d9534f;"></i></a>
                            </td>
                        </tr>
                        <?php $i++ ?>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop