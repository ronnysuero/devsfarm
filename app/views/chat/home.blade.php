<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Chat</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="css/bootstrap.css" rel="stylesheet">
	<link href="css/font-awesome.css" rel="stylesheet">
	<link href="css/style.chat.css" rel="stylesheet" type="text/css"> 
</head>
<body>
	<div class="site-holder">
		<div class="box-holder">
			<div class="content">
				<div class="row">
					<div class="col-mod-12">
						<h3 class="page-header"><i class="fa fa-comment"></i> Chat</h3>
					</div>
				</div>
				<div class="row chat-box">
					<div class="col-md-2">
						<div class="panel panel-cascade contacts-box">
							<div class="panel-heading">
								<h5 class="panel-title "> <i class="fa fa-user"></i> Contacts</h5>
							</div>
							<div class="panel-body nopadding">
								<div class="list-group contact">
									@foreach ($contacts as $index => $contact)
									<a class="list-group-item" onclick="setSenderId('contact{{$index + 1}}')">
										@if($contact->profile_image == null)
										<img src="images/profile.png" class="chat-user-avatar" alt="contact">
										@else
										<img src="{{Lang::get('show_image').'?src='.storage_path().$contact->profile_image}}" class="chat-user-avatar"/>
										@endif
										@if(strcmp(Auth::user()->rank, 'university') === 0)
										{{$contact->acronym}}
										@else
										{{$contact->name.' '.$contact->last_name}}
										<i class="fa fa-circle"></i>
										@endif
										<input type="hidden" value="{{$contact->_id}}" id="contact{{$index+1}}">
									</a>
									@endforeach
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-10">
						<div class="panel panel-cascade recipient-box">
							<div class="panel-heading">
								<h3 class="panel-title ">
									<span class="recipient">
										@if($user->profile_image == null)
										<img src="images/profile.png" class="chat-user-avatar" alt="picture-profile"></td>
										@else
										<img src="{{Lang::get('show_image').'?src='.storage_path().$user->profile_image}}" class="chat-user-avatar"/>
										@endif
										@if(strcmp(Auth::user()->rank, 'university') === 0)
										{{$user->acronym}}
										@else
										{{$user->name.' '.$user->last_name}}
										@endif
									</span>
								</h3>
							</div>
							<h4><span id="status">Connecting...</span></h4>
							<div class="panel-body nopadding">
								<div class="list-group conversation" id="content"></div>
								<input type="hidden" value="{{Auth::id()}}" id="_id">
								<input type="hidden" value="" id="chat_id">
								<input type="hidden" value="" id="receiver_id">
								<input type="hidden" value="{{$ip}}" id="ip">
								<div class="input-group">
									<input type="text" class="form-control write-message" id="write-message" placeholder="Type something here and hit enter">
									<span class="input-group-btn" >
										<button class="btn text-white bg-primary disabled" type="button" id="send-message">Send</button>
									</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="js/jquery-2.1.3.js"></script>
	<script src="js/reconnecting-websocket.min.js"></script>
	<script src="js/server.client.js"></script>
	<script type="text/javascript">
		function scrollDiv()
		{
			var content = $('#content');
			var height = content[0].scrollHeight;
		  	content.scrollTop(height);
		}

		function setSenderId(r)
		{
			$('#receiver_id').val($('#'+r).val());
			$('#content').html('');

			$.post("{{Lang::get('routes.find_chat')}}",{ receiver_id: $('#receiver_id').val() }).done(function( data ) {

				console.log(data);
				if(data.chat == '')
				return;
				
				$('#chat_id').val(data.chat._id);

				for(var i = 0; i< data.chat.conversations.length; i++)
				{
					var conversation = data.chat.conversations[i];
					var author = '';

					if(String(conversation.sender_id.$id) === data.sender._id)
						author = data.sender.name;
					else 
						author = data.receiver.name;

					$('#content').append('<a class="list-group-item"> '+
						'<img src="images/profile.png" class="chat-user-avatar" alt="">'+
						'<span class="username">' + author + ' <span class="time">'+ 
						formatDate(new Date(conversation.sent_date.sec*1000)) + 
						'</span> </span> <p>' + conversation.message + '</p></a>');
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
			minutes = minutes < 10 ? '0'+minutes : minutes;
			var strTime = hours + ':' + minutes + ' ' + ampm;

			return date.getDate() + "/" + (date.getMonth()+1) + "/" + date.getFullYear() + " " + strTime;
		}
	</script>
</body>
</html>