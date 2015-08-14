@extends('teacher.master')

@section('title', 'Subject Details')
@stop

@section('content')
<div class="row" style="color: #000000;">
	<h1 class="page-header"><i class="fa fa-group"></i> {{ Lang::get('teacher_section_groups.section_groups_header') }}</h1>
	<div class="col-lg-12">
		<div class="row">
            @if(count($groups) >= 1)
            @foreach($groups as $index => $group)
			<div class="col-lg-6">
				<div class="panel" style="background-color: {{ $colors[$index]  }}; color: white;">
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

					<div class="panel-footer" style="color: #000000;">
                        @foreach($group->student_id as $student)
                        <?php $member = Student::find($student ); ?>
						{{ $member->name  }} {{ $member->last_name }}
                        @if($student == $group->teamleader_id)
                                - TeamLeader
                        @endif
                            <a href="#" onclick="fillModal('{{$member->email}}')" data-toggle="modal" data-target="#studentDetailsModal">
						<i class="fa fa-external-link"></i></a><br>
						@endforeach
						<br><br>
						<a href="#" class="show_group_detail" id="{{ $group->_id  }}">
							<span class="pull-left">{{ Lang::get('teacher_section_groups.show_details')  }}</span>
							<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
							<div class="clearfix"></div>
						</a>
					</div>

				</div>
			</div>
            @endforeach
            @else
                <h4>{{ Lang::get('teacher_section_groups.no_groups') }}</h4>
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

    @include('student_info_modal');


<script type="text/javascript">
    function fillModal (x) {
        var yes =  '{{Lang::get('student_profile.yes')}}';
        var no = '{{Lang::get('student_profile.no')}}';

        $.post("{{Lang::get('routes.find_member_information')}}",
        {
            email:x
        }).done(function( data ) 
        {
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
