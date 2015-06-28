@extends('university.master')
@section('content')
<script type="text/javascript">
  $('document').ready(function() {
    $('#subject').on('change', function() {
      $.post("{{Lang::get('routes.find_section')}}",{ _id: $('#subject').val() }).done(function( data ) {
        var codes = "";
        
        for (var i = 0; i < data.sections.length; i++)
          codes += data.sections[i].code + ",";

        $('#codes').val(codes);
        $('#_id').val(data.subject._id);
      });
    })  
  });
</script>
<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header"><i class="fa fa-plus"></i> {{Lang::get('add_section.register')}}</h1>
    <div class="row">
      <div class="col-lg-8 col-lg-offset-2">
        <div class="panel panel-default">
          <div class="panel-heading">
            {{Lang::get('add_section.register')}}
          </div>
          @include('alert')
          <div class="panel-body">
            <div class="row">
              <div class="col-lg-12">
                {{ Form::open(array('url' => Lang::get('routes.add_section'), 'id' => 'register_form', 'role' => 'form')) }}
                  <div class="form-group">
                    <label>{{Lang::get('add_section.subject')}}</label>
                    <input type="hidden" id="_id" name="_id" value="">   
                    <select data-validate="required" class="form-control" id="subject" name="subject">
                      <option value="">{{Lang::get('add_section.select_subject')}}</option>
                      @foreach($subjects as $index => $subject)
                        <option value="{{ $subject->_id  }}">{{ $subject->name }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label>{{Lang::get('add_subject.section')}}</label>
                    <input data-validate="required,min(4),charactercomma,validateSection,compareCodes(section, codes)" class="form-control" id="section" name="section" placeholder="{{Lang::get('add_subject.section_placeholder')}}">
                    <p class="help-block">{{Lang::get('add_subject.message')}}</p>
                  </div>
                  <input type="hidden" id="codes" name="codes" value="">               
                  <button type="submit" class="btn btn-default pull-right">{{Lang::get('add_section.register')}}</button>
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
