
<!DOCTYPE HTML>
<html>
	<head>
		<title>Unknow Error</title>
		<link href="css\style.error.css" rel="stylesheet" type="text/css" media="all">
	</head>
	<body>

				<div class="header">
					<div class="logo">
						<h1><a href="#">Ohh Ohh</a></h1>
					</div>
				</div>
			<div class="content">
				<img src="images\error\default.png" title="error">
				<p><span><label>O</label>hh.....</span>You have experiencied a technical error. We Apologize. Please wait a few moments an try again.</p>
				@if(Auth::check())
					<a href="{{Lang::get('routes.'.Auth::user()->rank)}}">Back To Home</a>
				@else
					<a href="{{URL::to('/')}}">Back To Home</a>
				@endif
   			</div>
		</div>
	</body>
</html>
