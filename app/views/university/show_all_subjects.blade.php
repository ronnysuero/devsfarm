@extends('university.master')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><i class="fa fa-list"></i> Asignaturas</h1>
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
                            <th>Secciones</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1 ?>
                        @foreach ($subjects as $subject)
                        <tr>
                            <td><?php echo $i ?></td>
                            <td><a href="#"><i class="fa fa-edit" data-toggle="modal" data-target="#editModal" style="color:#337ab7;"></i></a></td>
                            <td>{{ $subject->name }}</td>
                            <td>{{ $subject->division }}</td>
                            <td>
                                @foreach ($subject->sections as $section)
                                    {{ $section }},
                                @endforeach
                            </td>
                            <td><a href="" data-toggle="modal" data-target="#deleteModal" ><i class="fa fa-trash-o" style="color:#d9534f;"></i></a></td>
                        </tr>
                        <?php $i++ ?>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
                <p><a href="{{Lang::get('routes.add_subject')}}"><i class="fa fa-plus" style="color: #0097A7;"></i> Agregar asignatura</a></p>
            @endif
        </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="Editar Asignatura" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel"><i class="fa fa-edit"></i> Modificar asignatura</h4>
                </div>
                <div class="modal-body">
                    {{ Form::open(array('url' => Lang::get('routes.update_subject'), 'id' => 'register_form', 'role' => 'form')) }}
                    <div class="form-group">
                        <label>Nombre asignatura</label>
                        <input class="form-control" id="subject_name" name="subject_name" placeholder="Nombre Asignatura" required>
                    </div>
                    <div class="form-group">
                        <label>Escuela</label>
                        <input class="form-control" id="division" name="division" placeholder="Escuela" required>
                    </div>
                    <div class="form-group">
                        <label>Secciones</label>
                        <input class="form-control" id="section" name="section" placeholder="Secciones separadas por coma" required>
                        <p class="help-block">Las secciones deben separar se por coma. 1, 2, 3</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Discard</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="Eliminar asignatura" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel"><i class="fa fa-trash-o"></i> Eliminar esta asignatura?</h4>
                </div>
                <div class="modal-body">
                    Al eliminar este asignatura no podra ser asignada a ningun maestro ni mostradas en las asignaturas.
                    Pero esto no afectara a las secciones que ya han realizado esta asignatura.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary">Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
