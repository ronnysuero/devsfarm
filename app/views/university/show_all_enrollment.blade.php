@extends('university.master')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><i class="fa fa-compress"></i> {{Lang::get('list_enroll.enrollment')}}</h1>
        <div class="panel-body">
        	@if (count($teachers) >= 1)
            <div class="table-responsive">
                @foreach($teachers as $teacher)
                    @if($teacher->profile_image == null)
                        <img src="images/140x140.png" alt="profesor"></td>
                    @else
                        <img src="{{Lang::get('show_image').'?src='.storage_path().$teacher->profile_image}}"/>
                    @endif

                    <h3>{{$teacher->name.' '.$teacher->last_name}}</h3><br />
                    <?php $subjects = Subject::whereIn('_id', $teacher->subjects_id)->get(); ?>

                    @foreach($subjects as $subject)
                        <h4>{{Lang::get('list_enroll.subject').$subject->name}}</h4>
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{Lang::get('list_enroll.section')}}</th>
                                    <th>{{Lang::get('list_enroll.school')}}</th>
                                    <th>{{Lang::get('list_enroll.unlink')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $sections = $subject->sections()->whereIn('_id', $teacher->sections_id)->get(); ?>
                                @foreach($sections as $index => $section)
                                    <tr>
                                        <td>{{$index+1}}</td>
                                        <td>{{$section->code}}</td>
                                        <td>{{$subject->school}}</td>
                                        <td><a href="#" class="pull-right"><i class="fa fa-chain-broken" data-toggle="modal" data-target="#deleteModal" style="color:#d9534f;"></i></a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <br />
                    @endforeach
                    <br /><br />
                @endforeach
            </div>
            <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="Eliminar inscripcion" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="Eliminar inscripcion"><i class="fa fa-chain-broken"></i> {{Lang::get('list_enroll.confirm')}}</h4>
                        </div>
                        <div class="modal-body">
                            {{Lang::get('list_enroll.agree')}}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">{{Lang::get('list_teacher.cancel')}}</button>
                            <button type="button" class="btn btn-primary">{{Lang::get('list_teacher.disable')}}</button>
                        </div>
                    </div>
                </div>
            </div>
            @else
                <p><a href="{{Lang::get('routes.add_enrollment')}}"><i class="fa fa-plus" style="color: #0097A7;"></i> {{Lang::get('list_enroll.add')}}</a></p>
            @endif
        </div>
    </div>
</div>
@stop
