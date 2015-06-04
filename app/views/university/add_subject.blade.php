@extends('master')
@section('content')
<div class="row">
    <div class="col-lg-12">
       <h1 class="page-header">Registrar Asignatura</h1>
       <div class="row">
           <div class="col-lg-8 col-lg-offset-2">
               <div class="panel panel-default">
                <div class="panel-heading">
                    Registrar Asignatura
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <form role="form">
                                <div class="form-group">
                                    <label>Nombre asignatura</label>
                                    <input class="form-control" id="subject_name" name="subject_name" placeholder="Nombre Asignatura">
                                </div>
                                <div class="form-group">
                                    <label>Escuela</label>
                                    <input class="form-control" id="division" name="division" placeholder="Escuela">
                                </div>
                                <div class="form-group">
                                    <label>Secciones</label>
                                    <input class="form-control" id="section" name="section" placeholder="Secciones separadas por coma">
                                    <p class="help-block">Las secciones deben separar se por coma. 1, 2, 3</p>
                                </div>
                                <button type="submit" class="btn btn-default pull-right">Registrar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
           </div>
       </div>
        
   </div>
</div>
@stop