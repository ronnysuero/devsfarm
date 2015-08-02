@extends('teacher.master')

@section('title', 'Subject Details')
@stop

@section('content')
<div class="row" style="color: #000000;">
	<h1 class="page-header"><i class="fa fa-group"></i> Section groups</h1>
	<div class="col-lg-12">
		<div class="row">
            @if(count($groups) >= 1)
            @foreach($groups as $index => $group)
			<div class="col-lg-4 col-md-6">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-3">
								<i class="fa fa-group fa-5x"></i>
							</div>
							<div class="col-xs-9 text-right">
								<div class="huge">{{ $group->project_name  }}</div>
								<div>{{ strtoupper($group->section_id)  }}</div>
							</div>
						</div>
					</div>

					<div class="panel-footer">
                        @foreach($group->student_id as $student)
                        <?php $member = Student::find($student ); ?>
						{{ $member->name  }} {{ $member->last_name }}
                            <a href="#" onclick="fillModal('{{$member->email}}')" data-toggle="modal" data-target="#studentDetailsModal">
						<i class="fa fa-external-link"></i></a><br>
						@endforeach
						<br><br>
						<a href="#" class="show_group_detail" id="{{ $group->_id  }}">
							<span class="pull-left">View Details</span>
							<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
							<div class="clearfix"></div>
						</a>
					</div>

				</div>
			</div>
            @endforeach
            @else
                <h4>There is not groups for this section yet.</h4>
            @endif

		</div>
	</div>
</div>
</div>

{{ Form::open(array('url' => Lang::get('routes.get_farm_report'), 'id' => 'form_groups_report', 'class' => 'hide')) }}
<div class="form-group">
    <input type="text" class="form-control" id="group_id" name="group_id"
           value="">
</div>
{{Form::close()}}

<div class="modal fade" id="studentDetailsModal" style="color: #000000;"
        tabindex="-1" role="dialog" aria-labelledby="Register University" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel" style="color: #26A69A;"><i class="fa fa-eye"></i> Information</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-lg-3"><img id="photo_display" name="photo_display" src="http://placehold.it/150x150" alt=""/></div>
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
				<hr />
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
    function fillModal (x) {
        var yes =  '{{Lang::get('student_profile.yes')}}';
        var no = '{{Lang::get('student_profile.no')}}';

        $.post("{{Lang::get('routes.find_member_information')}}",
        {
            email:x
        }).done(function( data ) {

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
            $('#photo_display').attr('src', data.picture  );
            $('#photo').val('');
            console.log(data);
        });
    }

    $(".show_group_detail").on("click", function(){
        var group = $(this).attr("id");
        $("#group_id").val(group);
        $("#form_groups_report").submit();
    });
</script>
@stop
