@extends('layouts.master')

@section('content')
<div class="card card-info card-outline">
    <div class="card-header">
        <h3 class="card-title"><i class="fa fa-file"></i> Manage Document and Templates</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="form-group row">
            <label for="searchbox" class="col-md-2 text-md-center" style="margin-top: 5px;"><i class="fa fa-search"></i> Search:</label>
            <div class="col-md-4">
                <input id="searchbox" type="text" class="form-control" name="searchbox" placeholder="Search">
            </div>
            <div class="col-md-6">
                <a href="#Add" class="btn btn-primary float-md-right" id="btn_addtemplate" data-toggle="modal" data-target="#AddTemplateModal"><i class="fa fa-plus-square"></i> Create Template</a>
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
<div class="modal fade" id="AddTemplateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
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
                    <label for="document_code" class="control-label col-md-4 text-md-center">Document Code:</label>
                        <div class="col-md-6">
                            
                            <input id="document_code" type="text" class="form-control" name="document_code" placeholder="Document Code"   autofocus>
                                    <p class="text-danger" id="error_document_code"></p>
                        </div>
                    </div>
                    <div class="form-group row">
                    <label for="document_description" class="control-label col-md-4 text-md-center">Document Description:</label>
                        <div class="col-md-6">
                            
                            <textarea id="document_description" type="text" class="form-control" name="document_description" placeholder="Document Description" autofocus></textarea>
                                    <p class="text-danger" id="error_document_description"></p>
                        </div>
                    </div>
                    <div class="form-group row">
                            <label for="document_file" class="col-md-4 text-md-center">Upload Document Template:</label>
                            <div class="col-md-6">
                                
                                    <div class="custom-file">
                                        <input type="file" class="form-control-file" id="document_file" name="document_file">
                                    </div>
                            </div>
                    </div>
               
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="SaveTemplate">Save <i id="spinner" class=""></button>
            </div>
        </form>
          </div>
        </div>
      </div>


<!-- Delete System Notification -->
<div class="modal fade" id="DeleteTemplateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
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
    // Show All Data
    showAllTemplate();
    /*DataTable*/ 
    var table = $("#DocumentAndTemplate").DataTable({
          // "searching": false,
          "sDom": '<"customcontent">rt<"row"<"col-lg-6" i><"col-lg-6" p>><"clear">',
          "paging": true,
          "pageLength": 10000,
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

    $('#btn_addtemplate').click(function (){
        $('#template_form')[0].reset();
        $('#template_form').attr('action', '/Template/store_template');
        $('#AddTemplateModal').find('#title_modal').text('Add Template');
        $('#template_form').removeAttr('hidden');
    });

    /*Save Template*/
    $('#template_form').submit(function (e){
        var url = $("#template_form").attr('action');
        $("#spinner").addClass('fa fa-refresh fa-spin');
        e.preventDefault();
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
            spinnerTimout();
        }
        if($('#document_description').val() == ""){
            $('#document_description').addClass('is-invalid');
            $('#error_document_description').html('Document Description is Required');
            spinnerTimout();
        }
        if($('#document_code').val() != "" && $('#document_description').val() != "") {
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
                // Show All Data
                showAllTemplate();
                /*Hide Modal*/
                setTimeout(function (){
                          $('#AddTemplateModal').modal('hide');
                }, 400);
                // Display a success toast, with a title
                toastr.success('Template Saved Successfully', 'Success')
                setTimeout(function (){
                    $("#spinner").removeClass('fa fa-refresh fa-spin');
                }, 1500);
            },
            error: function(data, status){
                toastr.error('Error. Please Complete The Data', 'Error!')
                setTimeout(function (){
                    $("#spinner").removeClass('fa fa-refresh fa-spin');
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

    /*Edit Template*/
    $('#showdata').on('click', '.template-edit', function(){
        var id = $(this).attr('data');
        $('#AddTemplateModal').modal('show');
        $('#AddTemplateModal').find('#title_modal').text('Edit Template');
        $('#template_form').attr('action', '/Template/update_template/' + id);
        $('#template_form').removeAttr('hidden');
        toastr.remove();
        $.ajax({
            type: 'ajax',
            method: 'get',
            url: '/Template/edit_template',
            data: {id: id},
            dataType: 'json',
            success: function(data){
                $('#document_code').val(data[0].document_code);
                $('#document_description').val(data[0].document_description);
                $('#document_file').attr('value', data[0].document_file);
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
        $('#DeleteTemplateModal').modal('show');
        $('#DeleteTemplateModal').find('#title_modal').text('Delete Template');
        $('#template_form').attr('hidden', true);
        //$("#SaveTemplate").prop("type", "button");
        toastr.remove()
        // Prevent Previous handler - unbind()
        $('#DeleteTemplate').unbind().click(function(){
            $("#spinner_delete").addClass('fa fa-refresh fa-spin');
            $.ajax({
                type: 'POST',
                url: '/Template/destroy_template',
                data: {
                    id: id,
                    '_token': $('input[name=_token]').val(),
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
        });
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
                        html +='<tr>'+
                                    // '<td>'+data[i].id+'</td>'+
                                     '<td>'+data[i].business_name+'</td>'+
                                     '<td>'+data[i].document_code+'</td>'+
                                     '<td>'+data[i].document_description+'</td>'+
                                     '<td data-toggle="tooltip" data-placement="top" title="Click To Download This Template">'+'<a href="/storage/Documents/templates/'+data[i].document_file+'" download>' +file_name+'   <i class="fa fa-download"></i>'+'</a>'+'</td>'+
                                     '<td>'+
                                        '<a href="javascript:;" class="btn btn-sm btn-secondary template-edit" data="'+data[i].id+'"><span class="icon is-small"><i class="fa fa-edit"></i></span>&nbsp;Edit</a>'+' '+
                                        '<a href="javascript:;" class="btn btn-sm btn-danger template-delete" data="'+data[i].id+'"><span class="icon is-small"><i class="fa fa-trash"></i></span>&nbsp;Delete</a>'+
                                    '</td>'+
                                '</tr>';
                    }
                    // if(type != null){
                        $('#showdata').html(html);
                    // }
                    //console.log('success');
                },
                error: function(){
                    console.log('Could not get data from database');
                }
            });
    }

    function spinnerTimout(){
        setTimeout(function (){
                    $("#spinner").removeClass('fa fa-refresh fa-spin');
        }, 250);
    }


});
</script>
@endsection