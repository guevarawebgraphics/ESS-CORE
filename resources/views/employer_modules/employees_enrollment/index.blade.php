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
            <li class="breadcrumb-item active-employees text-secondary">Encode Employees</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="card card-custom-blue card-outline">
        <div class="card-header">
            <h3 class="card-title"><i class="fa fa-edit"></i> Encode Employees</h3>
        </div>
        <div class="card-body">
            <div class="form-group row">
                {{-- <label for="address_zipcode" class="col-md-2 text-md-center">Search: </label> --}}
                <div class="col-md-6">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="fa fa-search input-group-text" style="background-color: #fff"></span>
                        </div>
                        <input id="searchbox" type="text" class="form-control" name="searchbox" placeholder="Search" autofocus>
                    </div>
                </div>
                <div class="col-md-6">
                    <a href="/enrollemployee/encode" class="btn btn-outline-primary btn-flat float-md-right mr-4" id="btnCreateEmployee"><i class="fa fa-plus-square" ></i> Encode Employee</a>
                    <a href="#upload" class="btn btn-outline-info btn-flat float-md-right mr-4" id="btnUploadEmployee"><i class="fa fa-upload" ></i> Upload Employee</a>
                </div>
            </div>

            <table class="table table-bordered table-striped" id="employee_table">
                <thead>
                    <tr>
                        <th>Employee No</th>
                        <th>Employee Name</th>
                        <th>Department</th>
                        <th>Position</th>
                        <th>Status</th>
                        <th>Change Status</th>
                        <th>Action</th>                 
                    </tr>
                </thead>
                <tbody>
                    @if(count($employee_info) > 0)
                        @foreach($employee_info as $info)
                        <tr>
                            <td>{{$info->employee_no}}</td>
                            <td>{{ucfirst($info->lastname) . ", " . ucfirst($info->firstname) . " " . ucfirst($info->middlename)}}</td>
                            <td>{{ucfirst($info->department)}}</td>
                            <td>{{ucfirst($info->position)}}</td>
                            <td>
                                @if($info->AccountStatus == 1)
                                    <span class="badge badge-success">Active</span>
                                @endif
                                @if($info->AccountStatus == 2)
                                    <span class="badge badge-secondary">In-Active</span>
                                @endif
                                @if($info->AccountStatus == 3)
                                    <span class="badge badge-danger">Deactivated</span>
                                @endif
                                @if($info->AccountStatus == 0)
                                    <span class="badge badge-danger">Deleted</span>
                                @endif
                            </td>
                            <td>
                                <button class="CS btn btn-sm btn-outline-info btn-flat" id="change_status" data-id="{{$info->emp_id}}">Change Status</button>
                            </td>
                            <td>
                                <a href="/enrollemployee/edit/{{$info->eneid}}" class="btn btn-sm btn-outline-primary btn-flat" id="btn_editemployee"><i class="fa fa-edit"></i>Edit Employee</a>
                            </td>
                        </tr>
                        @endforeach
                    @else
                    @endif
                </tbody>
            </table>       
        
        </div>
    </div>      
</div>

<!-- Modal For Change Status -->
<div class="modal fade" id="csModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content card-custom-blue card-outline">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel" >Change Status</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="text" id="account_id" hidden>
          <select class="form-control col-md-4" name="AccountStatus" id="AccountStatus">
            <option value="" selected>Changed Status</option>
            <option value="1">Active</option>
            <option value="2">In-Active</option>
            <option value="3">Deactivated</option>
          </select>
          <p class="text-danger" id="error_cs" hidden>Please Choose Option</p>
          <label id="CS-id"></label>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-info btn-flat" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-outline-primary btn-flat" id="ChangeStatusConfirm">Confirm <i id="spinner" class=""></button>
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
<script type="text/javascript">
    /*Function to get Filename*/
    function processSelectedFilesUploadEmployees(fileInput) {
        var files = fileInput.files;

        for (var i = 0; i < files.length; i++) {
                $('#upload_image_file').html(files[i].name);
        }
    }
    $(document).ready(function () {
         initDataTable();
         function initDataTable(){
            /*DataTable*/ 
            var table = $("#employee_table").DataTable({
                // "searching": false,
                "sDom": '<"customcontent">rt<"row"<"col-lg-6" i><"col-lg-6" p>><"clear">',
                "paging": true,
                "pageLength": 10,
                "ordering": false,
                scrollY: 500,
                //  scrollX: true,
                "autoWidth": true,
                lengthChange: false,
                responsive: true,
                fixedColumns: true,
            }); 
            /*Custom Search For DataTable*/
            $("#searchbox").on("keyup search input paste cut", function () {
                    table.search(this.value).draw();
            });
       }


      //function Refresh User table
      function refreshUserTable() {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "/enrollemployee/refresh_table_employee",
                method: "GET",
                data: {},
                success: function (data) {
                    $("#employee_table").DataTable().destroy();
                    $('#employee_table').html(data);
                    initDataTable();
                }
            });
        }

        $("#employee_table").on('click', '.CS', function(){
            $('#csModal').modal('show');
            var id = $(this).attr("data-id");
            $('#account_id').val(id);
            toastr.remove()
            console.log(id);
        });
         //Change Status
         $('#ChangeStatusConfirm').click(function (){
          $("#spinner").addClass('fa fa-refresh fa-spin');
          let Account_id = $('#account_id').val();
          let AccountStatus = $('#AccountStatus').val();
          toastr.remove()
          $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
          });
            if (AccountStatus == ""){
              $('#AccountStatus').addClass('is-invalid');
              $('#error_cs').removeAttr('hidden');
              toastr.error('Error. Please Choose a Option', 'Error!')
                setTimeout(function (){
                        $("#spinner").removeClass('fa fa-refresh fa-spin');
                  }, 250);
            }
            else {
              $.ajax({
                    url: "/enrollemployee/UpdateAccountStatus/" + Account_id,
                    method: 'PATCH',
                    async: false,
                    dataType: 'json',
                    data: {
                      AccountStatus: $('#AccountStatus').val(),
                      _token:     '{{ csrf_token() }}'
                    },
                    success: function (data, response){
                      refreshUserTable();
                      //Set the dropdown to the default selected
                      $('#AccountStatus option[value=""]').prop('selected', true);
                      //console.log('Success');
                      // Display a success toast, with a title
                      toastr.success('Account Updated Successfully', 'Success')
                      setTimeout(function (){
                            $("#spinner").removeClass('fa fa-refresh fa-spin');
                        }, 250);
                        // Hide Modal
                        setTimeout(function (){
                          $('#csModal').modal('hide');
                        }, 550);
                    },
                    error: function (data, e){
                      if(data.status == 500){
                        //console.log('Error');
                        toastr.error('Error. Please Choose a Option', 'Error!')
                        setTimeout(function (){
                                $("#spinner").removeClass('fa fa-refresh fa-spin');
                          }, 250);
                      }
                    }
                });
            }
        });

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

        // $('#btn_upload').click(function(){
        //     $("#spinner_upload").addClass('fa fa-refresh fa-spin');
        // });
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
                url: "{{ url('/enrollemployee/upload_employees') }}",
                type: 'POST',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (){
                    refreshUserTable();
                    $('#upload_employees_form')[0].reset();
                    $('#UploadEmployees').modal('hide');
                    toastr.success('Account Employees Created Successfully', 'Success')
                    //console.log("Success");
                    setTimeout(function (){
                            $("#spinner_upload").removeClass('fa fa-refresh fa-spin');
                        }, 300);
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
                            //$('#ttttt').append('<li><label class="text-danger" id="error_fields"> * '+errors+'</label></li></br>');
                           /**
                            * @ Temporary Fix
                            **/
                            for (i = 0; i < errors.length; i++){
                                if(errors[i]){
                                    //$('#ttttt').html('<li><label class="text-danger" id="error_fields">'+errors[i]+'</label></li></br>');
                                    // $('#ttttt').html('<li><label class="text-danger" id="error_fields"> * Please Double Check Your Upload File</label></li></br>')
                                }
                            }
                            // for (let test of errors) {
                            //     console.log(test);
                            // }
                            //onsole.log(errors.error);
                            var ssssq = Object.values(errors);
                            //console.log(ssssq.splice(26, 0));
                            /**/
                            var sparseKeys = Object.keys(errors);
                            //console.log(sparseKeys);
                            for (let [key, value] of Object.entries(errors)) {
                                //if(errors){
                                    //$('#error_fields').html(errors);
                                    //$('#error_fields').attr('hidden', false);
                                    //$('#ttttt').html('<li><label class="text-danger" id="error_fields">'+value+'</label></li></br>');
                               // }
                                //console.log(`${key}: ${value}`);
                            }
                        });
                    }
                }
            });

        });
    });
</script>
@endsection


