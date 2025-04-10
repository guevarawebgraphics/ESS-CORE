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
            <li class="breadcrumb-item active-payrollregister text-secondary">View Payroll Register</li>
        </ol>
    </div>
</div>
@endsection
@section('content')
@php
if(Session::get('payroll_management') == 'all'){
    $add = '';
    $edit = '';
    $delete = '';
}
elseif(Session::get('payroll_management') == 'view'){
    $add = 'disabled';
    $edit = 'disabled';
    $delete = 'disabled';
}
elseif(Session::get('payroll_management') == 'add'){
    $add = '';
    $edit = 'disabled';
    $delete = 'disabled';
}
elseif(Session::get('payroll_management') == 'edit'){
    $add = '';
    $edit = '';
    $delete = 'disabled';
}
elseif(Session::get('payroll_management') == 'delete'){
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
                    {{-- <button class="btn btn-outline-primary btn-flat float-md-right mr-4 {{$add}}" id="upload_payroll_register" data-toggle="modal" data-target="#upload_payroll_register_modal"><i class="fa fa-upload"></i> Upload Payroll Register</button> --}}
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
	  <div class="modal-content card-info card-outline">
		<div class="modal-header">
		  <h5 class="modal-title" id="exampleModalLabel">Upload Payroll</h5>
		  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		  </button>
		</div>
		<div class="modal-body">
            @foreach($Employees_upload_template as $employees_template)
                <a href="/storage/Documents/templates/{{$employees_template->document_file}}" download>{{$employees_template->document_code}}<div class="float-left mr-3"><i class="fa fa-download"></i></div></a>
                <input type="hidden" id="defaultfile" value="{{$employees_template->document_file}}">
            @endforeach
		  <form class="payroll_form" id="upload_payroll" runat="server">
			  @csrf
              <div class="col-md-12">
                <div class="input-group">
                    <label for="batch_no">Batch No:</label>
					<div class="col-md-12"> 
                        
                        <input class="form-control " type="text" name="batch_no" id="batch_no" placeholder="Batch No">
                    </div>  
                    <div class="col-md-6"> 
                            <label for="Period From">Period From:</label>
                            <input class="form-control datepicker" type="text" name="period_from" id="period_from" placeholder="YYYY-MM-DD" autocomplete="off">
                    </div>
                    <div class="col-md-6"> 
                            <label for="Period To">Period To:</label>
                            <input class="form-control datepicker" type="text" name="period_to" id="period_to" placeholder="YYYY-MM-DD" autocomplete="off">
                    </div>
                    <label for="batch_no">Payroll Schedule:</label>
                    <div class="col-md-12">
                        <select class="form-control " id="payroll_schedule" name="payroll_schedule">
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
						<input type="file" class="custom-file-input" id="payroll_file" name="file" multiple onchange="processSelectedFilesPayrollFile(this)">
						<label class="custom-file-label" for="validatedCustomFile" id="payroll_filename">Choose file...</label>
					</div>
				</div>
					
			</div>
        
		</div>
		<div class="modal-footer">
		  {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
		  <button type="submit" class="btn btn-outline-primary btn-flat btn-payroll-upload" id="Upload" data-file=""><span><i class="fa fa-upload"></i></span> Upload <i id="spinner_upload_payroll" class=""></button>
		</div>
		</form>
	  </div>
	</div>
  </div>
<script type="text/javascript">
    /*Function to get Filename*/
    function processSelectedFilesPayrollFile(fileInput) {
            var files = fileInput.files;

            for (var i = 0; i < files.length; i++) {
                if(files[i].name.length > 50){
                    $('#payroll_filename').html(files[i].name.substr(0,50));
                }
                else {
                    $('#payroll_filename').html(files[i].name);
                }
                $("#Upload").attr('data-image',files[i].name.toLowerCase()); 
                $("#Upload").attr('data-file',files[i].name);
            } 
        }
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
          "pageLength": 10,
           scrollY: 500,
          //  scrollX: true,
          "autoWidth": true,
          lengthChange: false,
          responsive: true,
          fixedColumns: true,
          "order": [[6, "desc"]]
        }); 
        /*Custom Search For DataTable*/
        $("#searchbox").on("keyup search input paste cut", function () {
                table.search(this.value).draw();
        });
      }

      $('#upload_payroll_register').click(function(e){
        e.preventDefault();
        $('#upload_payroll_register_modal').modal('show');
        $('.btn-payroll-upload').removeAttr('disabled');
        $('.btn-payroll-upload').attr('type', 'submit');
      });

       /*
        * Upload Payroll Register
        */
       $('#upload_payroll').submit(function (e){
            $('.btn-payroll-upload').attr('disabled', true);
            toastr.remove()
           console.log("TEST");
           e.preventDefault();
            var formData = new FormData($(this)[0]);
            var file = $("#payroll_file").val(); 
             if(fileValidate()==false) 
            {
                toastr.error("Please upload appropriate template"); 
                setTimeout(function (){
                            $("#spinner_upload_payroll").removeClass('fa fa-refresh fa-spin');
                            $('.btn-payroll-upload').removeAttr('disabled');
                        }, 250);
            } 
            if($('#batch_no').val()=="")
            {
                toastr.error("Batch no is required");  
                setTimeout(function (){
                            $("#spinner_upload_payroll").removeClass('fa fa-refresh fa-spin');
                            $('.btn-payroll-upload').removeAttr('disabled');
                        }, 250);
            }
            if($('#payroll_schedule').val()=="")
            {
                toastr.error("Payroll schedule is required");  
                setTimeout(function (){
                            $("#spinner_upload_payroll").removeClass('fa fa-refresh fa-spin');
                            $('.btn-payroll-upload').removeAttr('disabled');
                        }, 250);
            }
            if($('#period_from').val()=="")
            {
                toastr.error("Period From is required");  
                setTimeout(function (){
                            $("#spinner_upload_payroll").removeClass('fa fa-refresh fa-spin');
                            $('.btn-payroll-upload').removeAttr('disabled');
                        }, 250);
            }
            if($('#period_to').val()=="")
            {
                toastr.error("Period To is required");  
                setTimeout(function (){
                            $("#spinner_upload_payroll").removeClass('fa fa-refresh fa-spin');
                            $('.btn-payroll-upload').removeAttr('disabled');
                        }, 250);
            }
            if($('#batch_no').val()=="" || $('#payroll_schedule').val()=="" || fileValidate()==false) 
            {
                return false;
            }
            
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
                global: false,
                beforeSend: function(){
                    $("#spinner_upload_payroll").addClass('fa fa-refresh fa-spin'); 
                    $('.btn-payroll-upload').removeAttr('type');
                },
                complete: function() {
                    setTimeout(function (){
                            $("#spinner_upload_payroll").removeClass('fa fa-refresh fa-spin');
                    }, 250);
                    $('#Upload').removeAttr('disabled');
                },
                success: function(data) {
                    toastr.success('Payroll Register Uploaded!')
                    console.log("Success");
                    $("#payroll_register_table").DataTable().destroy();
                    showAllPayRegister();
                    initDataTable();
                    setTimeout(function (){
                            $("#spinner_upload_payroll").removeClass('fa fa-refresh fa-spin');
                        }, 250);
                    // Hide Modal
                    setTimeout(function (){
                        $('#upload_payroll_register_modal').modal('hide');
                        $('#upload_payroll')[0].reset();
                    }, 400);
                    // Preview Data
                    $.each(data, function (i, data) { 
                        console.log(data[0]['employeeno']);
                    });
                },
                error: function(data, status){
                    $('.btn-payroll-upload').removeAttr('disabled');
                    setTimeout(function (){
                                $("#spinner_upload_payroll").removeClass('fa fa-refresh fa-spin');
                    }, 250);
                    if(data.status === 422) {
                        var errors = $.parseJSON(data.responseText);
                        $.each(errors, function (i, errors) {
                            if(errors.batch_no){
                                toastr.error(errors.batch_no);
                                $('#batch_no').addClass('is-invalid'); 
                             
                            } 
                           if(errors.payroll_schedule){
                                toastr.error(errors.payroll_schedule);
                                $('#payroll_schedule').addClass('is-invalid'); 
                      
                            }
                        });
                    }
                }
           });
       });  
       function fileValidate() 
       { 
        var default_file = $("#defaultfile").val();
        var file = $("#payroll_file").val();  
        if(file.substring(12) !==default_file){
                return false;
            }

       }
       
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
                        global: false,
                        beforeSend: function(){
                            $('#post_payroll_register').attr('disabled', true);
                            /*
                            *@ NProgress Loading
                            **/
                            NProgress.start();
                            NProgress.set(0.6);     // Sorta same as .start()
                            NProgress.configure({ easing: 'ease', speed: 600 });
                            NProgress.configure({ showSpinner: false });//Turn off loading 
                        },
                        success: function(data) {
                            toastr.success('Payroll Successfully Posted')
                            $("#payroll_register_table").DataTable().destroy();
                            /**ReInitialize Table*/
                            showAllPayRegister();
                            initDataTable();
                            NProgress.set(0.8);
                            NProgress.done(true);
                        },
                        error: function(data) {
                            console.log("ERROR");
                            NProgress.done(true);
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
                        '<td>'+'<a href="/payrollmanagement/PayrollExport/'+data[i].id+'" class="export_batch_csv_file" data-batch_no="'+data[i].batch_no+'" {{$edit}}>'+data[i].payroll_file+ '<div class="float-right"><i class="fa fa-download"></i></div>'+'</a> ' +'</td>'+
                        '<td>'+AccountStatus+'</td>'+
                        '<td>' + 
                            '<a href="#post" class="btn btn-outline-secondary btn-flat {{$add}} '+(data[i].account_status == 1 ? 'disabled' : data[i].account_status == 0 ? '' : null)+'" data-id="'+data[i].id+'" id="post_payroll_register" {{$edit}}>POST</a> ' +
                        '</td>'+
                        '</tr>';

              }
                $('#showdata').html(html);
              //console.log("TEST");
            },
            error: function(){
              console.log('Could not get data from database');
            }
          });
        } 

        // $('#showdata').on('click', '.export_batch_csv_file', function(){
        //     var batch_no = $(this).attr('data-batch_no');
        //     /*AjaxSetup*/
        //     $.ajaxSetup({
        //     headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         }
        //     });;
        //     $.ajax({
        //         type: 'GET',
        //         url: '/payrollmanagement/PayrollExport',
        //         data: {batch_no, '_token': $('input[name=_token]').val()},
        //         success: function(data) {
        //             console.log(data);
        //         },
        //         error: function(data)  {
        //             console.log(data);
        //         }
        //     });
        // });



            var date = new Date();
            date.setDate(date.getDate());
            $('#period_to').datepicker({
                autoclose: true,
            }); 
            $('#period_from').datepicker({
                autoclose: true,
            }); 
    });
</script>
@endsection
