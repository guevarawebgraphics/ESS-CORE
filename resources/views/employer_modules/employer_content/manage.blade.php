@extends('layouts.master')

@section('crumb')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="m-0 text-dark">Employer Content</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
                <a href="#">Employer Content</a>
            </li>
            <li class="breadcrumb-item active">Manage Content</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><i class="fa fa-bullhorn"></i> Employer Content</h3>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <label for="searchbox" class="col-md-2 text-md-center" style="margin-top: 5px;"><i class="fa fa-search"></i> Search:</label>
                <div class="col-md-4">
                    <input id="searchbox" type="text" class="form-control" name="searchbox" placeholder="Search">
                </div>
                <div class="col-md-6">
                    <a href="#Add" class="btn btn-primary float-md-right" id="btn_createcontent" data-toggle="modal" data-target="#AddContentModal"><i class="fa fa-plus-square"></i> Create Employer Content</a>
                </div>
            </div>
    
            <div id="table_employercontent">
                @include("employer_modules.employer_content.tablemanage")    
            </div>                                                              
        </div>              
    </div>      
</div>
<!-- Add Content -->
<div class="modal fade" id="AddContentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="title_modal"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="content_form">
            {{-- CSRF --}}
                @csrf
                <div class="form-group row">
                <label for="content_title" class="control-label col-md-4 text-md-center">Content Title:</label>
                    <div class="col-md-6">
                        
                        <input id="content_title" type="text" class="form-control" name="content_title" placeholder="Content Title"   autofocus>
                                <p class="text-danger" id="error_content_title"></p>
                    </div>
                </div>
                <div class="form-group row">
                <label for="content_description" class="control-label col-md-4 text-md-center">Content Description:</label>
                    <div class="col-md-6">
                        
                        <textarea id="content_description" type="text" class="form-control" name="content_description" placeholder="Content Description" autofocus></textarea>
                                <p class="text-danger" id="error_annoucement_description"></p>
                    </div>
                </div>
                <div class="form-group row">
                        <label for="content_type" class="col-md-4 text-md-center">Content Type:</label>
                        <div class="col-md-6">
                            
                                <select id="content_type" name="content_type" class="form-control">
                                    <option value="" selected>Choose Content Type...</option>
                                </select>
                                    <p class="text-danger" id="error_content_type"></p>
                        </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="SaveContent">Save</button>
        </div>
    
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){

        var table = $("#EmployerContentTable").DataTable({
          // "searching": false,
          "sDom": '<"customcontent">rt<"row"<"col-lg-6" i><"col-lg-6" p>><"clear">',
          "paging": true,
          "pageLength": 10000,
          "ordering":false,
           scrollY: 300,
          //  scrollX: true,
          "autoWidth": true,
          lengthChange: false,
          responsive: true,
          "order": [[0, "desc"]]
        });
        /*Custom Search For DataTable*/
        $("#searchbox").on("keyup search input paste cut", function () {
            table.search(this.value).draw();
        });

        // Get User Type
        $.ajax({
            method: 'get',
            url: '/Account/get_user_type',
            dataType: 'json',
            success: function (data) {
                $.each(data, function (i, data) {
                    $("#content_type").append('<option value="' + data.id + '">' + data.type_name + '</option>');
                });
            },
            error: function (response) {
                console.log("Error cannot be");
            }
        });

        //Save content
        $(document).on("click", "#SaveContent", function(){
            //console.log("asa");
            $.ajax({
                headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "{{ route('createemployercontent') }}",
                method: "POST",
                data:$("#content_form").serialize(),             
                success:function(data)
                {                          
                    toastr.success('Content Created Successfully', 'Success')
                    $('#AddContentModal').modal('hide');
                    refreshUserTable();                                                                   
                }
            });
        });

    });
      
</script>
@endsection