@extends('layouts.master')

@section('crumb')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="m-0 text-dark">Payroll Management</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
                <a href="#">Payroll Management</a>
            </li>
            <li class="breadcrumb-item active">View Payroll Register</li>
        </ol>
    </div>
</div>
@endsection
@section('content')
@php
if(Session::get('create_profile') == 'all'){
    $add = '';
    $edit = '';
    $delete = '';
}
elseif(Session::get('create_profile') == 'view'){
    $add = 'disabled';
    $edit = 'disabled';
    $delete = 'disabled';
}
elseif(Session::get('create_profile') == 'add'){
    $add = '';
    $edit = 'disabled';
    $delete = 'disabled';
}
elseif(Session::get('create_profile') == 'edit'){
    $add = '';
    $edit = '';
    $delete = 'disabled';
}
elseif(Session::get('create_profile') == 'delete'){
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
    <div class="card card-info card-outline">
        <div class="card-header">
            <center><strong>View Payroll Register</strong></center>
        </div>
        <div class="card-body">

            <div class="form-group row">
                <div class="col-md-6">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="fa fa-search input-group-text" style="background-color: #fff;"></span>
                        </div>
                        <input type="text" id="searchbox" class="form-control" placeholder="Search">
                    </div>
                </div>
                <div class="col-md-6">
                    {{-- <a href="#" class="btn btn-secondary float-md-right mr-4"><i class="fa fa-file"></i> Generate Template</a> --}}
                    <button class="btn btn-primary float-md-right mr-4" id="upload_payroll_register" data-toggle="modal" data-target="#upload_payroll_register_modal"><i class="fa fa-upload"></i> Upload Payroll Register</button>
                </div>
            </div>  
            
            <table id="payroll_register_table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Period From</th>
                        <th>Period To</th>
                        <th>Batch No</th>
                        <th>Payroll Schedule</th>
                        <th>File</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="showdata">

                </tbody>
            </table>
        </div>              
    </div>      
</div>

<!-- Modal For Upload Profile Picture-->
<div class="modal fade" id="upload_payroll_register_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
	  <div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title" id="exampleModalLabel">Upload Payroll</h5>
		  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		  </button>
		</div>
		<div class="modal-body">
            @foreach($Employees_upload_template as $employees_template)
                <a href="/storage/Documents/templates/{{$employees_template->document_file}}" download>{{$employees_template->document_code}}<div class="float-left mr-3"><i class="fa fa-download"></i></div></a>
            @endforeach
		  <form id="upload_payroll" runat="server">
			  @csrf
			  {{-- <div class="col-md-4 offset-md-4 mb-3">
					<img class="img-thumbnail" id="image_preview" alt="your image" />
              </div> --}}
              <div class="col-md-12">
                <div class="input-group">
                    <label for="batch_no">Batch No:</label>
					<div class="col-md-12">
                        <input class="form-control" type="text" name="batch_no" id="batch_no" placeholder="Batch No">
                    </div>
                    <label for="batch_no">Payroll Schedule:</label>
                    <div class="col-md-12">
                        <select class="form-control" id="payroll_schedule" name="payroll_schedule">
                            <option value="">Select Options</option>
                                <option value="Weekly">Weekly</option>
                                <option value="Monthly">Monthly</option>
                                <option value="2xMonthly">2x Monthly</option>                                            
                        </select>
                    </div>
				</div>  
              </div>
              <br>
			<div class="col-md-12">
				<div class="input-group mb-3">
					<div class="input-group-prepend">
						<span class="fa fa-folder input-group-text"></span>
					</div>
					<div class="custom-file">
						<input type="file" class="custom-file-input" id="payroll_file" name="file" multiple onchange="processSelectedFilesProfileImage(this)">
						<label class="custom-file-label" for="validatedCustomFile" id="profile_image_filename">Choose file...</label>
					</div>
				</div>
					
			</div>
		  
		</div>
		<div class="modal-footer">
		  {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
		  <button type="submit" class="btn btn-primary" id="Upload"><span><i class="fa fa-upload"></i></span> Upload <i id="spinner" class=""></button>
		</div>
		</form>
	  </div>
	</div>
  </div>
<script type="text/javascript">
    $(document).ready(function () {
        /*
         * Functions
         */
         showAllPayRegister();
         initDataTable();
        
        function initDataTable(){
        /*DataTable*/ 
        var table = $("#payroll_register_table").DataTable({
          // "searching": false,
          "sDom": '<"customcontent">rt<"row"<"col-lg-6" i><"col-lg-6" p>><"clear">',
          "paging": true,
          "pageLength": 10000,
           scrollY: 500,
          //  scrollX: true,
          "autoWidth": true,
          lengthChange: false,
          responsive: true,
          fixedColumns: true,
          "order": [[4, "asc"]]
        }); 
        /*Custom Search For DataTable*/
        $("#searchbox").on("keyup search input paste cut", function () {
                table.search(this.value).draw();
        });
      }

       /*
        * Upload Payroll Register
        */
       $('#upload_payroll').submit(function (e){
        $("#spinner").addClass('fa fa-refresh fa-spin');
        toastr.remove()
           console.log("TEST");
           $('#upload_payroll_register_modal').modal('show');
           e.preventDefault();
            var formData = new FormData($(this)[0]);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
           $.ajax({
                url: "{{ url('/payrollmanagement/upload_payregister') }}",
                type: 'POST',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function() {
                    toastr.success('Payroll Register Uploaded!')
                    console.log("Success");
                    $("#payroll_register_table").DataTable().destroy();
                    showAllPayRegister();
                    initDataTable();
                    //Close Modal
                    //$('#upload_payroll_register_modal').modal('hide');
                    setTimeout(function (){
                            $("#spinner").removeClass('fa fa-refresh fa-spin');
                        }, 250);
                    // Hide Modal
                    setTimeout(function (){
                        $('#upload_payroll_register_modal').modal('hide');
                    }, 550);
                },
                error: function(data, status){
                    setTimeout(function (){
                                $("#spinner").removeClass('fa fa-refresh fa-spin');
                    }, 250);
                    //console.log("ERROR");
                    if(data.status === 422) {
                        //console.log("422");
                        var errors = $.parseJSON(data.responseText);
                        //console.log(errors.errors.accountname);
                        $.each(errors, function (i, errors) {
                            if(errors.batch_no){
                                //console.log(errors.batch_no);
                                toastr.error(errors.batch_no);
                                $('#batch_no').addClass('is-invalid');
                            }
                        });
                    }
                }
           });
       });

       /*
        * Post Payroll Register
        */
       $('#showdata').on('click', '#post_payroll_register', function(){
            var id = $(this).attr('data-id');
            toastr.remove()
            swal({
                title: "Do you wanna post this payroll?",
                //type: "error",
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes",
                showCancelButton: true,
                closeOnConfirm: true,
            },
                function(){
                    $.ajax({
                        type: 'POST',
                        url: '/payrollmanagement/post_payroll_register',
                        data: {
                            '_token': $('input[name=_token]').val(),
                            id: id,
                        },
                        success: function(data) {
                            toastr.success('Payroll Successfully Posted')
                            $("#payroll_register_table").DataTable().destroy();
                            /**ReInitialize Table*/
                            showAllPayRegister();
                            initDataTable();
                        },
                        error: function(data) {
                            console.log("ERROR");
                        }
                    });
                }
            );
       });

       

       /*
        * Get Payroll Register Details
        */
       function showAllPayRegister(){
          $.ajax({
            type: 'GET',
            url: '/payrollmanagement/get_payroll_register',
            async: false,
            dataType: 'json',
            success: function(data){
              var html = '';
              var i;
              for(i=0; i<data.length; i++){
                var AccountStatus = (data[i].account_status == 1 ? '<span class="badge badge-success">'+"Posted"+'</span>' : data[i].account_status == 0 ? '<span class="badge badge-warning">'+"Pending"+'</span>' : null);
                const period_from = new Date(data[i].period_from);
                const period_to = new Date(data[i].period_to);
                html +='<tr>'+
                        '<td>'+period_from.toDateString()+'</td>'+
                        '<td>'+period_to.toDateString()+'</td>'+
                        '<td>'+data[i].batch_no+'</td>'+
                        '<td>'+data[i].payroll_schedule_id+'</td>'+
                        '<td>'+'<a href="/Storage/employees/'+data[i].payroll_file+'" {{$edit}}>'+data[i].payroll_file+ '<div class="float-right"><i class="fa fa-download"></i></div>'+'</a> ' +'</td>'+
                        '<td>'+AccountStatus+'</td>'+
                        '<td>' + 
                            '<a href="#post" class="btn btn-secondary '+(data[i].account_status == 1 ? 'disabled' : data[i].account_status == 0 ? '' : null)+'" data-id="'+data[i].id+'" id="post_payroll_register" {{$edit}}>POST</a> ' +
                        '</td>'+
                        '</tr>';

              }
                $('#showdata').html(html);
              console.log("TEST");
            },
            error: function(){
              console.log('Could not get data from database');
            }
          });
        }
    });
</script>
@endsection
