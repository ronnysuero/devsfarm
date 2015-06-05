
<!DOCTYPE HTML>
<html>
	<head>
		<title>Internal Server Problem</title>
		<link href="css\style.error.css" rel="stylesheet" type="text/css" media="all">
	</head>
	<body>

				<div class="header">
					<div class="logo">
						<h1><a href="#">Ohh Ohh</a></h1>
					</div>
				</div>
			<div class="content">
				<img src="images\error\500.png" title="error">
				<p><span>Sorry</span> We're experiencing an internal server problem. Please try again later.</p>
				@if(Auth::check())
					<a href="{{Auth::user()->rank}}">Back To Home</a>
				@else
					<a href="{{URL::to('/')}}">Back To Home</a>
				@endif
   			</div>
		</div>
	</body>
</html>
