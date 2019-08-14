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
            <li class="breadcrumb-item active-employercontent text-secondary">Manage Content</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="container-fluid" >
    <div class="card card-info card-outline">
        <div class="card-header">
            <h3 class="card-title"><i class="fa fa-bullhorn"></i> Employer Content</h3>
        </div>
        <div class="card-body">
            <div class="form-group row">
              
                <div class="col-md-6">
                        <div class="input-group show">
                                <div class="input-group-prepend">
                                    <span class="fa fa-search input-group-text" style="background-color: #fff;"></span>
                                  </div>
                                  <input id="searchbox" type="text" class="form-control" name="searchbox" placeholder="Search">
                        </div>
                </div>
                <div class="col-md-6">
                    <a href="#Add" class="btn btn-outline-primary btn-flat float-md-right " id="btn_createcontent" data-toggle="modal" data-target="#AddContentModal"><i class="fa fa-plus-square"></i> Create Employer Content</a>
                </div>
            </div>
    
            <div id="table_employercontent" style="position: relative; overflow: auto; min-height: 870.141px;; width: 100%;">
                @include("employer_modules.employer_content.tablemanage")    
            </div>                                                              
        </div>              
    </div>      
</div>

<!-- Add Content Modal -->
<div class="modal fade" id="AddContentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content card-info card-outline">
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
                <input type="hidden" id="action" value="">
                <input type="hidden" id="hidden_id" name="hidden_id" value="">
                <div class="form-group row">
                    <label for="content_title" class="control-label col-md-4 text-md-center">Content Title:</label>     
                        <div class="col-md-6">    
                            <input id="content_title" type="text" class="form-control" name="content_title" placeholder="Content Title"   autofocus>
                            <p class="text-danger" id="error_content_title"></p>
                        </div>        
                </div>
                <div class="form-group row">
                    <label for="content_description" class="control-label col-md-4 text-md-center">Content Description:</label>
                        <div class="col-md-12">
                                <textarea type="text" id="content_description" class="form-control" name="content_description" placeholder="Content Description" autofocus></textarea>
                                <p class="text-danger" id="error_content_description"></p>
                        </div>
                </div>
            </form>
        
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary btn-flat" data-dismiss="modal">Close</button>  
            <button type="button" class="btn btn-outline-primary btn-flat" id="SaveContent"> </button> 
        </div>    
    </div>
</div>

<script>
    $(document).ready(function(){

        //function for refreshing table
        refreshTable();
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
                        "sDom": '<"customcontent">rt<"row"<"col-lg-6" i><"col-lg-6" p>><"clear">',
                        "paging": true,
                        "pageLength": 10,
                        "ordering":false,
                        scrollY: 500,
                        //  scrollX: true,
                        "autoWidth": true,
                        lengthChange: false,
                        responsive: true
                    }); 
                    $("#searchbox").on("keyup search input paste cut", function () {
                        table.search(this.value).draw();
                    });               
                }
            }); 

        }
        var table = $("#EmployerContentTable").DataTable({
          "sDom": '<"customcontent">rt<"row"<"col-lg-6" i><"col-lg-6" p>><"clear">',
          "paging": true,
          "pageLength": 10,
          "ordering":false,
           scrollY: 500,
          "autoWidth": true,
          lengthChange: false,
          responsive: true
        });
     
        

     

        //Save content 
        var editortwo = CKEDITOR.replace('content_description');
        CKFinder.setupCKEditor( editortwo );
        $(document).on("click", "#SaveContent", function(){ 
            action_to_do = $("#action").val(); 
            $('#SaveContent').attr('disabled',true);
            toastr.remove()
            $("#spinner_content").addClass('fa fa-refresh fa-spin');
            content_title = $("#content_title").val();


            if(content_title == "")
            {
              
                $('#content_title').addClass('is-invalid');
                $('#error_content_title').html('Content Title is Required'); 
                spinnerTimeoutEmployer()
                $('#SaveContent').removeAttr("disabled");
            }
            else
            {
                $('#content_title').removeClass('is-invalid');
                $('#error_content_title').html(''); 
                spinnerTimeoutEmployer()
            }

            if(CKEDITOR.instances.content_description.getData()  == "")
            {
          
                $('#content_description').addClass('is-invalid');
                $('#error_content_description').html('Content Description is Required');
                spinnerTimeoutEmployer()
                $('#SaveContent').removeAttr("disabled");
            }
            else
            {
                $('#content_description').removeClass('is-invalid');
                $('#error_content_description').html('');
            }
             
            if(content_title == "" && CKEDITOR.instances.content_description.getData()  == "")
            {
                toastr.error('Error. Please Complete the fields', 'Error!');
                spinnerTimeoutEmployer()
                $('#SaveContent').removeAttr("disabled");

            }
            
            if(content_title != "" && CKEDITOR.instances.content_description.getData()  != "")
            {
                if(action_to_do == "add")
                { 
                    
                    $('#spinner').addClass('fa fa-refresh fa-spin');
                      
                    $.ajax({
                        headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        url: "{{ route('createemployercontent') }}",
                        method: "POST",
                        data: {
                        _token:     '{{ csrf_token() }}',
                        content_title: $('#content_title').val(),
                        content_description: CKEDITOR.instances.content_description.getData(),
                        },           
                        success:function(data)
                        {                          
                            toastr.success('Content Created Successfully', 'Success') 
                            setTimeout(function (){
                                $('#AddContentModal').modal('hide');
                            }, 1000);
                            refreshTable(); 
                            spinnerTimeoutEmployer()

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
                                spinnerTimeoutEmployer()
                                
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
                        data: {
                        _token:     '{{ csrf_token() }}',
                        hidden_id: $('#hidden_id').val(),
                        content_title: $('#content_title').val(),
                        content_description: CKEDITOR.instances.content_description.getData(),
                        // announcement_type: $('#announcement_type').val(),
                        },              
                        success:function(data)
                        {                          
                            toastr.success('Content Updated Successfully', 'Success')
                            setTimeout(function (){
                                $('#AddContentModal').modal('hide');
                            }, 1000);
                            spinnerTimeoutEmployer()   
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
            }
            else
            {
                console.log("ERROR");
            }           
        });

        //click create content
        $('#btn_createcontent').click(function(e){
            $("#content_title").val(""); 
            content_description = $("#content_description").val("");
          //  $('#SaveContent').html('Save Content'); 
            CKEDITOR.instances.content_description.setData("");  
            $("#action").val("add");
            $("#hidden_id").val("");   

            $('#SaveContent').removeAttr("disabled");
            $('#content_title').removeClass('is-invalid');
            $('#error_content_title').html('');
            $('#content_description').removeClass('is-invalid');
            $('#error_content_description').html('');

            $('#SaveContent').html('Save Content '+' <i id="spinner_content" class=""> ');  
            $('#title_modal').html('Create Content');
        });

        //Show edit
        $(document).on("click", ".content-edit", function(){
            toastr.remove()
            $("#content_title").val(""); 
            $("#content_description").val("");
            $('#SaveContent').html('Update Content '+' <i id="spinner_content" class=""> ');
            $("#action").val("edit");

            var edit_id = $(this).data("add");
            //alert(edit_id);
            $('#AddContentModal').modal();
            $('#SaveContent').removeAttr("disabled"); 

            $('#content_title').removeClass('is-invalid');
            $('#error_content_title').html('');
            $('#content_description').removeClass('is-invalid');
            $('#error_content_description').html('');
             
            $('#title_modal').html('Edit Content');

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
                    CKEDITOR.instances.content_description.setData(data[0].content_description);    
                    refreshTable();     
                    spinnerTimeoutEmployer()                                                
                }
            });
        });

        //delete content
        $(document).on("click", ".content-delete", function(){ 
            toastr.remove()
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
            toastr.remove()
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
                            spinnerTimeoutEmployer()                                                                  
                        }
                    });
                }
            );         
        });

    });      
    //spinner
    function spinnerTimeoutEmployer(){
        setTimeout(function (){
                    $("#spinner_content").removeClass('fa fa-refresh fa-spin');
        }, 1000);
    }
</script>
@endsection