
<!DOCTYPE HTML>
<html>
	<head>
		<title>Page not Found</title>
		<link href="css\style.error.css" rel="stylesheet" type="text/css" media="all">
	</head>
	<body>

				<div class="header">
					<div class="logo">
						<h1><a href="#">Ohh Ohh</a></h1>
					</div>
				</div>
			<div class="content">
				<img src="images\error\404.png" title="error">
				<p><span><label>O</label>hh.....</span>You Requested the page that is no longer There.</p>
				@if(Auth::check())
					<a href="{{Auth::user()->rank}}">Back To Home</a>
				@else
					<a href="{{URL::to('/')}}">Back To Home</a>
				@endif
   			</div>
		</div>
	</body>
</html>
