<!DOCTYPE html>
<html lang='en'>
    <head>
      <meta charset="UTF-8" />
		  <meta http-equiv="X-UA-Compatible" content="IE=edge">
		  <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>TeamLand</title>
      <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
      <link rel="stylesheet" type="text/css" href="css/style.css" />
      <script type="text/javascript" src="js/bootstrap.js"></script>
    </head>
<body>
    <nav class="navbar" style="background: #0097A7;">
      <div class="container">
		    <a href="{{Lang::get('routes.logout')}}" class="pull-right" style="font-size: 16px; color: white; text-decoration: none; margin-top: 15px;">Log out</a>
		    <div class="navbar-header header_page">
          <a class="navbar-brand" href="{{Lang::get('routes.student')}}">TeamLand</a>
        </div>
      </div>
	  </nav>
	  <div class="row-offcanvas row-offcanvas-left" style="height: 100%;">
		  <div id="sidebar" class="sidebar-offcanvas" style="height: 100%;">
			  <div class="col-xs-2 col-md-2" style="background: #EEEEEE; margin-top: -20px; color: #424242; height: 100%;">
				  <h3>TeamLand</h3>
				  <ul class="nav" style="margin-left: -8px;">
					  <li class="active"><a href="#">Section</a></li>
  					<li><a href="#">Section</a></li>
  					<li><a href="#">Section</a></li>
  					<li><a href="#">Section</a></li>
  					<li><a href="#">Section</a></li>
  					<li><a href="#">Section</a></li>
  					<li><a href="#">Section</a></li>
  					<li><a href="#">Section</a></li>
  					<li><a href="#">Section</a></li>
  					<li><a href="#">Section</a></li>
				  </ul>
			  </div>
		  </div>
	  </div>
	  <div class="col-xs-10 col-md-10" style="border:1px solid red; margin-top: -20px; height: 400px;">
	  </div>
</body>
</html>
