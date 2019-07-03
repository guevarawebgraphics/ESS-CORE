@extends('layouts.master')

@section('crumb')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="m-0 text-dark">My Profile</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
                <a href="#">My Profile</a>
            </li>
            <li class="breadcrumb-item active">Settings</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
@php
if(Session::get('my_profile') == 'all'){
    $add = '';
    $edit = '';
    $delete = '';
}
elseif(Session::get('my_profile') == 'view'){
    $add = 'disabled';
    $edit = 'disabled';
    $delete = 'disabled';
}
elseif(Session::get('my_profile') == 'add'){
    $add = '';
    $edit = 'disabled';
    $delete = 'disabled';
}
elseif(Session::get('my_profile') == 'edit'){
    $add = '';
    $edit = '';
    $delete = 'disabled';
}
elseif(Session::get('my_profile') == 'delete'){
    $add = '';
    $edit = 'disabled';
    $delete = '';
}else{
    $add = 'disabled';
    $edit = 'disabled';
    $delete = 'disabled';
}                   
@endphp
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <div class="card card-info card-outline">
                <div class="card-header">
                    <center><strong> @if(auth()->user()->user_type_id == 1) Admin @elseif(auth()->user()->user_type_id == 3) Employer @elseif(auth()->user()->user_type_id == 4) Employee @endif</strong></center>
                </div>
                <div class="card-body">           
                    <div class="image">
                        <center>
                            <img alt="User Image" class="profile-user-img img-responsive img-circle elevation-2" id="settings_profile_picture" style="height: 100px; width: 99px;">
                        </center>
                    </div>                                    
                </div>
            </div>
            <div class="card card-info card-outline">
                <div class="card-header">
                    <center><strong>About Me</strong></center>
                </div>
                <div class="card-body">
                    <h6 class="card-title"><strong>Account Info</strong></h6>
                    <p class="card-text">                     
                        <div id="acc_info"></div>{{-- LALABAS DITO UNG ACCOUNT TYPE NYA KUNG ADMIN OR EMPLOYER ETC --}}
                    </p>       
                    <h6 class="card-title"><strong>Location</strong></h6>
                        <div id="location"></div>

                    <h6 class="card-title"><strong>Notes</strong></h6>
                    <p class="card-text">-</p>     
                </div>
            </div>
            @if(auth()->user()->user_type_id != 1)
            <div class="card card-info card-outline">
                <div class="card-header">
                    <center><strong>Goverment Numbers</strong></center>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card-title"><strong></strong></div>
                            <h6 class="card-title"><strong>TIN</strong></h6>
                            <div id="tin"></div>
                            <br>
                            <h6 class="card-title"><strong>SSS</strong></h6>
                            <div id="sss"></div>
                            <br>
                            <h6 class="card-title"><strong>PHIC</strong></h6>
                            <div id="phic"></div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="card-title"><strong>HDMF</strong></h6>
                            <div id="hdmf"></div>
                            <br>
                            <h6 class="card-title"><strong>NID</strong></h6>
                            <div id="nid"></div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            <!--Documents-->
            @if(auth()->user()->user_type_id === 3)
            <div class="card card-info card-outline">
                <div class="card-header">
                    <center><strong>Documents</strong></center>
                </div>
                <div class="card-body">
                    <h6 class="card-title"><strong>SEC</strong></h6>
                    <div id="sec"></div>
                    <br>
                    <h6 class="card-title"><strong>BIR</strong></h6>
                    <div id="bir"></div>
                </div>
            </div>
            @endif
            <!--End Documents -->
        </div>
        <div class="col-md-9">
            <div class="card card-info card-outline">
                <div class="card-header">
                    <center><strong>Account Settings</strong></center>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        {{-- Hidden ID --}}
                        <input type="hidden" id="hidden_id" />
                        <label for="txtusername" class="col-form-label col-md-2">Username</label>
                        <div class="col-md-6">
                            <input type="text" id="txtusername" class="form-control" name="username" disabled value="{{auth()->user()->username}}">            
                        </div>
                    </div>   
                    <div class="form-group row">
                        <label for="txtmobile" class="col-form-label col-md-2">Mobile Number</label>
                        <div class="col-md-6">                       
                            <div id="mobile"></div>
                        </div>
                    </div>  
                    <div class="form-group row">
                        <label for="txtemail" class="col-form-label col-md-2">Email @if(auth()->user()->email_verified_at != "")<span data-toggle="tooltip" data-placement="right" title="Verified"><i class="fa fa-check-circle text-primary"></i></span>@endif</label>
                        <div class="col-md-6">
                            <div id="email"></div>                                   
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary" id="btnUpdate" {{$edit}}>Update Account</button>                                                                      
                </div>              
            </div>
            @if(auth()->user()->user_type_id === 3)
            <!--Expiration-->
            <div class="card card-info card-outline">
                <div class="card-header">
                    <center><strong>Subscription</strong></center>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Enrollment Date</th>
                                <th>Expiration Date</th>
                                <th>Summary</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ \Carbon\Carbon::parse(auth()->user()->enrollment_date)->format('l jS \\of F Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse(auth()->user()->expiry_date)->format('l jS \\of F Y')  }} </td>
                                <td>{{ \Carbon\Carbon::parse(auth()->user()->enrollment_date)->diffForHumans(\Carbon\Carbon::parse(auth()->user()->expiry_date), true) }} ({{ \Carbon\Carbon::parse(auth()->user()->enrollment_date)->diffInDays(\Carbon\Carbon::parse(auth()->user()->expiry_date)) .' '. 'Days'  }})</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div><!--End Expiration-->
            @endif
            @if(auth()->user()->user_type_id === 4)
            <!--Settings Employer-->
            <div class="card card-info card-outline">
                <div class="card-header">
                    <center><strong>Current Employers</strong></center>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Employer</th>
                                <th>Enrollment Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($get_all_employers as $employers)
                            <tr>
                                <td>{{ $employers->business_name }}</td>
                                <td>{{ \Carbon\Carbon::parse($employers->enrollment_date)->format('l jS \\of F Y') }}</td>
                                <td>@if( $employers->status  == 1) <span class="badge badge-success">Active</span> @endif
                                     @if( $employers->status  == 2) <span class="badge badge-secondary">In-Active</span> @endif
                                     @if( $employers->status  == 3) <span class="badge badge-danger">Deactivated</span> @endif
                                     @if( $employers->status  == 0) <span class="badge badge-dark">Deleted</span> @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
            <!--End Settings Employer-->
            
        </div>
    </div>    
</div>

<script type="text/javascript">
    $(document).ready(function(){
        get_profile_picture();
        //Get the informations to show
        $.ajax({
            headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: "{{ route('settingsinfo') }}",
            method: "GET",
            data:{}, 
            dataType: "JSON",
            success:function(data)
            {
                if(data.type_name == null){
                    $("#acc_info").html('<p>'+"ESS Admin"+'</p>');
                }
                else {
                    $("#acc_info").html('<p>' + data.type_name + '</p>');
                }
                
                $("#hidden_id").val(data.id);

                if(data.unit == null && data.unit == null && data.brgy == null && data.mun == null && data.prov == null)
                {
                    $("#location").html('<p class="card-text" style="text-transform:uppercase">-</p>');
                }
                else
                {
                    $("#location").html('<p class="card-text" style="text-transform:uppercase">'+ data.unit + " " + data.brgy + " " + data.mun + " " + data.prov +'</p>');
                }
                
                if(data.email == null)
                {
                    $("#email").html('<input type="text" id="txtemail" class="form-control" name="email" value="-" disabled>');
                }
                else
                {
                    $("#email").html('<input type="text" id="txtemail" class="form-control" name="email" value="'+ data.email +'" >');
                }

                if(data.contact == null)
                {
                    $("#mobile").html('<input type="text" id="txtmobile" class="form-control" name="mobile" value="-" disabled>');
                }
                else
                {
                    $("#mobile").html('<input type="text" id="txtmobile" class="form-control" name="mobile" value="'+ data.contact +'" >');
                }

                if(data.tin == null)
                {
                    $("#tin").html('<p class="card-text" style="text-transform:uppercase">-</p>');
                }
                else
                {
                    $("#tin").html('<p class="card-text" style="text-transform:uppercase">'+ data.tin +'</p>');
                }

                if(data.sss == null)
                {
                    $("#sss").html('<p class="card-text" style="text-transform:uppercase">-</p>');
                }
                else
                {
                    $("#sss").html('<p class="card-text" style="text-transform:uppercase">'+ data.sss +'</p>');
                }

                if(data.phic == null)
                {
                    $("#phic").html('<p class="card-text" style="text-transform:uppercase">-</p>');
                }
                else
                {
                    $("#phic").html('<p class="card-text" style="text-transform:uppercase">'+ data.phic +'</p>');
                }

                if(data.hdmf == null)
                {
                    $("#hdmf").html('<p class="card-text" style="text-transform:uppercase">-</p>');
                }
                else
                {
                    $("#hdmf").html('<p class="card-text" style="text-transform:uppercase">'+ data.hdmf +'</p>');
                }

                if(data.nid == null)
                {
                    $("#nid").html('<p class="card-text" style="text-transform:uppercase">-</p>');
                }
                else
                {
                    $("#nid").html('<p class="card-text" style="text-transform:uppercase">'+ data.nid +'</p>');
                }

                if(data.sec == null)
                {
                    $("#sec").html('<p class="card-text" style="text-transform:uppercase">-</p>');
                }
                else
                {
                    var sec = data.sec;
                    $("#sec").html('<a href="/storage/Documents/sec/'+data.sec+'" data-toggle="tooltip" data-placement="top" title="Click To Download This File" download>' +(sec.length > 10 ? sec.substring(0, 10)+'<div class="float-right"><i class="fa fa-download"></i></div>' : data.sec) +'</a>');
                }

                if(data.bir == null)
                {
                    $("#bir").html('<p class="card-text" style="text-transform:uppercase">-</p>');
                }
                else
                {
                    var bir = data.bir;
                    $("#bir").html('<a href="/storage/Documents/bir/'+data.bir+'" data-toggle="tooltip" data-placement="top" title="Click To Download This File" download>' +(bir.length > 10 ? bir.substring(0, 10)+'<div class="float-right"><i class="fa fa-download"></i></div>' : data.bir) +'</a>');
                }
                
            }
        });

        //update settings
        $(document).on("click", "#btnUpdate", function(){
            id = $("#hidden_id").val();
            email = $("#txtemail").val();
            mobile = $("#txtmobile").val();
            toastr.remove()
            toastr.clear()

            if(email == "-" || mobile == "-")
            {
                toastr.error('Failed to Update', 'Failed')
            }
            else
            {
                swal({
                    title: "Update this account?",
                    //text: "Your will not be able to recover this imaginary file!",
                    type: "warning",             
                    confirmButtonClass: "btn-info",
                    confirmButtonText: "Yes",
                    showCancelButton: true,
                    closeOnConfirm: true,
                    },
                    function()
                    {                   
                        $.ajax({
                            headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            url: "{{ route('settingsupdate_post') }}",
                            method: "POST",
                            data:{id: id, email: email, contact: mobile},               
                            success:function(data)
                            {
                                toastr.success('Account Updated Successfully', 'Success')
                            }                  
                        });  
                    }
                );                
            }                   
        });


        /**
       * @ Get Profile Picture
       * */
      function get_profile_picture(){
        $.ajax({
          type: 'GET',
          url: '/ProfilePicture/get_profile_picture',
          async: false,
          dataType: 'json',
          success: function(data){
            //console.log(data);
            $('#settings_profile_picture').attr('src', '/storage/profile_picture/' + data);
          },
          error: function(data){

          }
        });
      }

    });
</script>
@endsection