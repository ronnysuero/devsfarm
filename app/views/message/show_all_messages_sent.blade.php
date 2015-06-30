@extends( Auth::user()->rank.'.master' )

@section('title', 'All Messages')

@section('content')
<script>
    $('document').ready(function() 
    {
        $(".checkbox").change(function()
        {
            console.log(this.checked);
            
            if( !$(this).is(':checked'))
                $("#delete_msg").removeClass("disabled");
            else
                console.log("Se ha quitado el check.");
        });

        $(".message").on("click", function()
        {
            console.log($(this).attr("id"));
            $('#editModal').modal('show');  
        });
    });
</script>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><i class="fa fa-envelope-o"></i> Mensajes enviados</h1>
        <button type="button" class="btn btn-danger disabled" id="delete_msg">Eliminar</button>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Destinatarios</th>
                            <th>Asunto</th>
                            <th>Contenido</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($messages as $index => $message)
                        <tr class="message" id="message_id{{$index+1}}">
                            <input type="hidden" name="id{{$index+1}}" value="{{$message->_id}}">
                            <td width="3%">
                                <div class="checkbox delete_message" id="id_del_mensaje" name="delete_message">
                                    <label> <input type="checkbox"> </label>
                                </div>
                            </td>
                            <?php $emails = MessageController::searchUsers($message->to); ?>
                            <td>
                                @foreach ($emails as $email)
                                    {{$email}}<br />
                                @endforeach
                            </td>
                            <td>{{$message->subject}}</td>
                            <td >
                                @if(strlen($message->body) > 70)
                                    {{substr($message->body, 0, 70);}} ...
                                @else
                                    {{$message->body}}
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="Ver mensaje" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel"><i class="fa fa-envelope-o"></i> Detalle del mensaje</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <h3 class="page-header"><i class="fa fa-user"></i> From: Narciso Nunez (narciso.arias21@gmailcom)</h3>
                            <h4>Subject: Herramienta utilizada en el proyecto</h4>
                            <p>A work breakdown structure is a key project deliverable that organizes the team's work into
                            manageable sections. The Project Management Body of Knowledge (PMBOK) defines the work
                            breakdown structure as a "deliverable oriented hierarchical decomposition of the work to be
                            executed by the project team." The work breakdown structure visually defines the scope into
                            manageable chunks that a project team can understand, as each level of the work breakdown
                            structure provides further definition and detail.
                            Figure 1(below) depicts a sample work breakdown structure with three levels defined.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop