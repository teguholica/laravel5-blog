@extends('admin.layout')

@section('webTitle')
Edit User - {{ $user->fullname }}
@stop

@section('main')
<form role="form" action="{{ route('admin.user.edit.action', $user->id) }}" method="post">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<div class="row">
		<div class="col-md-6">
			@if(Session::get('message_success') != '')
			<div class="alert alert-success" role="alert">
				{{ Session::get('message_success') }}
			</div>
			@elseif(Session::get('message_fail') != '')
			<div class="alert alert-danger" role="alert">
				{{ Session::get('message_fail') }}
			</div>
			@endif
			<div class="form-group @if($errors->has('display_name'))has-error has-feedback @endif">
				<label>Display Name<span style="color: red;">*</span></label>
				<input type="text" class="form-control" name="display_name" value="{{ $user->display_name }}">
				@if($errors->has('display_name'))
				<i class="fa fa-exclamation-triangle fa-lg form-control-feedback" style="top: 35px;"></i>
				<span class="help-block">{{ $errors->first('display_name') }}</span>
				@endif
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-primary">
					Save
				</button>
			</div>
		</div>
	</div>
</form>
<hr>
@stop