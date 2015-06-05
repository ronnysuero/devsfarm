@extends('university.master')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Asignaciones</h1>
        <div class="panel-body">
        	@if (count($assignments) >= 1)
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Foto</th>
                            <th>Profesor</th>
                            <th>Asignaturas</th>
                            <th>Secciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    	<?php $i=1 ?>
                        @foreach ($assignments as $assignment)
                        <tr>
                            <td width="150px;"><img src="http://placehold.it/140x140" alt="profesor"></td>
                            <td>{{ $assigment->photo }}</td>
                            <td>{{ $assigment->name " " $assigment->last_name }}</td>
                            <td>{{ $assigment->sections }}</td>
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