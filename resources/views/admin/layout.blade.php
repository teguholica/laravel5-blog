<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title> @yield('webTitle', 'No Title') </title>
		<link href="{{ asset('res/bootstrap-3.3.4/css/bootstrap.min.css') }}" rel="stylesheet">
		<link href="{{ asset('res/bootstrap-3.3.4/css/bootstrap-theme.min.css') }}" rel="stylesheet">
		<link href="{{ asset('res/font-awesome-4.1.0/css/font-awesome.min.css') }}" rel="stylesheet" />
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>
		<style>
			body {
				margin-top: 10px;
			}
			
			.navbar {
				font-family: 'Open Sans', sans-serif;
				font-weight: 300;
			}
			
			.navbar-brand {
				color: #FF9C00 !important;
			}
			
			.navbar-brand:hover {
				color: #FFFFFF !important;
			}
		</style>
		@yield('head')
	</head>
	<body>

		<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="#">{ #Admin }</a>
				</div>
			</div>
		</div>

		<div class="container-fluid" style="margin-top: 80px;">

			<div class="row">
				<div class="col-md-2" style="border-right: 1px solid #EEE;">
					<ul class="nav nav-pills nav-stacked">
						<li {{ Request::is('*admin')?'class=active':'' }}>
							<a href="{{ route('admin.dashboard.index') }}">Dashboard</a>
						</li>
						<li>
							<a href="{{ route('blog.index') }}" target="_blank">Go to site</a>
						</li>
						<li @if(Request::url() == route('admin.user.index.view'))class="active"@endif>
							<a href="{{ route('admin.user.index.view') }}">User</a>
						</li>
						<li @if(Request::url() == route('admin.user.changeCurrentPassword.view'))class="active"@endif>
							<a href="{{ route('admin.user.changeCurrentPassword.view') }}">Change Password</a>
						</li>
						<li>
							<a href="{{ url('auth/logout') }}">Log Out</a>
						</li>
					</ul>
					<hr>
					<ul class="nav nav-pills nav-stacked" style="margin-top: 10px;">
						<li {{ Request::is('*admin/post*')?'class=active':'' }}>
							<a href="{{ route('admin.post.index') }}">Post</a>
						</li>
						<li {{ Request::is('*admin/tag*')?'class=active':'' }}>
							<a href="{{ route('admin.tag.index') }}">Tag</a>
						</li>
						<li {{ Request::is('*admin/category*')?'class=active':'' }}>
							<a href="{{ route('admin.category.index') }}">Category</a>
						</li>
					</ul>
					<hr>
					<ul class="nav nav-pills nav-stacked" style="margin-top: 10px;">
						<li {{ Request::is('*admin/gcm_device*')?'class=active':'' }}>
							<a href="{{ route('admin.gcm_device.index') }}">GCM Device</a>
						</li>
						<li {{ Request::is('*admin/web_setting*')?'class=active':'' }}>
							<a href="{{ route('admin.web_setting.index') }}">Web Setting</a>
						</li>
					</ul>
				</div>
				<div class="col-md-10">
					<ol class="breadcrumb">
						<li><a href="{{ route('admin.dashboard.index') }}">Home</a></li>
						@yield('breadcrumb')
					</ol>
					@yield('main')
				</div>

			</div>
		</div>
		<script type="text/javascript" src="{{ asset('res/jquery-1.11.1/jquery.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('res/bootstrap-3.3.4/js/bootstrap.min.js') }}"></script>
		@yield('foot')
	</body>
</html>