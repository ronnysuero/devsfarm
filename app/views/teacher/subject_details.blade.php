@extends('teacher.master')

@section('title', 'Subject Details')
@stop

@section('content')
<div class="row">
    <h1 class="page-header"></h1>
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-group fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">4</div>
                                <div>Integrantes</div>
                            </div>
                        </div>
                    </div>

                    <div class="panel-footer">
                        Narciso Nunez - TeamLeader <a href="#"  data-toggle="modal" data-target="#studentDetailsModal">
                            <i class="fa fa-external-link"></i></a><br>
                        Leticia Reyes <a href="#"><i class="fa fa-external-link"></i></a><br>
                        Ronny Suero <a href="#"><i class="fa fa-external-link"></i></a>
                        <br><br>
                        <a href="#">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </a>
                    </div>

                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="panel panel-green">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-group fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">2</div>
                                <div>Integrantes</div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        Narciso Nunez - TeamLeader <a href="#"><i class="fa fa-external-link"></i></a><br>
                        Leticia Reyes <a href="#"><i class="fa fa-external-link"></i></a>
                        <br><br>
                        <a href="#">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="panel panel-yellow">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-group fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">2</div>
                                <div>Integrantes</div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        Ronny Suero <a href="#"><i class="fa fa-external-link"></i></a><br>
                        Leticia Reyes <a href="#"><i class="fa fa-external-link"></i></a>
                        <br><br>
                        <a href="#">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="panel panel-red">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-group fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">2</div>
                                <div>Integrantes</div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        Ronny Suero <a href="#"><i class="fa fa-external-link"></i></a><br>
                        Leticia Reyes <a href="#"><i class="fa fa-external-link"></i></a>
                        <br><br>
                        <a href="#">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-group fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">2</div>
                                <div>Integrantes</div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        Ronny Suero <a href="#"><i class="fa fa-external-link"></i></a><br>
                        Leticia Reyes <a href="#"  data-toggle="modal" data-target="#studentDetailsModal">
                                        <i class="fa fa-external-link"></i></a>
                        <br><br>
                        <a href="#">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>

<div class="modal fade" id="studentDetailsModal" tabindex="-1" role="dialog" aria-labelledby="Register University" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel" style="color: #26A69A;"><i class="fa fa-eye"></i> Information</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-3"><img src="http://placehold.it/150x150" alt=""/></div>
                    <div class="col-lg-8" style="margin-left: 10px; font-size: 1.2em;">

                        <table class="table">
                            <tr><th>Nombre</th><td>Narciso Nunez - Team Leader</td></tr>
                            <tr><th>Matricula</th> <td>10094304</td></tr>
                            <tr><th>Correo</th> <td>narciso.arias21@gmail.com</td></tr>
                            <tr><th>Trabaja</th> <td>Si</td></tr>
                            <tr><th>Telefono</th> <td>809-000-0000</td></tr>
                            <tr><th>Celular</th> <td>809-000-2333</td></tr>
                            <tr><th>Sexo</th> <td>Masculino</td></tr>
                        </table>
                    </div>
                </div>
                <hr />
            </div>
        </div>
    </div>
</div>
@stop