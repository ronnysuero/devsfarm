@extends( Auth::user()->rank.'.master' )

@section('title', Lang::get('send_message.title'))

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"></h1>
            <div class="row">
                <div class="col-lg-10 col-lg-offset-1">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-send"></i> {{Lang::get('send_message.title')}}
                        </div>
                        @include('alert')
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    {{ Form::open(array('url' => Lang::get('routes.send_message'), 'id' => 'sendMessage_form', 'role' => 'form')) }}
                                    <div class="form-group">
                                        <label>{{Lang::get('send_message.to')}}</label>
                                        <input data-validate="required,validateMail" class="form-control" id="receptor" name="receptor" placeholder="{{Lang::get('send_message.to_placeholder')}}">
                                        <p class="help-block">{{Lang::get('send_message.to_title')}}</p>
                                    </div>
                                    <div class="form-group">
                                        <label>{{Lang::get('send_message.subject')}}</label>
                                        <input data-validate="required" class="form-control" id="subject" name="subject" placeholder="{{Lang::get('send_message.subject_placeholder')}}">
                                    </div>
                                    <div class="form-group">
                                        <label>{{Lang::get('send_message.body')}}</label>
                                        <textarea class="form-control" rows="5" id="content" name="content"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-default pull-right">{{Lang::get('send_message.title')}}</button>
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
