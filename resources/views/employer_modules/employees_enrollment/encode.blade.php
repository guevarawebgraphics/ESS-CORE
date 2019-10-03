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
            <li class="breadcrumb-item active-encode-employees text-secondary">Encode Employees</li>
        </ol>
    </div>
</div>
@endsection
@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header card-custom-blue card-outline">
            <h3 class="card-title"><i class="fa fa-edit"></i> Encode Employees</h3>
        </div>
        <form method="POST" id="EmployeeForm">
        @csrf
            <div class="card-body">
                {{-- HIDDEN INPUT FIELD FOR EMPLOYEE PERSONAL INFO ID--}}
                <input type="hidden" id="hidden_personalinfo_id" name="hidden_personalinfo_id">
                <input type="hidden" id="hidden_essid" name="hidden_essid">
                {{-- RADIO BUTTON FIELD --}}
                <div class="form-group row">
                    <div class="offset-md-4">            
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="customRadio" name="rbn_emp"
                                value="new_employee" checked>
                            <label class="custom-control-label" for="customRadio">New Employee</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="customRadio2" name="rbn_emp"
                                value="existing_employee">
                            <label class="custom-control-label" for="customRadio2">Employee with ESS ID</label>
                        </div>                                             
                    </div>
                </div>   
                <div class="form-group row essid_field" hidden>
                        <label for="essid_search" class="col-md-2 text-md-center custom-flat-label">ESS ID / User ID</label>
                        <div class="col-md-8">
                                
                            <div class="input-group mb-3">
                                {{--<div class="input-group-prepend">
                                    <span class="fa fa-user input-group-text" style="background-color: #fff;"></span>
                                </div>--}}
                                <input id="essid_search" type="text" class="form-control" name="essid_search" placeholder="ESS ID / User ID" autofocus>&nbsp;&nbsp;
                                <input type="button" class="btn btn-outline-primary btn-flat" id="btn_search" value="Search">
                            </div>
                            <p class="text-danger" id="error_business_name"></p>
                            
                        </div>
                </div>
                <hr class="iform-label"> 
                <label class="iform-label"> Personal Information </label>
                <div class="form-group row mt-4 iform"> 
                        
                        <label for="firstname" class="col-md-2 text-md-center custom-flat-label">First Name :</label>  
                        <div class="col-md-4">
                            <div class="input-group mb-3">
                            {{--<div class="input-group-prepend">
                                    <span class="fa fa-user input-group-text"></span>
                                </div> --}}
                                <input id="firstname" type="text" class="form-control custom-flat-input" name="firstname" placeholder="First Name"   autofocus>
                            </div>
                            <p class="text-danger text-md-center" id="error_firstname"></p>
                        </div>
                        <label for="lastname" class="col-md-2 text-md-center custom-flat-label">Last Name :</label>   
                        <div class="col-md-4">
                            <div class="input-group mb-3">
                            {{--<div class="input-group-prepend">
                                    <span class="fa fa-user input-group-text"></span>
                                </div>--}}
                                <input id="lastname" type="text" class="form-control custom-flat-input" name="lastname" placeholder="Last Name"   autofocus>
                            </div>
                            <p class="text-danger text-md-center mb-6" id="error_lastname"></p>
                        </div>
                        <label for="middlename" class="col-md-2 text-md-center custom-flat-label">Middle Name :</label>   
                        <div class="col-md-4">
                            <div class="input-group mb-3">
                            {{--<div class="input-group-prepend">
                                    <span class="fa fa-user input-group-text"></span>
                                </div> --}} 
                                <input id="middlename" type="text" class="form-control custom-flat-input" name="middlename" placeholder="Middle Name"   autofocus>
                            </div>
                            <p class="text-danger text-md-center" id="error_middlename"></p>
                        </div>
                        <label for="suffix" class="col-md-2 text-md-center custom-flat-label">Suffix :</label>   
                        <div class="col-md-4">
                            <div class="input-group mb-3">
                            {{--<div class="input-group-prepend">
                                    <span class="fa fa-user input-group-text"></span>
                                </div> --}}
                                <input id="suffix" type="text" class="form-control custom-flat-input" name="suffix" placeholder="Suffix"   autofocus>
                            </div>
                            <p class="text-danger text-md-center" id="error_middlename"></p>
                        </div>
                        <label for="gender" class="col-md-2 text-md-center custom-flat-label">Gender :</label>
                        <div class="col-md-4">
                            <div class="input-group mb-3">
                            {{--<div class="input-group-prepend">
                                    <span class="fa fa-user input-group-text"></span>
                                </div>--}}
                                <select class="form-control custom-flat-select" id="gender" name="gender">
                                        <option value="">Select Options</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>                               
                                    </select>
                            </div>
                            <p class="text-danger text-md-center" id="error_gender"></p>
                        </div>
                        <label for="civil_status" class="col-md-2 text-md-center custom-flat-label">Civil Status :</label>
                        <div class="col-md-4">
                            <div class="input-group mb-3">
                            {{--  <div class="input-group-prepend">
                                    <span class="fa fa-user input-group-text"></span>
                                </div>--}}
                                <select class="form-control custom-flat-select" id="civil_status" name="civil_status">
                                        <option value="">Select Options</option>
                                        <option value="Single">Single</option>
                                        <option value="Married">Married</option>
                                        <option value="Widow">Widow</option>                                            
                                </select>
                            </div>
                            <p class="text-danger text-md-center" id="error_civil_status"></p>
                        </div>
                        <label for="birthdate" class="col-md-2 text-md-center custom-flat-label">Birthdate :</label>
                        <div class="col-md-4">
                            <div class="input-group mb-3">
                            {{--<div class="input-group-prepend">
                                    <span class="fa fa-calendar input-group-text"></span>
                                </div>--}}
                                <input id="birthdate" type="text" class="form-control datepicker custom-flat-input" name="birthdate" placeholder="MM/DD/YYYY"   autofocus>
                            </div>
                            <p class="text-danger text-md-center" id="error_birthdate"></p>
                        </div>
            
                </div>  
                <hr class="iform-label">
                <label class="iform-label"> Employee Information </label>
                <div class="form-group row mt-4 iform" id="iform_employee_no"> 
                        <label for="employee_no" class="col-md-2 text-md-center custom-flat-label">Employee No. </label>
                        <div class="col-md-4">
                                
                            <div class="input-group mb-3">
                            {{--<div class="input-group-prepend">
                                    <span class="fa fa-user input-group-text" style="background-color: #fff;"></span>
                                </div>--}}
                                <input id="employee_no" type="text" class="form-control custom-flat-input" name="employee_no" placeholder="Employee No"   autofocus>
                            </div>
                            <p class="text-danger text-md-center mb-6" id="error_employee_no"></p>
                        </div>
                </div>
                <div class="form-group row iform_editablefield"> 
                        <label for="position" class="col-md-2 text-md-center custom-flat-label">Position :</label>
                        <div class="col-md-4">
                            <div class="input-group mb-3">
                            {{--<div class="input-group-prepend">
                                    <span class="fa fa-user input-group-text"></span>
                                </div>--}}
                                <input id="position" type="text" class="form-control custom-flat-input" name="position" placeholder="Position"   autofocus>
                            </div>
                            <p class="text-danger text-md-center mb-6" id="error_position"></p>
                        </div>
                        <label for="department" class="col-md-2 text-md-center custom-flat-label">Department :</label>
                        <div class="col-md-4">
                            <div class="input-group mb-3">
                            {{--<div class="input-group-prepend">
                                    <span class="fa fa-user input-group-text"></span>
                                </div>--}}
                                <input id="department" type="text" class="form-control custom-flat-input" name="department" placeholder="Department"   autofocus>
                            </div>
                            <p class="text-danger text-md-center mb-6" id="error_department"></p>
                        </div> 
                        <label for="employment_status" class="col-md-2 text-md-center custom-flat-label">Employment Status :</label>
                        <div class="col-md-4">
                            <div class="input-group mb-3">
                            {{--<div class="input-group-prepend">
                                    <span class="fa fa-user input-group-text"></span>
                                </div>--}}
                                <select class="form-control custom-flat-select" id="employment_status" name="employment_status">
                                        <option value="">Select Options</option>
                                        <option value="Contractual">Contractual</option>
                                        <option value="Probationary">Probationary</option>
                                        <option value="Permanent">Permanent</option>
                                        <option value="Regular">Regular</option>
                                    </select>
                            </div>
                            <p class="text-danger text-md-center" id="error_employment_status"></p>
                        </div>
                        <label for="payroll_schedule" class="col-md-2 text-md-center custom-flat-label">Payroll Schedule :</label>
                        <div class="col-md-4">
                            <div class="input-group mb-3">
                            {{--<div class="input-group-prepend">
                                    <span class="fa fa-calendar input-group-text"></span>
                                </div>--}}
                                <select class="form-control custom-flat-select" id="payroll_schedule" name="payroll_schedule">
                                        <option value="">Select Options</option>
                                        <option value="Weekly">Weekly</option>
                                        <option value="Monthly">Monthly</option>
                                        <option value="2xMonthly">2x Monthly</option>                                            
                                </select>
                            </div>
                            <p class="text-danger text-md-center" id="error_payroll_schedule"></p>
                        </div>
                        <label for="payroll_bank" class="col-md-2 text-md-center custom-flat-label">Payroll Bank :</label>
                        <div class="col-md-4">
                            <div class="input-group mb-3">
                            {{--<div class="input-group-prepend">
                                    <span class="fa fa-address-card input-group-text"></span>
                                </div>--}}
                                <select class="form-control custom-flat-select" id="payroll_bank" name="payroll_bank">
                                        <option value="">Select Options</option>
                                        <option value="BDO">BANCO DE ORO</option>                                                              
                                </select>
                            </div>
                            <p class="text-danger text-md-center" id="error_payroll_bank"></p>
                        </div>
                        <label for="enrollment_date" class="col-md-2 text-md-center custom-flat-label">Enrollment Date :</label>
                        <div class="col-md-4">
                            <div class="input-group mb-3">
                            {{--<div class="input-group-prepend">
                                    <span class="fa fa-calendar input-group-text"></span>
                                </div>--}}
                                <input id="enrollment_date" type="text" class="form-control datepicker custom-flat-input" name="enrollment_date" placeholder="MM/DD/YYYY"   autofocus>
                            </div>
                            <p class="text-danger text-md-center" id="error_enrollment_date"></p>
                        </div> 
                        <label for="account_no" class="col-md-2 text-md-center custom-flat-label">Account No. :</label>  
                        <div class="col-md-4">
                            <div class="input-group mb-3">
                            {{--<div class="input-group-prepend">
                                    <span class="fa fa-user input-group-text"></span>
                                </div>--}}
                                <input id="account_no" type="text" class="form-control custom-flat-input" name="account_no" placeholder="Account Number" autofocus>
                            </div>
                            <p class="text-danger text-md-center" id="error_account_no"></p>
                        </div>
                </div>   
                <hr class="iform-label">
                <label class="iform-label"> Contact Information </label>
                <div class="form-group row mt-4 iform">
                        <label for="mobile_no" class="col-md-2 text-md-center custom-flat-label">Mobile No. :</label>
                        <div class="col-md-4">
                            <div class="input-group mb-3">
                            {{--<div class="input-group-prepend">
                                    <span class="fa fa-user input-group-text"></span>
                                </div>--}}
                                <input id="mobile_no" type="text" maxlength="11" class="form-control custom-flat-input" name="mobile_no" placeholder="Mobile No." onKeyPress="return checknumber(event)"  autofocus>
                            </div>
                            <p class="text-danger text-md-center mb-6" id="error_mobile_no"></p>
                        </div>
                        <label for="email_add" class="col-md-2 text-md-center custom-flat-label">Email :</label>
                        <div class="col-md-4">
                            <div class="input-group mb-3">
                            {{--<div class="input-group-prepend">
                                    <span class="fa fa-user input-group-text"></span>
                                </div>--}}
                                <input id="email_add" type="email" class="form-control custom-flat-input" name="email_add" placeholder="Email"   autofocus>
                            </div>
                            <p class="text-danger text-md-center" id="error_email_add"></p>
                        </div>
                </div> 
                <hr class="iform-label">
                <label class="iform-label"> Goverment Numbers </label>
                 <div class="form-group row mt-4 iform">
                        <label for="TIN" class="col-md-2 text-md-center custom-flat-label">TIN :</label>     
                        <div class="col-md-4">
                            <div class="input-group mb-3">
                            {{--<div class="input-group-prepend">
                                    <span class="fa fa-address-card input-group-text"></span>
                                </div>--}}
                                <input id="TIN" type="text" class="form-control custom-flat-input" name="tin" placeholder="TIN"   autofocus>
                            </div>
                            <p class="text-danger text-md-center" id="error_TIN"></p>
                        </div>
                        <label for="SSSGSIS" class="col-md-2 text-md-center custom-flat-label">SSS/GSIS :</label>   
                        <div class="col-md-4">
                            <div class="input-group mb-3">
                            {{--<div class="input-group-prepend">
                                    <span class="fa fa-address-card input-group-text"></span>
                                </div>--}}
                                <input id="SSSGSIS" type="text" class="form-control custom-flat-input" name="sssgsis" placeholder="SSS/GSIS"   autofocus>
                            </div>
                            <p class="text-danger text-md-center" id="error_SSSGSIS"></p>
                        </div>
                        <label for="HDMF" class="col-md-2 text-md-center custom-flat-label">HDMF :</label> 
                        <div class="col-md-4">
                            <div class="input-group mb-3">
                            {{--<div class="input-group-prepend">
                                    <span class="fa fa-address-card input-group-text"></span>
                                </div>--}}
                                <input id="HDMF" type="text" class="form-control custom-flat-input" name="hdmf" placeholder="HDMF" autofocus>
                            </div>
                            <p class="text-danger text-md-center" id="error_HDMF"></p>
                        </div>
                        <label for="PHIC" class="col-md-2 text-md-center custom-flat-label">PHIC :</label> 
                        <div class="col-md-4">
                            <div class="input-group mb-3">
                            {{--<div class="input-group-prepend">
                                    <span class="fa fa-address-card input-group-text"></span>
                                </div>--}}
                                <input id="PHIC" type="text" class="form-control custom-flat-input" name="phic" placeholder="PHIC" autofocus>
                            </div>
                            <p class="text-danger text-md-center" id="error_PHIC"></p>
                        </div>
                        <label for="nid" class="col-md-2 text-md-center custom-flat-label">NID :</label> 
                        <div class="col-md-4">
                            <div class="input-group mb-3">
                            {{--<div class="input-group-prepend">
                                    <span class="fa fa-address-card input-group-text"></span>
                                </div>--}}
                                <input id="nid" type="text" class="form-control custom-flat-input" name="nid" placeholder="NID" autofocus>
                            </div>
                            <p class="text-danger text-md-center" id="error_nid"></p>
                        </div>
                     
                </div>
                <hr class="iform-label">
                <label class="iform-label">Present Address</label>
                <div class="form-group row mt-4 iform">
                            <label class="col-md-2 text-md-center custom-flat-label">Country:</label>
                            <div class="col-md-4">
                                <div class="input-group mb-3">
                                {{--<div class="input-group-prepend">
                                        <span class="fa fa-address-card input-group-text"></span>
                                    </div>--}}
                                    <select id="country" name="country" class="form-control custom-flat-select">
                                            {{--<option value="">Choose Country</option> --}}
                                            <option value="Phillipines" selected>Philippines</option>
                                    </select>
                                </div>
                                <p class="text-danger text-md-center" id="error_country"></p>
                            </div>
                            <label for="address_unit" class="col-md-2 text-md-center custom-flat-label">Unit:</label>  
                            <div class="col-md-4">
                                <div class="input-group mb-3">
                                {{--<div class="input-group-prepend">
                                        <span class="fa fa-user input-group-text"></span>
                                    </div>--}}
                                    <input id="address_unit" type="text" class="form-control custom-flat-input" name="address_unit" placeholder="Address Unit"  autofocus>
                                </div>
                                <p class="text-danger text-md-center" id="error_address_unit"></p>
                            </div>
              
                            <label for="province" class="col-md-2 text-md-center custom-flat-label">Province:</label>
                            <div class="col-md-4">
                                <div class="input-group mb-3">
                                 {{--<div class="input-group-prepend">
                                        <span class="fa fa-address-card input-group-text"></span>
                                    </div>--}}
                                    <select id="province" name="province" class="form-control custom-flat-select">
                                            <option value="" selected>Choose Province</option>
                                    </select>
                                </div>
                                <p class="text-danger text-md-center" id="error_province"></p>
                            </div>
                            <label for="citytown" class="col-md-2 text-md-center custom-flat-label">City/Town:</label>
                            <div class="col-md-4">
                                <div class="input-group mb-3">
                                {{--<div class="input-group-prepend">
                                        <span class="fa fa-user input-group-text"></span>
                                    </div>--}}
                                    <select id="citytown" name="citytown" class="form-control custom-flat-select">
                                            <option value="" selected>Choose City/Town</option>
                                    </select>
                                </div>
                                <p class="text-danger text-md-center" id="error_citytown"></p>
                            </div>
                 
                            <label for="barangay" class="col-md-2 text-md-center custom-flat-label">Barangay:</label>
                            <div class="col-md-4">
                                <div class="input-group mb-3">
                                {{--<div class="input-group-prepend">
                                        <span class="fa fa-address-card input-group-text"></span>
                                    </div>--}}
                                    <select id="barangay" name="barangay" class="form-control custom-flat-select">
                                            <option value="" selected>Choose Barangay</option>
                                    </select>
                                </div>
                                <p class="text-danger text-md-center" id="error_barangay"></p>
                            </div>
                            <label for="zipcode" class="col-md-2 text-md-center custom-flat-label">Zipcode:</label> 
                            <div class="col-md-4">
                                <div class="input-group mb-3">
                                {{--<div class="input-group-prepend">
                                        <span class="fa fa-user input-group-text"></span>
                                    </div>--}}
                                    <input id="zipcode" type="text" class="form-control custom-flat-input" name="zipcode" placeholder="Address Zipcode"  autofocus>
                                </div>
                                <p class="text-danger text-md-center" id="error_zipcode"></p>
                            </div>
                  
                </div>     
            </div>     
                 
        </form>


        {{-- Employee Profile --}}
        <div class="col-md-8 offset-md-2" id="employee_profile" hidden>
                <!-- Widget: user widget style 1 -->
                <div class="card card-widget widget-user shadow rounded">
                  <!-- Add the bg color to the header using any of the bg-* classes -->
                  <div class="widget-user-header bg-info-active text-white" style="background: url('../dist/img/photo1.png') center center;">
                    <h3 class="widget-user-username" id="employee_name"></h3>
                    <h5 class="widget-user-desc" id="employee_position"></h5>
                  </div>
                  <div class="widget-user-image">
                    <img class="img-circle elevation-2" id="employee_profile_picture" alt="User Avatar" style="height: 90px; width: 90px;">
                  </div>
                  <div class="card-footer">
                    <label>Employees Information</label>
                      <div class="container">
                          <div class="row">
                            <div class="col-md-6">
                                <div class="emp_info">
                                    Employee No
                                    <p id="employee_employeeno"></p>
                                </div>
                                <div class="emp_info">
                                    Department
                                    <p id="employee_department"></p>
                                </div>
                                <div class="emp_info">
                                        Email
                                        <p id="employee_email"></p>
                                </div>
                                <div class="emp_info">
                                        Mobile No
                                        <p id="employee_mobileno"></p>
                                </div>
                                <div class="emp_info">
                                        Account No
                                        <p id="employee_accountno"></p>
                                </div>
                                <div class="emp_info">
                                        Enrollment Date
                                    <p id="employee_enrollmentdate"></p>
                                </div>
                                
                                
                                
                            </div>
                            <div class="col-md-6">
                                <div class="emp_info">
                                    Address
                                    <p id="employee_address">#</p>
                                </div>
                                <div class="emp_info">
                                    Birthdate
                                    <p id="employee_birthdate">#</p>
                                </div>
                                <div class="emp_info">
                                    Gender
                                    <p id="employee_gender">#</p>
                                </div>
                                <div class="emp_info">
                                    Civil Status
                                    <p id="employee_civilstatus">#</p>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Goverment Numbers</label>
                                <div class="emp_info">
                                    TIN
                                    <p id="employee_tin"></p>
                                </div>
                                <div class="emp_info">
                                    SSSGSIS
                                    <p id="employee_sssgsis"></p>
                                </div>
                                <div class="emp_info">
                                    PHIC
                                    <p id="employee_phic"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="emp_info" style="margin-top: 30.5px;">
                                    HDMF
                                    <p id="employee_hdmf"></p>
                                </div>
                                <div class="emp_info">
                                    NID
                                    <p id="employee_nid"></p>
                                </div>
                            </div>
                        </div>
                      </div>
                  </div>
                </div>
                <!-- /.widget-user -->
              </div>
              <!-- /.col --> 

              
        <div class="" id="formOverlay">
            <i class="" id="spinnerload"></i>
        </div>
          <!-- end loading -->
        <div class="card-footer">
            <button type="submit" class="btn btn-outline-primary  btn-flat float-right" id="submit">Submit <i id="spinnerload" class=""></i></button>
        </div>              
    </div>      
</div>
<script>
//called when key is pressed in textbox
function checknumber(e)
{
    //if the letter is not digit then display error and don't type anything
    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) 
    {
        return false;
    }
}

//document.getElementById("employer_id").disabled = true;

$(document).ready(function(){
    // Config Restriction for Pass Date
        var date = new Date();
        date.setDate(date.getDate());
        $('#enrollment_date').datepicker({
            autoclose: true,
            startDate: date
        });
    $('#birthdate').datepicker({
        autoclose: true,
    });
    /*Get Province*/
    $.ajax({
			method: 'get',
            url: '/enrollemployee/getprovince',
            dataType: 'json',
			success: function (data) {
                $.each(data, function (i, data) {
                    $("#province").append('<option value="' + data.provCode + '">' + data.provDesc + '</option>');
                });
			},
			error: function (response) {
                console.log("Error cannot be");
			}
    });

    /*Get City town*/
    $('#province').change(function (){
        $("#citytown").empty();
        if($('#province').val() != ""){
            $code = $('#province').val();
            $.ajax({
                    method: 'get',
                    url: '/enrollemployee/getcity/' + $code,
                    dataType: 'json',
                    success: function (data) {
                        $("#citytown").append('<option value="">Choose citytown</option>');
                        $.each(data, function (i, data) {
                            $("#citytown").append('<option value="' + data.citymunCode + '">' + data.citymunDesc + '</option>');
                        });
                    },
                    error: function (response) {
                            console.log("Error cannot be");
                    }
            });
        }
    });

    /*Get Barangay*/
    $('#citytown').change(function (){
        $("#barangay").empty();
        $code = $('#citytown').val();
        $.ajax({
                method: 'get',
                url: '/enrollemployee/getbarangay/' + $code,
                dataType: 'json',
                success: function (data) {
                    $("#barangay").append('<option value="">Choose Barangay</option>');
                    $.each(data, function (i, data) {
                        $("#barangay").append('<option value="' + data.id + '">' + data.brgyDesc + '</option>');
                    });
                },
                error: function (response) {
                        console.log("Error cannot be");
                }
        });
    });

    // //SHOWING OF TEXTBOX FOR ESS ID FIELD
     $("input[name=rbn_emp]").change(function (){
        var shift = $("input[name=rbn_emp]:checked").val();
        console.log(shift);  
        if(shift == "existing_employee")
        {
            $(".essid_field").removeAttr("hidden");
            $('.iform').attr('hidden', true);
            $('.iform-label').attr('hidden', true); 
            $('.iform_editablefield').attr('hidden',true);
        }
        else if(shift == "new_employee")
        {
            //Reset The form
            $('#EmployeeForm')[0].reset();
            $(".essid_field").attr("hidden", true);
            $('.iform').removeAttr('hidden', true);
            $('.iform-label').removeAttr('hidden');
            $('#employee_profile').attr('hidden', true) 
            
        }
    });
    

    //submit
    $(document).on("click", "#submit", function(){
        $('#formOverlay').addClass('overlay');
        $("#spinnerload").addClass('fa fa-refresh fa-spin');
        toastr.remove()
        error = 0;
        employee_no = $("#employee_no").val();
        position = $("#position").val();
        department = $("#department").val();
        suffix = $("#suffix").val();
        lastname = $("#lastname").val();
        mobile_no = $("#mobile_no").val();
        firstname = $("#firstname").val();
        email_add = $("#email_add").val();
        middlename = $("#middlename").val();
        enrollment_date = $("#enrollment_date").val();
        TIN = $("#TIN").val();
        employment_status = $("#employment_status").val();
        SSSGSIS = $("#SSSGSIS").val();
        birthdate = $("#birthdate").val();
        PHIC = $("#PHIC").val();
        gender = $("#gender").val();
        HDMF = $("#HDMF").val();
        civil_status = $("#civil_status").val();
        nid = $("#nid").val();
        payroll_schedule = $("#payroll_schedule").val();
        payroll_bank = $("#payroll_bank").val();
        account_no = $("#account_no").val();
        country = $("#country").val();
        address_unit = $("#address_unit").val();
        province = $("#province").val();
        citytown = $("#citytown").val();
        barangay = $("#barangay").val();
        zipcode = $("#zipcode").val();

        if(employee_no == "")
        {
            $("#employee_no").addClass('is-invalid');
            $("#error_employee_no").html("Employee No is Required");
            error++;
            spinnerTimout();
        }
        else
        {
            $("#employee_no").removeClass('is-invalid');
            $("#error_employee_no").html("");
            error = 0;
        }

        if(position == "")
        {
            $("#position").addClass('is-invalid');
            $("#error_position").html("Employee Position is Required");
            error++;
            spinnerTimout();
        }
        else
        {
            $("#position").removeClass('is-invalid');
            $("#error_position").html("");
            error = 0;
        }

        if(department == "")
        {
            $("#department").addClass('is-invalid');
            $("#error_department").html("Employee department is Required");
            error++;
            spinnerTimout();
        }
        else
        {
            $("#department").removeClass('is-invalid');
            $("#error_department").html("");
            error = 0;
        }

        if(lastname == "")
        {
            $("#lastname").addClass('is-invalid');
            $("#error_lastname").html("Employee Last Name is Required");
            error++;
            spinnerTimout();
        }
        else
        {
            $("#lastname").removeClass('is-invalid');
            $("#error_lastname").html("");
            error = 0;
        }

        if(mobile_no == "")
        {
            $("#mobile_no").addClass('is-invalid');
            $("#error_mobile_no").html("Employee Mobile No. is Required");
            error++;
            spinnerTimout();
        }
        else
        {
            $("#mobile_no").removeClass('is-invalid');
            $("#error_mobile_no").html("");
            error = 0;
        }

        if(firstname == "")
        {
            $("#firstname").addClass('is-invalid');
            $("#error_firstname").html("Employee First Name is Required");
            error++;
            spinnerTimout();
        }
        else
        {
            $("#firstname").removeClass('is-invalid');
            $("#error_firstname").html("");
            error = 0;
        }

        if(email_add == "")
        {
            $("#email_add").addClass('is-invalid');
            $("#error_email_add").html("Employee Email Address is Required");
            error++;
            spinnerTimout();
        }
        else
        {
            $("#email_add").removeClass('is-invalid');
            $("#error_email_add").html("");
            error = 0;
        }

        if(middlename == "")
        {
            $("#middlename").addClass('is-invalid');
            $("#error_middlename").html("Employee Middle Name is Required");
            error++;
            spinnerTimout();
        }
        else
        {
            $("#middlename").removeClass('is-invalid');
            $("#error_middlename").html("");
            error = 0;
        }

        if(enrollment_date == "")
        {
            $("#enrollment_date").addClass('is-invalid');
            $("#error_enrollment_date").html("Employee Enrollment Date is Required");
            error++;
            spinnerTimout();
        }
        else
        {
            $("#enrollment_date").removeClass('is-invalid');
            $("#error_enrollment_date").html("");
            error = 0;
        }

        if(TIN == "")
        {
            $("#TIN").addClass('is-invalid');
            $("#error_TIN").html("Employee TIN No. is Required");
            error++;
            spinnerTimout();
        }
        else
        {
            $("#TIN").removeClass('is-invalid');
            $("#error_TIN").html("");
            error = 0;
        }

        if(employment_status == "")
        {
            $("#employment_status").addClass('is-invalid');
            $("#error_employment_status").html("Employee Status is Required");
            error++;
            spinnerTimout();
        }
        else
        {
            $("#employment_status").removeClass('is-invalid');
            $("#error_employment_status").html("");
            error = 0;
        }

        if(SSSGSIS == "")
        {
            $("#SSSGSIS").addClass('is-invalid');
            $("#error_SSSGSIS").html("Employee SSS/GSIS No. is Required");
            error++;
            spinnerTimout();
        }
        else
        {
            $("#SSSGSIS").removeClass('is-invalid');
            $("#error_SSSGSIS").html("");
            error = 0;
        }

        if(birthdate == "")
        {
            $("#birthdate").addClass('is-invalid');
            $("#error_birthdate").html("Employee Birthdate is Required");
            error++;
            spinnerTimout();
        }
        else
        {
            $("#birthdate").removeClass('is-invalid');
            $("#error_birthdate").html("");
            error = 0;
        }

        if(PHIC == "")
        {
            $("#PHIC").addClass('is-invalid');
            $("#error_PHIC").html("Employee Philhealth No. is Required");
            error++;
            spinnerTimout();
        }
        else
        {
            $("#PHIC").removeClass('is-invalid');
            $("#error_PHIC").html("");
            error = 0;
        }

        if(gender == "")
        {
            $("#gender").addClass('is-invalid');
            $("#error_gender").html("Employee Gender is Required");
            error++;
            spinnerTimout();
        }
        else
        {
            $("#gender").removeClass('is-invalid');
            $("#error_gender").html("");
            error = 0;
        }

        if(HDMF == "")
        {
            $("#HDMF").addClass('is-invalid');
            $("#error_HDMF").html("Employee HDMF No. is Required");
            error++;
            spinnerTimout();
        }
        else
        {
            $("#HDMF").removeClass('is-invalid');
            $("#error_HDMF").html("");
            error = 0;
        }
        
        if(civil_status == "")
        {
            $("#civil_status").addClass('is-invalid');
            $("#error_civil_status").html("Employee Civil Status is Required");
            error++;
            spinnerTimout();
        }
        else
        {
            $("#civil_status").removeClass('is-invalid');
            $("#error_civil_status").html("");
            error = 0;
        }
        
        if(nid == "")
        {
            $("#nid").addClass('is-invalid');
            $("#error_nid").html("Employee nid No. is Required");
            error++;
            spinnerTimout();
        }
        else
        {
            $("#nid").removeClass('is-invalid');
            $("#error_nid").html("");
            error = 0;
        }
        
        if(payroll_schedule == "")
        {
            $("#payroll_schedule").addClass('is-invalid');
            $("#error_payroll_schedule").html("Employee Payroll Schedule is Required");
            error++;
            spinnerTimout();
        }
        else
        {
            $("#payroll_schedule").removeClass('is-invalid');
            $("#error_payroll_schedule").html("");
            error = 0;
        }

        if(payroll_bank == "")
        {
            $("#payroll_bank").addClass('is-invalid');
            $("#error_payroll_bank").html("Employee Payroll Bank is Required");
            error++;
            spinnerTimout();
        }
        else
        {
            $("#payroll_bank").removeClass('is-invalid');
            $("#error_payroll_bank").html("");
            error = 0;
        }
        
        if(account_no == "")
        {
            $("#account_no").addClass('is-invalid');
            $("#error_account_no").html("Employee Account No. is Required");
            error++;
            spinnerTimout();
        }
        else
        {
            $("#account_no").removeClass('is-invalid');
            $("#error_account_no").html("");
            error = 0;
        }
        
        if(country == "")
        {
            $("#country").addClass('is-invalid');
            $("#error_country").html("Employee Country is Required");
            error++;
            spinnerTimout();
        }
        else
        {
            $("#country").removeClass('is-invalid');
            $("#error_country").html("");
            error = 0;
        }

        if(address_unit == "")
        {
            $("#address_unit").addClass('is-invalid');
            $("#error_address_unit").html("Employee Address Unit is Required");
            error++;
            spinnerTimout();
        }
        else
        {
            $("#address_unit").removeClass('is-invalid');
            $("#error_address_unit").html("");
            error = 0;
        }
        
        if(province == "")
        {
            $("#province").addClass('is-invalid');
            $("#error_province").html("Employee Province is Required");
            error++;
            spinnerTimout();
        }
        else
        {
            $("#province").removeClass('is-invalid');
            $("#error_province").html("");
            error = 0;
        }

        if(citytown == "")
        {
            $("#citytown").addClass('is-invalid');
            $("#error_citytown").html("Employee Address Town is Required");
            error++;
            spinnerTimout();
        }
        else
        {
            $("#citytown").removeClass('is-invalid');
            $("#error_citytown").html("");
            error = 0;
        }

        if(barangay == "")
        {
            $("#barangay").addClass('is-invalid');
            $("#error_barangay").html("Employee Address Barangay is Required");
            error++;
            spinnerTimout();
        }
        else
        {
            $("#barangay").removeClass('is-invalid');
            $("#error_barangay").html("");
            error = 0;
        }

        if(zipcode == "")
        {
            $("#zipcode").addClass('is-invalid');
            $("#error_zipcode").html("Employee Zipcode is Required");
            error++;
            spinnerTimout();
        }
        else
        {
            $("#zipcode").removeClass('is-invalid');
            $("#error_zipcode").html("");
            error = 0;
        }
        if(birthdate != "" && birthdate.substring(6) >= 2001)
        {
            $("#birthdate").addClass('is-invalid');
            $("#error_birthdate").html("Age must be at least 18 years old");
            error++;
            spinnerTimout();
        }
        else 
        {
            $("#birthdate").removeClass('is-invalid');
            $("#error_birthdate").html("");
            error = 0;
        }

        if(error <= 0)
        {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'POST',
                url: '/enrollemployee/encode/post',
                data: $("#EmployeeForm").serialize(),
                success: function (data) {
                    /*
                    * Check if the response is error
                    */
                    if(data == 'error') { 
                     
                        toastr.info('ESS ID has been enrolled as your employee. Please enter other ESS ID.', 'Information')
                        toastr.options = {
                        "timeOut": "5000",
                        }
                    }
                    else {
                        spinnerTimout(3000);
                        toastr.success('Employee Enrolled Successfully', 'Success')
                        setTimeout(() => {
                            window.location.href = "{{URL::to('/enrollemployee')}}"
                        }, 1000);
                      
                        $('#EmployeeForm')[0].reset();
                    }
                },
                error: function (data, status) {
                    spinnerTimout(250);
                    console.log("RIG");
                    console.clear();
                    toastr.error('Employee Enrolled Failed', 'Error')
                    if(data.status === 422) {
                        var errors = $.parseJSON(data.responseText);
                        $.each(errors, function (i, errors) {
                            if(errors.employee_no){
                                $('#error_employee_no').html(errors.employee_no);
                                $('#error_employee_no').attr('hidden', false);
                                $('#employee_no').addClass('is-invalid');
                            }
                            if(errors.position){
                                $('#error_position').html(errors.position);
                                $('#error_position').attr('hidden', false);
                                $('#position').addClass('is-invalid');
                            }
                            if(errors.department){
                                $('#error_department').html(errors.department);
                                $('#error_department').attr('hidden', false);
                                $('#department').addClass('is-invalid');
                            }
                            if(errors.lastname){
                                $('#error_lastname').html(errors.lastname);
                                $('#error_lastname').attr('hidden', false);
                                $('#lastname').addClass('is-invalid');
                            }
                            if(errors.firstname){
                                $('#error_firstname').html(errors.firstname);
                                $('#error_firstname').attr('hidden', false);
                                $('#firstname').addClass('is-invalid');
                            }
                            if(errors.middlename){
                                $('#error_middlename').html(errors.middlename);
                                $('#error_middlename').attr('hidden', false);
                                $('#middlename').addClass('is-invalid');
                            }
                            if(errors.mobile_no){
                                $('#error_mobile_no').html(errors.mobile_no);
                                $('#error_mobile_no').attr('hidden', false);
                                $('#mobile_no').addClass('is-invalid');
                            }
                            if(errors.email_add){
                                $('#error_email_add').html(errors.email_add);
                                $('#error_email_add').attr('hidden', false);
                                $('#email_add').addClass('is-invalid');
                            }
                            if(errors.enrollment_date){
                                $('#error_enrollment_date').html(errors.enrollment_date);
                                $('#error_enrollment_date').attr('hidden', false);
                                $('#enrollment_date').addClass('is-invalid');
                            }
                            if(errors.employment_status){
                                $('#error_employment_status').html(errors.employment_status);
                                $('#error_employment_status').attr('hidden', false);
                                $('#employment_status').addClass('is-invalid');
                            }
                            if(errors.tin){
                                $('#error_TIN').html(errors.tin);
                                $('#error_TIN').attr('hidden', false);
                                $('#TIN').addClass('is-invalid');
                            }
                            if(errors.sssgsis){
                                $('#error_SSSGSIS').html(errors.sssgsis);
                                $('#error_SSSGSIS').attr('hidden', false);
                                $('#SSSGSIS').addClass('is-invalid');
                            }
                            if(errors.phic){
                                $('#error_PHIC').html(errors.phic);
                                $('#error_PHIC').attr('hidden', false);
                                $('#PHIC').addClass('is-invalid');
                            }
                            if(errors.hdmf){
                                $('#error_HDMF').html(errors.hdmf);
                                $('#error_HDMF').attr('hidden', false);
                                $('#HDMF').addClass('is-invalid');
                            }
                            if(errors.birthdate){
                                $('#error_birthdate').html(errors.birthdate);
                                $('#error_birthdate').attr('hidden', false);
                                $('#birthdate').addClass('is-invalid');
                            }
                            if(errors.nid){
                                $('#error_nid').html(errors.nid);
                                $('#nid').addClass('is-invalid');
                            }
                            if(errors.gender){
                                $('#error_gender').html(errors.gender);
                                $('#error_gender').attr('hidden', false);
                                $('#gender').addClass('is-invalid');
                            }
                            if(errors.civil_status){
                                $('#error_civil_status').html(errors.civil_status);
                                $('#error_civil_status').attr('hidden', false);
                                $('#civil_status').addClass('is-invalid');
                            }
                            if(errors.payroll_schedule){
                                $('#error_payroll_schedule').html(errors.payroll_schedule);
                                $('#error_payroll_schedule').attr('hidden', false);
                                $('#payroll_schedule').addClass('is-invalid');
                            }
                            if(errors.payroll_bank){
                                $('#error_payroll_bank').html(errors.payroll_bank);
                                $('#error_payroll_bank').attr('hidden', false);
                                $('#payroll_bank').addClass('is-invalid');
                            }
                            if(errors.account_no){
                                $('#error_account_no').html(errors.account_no);
                                $('#error_account_no').attr('hidden', false);
                                $('#account_no').addClass('is-invalid');
                            }
                            if(errors.country){
                                $('#error_country').html(errors.country);
                                $('#error_country').attr('hidden', false);
                                $('#country').addClass('is-invalid');
                            }
                            if(errors.address_unit){
                                $('#error_address_unit').html(errors.address_unit);
                                $('#error_address_unit').attr('hidden', false);
                                $('#address_unit').addClass('is-invalid');
                            }
                            if(errors.province){
                                $('#error_province').html(errors.province);
                                $('#error_province').attr('hidden', false);
                                $('#province').addClass('is-invalid');
                            }
                            if(errors.citytown){
                                $('#error_citytown').html(errors.citytown);
                                $('#error_citytown').attr('hidden', false);
                                $('#citytown').addClass('is-invalid');
                            }
                            if(errors.barangay){
                                $('#error_barangay').html(errors.barangay);
                                $('#error_barangay').attr('hidden', false);
                                $('#barangay').addClass('is-invalid');
                            }
                            if(errors.zipcode){
                                $('#error_zipcode').html(errors.zipcode);
                                $('#error_zipcode').attr('hidden', false);
                                $('#zipcode').addClass('is-invalid');
                            }
                        });
                    }
                }
            });
        }
        else
        {
            console.log("Error");
        }

        /*Function For Spinner*/
        function spinnerTimout(){
            setTimeout(function (){
                $("#spinnerload").removeClass('fa fa-refresh fa-spin');
                $('#formOverlay').removeClass('overlay');
            }, 1000);
        }       
        });

    //SEARCH EMPLOYEE
    $(document).on("click", "#btn_search", function(){
        var ess_id = $("#essid_search").val();
        $.ajax({
            headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            method: 'get',
            url: '/enrollemployee/searchemployee',           
            data: {essid: ess_id},
            dataType: 'JSON',
            success: function (data) {
                $('#employee_profile').removeAttr('hidden');
                $('#iform_employee_no').removeAttr('hidden');
                $('.iform_editablefield').attr('hidden',false);
                console.log(data.provDesc + ' '+  data.brgyDesc + ' ' + data.citymunDesc);

                let name =  {
                        firstname : data.firstname ,
                        middlename: data.middlename || '',
                        lastname : data.lastname ,
                        suffix : data.suffix  || ''
                }
                $('#employee_name').html(name.firstname + ' ' +name.middlename + ' ' + name.lastname + ' ' + name.suffix);

                $('#employee_address').html(data.address_unit + ' ' + data.provDesc + ' ' + data.citymunDesc + ' ' + data.brgyDesc);
                //
                //console.log
                $('#employee_email').html(data.email_add);
                $('#employee_mobileno').html(data.mobile_no);
                $('#employee_birthdate').html(data.birthdate);
                $('#employee_gender').html(data.gender);
                $('#employee_civilstatus').html(data.civil_status);
                $('#employee_tin').html(data.TIN);
                $('#employee_sssgsis').html(data.SSSGSIS);
                $('#employee_phic').html(data.PHIC);
                $('#employee_hdmf').html(data.HDMF);
                $('#employee_nid').html(data.NID);
                $("#suffix").val(data.suffix);
                $("#lastname").val(data.lastname);
                $("#firstname").val(data.firstname);
                $("#middlename").val(data.middlename);
                $("#TIN").val(data.TIN);
                $("#SSSGSIS").val(data.SSSGSIS);
                $("#PHIC").val(data.PHIC);
                $("#HDMF").val(data.HDMF);
                $("#nid").val(data.NID);
                $("#mobile_no").val(data.mobile_no);
                $("#email_add").val(data.email_add);
                $("#birthdate").val(data.birthdate);
                $("#gender").val(data.gender);
                $("#civil_status").val(data.civil_status);
                $("#country").val(data.country);
                $("#address_unit").val(data.address_unit);
                // $("#citytown").val(data.citytown);
                // $("#barangay").val(data.barangay);
                // $("#province").val(data.province);
                $("#zipcode").val(data.zipcode);
                $("#hidden_personalinfo_id").val(data.id);
                // auto complete fields
                $("#hidden_essid").val(data.ess_id);
                // Displays on the text fields
                //$('#employee_no').val(data.employee_no);
               // $('#enrollment_date').val(data.enrollment_date);
               // $('#department').val(data.department);
                //$('#employment_status').val(data.employment_status);
               // $('#payroll_schedule').val(data.payroll_schedule);
               // $('#payroll_bank').val(data.payroll_bank);
               // $('#account_no').val(data.account_no);
                //$('#position').val(data.position); 
                // 
                // Displays on the panel 
                //$('#employee_position').html(data.position);
               // $('#employee_enrollmentdate').html(data.enrollment_date); 
               // $('#employee_employeeno').html(""); 
               // $('#employee_accountno').html(data.account_no);
               // $('#employee_department').html(data.department);

                /******** Copies the actual value for displaying */

                $('#enrollment_date').on("change",function(){
                setTimeout(changevalue_enrollmentdate,0); 
                });

                var display_enrollment_date = $('#employee_enrollmentdate').text();
                var changevalue_enrollmentdate = () => {
                    var enrollment_date = $('#enrollment_date').val();
                    if (enrollment_date != display_enrollment_date){
                        $('#employee_enrollmentdate').html(enrollment_date);
                        enrollment_date = display_enrollment_date;
                    }
                }; 
                /// 

                $('#employee_no').on('keydown',function(){
                    setTimeout(changevalue_employeeno,0); 
                });  

                var display_employee_no = $('#employee_employeeno').text();
                var changevalue_employeeno = () => {
                    var employee_no = $('#employee_no').val();
                    if(employee_no != display_employee_no){
                        $('#employee_employeeno').html(employee_no); 
                        employee_no =  display_employee_no;
                    }
                }
                //  
              
                $('#account_no').on('keydown', function(){
                    setTimeout(changevalue_accountno,0); 
                });
                var display_accountno = $('#employee_accountno').text();
                var changevalue_accountno = () => {
                    var account_no = $('#account_no').val();
                    if(account_no !=  display_accountno ){
                        $('#employee_accountno').html(account_no); 
                        account_no =  display_accountno;
                    }
                } 
                //
                $('#department').on('keydown',function(){
                    setTimeout(changevalue_department,0);
                });
                var display_department = $('#employee_department');
                var changevalue_department = () => {
                    var department = $('#department').val();
                    if(display_department !=  department){
                        $('#employee_department').html(department);
                         department = display_department; 
                    }
                }

                $('#position').on('keydown', function(){
                    setTimeout(changevalue_position,0);
                });

                var display_position = $('#position');
                var changevalue_position = () => {
                    var position = $('#position').val();
                    if(display_position != position){
                        $('#employee_position').html(position);
                            department = display_position;
                    }
                }
                
                /*
                 * @ Check if the User has a Profile Picture or Null
                 */
                if(data.profifle_picture == null)
                {
                    $('#employee_profile_picture').attr('src', '/storage/pic.jpg');
                }
                else {
                    $('#employee_profile_picture').attr('src', '/storage/profile_picture/ESS_DEFAULT_PICTURE/' + data.profifle_picture);
                }
                
                

                $('#citytown option[value="'+data.citytown+'"]').prop('selected', true);
                $('#barangay option[value="'+data.barangay+'"]').prop('selected', true);
                $('#province option[value="'+data.province+'"]').prop('selected', true);
            },
            error: function(data) {
                toastr.remove()
                console.log("No employee Found")
                toastr.info('No Employee Found')
            }
        });
    });
});
</script>
@endsection