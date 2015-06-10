
<!DOCTYPE HTML>
<html>
	<head>
		<title>Unauthorized</title>
		<link href="css\style.error.css" rel="stylesheet" type="text/css" media="all">
	</head>
	<body>

				<div class="header">
					<div class="logo">
						<h1><a href="#">Ohh Ohh</a></h1>
					</div>
				</div>
			<div class="content">
				<img src="images\error\403.png" title="error">
				<p><span><label>O</label>hh.....</span>You are not authorized to view the page you requested.</p>
				@if(Auth::check())
					<a href="{{Auth::user()->rank}}">Back To Home</a>
				@else
					<a href="{{URL::to('/')}}">Back To Home</a>
				@endif
   			</div>
		</div>
	</body>
</html>