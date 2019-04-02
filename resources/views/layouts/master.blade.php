<!DOCTYPE html>
<html>
<head>
	<title>{{ config('app.name', 'Laravel') }}</title>
</head>
<body>
	<meta charset="utf-8">
	<meta content="width=device-width, initial-scale=1" name="viewport">
	<meta content="ie=edge" http-equiv="x-ua-compatible"><!-- Font Awesome Icons -->
	<link href="{{ asset('plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet"><!-- IonIcons -->
	<link href="{{ asset('http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css') }}" rel="stylesheet"><!-- Theme style -->
	<link href="{{ asset('dist/css/adminlte.min.css') }}" rel="stylesheet"><!-- Google Font: Source Sans Pro -->
	<link href="{{ asset('https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700') }}" rel="stylesheet">
    
	<div class="wrapper">
        @guest

        @else
            @include('inc/navbar')           
            @include('inc/sidebar')
            <div class="content-wrapper">			
			<div class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1 class="m-0 text-dark">Dashboard</h1>
						</div>
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item">
									<a href="#">Home</a>
								</li>
								<li class="breadcrumb-item active">Dashboard</li>
							</ol>
						</div>
					</div>
				</div>
			</div>			
        @endguest				
			<div class="content">
                <!-- RENDERING PAGES -->
				@yield('content')
			</div>
		</div>			
	</div>
    @include('inc/footer')

	<!-- REQUIRED SCRIPTS -->
	<!-- jQuery -->
	<script src="{{ asset('plugins/jquery/jquery.min.js') }}">
	</script> <!-- Bootstrap -->
	<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}">
	</script> <!-- AdminLTE -->
	<script src="{{ asset('dist/js/adminlte.js') }}">
	</script> <!-- OPTIONAL SCRIPTS -->
	<script src="{{ asset('dist/js/demo.js') }}">
	</script> 
	<script src="{{ asset('dist/js/pages/dashboard3.js') }}">
	</script>
</body>
</html>