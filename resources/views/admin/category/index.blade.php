@extends('admin.layout')

@section('webTitle')
Category(s)
@stop

@section('breadcrumb')
<li class="active">Category(s)</li>
@stop

@section('main')
<a href="{{ route('admin.category.create') }}" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Add Category</a>
<div style="margin-top: 10px">
	<div class="row">
		<div class="col-lg-6">
			@include('admin.alert')
			<table class="table table-striped">
				<tbody>
					@forelse($categories as $category)
					<tr>
						<td>{{ $category->name }}</td>
						<td>{{ $category->tag }}</td>
						<td style="text-align: right">
							<a href="{{ route('admin.category.edit', $category->id) }}" class="btn btn-primary btn-xs">Edit</a>&nbsp;
							<a href="{{ route('admin.category.destroy', $category->id) }}" class="btn btn-danger btn-xs" onclick="return confirm('Delete?')">Delete</a>
						</td>
					</tr>
					@empty
					<tr>
						<td colspan="3" style="text-align: center;">No Category(s)</td>
					</tr>
					@endforelse
				</tbody>
			</table>
		</div>
	</div>
</div>
@stop