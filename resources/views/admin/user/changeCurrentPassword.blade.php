@extends('admin.layout')

@section('webTitle')
Change Password
@stop

@section('main')
<form role="form" action="{{ route('admin.user.changeCurrentPassword.action') }}" method="post">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<div class="row">
		<div class="col-md-9">
			@if(Session::get('message_success') != '')
			<div class="alert alert-success" role="alert">
				{{ Session::get('message_success') }}
			</div>
			@elseif(Session::get('message_fail') != '')
			<div class="alert alert-danger" role="alert">
				{{ Session::get('message_fail') }}
			</div>
			@endif
			<div class="form-group @if($errors->has('password'))has-error has-feedback @endif">
				<label>Password<span style="color: red;">*</span></label>
				<input type="password" class="form-control" name="password" value="{{ Input::old('password') }}">
				@if($errors->has('password'))
				<i class="fa fa-exclamation-triangle fa-lg form-control-feedback" style="top: 35px;"></i>
				<span class="help-block">{{ $errors->first('password') }}</span>
				@endif
			</div>
			<div class="form-group @if($errors->has('retypepassword'))has-error has-feedback @endif">
				<label>Retype Password<span style="color: red;">*</span></label>
				<input type="password" class="form-control" name="retypepassword" value="{{ Input::old('retypepassword') }}">
				@if($errors->has('retypepassword'))
				<i class="fa fa-exclamation-triangle fa-lg form-control-feedback" style="top: 35px;"></i>
				<span class="help-block">{{ $errors->first('retypepassword') }}</span>
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