@extends('student.master')

@section('title', 'Profile - Student')
@stop


@section('content')
    <script type="text/javascript">
        $(document).ready(function(){
            $('#genre> option[value="{{$student->genre}}"]').attr('selected', 'selected');
            $('#job> option[value="{{$student->has_a_job}}"]').attr('selected', 'selected');
        });
    </script>

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><i class="fa fa-user"></i>{{Lang::get("student_profile.mi_profile")}}</h1>
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{Lang::get("student_profile.information")}}
                </div>
                <div class="panel-body">
                    {{ Form::open(array('url' => Lang::get('routes.update_student'), 'enctype' => 'multipart/form-data')) }}
                    <div class="row">

                        <div class="col-lg-3" style="overflow: hidden;">
                            @if($student->picture == null)
                                <img src="images/140x140.png" alt="" style="width: 140px; height: 140px;" id="photo_display" name="photo_display">
                            @else
                                <img src="{{Lang::get('show_image').'?src='.storage_path().$student->picture}}" style="width: 140px; height: 140px;" id="photo_display" name="photo_display" />
                            @endif
                            <input data-validate="image" type="file" id="photo" name="photo" accept="image/x-png, image/gif, image/jpeg" onchange="PreviewImage()">
                            <br>
                        </div>
                        <div class="col-lg-6" style="overflow: hidden;">
                            <form role="form">
                                <div class="form-group">
                                    <label>{{Lang::get("student_profile.name")}}</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{$student->name}}" required >
                                </div>
                                <div class="form-group">
                                    <label>{{Lang::get("student_profile.last_name")}}</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" value="{{$student->last_name}}"  required>
                                </div>
                                <div class="form-group">
                                    <label>{{Lang::get("student_profile.nip")}}</label>
                                    <input type="text" class="form-control" id="nip" name="nip" value="{{$student->university_id}}" >
                                </div>
                                <div class="form-group">
                                    <label for="genre">{{Lang::get("student_profile.genre")}}</label>
                                    <select class="form-control" id="genre" name="genre">
                                        <option value="m">{{Lang::get("student_profile.male")}}</option>
                                        <option value="f">{{Lang::get("student_profile.female")}}</option>
                                        <option value="o">{{Lang::get("student_profile.other")}}</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="job">{{Lang::get("student_profile.job")}}</label>
                                    <select class="form-control" id="job" name="job">
                                        <option value="0">{{Lang::get("student_profile.no")}}</option>
                                        <option value="1">{{Lang::get("student_profile.yes")}}</option>

                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>{{Lang::get("student_profile.phone")}}</label>
                                    <input type="text" class="form-control" id="phone" name="phone" value="{{$student->phone}}">
                                </div>
                                <div class="form-group">
                                    <label>{{Lang::get("student_profile.cellphone")}}</label>
                                    <input type="text" class="form-control" id="cellphone" name="cellphone" value="{{$student->cellphone}}">
                                </div>
                                <div class="form-group">
                                    <label>{{Lang::get("student_profile.email")}}</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{$student->email}}" required>
                                </div>

                                <hr/>
                                <a href="#" id="show_password_fields"><h5>{{Lang::get("student_profile.change_password")}}</h5></a>
                                <hr/>
                                <div id="password_fields" style="display: none;">
                                    <div class="form-group">
                                        <label>{{Lang::get("student_profile.current_password")}}</label>
                                        <input data-validate="required,password" class="form-control" id="current_password" name="current_password">
                                    </div>
                                    <div class="form-group">
                                        <label>{{Lang::get("student_profile.new_password")}}</label>
                                        <input data-validate="required,password" class="form-control" id="new_password" name="new_password">
                                    </div>
                                    <div class="form-group">
                                        <label>{{Lang::get("student_profile.confirm_new_password")}}</label>
                                        <input data-validate="required,password" class="form-control" id="confirm_new_password" name="confirm_new_password">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-default pull-right">{{Lang::get("student_profile.update")}}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $("#show_password_fields").click(function(){
            $("#password_fields").toggle("slow");
        });
        //
    </script>
@stop