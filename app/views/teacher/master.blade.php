<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<title>@yield('title')</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/sb-admin.css">
	<link rel="stylesheet" type="text/css" href="css/font-awesome.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/cropper.min.css">
	<link rel="stylesheet" type="text/css" href="css/alertify.core.css">
	<link rel="stylesheet" type="text/css" href="css/alertify.default.css">
	<link rel="stylesheet" type="text/css" href="redmond/jquery-ui.min.css">
	<link rel="stylesheet" type="text/css" href="css/jquery.ui.chatbox.css">
	<link rel="shortcut icon" href="favicon.png"> 
	<script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
    <script src="js/Chart.min.js"></script>

</head>
<body>
	<div id="wrapper">
		<nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="margin-bottom: 0">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="{{Lang::get('routes.teacher')}}">DevsFarm</a>
			</div>
			<?php 
				$unreadMessages = MessageController::unReadMessages(); 
				$stats = MessageController::getStats();
			?>
			<ul class="nav navbar-top-links navbar-right user-menu" id="user-menu">
				<li class="dropdown">
					<a href="#" class="settings dropdown-toggle" data-toggle="dropdown">
						<i class="fa fa-envelope" style="color: #0097A7;"></i>
						@if($stats['unread'] > 0)
							<span id="unread" class="badge bg-pink">{{$stats['unread']}}</span>
						@endif
					</a>
					<ul class="dropdown-menu inbox dropdown-user">
						@foreach($unreadMessages as $index => $message)
							<li class="popups" id="{{$index+1}}">
								<a>
									<?php $user = UserController::getUser(User::first($message->from)); ?>

									@if(is_null($user->profile_image))
										<img src="images/140x140.png" class="avatar" alt="avatar"></td>
									@else
										<img src="{{Lang::get('show_image').'?src='.storage_path().$user->profile_image}}" class="avatar"/>
									@endif
									<input type="hidden" id="id{{$index+1}}" value="{{$message->_id}}">
									<div>
										<span class="username">{{$user->name}}</span>
										<span class="time pull-right">
											<i class="fa fa-clock-o"></i>
											{{date('d-m-Y h:i A', $message->sent_date->sec)}}
										</span>
									</div>
									<div>
										<br/>
										<p>
											@if(strlen($message->body) > 50)
												{{substr($message->body, 0, 50)}} ...
											@else
												{{$message->body}}
											@endif
										</p>
									</div>
								</a>
							</li>
						@endforeach
						<li>
							<a href="{{Lang::get('routes.inbox')}}" class="btn bg-primary">
								{{Lang::get('teacher_master.view')}}
							</a>
						</li>
					</ul>
				</li>
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">
						<i class="fa fa-user fa-fw" style="color: #0097A7;"></i>  
						<i class="fa fa-caret-down" style="color: #0097A7;"></i>
					</a>
					<ul class="dropdown-menu dropdown-user">
						<li>
							<a href="{{Lang::get('routes.teacher_profile')}}">
								<i class="fa fa-user fa-fw" ></i> 
								{{Lang::get('teacher_master.profile')}}
							</a>
						</li>
						<li class="divider"></li>
						<li>
							<a href="{{Lang::get('routes.inbox')}}">
								<i class="fa fa-envelope"></i>   
								{{Lang::get('teacher_master.inbox')}}
							</a>
						</li>
						<li class="divider"></li>
						<li>
							<a href="{{Lang::get('routes.logout')}}">
								<i class="fa fa-sign-out fa-fw text-danger" ></i> 
								{{Lang::get('teacher_master.logout')}}
							</a>
						</li>
					</ul>
				</li>
			</ul>
			<div class="navbar-default sidebar" role="navigation">
				<div class="sidebar-nav navbar-collapse">
					<ul class="nav" id="side-menu">
						<li>
							<a href="{{Lang::get('routes.teacher')}}" class="nav_home_categoria" style="background-color: #0097A7; color: white;">
								<i class="fa fa-home"></i> {{Lang::get('teacher_master.board')}}
							</a>
						</li>
						<li>
							<a href="#" class="nav_categoria">
								<i class="fa fa-list"></i> 
								{{Lang::get('teacher_master.subject')}}
							</a>
							<ul class="nav nav-second-level">
								<?php 
									$teacher = Teacher::find(Auth::id());
									$subjects = Subject::whereIn('_id', $teacher->subjects_id)->get(); 
								?>
								@foreach($subjects as $subject)
									<li>
										<a href="#">
											<i class="fa fa-eye" style="color: #0097A7;"></i> 
											{{ $subject->name }}
										</a>
										<ul class="nav nav-third-level">
											<?php 
												$sections = $subject->sections()
																	->whereIn('_id', $teacher->sections_id)
																	->get(); 
											?>
											@foreach($sections as $section)
												<li>
													<a href="#" id="{{$section->current_code}}" class="menu_section">
														<i class="fa fa-arrow-right" style="color: #0097A7;"></i> {{ $section->code }}
													</a>
												</li>
											@endforeach
										</ul>
									</li>
								@endforeach
							</ul>
						</li>
						<li>
							<a href="{{Lang::get('routes.section_codes')}}" style="background-color: #0097A7; color: white;">
								<i class="fa fa-ticket"></i>
								{{Lang::get('teacher_master.section_codes')}}
							</a>
						</li>
						<li>
							<a href="#" class="nav_categoria">
								<i class="fa fa-list"></i> 
								{{Lang::get('teacher_master.teamleader')}}
							</a>
							<ul class="nav nav-second-level">
								<li>
									<a href="{{Lang::get('routes.add_teamleader')}}">
										<i class="fa fa-plus" style="color: #0097A7;"></i> 
										{{Lang::get('university_master.add')}}
									</a>
								</li>
								<li>
									<a href="{{Lang::get('routes.show_teamleader')}}">
										<i class="fa fa-eye" style="color: #0097A7;"></i> 
										{{Lang::get('university_master.list')}}
									</a>
								</li>
							</ul>
						</li>
						@if($stats['approve'] > 0)
							<li id="approve_li">
								<a href="{{Lang::get('routes.approval')}}" style="background-color: #0097A7; color: white;">
									<i class="fa fa-sign-in"></i>
									{{Lang::get('teacher_master.approval')}}
									<span id="approve" class="badge bg-pink">{{$stats['approve']}}</span>
								</a>
							</li>
						@endif
						<li id="cssmenu">
							<a href="{{Lang::get('routes.chat')}}" class="nav_categoria">
								<i class="fa fa-weixin"></i> 
								Chat
							</a>                          
						</li>
						<li>
							<a href="{{Lang::get('routes.report')}}" style="background-color: #0097A7; color: white;">
								<i class="fa fa-align-justify"></i>
								{{Lang::get('teacher_master.report')}}
							</a>
						</li>
					</ul>
				</div>
			</div>
		</nav>
		{{ Form::open(array('url' => Lang::get('routes.get_section_groups'), 'id' => 'form_section_groups', 'class' => 'hide')) }}
			<div class="form-group">
				<input type="text" class="form-control" id="section_code" name="section_code" value="">
			</div>
		{{Form::close()}}
		<input type="hidden" value="" id="student_id">
		<input type="hidden" value="" id="section_code">
		<input type="hidden" value="" id="name">
		<input type="hidden" value="" id="last_name">
		<input type="hidden" id="langGlobal" value="{{App::getLocale()}}">
		<div id="page-wrapper">
			@yield('content')
		</div>
		@include('message.modals')
	</div>

    <script type="text/javascript" src="js/wysihtml5-0.3.js"></script>
	<script type="text/javascript" src="js/verify.notify.js"></script>
	<script type="text/javascript" src="js/sb-admin.js"></script>
	<script type="text/javascript" src="js/bootstrap.js"></script>
	<script type="text/javascript" src="js/jquery.tablesorter.js"></script>
	<script type="text/javascript" src="js/metisMenu.min.js"></script>
	<script type="text/javascript" src="js/cropper.min.js"></script>
	<script type="text/javascript" src="js/main.js"></script>
	<script type="text/javascript" src="js/alertify.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui.min.js"></script>
	<script type="text/javascript" src="js/jquery.ui.chatbox.js"></script>
	<script type="text/javascript" src="js/chatboxManager.js"></script>
	<script type="text/javascript">

		$('document').ready(function()
		{	
			$("#tableOrder").tablesorter();

			$(".popups").on("click", function()
			{
				$('#to').html("");
				$('#title').html("");
				$('#body').html("");

				$.post("{{Lang::get('routes.find_message')}}",
				{ 
					_id: $('#id'+$(this).attr("id")).val(), 
					flag: true, 
					user: $('#user').val()
				})
				.done(function( data )
				{
					$('#to').html("<i class='fa fa-user'></i>" + "{{Lang::get('send_message.to')}}");

					for (var index in data.emails)
						$('#to').append("<li>" + data.emails[index] + "</li>");

					$('#title').html("{{Lang::get('send_message.subject')}} " + data.messages.subject);
					$('#body').html(data.messages.body);

					if(data.stats['unread'] === 0)
					{
						$('#span_unread').remove();
						$('#unread').remove();
					}
					else
					{
						$('#span_unread').html(data.stats['unread']);
						$('#unread').html(data.stats['unread']);
					}
					$('#showMessageModal').modal('show');
				});
				$('#'+$(this).attr("id")).remove();
			});

			var welcome = "";

			@if($stats['unread'] > 0 && Request::is(Lang::get('routes.'.Auth::user()->rank)))
				var plural = "";
				
				welcome = "{{Lang::get('messages.welcome')}} " + 
						  "{{UserController::getUser(Auth::user())->name}}: ";
				
				@if($stats['unread'] > 1)
					plural = "s";
				@endif

				alertify.set({ delay: 10000 });
				alertify.log
				(
					welcome + 
					" {{Lang::get('messages.alert_message')}} {{$stats['unread']}}" +
					" {{Lang::get('messages.message')}}" + 
					plural
				);
			@endif

			@if($stats['approve'] > 0 && Request::is(Lang::get('routes.'.Auth::user()->rank)))
				var plural = "";
				
				if(welcome === "")
				{
					welcome = "{{Lang::get('messages.welcome')}} " +
							  "{{UserController::getUser(Auth::user())->name}}: ";
				}
				else
					welcome = "";

				@if($stats['approve'] > 1)
					plural = "s";
				@endif

				alertify.set({ delay: 10000 });
				alertify.log
				(
					welcome + 
					" {{Lang::get('messages.have')}}" +
					" {{$stats['approve']}}" +
					" {{Lang::get('messages.student')}}" + 
					plural + 
					" {{Lang::get('messages.alert_approve')}}"
				);
			@endif
		});

		$(".menu_section").on("click", function()
		{
			var section = $(this).attr("id");
			console.log(section);
			$("#section_code").val(section);
			$("#form_section_groups").submit();
		});

		function fillData(student_id, code, name, last_name)
		{
			$('#student_id').val(student_id);
			$('#section_code').val(code);
			$('#name').val(name);
			$('#last_name').val(last_name);
		}

		var counter = 0;
		var idList = new Array();

		var broadcastMessageCallback = function(from, msg)
		{
			for(var i = 0; i < idList.length; i ++) 
			{
				chatboxManager.addBox(idList[i]);
				$("#" + idList[i]).chatbox("option", "boxManager").addMsg(from, msg);
		  	}
	  	}

		// chatboxManager is excerpt from the original project
		// the code is not very clean, I just want to reuse it to manage multiple chatboxes
		chatboxManager.init({messageSent : broadcastMessageCallback});

		$("#link_add").click(function(event) 
		{
			var id = $('#student_id').val() + '_' + $('#section_code').val();
			counter ++;
			idList.push(id);
			
			chatboxManager.addBox(id, 
			{
				title: "box" + counter,
				first_name: $('#name').val(),
				last_name: $('#last_name').val()
			});
			
			event.preventDefault();
		});

		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		ga('create', 'UA-68126611-1', 'auto');
		ga('send', 'pageview');
	</script>
</body>
</html>
