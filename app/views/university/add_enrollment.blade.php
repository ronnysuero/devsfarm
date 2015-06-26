@extends('university.master')
@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><i class="fa fa-plus"></i> Asignar asignatura a profesor</h1>
        <div class="panel panel-default">
            <div class="panel-heading">
                Asignar asignatura a profesor
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2">
                        <form role="form">
                            <div class="form-group">
                                <label>Asignatura</label>
                                <select class="form-control" id="subject" name="subject">
                                    <option value="">Seleccione una asignatura</option>
                                    @foreach($subjects as $subject)
                                        <option value="{{ $subject->_id  }}">{{ $subject->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Seccion</label>
                                <select class="form-control" id="section" name="section">
                                    <option value="">Select Section</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Profesor</label>
                                <select class="form-control" id="teacher" name="teacher">
                                    <option value="">Select Teacher</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-default pull-right">Registrar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
   </div>
</div>
@stop