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
                {{--@if (count($subjects) >= 1)--}}
                    <div class="table-responsive">
                        @include('alert')
                        <table id="tableOrder" class="table table-striped table-bordered table-hover tablesorter">
                            <thead>
                            <tr>
                                <th>{{Lang::get('section_codes.subject')}}</th>
                                <th>{{Lang::get('section_codes.section')}}</th>
                                <th>{{Lang::get('section_codes.code')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            {{--@foreach ($subjects as $index => $subject)--}}
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            {{--@endforeach--}}
                            </tbody>
                        </table>
                    </div>
                {{--@else--}}
                    {{--<p><a href="{{Lang::get('routes.add_subject')}}"><i class="fa fa-plus" style="color: #0097A7;"></i>{{Lang::get('list_subject.add_subject')}}</a></p>--}}
                {{--@endif--}}
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
                                <input type="text" class="form-control" id="current_period" name="current_period"
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
                    subjectNameInitials($('#subject').text());
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

                                    $('#_id').val(data.subject);
                                }
                            });
                }

            });

            $("#section").on("change", function(){
                if($('#section').val() !== "") {
                    section_name = $("#section :selected").text() + '-';
                    $("#section_code").text(subject_name + section_name + current_period_txt);
                }
            });

            $("#current_period").on("focusout", function(){
                current_period_txt = $("#current_period").val();
                $("#section_code").text(subject_name + section_name + current_period_txt);
            });

            function subjectNameInitials(subject){
                var acronym = getLetters(subject).substring(3) + '-';
                subject_name = acronym;
            }

            function getLetters(word){
                var letters = word.match(/\b(\w)/g);
                return letters.join('');
            }
        });

    </script>
@stop