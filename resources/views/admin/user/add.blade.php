@extends('admin.layout')

@section('webTitle')
Add User
@stop

@section('main')
<form role="form" action="{{ route('admin.user.add.action') }}" method="post">
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
				<input type="text" class="form-control" name="display_name" value="{{ Input::old('display_name') }}">
				@if($errors->has('display_name'))
				<i class="fa fa-exclamation-triangle fa-lg form-control-feedback" style="top: 35px;"></i>
				<span class="help-block">{{ $errors->first('display_name') }}</span>
				@endif
			</div>
			<div class="form-group @if($errors->has('username'))has-error has-feedback @endif">
				<label>Username<span style="color: red;">*</span></label>
				<input type="text" class="form-control" name="username" value="{{ Input::old('username') }}">
				@if($errors->has('username'))
				<i class="fa fa-exclamation-triangle fa-lg form-control-feedback" style="top: 35px;"></i>
				<span class="help-block">{{ $errors->first('username') }}</span>
				@endif
			</div>
			<div class="form-group @if($errors->has('email'))has-error has-feedback @endif">
				<label>Email<span style="color: red;">*</span></label>
				<input type="text" class="form-control" name="email" value="{{ Input::old('email') }}">
				@if($errors->has('email'))
				<i class="fa fa-exclamation-triangle fa-lg form-control-feedback" style="top: 35px;"></i>
				<span class="help-block">{{ $errors->first('email') }}</span>
				@endif
			</div>
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