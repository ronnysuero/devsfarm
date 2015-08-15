@extends('student.master')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><i class="fa fa-plus"></i> {{Lang::get('register_group.register')}}</h1>
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            {{Lang::get('register_group.register')}}
                        </div>
                        @include('alert')
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    {{ Form::open(array('url' => Lang::get('routes.register_group'), 'id' => 'register_form', 'role' => 'form','enctype' => 'multipart/form-data')) }}
                                    <div class="form-group">
                                        <label>{{Lang::get('register_group.name')}}</label>
                                        <input data-validate="required,size(3, 20),characterspace" type="text" class="form-control" id="name" name="name" placeholder="{{Lang::get('register_group.name_placeholder')}}" >
                                    </div>

                                    <div class="form-group">
                                        <label>{{Lang::get('register_group.Code_secction')}}</label>
                                        <input data-validate="required,size(3, 20),characterspace" type="text" class="form-control" id="idSubject" name="idSubject" placeholder="{{Lang::get('register_group.name_placeholder')}}" >
                                    </div>


                                    <div class="form-group">
                                        <label>{{Lang::get('register_group.project_name')}}</label>
                                        <input data-validate="required,size(3, 50),characterspace" type="text" class="form-control" id="project_name" name="project_name" placeholder="{{Lang::get('register_group.name_placeholder')}}" >

                                    </div>

                                    <div class="form-group">
                                        <label>{{Lang::get('register_group.logo')}}</label>
                                        <input data-validate="image" type="file" id="photo" name="photo" accept="image/x-png, image/gif, image/jpeg" onchange="PreviewImage()">
                                    </div>
                                    <div class="form-group">
                                        <img src="images/140x140.png" alt="" style="width: 140px; height: 140px;" id="photo_display" name="photo_display">
                                    </div>

                                    <button type="submit" class="btn btn-default pull-right">{{Lang::get('register_group.register')}}</button>
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
