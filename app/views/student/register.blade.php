<!DOCTYPE html>
<html lang='en'>
    <head>
      <meta charset="UTF-8" />
		  <meta http-equiv="X-UA-Compatible" content="IE=edge">
		  <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>TeamLand</title>
      <script type="text/javascript" src="js/bootstrap.js"></script>
      <script type="text/javascript" src="js/jquery-2.1.3.js"></script>
      <script type="text/javascript" src="js/script.js"></script>
      <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
      <link rel="stylesheet" type="text/css" href="css/style.css" />
      <script type="text/javascript">
        $(document).ready(function() {
            $('#error_div').hide();
        });
      </script>
    </head>
<body>

    <nav class="navbar" style="background: #0097A7;">
      <div class="container">
          <a href="{{URL::to('register_university')}}" class="pull-right" style="font-size: 16px; color: white; text-decoration: none; margin-top: 15px;">Register University</a>
        <div class="navbar-header header_page">
          <a class="navbar-brand" href="{{URL::to('/')}}">DevsFarm</a>
        </div>
	  </div>
    </nav>

    <div class="container">
		<div class="col-xs-12 col-sm-8 col-sm-offset-2">
      <div id="error_div" class="alert alert-danger alert-dismissable">
         <button type="button" class="close" data-dismiss="alert"
            aria-hidden="true" onclick="$('.alert.alert-danger.alert-dismissable').hide('slow')">
            &times;
         </button>
         <p id="error"></p>
      </div>
      @if($errors->has('error'))
        <div class="alert alert-danger alert-dismissable">
           <button type="button" class="close" data-dismiss="alert"
              aria-hidden="true" onclick="$('.alert.alert-danger.alert-dismissable').hide('slow')">
              &times;
           </button>
           {{ $errors->first('error') }}
        </div>
      @endif
      {{ Form::open(array('url' => 'register', 'class' => 'register_form', 'id' => 'register_form', 'onSubmit' => 'return validatePassword()')) }}
				<h1 class="">Register Student</h1>
				<hr>

				<div class="form-group col-xs-12 col-sm-6">
					<label for="guest_name">First Name</label>
					<input type="text" class="form-control" id="guest_name" name="guest_name" placeholder="Enter Name" required />
				</div>
				<div class="form-group col-xs-12 col-sm-6">
					<label for="guest_lastname">Last Name</label>
					<input type="text" class="form-control" id="guest_lastname" name="guest_lastname" placeholder="Enter Last Name" required />
				</div>
				<div class="form-group col-xs-12 col-sm-6">
					<label for="guest_email">Email</label>
					<input type="email" class="form-control" id="guest_email" name="guest_email" placeholder="Enter email" required />
				</div>
				<div class="form-group col-xs-12 col-sm-6">
					<label for="guest_genre">Genre</label>
					<select class="form-control" id="guest_genre" name="guest_genre">
						<option value="m">Male</option>
						<option value="f">Female</option>
						<option value="o">Other</option>
					</select>
				</div>
				<div class="form-group col-xs-12 col-sm-6">
					<label for="guest_job">Do you have a job?</label>
					<select class="form-control" id="guest_job" name="guest_job">
						<option value="1">Yes</option>
						<option value="0">No</option>
					</select>
				</div>
				<div class="form-group col-xs-12 col-sm-6">
					<label for="user_birthday">Birthday</label>
					<input type="date" class="form-control" id="guest_birthday" name="guest_birthday" required />
				</div>
				<div class="form-group col-xs-12 col-sm-6">
					<label for="user_password">Password</label>
					<input type="password" class="form-control" id="guest_password" name="guest_password" placeholder="Enter Password" required />
				</div>
				<div class="form-group col-xs-12 col-sm-6">
					<label for="user_confirm_password">Confirm Password</label>
					<input type="password" class="form-control" id="guest_confirm_password" name="guest_confirm_password" placeholder="Confirm password" required />
				</div>

				<button type="submit" class="btn btn-primary pull-right" style="margin-right: 15px;">Register</button>
        {{ Form::close() }}
		</div>

	</div>
</body>
</html>
