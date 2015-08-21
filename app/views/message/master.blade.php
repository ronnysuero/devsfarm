@extends(Auth::user()->rank.'.master')
@section('content')
	<div class="content">
		<div class="row">
			<div class="panel-heading">
				@yield('header')
			</div>
		</div>
		<div class="row inbox">
			<div class="col-md-2 mail-left-box">
				<?php $stats = MessageController::getStats(); ?>
				<a data-toggle="modal" data-target="#sendMessage" class="btn btn-block btn-compose btn-lg"><i class="fa fa-"></i>{{Lang::get('messages.compose')}}</a> 
				<div class="list-group inbox-options">
					<a href="{{Lang::get('routes.inbox')}}" class="list-group-item">
						<i class="fa fa-inbox"></i> {{Lang::get('messages.inbox')}} 
						@if($stats['inbox'] > 0)
							<span id="span_inbox" class="badge bg-primary">{{$stats['inbox']}}</span>
						@endif 
					</a> 
					<a href="{{Lang::get('routes.unread')}}"class="list-group-item">
						<i class="fa fa-bolt"></i> {{Lang::get('messages.unread')}} 
						@if($stats['unread'] > 0)
							<span id="span_unread" class="badge bg-primary">{{$stats['unread']}}</span> 
						@endif
					</a> 
					<a href="{{Lang::get('routes.mail_sent')}}" id="sent" class="list-group-item">
						<i class="fa fa-check-square-o"></i> {{Lang::get('messages.sent')}} 
						@if($stats['sent'] > 0)
							<span id="span_sent" class="badge  bg-primary">{{$stats['sent']}}</span> 
						@endif
					</a>
					<a href="{{Lang::get('routes.archived')}}" class="list-group-item">
						<i class="fa fa-archive"></i> {{Lang::get('messages.archived')}} 
						@if($stats['archived'] > 0)
							<span id="span_archived" class="badge bg-primary">{{$stats['archived']}}</span> 
						@endif
					</a> 
				</div>
			</div>
			<div class="col-md-10  mail-right-box">
				<div class="mail-options-nav">
					<div class="input-group select-all">
						<span class="input-group-addon">
							<input id="select_all" type="checkbox">
						</span>
						<div class="input-group-btn">
							<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" tabindex="-1">
								<span class="caret"></span>
								<span class="sr-only">Toggle Dropdown</span>
							</button>
							<ul class="dropdown-menu" role="menu">
								<li><a id="mark">{{Lang::get('messages.mark')}}</a></li>
								<li class="divider"></li>
								<li><a id="unmark">{{Lang::get('messages.unmark')}}</a></li>
							</ul>
						</div>
					</div>
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
			</div>
		</div> 
	</div>
	<script type="text/javascript">
		$(document).ready(function() 
		{
			$('#mark').click(function()
			{
				$(':checkbox').prop('checked', true);
				
				var flag = false;

				$('input[type=checkbox]').each(function () 
				{
					if(this.checked && $(this).attr('id') !== "select_all")
					{
						flag = true;
						return false;
					}
				});

				if(!flag)
				{
					disableBtn();
					$(':checkbox').prop('checked', false);
				}
				else
					enableBtn();
			});
			
			$('#unmark').click(function()
			{
				$(':checkbox').prop('checked', false);
				disableBtn();
			});

			$('#select_all').change(function() 
			{
			    $(':checkbox').prop('checked', this.checked);

			    if($(this).is(':checked'))
				{
					var flag = false;

					$('input[type=checkbox]').each(function () 
					{
						if(this.checked && $(this).attr('id') !== "select_all")
						{
							flag = true;
							return false;
						}
					});

					if(!flag)
					{
						disableBtn();
						$(':checkbox').prop('checked', false);
					}
					else
						enableBtn();
				}
				else
					disableBtn();
			});

			$(".checkboxs").change(function()
			{
				if($('#message_id'+ $(this).attr("id")).is(':checked'))
					enableBtn();
				else
				{
					var flag = false;

					$('input[type=checkbox]').each(function () 
					{
						if(this.checked && $(this).attr('id') !== "select_all")
						{
							flag = true;
							return false;
						}
					});

					if(!flag)
						disableBtn();
				}		
			});

			$('#deletebtn').on('click', function() 
			{
				$('#deleteModal').modal('show');
			});

			$('#delete_btn').on('click', function()
			{
				var idsArray = [];

				$('input[type=checkbox]').each(function () 
				{
					if(this.checked && $(this).attr('id') !== "select_all")
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
					if(this.checked && $(this).attr('id') !== "select_all")
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
					if(this.checked && $(this).attr('id') !== "select_all")
						idsArray.push($("#" + $(this).attr("id").replace('message_id', 'id')).val());
				});

				$.post("{{Lang::get('routes.archived_message')}}",{ _ids: idsArray}).done(function( data ) 
				{   
					if(data === "00")
						location.reload();
				});
			});

			$('#submit').click(function()
			{
				$.post("{{Lang::get('routes.send_message')}}", 
				{ 
					receptor: $('#receptor').val(),
					subject: $('#subject').val(),
					content: $('#content').val()
				})
				.done(function(data) 
	            {  
					if(data === '00')
						location.reload();
					else
					{
						$('#alert').html(
							'<div class="test alert alert-danger alert-dismissable">'+
							'<button type="button" class="close" data-dismiss="alert" aria-hidden="true"'+
							'> &times; </button> ' + data + ' </div>'
						);
					}						
				});
			});
		});
		
		function formatDate(date) 
		{
			var hours = date.getHours(),
			minutes = date.getMinutes(),
			ampm = hours >= 12 ? 'pm' : 'am';

			hours = hours % 12;
			hours = hours ? hours : 12;
			minutes = minutes < 10 ? '0'+minutes : minutes;
			var strTime = hours + ':' + minutes + ' ' + ampm;

			return date.getDate() + "-" + (date.getMonth()+1) + "-" + date.getFullYear() + " " + strTime;
		}

		function enableBtn()
		{
			$("#archivebtn").removeClass("disabled");
			$("#deletebtn").removeClass("disabled");	
			$("#readbtn").removeClass("disabled");
		}

		function disableBtn()
		{
			$("#archivebtn").addClass("disabled");
			$("#deletebtn").addClass("disabled");	
			$("#readbtn").addClass("disabled");
		}
	</script>
@stop
