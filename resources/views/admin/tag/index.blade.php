@extends('admin.layout')

@section('webTitle')
Tag(s)
@stop

@section('breadcrumb')
<li class="active">Tag(s)</li>
@stop

@section('main')
<a href="{{ route('admin.tag.create') }}" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Add Tag</a>
<div style="margin-top: 10px">
	<div class="row">
		<div class="col-lg-6">
			@include('admin.alert')
			<table class="table table-striped">
				<tbody>
					@forelse($tags as $tag)
					<tr>
						<td>{{ $tag->name }}</td>
						<td style="text-align: right">
							<a href="{{ route('admin.tag.edit', $tag->id) }}" class="btn btn-primary btn-xs">Edit</a>&nbsp;
							<a href="{{ route('admin.tag.destroy', $tag->id) }}" class="btn btn-danger btn-xs" onclick="return confirm('Delete?')">Delete</a>
						</td>
					</tr>
					@empty
					<tr>
						<td colspan="3" style="text-align: center;">No Tag(s)</td>
					</tr>
					@endforelse
				</tbody>
			</table>
		</div>
	</div>
</div>
@stop