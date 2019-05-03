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
                    <a href="#Add" class="btn btn-primary float-md-right " id="btn_createcontent" data-toggle="modal" data-target="#AddContentModal"><i class="fa fa-plus-square"></i> Create Employer Content</a>
                </div>
            </div>
    
            <div id="table_employercontent">
                @include("employer_modules.employer_content.tablemanage")    
            </div>                                                              
        </div>              
    </div>      
</div>

<!-- Add Content Modal -->
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
                <input type="text" id="action" value="">
                <input type="text" id="hidden_id" name="hidden_id" value="">
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
                                <p class="text-danger" id="error_content_description"></p>
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

        //function for refreshing table
        function refreshTable()
        {
            $.ajax({
                headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "{{ route('refreshmanage') }}",
                method: "GET",
                data:{},             
                success:function(data)
                {   
                    $('#table_employercontent').html(data);                    
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
                }
            });
        }

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

        //Save content
        $(document).on("click", "#SaveContent", function(){
            action_to_do = $("#action").val();
            //alert(action_to_do);
            //console.log("asa");
            if(action_to_do == "add")
            {
                $.ajax({
                    headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: "{{ route('createemployercontent') }}",
                    method: "POST",
                    data:$("#content_form").serialize(),             
                    success:function(data)
                    {                          
                        toastr.success('Content Created Successfully', 'Success')
                        $('#AddContentModal').modal('hide');
                        refreshTable();                                                    
                    },
                    error:function(data, status)
                    {
                        toastr.error('Error. Please Complete the fields', 'Error!')
                        /*Add Error Field*/
                        var errors = $.parseJSON(data.responseText);
                        $.each(errors, function(i, errors){
                            if(errors.content_title){
                                $('#content_title').addClass('is-invalid');
                                $('#error_content_title').html('Content Title is Required');
                            }
                            if(errors.content_description){
                                $('#content_description').addClass('is-invalid');
                                $('#error_content_description').html('Content Description is Required');
                            }
                            
                        });
                    }
                });
            }
            else if(action_to_do == "edit")
            {
                $.ajax({
                    headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: "{{ route('updateemployercontent') }}",
                    method: "POST",
                    data:$("#content_form").serialize(),             
                    success:function(data)
                    {                          
                        toastr.success('Content Updated Successfully', 'Success')
                        $('#AddContentModal').modal('hide');
                        refreshTable();                                                                  
                    },
                    error:function(data, status)
                    {
                        toastr.error('Error. Please Complete the fields', 'Error!')
                        /*Add Error Field*/
                        var errors = $.parseJSON(data.responseText);
                        $.each(errors, function(i, errors){
                            if(errors.content_title){
                                $('#content_title').addClass('is-invalid');
                                $('#error_content_title').html('Content Title is Required');
                            }
                            if(errors.content_description){
                                $('#content_description').addClass('is-invalid');
                                $('#error_content_description').html('Content Description is Required');
                            }                           
                        });
                    }              
                });
            }
            
        });

        //click create content
        $('#btn_createcontent').click(function(e){
            $("#content_title").val(""); 
            $("#content_description").val("");
            $('#SaveContent').html('Save Content');
            $("#action").val("add");
            $("#hidden_id").val(""); 
        });

        //Show edit
        $(document).on("click", ".content-edit", function(){
            $("#content_title").val(""); 
            $("#content_description").val("");
            $('#SaveContent').html('Update Content');
            $("#action").val("edit");

            var edit_id = $(this).data("add");
            //alert(edit_id);
            $('#AddContentModal').modal();

            $.ajax({
                headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "{{ route('editemployercontent') }}",
                method: "GET",
                data:{id: edit_id},
                dataType: "JSON",            
                success:function(data)
                {    
                    $("#hidden_id").val(data[0].id);                    
                    $("#content_title").val(data[0].content_title); 
                    $("#content_description").val(data[0].content_description);                                                           
                }
            });
        });

        //delete content
        $(document).on("click", ".content-delete", function(){
            delete_id = $(this).data("add");
            delete_data = delete_id.split("]]");
            swal({
                title: "Delete this content?",
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
                        url: "{{ route('deleteemployercontent') }}",
                        method: "POST",
                        data:{id: delete_data[0], title:delete_data[1]},
                        dataType: "JSON",            
                        success:function(data)
                        {    
                            toastr.success('Content Deleted Successfully', 'Success')
                            refreshTable();                                                                          
                        }
                    });
                }
            );         
        });

        //post content
        $(document).on("click", ".content-post", function(){
            post_id = $(this).data("add");
            post_data = post_id.split("]]");
            console.log(post_id);
            swal({
                title: "Post this Content?",
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
                        url: "{{ route('postemployercontent') }}",
                        method: "POST",
                        data:{id: post_data[0], title: post_data[1]},            
                        success:function(data)
                        {    
                            refreshTable();                                 
                            toastr.success('Content Posted Successfully', 'Success')                                                                      
                        }
                    });
                }
            );         
        });

    });     
</script>
@endsection