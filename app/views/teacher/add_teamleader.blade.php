@extends('teacher.master')
@section('title', Lang::get('teacher_title.add_teamleader'))
@section('content')
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header"><i class="fa fa-plus"></i>{{Lang::get('teamleader.teamleader')}}</h1>
		</div>
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					{{Lang::get('teamleader.add_teamleader')}}
				</div>
				@include('alert')
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-8 col-lg-offset-2">
							{{ Form::open(array('url' => Lang::get('routes.add_teamleader'), 'id' => 'register_form')) }}
								<div class="form-group">
									<label>{{Lang::get('section_codes.subject')}}</label>
									<select data-validate="required" class="form-control" id="subject" name="subject">
										<option value="">{{Lang::get('section_codes.subject_placeHolder')}}</option>
										@foreach($subjects as $subject)
											<option value="{{ $subject->_id }}">{{ $subject->name }}</option>
										@endforeach
									</select>
								</div>
								<div class="form-group">
									<label>{{Lang::get('section_codes.section')}}</label>
									<select data-validate="required" class="form-control" id="section" name="section">
										<option value="">{{Lang::get("section_codes.section_placeHolder")}}</option>
									</select>
								</div>
								<div class="form-group">
									<label>{{Lang::get('teamleader.teamleader')}}</label>
									<select data-validate="required" class="form-control" id="teamleader" name="teamleader[]" multiple>
									</select>
									<p>{{Lang::get('teamleader.message')}}</p>
								</div>
								<button type="submit" class="btn btn-default pull-right">{{Lang::get('teamleader.register')}}</button>
							{{Form::close()}}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		$('document').ready(function()
		{
			$('#subject').on('change', function()
			{
				if($('#subject').val() !== "")
				{
					$.post("{{Lang::get('routes.find_subject_section')}}",
					{
						_id: $('#subject').val()
					})
					.done(function( data )
					{
						var message = "";
					
						if(data === "")
							message = '<option value="">{{Lang::get("add_enroll.no_record")}}</option>';
						else
							message = '<option value="">{{Lang::get("add_enroll.section_placeholder")}}</option>';

						$('#section')
							.find('option')
							.remove()
							.end()
							.append(message);

						if(data !== "")
						{
							for(var item in data.sections)
								$('#section').append( new Option(data.sections[item].code, data.sections[item]._id) );
						}
					});
				}
				else
				{
					$('#section').html('<option value="">{{Lang::get("section_codes.section_placeHolder")}} </option>');
					
					$('#teamleader')
							.find('option')
							.remove()
							.end();
				}
			});

			$("#section").on("change", function()
			{
				if($('#section').val() !== "")
				{
					$.post("{{Lang::get('routes.find_student')}}",
					{
						section: $('#section').val(),
						subject: $('#subject').val()
					})
					.done(function( data )
					{
						var message = "";
						
						if(data.code === "99")
							message = '<option value="">{{Lang::get("add_enroll.no_student")}}</option>';
						
						$('#teamleader')
							.find('option')
							.remove()
							.end()
							.append(message);

						if(data.code === "00")
						{
							for(var item in data.students)
							{
								var name = data.students[item].id_number + " - " + data.students[item].name + ' ' + data.students[item].last_name;
								 
								$('#teamleader').append(new Option(name, data.students[item]._id));
							}
						}
					});
				}
				else
				{
					$('#teamleader')
							.find('option')
							.remove()
							.end();
				}
			});
		});
	</script>
@stop