<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Scripts -->
   
    <style>
        .nopadding {
            padding: 0 !important;
            margin: 0 !important;
            }
    </style>  
    <link href="{{ asset('css/app.css') }}" rel="stylesheet"> 
</head>
<body>
<div class ="card border-dark" style="max-height: 40rem; height:40rem;"> 
       
<p style="font-size:15px;">Dear <b>{{ucfirst($lastname) . ", " . ucfirst($firstname) . " " . ucfirst($middlename)}} </b></p>
<br>

<p>Congratulations! You have been registered by your Employer, {{$employer_name}}, to MyCASHere Payroll & Financial Services. Kindly verify your 
email and activate your account by clicking this link <a href="#">click here to subscribe</a>. You will be redirected to MyCASHere account activation 
page and you will be required to enter your access credentials below and the verification code sent to your registered Mobile No. <b>{{$mobile_no}}</b>. If you have recently changed your mobile no. 
kindly advise your HR immediately to update your registration details. 
</p>
<br>
<p>
    Below is your system generated access credentials:
</p>
<br>
<p><b>Username: </b> {{$username}}</p>
<p><b>Temporary Password: </b> {{$password}} </p>
<br>
<p>For your protection, we will immediately ask you to enter your NEW PASSWORD. Never share your User ID and Password to anybody.</p>
<br>
<p style="font-size:14px;">Have a nice day!</p>
<p style="font-size:12px;">Sincerely,</p>
<p style="font-size:11px;">MyCASHere Team</p>



{{-- <p style="">Dear </p>
<br>
<p>Congratulations! You have been registered by your Employer, , to MyCASHere Payroll & Financial Services. Kindly verify your 
    email and activate your account by clicking this link <a href="#">click here to subscribe</a>. You will be redirected to MyCASHere account activation 
    page and you will be required to enter your access credentials below and the verification code sent to your registered mobile no. 091212121212. If you have recently changed your mobile no. 
    kindly advise your HR immediately to update your registration details. 
</p>
<br>
<p>
    Below is your system generated access credentials:
</p>
<br>
<p><b>Username: </b> </p>
<p><b>Temporary Password: </b> 123456 </p>
<br>
<p>For your protection, we will immediately ask you to enter your NEW PASSWORD. Never share your User ID and Password to anybody.</p>
<br>
<p style="font-size:14px;">Have a nice day!</p>
<p style="font-size:10px;">Sincerely,</p>
<p style="font-size:10px;">MyCASHere Team</p> --}}

</div>
</body>
</html>
