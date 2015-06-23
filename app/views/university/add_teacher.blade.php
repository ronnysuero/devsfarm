@extends('university.master')
@section('content')
<script type="text/javascript">
  function PreviewImage() {
    var oFReader = new FileReader();
    oFReader.readAsDataURL(document.getElementById("photo").files[0]);

    var file = document.getElementById("photo").value || "";

    oFReader.onload = function(oFREvent) {
      if(!file.match(/(\.jpg|\.jpeg|\.bmp|\.gif|\.png)$/))
        document.getElementById("photo_display").src = "images/140x140.png";
      else
        document.getElementById("photo_display").src = oFREvent.target.result;
    };
  };
</script>
<div class="row">
    <div class="col-lg-12">
       <h1 class="page-header"><i class="fa fa-plus"></i> Registrar Profesor</h1>
       <div class="row">
           <div class="col-lg-8 col-lg-offset-2">
               <div class="panel panel-default">
                <div class="panel-heading">
                    Registrar profesor
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
                                    <label>Nombres</label>
                                    <input data-validate="required,size(3, 20),characterspace" type="text" class="form-control" id="name" name="name" placeholder="Nombres" >
                                </div>
                                <div class="form-group">
                                    <label>Apellidos</label>
                                    <input data-validate="required,size(3, 20),characterspace" type="text" class="form-control" id="last_name" name="last_name" placeholder="Apellidos" >
                                </div>
                                <div class="form-group">
                                    <label>Telefono</label>
                                    <input data-validate="required,phone" type="text" class="form-control" id="phone" name="phone" placeholder="Telefono">
                                </div>
                                <div class="form-group">
                                    <label>Celular</label>
                                    <input data-validate="required,phone" type="text" class="form-control" id="cellphone" name="cellphone" placeholder="Celular">
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input data-validate="required,email" type="email" class="form-control" id="email" name="email" placeholder="Email" >
                                </div>
                                <div class="form-group">
                                    <label>Foto</label>
                                    <input data-validate="image" type="file" id="photo" name="photo" accept="image/x-png, image/gif, image/jpeg" onchange="PreviewImage()">
                                </div>
                                <div class="form-group">
                                    <label></label>
                                    <img src="images/140x140.png" alt="" style="width: 140px; height: 140px;" id="photo_display" name="photo_display">
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
