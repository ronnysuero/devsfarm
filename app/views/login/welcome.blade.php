<!DOCTYPE html>
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Welcome to Devsfarm</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <link href="css/login.css" rel="stylesheet">
    <link href="css/animate-custom.css" rel="stylesheet">
</head>
<body>
<script type="text/javascript" src="js/jquery.min.js"></script>

<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">DevsFarm</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            {{ Form::open(array('url' => Lang::get('routes.login'), 'class' => 'navbar-form navbar-right')) }}
                <div class="form-group">
                    <input data-validate="required,email" class="form-control" type="email" name="user_email" placeholder="{{Lang::get('login.email_placeholder')}}">
                </div>
                <div class="form-group">
                    <input data-validate="required" type="password" class="form-control" name="user_password" placeholder="{{Lang::get('login.password_placeholder')}}">
                </div>
                <button type="submit" class="btn btn-primary">{{Lang::get('login.login')}}</button>
                <br>
                <a href="{{Lang::get('routes.forget_password')}}">
                    {{Lang::get('login.forget_password')}}
                </a>
            {{ Form::close() }}

        </div><!--/.navbar-collapse -->
    </div>
</nav>

<img src="images/header.jpg" alt="" width="100%" style="margin-top: 50px;">

<div class="container">
    <div class="row">
        <div class="col-lg-7">
            <div class="row">
                <div class="col-md-12">
                    <h2>{{Lang::get('welcome.devsfarm_label')}}</h2>
                    <p>{{Lang::get('welcome.devsfarm_definition')}}</p>
                    <hr>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <h2>{{Lang::get('welcome.chat_label')}}</h2>
                    <p>{{Lang::get('welcome.chat_definition')}}</p>
                    <hr>
                </div>
                <div class="col-md-6">
                    <h2>{{Lang::get('welcome.reports_label')}}</h2>
                    <p>{{Lang::get('welcome.reports_definition')}}<br><br></p>
                    <hr>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <h2>{{Lang::get('welcome.attach_files_label')}}</h2>
                    <p>{{Lang::get('welcome.attach_files_definition')}}<br><br></p>
                    <hr>
                </div>
                <div class="col-md-6">
                    <h2>{{Lang::get('welcome.client_mobile_label')}}</h2>
                    <p>{{Lang::get('welcome.client_mobile_definition')}}</p>
                    <hr>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="register-box clearfix animated flipInY">
                <ul class="tabs">
                    <li class="tab-link current" data-tab="tab-1">{{Lang::get('register_student.register_student')}}</li>
                    <li class="tab-link" data-tab="tab-2">{{Lang::get('register_student.register_university')}}</li>
                </ul>
                <div id="tab-1" class="login-form tab-content current">
                    @include('alert')
                    {{ Form::open(array(
								'url' => Lang::get('routes.register_student'),
								'style' => 'overflow: hidden; color: #26A69A;',
								'class' => 'register_form',
								'id' => 'register_form',
								'onsubmit' => 'return validate_captcha()'
							))
						}}
                    <div class="form-group col-sm-12">
                        <label for="guest_name">{{Lang::get('register_student.first_name')}}</label>
                        <input data-validate="required,size(3, 10),character" type="text" class="form-control" id="guest_name" name="guest_name" placeholder="{{Lang::get('register_student.first_name_placeholder')}}"/>
                    </div>
                    <div class="form-group col-sm-12">
                        <label for="guest_lastname">{{Lang::get('register_student.last_name')}}</label>
                        <input data-validate="required,size(3, 10),character" type="text" class="form-control" id="guest_lastname" name="guest_lastname" placeholder="{{Lang::get('register_student.last_name_placeholder')}}"  />
                    </div>

                    <div class="form-group col-sm-12">
                        <label for="guest_id">{{Lang::get('register_student.id_number')}}</label>
                        <input data-validate="required,alphanumeric,size(6, 9)" type="text" class="form-control" id="guest_id" name="guest_id" placeholder="{{Lang::get('register_student.id_number_placeholder')}}"  />
                    </div>
                    <div class="form-group col-sm-12">
                        <label for="guest_email">{{Lang::get('register_student.email')}}</label>
                        <input data-validate="required,email" type="email" class="form-control" id="guest_email" name="guest_email" placeholder="{{Lang::get('register_student.email_placeholder')}}"  />
                    </div>
                    <div class="form-group col-xs-12 col-sm-6">
                        <label for="guest_genre">{{Lang::get('register_student.genre')}}</label>
                        <select class="form-control" id="guest_genre" name="guest_genre">
                            <option value="m">{{Lang::get('register_student.male')}}</option>
                            <option value="f">{{Lang::get('register_student.female')}}</option>
                            <option value="o">{{Lang::get('register_student.other')}}</option>
                        </select>
                    </div>
                    <div class="form-group col-xs-12 col-sm-6">
                        <label for="guest_job">{{Lang::get('register_student.has_a_job')}}</label>
                        <select class="form-control" id="guest_job" name="guest_job">
                            <option value="1">{{Lang::get('register_student.yes')}}</option>
                            <option value="0">{{Lang::get('register_student.no')}}</option>
                        </select>
                    </div>
                    <div class="form-group col-xs-12 col-sm-6">
                        <label for="user_password">{{Lang::get('register_student.password')}}</label>
                        <input data-validate="required,min(6),password(guest_password, guest_email)" type="password" class="form-control" id="guest_password" name="guest_password" placeholder="{{Lang::get('register_student.password_placeholder')}}"  />
                    </div>
                    <div class="form-group col-xs-12 col-sm-6">
                        <label for="user_confirm_password">{{Lang::get('register_student.confirm_password')}}</label>
                        <input data-validate="required,min(6),verifyPassword(guest_password, guest_confirm_password)" type="password" class="form-control" id="guest_confirm_password" name="guest_confirm_password" placeholder="{{Lang::get('register_student.confirm_password_placeholder')}}"  />
                    </div>
                    <div class="form-group col-xs-12 col-sm-6">
                        <div id="recaptcha1"></div>
                        <span id="captcha" style="color:red" />
                    </div>
                    <button type="submit" class="btn btn-red">{{Lang::get('register_student.register')}}</button>
                    {{ Form::close() }}
                </div>
                <div id="tab-2" class="login-form tab-content">
                    @include('alert')
                    {{ Form::open(array(
								'url' => Lang::get('routes.register_university'),
								'style' => 'overflow: hidden; color: #26A69A;',
								'id' => 'register_form',
								'onsubmit' => 'return validate_captcha2()'
							))
						}}
                    <div class="form-group col-lg-12">
                        <label for="university_name">{{Lang::get('register_university.name')}}</label>
                        <input data-validate="required,size(5, 40),characterspace" type="text" class="form-control" id="university_name" name="university_name" placeholder="{{Lang::get('register_university.name_placeholder')}}"  />
                    </div>
                    <div class="form-group col-lg-12">
                        <label for="university_acronym">{{Lang::get('register_university.acronym')}}</label>
                        <input data-validate="required,size(3, 10),character" type="text" class="form-control" id="university_acronym" name="university_acronym" placeholder="{{Lang::get('register_university.acronym_placeholder')}}"  />
                    </div>
                    <div class="form-group col-lg-12">
                        <label for="university_email">{{Lang::get('register_university.email')}}</label>
                        <input data-validate="required,email" type="email" class="form-control" id="university_email" name="university_email" placeholder="{{Lang::get('register_university.email_placeholder')}}"  />
                    </div>
                    <div class="form-group col-lg-12">
                        <label for="university_password">{{Lang::get('register_university.password')}}</label>
                        <input data-validate="required,min(6),password(university_password, university_email)" type="password" class="form-control" id="university_password" name="university_password" placeholder="{{Lang::get('register_university.password_placeholder')}}"  />
                    </div>
                    <div class="form-group col-lg-12">
                        <label for="university_confirm_password">{{Lang::get('register_university.confirm_password')}}</label>
                        <input data-validate="required,min(6),verifyPassword(university_password, university_confirm_password)" type="password" class="form-control" id="university_confirm_password" name="university_confirm_password" placeholder="{{Lang::get('register_university.confirm_password_placeholder')}}"  />
                    </div>
                    <div class="form-group col-lg-12">
                        <div id="recaptcha2"></div>
                        <span id="captcha2" style="color:red" />
                    </div>

                    <button type="submit" class="btn btn-red">{{Lang::get('register_university.register')}}</button>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>


    <hr>

    <footer>
        <p>© Devsfarm 2015-2016</p>
    </footer>
</div> <!-- /container -->
<script src="https://www.google.com/recaptcha/api.js?hl={{App::getLocale()}}&onload=myCallBack&render=explicit"></script>
<script type="text/javascript">
    $(document).ready(function()
    {
        $('ul.tabs li').click(function()
        {
            var tab_id = $(this).attr('data-tab');
            $('ul.tabs li').removeClass('current');
            $('.tab-content').removeClass('current');
            $(this).addClass('current');
            $("#"+tab_id).addClass('current');
        });
    })

    function validate_captcha()
    {
        var v = grecaptcha.getResponse();

        if(v.length == 0)
        {
            $('#captcha').html("{{Lang::get('register_student.error_captcha')}}");
            return false;
        }
        else if(v.length != 0)
        {
            $('#captcha').html("");
            return true;
        }
    }

    function validate_captcha2()
    {
        var v = grecaptcha.getResponse();

        if(v.length == 0)
        {
            $('#captcha2').html("{{Lang::get('register_student.error_captcha')}}");
            return false;
        }
        else if(v.length != 0)
        {
            $('#captcha2').html("");
            return true;
        }
    }

</script>

<script>
    var recaptcha1
            ,recaptcha2;

    var myCallBack = function()
    {
        //Render the recaptcha1 on the element with ID "recaptcha1"
        recaptcha1 = grecaptcha.render('recaptcha1', {
            'sitekey' : "{{Config::get('recaptcha.public_key')}}",
            'theme' : 'light'
        });

        //Render the recaptcha2 on the element with ID "recaptcha2"
        recaptcha2 = grecaptcha.render('recaptcha2', {
            'sitekey' : "{{Config::get('recaptcha.public_key')}}",
            'theme' : 'light'
        });
    };
</script>

<script src="./Jumbotron Template for Bootstrap_files/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.js"></script>
<script type="text/javascript" src="js/custom.modernizr.js"></script>
<script type="text/javascript" src="js/placeholder-shim.js"></script>
<script type="text/javascript" src="js/custom.js"></script>
<script type="text/javascript" src="js/verify.notify.js"></script>


</body></html>
