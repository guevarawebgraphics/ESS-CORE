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
                    <center><strong>Admin</strong></center>
                </div>
                <div class="card-body">           
                    <div class="image">
                        <center>
                            <img alt="User Image" class="profile-user-img img-responsive img-circle elevation-2" src="../storage/pic.jpg">
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
                        <label for="txtemail" class="col-form-label col-md-2">Email</label>
                        <div class="col-md-6">
                            <div id="email"></div>                                   
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary" id="btnUpdate" {{$edit}}>Update Account</button>                                                                      
                </div>              
            </div>           
        </div>
    </div>    
</div>

<script type="text/javascript">
    $(document).ready(function(){
        //Get the informations to show
        $.ajax({
            headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: "{{ route('settingsinfo') }}",
            method: "GET",
            data:{}, 
            dataType: "JSON",
            success:function(data)
            {
                $("#acc_info").html('<p>' + data.type_name + '</p>');
                $("#hidden_id").val(data.id);

                if(data.unit == "" && data.unit == "" && data.brgy == "" && data.mun == "" && data.prov == "")
                {
                    $("#location").html('<p class="card-text" style="text-transform:uppercase">-</p>');
                }
                else
                {
                    $("#location").html('<p class="card-text" style="text-transform:uppercase">'+ data.unit + " " + data.brgy + " " + data.mun + " " + data.prov +'</p>');
                }
                
                if(data.email == "")
                {
                    $("#email").html('<input type="text" id="txtemail" class="form-control" name="email" value="-" disabled>');
                }
                else
                {
                    $("#email").html('<input type="text" id="txtemail" class="form-control" name="email" value="'+ data.email +'" >');
                }

                if(data.contact == "")
                {
                    $("#mobile").html('<input type="text" id="txtmobile" class="form-control" name="mobile" value="-" disabled>');
                }
                else
                {
                    $("#mobile").html('<input type="text" id="txtmobile" class="form-control" name="mobile" value="'+ data.contact +'" >');
                }
                
            }
        });

        //update settings
        $(document).on("click", "#btnUpdate", function(){
            id = $("#hidden_id").val();
            email = $("#txtemail").val();
            mobile = $("#txtmobile").val();

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

    });
</script>
@endsection