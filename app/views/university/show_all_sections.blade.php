@extends('university.master')
@section('content')
<script type="text/javascript">
    function fillModal (y, x) {
        $.post("{{Lang::get('routes.find_section')}}",{ code: x, subject_id: $('#subject_id'+y).val() }).done(function( data ) {
            $('#section_code').val(data.section.code);
            $('#_id').val(data.section._id);
            $('#subject_id').val(data.subject_id);
            getCodes(data.subject_id);
        });
    }

    function getCodes(x)
    {
        $.post("{{Lang::get('routes.find_section')}}",{ _id: x }).done(function( data ) {
            var codes = "";

            for (var i = 0; i < data.sections.length; i++) 
                codes += data.sections[i].code + ",";

            $('#codes').val(codes);
        });
    }
</script>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><i class="fa fa-list-ol"></i> {{Lang::get('list_section.section')}}</h1>
        <div class="panel-body">
            @if (count($subjects) >= 1)
                <div class="table-responsive">
                    @include('alert')
                    @foreach ($subjects as $item => $subject)
                        <h3>{{Lang::get('list_section.subject').ucfirst($subject->name)}}</h3>
                        <input type="hidden" id="subject_id{{$item+1}}", name="subject_id{{$item+1}}" value="{{$subject->_id}}"> 
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{Lang::get('list_section.section')}}</th>
                                    <th>{{Lang::get('list_section.assigned')}}</th>
                                    <th>{{Lang::get('list_subject.edit')}}</th>
                                    <th>{{Lang::get('list_subject.delete')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($subject->sections as $index => $section)
                                    <tr>
                                        <td>{{$index + 1}}</td>
                                        <td>{{$section->code}}</td>
                                        <td>
                                            @if(!$section->is_free) 
                                                {{Lang::get('list_section.yes')}} 
                                            @else 
                                                {{Lang::get('list_section.no')}} 
                                            @endif
                                        </td>
                                        <td><a onclick="fillModal('{{$item+1}}', '{{$section->code}}')" href="#"><i class="fa fa-edit" data-toggle="modal" data-target="#editModal" style="color:#337ab7;"></i></a></td>
                                        <td><a href="" data-toggle="modal" data-target="#deleteModal" ><i class="fa fa-trash-o" style="color:#d9534f;"></i></a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <br />
                    @endforeach
                </div>
            @else
                <p><a href="{{Lang::get('routes.add_section')}}"><i class="fa fa-plus" style="color: #0097A7;"></i>{{Lang::get('list_section.add_section')}}</a></p>
            @endif
        </div>
    </div>
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="Editar Asignatura" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel"><i class="fa fa-edit"></i> {{Lang::get('list_section.modify_section')}}</h4>
                </div>
                <div class="modal-body">
                    {{ Form::open(array('url' => Lang::get('routes.update_section'), 'id' => 'register_form', 'role' => 'form')) }}
                        <div class="form-group">
                            <label>{{Lang::get('list_section.section_code')}}</label>
                            <input data-validate="required,min(4),charactercomma,validateSection,compareCodes(section_code, codes)" class="form-control" id="section_code" name="section_code">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">{{Lang::get('list_subject.discard')}}</button>
                            <button type="submit" class="btn btn-primary">{{Lang::get('list_subject.save')}}</button>
                        </div>
                        <input type="hidden" id="codes" name="codes" value="">  
                        <input type="hidden" id="_id", name="_id" value="">
                        <input type="hidden" id="subject_id", name="subject_id" value="">             
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="Eliminar asignatura" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel"><i class="fa fa-trash-o"></i> {{Lang::get('list_section.delete_section')}}</h4>
                </div>
                <div class="modal-body">
                    {{Lang::get('list_section.agree')}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{Lang::get('list_subject.cancel')}}</button>
                    <button type="button" class="btn btn-primary">{{Lang::get('list_subject.delete')}}</button>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
