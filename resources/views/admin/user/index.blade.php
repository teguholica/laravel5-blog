@extends('admin.layout')

@section('webTitle')
    User List
@stop

@section('main')
@if(Session::get('message') != '')
<div class="alert alert-success fade in" role="alert">
	<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
	{{ Session::get('message') }}
</div>
@endif
<a href="{{ route('admin.user.add.action') }}" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Add User</a>
<div style="margin-top: 10px">
	<table class="table table-striped">
		<tbody>
			@forelse($users as $user)
			<tr>
				<td>{{ $user->id }}</td>
				<td>{{ $user->display_name }}</td>
				<td>{{ $user->email }}</td>
				<td style="text-align: right">
					<a href="{{ route('admin.user.edit.view', $user->id) }}" class="btn btn-primary btn-xs">Edit</a>&nbsp;
					<a href="{{ route('admin.user.delete.action', $user->id) }}" onclick="return confirm('Delete?')" class="btn btn-danger btn-xs">Delete</a>
				</td>
			</tr>
			@empty
			<tr>
				<td colspan="3" style="text-align: center;">No User(s)</td>
			</tr>
			@endforelse
		</tbody>
	</table>
</div>
@stop