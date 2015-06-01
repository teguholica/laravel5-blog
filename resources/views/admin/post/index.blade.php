@extends('admin.layout')

@section('webTitle')
    Post List
@stop

@section('breadcrumb')
<li class="active">Post(s)</li>
@stop

@section('main')
<a href="{{ route('admin.post.create') }}" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Add Post</a>
<div style="margin-top: 10px">
	@include('admin.alert')
	<table class="table table-striped">
		<tbody>
			@forelse($posts as $post)
			<tr>
				<td>{{ $post->id }}</td>
				<td>{{ $post->title }}</td>
				<td>{{ $post->category->name }}</td>
				<td>{{ $post->comment->count() }} Comments</td>
				<td style="text-align: right">
					<a href="{{ route('admin.post.edit', $post->id) }}" class="btn btn-primary btn-xs">Edit</a>&nbsp;
					<a href="{{ route('admin.post.destroy', $post->id) }}" onclick="return confirm('Delete?')" class="btn btn-danger btn-xs">Delete</a>
				</td>
			</tr>
			@empty
			<tr>
				<td colspan="3" style="text-align: center;">No Post(s)</td>
			</tr>
			@endforelse
		</tbody>
	</table>
	<div style="text-align: center">
		{{ $posts->render() }}
	</div>
</div>
@stop