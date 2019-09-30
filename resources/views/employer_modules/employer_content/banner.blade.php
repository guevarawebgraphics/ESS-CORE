@extends('layouts.master')

@section('crumb')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="m-0 text-dark">Banner Content</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
                <a href="#">Banner Content</a>
            </li>
            <li class="breadcrumb-item active-employercontent text-secondary">Manage Content</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="container-fluid" >
    <div class="card card-custom-blue card-outline">
        <div class="card-header">
            <h3 class="card-title"><i class="fa fa-bullhorn"></i> Banner Content</h3>
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
                            <a href="#AddBannerLink" class="btn btn-outline-primary btn-flat float-md-right " id="btn_createbannercontent" data-toggle="modal" data-target="#AddBannerModal"><i class="fa fa-plus-square"></i> Create Banner Content</a>
                        </div>
                </div>
                <div id="table_bannercontent" style="position: relative; overflow: auto; min-height: 870.141px;; width: 100%;">
                        @include("employer_modules.employer_content.tablebanner")    
                </div>                                    
        </div>              
    </div>      
</div>
<div class="modal fade" id="AddBannerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content card-custom-blue card-outline">
        <div class="modal-header">
            <h5 class="modal-title" id="title_modal"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="contentbannerform"  runat="server">
            {{-- CSRF --}}
                @csrf
                <input type="hidden" id="action" value="">
                <input type="hidden" id="hidden_id" name="hidden_id" value="">
                <div class="form-group row">
                        <label for="content_title" class="control-label col-md-4 text-md-center custom-flat-label">Banner Title:</label>     
                        <div class="col-md-6">    
                            <input id="banner_title" type="text" class="form-control custom-flat-input-modal" name="title_banner" placeholder="Content Title"   autofocus>
                            <p class="text-danger" id="error_banner_title"></p>
                        </div>        
                </div>
                <div class="form-group row"> 
                        <label for="banner_description" class="control-label col-md-4 text-md-center custom-flat-label">Banner Description:</label> 
                        <div class="col-md-6">    
                            <textarea type="text" id="banner_description" class="form-control  custom-flat-input-modal" name="description_banner" placeholder="Content Description" autofocus></textarea>
                            <p class="text-danger" id="error_banner_description"></p> 
                        </div>
                </div>  
                <div class="form-group row"> 
                        <label for="media_description" class="control-label col-md-4 text-md-center custom-flat-label">Image/Video File:</label>
                        <div class="col-md-6">    
                        <div class="custom-file">    
                            <input type="file" class="custom-file-input" id="banner_file" onchange="processSelectedFilesBanner(this)" name="media_banner_file">
                            <label class="custom-file-label" for="validatedCustomFile" id="choose_file">Choose file...</label>  
                            </div> 
                            <input type="hidden" name="hidden_file_name" id="hidden_file_name" val="">
                            <p class="text-danger" id="error_banner_file"></p> 
                        </div>  
                </div>
        
        
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary btn-flat" data-dismiss="modal">Close</button>  
            <button type="submit" class="btn btn-outline-primary btn-flat" id="SaveBannerContent"> </button> 
        </div>     
    </form>
    </div>
</div>
<script>
        $(document).ready(function(){
    
            //function for refreshing table
        
            function refreshTableBanner()
            { 
                $.ajax({
                    headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: "{{ route('refresh_banner') }}",
                    method: "GET",
                    data:{},             
                    success:function(data)
                    {   
                        $('#table_bannercontent').html(data);                    
                        var table = $("#BannerContentTable").DataTable({
                            "sDom": '<"customcontent">rt<"row"<"col-lg-6" i><"col-lg-6" p>><"clear">',
                            "paging": true,
                            "pageLength": 10,
                            "ordering":false,
                            scrollY: 600,
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
            var table = $("#BannerContentTable").DataTable({
              "sDom": '<"customcontent">rt<"row"<"col-lg-6" i><"col-lg-6" p>><"clear">',
              "paging": true,
              "pageLength": 10,
              "ordering":false,
               scrollY: 500,
              "autoWidth": true,
              lengthChange: false,
              responsive: true
            }); 
 
        $(document).on("click", "#btn_createbannercontent", function(){ 
            $('#SaveBannerContent').html('Create Banner Content '+' <i id="spinner_content" class=""> ');
            $("#action").val("add"); 
            $('#title_modal').html('Create Banner'); 

            $('#banner_title').removeClass('is-invalid');
            $('#error_banner_title').html(''); 

            $('#banner_description').removeClass('is-invalid');
            $('#error_banner_description').html(''); 

            $('#banner_file').removeClass('is-invalid');
            $('#error_banner_file').html(''); 

            $('#banner_title').val(""); 
            $('#banner_description').val(""); 
            $('#choose_file').html('Choose file'); 
            $('#banner_file').val("");  

            $('#SaveBannerContent').attr('disabled',false);
        });  
        $(document).on("click", ".banner-edit", function(){  
            $('#SaveBannerContent').html('Edit Banner Content '+' <i id="spinner_content" class=""> '); 
            $('#title_modal').html('Edit Banner'); 
            $("#action").val("edit"); 

            $('#banner_title').removeClass('is-invalid');
            $('#error_banner_title').html(''); 

            $('#banner_description').removeClass('is-invalid');
            $('#error_banner_description').html(''); 

            $('#banner_file').removeClass('is-invalid');
            $('#error_banner_file').html('');
            
            $('#banner_title').val(""); 
            $('#banner_description').val(""); 
            $('#banner_file').val("");  

            $('#SaveBannerContent').attr('disabled',false);
            
            let banner = {
                title : $(this).attr('data-title'),
                description:  $(this).attr('data-description'),
                file: $(this).attr('data-file'),
                id: $(this).attr('data-add'),
            }
            $('#banner_title').val(banner.title);  
            $('#banner_description').val(banner.description);   
            $('#banner_file').attr('src',banner.file);
            $('#choose_file').html(banner.file.substring(0,15)+'...'); 
            $('#hidden_file_name').val(banner.file);
            $('#hidden_id').val(banner.id)    
                

        });   
        $('#contentbannerform').submit(function (e){  
            $('#SaveBannerContent').attr('disabled',true);
            e.preventDefault(); 
            toastr.remove()
            var formData = new FormData($(this)[0]);   
            $("#spinner_content").addClass('fa fa-refresh fa-spin');
            var action = $('#action').val(); 
            if(action =="add") {
                $.ajaxSetup({
                        headers: {
                                  'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        } 
                        }); 
                        $.ajax({
                              url: '/employercontent/create_banner',
                              method: 'POST',
                              async: false,
                              dataType: 'json',
                              data: formData,
                              cache: false,
                              contentType: false,
                              enctype: 'multipart/form-data',
                              processData: false,
                              success: function(data){
                                toastr.success('Banner Uploaded Successfully', 'Success');
                                console.log("UPLOADED");
                                refreshTableBanner(); 
                                setTimeout(function (){
                                $('#AddBannerModal').modal('hide');
                                }, 1000);
                              },
                              error: function(data){
                                if(data.status ==422) { 
                               
                                    toastr.error('Error. Please Complete the fields', 'Error!');
                                    spinnerTimeoutEmployer()
                                    var errors = $.parseJSON(data.responseText); 
                                    $.each(errors, function(i, errors){
                                        if(errors.title_banner){
                                            $('#banner_title').addClass('is-invalid');
                                            $('#error_banner_title').html(errors.title_banner);
                                        }  
                                        if(!errors.title_banner){
                                            $('#banner_title').removeClass('is-invalid');
                                            $('#error_banner_title').html("");
                                        } 

                                        //  

                                        if(errors.description_banner){
                                            $('#banner_description').addClass('is-invalid');
                                            $('#error_banner_description').html(errors.description_banner);
                                        }
                                        if(!errors.description_banner){
                                            $('#banner_description').removeClass('is-invalid');
                                            $('#error_banner_description').html("");
                                        }
                                        // 
                                        
                                        if(errors.media_banner_file){
                                            $('#banner_file').addClass('is-invalid');
                                            $('#error_banner_file').html(errors.media_banner_file);
                                        } 
                                        if(!errors.media_banner_file){
                                            $('#banner_file').removeClass('is-invalid');
                                            $('#error_banner_file').html("");
                                        }
                                        console.log(errors); 
                                        console.clear(); 
                                        $('#SaveBannerContent').attr('disabled',false);
                                    });
                                }
                                
                              }
                              
                          });
            }
            else { 
                console.log(action); 
                $.ajaxSetup({
                        headers: {
                                  'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        } 
                        }); 
                        $.ajax({
                              url: '/employercontent/update_banner',
                              method: 'POST',
                              async: false,
                              dataType: 'json',
                              data: formData,
                              cache: false,
                              contentType: false,
                              enctype: 'multipart/form-data',
                              processData: false,
                              success: function(data){ 
                                setTimeout(function (){
                                $('#AddBannerModal').modal('hide');
                                }, 1000);
                                toastr.success('Banner Edited Successfully', 'Success')
                                console.log("UPLOADED");
                                refreshTableBanner(); 
                              
                              },
                              error: function(data){
                                if(data.status ==422) {  
                                    console.clear();
                                    toastr.error('Error. Please Complete the fields', 'Error!');
                                    spinnerTimeoutEmployer()
                                    var errors = $.parseJSON(data.responseText); 
                                    $.each(errors, function(i, errors){
                                        if(errors.title_banner){
                                            $('#banner_title').addClass('is-invalid');
                                            $('#error_banner_title').html(errors.title_banner);
                                        }  
                                        if(!errors.title_banner){
                                            $('#banner_title').removeClass('is-invalid');
                                            $('#error_banner_title').html("");
                                        } 

                                        //  

                                        if(errors.description_banner){
                                            $('#banner_description').addClass('is-invalid');
                                            $('#error_banner_description').html(errors.description_banner);
                                        }
                                        if(!errors.description_banner){
                                            $('#banner_description').removeClass('is-invalid');
                                            $('#error_banner_description').html("");
                                        }
                                        // 
                                        
                                        if(errors.media_banner_file){
                                            $('#banner_file').addClass('is-invalid');
                                            $('#error_banner_file').html(errors.media_banner_file);
                                        } 
                                        if(!errors.media_banner_file){
                                            $('#banner_file').removeClass('is-invalid');
                                            $('#error_banner_file').html("");
                                        }
                                        console.log(errors); 
                                        console.clear();
                                    });
                                }
                              }
                              
                          });
            }

                        
           
        });  
        $(document).on("click", ".banner-delete", function(){ 
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
                        url: "{{ route('deletebannercontent') }}",
                        method: "POST",
                        data:{id: delete_data[0], title:delete_data[1]},
                        dataType: "JSON",            
                        success:function(data)
                        {    
                            toastr.success(''+data+'', 'Success')
                            refreshTableBanner();                                                          
                        }
                    });
                }
            );   
     
        });  
        $(document).on("click", ".banner-post", function(){ 
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
                        url: "{{ route('postbanner') }}",
                        method: "POST",
                        data:{id: post_data[0], title: post_data[1]},            
                        success:function(data)
                        {    
                            refreshTableBanner();                                 
                            toastr.success('Content Posted Successfully', 'Success')     
                            spinnerTimeoutEmployer()                                                                  
                        }
                    });
                }
            );         
        }); 
                    //spinner btn_createmediacontent
            function spinnerTimeoutEmployer(){
            setTimeout(function (){
                        $("#spinner_content").removeClass('fa fa-refresh fa-spin');
            }, 1000);
        } 
        
    });  
    
</script>


@endsection