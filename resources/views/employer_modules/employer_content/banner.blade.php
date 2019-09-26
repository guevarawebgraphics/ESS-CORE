@extends('layouts.master')

@section('crumb')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="m-0 text-dark">Carousel Content</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
                <a href="#">Carousel Content</a>
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
                            <input id="content_title" type="text" class="form-control custom-flat-input-modal" name="media_title" placeholder="Content Title"   autofocus>
                            <p class="text-danger" id="error_content_title"></p>
                        </div>        
                </div>
                <div class="form-group row"> 
                        <label for="content_description" class="control-label col-md-4 text-md-center custom-flat-label">Banner Description:</label> 
                        <div class="col-md-6">    
                            <textarea type="text" id="media_description" class="form-control  custom-flat-input-modal" name="media_description" placeholder="Content Description" autofocus></textarea>
                            <p class="text-danger" id="error_content_description"></p> 
                        </div>
                </div>  
                <div class="form-group row"> 
                        <label for="media_description" class="control-label col-md-4 text-md-center custom-flat-label">Image/Video File:</label>
                        <div class="col-md-6">    
                        <div class="custom-file">    
                            <input type="file" class="custom-file-input" id="banner_file" name="banner_file">
                            <label class="custom-file-label" for="validatedCustomFile" id="medial_file">Choose file...</label>  
                            </div>
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
        });  
        $(document).on("click", ".banner-edit", function(){ 
            $('#SaveBannerContent').html('Edit Banner Content '+' <i id="spinner_content" class=""> ');
            $("#action").val("edit");
        });  
        $('#contentbannerform').submit(function (e){ 
            console.log("hi");
            e.preventDefault();
            var formData = new FormData($(this)[0]); 
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
                          
                                console.log("UPLOADED");
                                refreshTableBanner();
                              },
                              error: function(data){
                                if(data.status ==422) {
                                    var errors = $.parseJSON(data.responseText); 
                                    $.each(errors, function(i, errors){
                                    
                                        console.log(errors);
                                    });
                                }
                              }
                              
                          });
                        
           
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