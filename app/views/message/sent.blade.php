@extends('message.master')
@section('title', Lang::get('message_title.sent'))
@section('header')
	<h1 class="page-header">{{Lang::get('messages.title_sent')}}</h1>
@stop
@section('body')
	@foreach($messages as $index => $message)
		<tr>
			<input type="hidden" id="id{{$index+1}}" value="{{$message->_id}}">
			<td id="{{$index+1}}">
				<div class="checkboxs delete_message" id="{{$index+1}}">
					<label> <input type="checkbox" id="message_id{{$index+1}}"> </label>
				</div>
			</td>
			<td class="subject message" id="{{$index+1}}">
				@if(strlen($message->subject) > 70)
					{{substr($message->subject, 0, 70)}} ...
				@else
					{{$message->subject}}
				@endif
			</td>
			<td class="body message"  id="{{$index+1}}">
				@if(strlen($message->body) > 70)
					{{substr($message->body, 0, 70)}} ...
				@else
					{{$message->body}}
				@endif
			</td>
			<td class="time message" id="{{$index+1}}"> 
				{{MessageController::getDate($message->sent_date)}}
			</td>
		</tr>
	@endforeach
	<script type="text/javascript">
		$(document).ready(function() 
		{
			$(".message").on("click", function()
			{
				$('#to').html("");
				$('#title').html("");
				$('#body').html("");

				$.post("{{Lang::get('routes.find_message')}}",
				{ 
					_id: $('#id'+$(this).attr("id")).val()
				})
				.done(function( data ) 
				{    
					$('#to').html("<i class='fa fa-user'></i>" + "{{Lang::get('send_message.to')}}");

					for (var index in data.emails) 
						$('#to').append("<li>" + data.emails[index] + "</li>");

					$('#title').html("{{Lang::get('send_message.subject')}} " + data.messages.subject);
					$('#body').html(formatDate(new Date(data.messages.sent_date.sec*1000))+"<br/>");
					$('#body').append(data.messages.body);
					$('#editModal').modal('show');
				});
			});
		});
	</script>
@stop

