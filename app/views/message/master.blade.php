@extends(Auth::user()->rank.'.master')
@stop
@section('content')
	<div class="content">
		<div class="row">
			<div class="panel-heading">
				<h1 class="page-header">Bandeja de entrada</h1>
			</div>
		</div>
		<div class="row inbox">
			<div class="col-md-2 mail-left-box">
				<a id="compose" class="btn btn-block btn-compose btn-lg"><i class="fa fa-"></i> Compose Mail </a> 
				<div class="list-group inbox-options">
					<a href="{{Lang::get('routes.inbox')}}" class="list-group-item"><i class="fa fa-inbox"></i> Inbox <span class="badge  bg-primary">{{$stats['inbox']}}</span> </a> 
					<a href="{{Lang::get('routes.unread')}}"class="list-group-item"><i class="fa fa-bolt"></i> Unread <span class="badge  bg-primary">{{$stats['unread']}}</span> </a> 
					<a href="{{Lang::get('routes.sent')}}" id="sent" class="list-group-item"><i class="fa fa-check-square-o"></i> Sent <span class="badge  bg-primary">{{$stats['sent']}}</span> </a>
					<a href="{{Lang::get('routes.archived')}}" class="list-group-item"><i class="fa fa-archive"></i> Archived <span class="badge  bg-primary">{{$stats['archived']}}</span> </a> 
				</div>
			</div>
			<div class="col-md-10  mail-right-box">
				<div class="mail-options-nav">
					<div class="btn-group mail-options">
						<button id="archivebtn" class="btn btn-success disabled"><i class="fa fa-archive"></i> Archive</button>
						<button id="readbtn" class="btn btn-warning disabled"><i class="fa fa-ban"></i> Mark as read</button>
						<button id="deletebtn" class="btn btn-danger disabled"><i class="fa fa-trash-o"></i> Delete</button>
					</div>
				</div>
				@include('alert')
				<div class="mails">
					<table id="mail" class="table table-hover table-condensed">
						@yield('body')
						</table>
					</div>
				</div>
				<div class="modal fade" id="viewMessage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header bg-primary text-white">
								<button type="button" class="close text-white" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h3 class="modal-title">Subject</h3>
							</div>
							<div class="modal-body">
								<div class="icon-show"></div>
							</div>
							<div class="modal-footer">
								<textarea class="form-control" rows="4"></textarea>
								<br>
								<button type="button" class="btn bg-primary text-white">Send Reply! </button>
							</div>
						</div>
					</div>
				</div>
				<div class="modal fade" id="sendMessage" tabindex="-1" role="dialog" aria-labelledby="Enviar mensaje" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h4 class="modal-title" id="Enviar mensaje"><i class="fa fa-send"></i> {{Lang::get('send_message.title')}}</h4>
							</div>
							<div class="modal-body">
								{{ Form::open(array('url' => Lang::get('routes.send_message'), 'id' => 'sendMessage_form', 'role' => 'form')) }}
								<div class="form-group">
									<label>{{Lang::get('send_message.to')}}</label>
									<input data-validate="required,validateMail" class="form-control" id="receptor" name="receptor" placeholder="{{Lang::get('send_message.to_placeholder')}}">
									<p class="help-block">{{Lang::get('send_message.to_title')}}</p>
								</div>
								<div class="form-group">
									<label>{{Lang::get('send_message.subject')}}</label>
									<input data-validate="required" class="form-control" id="subject" name="subject" placeholder="{{Lang::get('send_message.subject_placeholder')}}">
								</div>
								<div class="form-group">
									<label>{{Lang::get('send_message.body')}}</label>
									<textarea class="form-control" rows="5" id="content" name="content"></textarea>
								</div>
								{{ Form::close() }}
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">{{Lang::get('list_teacher.cancel')}}</button>
								<button type="submit" form="sendMessage_form" class="btn btn-primary pull-right">{{Lang::get('send_message.title')}}</button>
							</div>
						</div>
					</div>
				</div>
				<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="Ver mensaje" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h4 class="modal-title" id="myModalLabel"><i class="fa fa-envelope-o"></i> {{Lang::get('list_message.details')}}</h4>
							</div>
							<div class="modal-body">
								<div class="row">
									<div class="col-lg-12">
										<h3 class="page-header" id="to"></h3>
										<br/>
										<h4 id="title"></h4>
										<br/>
										<p id="body"></p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="Eliminar mensaje" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h4 class="modal-title" id="Eliminar mensaje"><i class="fa fa-trash-o"></i> {{Lang::get('list_message.delete_msg')}}</h4>
							</div>
							<div class="modal-body">
								{{Lang::get('list_message.agree')}}
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">{{Lang::get('list_teacher.cancel')}}</button>
								<button type="button" class="btn btn-primary" id="delete_btn">{{Lang::get('list_teacher.disable')}}</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div> 
	</div>
	<script type="text/javascript">
		$(document).ready(function() 
		{
			$('#compose').on('click', function()
			{
				$('#sendMessage').modal('show');
			});

			$(".checkboxs").change(function()
			{
				if($('#message_id'+ $(this).attr("id")).is(':checked'))
				{
					$("#archivebtn").removeClass("disabled");
					$("#deletebtn").removeClass("disabled");	
					$("#readbtn").removeClass("disabled");
				}
				else
				{
					var flag = false;

					$('input[type=checkbox]').each(function () 
					{
						if(this.checked)
						{
							flag = true;
							return false;
						}
					});

					if(!flag)
					{
						$("#archivebtn").addClass("disabled");
						$("#deletebtn").addClass("disabled");	
						$("#readbtn").addClass("disabled");
					}
				}		
			});

			$('#deletebtn').on('click', function() 
			{
				var idsArray = [];

				$('input[type=checkbox]').each(function () 
				{
					if(this.checked)
						idsArray.push($("#" + $(this).attr("id").replace('message_id', 'id')).val());
				});

				$.post("{{Lang::get('routes.drop_message')}}",{ _ids: idsArray}).done(function( data ) 
				{    
					if(data === "00")
						location.reload();
				});
			});

			$('#readbtn').on('click', function() 
			{
				var idsArray = [];

				$('input[type=checkbox]').each(function () 
				{
					if(this.checked)
						idsArray.push($("#" + $(this).attr("id").replace('message_id', 'id')).val());
				});

				$.post("{{Lang::get('routes.drop_message')}}",{ _ids: idsArray}).done(function( data ) 
				{    
					if(data === "00")
						location.reload();
				});
			});

			$('#archivebtn').on('click', function() 
			{
				var idsArray = [];

				$('input[type=checkbox]').each(function () 
				{
					if(this.checked)
						idsArray.push($("#" + $(this).attr("id").replace('message_id', 'id')).val());
				});

				$.post("{{Lang::get('routes.drop_message')}}",{ _ids: idsArray}).done(function( data ) 
				{    
					if(data === "00")
						location.reload();
				});
			});
		});
	</script>
@stop
