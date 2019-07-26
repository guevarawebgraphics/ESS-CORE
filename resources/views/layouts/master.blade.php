<!DOCTYPE html>
<html>
<head>
	<title>{{ config('app.name', 'Laravel') }}</title>
	<meta charset="utf-8">
	<meta content="width=device-width, initial-scale=1" name="viewport">
	<meta content="ie=edge" http-equiv="x-ua-compatible"><!-- Font Awesome Icons -->
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<!-- Styles -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet"><!--Custome Style-->
	<link href="{{ asset('plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet"><!-- IonIcons -->
	<link href="{{ asset('http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css') }}" rel="stylesheet"><!-- Theme style -->
	<link href="{{ asset('dist/css/adminlte.min.css') }}" rel="stylesheet"><!-- Google Font: Source Sans Pro -->
	{{-- <link href="{{ asset('https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700') }}" rel="stylesheet"> --}}
	<link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet"> <!--Font Poppins-->
	<link href="{{ asset('Toastr/toastr.min.css') }}" rel="stylesheet"> <!--Toastr-->
	<link href="{{ asset('plugins/select2/select2.min.css') }}" rel="stylesheet"><!-- select -->
	<link href="{{ asset('/plugins/datepicker/datepicker3.css') }}" rel="stylesheet"><!--DatePicker-->
	<link href="{{ asset('/plugins/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet"><!--DataTable-->
	<link href="{{ asset('/plugins/datatables/extensions/Responsive/css/dataTables.responsive.css') }}" rel="stylesheet"><!--Responsive DataTable-->
	<!--Full Calendar-->
	<link rel="stylesheet" href="{{ asset('/plugins/fullcalendar/fullcalendar.min.css') }}">
	{{-- <link rel="stylesheet" href="{{ asset('/plugins/fullcalendar/fullcalendar.print.min.css') }}"> --}}

	<!-- REQUIRED SCRIPTS -->
	<!-- jQuery -->
	<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script> <!-- Bootstrap -->
	<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script> <!-- AdminLTE -->
	<script src="{{ asset('dist/js/adminlte.js') }}"></script> <!-- OPTIONAL SCRIPTS -->
	<script src="{{ asset('dist/js/demo.js') }}"></script> 
	<script src="{{ asset('dist/js/pages/dashboard3.js') }}"></script>
	<!-- DataTables -->
	<script src="{{ asset('/plugins/datatables/jquery.dataTables.js') }}"></script>
	<script src="{{ asset('/plugins/datatables/dataTables.bootstrap4.js') }}"></script>
	<script src="{{ asset('plugins/jQueryUI/jquery-ui.js') }}"></script>
	<script src="{{ asset('plugins/JQueryUI/jquery-ui.min.js') }}"></script>
	<script src="{{ asset('plugins/datepicker/bootstrap-datepicker.js') }}"></script>
	<!-- SELECT 2 -->
	<script src="{{ asset('/plugins/select2/select2.full.min.js') }}"></script>
	<!-- Responsive -->
	<script src="{{ asset('/plugins/datatables/extensions/Responsive/js/dataTables.responsive.min.js') }}"></script>
	<!--Toastr-->
	<script src="{{ asset('Toastr/toastr.min.js') }}"></script>
	{{-- SWEET ALERT --}}
	<link href="{{ asset('sweetalert/sweetalert.css') }}" rel="stylesheet">
	<script src="{{ asset('sweetalert/sweetalert.js')}}" ></script>
	<link href="{{ asset('sweetalert/sweetalert.min.css') }}" rel="stylesheet">	
	<link href="{{ asset('sweetalert/sweetalert.min.css.map') }}">
	<script src="{{ asset('sweetalert/sweetalert.min.js') }}" ></script>
	{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.2.0/socket.io.dev.js"></script> --}}
	<!-- Socket IO -->
	<script src="{{ asset('SocketIO/socket.io.dev.js') }}"></script>
	{{-- <script src="http://cdn.ckeditor.com/4.11.4/standard/ckeditor.js"></script> --}}
	<!-- CKEDITOR 4 -->
	<script src="{{ asset('/ckeditor/ckeditor.js') }}"></script>
	<script src="{{ asset('/ckeditor/adapters/jquery.js') }}"></script>
	<script src="{{ asset('/ckeditor/ckfinder/ckfinder.js') }}"></script>
	<!--Full Calendar-->
	<script src="{{ asset('/plugins/moment/moment.min.js') }}"></script>
	<script src="{{ asset('/plugins/fullcalendar/fullcalendar.min.js') }}"></script>
	{{-- <script src="{{ asset('/ckeditor/ckfinder/core/connector/php/connector') }}"></script> --}}
	<!--ionic icons-->
	<link href="{{ asset('Ionicons/ionicons.min.css') }}" rel="stylesheet">
	<!--Scripts-->
	@if(Auth::check())
	<script src="{{ asset('js/scripts.js') }}"></script> 
	<script src="{{ asset('js/scripts-j.js') }}"></script>
	<!--Upload Image-->
	<script src="{{ asset('js/uploadprofile_image.js') }}"></script>
	@endif
    
</head>
<body class="hold-transition sidebar-mini">
	<div class="wrapper">
        @guest

		@else	
			@include('inc/navbar')
			@php
			 $user_picture = DB::table('user_picture')->where('user_id', '=', auth()->user()->id)->pluck('profile_picture')->first(); 
			 $link = '/storage/profile_picture/';  
			 if(empty($user_picture))
			 {
				if(auth()->user()->employee_id=="none")
				{
					 $user_picture = "essmale.png";
				}
				else 
				{
					$employee_table = DB::table('employee as e')
                                            ->join('employee_personal_information as epi','e.employee_info','=','epi.id')
                                            ->select('e.id as idno','epi.gender as gender')
                                            ->where('e.id','=',auth()->user()->employee_id)
                                            ->first();
                                            
                                            $user_picture = $employee_table->gender; //gets the gender of the user 
                                            
                                            //providing default picture 
                                            if($user_picture == "Female") 
                                            {
                                                        $user_picture = "essfemale.png";
                                            } 
                                            else
                                            {
                                                        $user_picture = "essmale.png";
                                            }
				}
	
			 }

			@endphp           
			@include('inc/sidebar', ['user_picture' => $user_picture, 'link' => $link]) 
	
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
	{{-- Custom Sript --}}
	<!--IOnicons Script-->
	{{-- <script src="{{ asset('Ionicons/ionicons.js') }}"></script> --}}
	{{-- Pusher --}}
	<script src="https://js.pusher.com/4.4/pusher.min.js"></script>
    @include('inc/footer')
	
	
</body>
</html>