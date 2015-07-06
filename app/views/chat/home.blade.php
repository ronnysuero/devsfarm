<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Chat</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="css\bootstrap.css" rel="stylesheet">
	<link href="css\font-awesome.css" rel="stylesheet">
	<link href="css\style.chat.css" rel="stylesheet" type="text/css"> 
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
										<img src="images\profile.png" class="chat-user-avatar" alt="contact"></td>
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
										<img src="images\profile.png" class="chat-user-avatar" alt="picture-profile"></td>
										@else
										<img src="{{Lang::get('show_image').'?src='.storage_path().$user->profile_image}}" class="chat-user-avatar"/>
										@endif
										@if(strcmp(Auth::user()->rank, 'university') === 0)
										{{$user->acronym}}
										@else
										{{$user->name.' '.$user->last_name}}
										@endif
										<i class="fa fa-circle"></i>
									</span>
								</h3>
							</div>
							<span id="status">Connecting...</span>
							<div class="panel-body nopadding">
								<div class="list-group conversation" id="content"></div>
								<input type="hidden" value="{{Auth::id()}}" id="_id">
								<input type="hidden" value="" id="chat_id">
								<input type="hidden" value="" id="receiver">
								<div class="input-group">
									<input type="text" class="form-control write-message disabled" id="write-message" placeholder="Type something here and hit enter">
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
	<script src="js/server.client.js"></script>
	<script type="text/javascript">
		function setSenderId(r)
		{
			$('#receiver').val($('#'+r).val());
			$('#content').html('');
			
			$.post("{{Lang::get('routes.find_chat')}}",{ _id: $('#_id').val(), receiver: $('#receiver').val() }).done(function( data ) {
				$('#chat_id').val(data.id);
			});
		}	
	</script>
</body>
</html>