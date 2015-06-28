<!DOCTYPE html>
<html lang='en'>
    <head>
      <meta charset="UTF-8" />
		  <meta http-equiv="X-UA-Compatible" content="IE=edge">
		  <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>DevsFarm</title>

      <script type="text/javascript" src="js/jquery-2.1.3.js"></script>
      <script type="text/javascript" src="js/verify.notify.js"></script>
      <script type="text/javascript" src="js/bootstrap.js"></script>
      <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
      <link rel="stylesheet" type="text/css" href="css/style.css" />
    </head>
<body>

    <nav class="navbar" style="background-color: #f8f8f8;  border-color: #e7e7e7;">
      <div class="container">
          <a href="#" data-toggle="modal" data-target="#registerModal"
             class="pull-right" style="font-size: 16px; color: #26A69A; text-decoration: none; margin-top: 15px;">{{Lang::get('register_university.register_university')}}</a>
        <div class="navbar-header header_page">
          <a class="navbar-brand" style="color: #26A69A;" href="{{URL::to('/')}}">DevsFarm</a>
        </div>
	  </div>
    </nav>

    <div class="container">
		<div class="col-xs-12 col-sm-8 col-sm-offset-2">
      @if($errors->has('error'))
        <div class="alert alert-danger alert-dismissable">
           <button type="button" class="close" data-dismiss="alert"
              aria-hidden="true" onclick="$('.alert.alert-danger.alert-dismissable').hide('slow')">
              &times;
           </button>
           {{ $errors->first('error') }}
        </div>
      @endif
      {{ Form::open(array('url' => Lang::get('routes.register_student'), 'class' => 'register_form', 'id' => 'register_form')) }}
				<h1 class="">{{Lang::get('register_student.register_student')}}</h1>
				<hr>

				<div class="form-group col-xs-12 col-sm-6">
					<label for="guest_name">{{Lang::get('register_student.first_name')}}</label>
					<input data-validate="required,size(3, 10),character" type="text" class="form-control" id="guest_name" name="guest_name" placeholder="{{Lang::get('register_student.first_name_placeholder')}}"/>
				</div>
				<div class="form-group col-xs-12 col-sm-6">
					<label for="guest_lastname">{{Lang::get('register_student.last_name')}}</label>
					<input data-validate="required,size(3, 10),character" type="text" class="form-control" id="guest_lastname" name="guest_lastname" placeholder="{{Lang::get('register_student.last_name_placeholder')}}"  />
				</div>
				<div class="form-group col-xs-12 col-sm-6">
					<label for="guest_email">{{Lang::get('register_student.email')}}</label>
					<input data-validate="required,email" type="email" class="form-control" id="guest_email" name="guest_email" placeholder="{{Lang::get('register_student.email_placeholder')}}"  />
				</div>
				<div class="form-group col-xs-12 col-sm-6">
					<label for="guest_genre">{{Lang::get('register_student.genre')}}</label>
					<select class="form-control" id="guest_genre" name="guest_genre">
						<option value="m">{{Lang::get('register_student.male')}}</option>
						<option value="f">{{Lang::get('register_student.female')}}</option>
						<option value="o">{{Lang::get('register_student.other')}}</option>
					</select>
				</div>
				<div class="form-group col-xs-12 col-sm-6">
					<label for="guest_job">{{Lang::get('register_student.has_a_job')}}</label>
					<select class="form-control" id="guest_job" name="guest_job">
						<option value="1">{{Lang::get('register_student.yes')}}</option>
						<option value="0">{{Lang::get('register_student.no')}}</option>
					</select>
				</div>
				<div class="form-group col-xs-12 col-sm-6">
					<label for="guest_id">{{Lang::get('register_student.id_number')}}</label>
					<input data-validate="required,alphanumeric,size(6, 9)" type="text" class="form-control" id="guest_id" name="guest_id" placeholder="{{Lang::get('register_student.id_number_placeholder')}}"  />
				</div>
				<div class="form-group col-xs-12 col-sm-6">
					<label for="user_password">{{Lang::get('register_student.password')}}</label>
					<input data-validate="required,min(6),password(guest_password, guest_email)" type="password" class="form-control" id="guest_password" name="guest_password" placeholder="{{Lang::get('register_student.password_placeholder')}}"  />
				</div>
				<div class="form-group col-xs-12 col-sm-6">
					<label for="user_confirm_password">{{Lang::get('register_student.confirm_password')}}</label>
					<input data-validate="required,min(6),verifyPassword(guest_password, guest_confirm_password)" type="password" class="form-control" id="guest_confirm_password" name="guest_confirm_password" placeholder="{{Lang::get('register_student.confirm_password_placeholder')}}"  />
				</div>

				<button type="submit" class="btn btn-primary pull-right" style="margin-right: 15px;">{{Lang::get('register_student.register')}}</button>
        {{ Form::close() }}
		</div>

	</div>

    <div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="Register University" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel" style="color: #26A69A;">{{Lang::get('register_university.register_university')}}</h4>
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
                    {{ Form::open(array('url' => Lang::get('routes.register_university'), 'style' => 'overflow: hidden; color: #26A69A;', 'id' => 'register_form')) }}

                    <div class="form-group col-lg-12">
                        <label for="university_name">{{Lang::get('register_university.name')}}</label>
                        <input data-validate="required,size(5, 40),characterspace" type="text" class="form-control" id="university_name" name="university_name" placeholder="{{Lang::get('register_university.name_placeholder')}}"  />
                    </div>
                    <div class="form-group col-lg-12">
                        <label for="university_acronym">{{Lang::get('register_university.acronym')}}</label>
                        <input data-validate="required,size(3, 10),character" type="text" class="form-control" id="university_acronym" name="university_acronym" placeholder="{{Lang::get('register_university.acronym_placeholder')}}"  />
                    </div>
                    <div class="form-group col-lg-12">
                        <label for="university_email">{{Lang::get('register_university.email')}}</label>
                        <input data-validate="required,email" type="email" class="form-control" id="university_email" name="university_email" placeholder="{{Lang::get('register_university.email_placeholder')}}"  />
                    </div>
                    <div class="form-group col-lg-12">
                        <label for="university_password">{{Lang::get('register_university.password')}}</label>
                        <input data-validate="required,min(6),password(university_password, guest_email)" type="password" class="form-control" id="university_password" name="university_password" placeholder="{{Lang::get('register_university.password_placeholder')}}"  />
                    </div>
                    <div class="form-group col-lg-12">
                        <label for="university_confirm_password">{{Lang::get('register_university.confirm_password')}}</label>
                        <input data-validate="required,min(6),verifyPassword(university_password, university_confirm_password)" type="password" class="form-control" id="university_confirm_password" name="university_confirm_password" placeholder="{{Lang::get('register_university.confirm_password_placeholder')}}"  />
                    </div>

                    <button type="submit" class="btn btn-primary pull-right" style="margin-right: 15px;">{{Lang::get('register_university.register')}}</button>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</body>
</html>
