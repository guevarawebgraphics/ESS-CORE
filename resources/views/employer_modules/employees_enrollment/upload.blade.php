@extends('layouts.master')

@section('crumb')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="m-0 text-dark">Employees Enrollment</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
                <a href="#">Employees Enrollment</a>
            </li>
            <li class="breadcrumb-item active-employees text-secondary">Upload Employees</li>
        </ol>
    </div>
</div>
@endsection
@php
if(Session::get('employee_enrollment') == 'all'){
    $add = '';
    $edit = '';
    $delete = '';
}
elseif(Session::get('employee_enrollment') == 'view'){
    $add = 'disabled';
    $edit = 'disabled';
    $delete = 'disabled';
}
elseif(Session::get('employee_enrollment') == 'add'){
    $add = '';
    $edit = 'disabled';
    $delete = 'disabled';
}
elseif(Session::get('employee_enrollment') == 'edit'){
    $add = '';
    $edit = '';
    $delete = 'disabled';
}
elseif(Session::get('employee_enrollment') == 'delete'){
    $add = '';
    $edit = 'disabled';
    $delete = '';
}else{
    $add = 'disabled';
    $edit = 'disabled';
    $delete = 'disabled';
}                   
@endphp
@section('content')
<div class="container-fluid">
    <div class="card card-custom-blue card-outline">
        <div class="card-header">
            <h3 class="card-title"><i class="fa fa-edit"></i> Upload Employees Preview</h3>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <div class="col-md-6">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="fa fa-search input-group-text" style="background-color: #fff"></span>
                        </div>
                        <input id="searchbox" type="text" class="form-control" name="searchbox" placeholder="Search" autofocus>
                    </div>
                    <br>
                    <div class="alert alert-danger" id="error_alert" hidden="true">
                            <span><i class="fa fa-exclamation-circle"></i> <b>Errors</b></span>
                        <ul>
                            <div id="upload_validation_error_message"></div>
                        </ul>
                    </div>
                </div>
                
                <div class="col-md-6">
                    {{-- <a href="/enrollemployee/encode" class="btn btn-outline-primary btn-flat float-md-right mr-4" id="btnCreateEmployee"><i class="fa fa-plus-square" ></i> Encode Employee</a> --}}
                    <a href="#upload" class="btn btn-outline-info btn-flat float-md-right mr-4" id="btnUploadEmployee"><i class="fa fa-upload" ></i> Upload Employee</a>
                    <a href="#saveemployees" class="btn btn-outline-primary btn-flat float-md-right mr-4" id="btnSaveEmployees"><i class="fa fa-save" ></i> Save Employees</a>
                </div>
            </div>

            <div class="table-responsive">
                <table id="upload_employees_preview_table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Employee No</th>
                            <th>TIN</th>
                            <th>SSSGSIS</th>
                            <th>PHIC</th>
                            <th>HDMF</th>
                            <th>NID</th>
                            <th>MOBILE NUMBER</th>
                            <th>EMAIL</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody id="preview_employee_details">
                        {{-- Showdata --}}
                    </tbody>
                </table>
            </div>

        </div>              
    </div>      
</div>


  <!-- Modal For Upload Employee -->
  <div class="modal fade" id="UploadEmployees" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content card-custom-blue card-outline">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel" >Upload Employees</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <div class="col-md-12">
            @foreach($Employees_upload_template as $employees_template)
                <a href="/storage/Documents/templates/{{$employees_template->document_file}}" download>{{$employees_template->document_code}}<div class="float-left mr-3"><i class="fa fa-download"></i></div></a>
            @endforeach
            <ul id="ttttt" style="list-style-type: none;">
                {{-- <li><label class="text-danger" id="error_fields" hidden="true"></label></li> --}}
            </ul>
        </div>
        <form id="upload_employees_form">
            @csrf
            <div class="col-md-12">

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="fa fa-folder input-group-text"></span>
                    </div>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="imgInp" name="file" multiple onchange="processSelectedFilesUploadEmployees(this)">
                        <label class="custom-file-label" for="validatedCustomFile" id="upload_image_file">Choose file...</label>
                    </div>
                </div>
    
        </div>
     
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-info btn-flat" data-dismiss="modal" id="btn_upload_close">Close</button>
            <button type="submit" class="btn btn-outline-primary btn-flat" id="btn_upload">Upload <i id="spinner_upload" class=""></button>
        </div>
    </form>
      </div>
    </div>
  </div>


<!-- Modal For Upload Edit Employee Preview Details-->
<div class="modal fade" id="edit_employees_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content modal-lg">
            <div class="modal-header card-custom-blue card-outline">
              <h5 class="modal-title" id="exampleModalLongTitle">Edit Employees Register Details</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger" id="error_alert_upodate" hidden="true">
                    <span><i class="fa fa-exclamation-circle"></i> <b>Errors</b></span>
                    <ul>
                        <div id="update_validation_error_message"></div>
                    </ul>
                </div>
              <form id="edit_employee_details">
                  @csrf
                  <input type="text" name="employee_preview_id" id="employee_detail_id" hidden="true">
                  <div class="row">
                    <div class="col-md-12" id="edit_employees_field_col_1">
                    </div>
                  </div>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-outline-secondary btn-flat" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-outline-primary btn-flat" id="save_edit_employee_details">Save changes</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
 /*Function to get Filename*/
 function processSelectedFilesUploadEmployees(fileInput) {
        var files = fileInput.files;

        for (var i = 0; i < files.length; i++) {
                $('#upload_image_file').html(files[i].name);
        }
    }

    $(document).ready(function() {
        showAllEmployeesDetailsPreview();
        initDataTableEmployeePreview();
        

       function initDataTableEmployeePreview(){
        /*DataTable*/ 
        var table = $("#upload_employees_preview_table").DataTable({
            // "searching": false,
            "sDom": '<"customcontent">rt<"row"<"col-lg-6" i><"col-lg-6" p>><"clear">',
            "paging": true,
            "pageLength": 10,
            scrollY: 500,
            //  scrollX: true,
            "autoWidth": true,
            lengthChange: false,
            responsive: true,
            fixedColumns: true,
            "order": [[8, "desc"]]
        });
        /*Custom Search For DataTable*/
        $("#searchbox").on("keyup search input paste cut", function () {
            table.search(this.value).draw();
        });
    }


       $('#btnUploadEmployee').click(function(){
            toastr.clear()
            toastr.remove()
            $('#UploadEmployees').modal('show');
        });

        /*
        *@ On Close Modal
        */
        $('#UploadEmployees').on('hidden.bs.modal', function (e) {
            $('#ttttt').remove();
        });

        $('#upload_employees_form').submit(function (e){
            $("#spinner_upload").addClass('fa fa-refresh fa-spin');
            e.preventDefault();
            var formData = new FormData($(this)[0]);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ url('/enrollemployee/upload_employees_preview') }}",
                type: 'POST',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (){
                    //$('#preview_employee_details').DataTable().destroy();
                    
                    $('#upload_employees_form')[0].reset();
                    $('#UploadEmployees').modal('hide');
                    toastr.success('Employees Uploaded Successfully', 'Success')
                    //console.log("Success");
                    setTimeout(function (){
                            $("#spinner_upload").removeClass('fa fa-refresh fa-spin');
                        }, 300);
                    //initDataTableEmployeePreview();
                    showAllEmployeesDetailsPreview();
                },
                error: function(data, status){
                    setTimeout(function (){
                            $("#spinner_upload").removeClass('fa fa-refresh fa-spin');
                            $('#btn_upload').removeAttr('disabled');
                            $('#btn_upload_close').removeAttr('disabled');
                        }, 250);
                    // /console.log(data);
                    if(data.status === 422) {
                        //console.log(data.responseJSON.errors);
                        var err = data.responseJSON.errors;
                        //console.log("422");
                        var errors = $.parseJSON(data.responseText);
                        //console.log(errors);
                        $.each(err, function (i, err) {
                            //console.log(err);
                            $('#ttttt').append('<li><label class="text-danger" id="error_fields">'+err+'</label></li></br>');
                            
                        });
                    }
                }
            });

        });

       // Show Employees Preview
       function showAllEmployeesDetailsPreview(){
           $.ajax({
            type: 'GET',
            url: '/enrollemployee/get_employees_details_preview',
            async: false,
            dataType: 'json',
            success: function(data){
                var html = '';
                var i;
                for(i=0; i<data.length; i++){
                    check_employee_exists_in_excel(data[i].id, data[i].employee_no, data[i].TIN, data[i].SSSGSIS, data[i].PHIC, data[i].HDMF, data[i].NID, data[i].mobile_no, data[i].email_add);
                    html += '<tr>'+
                                '<td>'+data[i].employee_no+'</td>'+
                                '<td>'+data[i].TIN+'</td>'+
                                '<td>'+data[i].SSSGSIS+'</td>'+
                                '<td>'+data[i].PHIC+'</td>'+
                                '<td>'+data[i].HDMF+'</td>'+
                                '<td>'+data[i].NID+'</td>'+
                                '<td>'+data[i].mobile_no+'</td>'+
                                '<td>'+data[i].email_add+'</td>'+
                                '<td>' +
                                    '<a href="javascript:;" class="btn btn-sm btn-outline-info btn-flat btn_Edit_Employees_Preview" data-id="'+data[i].id+'" data-employee_no="'+data[i].employee_no+'" data-tin="'+data[i].TIN+'" data-sssgsis="'+data[i].SSSGSIS+'" '+
                                    ' data-phic="'+data[i].PHIC+'" data-hdmf="'+data[i].HDMF+'" data-nid="'+data[i].NID+'" data-mobile_no="'+data[i].mobile_no+'" data-email_add="'+data[i].email_add+'" data-toggle="modal" data-target="#edit_employees_details"><i class="fa fa-edit"></i> Edit</a> ' +
                                    '<a href="javascript:;" class="Delete btn-sm btn btn-outline-danger btn-flat btn_delete_employee_preview" id="delete-btn" data-toggle="modal" data-target="#deleteModal" data-id="'+data[i].id+'" {{$delete}}><i class="fa fa-trash"></i> Delete</a>' +
                                '</td>'+
                            '</tr>';
                }
                $('#preview_employee_details').html(html);
                //console.log(data);
            },
            error: function(data){
                //console.log('Could not get data from database');
            }
           });
       }


        /*Check for Duplicate Entry*/
        function check_employee_exists_in_excel(id, employee_no, TIN, SSSGSIS, PHIC, HDMF, NID, mobile_no, email_add)
        {
            $.ajax({
                type: 'POST',
                url: '/EmployeesEnrollmentController/check_employee_details_exists_in_excel',
                data: {
                    '_token': $('input[name=_token]').val(),
                    id: id,
                    employee_no: employee_no,
                    TIN: TIN,
                    SSSGSIS: SSSGSIS,
                    PHIC: PHIC,
                    HDMF: HDMF,
                    NID: NID,
                    mobile_no: mobile_no,
                    email_add: email_add},
                dataType: 'json',
                success: function(data){
                    //console.log(data);
                    if(data.status == "false"){
                            console.log();
                            $('#error_alert').removeAttr('hidden');
                            $('#upload_validation_error_message').append('<label>Employee No: ' + employee_no + ' '+ data.message +'</label><br>');
                        }
                },
                error: function(data){
                    console.log(data);
                    // Handle Errors
                    var errors = $.parseJSON(data.responseText);
                    console.log(errors.errors)
                    $.each(errors, function(i, errors){
                        if(errors.employee_no){
                            $('#error_alert').removeAttr('hidden');
                            $('#upload_validation_error_message').append('<hr><label>Employee No Duplicate Entry: ' + employee_no +'</label><br>');
                        }
                        if(errors.TIN){
                            $('#error_alert').removeAttr('hidden');
                            $('#upload_validation_error_message').append('<hr><label>TIN Duplicate Entry: ' + TIN +'</label><br>');
                        }
                        if(errors.SSSGSIS){
                            $('#error_alert').removeAttr('hidden');
                            $('#upload_validation_error_message').append('<label>SSSGSIS Duplicate Entry: ' + SSSGSIS +'</label><br>');
                        }
                        if(errors.PHIC){
                            $('#error_alert').removeAttr('hidden');
                            $('#upload_validation_error_message').append('<label>PHIC Duplicate Entry: ' + PHIC +'</label><br>');
                        }
                        if(errors.HDMF){
                            $('#error_alert').removeAttr('hidden');
                            $('#upload_validation_error_message').append('<label>HDMF Duplicate Entry: ' + HDMF +'</label><br>');
                        }
                        if(errors.mobile_no){
                            $('#error_alert').removeAttr('hidden');
                            $('#upload_validation_error_message').append('<label>Mobile Number Errors: ' + errors.mobile_no +'</label><br>');
                        }
                        if(errors.email_add){
                            $('#error_alert').removeAttr('hidden');
                            $('#upload_validation_error_message').append('<label>Email Address Duplicate Entry: ' + email_add +'</label><br>');
                        }
                    });
                }
            });
        }


        /*Edit Employees Upload Preview*/
        $('#preview_employee_details').on('click', '.btn_Edit_Employees_Preview', function (){
            var id = $(this).attr('data-id');

            /*Get All Employee Details*/
            let employee_details = {
                employee_no: $(this).attr('data-employee_no'),
                TIN: $(this).attr('data-tin'),
                SSSGSIS: $(this).attr('data-sssgsis'),
                PHIC: $(this).attr('data-phic'),
                HDMF: $(this).attr('data-hdmf'),
                NID: $(this).attr('data-nid'),
                mobile_no: $(this).attr('data-mobile_no'),
                email_add: $(this).attr('data-email_add')
            };

            console.log(employee_details);
            $('#employee_detail_id').val(id);
            $.each(employee_details, function(key, edit_employees_field_col_1){
                $('#edit_employees_field_col_1').append(`
                <div class="input-group input-group-sm mb-3">
                    <div class="col-md-12">
                        <label for="batch_no" style="font-family: Poppins !important;">`+key.charAt(0).toUpperCase() + key.slice(1)+`:</label>
                        <input type="text" name="`+key+`" id="`+key+`" value="`+edit_employees_field_col_1+`" class="form-control" placeholder="`+key+` ">
                    </div>
                </div>
                `);
            });
        });

        // Close Edit modal
        $('#edit_employees_details').on('hidden.bs.modal', function(e) {
            $('.input-group').remove();
        });

        // Update Employee Details Preview
        $('#save_edit_employee_details').click(function (e){
            e.preventDefault();
            toastr.remove()
            var formData = new FormData($('#edit_employee_details')[0]);
            $.ajax({
                url: '/EmployeesEnrollmentController/update_employees_details_preview',
                method: 'POST',
                async: false,
                dataType: 'json',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data){
                    console.log(data);
                    $("#upload_employees_preview_table").DataTable().destroy();
                    if(data.status == 'true'){
                        // Modal hide
                        setTimeout(function (){
                                $('#edit_employees_details').modal('hide');
                        }, 400);
                        // Display a success toast, with a title
                        toastr.success('Employee Details Updated', 'Success')
                        $('#edit_employee_details')[0].reset();
                        
                        showAllEmployeesDetailsPreview();
                        initDataTableEmployeePreview();
                         /*Redirect To Account*/
                         window.location.replace('{{ config('app.url') }}/enrollemployee/upload');
                        
                    }
                    
                },
                error: function(data){
                    console.log(data);
                    // Handle Errors
                    var errors = $.parseJSON(data.responseText);
                    console.log(errors.errors)
                    if(errors.errors){
                        $('#error_alert_upodate').removeAttr('hidden');
                        $('#update_validation_error_message').html('<hr><label>Employee No Already Taken</label><br>');
                    }
                    $.each(errors, function(i, errors){
                            // if(errors.employee_no){
                            //     $('#error_alert_upodate').removeAttr('hidden');
                            //     $('#update_validation_error_message').html('<hr><label>Employee No Duplicate Entry: ' + employee_no +'</label><br>');
                            // }
                            if(errors.TIN){
                                $('#error_alert_upodate').removeAttr('hidden');
                                $('#update_validation_error_message').html('<hr><label>' + errors.TIN +'</label><br>');
                            }
                            if(errors.SSSGSIS){
                                $('#error_alert_upodate').removeAttr('hidden');
                                $('#update_validation_error_message').html('<label>' + errors.SSSGSIS +'</label><br>');
                            }
                            if(errors.PHIC){
                                $('#error_alert_upodate').removeAttr('hidden');
                                $('#update_validation_error_message').html('<label>' + errors.PHIC +'</label><br>');
                            }
                            if(errors.HDMF){
                                $('#error_alert_upodate').removeAttr('hidden');
                                $('#update_validation_error_message').html('<label>' + errors.HDMF +'</label><br>');
                            }
                            if(errors.mobile_no){
                                $('#error_alert_upodate').removeAttr('hidden');
                                $('#update_validation_error_message').html('<label>' + errors.mobile_no +'</label><br>');
                            }
                            if(errors.email_add){
                                $('#error_alert_upodate').removeAttr('hidden');
                                $('#update_validation_error_message').html('<label>' + errors.email_add +'</label><br>');
                            }
                        });
                    }
                    
                //}
            });
        });

        // Delete Employee Preview
        $('#preview_employee_details').on('click', '.btn_delete_employee_preview', function() {
            var id = $(this).attr('data-id');
            toastr.remove()
            // Revmove current toasts using animation
            toastr.clear()
            swal({
                title: "Do you wanna Delete This?",
                type: "error",
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes",
                showCancelButton: true,
                closeOnConfirm: true,
            },
                function(){
                    $.ajax({
                        type: 'POST',
                        url: '/EmployeesEnrollmentController/delete_employee_details',
                        data: { id: id,
                            '_token': $('input[name=_token]').val(),
                        },
                        success: function(data){
                            if(data.status == 'true'){
                                toastr.success('Employee Details Deleted', 'Success')
                                $("#upload_employees_preview_table").DataTable().destroy();
                                showAllEmployeesDetailsPreview();
                                initDataTableEmployeePreview();
                            }
                            
                        },
                        error: function(data){
                            toastr.error('Error Deleting Employee')
                            console.log(data);
                        }
                    });
                }
            
            );
        });

        // Save Employee Preview
        $('#btnSaveEmployees').click(function (e){
            e.preventDefault();
            toastr.remove()
            // Remove current toasts using animation
            toastr.clear()
            swal({
                title: "Do you want to save this Employees?",
                type: 'info',
                confirmButtonClass: "btn-info",
                confirmButtonText: "Yes",
                showCancelButton: true,
                closeOnConfirm: true,
            },
                function(){
                    $.ajax({
                        type: 'POST',
                        url: '/EmployeesEnrollmentController/save_employees_preview',
                        data: {'_token': $('input[name=_token]').val()},
                        success: function(data){
                            console.log(data);
                            toastr.success('Employees Details Saved', 'Success')
                            $("#upload_employees_preview_table").DataTable().destroy();
                            showAllEmployeesDetailsPreview();
                            initDataTableEmployeePreview();
                        },
                        error: function(data){
                            console.log(data);
                        }
                    });
                }
            );
        });


    });
</script>
@endsection