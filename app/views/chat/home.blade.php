@extends(Auth::user()->rank.'.master')
@section('content')
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header"><i class="fa fa-comment"></i>Chat</h1>
		</div>
		<div class="col-lg-12 chat-box">
			<div class="col-md-3">
				<div class="panel panel-cascade contacts-box">
					<div class="panel-heading">
						<h2 class="panel-title "> 
							<i class="fa fa-user"></i>
							{{Lang::get('chat.contact')}}
						</h2>
					</div>
					<div class="panel-body nopadding">
						<div class="list-group contact">
							@foreach ($contacts as $contact)
								<a class="list-group-item" onclick="setSenderId('{{$contact->_id}}')">
									<span id="{{$contact->_id}}" class="recipient">
										@if(is_null($contact->profile_image))
											<img src="images/profile.png" class="chat-user-avatar" alt="contact">
										@else
											<img src="{{Lang::get('show_image').'?src='.storage_path().$contact->profile_image}}" class="chat-user-avatar"/>
										@endif
									</span>
									{{$contact->name.' '.$contact->last_name}}
									{{-- <i class="fa fa-circle"></i> --}}
								</a>
							@endforeach
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-9">
				<div class="panel panel-cascade recipient-box">
					<div class="panel-heading">
						<h3 class="panel-title ">
							<span id="{{$user->_id}}" class="recipient">
								@if(is_null($user->profile_image))
									<img src="images/profile.png" class="chat-user-avatar" alt="picture-profile"></td>
								@else
									<img src="{{Lang::get('show_image').'?src='.storage_path().$user->profile_image}}" class="chat-user-avatar"/>
								@endif
							</span>
							{{$user->name.' '.$user->last_name}}
						</h3>
					</div>
					<h4><span id="status">{{Lang::get('chat.connection')}}...</span></h4>
					<div class="panel-body nopadding">
						<div class="list-group conversation" id="content"></div>
						<input type="hidden" value="{{Auth::id()}}" id="_id">
						<input type="hidden" value="" id="chat_id">
						<input type="hidden" value="" id="receiver_id">
						<input type="hidden" value="{{$ip}}" id="ip">
						<div class="input-group">
							<input type="text" class="form-control write-message" id="write-message" placeholder="{{Lang::get('chat.message')}}">
							<span class="input-group-btn" >
								<button class="btn text-white bg-primary disabled" type="button" id="send-message">{{Lang::get('chat.send')}}</button>
							</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="js/reconnecting-websocket.min.js"></script>
	<script type="text/javascript" src="js/server.client.js"></script>
	<script type="text/javascript">
		function scrollDiv()
		{
			var content = $('#content');
			var height = content[0].scrollHeight;
		  	content.scrollTop(height);
		}

		function setSenderId(r)
		{
			$('#receiver_id').val(r);
			$('#content').html('');

			$.post("{{Lang::get('routes.find_chat')}}",
			{ 
				receiver_id: $('#receiver_id').val() 
			})
			.done(function( data ) 
			{
				if(data.chat == '')
					return;
				
				$('#chat_id').val(data.chat._id);

				for(var i = 0; i < data.chat.conversations.length; i++)
				{
					var conversation = data.chat.conversations[i],
						photo = "",
						author = "";

					if(String(conversation.sender_id.$id) === data.sender._id)
					{
						author = data.sender.name;
						photo = $('#' + data.sender._id).html();
					}
					else
					{
						author = data.receiver.name;
						photo = $('#' + data.sender._id).html();
					} 
					
					$('#content').append
					(
						'<a class="list-group-item"> ' + photo +
						' <span class="username">' + author + ' <span class="time">' + 
						formatDate(new Date(conversation.sent_date.sec*1000)) + 
						' </span> </span> <p>' + conversation.message + '</p></a>'
					);
				}

				scrollDiv();
			});
		}				

		function formatDate(date) 
		{
			var hours = date.getHours(),
				minutes = date.getMinutes(),
				ampm = hours >= 12 ? 'pm' : 'am';

			hours = hours % 12;
			hours = hours ? hours : 12;
			minutes = minutes < 10 ? '0' + minutes : minutes;
			
			var strTime = hours + ':' + minutes + ' ' + ampm;

			return date.getDate() + "/" + (date.getMonth()+1) + "/" + date.getFullYear() + " " + strTime;
		}
	</script>
@stop