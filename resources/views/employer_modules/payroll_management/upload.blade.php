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
            <li class="breadcrumb-item active-upload-payrollregister text-secondary">Upload Payroll Register</li>
        </ol>
    </div>
</div>
@endsection
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
            <center><strong>Upload Payroll Register</strong></center>
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
                    <br>
                    <div class="alert alert-danger" id="error_alert" hidden="true">
                            <span><i class="fa fa-exclamation-circle"></i> <b>Errors</b></span>
                        <ul>
                            <div id="upload_validation_error_message"></div>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6">
                        {{-- <button class="btn btn-outline-primary btn-flat float-md-right mr-4 {{$add}}" id="save_payroll_register" data-toggle="modal" data-target="#"><i class="fa fa-upload"></i> Save Payroll Register</button> --}}
                        <button type="button" class="btn btn-outline-primary btn-flat float-md-right mr-4 {{$add}}" id="btn_save_payroll"><i class="fa fa-upload"></i> Save Payroll Register</button>
                        <button class="btn btn-outline-info btn-flat float-md-right mr-4 {{$add}}" id="upload_payroll_register" data-toggle="modal" data-target="#upload_payroll_register_modal"><i class="fa fa-upload"></i> Upload Payroll Register</button>
                </div>
            </div>  
            {{-- <h5 class="text-center">Upload Payroll Register Preview</h5> --}}
            {{-- <form action="/payrollmanagement/PayrollExport" method="GET">
                @csrf
                <button class="btn btn-outline-info btn-flat" type="submit">Download File</button>
            </form> --}}
            <div class="table-responsive">
                    <table id="payroll_register_table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>EMPLOYEE NO</th>
                                    {{-- <th>DEPARTMENT</th>
                                    <th>POSITION</th> --}}
                                    <th>BASIC</th>
                                    <th>ABSENT</th>
                                    <th>LATE</th>
                                    <th>UNDERTIME</th>
                                    <th>REGULAROT</th>
                                    <th>LEGAL HOLIDAY</th>
                                    <th>SPECIAL NON WORKING HOLIDAY</th>
                                    <th>NIGHT DIFF</th>
                                    <th>ADJUSTMENT SALARY</th>
                                    <th>NIGHT DIFF OT</th>
                                    <th>INCENTIVE</th>
                                    <th>COMMISIONS</th>
                                    <th>NET BASIC TAXABLE INCOME</th>
                                    <th>NON TAXABLE ALLOWANCE</th>
                                    <th>RICE ALLOWANCE</th>
                                    <th>MEAL ALLOWANCE</th>
                                    <th>TELECOM</th>
                                    <th>TRANSPO</th>
                                    <th>ECOLA</th>
                                    <th>GROSS PAY</th>
                                    <th>SSS</th>
                                    <th>PHIC</th>
                                    <th>HDMF</th>
                                    <th>WTAX</th>
                                    <th>SSS LOAN</th>
                                    <th>BANK LOAN</th>
                                    <th>CASH ADVANCE</th>
                                    <th>TOTAL DEDUCTION</th>
                                    <th>NET PAY</th>
                                    <th>BANK ACCOUNT NO</th>
                                    {{-- <th>PAYROLL RELEASE DATE</th> --}}
                                    <th>OVERTIME HOURS</th>
                                    <th>ABSENCES DAYS</th>
                                    <th>EDIT</th>
                                </tr>
                            </thead>
                            <form id="submit_payroll_form">
                                @csrf
                                <tbody id="previewdata">
                                    
                                </tbody>
                            </form>
                        </table>
            </div>
        </div>              
    </div>      
</div>


<!-- Modal For Upload Upload Payroll-->
<div class="modal fade" id="upload_payroll_register_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
	  <div class="modal-content card-custom-blue card-outline">
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
		  <button type="submit" class="btn btn-outline-primary btn-flat btn-payroll-upload" id="Upload"><span><i class="fa fa-upload"></i></span> Upload</button>
		</div>
		</form>
	  </div>
	</div>
  </div>


  <!-- Modal For Save Payroll-->
<div class="modal fade" id="save_payroll_register_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
	  <div class="modal-content card-custom-blue card-outline">
		<div class="modal-header">
		  <h5 class="modal-title" id="exampleModalLabel">Save Payroll</h5>
		  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		  </button>
		</div>
		<div class="modal-body">
        <div class="alert alert-danger" id="save_payroll_errors" hidden="true">
                <span><i class="fa fa-exclamation-circle"></i> <b>Errors</b></span>
            <ul>
                <div id="save_validation_error_message"></div>
            </ul>
        </div>         
        <form id="save_payroll_form">
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
        
		</div>
		<div class="modal-footer">
		  {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
		  <button type="submit" class="btn btn-outline-primary btn-flat" id="btn_submit_payroll" data-file=""><span><i class="fa fa-upload"></i></span> Save <i id="spinner_save_payroll" class=""></button>
		</div>
		</form>
	  </div>
	</div>
  </div>



    <!-- Modal For Upload Edit Payroll Register Details-->
<div class="modal fade" id="edit_payroll_register_details_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content modal-lg">
            <div class="modal-header card-custom-blue card-outline">
              <h5 class="modal-title" id="exampleModalLongTitle">Edit Payroll Register Details</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form id="edit_payroll_details">
                  @csrf
                  <div class="row">
                    <div class="col-md-6" id="edit_payroll_field_col_1">
                    </div>
                    <div class="col-md-6" id="edit_payroll_field_col_2">
                    </div>
                  </div>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-outline-secondary btn-flat" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-outline-primary btn-flat" id="save_edit_payroll_register_details">Save changes</button>
            </div>
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
    $(document).ready(function (){
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
          scrollX: true,
          "autoWidth": true,
          lengthChange: false,
          responsive: true,
          fixedColumns: true,
          "order": [[4, "desc"]]
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
            if(fileValidate()==false) 
            {
                return false;
            }
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
           $.ajax({
                url: "{{ url('/payrollmanagement/upload_payroll_preview') }}",
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
                    //console.log("Success");
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
                        $('#Upload').removeAttr('disabled');
                    }, 400);
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
        * Get Payroll Register Details
        */
        function showAllPayRegister(){
          $.ajax({
            type: 'GET',
            url: '/payrollmanagement/get_payroll_register_details_preview',
            async: false,
            dataType: 'json',
            success: function(data){
              var html = '';
              var i;
              for(i=0; i<data.length; i++){
                check_employee_no(data[i].employee_no);
                check_duplicate_entry(data[i].employee_no);
                var AccountStatus = (data[i].account_status == 1 ? '<span class="badge badge-success">'+"Posted"+'</span>' : data[i].account_status == 0 ? '<span class="badge badge-warning">'+"Pending"+'</span>' : null);
                const period_from = new Date(data[i].period_from);
                const release_payroll_date = new Date(data[i].payroll_release_date);
                html += '<form id="preview_details">'+
                        '<tr>'+
                        '<td><input class="form-control custom-table-input employee_no preview_data_details'+data[i].id+'" type="text" name="employee_no" value="'+data[i].employee_no+'" class=" "  hidden="true">'+data[i].employee_no+'</td>'+
                        '<td><input class="preview_data_details'+data[i].id+'" type="number" name="basic" value="'+data[i].basic+'" class="form-control custom-table-input basic"  hidden="true">'+data[i].basic+'</td>'+
                        '<td><input class="preview_data_details'+data[i].id+'" type="number" name="absent" value="'+data[i].absent+'" class="form-control custom-table-input absent"  hidden="true">'+data[i].absent+'</td>'+
                        '<td><input class="preview_data_details'+data[i].id+'" type="number" name="late" value="'+data[i].late+'" class="form-control custom-table-input late"  hidden="true">'+data[i].late+'</td>'+
                        '<td><input class="preview_data_details'+data[i].id+'" type="number" name="undertime" value="'+data[i].undertime+'" class="form-control custom-table-input undertime"  hidden="true">'+data[i].undertime+'</td>'+
                        '<td><input class="preview_data_details'+data[i].id+'" type="number" name="regular_ot" value="'+data[i].regular_ot+'" class="form-control custom-table-input regular_ot"  hidden="true">'+data[i].regular_ot+'</td>'+
                        '<td><input class="preview_data_details'+data[i].id+'" type="number" name="legal_holiday" value="'+data[i].legal_holiday+'" class="form-control custom-table-input legal_holiday"  hidden="true">'+data[i].legal_holiday+'</td>'+
                        '<td><input class="preview_data_details'+data[i].id+'" type="number" name="special_holiday" value="'+data[i].special_holiday+'" class="form-control custom-table-input special_holiday"  hidden="true">'+data[i].special_holiday+'</td>'+
                        '<td><input class="preview_data_details'+data[i].id+'" type="number" name="night_differencial" value="'+data[i].night_differencial+'" class="form-control custom-table-input night_differencial"  hidden="true">'+data[i].night_differencial+'</td>'+
                        '<td><input class="preview_data_details'+data[i].id+'" type="number" name="adjustment_salary" value="'+data[i].adjustment_salary+'" class="form-control custom-table-input adjustment_salary"  hidden="true">'+data[i].adjustment_salary+'</td>'+
                        '<td><input class="preview_data_details'+data[i].id+'" type="number" name="night_diff_ot" value="'+data[i].night_diff_ot+'" class="form-control custom-table-input night_diff_ot"  hidden="true">'+data[i].night_diff_ot+'</td>'+
                        '<td><input class="preview_data_details'+data[i].id+'" type="number" name="incentives" value="'+data[i].incentives+'" class="form-control custom-table-input incentives"  hidden="true">'+data[i].incentives+'</td>'+
                        '<td><input class="preview_data_details'+data[i].id+'" type="number" name="commision" value="'+data[i].commision+'" class="form-control custom-table-input commision"  hidden="true">'+data[i].commision+'</td>'+
                        '<td><input class="preview_data_details'+data[i].id+'" type="number" name="net_basic_taxable" value="'+data[i].net_basic_taxable+'" class="form-control custom-table-input net_basic_taxable"  hidden="true">'+data[i].net_basic_taxable+'</td>'+
                        '<td><input class="preview_data_details'+data[i].id+'" type="number" name="non_taxable_allowance" value="'+data[i].non_taxable_allowance+'" class="form-control custom-table-input non_taxable_allowance"  hidden="true">'+data[i].non_taxable_allowance+'</td>'+
                        '<td><input class="preview_data_details'+data[i].id+'" type="number" name="rice_allowance" value="'+data[i].rice_allowance+'" class="form-control custom-table-input rice_allowance"  hidden="true">'+data[i].rice_allowance+'</td>'+
                        '<td><input class="preview_data_details'+data[i].id+'" type="number" name="meal_allowance" value="'+data[i].meal_allowance+'" class="form-control custom-table-input meal_allowance"  hidden="true">'+data[i].meal_allowance+'</td>'+
                        '<td><input class="preview_data_details'+data[i].id+'" type="number" name="telecom" value="'+data[i].telecom+'" class="form-control custom-table-input" readonly="readonly telecom" hidden="true">'+data[i].telecom+'</td>'+
                        '<td><input class="preview_data_details'+data[i].id+'" type="number" name="transpo" value="'+data[i].transpo+'" class="form-control custom-table-input" readonly="readonly transpo" hidden="true">'+data[i].transpo+'</td>'+
                        '<td><input class="preview_data_details'+data[i].id+'" type="number" name="ecola" value="'+data[i].ecola+'" class="form-control custom-table-input ecola"  hidden="true">'+data[i].ecola+'</td>'+
                        '<td><input class="preview_data_details'+data[i].id+'" type="number" name="grosspay" value="'+data[i].grosspay+'" class="form-control custom-table-input grosspay"  hidden="true">'+data[i].grosspay+'</td>'+
                        '<td><input class="preview_data_details'+data[i].id+'" type="number" name="sss" value="'+data[i].sss+'" class="form-control custom-table-input sss"  hidden="true">'+data[i].sss+'</td>'+
                        '<td><input class="preview_data_details'+data[i].id+'" type="number" name="phic" value="'+data[i].phic+'" class="form-control custom-table-input phic"  hidden="true">'+data[i].phic+'</td>'+
                        '<td><input class="preview_data_details'+data[i].id+'" type="number" name="hdmf" value="'+data[i].hdmf+'" class="form-control custom-table-input hdmf"  hidden="true">'+data[i].hdmf+'</td>'+
                        '<td><input class="preview_data_details'+data[i].id+'" type="number" name="wtax" value="'+data[i].wtax+'" class="form-control custom-table-input wtax"  hidden="true">'+data[i].wtax+'</td>'+
                        '<td><input class="preview_data_details'+data[i].id+'" type="number" name="sss_loan" value="'+data[i].sss_loan+'" class="form-control custom-table-input sss_loan"  hidden="true">'+data[i].sss_loan+'</td>'+
                        '<td><input class="preview_data_details'+data[i].id+'" type="number" name="hdmf_loan" value="'+data[i].hdmf_loan+'" class="form-control custom-table-input hdmf_loan"  hidden="true">'+data[i].hdmf_loan+'</td>'+

                        '<td><input class="preview_data_details'+data[i].id+'" type="number" name="cash_advance" value="'+data[i].cash_advance+'" class="form-control custom-table-input cash_advance"  hidden="true">'+data[i].cash_advance+'</td>'+
                        '<td><input class="preview_data_details'+data[i].id+'" type="number" name="bank_loan" value="'+data[i].bank_loan+'" class="form-control custom-table-input bank_loan"  hidden="true">'+data[i].bank_loan+'</td>'+
                        '<td><input class="preview_data_details'+data[i].id+'" type="number" name="total_deduction" value="'+data[i].total_deduction+'" class="form-control custom-table-input total_deduction"  hidden="true">'+data[i].total_deduction+'</td>'+
                        '<td><input class="preview_data_details'+data[i].id+'" type="number" name="net_pay" value="'+data[i].net_pay+'" class="form-control custom-table-input net_pay"  hidden="true">'+data[i].net_pay+'</td>'+
                        // '<td>'+release_payroll_date.toDateString()+'</td>'+
                        '<td><input class="preview_data_details'+data[i].id+'" type="number" name="overtime_hours" value="'+data[i].overtime_hours+'" class="form-control custom-table-input overtime_hours"  hidden="true">'+data[i].overtime_hours+'</td>'+
                        '<td><input class="preview_data_details'+data[i].id+'" type="number" name="absences_days" value="'+data[i].absences_days+'" class="form-control custom-table-input absences_days"  hidden="true">'+data[i].absences_days+'</td>'+

                        '<td>'+ 
                            '<a href="javascript:;" class="btn btn-sm btn-outline-primary btn-flat save-edit-payroll-register-details'+data[i].id+' {{$add}} data-id"'+data[i].id+'" disabled="true" hidden="true"><span class="icon is-small"><i class="fa fa-save"></i></span>&nbsp;Save</a>'+
                            '<a href="#post" class="btn btn-sm btn-outline-info btn-flat edit_payroll_register {{$edit}}" data-id="'+data[i].id+'" data-employee_no="'+data[i].employee_no+'" data-basic="'+data[i].basic+'" data-absent="'+data[i].absent+'" data-late="'+data[i].late+'" data-undertime="'+data[i].undertime+'" '+
                            'data-regular_ot="'+data[i].regular_ot+'" data-legal_holiday="'+data[i].legal_holiday+'" data-special_holiday="'+data[i].special_holiday+'" data-night_differencial="'+data[i].night_differencial+'" data-adjustment_salary="'+data[i].adjustment_salary+'" data-night_diff_ot="'+data[i].night_diff_ot+'" data-incentives="'+data[i].incentives+'" '+
                            'data-commision="'+data[i].commision+'" data-net_basic_taxable="'+data[i].net_basic_taxable+'" data-non_taxable_allowance="'+data[i].non_taxable_allowance+'" data-rice_allowance="'+data[i].rice_allowance+'" data-meal_allowance="'+data[i].meal_allowance+'" data-telecom="'+data[i].telecom+'" data-transpo="'+data[i].transpo+'" '+
                            'data-ecola="'+data[i].ecola+'" data-grosspay="'+data[i].grosspay+'" data-sss="'+data[i].sss+'" data-phic="'+data[i].phic+'" data-phic="'+data[i].phic+'" data-hdmf="'+data[i].hdmf+'" data-wtax="'+data[i].wtax+'" data-sss_loan="'+data[i].sss_loan+'" data-hdmf_loan="'+data[i].hdmf_loan+'" '+
                            'data-hdmf_load="'+data[i].hdmf_load+'" data-cash_advance="'+data[i].cash_advance+'" data-bank_loan="'+data[i].bank_loan+'" data-total_deduction="'+data[i].total_deduction+'" data-net_pay="'+data[i].net_pay+'" data-overtime_hours="'+data[i].overtime_hours+'" data-absences_days="'+data[i].absences_days+'" id="edit_payroll_register" data-toggle="modal" data-target="#edit_payroll_register_details_modal"><i class="fa fa-pencil"></i></span>&nbsp;EDIT</a> ' +
                            '<a href="javascript:;" class="btn btn-sm btn-outline-danger btn-flat delete_payroll_register {{$delete}}" id="delete_payroll_details" data="'+data[i].id+'" {{$delete}}><span class="icon is-small"><i class="fa fa-trash"></i></span>&nbsp;Delete</a>'+
                        '</td>'+

                        '</tr>'+
                        '</form>';
                 //console.log(data[i]);

              }
                $('#previewdata').html(html);
              //console.log("TEST");
            },
            error: function(){
              console.log('Could not get data from database');
            }
          });
        } 

        /*Check Employee NO*/
        function check_employee_no(employee_no)
        {
            $.ajax({
                type: 'GET',
                url: '/payrollmanagement/check_employee_no',
                data: {employee_no: employee_no},
                async: true,
                dataType: 'json',
                success: function(data){
                    //console.log(data);
                    //console.log(employee_no);
                    //$.each(data, function(i, data){
                        if(data.status == "false"){
                            //console.log();
                            $('#error_alert').removeAttr('hidden');
                            $('#upload_validation_error_message').append('<label>Employee No: ' + employee_no + ' '+ data.message +'</label><br>');
                        }
                    //});
                },
                error: function(data){
                    //console.log(data);
                }
            });
        }

        /*Check for Duplicate Entry*/
        function check_duplicate_entry(employee_no)
        {
            $.ajax({
                type: 'GET',
                url: '/payrollmanagement/check_employee_exists_in_excel',
                data: {employee_no: employee_no},
                async: true,
                dataType: 'json',
                success: function(data){
                    //console.log(data);
                    if(data.status == "false"){
                            //console.log();
                            $('#error_alert').removeAttr('hidden');
                            $('#upload_validation_error_message').append('<label>Employee No: ' + employee_no + ' '+ data.message +'</label><br>');
                        }
                },
                error: function(data){
                    //console.log(data);
                }
            });
        }


        $('#submit_payroll_form').submit(function (){
            
        });

        $('#btn_save_payroll').click(function() {
            //console.log("TEST");
            $('#save_payroll_register_modal').modal('show');
        });

        $('#btn_submit_payroll').click(function (e){
            toastr.remove()
            e.preventDefault();
            var data = new FormData($('#save_payroll_form')[0]);
            swal({
                title: "Do you wanna Save This Payroll Register Details?",
                type: "warning",
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes",
                showCancelButton: true,
                closeOnConfirm: true,
            },
                function(){
                     /*AjaxSetup*/
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "{{ url('/payrollmanagement/submit_payroll_register_details') }}",
                        method: 'POST',
                        async: false,
                        dataType: 'json',
                        data: data,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function(data){
                            if(data.status == 'false'){
                                // Display a success toast, with a title
                                toastr.error('Pay Register Details Please Check your Employees Payroll Schedules')
                                console.log(data);
                                $('#save_payroll_errors').removeAttr('hidden');
                                $('#save_validation_error_message').html('<label>'+ data.message +'</label><br>');
                            }
                            else if(data.status == 'failed'){
                                // Display a success toast, with a title
                                toastr.error('Pay Register Details Please Check your Employees Payroll Schedules')
                                console.log(data);
                                $('#save_payroll_errors').removeAttr('hidden');
                                $('#save_validation_error_message').html('<label>'+ data.message +'</label><br>');
                            }
                            else {
                            // Display a success toast, with a title
                            toastr.success('Pay Register Details Successfully Posted', 'Success')
                            $('#error_alert').attr('hidden', true);
                            showAllPayRegister();
                            console.log(data);
                            $('#save_payroll_register_modal').modal('hide');
                            $('#save_payroll_form')[0].reset();
                            }
                        },
                        error: function(data, status){
                            // Catch Erros
                            if(data.status === 422){
                                var errors = $.parseJSON(data.responseText);
                                $.each(errors, function(i, errors){
                                    if(errors.batch_no){
                                        $('#save_payroll_errors').removeAttr('hidden');
                                        $('#save_validation_error_message').append('<label>'+ errors.batch_no +'</label><br>');
                                    }
                                    if(errors.period_from){
                                        $('#save_payroll_errors').removeAttr('hidden');
                                        $('#save_validation_error_message').append('<label>'+ errors.period_from +'</label><br>');
                                    }
                                    if(errors.period_to){
                                        $('#save_payroll_errors').removeAttr('hidden');
                                        $('#save_validation_error_message').append('<label>'+ errors.period_to +'</label><br>');
                                    }
                                    if(errors.payroll_schedule){
                                        $('#save_payroll_errors').removeAttr('hidden');
                                        $('#save_validation_error_message').append('<label>'+ errors.payroll_schedule +'</label><br>');
                                    }
                                });
                            }
                        }
                    });
                }
            );
            
        });

        /*Date Configuration*/
        var date = new Date();
            date.setDate(date.getDate());
            $('#period_to').datepicker({
                autoclose: true,
            }); 
            $('#period_from').datepicker({
                autoclose: true,
            }); 

        // /*Edit Payroll Register Details*/
        $('#previewdata').on('click', '.edit_payroll_register', function(){
            
            var id = $(this).attr('data-id');
            var employee_no = $(this).attr('data-employee_no');
            var basic = $(this).attr('data-basic');
            var absent = $(this).attr('data-absent');
            console.log(id);

            let edit_details_col_1 = {
                //id: $(this).attr('data-id'),
                employee_no: $(this).attr('data-employee_no'),
                basic: $(this).attr('data-basic'),
                absent: $(this).attr('data-absent'),
                late: $(this).attr('data-late'),
                regular_ot: $(this).attr('data-regular_ot'),
                undertime: $(this).attr('data-undertime'),
                legal_holiday: $(this).attr('data-legal_holiday'),
                special_holiday: $(this).attr('data-special_holiday'),
                night_differencial: $(this).attr('data-night_differencial'),
                adjustment_salary: $(this).attr('data-adjustment_salary'),
                night_diff_ot: $(this).attr('data-night_diff_ot'),
                incentives: $(this).attr('data-incentives'),
                commision: $(this).attr('data-commision'),
                net_basic_taxable: $(this).attr('data-net_basic_taxable'),
                non_taxable_allowance: $(this).attr('data-non_taxable_allowance'),
                rice_allowance: $(this).attr('data-rice_allowance'),
                meal_allowance: $(this).attr('data-meal_allowance'),
                
            };

            let edit_details_col_2  = {
                
                telecom: $(this).attr('data-telecom'),
                transpo: $(this).attr('data-transpo'),
                ecola: $(this).attr('data-ecola'),
                grosspay: $(this).attr('data-grosspay'),
                sss: $(this).attr('data-sss'),
                phic: $(this).attr('data-sss'),
                hdmf: $(this).attr('data-hdmf'),
                wtax: $(this).attr('data-wtax'),
                sss_loan: $(this).attr('data-sss_loan'),
                hdmf_loan: $(this).attr('data-hdmf_loan'),
                bank_loan: $(this).attr('data-bank_loan'),
                cash_advance: $(this).attr('data-cash_advance'),
                total_deduction: $(this).attr('data-total_deduction'),
                net_pay: $(this).attr('data-net_pay'),
                overtime_hours: $(this).attr('data-overtime_hours'),
                absences_days: $(this).attr('data-absences_days'),
            };

            $.each(edit_details_col_1, function(key, edit_details_col_1){
                $('#edit_payroll_field_col_1').append(`
                <div class="input-group input-group-sm mb-3">
                <input type="text" name="id" value="`+id+`" hidden="true">
                    <div class="col-md-12">
                        <label for="batch_no" style="font-family: Poppins !important;">`+key.charAt(0).toUpperCase() + key.slice(1)+`:</label>
                        <input type="number" name="`+key+`" id="`+key+`" value="`+edit_details_col_1+`" class="form-control" placeholder="`+key+` ">
                    </div>
                </div>
                `);
            });

            $.each(edit_details_col_2, function(key, edit_details_col_2){
                $('#edit_payroll_field_col_2').append(`
                <div class="input-group input-group-sm mb-3">
                    <div class="col-md-12">
                        <label for="batch_no" style="font-family: Poppins !important;">`+key.charAt(0).toUpperCase() + key.slice(1)+`:</label>
                        <input type="number" name="`+key+`" id="`+key+`" value="`+edit_details_col_2+`" class="form-control" placeholder="`+key+` ">
                    </div>
                </div>
                `);
            });

            

        //     $('.preview_data_details'+id).removeAttr('hidden');
        //     $('.save-edit-payroll-register-details'+id).removeAttr('hidden');
        //     $('.save-edit-payroll-register-details'+id).removeAttr('disabled');

        //     $('#employee_no').val(employee_no);
        //     $('#basic').val(basic);
        //     $('#absent').val(absent);
         });
         

         // Close Edit modal
         $('#edit_payroll_register_details_modal').on('hidden.bs.modal', function(e) {
            $('.input-group').remove();
         });




         // Update Details
         $('#save_edit_payroll_register_details').click(function (e){
            e.preventDefault();
            toastr.remove()
            var formData = new FormData($('#edit_payroll_details')[0]);
            $.ajax({
                url: '/payrollmanagement/update_payroll_details_preview',
                method: 'POST',
                async: false,
                dataType: 'json',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    if(data.status == 'true'){
                        // Modal hide
                        setTimeout(function (){
                                $('#edit_payroll_register_details_modal').modal('hide');
                        }, 400);
                        // Display a success toast, with a title
                        toastr.success('Payroll Details Updated', 'Success')
                        $('#edit_payroll_details')[0].reset();
                        $("#payroll_register_table").DataTable().destroy();
                        showAllPayRegister();
                        initDataTable();
                    }
                    console.log(data);
                },
                error: function(data){
                    console.log(data);
                }
            });
         });

        /*Delete Payroll Detailks*/
        $('#previewdata').on('click', '.delete_payroll_register', function() {
            var id = $(this).attr('data');
            toastr.remove()
            // Remove current toasts using animation
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
                    url: '/payrollmanagement/delete_preview_details',
                    data: {
                        id: id,
                        '_token': $('input[name=_token]').val(),
                    },
                    success: function(data){
                            // Display a success toast, with a title
                            toastr.success('Pay Register Details Deleted', 'Success')
                            $("#payroll_register_table").DataTable().destroy();
                            showAllPayRegister();
                            initDataTable();
                    },
                    error: function(data){
                        toastr.error('Error Deleting Announcement')
                    }

                });
            }
        );
        });

         // Edit 
         $('#previewdata').on('click', '.preview_data_details', function(){
            var id = $(this).attr('data-id');
            $('.preview_data_details'+id).attr('hidden', true);
            console.log(id);
        });

        // Save Payroll Register Details
        $('#previewdata').on('click', '.save-edit-payroll-register-details', function(){

        });




    });
  </script>
@endsection