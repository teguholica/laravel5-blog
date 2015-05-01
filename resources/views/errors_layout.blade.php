<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="author" content="Teguh Arifianto">
		<title>@yield('webTitle')</title>
		<link rel="stylesheet" type="text/css" href="{{ asset('res/bootstrap-3.3.4/css/bootstrap.min.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('res/bootstrap-3.3.4/css/bootstrap-theme.min.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('res/frontend/blog-home.css') }}">
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>
		@yield('head')
	</head>
	<body>
		@yield('main')
		<!-- /.container -->
		<!-- JavaScript -->
		<script type="text/javascript" src="{{ asset('res/jquery-2.1.3/jquery.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('res/bootstrap-3.3.4/js/bootstrap.min.js') }}"></script>
		@yield('foot')
	</body>
</html>