@extends('teacher.master')

@section('title', 'Report - Farm')
@stop
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Report</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-group"></i> Integrantes</h3>
            <hr/>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4" style="overflow: hidden; margin-bottom: 5px;">
                <div class="pull-left" style="margin-right: 5px;">
                    <img src="http://placehold.it/140x140" alt=""/>
                </div>
                <div style="margin-left: 5px; ">
                    Narciso Nunez (TL) <br/>
                    100094304<br/>
                    narciso.arias21@gmail.com<br/>
                    <strong>Trabaja:</strong> Si<br/>
                    <strong>Telefono:</strong> 809-000-0000<br/>
                    <strong>Celular:</strong> 809-000-0000
                </div>
        </div>
        <div class="col-lg-4" style="overflow: hidden; margin-bottom: 5px;">
            <div class="pull-left" style="margin-right: 5px;">
                <img src="http://placehold.it/140x140" alt=""/>
            </div>
            <div style="margin-left: 5px; ">
                Narciso Nunez (TL) <br/>
                100094304<br/>
                narciso.arias21@gmail.com<br/>
                <strong>Trabaja:</strong> Si<br/>
                <strong>Telefono:</strong> 809-000-0000<br/>
                <strong>Celular:</strong> 809-000-0000
            </div>
        </div>
        <div class="col-lg-4" style="overflow: hidden; margin-bottom: 5px;">
            <div class="pull-left" style="margin-right: 5px;">
                <img src="http://placehold.it/140x140" alt=""/>
            </div>
            <div style="margin-left: 5px; ">
                Narciso Nunez (TL) <br/>
                100094304<br/>
                narciso.arias21@gmail.com<br/>
                <strong>Trabaja:</strong> Si<br/>
                <strong>Telefono:</strong> 809-000-0000<br/>
                <strong>Celular:</strong> 809-000-0000
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-list-alt"></i> Asignaciones</h3>
            <hr/>
        </div>
    </div>

    <div class="well well-sm" style="padding-left: 25px;">
    <div class="row">
        <div class="col-lg-12">
            <div class="row">

                    <div class="co-lg-4"><strong>Total de asignaciones:</strong> 45 </div>
                    <div class="co-lg-4"><strong>Total completadas:</strong> 27</div>
                    <div class="co-lg-4"><strong>Total pendientes:</strong> 18</div>
                </div>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Narciso Nunez
                </div>
                <div class="panel-body">
                    <div class="flot-chart">
                        <div class="flot-chart-content flot-pie-chart"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Leticia Reyes
                </div>
                <div class="panel-body">
                    <div class="flot-chart">
                        <div class="flot-chart-content flot-pie-chart"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script type="text/javascript" src="http://cdn.jsdelivr.net/jquery.flot/0.8.3/jquery.flot.min.js"></script>
    <script>

        var data = [],
                series = Math.floor(Math.random() * 6) + 3;

        for (var i = 0; i < series; i++) {
            data[i] = {
                label: "Series" + (i + 1),
                data: Math.floor(Math.random() * 100) + 1
            }
        }
        function setCode(lines) {
            $("#code").text(lines.join("\n"));
        }
        var placeholder = $(".flot-pie-chart").unbind();

        for(var i = 0; i<placeholder.length; i++){
            placeholder.unbind();

            $.plot(placeholder, data, {
                series: {
                    pie: {
                        show: true,
                        combine: {
                            color: "#999",
                            threshold: 0.05
                        }
                    }
                },
                legend: {
                    show: true
                }
            });
        }

    </script>
@stop