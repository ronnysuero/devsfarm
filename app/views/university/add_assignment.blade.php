@extends('master')
@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Asignar asignatura a profesor</h1>
        <div class="panel panel-default">
            <div class="panel-heading">
                Asignar asignatura a profesor
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2">
                        <form role="form">
                            <div class="form-group">
                                <label>Profesor</label>
                                <select class="form-control" id="professor" name="professor">
                                    <option value="">Seleccione un profesor</option>
                                    <option value="1">1</option>
                                    <option value="">2</option>
                                    <option value="">3</option>
                                    <option value="">4</option>
                                    <option value="">5</option>
                                </select>
                            </div>
                           <div class="form-group">
                                <label>Asignatura</label>
                                <select class="form-control" id="subject" name="subject">
                                    <option value="">Seleccione una asignatura</option>
                                    <option value="1">1</option>
                                    <option value="">2</option>
                                    <option value="">3</option>
                                    <option value="">4</option>
                                    <option value="">5</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Secciones</label>
                                <select multiple class="form-control" id="sections" name="sections">
                                    <option value="1">1</option>
                                    <option value="">2</option>
                                    <option value="">3</option>
                                    <option value="">4</option>
                                    <option value="">5</option>
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