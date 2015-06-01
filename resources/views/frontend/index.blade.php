@extends('frontend.layout')

@section('meta')
<meta name="title" content="{{ $webSettings->web_title }}">
<meta name="keyword" content="{{ $webSettings->meta_keyword }}">
<meta name="description" content="{{ $webSettings->meta_description }}">
@stop

@section('head')
<style>
	.content h2 a {
		font-family: 'Open Sans', sans-serif;
		font-size: 30px;
		margin: 0px;
		padding: 0px;
		text-decoration: none;
		color: #000000;
		font-weight: 300;
		-o-transition: all 0.2s linear;
		-moz-transition: all 0.2s linear;
		-khtml-transition: all 0.2s linear;
		-webkit-transition: all 0.2s linear;
		-ms-transition: all 0.2s linear;
		transition: all 0.2s linear;
	}

	.content h2 a:hover {
		color: #FF9C00;
	}

	.content h5 {
		font-family: 'Open Sans', sans-serif;
		font-weight: 300;
		color: #757575;
		margin: 0;
	}

	pre {
		background-color: #1B2426 !important;
		color: white !important;
		border: 1px solid #1B2426;
	}
</style>
@stop

@section('main')
@forelse ($posts as $post)
<div class="content">
	<h2><a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a></h2>
	<h5>
		<div>
			<span class="glyphicon glyphicon-user"></span> Oleh <a href="index.php">{{ $post->user->display_name }}</a>&nbsp;&nbsp; 
			<span class="glyphicon glyphicon-eye-open"></span> Dilihat {{ $post->view }}x
		</div>
	</h5>
</div>
<hr>
@empty
<div class="content" style="margin-top: 10px;text-align: center;">
	<div class="alert alert-warning" role="alert" >Belum ada posting</div>
</div>
@endforelse

<div style="text-align: center">
	{!! $posts->render() !!}
</div>

@stop
