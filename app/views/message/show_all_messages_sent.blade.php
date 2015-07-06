@extends( Auth::user()->rank.'.master' )
@section('title', Lang::get('list_message.title_sent'))
@section('content')
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header"><i class="fa fa-envelope-o"></i> {{Lang::get('list_message.title_sent')}}</h1>
		<button type="button" class="btn btn-danger disabled" id="delete_msg" onclick="$('#deleteModal').modal('show');">{{Lang::get('list_message.delete')}}</button>
		<div class="panel-body">
			<div class="table-responsive">
				<table id="tableOrder" class="table table-striped table-bordered table-hover tablesorter">
					<thead>
						<tr>
							<th></th>
							<th>{{Lang::get('list_message.date')}}</th>
							<th>{{Lang::get('list_message.to')}}</th>
							<th>{{Lang::get('list_message.subject')}}</th>
							<th>{{Lang::get('list_message.body')}}</th>
						</tr>
					</thead>
					<tbody>
						@foreach($messages as $index => $message)
						<tr>
							<input type="hidden" id="id{{$index+1}}" value="{{$message->_id}}">
							<td width="1%">
								<div class="checkbox delete_message" id="{{$index+1}}">
									<label> <input type="checkbox" id="message_id{{$index+1}}"> </label>
								</div>
							</td>
							<td width="13%" class="message" id="{{$index+1}}"> {{date('Y-m-d H:i', $message->sent_date->sec);}}
							</td>
							<?php $emails = MessageController::searchUsers($message->to); ?>
							<td width="25%" class="message" id="{{$index+1}}">
								@foreach ($emails as $email)
								<li>{{$email}}</li>
								@endforeach
							</td>
							<td width="27%" class="message" id="{{$index+1}}">
								@if(strlen($message->subject) > 70)
								{{substr($message->subject, 0, 70);}} ...
								@else
								{{$message->subject}}
								@endif
							</td>
							<td class="message" id="{{$index+1}}">
								@if(strlen($message->body) > 70)
								{{substr($message->body, 0, 70);}} ...
								@else
								{{$message->body}}
								@endif
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
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
							<h4 id="subject"></h4>
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
<script>
	$('document').ready(function() 
	{
		$(".checkbox").change(function()
		{
			if($('#message_id'+ $(this).attr("id")).is(':checked'))
				$("#delete_msg").removeClass("disabled");
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
					$("#delete_msg").addClass("disabled");	
			}			
		});

		$(".message").on("click", function()
		{
			$('#to').html("");
			$('#subject').html("");
			$('#body').html("");

			$.post("{{Lang::get('routes.find_message')}}",{ _id: $('#id'+$(this).attr("id")).val()}).done(function( data ) 
			{    
				$('#to').html("<i class='fa fa-user'></i>" + "{{Lang::get('send_message.to')}}");

				for (var index in data.emails) 
				$('#to').append("<li>" + data.emails[index] + "</li>");

				$('#subject').html("{{Lang::get('send_message.subject')}} " + data.messages.subject);
				$('#body').html(data.messages.body);
			});

			$('#editModal').modal('show');
		});

		$('#delete_btn').on('click', function() 
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
				else
					$('#deleteModal').modal('hide');
			});
		});
	});
</script>
@stop