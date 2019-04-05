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
            <li class="breadcrumb-item active">Manage User Access</li>
        </ol>
    </div>
</div>
@endsection

@section('content')

<div class="container">
    <div class="pull-right">
        <button type="button" class="btn btn-primary" id="btnCreateUser">Create User Type</button>
    </div>
    <br>
    <br>
    <div id="table_usertype">
        @include('admin_modules.table.tableusertype')
    </div>
</div>

<!-- Modal for manage user access-->
<div class="modal fade bd-example-modal-lg" id="userAccessModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
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
                    <div id="modal_module"></div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btnSave">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Create/Edit User type -->
<div class="modal fade" id="userTypeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create User Type</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <form id="usertype_form">
                        @csrf
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">User Type Name</label>
                            <div id="typename"  class="col-md-6">
                                <input id="name" type="text" class="form-control" name="type_name" value="">                                  
                                <p class="text-danger" id="error-no-type" hidden>* Field is Required</p>             
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">Type Description</label>
                            <div class="col-md-6">
                                <textarea rows="3" id="desc" class="form-control" name="type_desc" value=""></textarea>               
                            </div>
                        </div>                                            
                    </form>                   
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btnSaveUserType">Save User Type</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){

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
                }
            });
        }     

        //Manage User Access Modal
        $(document).on("click", "#manage", function(){
            $('#userAccessModal').modal('show');
            userid = $(this).data("add");
            //alert(userid);
            $.ajax({
                headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "{{ route('showmodule') }}",
                method: "GET",
                data:{id: userid},                 
                success:function(data)
                {
                    $('#modal_module').html(data);
                    $('#hidden_id').val(userid);                  
                }
            });
        });
        
        //Update Access Modal
        $(document).on("click", "#btnSave", function(){            
            userid = $(this).data("add");
            $.ajax({
                headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "{{ route('updatemoduleaccess') }}",
                method: "POST",
                data:$('#formUserLevel').serialize(),                 
                success:function(data)
                {
                    alert("Successfully Updated");          
                }
            });
        });

        //Create user type
        $(document).on("click", "#btnCreateUser", function(){
            
            $('#name').val("");
            $('#desc').val("");
            $('#name').removeClass("is-invalid");
            $('#error-no-type').attr("hidden", true);
            $('#userTypeModal').modal();            
        });

         //Saving of new user type
        $(document).on("click", "#btnSaveUserType", function(){

            $type_name = $('#name').val();
            $type_desc = $('#desc').val();

            if($type_name == "")
            {
                $('#name').addClass("is-invalid");
                $('#error-no-type').removeAttr("hidden");
            }
            else
            {
                $.ajax({
                    headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: "{{ route('usertype_post') }}",
                    method: "POST",
                    data:$('#usertype_form').serialize(),                 
                    success:function(data)
                    {
                        alert("User Type Added!"); 
                        refreshUsertypeTable();
                        $('#userTypeModal').modal('hide');           
                    }
                });
            }           
        });
    });
</script>
@endsection