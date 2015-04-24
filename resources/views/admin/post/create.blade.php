@extends('admin.layout')

@section('webTitle')
Create New Post
@stop

@section('breadcrumb')
<li><a href="{{ route('admin.post.index') }}">Post(s)</a></li>
<li class="active">Create New Post</li>
@stop

@section('head')
<link href="{{ asset('res/summernote-0.6.3/summernote.css') }}" rel="stylesheet" />
<link href="{{ asset('res/summernote-0.6.3/summernote-bs3.css') }}" rel="stylesheet" />
<style>
	pre {
		background-color: #1B2426 !important;
		color: white !important;
		border: 1px solid #1B2426;
	}
</style>
@stop

@section('main')
<form id="postForm" role="form" action="{{ route('admin.post.store') }}" method="post" onsubmit="return postForm()" enctype="multipart/form-data">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<div class="row">
		<div class="col-md-9">
			@include('admin.alert')
			<div class="form-group @if($errors->has('title'))has-error has-feedback @endif">
				<label>Title<span style="color: red;">*</span></label>
				<input class="form-control" name="title" value="{{ Input::old('title') }}">
				@if($errors->has('title'))
				<i class="fa fa-exclamation-triangle fa-lg form-control-feedback" style="top: 35px;"></i>
				<span class="help-block">{{ $errors->first('title') }}</span>
				@endif
			</div>
			<div class="form-group @if($errors->has('slug'))has-error has-feedback @endif">
				<label>Slug<span style="color: red;">*</span></label>
				<input class="form-control" name="slug" value="{{ Input::old('slug') }}">
				@if($errors->has('slug'))
				<i class="fa fa-exclamation-triangle fa-lg form-control-feedback" style="top: 35px;"></i>
				<span class="help-block">{{ $errors->first('slug') }}</span>
				@endif
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group @if($errors->has('meta_keyword'))has-error has-feedback @endif">
						<label>Meta Keyword</label>
						<textarea class="form-control" name="meta_keyword">{{ Input::old('meta_keyword') }}</textarea>
						@if($errors->has('meta_keyword'))
						<i class="fa fa-exclamation-triangle fa-lg form-control-feedback" style="top: 35px;"></i>
						<span class="help-block">{{ $errors->first('meta_keyword') }}</span>
						@endif
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group @if($errors->has('meta_description'))has-error has-feedback @endif">
						<label>Meta Description</label>
						<textarea class="form-control" name="meta_description">{{ Input::old('meta_description') }}</textarea>
						@if($errors->has('meta_description'))
						<i class="fa fa-exclamation-triangle fa-lg form-control-feedback" style="top: 35px;"></i>
						<span class="help-block">{{ $errors->first('meta_description') }}</span>
						@endif
					</div>
				</div>
			</div>
			<div class="form-group" id="preview_content_wrapper" style="display:none;">
				<label>Preview Content</label>
				<input id="inputPreviewImage" type="file" name="preview_image" style="display:none;">
				<div style="border:3px dashed #999999;padding:10px;text-align:center;margin-bottom:10px;cursor:pointer;" onclick="$('#inputPreviewImage').trigger('click');">
					<img id="imgPreviewImage" @if(empty($post->preview_image)) src="{{ asset('res/images/icon_upload.png') }}" @else src="{{ asset('images/preview/'.$post->preview_image) }}" style="width:100%;" @endif />
				</div>
				<input type="hidden" name="preview_content">
				<div id="post_preview_content" class="summernote">{{ Input::old('preview_content') }}</div>
			</div>
			<div class="form-group">
				<label>Content</label>
				<input type="hidden" name="content">
				<div id="post_content" class="summernote">{{ Input::old('content') }}</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label>Settings</label>
				<div class="checkbox">
					<label>
						<input type="checkbox" name="is_publish" value="1">
						Publish
				</div>
				<div class="checkbox">
					<label>
						<input type="checkbox" name="show_in_home" value="1" checked>
						Show in Home
				</div>
				<div class="checkbox">
					<label>
						<input type="checkbox" name="disable_comment" value="1">
						Disable Comment
				</div>
				<div class="checkbox">
					<label>
						<input type="checkbox" name="enable_preview_content" value="1" onchange="previewContent()">
						Custom Content Preview
				</div>
			</div>
			<hr>
			<div class="form-group">
				<label>Category</label>
				<select class="form-control" name="category_id">
					@foreach($categories as $category)
					<option value="{{ $category->id }}">{{ $category->name }}</option>
					@endforeach
				</select>
			</div>
			<hr>
			<div class="form-group">
				<label>Tags</label>
				@forelse($tags as $tag)
				<div class="checkbox">
					<label>
						<input name="tags[]" value="{{ $tag->id }}" type="checkbox"> {{ $tag->name }}
					</label>
				</div>
				@empty
				<div>No Tag(s)</div>
				@endforelse
			</div>
			<hr>
			<div class="form-group">
				<button type="submit" class="btn btn-primary" style="width: 100%;">
					Save
				</button>
			</div>
		</div>
	</div>
</form>
<form id="loadPostForm" style="display:none;">
	<input type="file">
</form>
<hr>
@stop

@section('foot')
<script type="text/javascript" src="{{ asset('res/summernote-0.6.3/summernote.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('res/jquery-slugify/jquery.slugify.js') }}"></script>
<script>
	$(document).ready(function() {
		$('[name="slug"]').slugify('[name="title"]');

		$('.summernote').summernote({
			height : 300,
			minHeight : null,
			maxHeight : null,
			focus : true
		});
	}); 
</script>
<script>
	var postForm = function() {
		$('input[name="preview_content"]').val($('#post_preview_content').code());
		$('input[name="content"]').val($('#post_content').code());
	}
	var previewContent = function() {
		if ($('input[name="enable_preview_content"]').is(':checked')) {
			$("#preview_content_wrapper").show();
		} else {
			$("#preview_content_wrapper").hide();
		}
	}

	$('#inputPreviewImage').change(function(){
		myFile = $(this).prop('files');
		var reader = new FileReader();
        reader.readAsDataURL(myFile[0]);
        reader.onload = function(e) {
        	$('#imgPreviewImage').css('width', '100%');
        	$('#imgPreviewImage').attr('src', e.target.result);
        };
	});
</script>
@stop