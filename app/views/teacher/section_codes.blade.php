@extends('teacher.master')

@section('title', 'Section Codes')
@stop
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><i class="fa fa-list"></i> {{Lang::get('section_codes.all_section_codes')}}</h1>
        </div>
        <div class="col-lg-12">
            <div class="panel-body">
                <div class="table-responsive">
                    <table id="tableOrder" class="table table-striped table-bordered table-hover tablesorter">
                        <thead>
                        <tr>
                            <th>{{Lang::get('section_codes.subject')}}</th>
                            <th>{{Lang::get('section_codes.section')}}</th>
                            <th>{{Lang::get('section_codes.period')}}</th>
                            <th>{{Lang::get('section_codes.code')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if (count($subjects) >= 1)
                        @foreach ($subjects as $subject)
                            <?php $sections = $subject->sections()->whereIn('_id', $teacher_section_id)->whereNull('deleted_at')->get(); ?>
                            @foreach($sections as $section)
                                <?php $section_code = SectionCodes::where('code', $section->current_code)->first(); ?>
                                <tr>
                                    <td>{{ $subject->name }}</td>
                                    <td>{{ $section->code  }}</td>
                                    <td>{{ $section_code->current_period  }}</td>
                                    <td>{{ $section->current_code  }}</td>
                                </tr>
                            @endforeach
                        @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><i class="fa fa-plus"></i> {{Lang::get('section_codes.new_section_code')}}</h1>
        </div>
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{Lang::get('section_codes.new_section_code')}}
                </div>
                @include('alert')
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-8 col-lg-offset-2">
                            {{ Form::open(array('url' => Lang::get('routes.create_section_code'), 'id' => 'register_form', 'role' => 'form')) }}
                            <div class="form-group">
                                <label>{{Lang::get('section_codes.subject')}}</label>
                                <input type="hidden" id="subject_id" name="subject_id" value="">
                                <select data-validate="required" class="form-control" id="subject" name="subject">
                                    <option value="">{{Lang::get('section_codes.subject_placeHolder')}}</option>
                                    @foreach($subjects as $subject)
                                        <option value="{{ $subject->_id }}">{{ $subject->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>{{Lang::get('section_codes.section')}}</label>
                                <input type="hidden" id="section_id" name="section_id" value="">
                                <select data-validate="required" class="form-control" id="section" name="section">
                                    <option value="">{{Lang::get("section_codes.section_placeHolder")}}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>{{Lang::get('section_codes.period')}}</label>
                                <input data-validate="required" type="text" class="form-control" id="current_period" name="current_period"
                                       placeholder="{{Lang::get('section_codes.period_placeHolder')}}">
                            </div>
                            <label>Code: <p id="section_code"></p></label>
                            <button type="submit" class="btn btn-default pull-right">{{Lang::get('section_codes.generate_code')}}</button>
                            {{Form::close()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $('document').ready(function()
        {
            var section_name = '';
            var subject_name = '';
            var current_period_txt = '';

            $('#subject').on('change', function()
            {

                if($('#subject').val() !== "")
                {
                    subjectNameInitials($('#subject :selected').text());
                    $("#section_code").text(subject_name + section_name + current_period_txt);

                    $.post("{{Lang::get('routes.find_subject_section')}}",
                            {
                                _id: $('#subject').val()
                            })
                            .done(function( data )
                            {
                                var message = "";

                                message = '<option value="">{{Lang::get("section_codes.section_placeHolder")}} </option>';

                                $('#section')
                                        .find('option')
                                        .remove()
                                        .end()
                                        .append(message);

                                if(data !== "")
                                {
                                    for(var item in data.sections)
                                        $('#section').append( new Option(data.sections[item].code, data.sections[item]._id) );

                                    $('#subject_id').val(data.subject);
                                }
                            });
                }

            });

            $("#section").on("change", function(){
                if($('#section').val() !== "") {
                    section_name = $("#section :selected").text() + '-';
                    $("#section_code").text(subject_name + section_name + current_period_txt);

                    $("#section_id").val( $("#section").val() );
                }
            });

            $("#current_period").on("keyup", function(){
                current_period_txt = $("#current_period").val();
                $("#section_code").text(subject_name + section_name + current_period_txt);
            });

            function subjectNameInitials(subject){
                var acronym = getLetters(subject) + '-';
                subject_name = acronym;
            }

            function getLetters(word){
                var letters = word.match(/\b(\w)/g);
                return letters.join('');
            }
        });

    </script>
@stop