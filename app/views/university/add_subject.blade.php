@extends('university.master')
@section('content')
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header"><i class="fa fa-plus"></i> {{Lang::get('add_subject.register')}}</h1>
		<div class="row">
			<div class="col-lg-8 col-lg-offset-2">
				<div class="panel panel-default">
					<div class="panel-heading">
						{{Lang::get('add_subject.register')}}
					</div>
					@include('alert')
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-12">
								{{ Form::open(array('url' => Lang::get('routes.add_subject'), 'id' => 'register_form', 'role' => 'form')) }}
								<div class="form-group">
									<label>{{Lang::get('add_subject.name')}}</label>
									<input data-validate="required,mi(5, 25),characterspace" class="form-control" id="subject_name" name="subject_name" placeholder="{{Lang::get('add_subject.name_placeholder')}}">
								</div>
								<div class="form-group">
									<label>{{Lang::get('add_subject.school')}}</label>
									<input data-validate="required,size(5, 25),characterspace" class="form-control" id="school" name="school" placeholder="{{Lang::get('add_subject.school_placeholder')}}">
								</div>
								<div class="form-group">
									<label>{{Lang::get('add_subject.section')}}</label>
									<input data-validate="required,min(4),charactercomma,validateSection" class="form-control" id="section" name="section" placeholder="{{Lang::get('add_subject.section_placeholder')}}">
									<p class="help-block">{{Lang::get('add_subject.message')}}</p>
								</div>
								<button type="submit" class="btn btn-default pull-right">{{Lang::get('add_subject.register')}}</button>
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
