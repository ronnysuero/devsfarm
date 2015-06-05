@extends('master')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Asignaturas</h1>
        <div class="panel-body">
            @if (count($subjects) >= 1)
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Editar</th>
                            <th>Asignatura</th>
                            <th>Escuela</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1 ?>
                        @foreach ($subjects as $subject)
                        <tr>
                            <td><?php echo $i ?></td>
                            <td><a href="{{ $subject->_id }}"><i class="fa fa-edit" style="color:#337ab7;"></i></a></td>
                            <td>{{ $subject->name }}</td>
                            <td>{{ $subject->division }}</td>
                            <td><a href="{{ $subject->_id }}"><i class="glyphicon glyphicon-remove" style="color:#d9534f;"></i></a></td>
                        </tr>
                        <?php $i++ ?>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
                <p><a href="flot.html"><i class="fa fa-plus" style="color: #0097A7;"></i> Agregar asignatura</a></p>
            @endif
        </div>
    </div>
</div>
@stop