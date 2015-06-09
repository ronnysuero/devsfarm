<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TeamLand</title>
    <script type="text/javascript" src="js/bootstrap.js"></script>
    <script type="text/javascript" src="js/jquery-2.1.3.js"></script>
    <script type="text/javascript" src="js/script.js"></script>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <script type="text/javascript">
        $(document).ready(function() {
            $('#error_div').hide();
        });
    </script>
</head>
<body>

<nav class="navbar" style="background: #0097A7;">
    <div class="container">
        <div class="navbar-header header_page">
            <a class="navbar-brand" href="{{URL::to('/')}}">DevsFarm</a>
        </div>
    </div>
</nav>

<div class="container">
    <div class="col-lg-6 col-lg-offset-3">
        <div id="error_div" class="alert alert-danger alert-dismissable">
           <button type="button" class="close" data-dismiss="alert"
              aria-hidden="true" onclick="$('.alert.alert-danger.alert-dismissable').hide('slow')">
              &times;
           </button>
           <p id="error"></p>
        </div>
        @if($errors->has('error'))
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert"
                        aria-hidden="true" onclick="$('.alert.alert-danger.alert-dismissable').hide('slow')">
                    &times;
                </button>
                {{ $errors->first('error') }}
            </div>
        @endif
        {{ Form::open(array('url' => 'register_university', 'class' => 'register_form', 'id' => 'register_form', 'onSubmit' => 'return validatePasswordUniversity()')) }}
        <h1 class="">Register University</h1>
        <hr>

        <div class="form-group col-lg-12">
            <label for="guest_name">Name</label>
            <input type="text" class="form-control" id="university_name" name="university_name" placeholder="Enter Name" required />
        </div>
        <div class="form-group col-lg-12">
            <label for="guest_lastname">Acronym</label>
            <input type="text" class="form-control" id="university_acronym" name="university_acronym" placeholder="Enter The Acronym" required />
        </div>
        <div class="form-group col-lg-12">
            <label for="guest_email">Email</label>
            <input type="email" class="form-control" id="university_email" name="university_email" placeholder="Enter email" required />
        </div>
        <div class="form-group col-lg-12">
            <label for="user_password">Password</label>
            <input type="password" class="form-control" id="university_password" name="university_password" placeholder="Enter Password" required />
        </div>
        <div class="form-group col-lg-12">
            <label for="user_confirm_password">Confirm Password</label>
            <input type="password" class="form-control" id="university_confirm_password" name="university_confirm_password" placeholder="Confirm password" required />
        </div>

        <button type="submit" class="btn btn-primary pull-right" style="margin-right: 15px;">Register</button>
        {{ Form::close() }}
    </div>
</div>
</body>
</html>
