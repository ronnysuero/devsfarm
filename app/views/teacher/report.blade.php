@extends('teacher.master')
@section('title', Lang::get('teacher_master.report'))
@section('content')
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">
				<i class="fa fa-align-justify"></i> 
				{{Lang::get('teacher_master.report')}}
			</h1>
		</div>
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					Generar un nuevo reporte
				</div>
				@include('alert')
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-8 col-lg-offset-2">
							{{ Form::open(array('url' => Lang::get('routes.view_report'), 'id' => 'register_form', 'role' => 'form')) }}
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
									<label>Grupos</label>
									<select data-validate="required" class="form-control" id="group" name="group">
										<option value="">Seleccionar grupo</option>
									</select>
								</div>
								<div class="form-group">
									<label>Estudiante</label>
									<select data-validate="required" class="form-control" id="students" name="students[]" multiple>
										<option value="">Seleccionar estudiante</option>
									</select>
								</div>
								<div class="form-group">
									<label>Etiquetas</label>
									<select data-validate="required" class="form-control" id="tags" name="tags[]" multiple>
										<option value="all">Todos</option>
										<option value="analysis">{{Lang::get('register_assignment.analysis')}}</option>
										<option value="database">{{Lang::get('register_assignment.database')}}</option>
										<option value="design">{{Lang::get('register_assignment.design')}}</option>
										<option value="programming">{{Lang::get('register_assignment.programming')}}</option>
										<option value="testing">{{Lang::get('register_assignment.testing')}}</option>
									</select>
								</div>
								<div class="form-group">
									<label>Archivos Adjuntos</label>
									<select data-validate="required" class="form-control" id="attach" name="attach">
										<option value="all">Todos</option>
										<option value="yes">Si</option>
										<option value="no">No</option>
									</select>
								</div>
								<button type="submit" class="btn btn-default pull-right">
									Generar reporte
								</button>
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
				if($('#subject').val() != "")
				{
					$.post("{{Lang::get('routes.find_subject_section')}}",
					{
						_id: $('#subject').val()
					})
					.done(function( data )
					{
						var message = '<option value="">{{Lang::get("section_codes.section_placeHolder")}} </option>';

						$('#section')
							.find('option')
							.remove()
							.end()
							.append(message);

						if(data !== "")
						{
							for(var item in data.sections)
							{
								if(data.sections[item].current_code != "" || data.sections[item].current_code != null)
								{
									$('#section').append( 
										new Option(data.sections[item].code, data.sections[item].current_code) 
									);
								}
							}
						}
					});
				}
				else
					$('#section').html('<option value="">{{Lang::get("section_codes.section_placeHolder")}} </option>');
			});

			$("#section").on("change", function()
			{
				if($('#section').val() != "") 
				{
					$.post("{{Lang::get('routes.find_Group_By_Section')}}",
					{
						section_code: $('#section').val()
					})
					.done(function( data )
					{
						var message = '<option value="">Seleccionar grupo</option>';

						$('#group')
							.find('option')
							.remove()
							.end()
							.append(message);

						if(data.length > 0)
						{
							$('#group').append( 
								new Option("Todos", "all") 
							);

							for(var item in data)
							{
								$('#group').append( 
									new Option(data[item].name, data[item]._id) 
								);
							}
						}
					});
				}
				else
					$('#group').html('<option value="">No existen grupos para esta seccion</option>');
			});

			$("#group").on("change", function()
			{
				if($('#group').val() != "") 
				{
					if($('#group').val() == "all")
						$('#students').prop('disabled', 'disabled');
					else
					{
						$('#students').removeAttr('disabled');

						$.post("{{Lang::get('routes.find_student')}}",
						{
							group_id: $('#group').val()
						})
						.done(function( data )
						{
							$('#students')
								.find('option')
								.remove()
								.end();

							if(data.length > 0)
							{
								$('#students').append( 
									new Option("Todos", "all") 
								);

								for(var item in data)
								{
									$('#students').append( 
										new Option((data[item].name + ' ' + data[item].last_name), data[item]._id) 
									);
								}
							}
						});
					}
				}
				else
				{
					$('#students').removeAttr('disabled');
					$('#students').html('<option value="">Seleccionar estudiante</option>');
				}
			});
		});
	</script>
@stop