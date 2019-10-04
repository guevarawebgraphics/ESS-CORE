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
            <li class="breadcrumb-item active-createuser text-secondary">Create User</li>
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
    <div class="card card-custom-blue card-outline">
        <div class="card-header">
            <h3 class="card-title"><i class="fa fa-user-o"></i> Create User</h3>
        </div>

        <div class="card-body">
            <div class="form-group row">
                <div class="col-md-6">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="fa fa-search input-group-text" style="background-color: #fff;"></span>
                        </div>
                        <input id="searchbox" type="text" class="form-control" name="searchbox" placeholder="Search" autofocus>
                    </div>
                </div>
                <div class="col-md-6">
                    <button type="button" class="btn btn-outline-primary btn-flat float-md-right" id="btnCreateUser" {{$add}}><i class="icon ion-md-person-add"></i></i> Create User</button>
                </div>
            </div>

            <div id="table_user">
                @include('admin_modules.table.tableuser')
            </div>
        </div>
    </div>
</div>

<!-- Modal for create user-->
<div class="modal fade bd-example-modal-lg" id="createUserModal" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content card-custom-blue card-outline">
            <div class="modal-header">
                <h5 class="modal-title" id="UserTitle">Create User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="createuser_form">
                    @csrf

                    <div class="form-group row">
                        <label for="name" class="col-md-6 col-form-label text-md-left custom-flat-label">{{ __('Name') }}</label>
                        <input type="hidden" id="hidden_id">
                        <input type="hidden" id="action" value="add">
                        <div class="col-md-12">
                            <div class="input-group">
                                {{-- <div class="input-group-prepend">
                                    <span class="fa fa-user input-group-text"></span>
                                </div> --}}
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }} custom-flat-input-modal" placeholder="Name" name="name" value="{{ old('name') }}" required autofocus>
                            </div>
                            <p class="text-danger" id="error-no-name" hidden>* Field is Required</p>
                        </div>
                    </div>
                    @if(auth()->user()->user_type_id == 1)
                    <div class="form-group row">
                        
                        <div class="col-md-12">
                            <div class="input-group">
                                {{-- <div class="input-group-prepend">
                                    <span class="fa fa-user input-group-text"></span>
                                </div> --}}
                                <label for="user_type" class="col-md-6 col-form-label text-md-left custom-flat-label">Employer</label>
                                <input type="hidden" name = "hidden_account_id" id = "hidden_account_id" >
                                <select id="cmbEmployer" class="form-control employer-select " name="cmbEmployer" style="display:none !important;width:100%;"></select>
                            </div>
                            <p class="text-danger" id="error-no-employer" hidden>* Select an Employer</p>
                        </div>
                    </div>
                    @endif
                    <div class="form-group row">
                        

                        <div class="col-md-12">
                            <div class="input-group">
                                {{-- <div class="input-group-prepend">
                                    <span class="fa fa-user input-group-text"></span>
                                </div> --}}
                                <label for="email" class="col-md-6 col-form-label text-md-left custom-flat-label">{{ __('User ID / ESS ID') }}</label>
                                <input id="txtusername" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }} custom-flat-input-modal" name="username" value="{{ old('email') }}" required>
                            </div>
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
                        
                        <div class="col-md-12">
                            <div class="input-group">
                                {{-- <div class="input-group-prepend">
                                    <span class="fa fa-user input-group-text"></span>
                                </div> --}}
                                <label for="user_type" class="col-md-6 col-form-label text-md-left custom-flat-label">User Type</label>
                                <select id="cmbUser" class="form-control custom-flat-select" name="cmbUser_type"></select>
                            </div>
                        </div>
                    </div>

                    <div id="password_field">
                        <div class="form-group row">
                            

                            <div class="col-md-12">
                                <div class="input-group">
                                    {{-- <div class="input-group-prepend">
                                        <span class="fa fa-lock input-group-text"></span>
                                    </div> --}}
                                    <label for="password"
                                class="col-md-6 col-form-label text-md-left custom-flat-label">{{ __('Password') }}</label>
                                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }} custom-flat-input-modal" placeholder="Password" name="password" required>
                                </div>
                                <p class="text-danger" id="error-no-pass" hidden>* Field is Required | Password must be 9 characters</p>
                                @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            

                            <div class="col-md-12">
                                <div class="input-group">
                                    {{-- <div class="input-group-prepend">
                                        <span class="fa fa-lock input-group-text"></span>
                                    </div> --}}
                                    <label for="password-confirm"
                                class="col-md-6 col-form-label text-md-left custom-flat-label">{{ __('Confirm Password') }}</label>
                                    <input id="password-confirm" type="password" class="form-control custom-flat-input-modal" name="password_confirmation" placeholder="Confirm Password" required>
                                </div>
                                <p class="text-danger" id="error-no-repass" hidden>* Field is Required | Must be same as Password</p>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-info btn-flat" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline-primary btn-flat" id="btnRegister"></button>
            </div>
        </div>
    </div>
</div>
<!-- Modal for reset password-->
<div class="modal fade bd-example-modal-lg" id="resetPasswordModal" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content card-custom-blue card-outline">
            <div class="modal-header">
                <h5 class="modal-title" id="UserTitle">Reset Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST">
                    @csrf
                    <input type="hidden" id="hidden_id_password">

                    <div class="form-group row">
                        <label for="password" class="col-md-4 col-form-label text-md-left custom-flat-label">{{ __('User ID / ESS ID') }}</label>

                        <div class="col-md-6">
                            <input id="username" type="text" class="form-control custom-flat-input-modal-disabled" name="username" required disabled>
                        </div>
                    </div>

                    <div class="form-group row">
                        

                        <div class="col-md-12">
                            <div class="input-group">
                                {{-- <div class="input-group-prepend">
                                    <span class="fa fa-lock input-group-text"></span>
                                </div> --}}
                                <label for="password"
                            class="col-md-6 col-form-label text-md-left custom-flat-label">{{ __('New Password') }}</label>
                                <input id="newpassword" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }} custom-flat-input-modal" name="password" autofocus required>
                            </div>
                            <p class="text-danger" id="error-no-pass-reset" hidden>
                                <ul id="no-pass-reset" class="text-danger">
                                   
                                </ul>
                            </p>
                            @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        

                        <div class="col-md-12">
                            <div class="input-group">
                                {{-- <div class="input-group-prepend">
                                    <span class="fa fa-lock input-group-text"></span>
                                </div> --}}
                                <label for="password-confirm"
                            class="col-md-6 col-form-label text-md-left custom-flat-label">{{ __('Confirm New Password') }}</label>
                                <input id="newpassword-confirm" type="password" class="form-control custom-flat-input-modal" name="password_confirmation" required>
                            </div>
                            <p class="text-danger" id="error-no-repass-reset" hidden>
                                    <ul id="no-repass-reset" class="text-danger">
                                   
                                    </ul>
                            </p>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-info btn-flat" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline-primary btn-flat" id="btnReset"></button>
            </div>
        </div>
    </div>
</div>
<!-- Modal For Change Status -->
<div class="modal fade" id="csModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content card-custom-blue card-outline">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel" >Change Status</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="text" id="account_id" hidden>
          <select class="form-control col-md-12 custom-flat-select" name="AccountStatus" id="AccountStatus">
            <option value="" selected>Changed Status</option>
            <option value="1">Active</option>
            <option value="2">In-Active</option>
            <option value="3">Deactivated</option>
          </select>
          <p class="text-danger" id="error_cs" hidden>Please Choose Option</p>
          <label id="CS-id"></label>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-info btn-flat" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-outline-primary btn-flat" id="ChangeStatusConfirm">Confirm <i id="spinner" class=""><i></button>
        </div>
      </div>
    </div>
  </div>

<script>
    $(document).ready(function () {

        /*DataTable*/
        var table = $("#users_table").DataTable({
            // "searching": false,
            "sDom": '<"customcontent">rt<"row"<"col-lg-6" i><"col-lg-6" p>><"clear">',
            "paging": true,
            "ordering": false,
            "pageLength": 10,
            scrollY: 600,
            //  scrollX: true,
            "autoWidth": true,
            lengthChange: false,
            responsive: true,
        });

        /*Custom Search For DataTable*/
        $("#searchbox").on("keyup search input paste cut", function () {
            table.search(this.value).draw();
        });

        //ajax on loading the EMPLOYER
        $.ajax({
            headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: "{{ route('loademployer') }}",
            method: "GET",
            data:{},                 
            success:function(data)
            {
                $("#cmbEmployer").html(data);
            }
        });

        
        //AJAX ON LOADING THE ESS USER ID
        $('.employer-select').select2()
        $("#cmbEmployer").change(function(){

            val = $('#cmbEmployer').val();
            var selected = $(this).find('option:selected');
            var extra = selected.data('add'); 

            var data_split = extra.split("]]");

            console.log(data_split[1]);

            console.log(extra);
            
            $("#hidden_account_id").val(data_split[1]);
            // var name = val.split("]]");

            $.ajax({
                headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "/manageuser/generate",
                method: "GET",
                data:{employername: extra},                 
                success:function(data)
                {
                    //console.log(data);
                    $("#txtusername").val(data);
                }
            });

        });
        

        //AJAX ON GETTING THE USERTYPE
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ route('load_usertype') }}",
            method: "GET",
            data: {},
            success: function (data) {
                $('#cmbUser').html(data);
            }
        });

        //function Refresh User table
        function refreshUserTable() {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('refreshtable_user') }}",
                method: "GET",
                data: {},
                success: function (data) {
                    $('#table_user').html(data);
                    /*DataTable*/
                    var table = $("#users_table").DataTable({
                        // "searching": false,
                        "sDom": '<"customcontent">rt<"row"<"col-lg-6" i><"col-lg-6" p>><"clear">',
                        "paging": true,
                        "pageLength": 10,
                        "ordering": false,
                        scrollY: 600,
                        //  scrollX: true,
                        "autoWidth": true,
                        lengthChange: false,
                        responsive: true,
                    });
                }
            });
        }

        //Create new User
        $(document).on("click", "#btnCreateUser", function () {
            $('#btnRegister').html("Create User"+"<i id='spinner_user' class=''> </i>");
            $('#createUserModal').modal();
            $("#UserTitle").html("Create User");

            $('#name').val("");
            $('#txtusername').val("");
            $('#password').val("");
            $('#password-confirm').val("");
            $("#cmbEmployer").val('');

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
            $("#password_field").removeAttr("hidden");
            $("#cmbEmployer").removeAttr('disabled');
            $("#txtusername").removeAttr('disabled');

            $("#btnRegister").removeAttr("disabled");

            $('#cmbEmployer').removeClass("is-invalid");
            $('#error-no-employer').attr("hidden", true);
        });

        $('#createUserModal').on('hidden.bs.modal', function (e) {
            $('#txtusername').addClass('custom-flat-input');
            $('#txtusername').removeClass('custom-flat-input-disabled');
        });
        //EDIT USER TYPE
        var info;
        var olduserName;
        $(document).on("click", "#edit_user", function () {
            var id = $(this).data("add");
            $('#txtusername').removeClass('custom-flat-input');
            $('#txtusername').addClass('custom-flat-input-disabled');
            $('#name').val("");
            $('#txtusername').val("");
            $('#password').val("");
            $('#password-confirm').val("");

            $('#btnRegister').html("Update User"+"<i id='spinner_user' class=''> </i>");

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

            $('#cmbEmployer').removeClass("is-invalid");
            $('#error-no-employer').attr("hidden", true);

            info = id.split("]]");
            $('#createUserModal').modal();
            $("#UserTitle").html("Edit User");
            $("#hidden_id").val(info[0]);
            $("#action").val("edit");
            $("#name").val(info[1]);
            $("#txtusername").val(info[2]).attr('disabled', true);
            $("#cmbUser").val(info[3]);
            $("#cmbEmployer").select2().val(info[4]).attr('disabled', true);
            console.log(info[4]);
            olduserName = $('#txtusername').val();
            //alert(info[0]);
            $("#password_field").attr("hidden", true);
            $("#new_or_exist_field").attr("hidden", true);

            $("#btnRegister").removeAttr("disabled"); 

            /*  $.get('/manageuser/show/'+info[4], function(response){
                $('#cmbEmployer').val(`hi ${response[0]} `) 
            }, 'json');*/
        });

        //REGISTER new user
        $(document).on("click", "#btnRegister", function () {
            $('#btnRegister').attr('disabled',true);
            $('#spinner_user').addClass('fa fa-refresh fa-spin'); 
            toastr.remove(); 
            name = $('#name').val();
            username = $('#txtusername').val();
            password = $('#password').val();
            repassword = $('#password-confirm').val();
            usertype = $('#cmbUser').val();
            employer = $("#cmbEmployer").val();

            var action = $("#action").val();
            //ADD 
            if (action == "add") {
                if (name == "") {
                    $('#name').addClass("is-invalid");
                    $('#error-no-name').removeAttr("hidden");
                    spinnerTimoutCreateUser() 
                    $('#btnRegister').removeAttr('disabled');
                } else {
                    $('#name').removeClass("is-invalid");
                    $('#error-no-name').attr("hidden", true);
                }

                if (username == "") {
                    $('#txtusername').addClass("is-invalid");
                    $('#error-no-username').removeAttr("hidden");
                    spinnerTimoutCreateUser()
                    $('#btnRegister').removeAttr('disabled');
                } else {
                    $('#txtusername').removeClass("is-invalid");
                    $('#error-no-username').attr("hidden", true);
                }

                if (password == "" || password.length < 9) {
                    $('#password').addClass("is-invalid");
                    $('#error-no-pass').removeAttr("hidden");
                    spinnerTimoutCreateUser()
                    $('#btnRegister').removeAttr('disabled');
                } else {
                    $('#password').removeClass("is-invalid");
                    $('#error-no-pass').attr("hidden", true);
                }

                if (repassword == "" || password != repassword) {
                    $('#password-confirm').addClass("is-invalid");
                    $('#error-no-repass').removeAttr("hidden");
                    spinnerTimoutCreateUser()
                    $('#btnRegister').removeAttr('disabled');
                } else {
                    $('#password-confirm').removeClass("is-invalid");
                    $('#error-no-repass').attr("hidden", true);
                }

                if (employer == "") {
                    $('#cmbEmployer').addClass("is-invalid");
                    $('#error-no-employer').removeAttr("hidden");
                    spinnerTimoutCreateUser()
                    $('#btnRegister').removeAttr('disabled');
                } else {
                    $('#cmbEmployer').removeClass("is-invalid");
                    $('#error-no-employer').attr("hidden", true);
                }

                if (name != "" && username != "" && password != "" && repassword != "" && password ==
                    repassword && password.length >= 9 && employer != "") {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "{{ route('register') }}",
                        method: "POST",
                        data: $("#createuser_form").serialize(),
                        dataType: "json",
                        success: function (data) {
                            if (data == "taken") {
                                $('#txtusername').addClass("is-invalid");
                                $('#error-taken').removeAttr("hidden");
                                spinnerTimoutCreateUser()
                                refreshUserTable();
                                setTimeout(function (){
                                  $("#createUserModal").modal('hide');
                                }, 1000);
                                $('#btnRegister').attr('disabled',true);
                            }
                            if (data == "suc") {
                                toastr.success('User Register Successfully', 'Success')
                                $('#createUserModal').modal('hide');
                                refreshUserTable();
                                spinnerTimoutCreateUser()
                                setTimeout(function (){
                                  $("#createUserModal").modal('hide');
                                }, 1000);
                                $('#btnRegister').attr('disabled',true);
                            }
                        }
                    });
                }
            }
            //EDIT
            else if (action == "edit") {
                toastr.remove() 
                $('#btnRegister').attr('disabled',true);
                
                if (name == "") {
                    $('#name').addClass("is-invalid");
                    $('#error-no-name').removeAttr("hidden");
                    spinnerTimoutCreateUser()
                    $("#btnRegister").removeAttr("disabled");
                } else {
                    $('#name').removeClass("is-invalid");
                    $('#error-no-name').attr("hidden", true);
                }

                if (username == "") {
                    $('#txtusername').addClass("is-invalid");
                    $('#error-no-username').removeAttr("hidden");
                    spinnerTimoutCreateUser()
                    $("#btnRegister").removeAttr("disabled");
                } else {
                    $('#txtusername').removeClass("is-invalid");
                    $('#error-no-username').attr("hidden", true);
                    $("#btnRegister").removeAttr("disabled");
                }

                if (name != "" && username != "") {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "{{ route('checkusername') }}",
                        method: "GET",
                        data: {
                            userName: username
                        },
                        success: function (data) {
                            if (data == "taken") {
                                if (olduserName == username) {
                                    //alert("SAME");
                                    $.ajax({
                                        headers: {
                                            'X-CSRF-TOKEN': $(
                                                'meta[name="csrf-token"]').attr(
                                                'content')
                                        },
                                        url: "{{ route('updateuser_post') }}",
                                        method: "POST",
                                        data: {
                                            id: info[0],
                                            name: name,
                                            userName: username,
                                            userType: usertype
                                        },
                                        success: function (data) {
                                            toastr.success(
                                                'User Updated Successfully',
                                                'Success')
                                                setTimeout(function (){
                                                $("#createUserModal").modal('hide');
                                                }, 1000);
                                                refreshUserTable();
                                                $('#btnRegister').attr('disabled',true);
                                        }
                                    });
                                } else {
                                    //alert("taken");
                                    $('#txtusername').addClass("is-invalid");
                                    $('#error-taken').removeAttr("hidden");
                                }
                            } else if (data == "not") {
                                //alert("AJAX");
                                $.ajax({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                                            .attr('content')
                                    },
                                    url: "{{ route('updateuser_post') }}",
                                    method: "POST",
                                    data: {
                                        id: info[0],
                                        name: name,
                                        userName: username,
                                        userType: usertype,
                                        password: password
                                    },
                                    success: function (data) {
                                        toastr.success(
                                            'User Updated Successfully',
                                            'Success')
                                            setTimeout(function (){
                                            $("#createUserModal").modal('hide');
                                            }, 1000);
                                            refreshUserTable();
                                            $('#btnRegister').attr('disabled',true);
                                    }
                                });
                            }
                        }
                    });
                }
            }
        });
        function spinnerTimoutCreateUser(){
        setTimeout(function (){
                    $('#spinner_user').removeClass('fa fa-refresh fa-spin');
        }, 1000);
        } 

        //DELETE USER TYPE
        $(document).on("click", "#delete_user", function () {
            var id = $(this).data("add");
            var data = id.split("]]");
            swal({
                    title: "Delete this user '" + data[1] + "' ?",
                    type: "error",
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes",
                    showCancelButton: true,
                    closeOnConfirm: true,
                },
                function () {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "{{ route('deleteuser_post') }}",
                        method: "POST",
                        data: {
                            userTypeID: data[0],
                            userName: data[1]
                        },
                        success: function (data) {
                            toastr.success('User Deleted!', 'Success')
                            refreshUserTable();
                            $('#userTypeModal').modal('hide');
                        }
                    });
                }
            );
        });

        $(document).on('click', '#change_status', function(){
            $('#csModal').modal('show');
            var id = $(this).attr("data-id");
            $('#account_id').val(id);
            toastr.remove()
            // console.log(id);
        });
         //Change Status
         $(document).on('click', '#ChangeStatusConfirm', function (){
          $("#spinner").addClass('fa fa-refresh fa-spin');
     
          let Account_id = $('#account_id').val();
          let AccountStatus = $('#AccountStatus').val();
          toastr.remove()
          $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
          });
            if (AccountStatus == ""){
              $('#AccountStatus').addClass('is-invalid');
              $('#error_cs').removeAttr('hidden');
              toastr.error('Error. Please Choose a Option', 'Error!')
                setTimeout(function (){
                        $("#spinner").removeClass('fa fa-refresh fa-spin');
                  }, 250);
            }
            else {
              $.ajax({
                    url: "/manageuser/UpdateAccountStatus/" + Account_id,
                    method: 'PATCH',
                    async: false,
                    dataType: 'json',
                    data: {
                      AccountStatus: $('#AccountStatus').val(),
                      _token:     '{{ csrf_token() }}'
                    },
                    success: function (data, response){
                      refreshUserTable();
                      //Set the dropdown to the default selected
                      $('#AccountStatus option[value=""]').prop('selected', true);
                      // Display a success toast, with a title
                      toastr.success('Account Updated Successfully', 'Success')
                      setTimeout(function (){
                            $("#spinner").removeClass('fa fa-refresh fa-spin');
                        }, 250);
                        // Hide Modal
                        setTimeout(function (){
                          $('#csModal').modal('hide');
                        }, 550);
                    },
                    error: function (data, e){
                      console.clear();
                      if(data.status == 500){
                        toastr.error('Error. Please Choose a Option', 'Error!')
                        setTimeout(function (){
                                $("#spinner").removeClass('fa fa-refresh fa-spin');
                          }, 250);
                      }
                    }
                });
            }
        });

        //OPEN MODAL RESET PASSWORD
        $(document).on("click", "#reset_password", function () {
            $("#resetPasswordModal").modal();           
            $("#newpassword").val("");
            $("#newpassword-confirm").val("");
            reset_data = $(this).data("add");
            reset_info = reset_data.split("]]");
            console.log(reset_info[0]);
            $("#hidden_id_password").val(reset_info[0]);
            $("#username").val(reset_info[1]);
            $('#btnReset').html("Reset Password "+"<i id='spinner_user' class=''> </i>");
            $("#btnReset").removeAttr('disabled');
        });
                //
         $(document).on("click", ".cancel", function () {
            $("#btnReset").removeAttr('disabled');
        });
        
        //RESET PASSWORD POST
        $(document).on("click", "#btnReset", function () {
            $('#no-pass-reset').html("");
            $('#no-repass-reset').html("");
            hidden_id = $("#hidden_id_password").val();
            password = $('#newpassword').val();
            con_newpassword = $('#newpassword-confirm').val(); 
            $('#spinner_user').addClass('fa fa-refresh fa-spin'); 
            $("#btnReset").attr("disabled",true);
            if (password == "") {
                $('#newpassword').addClass("is-invalid");
                $('#error-no-pass-reset').removeAttr("hidden");  
                
                $('#no-pass-reset').append(" <li> Password is required </li>");
                spinnerTimoutCreateUser()
                $("#btnReset").removeAttr('disabled');
            } else {
                $('#newpassword').removeClass("is-invalid");
                $('#error-no-pass-reset').attr("hidden", true);
                spinnerTimoutCreateUser()
            }
            if (password.length < 9) {
                $('#newpassword').addClass("is-invalid");
                $('#error-no-pass-reset').removeAttr("hidden"); 
                $('#no-pass-reset').append("<li> Password must be atleast 9 characters  </li>");
                spinnerTimoutCreateUser()
                $("#btnReset").removeAttr('disabled');
            } else {
                $('#newpassword').removeClass("is-invalid");
                $('#error-no-pass-reset').attr("hidden", true);
                spinnerTimoutCreateUser()
            } 
            if (con_newpassword == "") {
                $('#newpassword-confirm').addClass("is-invalid");
                $('#error-no-repass-reset').removeAttr("hidden");  
                
                $('#no-repass-reset').append(" <li> Password is required </li>");
                spinnerTimoutCreateUser()
                $("#btnReset").removeAttr('disabled');
            } else {
                $('#newpassword-confirm').removeClass("is-invalid");
                $('#error-no-repass-reset').attr("hidden", true);
                spinnerTimoutCreateUser()
            }
            if (con_newpassword.length < 9) {
                $('#newpassword-confirm').addClass("is-invalid");
                $('#error-no-repass-reset').removeAttr("hidden"); 
                $('#no-repass-reset').append("<li> Password must be atleast 9 characters  </li>");
                spinnerTimoutCreateUser()
                $("#btnReset").removeAttr('disabled');
            } else {
                $('#newpassword-confirm').removeClass("is-invalid");
                $('#error-no-repass-reset').attr("hidden", true);
                spinnerTimoutCreateUser()
            }

            if (password != con_newpassword) {
                $('#newpassword').addClass("is-invalid");
                $('#newpassword-confirm').addClass("is-invalid");
                $('#error-no-repass-reset').removeAttr("hidden"); 
                $('#no-repass-reset').append("<li> Password must be match </li>");
                spinnerTimoutCreateUser()
                $("#btnReset").removeAttr('disabled');
            } else {
                $('#newpassword-confirm').removeClass("is-invalid");
                $('#no-repass-resett').attr("hidden", true);
            }
            if (password != "" && con_newpassword != "" && password.length >= 9 && password == con_newpassword){
                    swal({
                        title: "Reset Password?",
                        type: "warning",
                        confirmButtonClass: "btn-info",
                        confirmButtonText: "Yes",
                        showCancelButton: true,
                        closeOnConfirm: true,
                    },
                    function () {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: "{{ route('resetpassword') }}",
                            method: "POST",
                            data: {
                                id: reset_info[0],
                                password: password
                            },
                            success: function (data) {
                                toastr.success('Password Reset Successfully!', 'Success')                       
                                $('#resetPasswordModal').modal('hide');
                                
                                spinnerTimoutCreateUser()
                            }
                        });
                                } 
                          
                );
               
            }
        });

    });
</script>
@endsection
