@extends('university.master')
@section('title', Lang::get('university_title.add_enroll'))
@section('content')
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header"><i class="fa fa-plus"></i> {{Lang::get('add_enroll.enroll')}}</h1>
			<div class="panel panel-default">
				<div class="panel-heading">
					{{Lang::get('add_enroll.enroll')}}
				</div>
				@include('alert')
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-8 col-lg-offset-2">
							{{ Form::open(array('url' => Lang::get('routes.add_enrollment'), 'id' => 'register_form', 'role' => 'form')) }}
								<div class="form-group">
									<label>{{Lang::get('add_enroll.teacher')}}</label>
									<select data-validate="required" class="form-control" id="teacher" name="teacher">
										<option value="">{{Lang::get('add_enroll.teacher_placeholder')}}</option>
										@foreach($teachers as $teacher)
											<option value="{{ $teacher->_id }}">{{ $teacher->name.' '.$teacher->last_name }}</option>
										@endforeach
									</select>
								</div>
								<div class="form-group">
									<label>{{Lang::get('add_enroll.subject')}}</label>
									<select data-validate="required" class="form-control" id="subject" name="subject">
										<option value="">{{Lang::get('add_enroll.subject_placeholder')}}</option>
										@foreach($subjects as $subject)
											<option value="{{ $subject->_id }}">{{ $subject->name }}</option>
										@endforeach
									</select>
								</div>
								<div class="form-group">
									<label>{{Lang::get('add_enroll.section')}}</label>
									<select data-validate="required" class="form-control" id="section" name="section">
										<option value="">{{Lang::get('add_enroll.section_placeholder')}}</option>
									</select>
								</div>
								<button type="submit" class="btn btn-default pull-right">{{Lang::get('add_enroll.register')}}</button>
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
					$.post("{{Lang::get('routes.find_unused_section')}}",
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
							{
								$('#section').append( 
									new Option(data.sections[item].code, data.sections[item]._id) 
								);
							}
						}
					});
				}
			}); 
		});
	</script>
@stop