@extends('university.master')
@section('content')
<div class="row">
    <div class="col-lg-12">
       <h1 class="page-header"><i class="fa fa-plus"></i> {{Lang::get('register_teacher.register')}}</h1>
       <div class="row">
           <div class="col-lg-8 col-lg-offset-2">
               <div class="panel panel-default">
                <div class="panel-heading">
                    {{Lang::get('register_teacher.register')}}
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
                            {{ Form::open(array('url' => Lang::get('routes.add_teacher'), 'id' => 'register_form', 'role' => 'form','enctype' => 'multipart/form-data')) }}
                                <div class="form-group">
                                    <label>{{Lang::get('register_teacher.name')}}</label>
                                    <input data-validate="required,size(3, 20),characterspace" type="text" class="form-control" id="name" name="name" placeholder="{{Lang::get('register_teacher.name_placeholder')}}" >
                                </div>
                                <div class="form-group">
                                    <label>{{Lang::get('register_teacher.last_name')}}</label>
                                    <input data-validate="required,size(3, 20),characterspace" type="text" class="form-control" id="last_name" name="last_name" placeholder="{{Lang::get('register_teacher.last_name_placeholder')}}" >
                                </div>
                                <div class="form-group">
                                    <label>{{Lang::get('register_teacher.phone')}}</label>
                                    <input data-validate="required,phone" type="text" class="form-control" id="phone" name="phone" placeholder="{{Lang::get('register_teacher.phone_placeholder')}}">
                                </div>
                                <div class="form-group">
                                    <label>{{Lang::get('register_teacher.cellphone')}}</label>
                                    <input data-validate="required,phone" type="text" class="form-control" id="cellphone" name="cellphone" placeholder="{{Lang::get('register_teacher.cellphone_placeholder')}}">
                                </div>
                                <div class="form-group">
                                    <label>{{Lang::get('register_teacher.email')}}</label>
                                    <input data-validate="required,email" type="email" class="form-control" id="email" name="email" placeholder="{{Lang::get('register_teacher.email_placeholder')}}" >
                                </div>
                                <div class="form-group">
                                    <label>{{Lang::get('register_teacher.photo')}}</label>
                                    <input data-validate="image" type="file" id="photo" name="photo" accept="image/x-png, image/gif, image/jpeg" onchange="PreviewImage()">
                                </div>
                                <div class="form-group">
                                    <label></label>
                                    <img src="images/140x140.png" alt="" style="width: 140px; height: 140px;" id="photo_display" name="photo_display">
                                </div>
                                <button type="submit" class="btn btn-default pull-right">{{Lang::get('register_teacher.register')}}</button>
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
