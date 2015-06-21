@extends('university.master')

@section('title', 'Dashboard - University')
@stop
@section('content')
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Asignaturas</h1>
        @if (count($subjects) >= 1)
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Asignatura</th>
                            <th>Escuela</th>
                            <th>Secciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1 ?>
                        @foreach ($subjects as $subject)
                        <tr>
                            <td><?php echo $i ?></td>
                            <td>{{ $subject->name }}</td>
                            <td>{{ $subject->division }}</td>
                            <td>
                                @foreach ($subject->sections as $section)
                                    {{ $section->code }},
                                @endforeach
                            </td>
                        </tr>
                        <?php $i++ ?>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @else
            <p><a href="{{Lang::get('routes.add_subject')}}"><i class="fa fa-plus" style="color: #0097A7;"></i> Agregar asignaturas</a></p>
        @endif
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Profesores</h1>
        @if (count($teachers) >= 1)
        <div class="panel-body">
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
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1 ?>
                        @foreach ($teachers as $teacher)
                        <tr>
                            <td width="150px;"><img src="" alt="profesor"></td>
                            <td>{{ $teacher->name }}</td>
                            <td>{{ $teacher->last_name }}</td>
                            <td>{{ $teacher->phone }}</td>
                            <td>{{ $teacher->cellphone }}</td>
                            <td>{{ $teacher->email }}</td>
                        </tr>
                        <?php $i++ ?>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @else
            <p><a href="{{Lang::get('routes.add_teacher')}}"><i class="fa fa-plus" style="color: #0097A7;"></i> Agregar profesores</a></p>
        @endif
    </div>
</div>
@stop
