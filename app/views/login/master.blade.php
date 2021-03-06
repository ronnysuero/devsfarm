<!DOCTYPE html>
<html class="no-js" lang="en"> 
<head>  	
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<meta name="author" content="DevsFarm">
	<link rel="shortcut icon" href="favicon.png"> 
	<title>@yield('title')</title>
	<link href="css/bootstrap.css" rel="stylesheet">
	<link href="css/login.css" rel="stylesheet">
	<link href="css/animate-custom.css" rel="stylesheet">
</head>
<body>
	<script type="text/javascript" src="js/jquery.min.js"></script> 
	@yield('content')
	<input type="hidden" id="langGlobal" value="{{App::getLocale()}}">
	<script type="text/javascript" src="js/bootstrap.js"></script>
	<script type="text/javascript" src="js/custom.modernizr.js"></script> 
	<script type="text/javascript" src="js/placeholder-shim.js"></script>        
	<script type="text/javascript" src="js/custom.js"></script>
	<script type="text/javascript" src="js/verify.notify.js"></script>
</body>
</html>
