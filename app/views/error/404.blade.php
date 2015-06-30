
<!DOCTYPE HTML>
<html>
<head>
	<title>{{Lang::get('error.404_title')}}</title>
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
		<p><span><label>O</label>hh.....</span>{{Lang::get('error.404_message')}}</p>
		@if(Auth::check())
		<a href="{{Lang::get('routes.'.Auth::user()->rank)}}">{{Lang::get('error.back')}}</a>
		@else
		<a href="{{URL::to('/')}}">{{Lang::get('error.back')}}</a>
		@endif
	</div>
</div>
</body>
</html>
