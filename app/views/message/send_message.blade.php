@extends( Auth::user()->rank.'.master' )

@section('title', 'Send Message')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"></h1>
            <div class="row">
                <div class="col-lg-10 col-lg-offset-1">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-send"></i> Enviar mensaje
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
                                    {{ Form::open(array('url' => Lang::get('routes.send_message'), 'id' => 'sendMessage_form', 'role' => 'form')) }}
                                    <div class="form-group">
                                        <label>To:</label>
                                        <input class="form-control" id="receptor" name="receptor" placeholder="Email del receptor" required>
                                        <p class="help-block">Separar por coma ',' para enviar a varios destinatarios</p>
                                    </div>
                                    <div class="form-group">
                                        <label>Subject</label>
                                        <input class="form-control" id="subject" name="subject" placeholder="Asunto" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Content</label>
                                        <textarea class="form-control" rows="5" id="content" name="content"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-default pull-right">Enviar</button>
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
