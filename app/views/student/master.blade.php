<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>@yield('title')</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/sb-admin.css">
	<link rel="stylesheet" type="text/css" href="css/font-awesome.css">
	<link rel="stylesheet" type="text/css" href="css/dhtmlxgantt.css">
	<link rel="stylesheet" type="text/css" href="css/font-awesome.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/cropper.min.css">
	<link rel="stylesheet" type="text/css" href="css/alertify.core.css" />
	<link rel="stylesheet" type="text/css" href="css/alertify.default.css" />
	<link rel="stylesheet" type="text/css" href="css/bootstrap-wysihtml5.css" />
	<link rel="stylesheet" type="text/css" href="css/jquery.datetimepicker.css" />
	<link rel="shortcut icon" href="favicon.png"> 
	<script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
</head>
<body>
	<div id="wrapper">
		<nav class="navbar navbar-default  navbar-fixed-top" role="navigation" style="margin-bottom: 0">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="{{Lang::get('routes.student')}}">DevsFarm</a>
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

									@if($user->profile_image === null)
										<img src="images/140x140.png" class="avatar" alt="avatar"></td>
									@else
										<img src="{{Lang::get('show_image').'?src='.storage_path().$user->profile_image}}" class="avatar"/>
									@endif    
									<input type="hidden" id="id{{$index+1}}" value="{{$message->_id}}">
									<div>
										<span class="username">{{$user->name}}</span> 
										<span class="time pull-right"> 
											<i class="fa fa-clock-o"></i> 
											{{MessageController::getDate($message->sent_date)}}
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
								{{Lang::get('university_master.view')}}
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
							<a href="{{Lang::get('routes.student_profile')}}">
								<i class="fa fa-user fa-fw" ></i> 
								{{Lang::get('university_master.profile')}}
							</a>
						</li>
						<li class="divider"></li>
						<li>
							<a href="{{Lang::get('routes.inbox')}}">
								<i class="fa fa-envelope"></i>   
								{{Lang::get('university_master.inbox')}}
							</a>
						</li>
						<li class="divider"></li>
						<li>
							<a href="{{Lang::get('routes.logout')}}">
								<i class="fa fa-sign-out fa-fw text-danger" ></i> 
								{{Lang::get('university_master.logout')}}
							</a>
						</li>
					</ul>
				</li>
			</ul>	
			<div class="navbar-default sidebar" role="navigation">
				<div class="sidebar-nav navbar-collapse">
					<ul class="nav" id="side-menu">
						<li>
							<a href="{{Lang::get('routes.student')}}" class="nav_home_categoria" style="background-color: #0097A7; color: white;">
								<i class="fa fa-home"></i> {{Lang::get('teacher_master.board')}}
							</a>
						</li>
						<li>
							<a href="#" class="nav_categoria">
								<i class="fa fa-list"></i> 
								{{Lang::get('student_master.groups')}}
							</a>
							<ul class="nav nav-second-level">
								<li>
									<a href={{Lang::get('routes.add_group')}}>
										<i class="fa fa-plus" style="color: #0097A7;"></i>
										{{Lang::get('student_master.new_group')}}
									</a>
								</li>

								<li>
									<a href={{Lang::get('routes.join_to_group')}}>
										<i class="fa fa-plus" style="color: #0097A7;"></i> 
										{{Lang::get('student_master.join_group')}}
									</a>
								</li>

								<li>
									<a href={{Lang::get('routes.show_groups')}}>
										<i class="fa fa-plus" style="color: #0097A7;"></i> 
										{{Lang::get('student_master.show_group')}}
									</a>
								</li>

							</ul>
						</li>
						<li>
							<a href="{{Lang::get('routes.enroll_section')}}" class="nav_home_categoria" style="background-color: #0097A7; color: white;">
								<i class="fa fa-plus"></i> {{Lang::get('student_master.join_subject')}}
							</a>
						</li>
						@if($stats['join'] > 0)
							<li id="join_li">
								<a href="{{Lang::get('routes.approval_group')}}" style="background-color: #0097A7; color: white;">
									<i class="fa fa-sign-in"></i>
									{{Lang::get('teacher_master.approval')}}
									<span id="join" class="badge bg-pink">{{$stats['join']}}</span>
								</a>
							</li>
						@endif
						<li id="cssmenu">
							<a href="{{Lang::get('routes.chat')}}" class="nav_categoria">
								<i class="fa fa-weixin"></i> 
								Chat
							</a>
							<ul class="nav nav-second-level">
								<?php 
									$student = Student::find(Auth::id());
									$sectionCodes = SectionCode::whereIn('students_id', array(Auth::id()))->get(); 
								?>
							</ul>                            
						</li>	
					</ul>
				</div>
			</nav>
		</div>
		<input type="hidden" id="langGlobal" value="{{App::getLocale()}}">
	<div class="row" id="page-wrapper">
		@yield('content')
	</div>
	@include('message.modals')
	<script type="text/javascript" src="js/verify.notify.js"></script>
	<script type="text/javascript" src="js/sb-admin.js"></script>
	<script type="text/javascript" src="js/bootstrap.js"></script>
	<script type="text/javascript" src="js/jquery.tablesorter.js"></script>
	<script type="text/javascript" src="js/metisMenu.min.js"></script>
	<script type="text/javascript" src="js/cropper.min.js"></script>
	<script type="text/javascript" src="js/main.js"></script>
	<script type="text/javascript" src="js/alertify.min.js"></script>
	<script type="text/javascript" src="js/wysihtml5-0.3.js"></script>
	<script type="text/javascript" src="js/bootstrap-wysihtml5.js"></script>
	<script type="text/javascript" src="js/jquery.datetimepicker.js"></script>
	<script type="text/javascript">

		$('document').ready(function() 
		{	
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

			@if($stats['unread'] > 0 && Request::is(Lang::get('routes.'.Auth::user()->rank)))
				var plural = "";

				@if($stats['unread'] > 1)
					plural = "s";
				@endif

				alertify.set({ delay: 10000 });
				alertify.log("{{Lang::get('messages.welcome')}} {{UserController::getUser(Auth::user())->name}}, {{Lang::get('messages.alert_message')}} {{$stats['unread']}} {{Lang::get('messages.message')}}" + plural);
			@endif
		});
	</script>
</body>
</html>
