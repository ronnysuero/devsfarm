@if(Session::has('message'))
<div class="alert alert-success alert-dismissable">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true"
	onclick="$('.alert.alert-success.alert-dismissable').hide('slow')">
	&times;
</button>
{{Session::get('message')}}
</div>
@endif
@if($errors->has('error'))
<div class="alert alert-danger alert-dismissable">
	<button type="button" class="close" data-dismiss="alert"
	aria-hidden="true" onclick="$('.alert.alert-danger.alert-dismissable').hide('slow')">
	&times;
</button>
{{ $errors->first('error') }}
</div>
@endif