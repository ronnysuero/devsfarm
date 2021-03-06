﻿<div class="col-lg-6">
	<div class="register-box clearfix animated flipInY">
		<ul class="tabs">
			<li class="tab-link current" data-tab="tab-1">{{Lang::get('register_student.register_student')}}</li>
			<li class="tab-link" data-tab="tab-2">{{Lang::get('register_student.register_university')}}</li>
		</ul>
		<div id="tab-1" class="login-form tab-content current">
			{{ Form::open(array(
						'url' => Lang::get('routes.register_student'),
						'style' => 'overflow: hidden; color: #26A69A;',
						'class' => 'register_form',
						'id' => 'register_student',
						'onsubmit' => 'return validate_student()'
					))
				}}
			<div class="form-group col-sm-12">
				<label for="guest_name">{{Lang::get('register_student.first_name')}}</label>
				<input data-validate="required,size(3, 15),character" type="text" class="form-control" id="guest_name" name="guest_name" placeholder="{{Lang::get('register_student.first_name_placeholder')}}"/>
			</div>
			<div class="form-group col-sm-12">
				<label for="guest_lastname">{{Lang::get('register_student.last_name')}}</label>
				<input data-validate="required,size(3, 15),character" type="text" class="form-control" id="guest_lastname" name="guest_lastname" placeholder="{{Lang::get('register_student.last_name_placeholder')}}"  />
			</div>

			<div class="form-group col-sm-12">
				<label for="guest_id">{{Lang::get('register_student.id_number')}}</label>
				<input data-validate="required,alphanumeric,size(6, 9)" type="text" class="form-control" id="guest_id" name="guest_id" placeholder="{{Lang::get('register_student.id_number_placeholder')}}"  />
			</div>
			<div class="form-group col-sm-12">
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
				<label for="user_password">{{Lang::get('register_student.password')}}</label>
				<input data-validate="required,min(6),password(guest_password, guest_email)" type="password" class="form-control" id="guest_password" name="guest_password" placeholder="{{Lang::get('register_student.password_placeholder')}}"  />
			</div>
			<div class="form-group col-xs-12 col-sm-6">
				<label for="user_confirm_password">{{Lang::get('register_student.confirm_password')}}</label>
				<input data-validate="required,min(6),verifyPassword(guest_password, guest_confirm_password)" type="password" class="form-control" id="guest_confirm_password" name="guest_confirm_password" placeholder="{{Lang::get('register_student.confirm_password_placeholder')}}"  />
			</div>
			<div class="form-group col-xs-12 col-sm-6">
				<div id="recaptcha_student"></div>
				<span id="error_student" style="color:red" />
			</div>
			<input type="hidden" id="student_check" value="">
			<button type="submit" class="btn btn-red">{{Lang::get('register_student.register')}}</button>
			{{ Form::close() }}
		</div>
		<div id="tab-2" class="login-form tab-content">
			@include('alert')
			{{ Form::open(array(
						'url' => Lang::get('routes.register_university'),
						'style' => 'overflow: hidden; color: #26A69A;',
						'id' => 'register_university',
						'onsubmit' => 'return validate_university()'
					))
				}}
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
				<input data-validate="required,min(6),password(university_password, university_email)" type="password" class="form-control" id="university_password" name="university_password" placeholder="{{Lang::get('register_university.password_placeholder')}}"  />
			</div>
			<div class="form-group col-lg-12">
				<label for="university_confirm_password">{{Lang::get('register_university.confirm_password')}}</label>
				<input data-validate="required,min(6),verifyPassword(university_password, university_confirm_password)" type="password" class="form-control" id="university_confirm_password" name="university_confirm_password" placeholder="{{Lang::get('register_university.confirm_password_placeholder')}}"  />
			</div>
			<div class="form-group col-lg-12">
				<div id="recaptcha_university"></div>
				<span id="error_university" style="color:red" />
			</div>
			<input type="hidden" id="university_check" value="">
			<button type="submit" class="btn btn-red">{{Lang::get('register_university.register')}}</button>
			{{ Form::close() }}
		</div>
	</div>
</div>