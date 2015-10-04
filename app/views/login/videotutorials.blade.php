@extends('login.welcome')
@section('title', Lang::get('login_title.tutorial'))
@section('content')
<div class="container" style="margin-top: 60px;">
    <h2>{{Lang::get('videotutorial.video_tutorial')}}</h2>
    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-6">
                    <h3 style="background: #F7F3F3;padding: 8px;">{{Lang::get('videotutorial.university_workflow')}}</h3>
                    <video width="100%" controls>
                        <source src="video/university.mp4" type="video/mp4">
                        Your browser does not support mp4 videos.
                    </video>
                </div>

                <div class="col-lg-6">
                    <h3 style="background: #F7F3F3;padding: 8px;">{{Lang::get('videotutorial.student_workflow')}}</h3>
                    <video width="100%" controls>
                        <source src="video/student.mp4" type="video/mp4">
                        Your browser does not support mp4 videos.
                    </video>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <h3 style="background: #F7F3F3;padding: 8px;">{{Lang::get('videotutorial.teacher_workflow')}}</h3>
                    <video width="100%" controls>
                        <source src="video/teacher.mp4" type="video/mp4">
                        Your browser does not support mp4 videos.
                    </video>
                </div>

                <div class="col-lg-6">
                    <h3 style="background: #F7F3F3;padding: 8px;">{{Lang::get('videotutorial.recover_password')}}</h3>
                    <video width="100%" controls>
                        <source src="video/recover_password.mp4" type="video/mp4">
                        Your browser does not support mp4 videos.
                    </video>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <h3 style="background: #F7F3F3;padding: 8px;">{{Lang::get('videotutorial.blocking_user')}}</h3>
                    <video width="100%" controls>
                        <source src="video/blocking_user.mp4" type="video/mp4">
                        Your browser does not support mp4 videos.
                    </video>
                </div>
            </div>
        </div>
    </div>
</div>
@stop