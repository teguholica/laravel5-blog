@extends('admin.layout')

@section('webTitle')
Add Category
@stop

@section('breadcrumb')
<li><a href="{{ route('admin.post.index') }}">Category(s)</a></li>
<li class="active">Create New Category</li>
@stop

@section('main')
<form role="form" action="{{ route('admin.category.store') }}" method="post">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<div class="row">
		<div class="col-md-8">
			@include('admin.alert')
			<div class="form-group{{ $errors->has('name')?' has-error has-feedback':'' }}">
				<label>Name<span style="color: red;">*</span></label>
				<input type="text" name="name" class="form-control" value="{{ Input::old('name') }}" />
				@if($errors->has('name'))
				<i class="fa fa-exclamation-triangle fa-lg form-control-feedback" style="top: 35px;"></i>
				<span class="help-block">{{ $errors->first('name') }}</span>
				@endif
			</div>
			<div class="form-group{{ $errors->has('slug')?' has-error has-feedback':'' }}">
				<label>Slug<span style="color: red;">*</span></label>
				<input type="text" name="slug" class="form-control" value="{{ Input::old('slug') }}" />
				@if($errors->has('slug'))
				<i class="fa fa-exclamation-triangle fa-lg form-control-feedback" style="top: 35px;"></i>
				<span class="help-block">{{ $errors->first('slug') }}</span>
				@endif
			</div>
			<div class="form-group{{ $errors->has('tag')?' has-error has-feedback':'' }}">
				<label>Tag<span style="color: red;">*</span></label>
				<input type="text" name="tag" class="form-control" value="{{ Input::old('tag') }}" />
				@if($errors->has('tag'))
				<i class="fa fa-exclamation-triangle fa-lg form-control-feedback" style="top: 35px;"></i>
				<span class="help-block">{{ $errors->first('tag') }}</span>
				@endif
			</div>
		</div>
	</div>
	<button type="submit" class="btn btn-primary">
		Save
	</button>
</form>
<hr>
@stop

@section('foot')
<script type="text/javascript" src="{{ asset('res/jquery-slugify/jquery.slugify.js') }}"></script>
<script>
	$(document).ready(function() {
		$('[name="slug"]').slugify('[name="name"]');
	}); 
</script>
@stop
