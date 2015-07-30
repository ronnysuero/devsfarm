@extends('student.master')

@section('title', 'Dashboard - Teacher')
@stop
@section('content')
    <div class="col-lg-12">
        <h1 class="page-header">Diagrama de Gantt</h1>
        <IMG SRC="images/gantt2.jpg" ALT="gantt" WIDTH=1025 HEIGHT=200>
    </div>

    <div class="col-lg-12">
        <h1 class="page-header">Nombre del Proyecto</h1>


        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th></th>
                    <th>{{Lang::get('list_assignment.description')}}</th>
                    <th>{{Lang::get('list_assignment.state')}}</th>
                    <th>{{Lang::get('list_assignment.assigned_to')}}</th>
                    <th>{{Lang::get('list_assignment.assigned_by')}}</th>
                    <th>{{Lang::get('list_assignment.deadline')}}</th>
                    <th>
                        <a href="#" data-toggle="modal" data-target="#registerModal"><i class="fa fa-plus"></i></a>
                        <i class="fa fa-minus"></i>
                        <i class="fa fa-pencil"></i>
                    </th>


                    <th></th>

                </thead>
                <tbody >

                <tr>
                    <td><label> <input type="checkbox" id=""> </label></td>
                    <td>Realizar Diagrama de Actividades</td>
                    <td>Completada</td>
                    <td>Leticia </td>
                    <td>Narciso</td>
                    <td>12/05/2015</td>
                    <td><button type="button" class="btn btn-warning  btn-sm">Asignar</button></td>
                    <td></td>

                </tr>

                <tr>
                    <td><label> <input type="checkbox" id=""> </label></td>
                    <td>Realizar Diagrama de Actividades</td>
                    <td>Completada</td>
                    <td>Leticia </td>
                    <td>Narciso</td>
                    <td>12/05/2015</td>
                    <td><button type="button" class="btn btn-warning  btn-sm">Asignar</button></td>
                    <td></td>

                </tr>


                <tr>
                    <td><label> <input type="checkbox" id=""> </label></td>
                    <td>Realizar Diagrama de Actividades</td>
                    <td>Completada</td>
                    <td>Leticia </td>
                    <td>Narciso</td>
                    <td>12/05/2015</td>
                    <td><button type="button" class="btn btn-warning btn-sm" >Asignar</button></td>
                    <td></td>

                </tr>

                </tbody>
            </table>
        </div>
    </div>


    </div>
@stop

<div class="modal fade" id="registerModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{{Lang::get("register_assignment.register_assignment")}}</h4>
            </div>
            <div class="modal-body">
                @if($errors->has('error'))
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert"
                                aria-hidden="true" onclick="$('.alert.alert-danger.alert-dismissable').hide('slow')">
                            &times;
                        </button>
                        {{ $errors->first('error') }}
                    </div>
                @endif
                {{ Form::open(array('url' => Lang::get('routes.register_university'), 'style' => 'overflow: hidden; color: #26A69A;', 'id' => 'register_form')) }}

                {{Form::close()}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{Lang::get("register_assignment.close_button")}}</button>
                <button type="button" class="btn btn-primary">{{Lang::get("register_assignment.save_button")}}</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
>>>>>>> leticia
