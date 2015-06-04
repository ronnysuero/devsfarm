@extends('master')
@section('content')
<div class="row">
    <div class="col-lg-12">
       <h1 class="page-header">Registrar Profesor</h1>
       <div class="row">
           <div class="col-lg-8 col-lg-offset-2">
               <div class="panel panel-default">
                <div class="panel-heading">
                    Registrar profesor
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <form role="form">
                                <div class="form-group">
                                    <label>Nombres</label>
                                    <input class="form-control" id="name" name="name" placeholder="Nombres" required>
                                </div>
                                <div class="form-group">
                                    <label>Apellidos</label>
                                    <input class="form-control" id="last_name" name="last_name" placeholder="Apellidos" required>
                                </div>
                                <div class="form-group">
                                    <label>Telefono</label>
                                    <input class="form-control" id="phone" name="phone" placeholder="Telefono">
                                </div>
                                <div class="form-group">
                                    <label>Celular</label>
                                    <input class="form-control" id="cellphone" name="cellphone" placeholder="Celular">
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input class="form-control" id="email" name="email" placeholder="Email" required>
                                </div>
                                <div class="form-group">
                                    <label>Foto</label>
                                    <input type="file" id="photo" name="photo">
                                </div>
                                <div class="form-group">
                                    <label></label>
                                    <img src="http://placehold.it/140x140" alt="" id="photo_display" name="photo_display">
                                </div>
                                <button type="submit" class="btn btn-default pull-right">Registrar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
           </div>
       </div>
        
   </div>
</div>
@stop