@extends(Auth::user()->rank.'.master')
@stop
@section('content')
	<div class="content">
		<div class="row">
			<div class="panel-heading">
				@yield('header')
			</div>
		</div>
		<div class="row inbox">
			<div class="col-md-2 mail-left-box">
				<a id="compose" class="btn btn-block btn-compose btn-lg"><i class="fa fa-"></i>{{Lang::get('messages.compose')}}</a> 
				<div class="list-group inbox-options">
					<a href="{{Lang::get('routes.inbox')}}" class="list-group-item">
						<i class="fa fa-inbox"></i> {{Lang::get('messages.inbox')}} 
						@if($stats['inbox'] !== 0)
							<span id="span_inbox" class="badge bg-primary">{{$stats['inbox']}}</span>
						@endif 
					</a> 
					<a href="{{Lang::get('routes.unread')}}"class="list-group-item">
						<i class="fa fa-bolt"></i> {{Lang::get('messages.unread')}} 
						@if($stats['unread'] !== 0)
							<span id="span_unread" class="badge bg-primary">{{$stats['unread']}}</span> 
						@endif
					</a> 
					<a href="{{Lang::get('routes.sent')}}" id="sent" class="list-group-item">
						<i class="fa fa-check-square-o"></i> {{Lang::get('messages.sent')}} 
						@if($stats['sent'] !== 0)
							<span id="span_sent" class="badge  bg-primary">{{$stats['sent']}}</span> 
						@endif
					</a>
					<a href="{{Lang::get('routes.archived')}}" class="list-group-item">
						<i class="fa fa-archive"></i> {{Lang::get('messages.archived')}} 
						@if($stats['archived'] !== 0)
							<span id="span_archived" class="badge bg-primary">{{$stats['archived']}}</span> 
						@endif
					</a> 
				</div>
			</div>
			<div class="col-md-10  mail-right-box">
				<div class="mail-options-nav">
					<div class="btn-group mail-options">
						<button id="archivebtn" class="btn btn-success disabled"><i class="fa fa-archive"></i> {{Lang::get('messages.archive')}}</button>
						<button id="readbtn" class="btn btn-warning disabled"><i class="fa fa-ban"></i> {{Lang::get('messages.read')}}</button>
						<button id="deletebtn" class="btn btn-danger disabled"><i class="fa fa-trash-o"></i> {{Lang::get('messages.delete')}}</button>
					</div>
				</div>
				@include('alert')
				<div class="mails">
					<table id="mail" class="table table-hover table-condensed">
						@yield('body')
						</table>
					</div>
				</div>
				@include('message.modals')
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

				$.post("{{Lang::get('routes.mark_read_message')}}",{ _ids: idsArray}).done(function( data ) 
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

				$.post("{{Lang::get('routes.archived_message')}}",{ _ids: idsArray}).done(function( data ) 
				{   
					if(data === "00")
						location.reload();
				});
			});
		});
	</script>
@stop
