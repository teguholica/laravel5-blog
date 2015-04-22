<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">
		<link rel="icon" href="../../favicon.ico">

		<title>Login</title>
		<link href="{{ asset('res/bootstrap-3.3.4/css/bootstrap.min.css') }}" rel="stylesheet">
		<style>
			body {
				background-color: #F1F1F1;
				margin-top: 100px;
			}

			#content {
				background-color: #FFFFFF;
				-webkit-box-shadow: 0px 2px 2px 0px rgba(50, 50, 50, 0.1);
				-moz-box-shadow: 0px 2px 2px 0px rgba(50, 50, 50, 0.1);
				box-shadow: 0px 2px 2px 0px rgba(50, 50, 50, 0.1);
				margin-bottom: 10px;
				padding: 20px;
			}
		</style>
	</head>
	<body>
		<div class="container">
			<div class="row">
				<div id="content" class="col-md-8 col-md-offset-2">
					@if (count($errors) > 0)
						<div class="alert alert-danger">
							<strong>Whoops!</strong> There were some problems with your input.<br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif

					<form class="form-horizontal" role="form" method="POST" action="{{ url('auth/login') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="form-group">
							<label class="col-md-4 control-label">E-Mail Address</label>
							<div class="col-md-6">
								<input type="email" class="form-control" name="email" value="{{ old('email') }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Password</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="password">
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<div class="checkbox">
									<label>
										<input type="checkbox" name="remember"> Remember Me
									</label>
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary" style="margin-right: 15px;">
									Login
								</button>

								<a href="/password/email">Forgot Your Password?</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<script type="text/javascript" src="{{ asset('res/jquery-2.1.3/jquery.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('res/bootstrap-3.3.4/js/bootstrap.min.js') }}"></script>
	</body>
</html>