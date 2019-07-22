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
            <li class="breadcrumb-item active">Change Password</li>
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
    <div class="card card-info card-outline">
        <div class="card-header">
            <center><strong>Change Password</strong></center>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <label for="txtcurpass" class="col-form-label col-md-2">Current Password</label>
                <div class="col-md-6">
                    <input type="password" id="txtcurpass" class="form-control" name="curpass">
                    <p class="text-danger" id="error-no-cur" hidden>* Field is Required</p>            
                </div>
            </div>   
            <div class="form-group row">
                <label for="txtnewpass" class="col-form-label col-md-2">New Password</label>
                <div class="col-md-6">
                    <input type="password" id="txtnewpass" class="form-control" name="newpass">
                    <p class="text-danger" id="error-no-new" hidden></p>
                    {{-- <p class="text-danger" id="error-length" hidden>* Maximum of 6 characters</p> --}}
                </div>
            </div>  
            <div class="form-group row">
                <label for="txtconpass" class="col-form-label col-md-2">Confirm Password</label>
                <div class="col-md-6">
                    <input type="password" id="txtconpass" class="form-control" name="conpass">
                    <p class="text-danger" id="error-no-newcon" hidden></p> 
                    {{-- <p class="text-danger" id="error-notmatch" hidden>* Confirm Password not match</p> --}}
                </div>
            </div>
            <button type="button" class="btn btn-outline-primary btn-flat" id="btnUpdate" {{$edit}}>Update Password</button>                                                                      
        </div>              
    </div>      
</div>
<script>
    $(document).ready(function(){

        var curPass_valid = '';
        //check the current password
        $("#txtcurpass").focusout(function (){
            curPass = $('#txtcurpass').val();
            $.ajax({
                headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "{{ route('changepassword_prev') }}",
                method: "GET",
                data:{oldPass: curPass},               
                success:function(data)
                {                   
                    if(data == "1")
                    {
                       curPass_valid = "1";
                    }
                    if(data == "0")
                    {
                        curPass_valid = "0";
                    }
                    
                }
            });
        });

        //update settings
        var counter = 0;
        $(document).on("click", "#btnUpdate", function(){
            toastr.remove()
            toastr.clear()
            counter = 0;
            if(curPass_valid == "1")
            {
                newPass = $('#txtnewpass').val();
                conNewPass = $('#txtconpass').val();
                curPass = $('#txtcurpass').val();
                
                //current password
                if(curPass == "" )
                {
                    $('#txtcurpass').addClass("is-invalid");
                    $('#error-no-cur').removeAttr("hidden");
                    counter++;
                }
                else
                {
                    $('#txtcurpass').removeClass("is-invalid");
                    $('#error-no-cur').attr("hidden", true);
                }
                //new password
                if(newPass == "" )
                {
                    $('#txtnewpass').addClass("is-invalid");
                    $('#error-no-new').removeAttr("hidden").html("* Field is Required");
                    counter++;
                }   
                else if(newPass.length < 6)
                {
                    $('#txtnewpass').addClass("is-invalid");
                    $('#error-no-new').removeAttr("hidden").html("* Maximum of 6 characters");
                    counter++;
                }
                else 
                {
                    $('#txtnewpass').removeClass("is-invalid");
                    $('#error-no-new').attr("hidden", true);                  
                }
                //confirm password
                if(conNewPass == "")
                {
                    $('#txtconpass').addClass("is-invalid");
                    $('#error-no-newcon').removeAttr("hidden").html("* Field is Required");
                    counter++;                   
                }
                else if(conNewPass != newPass)
                {
                    $('#txtconpass').addClass("is-invalid");
                    $('#error-no-newcon').removeAttr("hidden").html("* Confirm password not match");
                    counter++;
                }
                else
                {
                    $('#txtconpass').removeClass("is-invalid");
                    $('#error-no-newcon').attr("hidden", true);                   
                }

                if(counter == 0)
                {
                    swal({
                        title: "Update Password?",
                        //text: "Your will not be able to recover this imaginary file!",
                        type: "info",
                        showCancelButton: true,
                        confirmButtonClass: "btn-info",
                        confirmButtonText: "Yes",
                        closeOnConfirm: true
                    },
                    function(){
                        //swal("Deleted!", "Your imaginary file has been deleted.", "success");
                        $.ajax({
                            headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            url: "{{ route('changepassword_post') }}",
                            method: "POST",
                            data:{newPass: newPass},               
                            success:function(data)
                            {                               
                                toastr.success('Password Changed Successfully', 'Success')
                                //alert("Changed");      
                                curPass_valid = '';
                                $('#txtnewpass').val("");
                                $('#txtcurpass').val("");  
                                $('#txtconpass').val("");   
                                $('#txtcurpass').removeClass("is-invalid");
                                $('#error-no-cur').attr("hidden", true);   
                                $('#txtnewpass').removeClass("is-invalid");
                                $('#error-no-new').attr("hidden", true);   
                                $('#txtconpass').removeClass("is-invalid");
                                $('#error-no-newcon').attr("hidden", true);                  
                            }                      
                        });        
                    });
                    
                    // var c = confirm("Update Password?");

                    // if(c == true)
                    // {                    
                    //     $.ajax({
                    //         headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    //         url: "{{ route('changepassword_post') }}",
                    //         method: "POST",
                    //         data:{newPass: newPass},               
                    //         success:function(data)
                    //         {
                    //             toastr.success('Password Changed Successfully', 'Success')
                    //             //alert("Changed");      
                    //             curPass_valid = '';
                    //             $('#txtnewpass').val("");
                    //             $('#txtcurpass').val("");  
                    //             $('#txtconpass').val("");   
                    //             $('#txtcurpass').removeClass("is-invalid");
                    //             $('#error-no-cur').attr("hidden", true);   
                    //             $('#txtnewpass').removeClass("is-invalid");
                    //             $('#error-no-new').attr("hidden", true);   
                    //             $('#txtconpass').removeClass("is-invalid");
                    //             $('#error-no-newcon').attr("hidden", true);                  
                    //         }                      
                    //     });                       
                    // }
                    // else
                    // {

                    // }                  
                }
            }
            else
            {
                toastr.error('Change Password Failed', 'Failed')
                curPass_valid = '';
            }                              
        });

    });
</script>
@endsection