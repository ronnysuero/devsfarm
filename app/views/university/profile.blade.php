@extends('university.master')

@section('title', Lang::get('university_profile.title'))
@stop

@section('content')
<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header">{{Lang::get('university_profile.profile')}}</h1>
    <div class="panel panel-default">
      <div class="panel-heading">
        {{Lang::get('university_profile.profile')}}
      </div>
      <div class="panel-body">
        <div class="row">
          @include('alert')
          {{ Form::open(array('url' => Lang::get('routes.update_university'), 'enctype' => 'multipart/form-data')) }}
            <div class="col-lg-3" style="overflow: hidden;">
              @if($university->profile_image == null)
                <img src="images/140x140.png" alt="" style="width: 140px; height: 140px;" id="photo_display" name="photo_display">
              @else
                <img src="{{Lang::get('show_image').'?src='.storage_path().$university->profile_image}}" style="width: 140px; height: 140px;" id="photo_display" name="photo_display" />
              @endif
              <input data-validate="image" type="file" id="photo" name="photo" accept="image/x-png, image/gif, image/jpeg" onchange="PreviewImage()">
              <br>
            </div>
            <div class="col-lg-6" style="overflow: hidden;">
            <div class="form-group">
              <label>{{Lang::get('university_profile.name')}}</label>
              <input data-validate="required,size(20, 40),characterspace" class="form-control" id="university_name" name="university_name" value="{{$university->name}}" >
            </div>
            <div class="form-group">
              <label>{{Lang::get('university_profile.acronym')}}</label>
              <input data-validate="required,size(3, 10),character" class="form-control"  value= "{{$university->acronym}}" id="university_acronym" name="university_acronym" >
            </div>
            <div class="form-group">
              <label>{{Lang::get('university_profile.email')}}</label>
              <input data-validate="required,email" class="form-control" id="university_email" name="university_email" value="{{$university->email}}">
            </div>
              <button type="submit" class="btn btn-default pull-right">{{Lang::get('university_profile.update')}}</button>
            </div>
          </form>
          </div>
        </div>
      </div>
    </div>
</div>
@stop