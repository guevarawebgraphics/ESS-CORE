@extends('layouts.master')
@section('crumb')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="m-0 text-dark">Manage Docs & Template</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
                <a href="#">Manage Docs & Template</a>
            </li>
            <li class="breadcrumb-item active-template text-secondary">Manage</li>
        </ol>
    </div>
</div>
@endsection
@section('content')
@php
if(Session::get('manage_docs') == 'all'){
    $add = '';
    $edit = '';
    $delete = '';
}
elseif(Session::get('manage_docs') == 'view'){
    $add = 'disabled';
    $edit = 'disabled';
    $delete = 'disabled';
}
elseif(Session::get('manage_docs') == 'add'){
    $add = '';
    $edit = 'disabled';
    $delete = 'disabled';
}
elseif(Session::get('manage_docs') == 'edit'){
    $add = '';
    $edit = '';
    $delete = 'disabled';
}
elseif(Session::get('manage_docs') == 'delete'){
    $add = '';
    $edit = 'disabled';
    $delete = '';
}else{
    $add = 'disabled';
    $edit = 'disabled';
    $delete = 'disabled';
}                   
@endphp
<div class="card card-custom-blue card-outline">
    <div class="card-header">
        <h3 class="card-title"><i class="fa fa-file"></i> Manage Document and Templates</h3>
        {{-- <i class="fa fa-file"></i> --}}
    </div>

    <!-- /.card-header -->
    <div class="card-body">
        <div class="form-group row">
            {{-- <label for="searchbox" class="col-md-2 text-md-center" style="margin-top: 5px;"><i class="fa fa-search"></i> Search:</label> --}}
            <div class="col-md-6">
                <div class="input-group">
                  <div class="input-group-prepend">
                      <span class="fa fa-search input-group-text" style="background-color: #fff;"></span>
                    </div>
                    <input id="searchbox" type="text" class="form-control" name="searchbox" placeholder="Search">
                </div>
            </div>
            <div class="col-md-6">
                <a href="#Add" class="btn btn-outline-primary btn-flat float-md-right" id="btn_addtemplate" data-toggle="modal" data-target="#AddTemplateModal" {{$add}}><i class="fa fa-plus-square"></i> Create Template</a>
            </div>
        </div>

        <table id="DocumentAndTemplate" class="table table-boredered table-striped">
            <thead>
                <tr>
                    {{-- <th>ID</th> --}}
                    <th>Employer</th>
                    <th>Code</th>
                    <th>Description</th>
                    <th>File</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="showdata">
                {{-- Showdata --}}
            </tbody>
        </table>
    </div>
</div>

<!-- Add System Notification --> 
<!-- -->
<div class="modal fade" id="AddTemplateModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content card-custom-blue card-outline">
            <div class="modal-header">
              <h5 class="modal-title" id="title_modal"></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form id="template_form">
                {{-- CSRF --}}
                    @csrf
                    <div class="form-group row">
                    <label for="document_code" class="control-label col-md-4 text-md-center custom-flat-label">Document Code:</label>
                        <div class="col-md-6">
                            
                            <input id="document_code" type="text" class="form-control custom-flat-input-modal" name="document_code" placeholder="Document Code"   autofocus>
                                    <p class="text-danger" id="error_document_code"></p>
                        </div>
                    </div>
                    <div class="form-group row">
                    <label for="document_description" class="control-label col-md-4 text-md-center custom-flat-label">Document Description:</label>
                        <div class="col-md-6">
                            
                            <textarea id="document_description" type="text" class="form-control custom-flat-input-modal" name="document_description" placeholder="Document Description" autofocus></textarea>
                                    <p class="text-danger" id="error_document_description"></p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="employer" class="col-md-4 text-md-center custom-flat-label">Select Employer</label>
                        <div class="col-md-6">
                            <select class="form-control select2 custom-flat-select" style="width: 67%; padding-right: 250px !important;" name="employer_id" id="employer_id">
                                <option selected value="0">--Select Employer</option>
                                    @foreach($employers as $employer)
                                        <option value="{{$employer->id}}">{{$employer->business_name}}</option>
                                    @endforeach
                                </select>
                                <p class="text-danger" id="error_employer_id"></p>
                        </div>
                    </div>
                    <div class="form-group row">
                            <label for="document_file" class="col-md-4 text-md-center custom-flat-label">Upload Document Template:</label>
                            <div class="col-md-6">
                                
                                    <div class="custom-file">
                                        <input type="file" class="form-control-file custom-flat-file" id="document_file" name="document_file">
                                    </div>
                                    <input type="text" class="form-control disabled" id="document_file_name" name="document_file_name" hidden="true" disabled="true">
                            </div>
                    </div>
               
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-info btn-flat" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-outline-primary btn-flat" id="SaveTemplate">Save <i id="spinner_add" class=""></i></button>
            </div>
        </form>
          </div>
        </div>
      </div>


<!-- Delete System Notification -->
<div class="modal fade" id="DeleteTemplateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content card-custom-blue card-outline">
            <div class="modal-header">
              <h5 class="modal-title" id="title_modal"></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
               <h4>D you wanna Delete This Template?</h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="DeleteTemplate">Confirm <i id="spinner_delete" class=""></button>
            </div>
          </div>
        </div>
      </div>

<script>
$(document).ready(function (){
    $('.select2').select2()
    // Show All Data
    showAllTemplate();
    initdataTableDocumentAndTemplate();
    function initdataTableDocumentAndTemplate(){
        /*DataTable*/ 
        var table = $("#DocumentAndTemplate").DataTable({
            "sDom": '<"customcontent">rt<"row"<"col-lg-6" i><"col-lg-6" p>><"clear">',
            "paging": true,
            "pageLength": 10,
            "ordering": false,
            scrollY: 500,
            //  scrollX: true,
            "autoWidth": true,
            lengthChange: false,
            responsive: true,
            fixedColumns: true
        });
        /*Custom Search For DataTable*/
        $("#searchbox").on("keyup search input paste cut", function () {
            table.search(this.value).draw();
        });
    }

    $('#btn_addtemplate').click(function (){
        $('#template_form')[0].reset();
        $('#template_form').attr('action', '/Template/store_template');
        $('#AddTemplateModal').find('#title_modal').text('Add Template');
        $('#template_form').removeAttr('hidden');
        $('#document_file_name').attr('hidden', true);
        $('#employer_id').attr('disabled', false);
        $("#SaveTemplate").removeAttr("disabled");
    });

    /*Save Template*/
    $('#template_form').submit(function (e){
        var url = $("#template_form").attr('action');
        $("#SaveTemplate").attr("disabled",true);
        e.preventDefault();
        $("#spinner_add").addClass("fa fa-refresh fa-spin"); 
        toastr.remove();
        var formData = new FormData($(this)[0]);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        if($('#document_code').val() == ""){
            $('#document_code').addClass('is-invalid');
            $('#error_document_code').html('Document Code is Required');
            spinnerTimout()
            $("#SaveTemplate").removeAttr("disabled");
        }
        if($('#document_description').val() == ""){
            $('#document_description').addClass('is-invalid');
            $('#error_document_description').html('Document Description is Required');
            spinnerTimout()
            $("#SaveTemplate").removeAttr("disabled");
        }
        if($('#document_code').val() != "" && $('#document_description').val() != "") {
            $("#SaveTemplate").removeAttr("disabled");
            $.ajax({
            url: url,
            method: 'POST',
            async: false,
			dataType: 'json',
            data: formData,
            cache: false,
            contentType: false,
            enctype: 'multipart/form-data',
            processData: false,
            success: function(data){
                $('#DocumentAndTemplate').DataTable().destroy();
                // Show All Data
                showAllTemplate();
                initdataTableDocumentAndTemplate();
                /*Hide Modal*/
                setTimeout(function (){
                          $('#AddTemplateModal').modal('hide');
                }, 1000);
                $("#SaveTemplate").attr("disabled",true);
                // Display a success toast, with a title
                toastr.success('Template Saved Successfully', 'Success')
                spinnerTimout()
            },
            error: function(data, status){
                toastr.error('Error. Please Complete The Data', 'Error!')
                setTimeout(function (){
                    $("#spinner_add").removeClass('fa fa-refresh fa-spin');
                }, 250);
                var errors = $.parseJSON(data.responseText);
                $.each(errors, function (i, errors){
                    if(errors.document_code){
                        $('#document_code').addClass('is-invalid');
                        $('#error_document_code').html('Document Code is Required');
                    }
                    if(errors.document_description){
                        $('#document_description').addClass('is-invalid');
                        $('#error_document_description').html('Document Description is Required');
                    }
                });
               
            }
        });
        }
        
    });
    function spinnerTimout(){
        setTimeout(function (){
                    $("#spinner_add").removeClass('fa fa-refresh fa-spin');
        }, 1000);
    }

    /*Edit Template*/
    $('#showdata').on('click', '.template-edit', function(){
        var id = $(this).attr('data');
        $('#AddTemplateModal').modal('show');
        $('#AddTemplateModal').find('#title_modal').text('Edit Template');
        $('#template_form').attr('action', '/Template/update_template/' + id);
        $('#template_form').removeAttr('hidden');
        $('#document_file_name').removeAttr('hidden');
        $('#employer_id').attr('disabled', true);
        $("#SaveTemplate").removeAttr("disabled"); 
        $('#error_document_code').html('');
        $('#document_code').removeClass('is-invalid');
        $('#error_document_description').html('');
        $('#document_description').removeClass('is-invalid');  

        var code = $(this).attr('data-code'); 
        var description = $(this).attr('data-description'); 
        var file = $(this).attr('data-file');
        toastr.remove();
        $.ajax({
            type: 'ajax',
            method: 'get',
            url: '/Template/edit_template',
            data: {id: id},
            dataType: 'json',
            success: function(data){
                if(data.length == 0)
                {
                    $('#document_code').val(code); 
                    $('#document_description').val(description);
                    $('#document_file_name').val(file); 
                    $('#select2-employer_id-container').text("");
                }                
                else 
                {
                $('#select2-employer_id-container').attr('title', data[0].employer_id).text(data[0].business_name);
                $('#document_code').val(data[0].document_code);
                $('#document_description').val(data[0].document_description);
                $('#document_file').attr('value', data[0].document_file);
                $('#document_file_name').val(data[0].document_file);
                }
                       
            },
            error: function(){
                $.each(errors, function (i, errors){
                    if(errors.document_code){
                        $('#document_code').addClass('is-invalid');
                        $('#error_document_code').html('Document Code is Required');
                    }
                    if(errors.document_description){
                        $('#document_description').addClass('is-invalid');
                        $('#error_document_description').html('Document Description is Required');
                    }
                });
            }
        }); 
    });

    /*Delete Template*/
    $('#showdata').on('click', '.template-delete', function(){
        var id = $(this).attr('data');
        var documentfile = $(this).attr('documentfile');
        toastr.remove()
        toastr.clear()
        swal({
            title: "Do you wanna Delete This Template?",
            type: "error",
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes",
            showCancelButton: true,
            closeOnConfirm: true,
        },
            function (){
                $.ajax({
                    type: 'POST',
                    url: '/Template/destroy_template',
                    data: {
                        id: id,
                        '_token': $('input[name=_token]').val(),
                        documentfile: documentfile,
                    },
                    success: function(data){
                        setTimeout(function (){
                            $('#DeleteTemplateModal').modal('hide');
                        }, 400);
                        // Display a success toast, with a title
                        toastr.success('Template Deleted Successfully', 'Success')
                        setTimeout(function (){
                            $("#spinner_delete").removeClass('fa fa-refresh fa-spin');
                        }, 300);
                        showAllTemplate();
                    },
                    error: function(data){
                        toastr.error('Error Deleting Template')
                    }
                });
            }
        );


    }); 

    //Show Data
    function showAllTemplate(){
        $.ajax({
                type: 'GET',
                url: '/Template/get_all_template',
                async: false,
                dataType: 'json',
                success: function (data){
                    var html = '';
                    var i;
                    for(i=0; i<data.length; i++){
                       var file_name = (data[i].document_file.string > 5 ? data[i].document_file.substring(0,5) : data[i].document_file.substring(0,10));
                                         $.ajax({
                                            type: 'ajax',
                                            method: 'get',
                                            url: '/Template/get_employer_name',
                                            data: {id:data[i].id},
                                            dataType: 'json',
                                            async:true,
                                            success: function(response){       
                                                $("#employer-name-"+response.id+"").html(response.name);                              
                                                if(response.name==false)
                                                {
                                                    $("#employer-name-"+response.id+"").html("Available to all");
                                                }
                                            }, 
                                                 }); 
                                     
                        html +='<tr>'+
                                     '<td id="employer-name-'+data[i].id+'"></td>'+
                                     '<td>'+data[i].document_code+'</td>'+
                                     '<td>'+data[i].document_description+'</td>'+
                                     '<td data-toggle="tooltip" data-placement="top" title="Click To Download This Template">'+'<a href="/storage/Documents/templates/'+data[i].document_file+'" download>' +file_name+'<div class="float-right"><i class="fa fa-download"></i></div>'+'</a>'+'</td>'+
                                     '<td>'+
                                        '<a href="javascript:;" class="btn btn-sm btn-outline-info btn-flat template-edit" data-file="'+data[i].document_file+'" data-code="'+data[i].document_code+'"  data-description="'+data[i].document_description+'" data="'+data[i].id+'" {{$edit}}><span class="icon is-small"><i class="fa fa-edit"></i></span>&nbsp;Edit</a>'+' '+
                                        '<a href="javascript:;" class="btn btn-sm btn-outline-danger btn-flat template-delete" data="'+data[i].id+'"  data-documentfile="'+data[i].document_file+'" {{$delete}}><span class="icon is-small"><i class="fa fa-trash"></i></span>&nbsp;Delete</a>'+
                                     '</td>'+
                                '</tr>';
                    }
                   
                        $('#showdata').html(html);
                   
                
                },
                error: function(){
                    console.log('Could not get data from database');
                }
            });
    }


});
</script>
@endsection