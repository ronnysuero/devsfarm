<!DOCTYPE html>
<html lang='en'>
    <head>
      <meta charset="UTF-8" />
		  <meta http-equiv="X-UA-Compatible" content="IE=edge">
		  <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>DevsFarm</title>

      <script type="text/javascript" src="js/jquery-2.1.3.js"></script>
        <script type="text/javascript" src="js/bootstrap.js"></script>
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

    <nav class="navbar" style="background-color: #f8f8f8;  border-color: #e7e7e7;">
      <div class="container">
          <a href="#" data-toggle="modal" data-target="#registerModal"
             class="pull-right" style="font-size: 16px; color: #26A69A; text-decoration: none; margin-top: 15px;">Register University</a>
        <div class="navbar-header header_page">
          <a class="navbar-brand" style="color: #26A69A;" href="{{URL::to('/')}}">DevsFarm</a>
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
      {{ Form::open(array('url' => 'register_student', 'class' => 'register_form', 'id' => 'register_form', 'onSubmit' => 'return validatePasswordStudent()')) }}
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
					<label for="guest_id">Matricula</label>
					<input type="text" class="form-control" id="guest_id" name="guest_id" required />
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

    <div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="Register University" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel" style="color: #26A69A;">Register University</h4>
                </div>
                <div class="modal-body">
                    @if($errors->has('error'))
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert"
                                    aria-hidden="true" onclick="$('.alert.alert-danger.alert-dismissable').hide('slow')">
                                &times;
                            </button>
                            {{ $errors->first('error') }}
                        </div>
                    @endif
                    {{ Form::open(array('url' => 'register_university', 'style' => 'overflow: hidden; color: #26A69A;', 'id' => 'register_form', 'onSubmit' => 'return validatePasswordUniversity()')) }}

                    <div class="form-group col-lg-12">
                        <label for="guest_name">Name</label>
                        <input type="text" class="form-control" id="university_name" name="university_name" placeholder="Enter Name" required />
                    </div>
                    <div class="form-group col-lg-12">
                        <label for="guest_lastname">Acronym</label>
                        <input type="text" class="form-control" id="university_acronym" name="university_acronym" placeholder="Enter The Acronym" required />
                    </div>
                    <div class="form-group col-lg-12">
                        <label for="guest_email">Email</label>
                        <input type="email" class="form-control" id="university_email" name="university_email" placeholder="Enter email" required />
                    </div>
                    <div class="form-group col-lg-12">
                        <label for="user_password">Password</label>
                        <input type="password" class="form-control" id="university_password" name="university_password" placeholder="Enter Password" required />
                    </div>
                    <div class="form-group col-lg-12">
                        <label for="user_confirm_password">Confirm Password</label>
                        <input type="password" class="form-control" id="university_confirm_password" name="university_confirm_password" placeholder="Confirm password" required />
                    </div>

                    <button type="submit" class="btn btn-primary pull-right" style="margin-right: 15px;">Register</button>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</body>
</html>
