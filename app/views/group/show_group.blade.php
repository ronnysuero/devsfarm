@extends('student.master')

@section('title', 'Mis Grupos')
@stop

@section('content')
    <script type="text/javascript">
        function fillModal (x) {
            var yes='{{Lang::get('student_profile.yes')}}';
            var no='{{Lang::get('student_profile.no')}}';

            $.post("{{Lang::get('routes.find_student')}}",{email:x }).done(function( data ) {
                $("#name").html(data.name);
                $("#last_name").html(data.last_name);
                $("#mail").html(x);
                $("#phone").html(data.phone);
                $("#cellphone").html(data.cellphone);
                $("#genre").html(data.genre);
                if(data.has_a_job==1){
                    $("#job").html(yes);
                }else{
                    $("#job").html(no);
                }
                $('#photo_display').attr('src', $('#image').attr('src'));
                $('#photo').val('');




            });
        }
    </script>

    <div class="row">

        <h1 class="page-header">{{Lang::get('show_groups.my_groups')}}</h1>
        <div class="col-lg-12">
            <div class="row">

                @foreach ($groups as $group)

                    <div class="col-lg-6 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-group fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><span style="text-transform: capitalize;">{{$group->name}}</span></div>
                                        <div><span style="text-transform: uppercase;"> {{$group->section_id}}</span></div>
                                    </div>
                                </div>
                            </div>

                            <br>
                            <div style="margin-left: 5px;">
                                <?php $students = Student::whereIn('_id',$group->student_id)->get(); ?>

                                @foreach ($students as $index =>$user)
                                    {{$user->name}}  {{$user->last_name}}
                                    <input type="hidden" id="email" name="email">
                                    <td ></td>
                                    <a onclick="fillModal('{{$user->email}}')" href="#"  data-toggle="modal" data-target="#studentDetailsModal">
                                        <i class="fa fa-external-link"></i></a>
                                    <br>
                                @endforeach

                            </div>
                            <br>
                            <div class="panel-footer">

                                <a href="{{Lang::get('routes.farm_report')}}">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </a>
                            </div>

                        </div>
                    </div>

                @endforeach


            </div>
        </div>
    </div>

    <div class="modal fade" id="studentDetailsModal" tabindex="-1" role="dialog" aria-labelledby="Register University" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel" style="color: #26A69A;"><i class="fa fa-eye"></i> {{Lang::get('show_groups.information')}} </h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-3">
                            <img src="images/140x140.png" alt="" style="width: 140px; height: 140px;" id="photo_display" name="photo_display"></div>
                        <div class="col-lg-8" style="margin-left: 10px; font-size: 1.2em;">



                            <table class="table">


                                <tr><th>{{Lang::get('student_profile.name')}}</th><td id="name" name="name"></td></tr>
                                <tr><th>{{Lang::get('student_profile.nip')}}</th><td id="last_name" name="last_name"></td></tr>
                                <tr><th>{{Lang::get('student_profile.email')}}</th> <td id="mail" name="mail"></td></tr>
                                <tr><th>{{Lang::get('student_profile.job')}}</th> <td id="job" name="job"></td></tr>
                                <tr><th>{{Lang::get('student_profile.phone')}}</th> <td id="phone" name="phone"></td></tr>
                                <tr><th>{{Lang::get('student_profile.cellphone')}}</th> <td id="cellphone" name="cellphone"></td></tr>
                                <tr><th>{{Lang::get('student_profile.genre')}}</th> <td id="genre" name="genre"></td></tr>

                            </table>
                        </div>
                    </div>
                    <hr/>
                </div>
            </div>
        </div>
    </div>


@stop
