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
		{{ HTML::style('assets/bootstrap/css/bootstrap.min.css') }}
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
				<div id="content" class="col-md-4 col-md-offset-4">
					@if(Session::has('error'))
					<div class="alert alert-danger" role="alert">
						{{ Session::get('error') }}
					</div>
					@endif
					@if(Session::has('message'))
					<div class="alert alert-success" role="alert">
						{{ Session::get('message') }}
					</div>
					@endif
					<form role="form" action="{{ route('login') }}" method="post">
						<div class="form-group{{ $errors->has('username')?' has-error':'' }}">
							<input type="text" class="form-control" name="username" placeholder="Username" value="{{ Input::old('username') }}">
						</div>
						<div class="form-group{{ $errors->has('password')?' has-error':'' }}">
							<input type="password" class="form-control" name="password" placeholder="Password">
						</div>
						<div class="checkbox">
							<label>
								<input type="checkbox">
								Remember me </label>
						</div>
						<div class="col-md-6 col-md-offset-3" style="text-align: center">
							<button type="submit" class="btn btn-primary">
								Submit
							</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		{{ HTML::script('assets/jquery/jquery-1.10.2.js') }}
		{{ HTML::script('assets/bootstrap/js/bootstrap.min.js') }}
	</body>
</html>