<!DOCTYPE html>
<html>
<head>
	<title>{{ config('app.name', 'Laravel') }}</title>
	<style>
		table td{
			font-size: 85%;
			text-align: center;			
		}

		table th{
			text-align: center;
			font-size: 95%;
		}

		li a p{
			font-size: 90%;
		}
		
	</style>
</head>
<body>
	<meta charset="utf-8">
	<meta content="width=device-width, initial-scale=1" name="viewport">
	<meta content="ie=edge" http-equiv="x-ua-compatible"><!-- Font Awesome Icons -->
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link href="{{ asset('plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet"><!-- IonIcons -->
	<link href="{{ asset('http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css') }}" rel="stylesheet"><!-- Theme style -->
	<link href="{{ asset('dist/css/adminlte.min.css') }}" rel="stylesheet"><!-- Google Font: Source Sans Pro -->
	<link href="{{ asset('https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700') }}" rel="stylesheet">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
	<link href="{{ asset('plugins/select2/select2.min.css') }}" rel="stylesheet"><!-- select -->
	<link href="{{ asset('plugins//bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}" rel="stylesheet">

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
	<!-- DataTables -->
	<script src="{{ asset('/plugins/datatables/jquery.dataTables.js') }}"></script>
	<script src="{{ asset('/plugins/datatables/dataTables.bootstrap4.js') }}"></script>
	<!-- SELECT 2 -->
	<script src="{{ asset('/plugins/select2/select2.full.min.js') }}"></script>
	<!-- CK Editor -->
	<script src="{{ asset('/plugins/ckeditor/ckeditor.js') }}"></script>
	<!-- Bootstrap WYSIHTML5 -->
	<script src="{{ asset('/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
	<script src="https://twitter.github.io/typeahead.js/releases/latest/typeahead.bundle.js"></script>
	<script src="{{ asset('js/scripts.js') }}"></script>
    
	<div class="wrapper">
        @guest

        @else
            @include('inc/navbar')           
            @include('inc/sidebar')
            <div class="content-wrapper">			
			<div class="content-header">
				<div class="container-fluid">
					@yield('crumb')
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

	
</body>
</html>