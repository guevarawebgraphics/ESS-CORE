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
            <li class="breadcrumb-item active">Create User Type</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="container">

    <div class="row justify-content-center text-center">
        <div class="col-md-6">
            <h2>Company Logo Here</h2>
        </div>
    </div> 
    
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center text-white" style="background-color: #3c8dbc">Create User Type</div>

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
                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <input type="submit" id="btnSave" class="btn btn-primary" value="Save User Type">                                                                
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        
        //Saving of new user type
        $(document).on("click", "#btnSave", function(){

            $type_name = $('#name').val();
            $type_desc = $('#desc').val();

            if($type_name == "")
            {
                $('#name').addClass("is-invalid");
                $('#error-no-type').removeAttr("hidden");
            }
            else{
                $.ajax({
                    headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: "{{ route('usertype_post') }}",
                    method: "POST",
                    data:$('#usertype_form').serialize(),                 
                    success:function(data)
                    {
                        alert("User Type Added!");                 
                    }
                });
            }           
        });
    });
</script>
@endsection
