@extends('admin.layout')

@section('webTitle')
    Web Setting
@stop

@section('breadcrumb')
<li class="active">Web Settings</li>
@stop

@section('main')
<div style="margin-top: 10px">
	<div class="row">
		<div class="col-md-6">
			@include('admin.alert')
			<form role="form" action="{{ route('admin.web_setting.update') }}" method="POST">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<div class="form-group">
				    <label>Web Title</label>
				    <input class="form-control" name="web_title" value="{{ $web_title }}">
				</div>
				<div class="form-group">
				    <label>Meta Keyword</label>
				    <textarea class="form-control" name="meta_keyword">{{ $meta_keyword }}</textarea>
				</div>
				<div class="form-group">
				    <label>Meta Description</label>
				    <textarea class="form-control" name="meta_description">{{ $meta_description }}</textarea>
				</div>
				<button type="submit" class="btn btn-primary">Save</button>
			</form>

		</div>
	</div>
</div>
@stop