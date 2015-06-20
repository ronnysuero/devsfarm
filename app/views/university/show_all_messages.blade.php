@extends('university.master')
@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><i class="fa fa-envelope-o"></i> Mensajes</h1>

            <button type="button" class="btn btn-danger disabled" id="delete_msg">Eliminar</button>
            <div class="panel-body">
                {{--@if (count($subjects) >= 1)--}}
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Remitente</th>
                                <th>Asunto</th>
                                <th>Contenido</th>
                            </tr>
                            </thead>
                            <tbody>

                            {{--@foreach ($subjects as $subject)--}}

                                <tr class="message" id="id_del_mensaje">
                                    <td width="3%">
                                        <div class="checkbox delete_message" id="id_del_mensaje" name="delete_message">
                                            <label>
                                                <input type="checkbox">
                                            </label>
                                        </div>
                                    </td>
                                    <td width="22%">Narciso Nunez</td>
                                    <td width="40%">Herramienta utilizada en el proyecto</td>
                                    <td width="35%">A work breakdown structure is a key project deliverable that organizes...</td>
                                </tr>
                            {{--@endforeach--}}
                            </tbody>
                        </table>
                    </div>
                {{--@else--}}
                    {{--<p><a href="{{URL::to('send_message')}}"><i class="fa fa-plus" style="color: #0097A7;"></i> Enviar mensaje</a></p>--}}
                {{--@endif--}}
            </div>
        </div>
    </div>
<script>
    $(".checkbox").change(function(){
        console.log(this.checked);
        if( !$(this).is(':checked')){
            $("#delete_msg").removeClass("disabled");
        } else{
            console.log("Se ha quitado el check.");
        }
    });
    $(".message").on("click", function(){
        console.log($(this).attr("id"));
        window.location.replace('show_message');
    });

</script>
@stop