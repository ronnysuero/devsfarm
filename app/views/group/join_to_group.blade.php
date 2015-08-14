@extends('Student.master')
@section('content')
    <script type="text/javascript">
        $('document').ready(function()
        {
            $('#subject').on('change', function()
            {
                if($('#subject').val() !== "")
                {
                    $.post("{{Lang::get('routes.find_Group_By_Section')}}",{ _id: $('#subject').val() }).done(function( data )
                    {

                        var message = "";

                        if(data === "")
                            message = '<option value="">{{Lang::get("add_enroll.no_record")}}</option>';
                        else
                            message = '<option value="">{{Lang::get("join_to_group.group_placeholder")}}</option>';

                        $('#group')
                                .find('option')
                                .remove()
                                .end()
                                .append(message);

                        if(data !== "")
                        {
                            for(var item in data.groups)
                                $('#group').append( new Option(data.groups[item].name, data.groups[item]._id) );

                            $('#_id').val(data.subject);
                        }
                    });
                }
            });


        });
    </script>
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><i class="fa fa-plus"></i> {{Lang::get('join_to_group.joinHeading')}}</h1>
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            {{Lang::get('join_to_group.joinHeading')}}
                        </div>
                        @include('alert')
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    {{ Form::open(array('url' => Lang::get('routes.join_to_group'), 'id' => 'register_form', 'role' => 'form','enctype' => 'multipart/form-data')) }}
                                    <div class="form-group">
                                        <input type="hidden" id="_id" name="_id" value="">
                                        <label>{{Lang::get('join_to_group.section_code')}}</label>
                                        <input data-validate="required,size(3, 20),characterspace" type="text" class="form-control" id="subject" name="subject" placeholder="" >

                                    </div>

                                    <div class="form-group">
                                        <label>{{Lang::get('join_to_group.groups')}}</label>
                                        <select data-validate="required" class="form-control" id="group" name="group">
                                            <option value="">{{Lang::get('join_to_group.group_placeholder')}}</option>
                                        </select>
                                    </div>


                                    <button type="submit" class="btn btn-default pull-right">{{Lang::get('join_to_group.join')}}</button>
                                    {{ Form::close() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
