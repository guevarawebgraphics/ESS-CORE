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
            <li class="breadcrumb-item active-manageuser text-secondary">Manage User Access</li>
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

<div class="container-fluid">
    <div class="card card-custom-blue card-outline">
        <div class="card-header">
            <h3 class="card-title"><i class="fa fa-gears"></i> Manage User Access</h3>
        </div>
        
        <div class="card-body">
            <div class="form-group row">
                <div class="col-md-6">    
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="fa fa-search input-group-text" style="background-color: #fff;"></span>
                        </div>
                        <input id="searchbox" type="text" class="form-control" name="searchbox" placeholder="Search"  autofocus>
                    </div>
                </div>
                {{-- <label for="address_zipcode" class="col-md-2 text-md-center">Search: </label> --}}
                <div class="col-md-6">
                    <button type="button" class="btn btn-outline-primary btn-flat float-md-right" id="btnCreateUser" {{$add}}><i class="fa fa-plus-square"></i> Create User Type</button>
                </div>
            </div>

            <div id="table_usertype">
                @include('admin_modules.table.tableusertype')
            </div>
        </div>
    </div>
</div>

<!-- Modal for manage user access-->
<div class="modal fade bd-example-modal-lg" id="userAccessModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content card-custom-blue card-outline">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Manage User Access</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formUserLevel">
                    @csrf
                    <input type="hidden" id="hidden_id" name="hidden_id">
                    <input type="hidden" id="hidden_typename" name="hidden_typename">
                    <div id="modal_module"></div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-info btn-flat" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline-primary btn-flat" id="btnSave">Save changes<i id="spinner_manage" class=""> </i></button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Create/Edit User type -->
<div class="modal fade" id="userTypeModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content card-custom-blue card-outline">
            <div class="modal-header">
                <h5 class="modal-title" id="userTypeTitle">Create User Type</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <form id="usertype_form">
                        @csrf

                        <div class="form-group row" id="user_type_for_field">
                            <label for="user_type" class="col-md-4 col-form-label text-md-right">User Type for</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="fa fa-user input-group-text"></span>
                                    </div>
                                    <select id="userTypeFor" class="form-control" name="cmb_userTypeFor">  
                                            <option selected disabled>Choose User Type</option>                                  
                                            <option value="2">Lender</option>
                                            <option value="4">Employer</option>   
                                            <option value="6">Biller</option>                                                        
                                    </select>
                                </div>
                            </div>                   
                        </div>

                        @if(auth()->user()->user_type_id == 1)
                        <div class="form-group row" id="employer_field" hidden>
                            <label for="user_type" class="col-md-4 col-form-label text-md-right user_type"></label>
                            <div class="col-md-6">
                                <select id="employer" class="form-control usertype-for-search" name="cmb_Employe"  style="width: 100%;">                                                                 
                            </select>
                            </div>                   
                        </div>
                        @endif

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">User Type Name</label>
                            <div id="typename"  class="col-md-6">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="fa fa-user input-group-text"></span>
                                    </div>
                                    <input type="hidden" id="hidden_id_usertype">
                                    <input type="hidden" id="action" value="add">
                                    <input id="name" type="text" class="form-control" name="type_name" value="">      
                                </div>             
                                <p class="text-danger" id="error-no-type" hidden>* Field is Required</p>             
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">Type Description</label>
                            <div class="col-md-6">
                                <textarea rows="3" id="desc" class="form-control" name="type_desc" value=""></textarea>     
                                <p class="text-danger" id="error-no-desc" hidden>* Field is Required</p>                
                            </div>
                           
                        </div>                                            
                    </form>                   
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-info btn-flat" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline-primary btn-flat" id="btnSaveUserType">Save User Type <i id="spinner_user_type" class=""> </i></button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('.usertype-for-search').select2()
        /*DataTable*/ 
        var table = $("#usertype_table").DataTable({
            "sDom": '<"customcontent">rt<"row"<"col-lg-6" i><"col-lg-6" p>><"clear">',
            "paging": true,
            "pageLength": 10,
            "ordering": false,
            scrollY: 600,
            "autoWidth": true,
            lengthChange: false,
            responsive: true,
        });

        /*Custom Search For DataTable*/
        $("#searchbox").on("keyup search input paste cut", function () {
                table.search(this.value).draw();
        });
   
        //function for refreshing user type table
        function refreshUsertypeTable()
        {           
            $.ajax({
                headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "{{ route('refreshtable_usertype') }}",
                method: "GET",
                data:{},                 
                success:function(data)
                {
                    $('#table_usertype').html(data);       
                    /*DataTable*/ 
                    var table = $("#usertype_table").DataTable({
                        // "searching": false,
                        "sDom": '<"customcontent">rt<"row"<"col-lg-6" i><"col-lg-6" p>><"clear">',
                        "paging": true,
                        "pageLength": 10,
                        "ordering": false,
                        scrollY: 600,
                        "autoWidth": true,
                        lengthChange: false,
                        responsive: true,
                    });                          
                }
            });
        }     

        //Manage User Access Modal
        $(document).on("click", "#manage", function(){
            $('#userAccessModal').modal('show');
            $('#btnSave').removeAttr("disabled");
            manage_info = $(this).data("add");
            manage_data = manage_info.split("||");
            console.log(manage_data[0] + " " + manage_data[1]);
            $.ajax({
                headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "{{ route('showmodule') }}",
                method: "GET",
                data:{id: manage_data[0]},                 
                success:function(data)
                {
                    $('#modal_module').html(data);
                    $('#hidden_id').val(manage_data[0]); 
                    $('#hidden_typename').val(manage_data[1]);                  
                }
            });
        });
        
        //Update Access Modal
        $(document).on("click", "#btnSave", function(){            
            userid = $(this).data("add");
            $('#btnSave').attr("disabled",true);
            $('#spinner_manage').addClass('fa fa-refresh fa-spin');
            $.ajax({
                headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "{{ route('updatemoduleaccess') }}",
                method: "POST",
                data:$('#formUserLevel').serialize(),                 
                success:function(data)
                {
                    toastr.success('Access Updated Successfully', 'Success') 
                    spinnerTimout();
                    setTimeout(function (){
                        $('#userAccessModal').modal('hide');   
                    }, 1000);
                }
            });
        });
        function spinnerTimout(){
            setTimeout(function (){
                        $("#spinner_manage").removeClass('fa fa-refresh fa-spin');
            }, 1000);
            } 
        //Create user type
        $(document).on("click", "#btnCreateUser", function(){
            
            $('#name').val("");
            $('#desc').val("");
            $('#name').removeClass("is-invalid");
            $('#error-no-type').attr("hidden", true);
            $('#action').val("add");
            $('#userTypeTitle').html("Create User Type");
            $('#hidden_id_usertype').val("");
            $('#userTypeModal').modal();
            $("#user_type_for_field").removeAttr("hidden");   
            $('#desc').removeClass("is-invalid");      
            $("#error-no-desc").attr("hidden", true);
            $("#spinner_user_type").removeClass('fa fa-refresh fa-spin');
        });

        //EDIT USER TYPE
        var info;
        $(document).on("click", "#edit_usertype", function(){
            var id = $(this).data("add");
            info = id.split("]]");
            //alert(info);
            $('#userTypeModal').modal();
            $('#userTypeTitle').html("Edit User Type");
            $('#action').val("edit");
            $('#name').val(info[1]);
            $('#desc').val(info[2]);
            $('#hidden_id_usertype').val(info[0]);
            $("#user_type_for_field").attr("hidden", true);
            $('#btnSaveUserType').removeAttr("disabled");
            
            $("#spinner_user_type").removeClass('fa fa-refresh fa-spin');

            $('#error-no-desc').attr("hidden",true); 
            $('#error-no-type').attr("hidden",true); 

            $('#name').removeClass("is-invalid");
            $('#desc').removeClass("is-invalid");

        });

         //Saving of new user type
        $(document).on("click", "#btnSaveUserType", function(){

            type_name = $('#name').val();
            type_desc = $('#desc').val();
            $('#btnSaveUserType').attr("disabled",true);
            $('#spinner_user_type').addClass('fa fa-refresh fa-spin');
            toastr.remove() 
            if(type_name == "")
            {
                $('#name').addClass("is-invalid");
                $('#error-no-type').removeAttr("hidden"); 
                $('#btnSaveUserType').removeAttr("disabled");
                spinnerTimoutUserType()
            }
            if(type_desc=="")
            {
                $('#desc').addClass("is-invalid");
                $('#error-no-desc').removeAttr("hidden"); 
                
                $('#btnSaveUserType').removeAttr("disabled");
                spinnerTimoutUserType()
            }
            else
            {
                var action = $('#action').val();              
                if(action == "add")
                {
                    $.ajax({
                        headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        url: "{{ route('usertype_post') }}",
                        method: "POST",
                        data:$('#usertype_form').serialize(),                 
                        success:function(data)
                        {
                            toastr.success('User Type Added!', 'Success')
                            refreshUsertypeTable();
                            setTimeout(function (){
                                $('#userTypeModal').modal('hide'); 
                            }, 1000);    
                            spinnerTimoutUserType()
                            $('#btnSaveUserType').removeAttr("disabled");

                        }
                    });
                }
                else if(action = "edit"){
                    $.ajax({
                        headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        url: "{{ route('updateusertype_post') }}",
                        method: "POST",
                        data:{typeName: type_name, typeDesc: type_desc, userTypeID: info[0]},                 
                        success:function(data)
                        {
                            toastr.success('User Type Updated!', 'Success')
                            refreshUsertypeTable();
               
                            setTimeout(function (){
                                $('#userTypeModal').modal('hide'); 
                            }, 1000);      
                            $('#btnSaveUserType').removeAttr("disabled");
     
                        }
                    });
                }               
            }           
        });
        function spinnerTimoutUserType(){
            setTimeout(function (){
                        $("#spinner_user_type").removeClass('fa fa-refresh fa-spin');
            }, 1000);
        } 

        
        //DELETE USER TYPE
        $(document).on("click", "#delete_usertype", function(){
            var id = $(this).data("add");
            var data_info = id.split("]]");
            toastr.remove() 
            //alert(id);
            swal({
                title: "Do you want to delete User Type " + "'" + data_info[1] + "'?",
                //text: "Your will not be able to recover this imaginary file!",
                type: "error",             
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes",
                showCancelButton: true,
                closeOnConfirm: true,
                },
                function()
                {                   
                    $.ajax({
                        headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        url: "{{ route('deleteusertype_post') }}",
                        method: "POST",
                        data:{userTypeID: data_info[0], userTypeName: data_info[1]},                 
                        success:function(data)
                        {
                            toastr.success('User Type Deleted!', 'Success') 
                            refreshUsertypeTable();
                            $('#userTypeModal').modal('hide');           
                        }
                    });
                }
            );       
        });

        //FOR EMPLOYER SELECTION 

        $("#userTypeFor").change(function (){
                $('#select2-employer-container').html("");
                val = $('#userTypeFor').val();
                if(val ==4)
                {
                    $('.user_type').html("Employer");
                }
                else if( val == 6)
                {
                    $('.user_type').html("Biller");
                }
                else 
                {
                    $('.user_type').html("Lender");
                }
                $('#employer_field').removeAttr("hidden");
                $.ajax({
                    headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: "{{ route('loadusertypeinput') }}",
                    method: "GET",
                    data:{
                        value : val
                    },                 
                    success:function(data)
                    {
                        $("#employer").html(data);
                    }
                });
        
        });

        
    });
</script>
@endsection