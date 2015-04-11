@extends('frontend.layout')

@section('meta')
<meta name="title" content="{{ $webSettings->web_title }}">
<meta name="keyword" content="{{ $webSettings->meta_keyword }}">
<meta name="description" content="{{ $webSettings->meta_description }}">
@stop

@section('webTitle')
Search| TeguhDEV
@stop

@section('head')
<style>
	.content h3 {
		border-bottom: 1px solid #EEEEEE;
		padding-bottom: 20px;
	}

	.content h3 a {
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

	.content h3 a:hover {
		color: #FF9C00;
	}

	.content h5 {
		font-family: 'Open Sans', sans-serif;
		font-weight: 300;
		color: #757575;
	}

	pre {
		background-color: #1B2426 !important;
		color: white !important;
		border: 1px solid #1B2426;
	}
</style>
@stop

@section('main')
<i><h4>Hasil pencarian dengan kata kunci <b>'{{ Input::get('q') }}'</b> ada <b>{{ count($posts) }}</b> posting</h4></i>
@forelse ($posts as $post)
<div class="content">
	<h3><a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a></h3>
	<h5>
		<span class="glyphicon glyphicon-user"></span> Oleh <a href="index.php">{{ $post->user->fullname }}</a>&nbsp;&nbsp; 
		<span class="glyphicon glyphicon-time"></span> Terbit {{ date("F d, Y",strtotime($post->created_at)) }}&nbsp;&nbsp;
		<span class="glyphicon glyphicon-time"></span> Revisi {{ date("F d, Y",strtotime($post->updated_at)) }}
		
		<div class="pull-right">			
			<div class="btn-group">
			  <button type="button" class="btn btn-xs btn-primary dropdown-toggle" data-toggle="dropdown">
			    <span class="glyphicon glyphicon-share"></span> Berbagi <span class="caret"></span>
			  </button>
			  <ul class="dropdown-menu" role="menu">
			    <li><a href="{{ $post->share->gplus }}">Google+</a></li>
			    <li><a href="{{ $post->share->facebook }}">Facebook</a></li>
			    <li><a href="{{ $post->share->twitter }}">Twitter</a></li>
			  </ul>
			</div>
		</div>
		
	</h5>
	<p>
		@if($post->preview_content == "")
		{!! $post->lazy_content !!}
		@else
		{{ $post->preview_content }}...<a href="{{ route('blog.show', $post->slug) }}">Selengkapnya</a>
		@endif
	</p>
</div>
@empty
<div class="content" style="margin-top: 10px;text-align: center;">
	<div class="alert alert-warning" role="alert" >Belum ada posting</div>
</div>
@endforelse

<div style="text-align: center">
	{{ $posts->render() }}
</div>

@stop
