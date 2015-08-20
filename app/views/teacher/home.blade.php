@extends('teacher.master')
@section('title', Lang::get('teacher_title.home'))
@section('content')
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header" id="home_content_title">Home</h1>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<p  id="no_groups" class="hide"></p>
		</div>
	</div>
	<div class="row" class="hide">
		<div class="col-lg-12" id="groups">
		</div>
	</div>
@stop