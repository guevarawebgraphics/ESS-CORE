@extends('layouts.master')

@section('crumb')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="m-0 text-dark">Manage Users</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
                <a href="#">Manage Users</a>
            </li>
            <li class="breadcrumb-item active">Create User</li>
        </ol>
    </div>
</div>
@endsection

@section('content')

@php
if(Session::get('manage_users') == 'all'){
    $add = '';
    $edit = '';
    $delete = '';
}
elseif(Session::get('manage_users') == 'view'){
    $add = 'disabled';
    $edit = 'disabled';
    $delete = 'disabled';
}
elseif(Session::get('manage_users') == 'add'){
    $add = '';
    $edit = 'disabled';
    $delete = 'disabled';
}
elseif(Session::get('manage_users') == 'edit'){
    $add = '';
    $edit = '';
    $delete = 'disabled';
}
elseif(Session::get('manage_users') == 'delete'){
    $add = '';
    $edit = 'disabled';
    $delete = '';
}else{
    $add = 'disabled';
    $edit = 'disabled';
    $delete = 'disabled';
}                   
@endphp
{{-- {{Session::get("employer_id")}} --}}
<div class="container-fluid">
    <div class="card card-info card-outline">
        <div class="card-header">
            <h3 class="card-title"><i class="fa fa-user-o"></i> Create User</h3>
        </div>
        
        <div class="card-body">
            <div class="pull-right">
                <button type="button" class="btn btn-primary" id="btnCreateUser" {{$add}}><i class="fa fa-plus-square"></i> Create User</button>
            </div>
            <br>
            <br>

            <div class="form-group row">
                <label for="address_zipcode" class="col-md-2 text-md-center">Search: </label>
                <div class="col-md-4">          
                    <input id="searchbox" type="text" class="form-control" name="searchbox" placeholder="Search"  autofocus>
                </div>
            </div>

            <div id="table_user">
                @include('admin_modules.table.tableuser')
            </div>
        </div>
    </div>
</div>

<!-- Modal for create user-->
<div class="modal fade bd-example-modal-lg" id="createUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="UserTitle">Create User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- <form id="formUserLevel">
                    @csrf
                    <input type="hidden" id="hidden_id" name="hidden_id">
                    <div id="modal_module"></div>
                </form> --}}
                <form method="POST" id="createuser_form">
                    @csrf

                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>
                        <input type="hidden" id="hidden_id">
                        <input type="hidden" id="action" value="add">
                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>
                            <p class="text-danger" id="error-no-name" hidden>* Field is Required</p>  
                            @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Username') }}</label>

                        <div class="col-md-6">
                            <input id="txtusername" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('email') }}" required>
                            <p class="text-danger" id="error-taken" hidden>* Username already taken</p>
                            <p class="text-danger" id="error-no-username" hidden>* Field is Required</p>  
                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="user_type" class="col-md-4 col-form-label text-md-right">User Type</label>
                        <div class="col-md-6">
                            <select id="cmbUser" class="form-control" name="cmbUser_type" >                                                                 
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                            <p class="text-danger" id="error-no-pass" hidden>* Field is Required | Password must be 6 characters</p>  
                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                        <div class="col-md-6">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            <p class="text-danger" id="error-no-repass" hidden>* Field is Required | Must be same as Password</p>  
                        </div>
                    </div>                      
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btnRegister">Create User</button>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function(){

          /*DataTable*/ 
          var table = $("#users_table").DataTable({
            // "searching": false,
            "sDom": '<"customcontent">rt<"row"<"col-lg-6" i><"col-lg-6" p>><"clear">',
            "paging": true,
            "ordering": false,
            "pageLength": 10000,
            scrollY: 300,
            //  scrollX: true,
            "autoWidth": true,
            lengthChange: false,
            responsive: true,
        });

        /*Custom Search For DataTable*/
        $("#searchbox").on("keyup search input paste cut", function () {
                table.search(this.value).draw();
        });

        //function Refresh User table
        function refreshUserTable()
        {
            $.ajax({
                headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "{{ route('refreshtable_user') }}",
                method: "GET",
                data:{},                 
                success:function(data)
                {
                    $('#table_user').html(data);  
                   /*DataTable*/ 
                    var table = $("#users_table").DataTable({
                        // "searching": false,
                        "sDom": '<"customcontent">rt<"row"<"col-lg-6" i><"col-lg-6" p>><"clear">',
                        "paging": true,
                        "pageLength": 10000,
                        "ordering": false,
                        scrollY: 300,
                        //  scrollX: true,
                        "autoWidth": true,
                        lengthChange: false,
                        responsive: true,
                    });                            
                }
            });
        }

        //Create new User
        $(document).on("click","#btnCreateUser", function(){

            $('#btnRegister').html("Create User");

            $('#createUserModal').modal();
            $("#UserTitle").html("Create User");

            $('#name').val("");
            $('#txtusername').val("");
            $('#password').val("");
            $('#password-confirm').val("");

            $('#name').removeClass("is-invalid");           
            $('#txtusername').removeClass("is-invalid");           
            $('#password').removeClass("is-invalid");           
            $('#password-confirm').removeClass("is-invalid");

            $('#error-no-name').attr("hidden", true);
            $('#error-no-username').attr("hidden", true);
            $('#error-no-pass').attr("hidden", true);
            $('#error-no-repass').attr("hidden", true);
            $('#error-taken').attr("hidden", true);     
            $('#txtusername').removeClass("is-invalid");
              
            $("#hidden_id").val("");  
            $("#action").val("add");   
        });

        //EDIT USER TYPE
        var info;
        var olduserName;
        $(document).on("click", "#edit_user", function(){
            var id = $(this).data("add");

            $('#name').val("");
            $('#txtusername').val("");
            $('#password').val("");
            $('#password-confirm').val("");

            $('#btnRegister').html("Update User");

            $('#name').removeClass("is-invalid");           
            $('#txtusername').removeClass("is-invalid");           
            $('#password').removeClass("is-invalid");           
            $('#password-confirm').removeClass("is-invalid");

            $('#error-no-name').attr("hidden", true);
            $('#error-no-username').attr("hidden", true);
            $('#error-no-pass').attr("hidden", true);
            $('#error-no-repass').attr("hidden", true);
            $('#error-taken').attr("hidden", true);     
            $('#txtusername').removeClass("is-invalid");

            info = id.split("]]");
            $('#createUserModal').modal();
            $("#UserTitle").html("Edit User");
            $("#hidden_id").val(info[0]);
            $("#action").val("edit");                    
            $("#name").val(info[1]);
            $("#txtusername").val(info[2]);
            $("#cmbUser").val(info[3]);
            olduserName = $('#txtusername').val();
            //alert(info[0]);
            
        });

        //REGISTER new user
        $(document).on("click", "#btnRegister", function(){

            name = $('#name').val();
            username = $('#txtusername').val();
            password = $('#password').val();
            repassword = $('#password-confirm').val();
            usertype = $('#cmbUser').val();
            
            if(name == "")
            {
                $('#name').addClass("is-invalid");
                $('#error-no-name').removeAttr("hidden");
            }
            else
            {
                $('#name').removeClass("is-invalid");
                $('#error-no-name').attr("hidden", true);
            }

            if(username == "")
            {
                $('#txtusername').addClass("is-invalid");
                $('#error-no-username').removeAttr("hidden");
            }
            else
            {
                $('#txtusername').removeClass("is-invalid");
                $('#error-no-username').attr("hidden", true);
            }

            if(password == "" || password < 6)
            {
                $('#password').addClass("is-invalid");
                $('#error-no-pass').removeAttr("hidden");
            }
            else
            {
                $('#password').removeClass("is-invalid");
                $('#error-no-pass').attr("hidden", true);
            }

            if(repassword == "" || password != repassword)
            {
                $('#password-confirm').addClass("is-invalid"); 
                $('#error-no-repass').removeAttr("hidden");
            }
            else
            {
                $('#password-confirm').removeClass("is-invalid");
                $('#error-no-repass').attr("hidden", true);
            }   
               
            if(name != "" && username != "" && password != "" && repassword != "" && password == repassword)
            {      
                var action = $("#action").val();
                //alert(action);   
                //ADD 
                if(action == "add")      
                {
                    $.ajax({
                        headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        url: "{{ route('register') }}",
                        method: "POST",
                        data:$("#createuser_form").serialize(),
                        dataType: "json",  
                        success:function(data)
                        {   
                            if(data == "taken")
                            {                          
                                $('#txtusername').addClass("is-invalid");
                                $('#error-taken').removeAttr("hidden");                           
                            }
                            if(data == "suc")
                            {
                                toastr.success('User Register Successfully', 'Success')
                                $('#createUserModal').modal('hide');
                                refreshUserTable();
                            }                              
                        }
                    });
                }
                //EDIT
                else if(action == "edit")
                {
                    $.ajax({
                        headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        url: "{{ route('checkusername') }}",
                        method: "GET",
                        data:{userName:username},          
                        success:function(data)
                        {                            
                            if(data == "taken")
                            {
                                if(olduserName == username)
                                {
                                    //alert("SAME");
                                    $.ajax({
                                        headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                        url: "{{ route('updateuser_post') }}",
                                        method: "POST",
                                        data:{id: info[0], name:name, userName:username, userType:usertype, password:password},            
                                        success:function(data)
                                        {                               
                                            toastr.success('User Updated Successfully', 'Success')
                                            $('#createUserModal').modal('hide');
                                            refreshUserTable();                                                                       
                                        }
                                    });
                                }
                                else
                                {
                                    //alert("taken");
                                    $('#txtusername').addClass("is-invalid");
                                    $('#error-taken').removeAttr("hidden"); 
                                }                                         
                            }
                            else if(data == "not")
                            {
                                //alert("AJAX");
                                $.ajax({
                                    headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                    url: "{{ route('updateuser_post') }}",
                                    method: "POST",
                                    data:{id: info[0], name:name, userName:username, userType:usertype, password:password},             
                                    success:function(data)
                                    {                          
                                        toastr.success('User Updated Successfully', 'Success')
                                        $('#createUserModal').modal('hide');
                                        refreshUserTable();                                                                   
                                    }
                                });
                            }
                        }
                    });                 
                }              
            }
            else{
                alert("Unexpected Error");
            }
                                                               
        });

        //AJAX ON GETTING THE USERTYPE
        $.ajax({
            headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: "{{ route('load_usertype') }}",
            method: "GET",
            data:{},                 
            success:function(data)
            {               
                $('#cmbUser').html(data);                   
            }
        });

        
        //DELETE USER TYPE
        $(document).on("click", "#delete_user", function(){
            var id = $(this).data("add");
            var data = id.split("]]");
            //alert(id);
            var c = confirm("Do you want to delete User " + "'" + data[1] + "'?");
            if(c == true)
            {
                $.ajax({
                    headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: "{{ route('deleteuser_post') }}",
                    method: "POST",
                    data:{userTypeID: data[0]},                 
                    success:function(data)
                    {
                        toastr.success('User Type Deleted!', 'Success') 
                        refreshUserTable();
                        $('#userTypeModal').modal('hide');           
                    }
                });
            }
            else
            {

            }
        });
    });
</script>
@endsection
