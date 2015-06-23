@extends('university.master')
@section('content')
<div class="row">
    <div class="col-lg-12">
       <h1 class="page-header"><i class="fa fa-plus"></i> Registrar Asignatura</h1>
       <div class="row">
           <div class="col-lg-8 col-lg-offset-2">
               <div class="panel panel-default">
                <div class="panel-heading">
                    Registrar Asignatura
                </div>
                @if(Session::has('message'))
                  <div class="alert alert-success alert-dismissable">
                   <button type="button" class="close" data-dismiss="alert" aria-hidden="true"
                        onclick="$('.alert.alert-success.alert-dismissable').hide('slow')">
                        &times;
                     </button>
                     {{Session::get('message')}}
                  </div>
                @endif
                <div class="panel-body">

                    <div class="row">
                        <div class="col-lg-12">
                            {{ Form::open(array('url' => Lang::get('routes.add_subject'), 'id' => 'register_form', 'role' => 'form')) }}
                                <div class="form-group">
                                    <label>Nombre asignatura</label>
                                    <input data-validate="required,size(5, 15),characterspace" class="form-control" id="subject_name" name="subject_name" placeholder="Nombre Asignatura">
                                </div>
                                <div class="form-group">
                                    <label>Escuela</label>
                                    <input data-validate="required,size(5, 25),characterspace" class="form-control" id="division" name="division" placeholder="Escuela">
                                </div>
                                <div class="form-group">
                                    <label>Secciones</label>
                                    <input data-validate="required,size(4, 30),charactercomma" class="form-control" id="section" name="section" placeholder="Secciones separadas por coma">
                                    <p class="help-block">Las secciones deben separar se por coma. 1, 2, 3</p>
                                </div>
                                <button type="submit" class="btn btn-default pull-right">Registrar</button>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
           </div>
       </div>
   </div>
</div>
@stop
