@extends('teacher.master')

@section('title', 'Profile - Teacher')
@stop

@section('content')
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header"><i class="fa fa-user"></i>My Profile</h1>
		<div class="panel panel-default">
			<div class="panel-heading">
				Information
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-3" style="overflow: hidden;">
						<img src="http://placehold.it/150x150" alt="">
						<input type="file" id="logo" name="logo">
						<br>
					</div>
					<div class="col-lg-6" style="overflow: hidden;">
						<form role="form">
							<div class="form-group">
								<label>Nombres</label>
								<input type="text" class="form-control" id="name" name="name" placeholder="Nombres" required>
							</div>
							<div class="form-group">
								<label>Apellidos</label>
								<input type="text" class="form-control" id="last_name" name="last_name" placeholder="Apellidos" required>
							</div>
							<div class="form-group">
								<label>Telefono</label>
								<input type="text" class="form-control" id="phone" name="phone" placeholder="Telefono">
							</div>
							<div class="form-group">
								<label>Celular</label>
								<input type="text" class="form-control" id="cellphone" name="cellphone" placeholder="Celular">
							</div>
							<div class="form-group">
								<label>Email</label>
								<input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
							</div>

                            <hr/>
                            <a href="#" id="show_password_fields"><h5>Change Password</h5></a>
                            <hr/>
                            <div id="password_fields" style="display: none;">
                                <div class="form-group">
                                    <label>Current Password</label>
                                    <input data-validate="required,password" class="form-control" id="current_password" name="current_password">
                                </div>
                                <div class="form-group">
                                    <label>New Password</label>
                                    <input data-validate="required,password" class="form-control" id="new_password" name="new_password">
                                </div>
                                <div class="form-group">
                                    <label>Confirm New Password</label>
                                    <input data-validate="required,password" class="form-control" id="confirm_new_password" name="confirm_new_password">
                                </div>
                            </div>
							<button type="submit" class="btn btn-default pull-right">Actualizar</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
    $("#show_password_fields").click(function(){
        $("#password_fields").toggle("slow");
    });
    //
</script>
@stop