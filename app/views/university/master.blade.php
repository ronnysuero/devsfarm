<!DOCTYPE html>
<html lang="en">
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
	<link rel="shortcut icon" href="favicon.png"> 
	<script type="text/javascript" src="js/jquery-2.1.3.js"></script>
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
				<a class="navbar-brand" href="{{Lang::get('routes.university')}}">DevsFarm</a>
			</div>
			<ul class="nav navbar-top-links navbar-right user-menu" id="user-menu">
				<li class="dropdown">
					<a href="#" class="settings dropdown-toggle" data-toggle="dropdown">
						<i class="fa fa-envelope" style="color: #0097A7;"></i>
						<span class="badge bg-pink">4</span>
					</a>
					<ul class="dropdown-menu inbox dropdown-user">
						<li>
							<a href="inbox.php">     
								<img src="images/eleven.png" alt="" class="avatar">
								<div class="message">
									<span class="username">John Deo</span> 
									<span class="mini-details">
										(1) <i class="fa fa-paper-clip"></i>
									</span>
									<span class="time pull-right"> 
										<i class="fa fa-clock-o"></i> 06:58 PM
									</span>
									<p>
										Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's ... 
									</p>
								</div>
							</a>
						</li>
						<li><a href="inbox.php" class="btn bg-primary">View All</a></li>
					</ul>
				</li>
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">
						<i class="fa fa-envelope fa-fw" style="color: #0097A7;"></i><i class="fa fa-caret-down" style="color: #0097A7;"></i>
					</a>
					<ul class="dropdown-menu dropdown-user">
						<li><a href="{{Lang::get('routes.send_message')}}"><i class="fa fa-sign-out fa-space-shuttle"></i> {{Lang::get('university_master.send_message')}}</a>
						</li>
						<li class="divider"></li>
						<li><a href="{{Lang::get('routes.show_all_messages')}}"><i class="fa fa-list-alt fa-fw"></i> {{Lang::get('university_master.received_message')}}</a>
						</li>
						<li class="divider"></li>
						<li><a href="{{Lang::get('routes.mail_sent')}}"><i class="fa fa-envelope-o"></i> {{Lang::get('university_master.mail_sent')}}</a>
						</li>
					</ul>
				</li>
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">
						<i class="fa fa-user fa-fw" style="color: #0097A7;"></i>  <i class="fa fa-caret-down" style="color: #0097A7;"></i>
					</a>
					<ul class="dropdown-menu dropdown-user">
						<li><a href="{{Lang::get('routes.university_profile')}}"><i class="fa fa-user fa-fw" ></i> {{Lang::get('university_master.profile')}}</a>
						</li>
						<li class="divider"></li>
						<li><a href="{{Lang::get('routes.inbox')}}"><i class="fa fa-envelope"></i>   {{Lang::get('university_master.inbox')}}</a></li>
						<li class="divider"></li>
						<li><a href="{{Lang::get('routes.logout')}}"><i class="fa fa-sign-out fa-fw text-danger" ></i> {{Lang::get('university_master.logout')}}</a>
						</li>
					</ul>
				</li>
			</ul>
			<div class="navbar-default sidebar" role="navigation">
				<div class="sidebar-nav navbar-collapse">
					<ul class="nav" id="side-menu">
						<li>
							<a href="{{Lang::get('routes.university')}}" class="nav_home_categoria"><i class="fa fa-home"></i> {{Lang::get('university_master.board')}}</a>
						</li>
						<li>
							<a href="#" class="nav_categoria"><i class="fa fa-list"></i> {{Lang::get('university_master.subject')}}</a>
							<ul class="nav nav-second-level">
								<li>
									<a href="{{Lang::get('routes.add_subject')}}"><i class="fa fa-plus" style="color: #0097A7;"></i> {{Lang::get('university_master.add')}}</a>
								</li>
								<li>
									<a href="{{Lang::get('routes.show_all_subjects')}}"><i class="fa fa-eye" style="color: #0097A7;"></i> {{Lang::get('university_master.list')}}</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="#" class="nav_categoria"><i class="fa fa-list-ol"></i> {{Lang::get('university_master.section')}}</a>
							<ul class="nav nav-second-level">
								<li>
									<a href="{{Lang::get('routes.add_section')}}"><i class="fa fa-plus" style="color: #0097A7;"></i> {{Lang::get('university_master.add')}}</a>
								</li>
								<li>
									<a href="{{Lang::get('routes.show_all_sections')}}"><i class="fa fa-eye" style="color: #0097A7;"></i> {{Lang::get('university_master.list')}}</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="#" class="nav_categoria"><i class="fa fa-group"></i> {{Lang::get('university_master.teacher')}}</a>
							<ul class="nav nav-second-level">
								<li>
									<a href="{{Lang::get('routes.add_teacher')}}"><i class="fa fa-plus" style="color: #0097A7;"></i> {{Lang::get('university_master.add')}}</a>
								</li>
								<li>
									<a href="{{Lang::get('routes.show_all_teachers')}}"><i class="fa fa-eye" style="color: #0097A7;"></i> {{Lang::get('university_master.list')}}</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="#" class="nav_categoria"><i class="fa fa-compress"></i> {{Lang::get('university_master.assignment')}}</a>
							<ul class="nav nav-second-level">
								<li>
									<a href="{{Lang::get('routes.add_enrollment')}}"><i class="fa fa-plus" style="color: #0097A7;"></i> {{Lang::get('university_master.assign_subject')}}</a>
								</li>
								<li>
									<a href="{{Lang::get('routes.show_all_enrollment')}}"><i class="fa fa-eye" style="color: #0097A7;"></i> {{Lang::get('university_master.list')}}</a>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</nav>
		<div id="page-wrapper">
			@yield('content')
		</div>
	</div>
	<script type="text/javascript" src="js/verify.notify.js"></script>
	<script type="text/javascript" src="js/sb-admin.js"></script>
	<script type="text/javascript" src="js/bootstrap.js"></script>
	<script type="text/javascript" src="js/jquery.tablesorter.js"></script>
	<script type="text/javascript" src="js/metisMenu.min.js"></script>
	<script type="text/javascript" src="js/cropper.min.js"></script>
	<script type="text/javascript" src="js/main.js"></script>
	<script type="text/javascript">
		$('document').ready(function() 
		{
			$("#tableOrder").tablesorter(); 
		});
	</script>
</body>
</html>
