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
            <li class="breadcrumb-item active">Encode Employees</li>
        </ol>
    </div>
</div>
@endsection
@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header card-info card-outline">
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
                {{-- SEARCH FIELD --}}              
                {{-- <div class="form-inline">
                    <div class="col-md-1"></div>      
                    <div class="col-md-5 essid_field" hidden>               
                        <div class="form-group row">
                            <label for="essid_search" class="control-label">ESS ID / User ID</label>&nbsp;&nbsp;
                            <input id="essid_search" type="text" class="form-control" name="essid_search" placeholder="ESS ID / User ID" autofocus>&nbsp;&nbsp;
                            <input type="button" class="btn btn-primary" id="btn_search" value="Search">        
                        </div>                                         
                    </div>                     
                </div> --}}
                <div class="form-group row essid_field" hidden>
                        <label for="essid_search" class="col-md-2 text-md-center">ESS ID / User ID</label>
                        <div class="col-md-4">
                                
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="fa fa-user input-group-text"></span>
                                </div>
                                <input id="essid_search" type="text" class="form-control" name="essid_search" placeholder="ESS ID / User ID" autofocus>&nbsp;&nbsp;
                                <input type="button" class="btn btn-primary" id="btn_search" value="Search">
                            </div>
                            <p class="text-danger" id="error_business_name"></p>
                            
                        </div>
                        {{-- <label for="contactperson" class="col-md-2 text-md-center">Contact Person: </label>
                        <div class="col-md-4">
                            
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="fa fa-user input-group-text"></span>
                                </div>
                                <input id="contact_person" type="text" class="form-control" name="contact_person" placeholder="Contact Person"  autofocus>
                            </div>
                            <p class="text-danger" id="error_contact_person"></p>
                             --}}
                        {{-- </div> --}}
                </div>
                {{-- FIRST ROW --}}
                <div class="form-group row">
                        <label for="employee_no" class="col-md-2 text-md-center">Employee No. </label>
                        <div class="col-md-4">
                                
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="fa fa-user input-group-text"></span>
                                </div>
                                <input id="employee_no" type="text" class="form-control" name="employee_no" placeholder="Employee No"   autofocus>
                            </div>
                            <p class="text-danger text-md-center mb-6" id="error_employee_no"></p>
                        </div>
                </div>
                {{-- SECOND ROW --}}
                {{-- <div class="form-group row">
                    <div class="col-md-1"></div>            
                    <div class="col-md-5">
                        <label for="position" class="control-label text-md-center">Position :</label>               
                        <input id="position" type="text" class="form-control" name="position" placeholder="Position"   autofocus>
                        <p class="text-danger" id="error_position"></p>
                    </div>                 
                    
                    <div class="col-md-5">
                        <label for="department" class="control-label text-md-center">Department :</label>
                        <input id="department" type="text" class="form-control" name="department" placeholder="Department"   autofocus>
                        <p class="text-danger" id="error_department"></p>
                    </div>
                    <div class="col-md-1"></div>  
                </div> --}}
                <div class="form-group row">
                        <label for="position" class="col-md-2 text-md-center">Position :</label>
                        <div class="col-md-4">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="fa fa-user input-group-text"></span>
                                </div>
                                <input id="position" type="text" class="form-control" name="position" placeholder="Position"   autofocus>
                            </div>
                            <p class="text-danger text-md-center mb-6" id="error_position"></p>
                        </div>
                        <label for="department" class="col-md-2 text-md-center">Department :</label>
                        <div class="col-md-4">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="fa fa-user input-group-text"></span>
                                </div>
                                <input id="department" type="text" class="form-control" name="department" placeholder="Department"   autofocus>
                            </div>
                            <p class="text-danger text-md-center mb-6" id="error_department"></p>
                        </div>
                </div>
                {{-- THIRD ROW --}}
                {{-- <div class="form-group row">                   
                    <div class="col-md-1"></div>
                    <div class="col-md-5">
                        <label for="lastname" class="control-label text-md-center">Last Name :</label>               
                        <input id="lastname" type="text" class="form-control" name="lastname" placeholder="Last Name"   autofocus>
                        <p class="text-danger" id="error_lastname"></p>
                    </div>

                    <div class="col-md-5">
                        <label for="mobile_no" class="control-label text-md-center">Mobile No. :</label>
                        <input id="mobile_no" type="text" maxlength="11" class="form-control" name="mobile_no" placeholder="Mobile No." onKeyPress="return checknumber(event)"  autofocus>
                        <p class="text-danger" id="error_mobile_no"></p>
                    </div>
                    <div class="col-md-1"></div>
                </div> --}}
                <div class="form-group row">
                        <label for="lastname" class="col-md-2 text-md-center">Last Name :</label>   
                        <div class="col-md-4">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="fa fa-user input-group-text"></span>
                                </div>
                                <input id="lastname" type="text" class="form-control" name="lastname" placeholder="Last Name"   autofocus>
                            </div>
                            <p class="text-danger text-md-center mb-6" id="error_lastname"></p>
                        </div>
                        <label for="mobile_no" class="col-md-2 text-md-center">Mobile No. :</label>
                        <div class="col-md-4">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="fa fa-user input-group-text"></span>
                                </div>
                                <input id="mobile_no" type="text" maxlength="11" class="form-control" name="mobile_no" placeholder="Mobile No." onKeyPress="return checknumber(event)"  autofocus>
                            </div>
                            <p class="text-danger text-md-center mb-6" id="error_mobile_no"></p>
                        </div>
                </div>
                {{-- FOURTH ROW --}}
                {{-- <div class="form-group row">                  
                    <div class="col-md-1"></div> 
                    <div class="col-md-5">
                        <label for="firstname" class="control-label text-md-center">First Name :</label>               
                        <input id="firstname" type="text" class="form-control" name="firstname" placeholder="First Name"   autofocus>
                        <p class="text-danger" id="error_firstname"></p>
                    </div>
                                       
                    <div class="col-md-5">
                        <label for="email_add" class="control-label text-md-center">Email :</label>
                        <input id="email_add" type="email" class="form-control" name="email_add" placeholder="Email"   autofocus>
                        <p class="text-danger" id="error_email_add"></p>
                    </div>
                    <div class="col-md-1"></div>
                </div> --}}
                <div class="form-group row">
                        <label for="firstname" class="col-md-2 text-md-center">First Name :</label>  
                        <div class="col-md-4">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="fa fa-user input-group-text"></span>
                                </div>
                                <input id="firstname" type="text" class="form-control" name="firstname" placeholder="First Name"   autofocus>
                            </div>
                            <p class="text-danger text-md-center" id="error_firstname"></p>
                        </div>
                        <label for="email_add" class="col-md-2 text-md-center">Email :</label>
                        <div class="col-md-4">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="fa fa-user input-group-text"></span>
                                </div>
                                <input id="email_add" type="email" class="form-control" name="email_add" placeholder="Email"   autofocus>
                            </div>
                            <p class="text-danger text-md-center" id="error_email_add"></p>
                        </div>
                </div>
                {{-- FIFTH ROW --}}
                {{-- <div class="form-group row">
                    <div class="col-md-1"></div>                    
                    <div class="col-md-5">
                        <label for="middlename" class="control-label text-md-center">Middle Name :</label>               
                        <input id="middlename" type="text" class="form-control" name="middlename" placeholder="Middle Name"   autofocus>
                        <p class="text-danger" id="error_middlename"></p>
                    </div>
                  
                    <div class="col-md-5">
                        <label for="enrollment_date" class="control-label text-md-center">Enrollment Date :</label>
                        <input id="enrollment_date" type="date" class="form-control" name="enrollment_date" placeholder="Enrollment Date"   autofocus>
                        <p class="text-danger" id="error_enrollment_date"></p>
                    </div>
                    <div class="col-md-1"></div>
                </div> --}}
                <div class="form-group row">
                        <label for="middlename" class="col-md-2 text-md-center">Middle Name :</label>   
                        <div class="col-md-4">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="fa fa-user input-group-text"></span>
                                </div>
                                <input id="middlename" type="text" class="form-control" name="middlename" placeholder="Middle Name"   autofocus>
                            </div>
                            <p class="text-danger text-md-center" id="error_middlename"></p>
                        </div>
                        <label for="enrollment_date" class="col-md-2 text-md-center">Enrollment Date :</label>
                        <div class="col-md-4">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="fa fa-calendar input-group-text"></span>
                                </div>
                                <input id="enrollment_date" type="text" class="form-control datepicker" name="enrollment_date" placeholder="MM/DD/YYYY"   autofocus>
                            </div>
                            <p class="text-danger text-md-center" id="error_enrollment_date"></p>
                        </div>
                </div>
                {{-- SIXTH ROW --}}
                {{-- <div class="form-group row">                 
                    <div class="col-md-1"></div>
                    <div class="col-md-5">
                        <label for="TIN" class="control-label text-md-center">TIN :</label>               
                        <input id="TIN" type="text" class="form-control" name="tin" placeholder="TIN"   autofocus>
                        <p class="text-danger" id="error_TIN"></p>
                    </div>
                                     
                    <div class="col-md-5">
                        <label for="employment_status" class="control-label text-md-center">Employment Status :</label>
                        <select class="form-control" id="employment_status" name="employment_status">
                            <option value="">Select Options</option>
                            <option value="Contractual">Contractual</option>
                            <option value="Probationary">Probationary</option>
                            <option value="Permanent">Permanent</option>
                            <option value="Regular">Regular</option>
                        </select>
                        <p class="text-danger" id="error_employment_status"></p>
                    </div>
                    <div class="col-md-1"></div>
                </div> --}}
                <div class="form-group row">
                        <label for="TIN" class="col-md-2 text-md-center">TIN :</label>     
                        <div class="col-md-4">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="fa fa-address-card input-group-text"></span>
                                </div>
                                <input id="TIN" type="text" class="form-control" name="tin" placeholder="TIN"   autofocus>
                            </div>
                            <p class="text-danger text-md-center" id="error_TIN"></p>
                        </div>
                        <label for="employment_status" class="col-md-2 text-md-center">Employment Status :</label>
                        <div class="col-md-4">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="fa fa-user input-group-text"></span>
                                </div>
                                <select class="form-control" id="employment_status" name="employment_status">
                                        <option value="">Select Options</option>
                                        <option value="Contractual">Contractual</option>
                                        <option value="Probationary">Probationary</option>
                                        <option value="Permanent">Permanent</option>
                                        <option value="Regular">Regular</option>
                                    </select>
                            </div>
                            <p class="text-danger text-md-center" id="error_employment_status"></p>
                        </div>
                </div>
                {{-- SEVENTH ROW --}}
                {{-- <div class="form-group row">                 
                    <div class="col-md-1"></div>
                    <div class="col-md-5">               
                        <label for="SSSGSIS" class="control-label text-md-center">SSS/GSIS :</label>
                        <input id="SSSGSIS" type="text" class="form-control" name="sssgsis" placeholder="SSS/GSIS"   autofocus>
                        <p class="text-danger" id="error_SSSGSIS"></p>
                    </div>
                   
                    <div class="col-md-5">
                        <label for="birthdate" class="control-label text-md-center">Birthdate :</label>
                        <input id="birthdate" type="date" class="form-control" name="birthdate" placeholder="Birthdate"   autofocus>
                        <p class="text-danger" id="error_birthdate"></p>
                    </div>
                    <div class="col-md-1"></div>
                </div> --}}
                <div class="form-group row">
                        <label for="SSSGSIS" class="col-md-2 text-md-center">SSS/GSIS :</label>   
                        <div class="col-md-4">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="fa fa-address-card input-group-text"></span>
                                </div>
                                <input id="SSSGSIS" type="text" class="form-control" name="sssgsis" placeholder="SSS/GSIS"   autofocus>
                            </div>
                            <p class="text-danger text-md-center" id="error_SSSGSIS"></p>
                        </div>
                        <label for="birthdate" class="col-md-2 text-md-center">Birthdate :</label>
                        <div class="col-md-4">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="fa fa-calendar input-group-text"></span>
                                </div>
                                <input id="birthdate" type="text" class="form-control datepicker" name="birthdate" placeholder="MM/DD/YYYY"   autofocus>
                            </div>
                            <p class="text-danger text-md-center" id="error_birthdate"></p>
                        </div>
                </div>
                {{-- EIGHT ROW --}}
                {{-- <div class="form-group row">                   
                    <div class="col-md-1"></div>
                    <div class="col-md-5">
                        <label for="PHIC" class="control-label text-md-center">PHIC :</label>               
                        <input id="PHIC" type="text" class="form-control" name="phic" placeholder="PHIC" autofocus>
                        <p class="text-danger" id="error_PHIC"></p>
                    </div>
           
                    <div class="col-md-5">
                        <label for="gender" class="control-label text-md-center">Gender :</label>
                        <select class="form-control" id="gender" name="gender">
                            <option value="">Select Options</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>                               
                        </select>
                        <p class="text-danger" id="error_gender"></p>
                    </div>
                    <div class="col-md-1"></div>
                </div> --}}
                <div class="form-group row">
                        <label for="PHIC" class="col-md-2 text-md-center">PHIC :</label> 
                        <div class="col-md-4">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="fa fa-address-card input-group-text"></span>
                                </div>
                                <input id="PHIC" type="text" class="form-control" name="phic" placeholder="PHIC" autofocus>
                            </div>
                            <p class="text-danger text-md-center" id="error_PHIC"></p>
                        </div>
                        <label for="gender" class="col-md-2 text-md-center">Gender :</label>
                        <div class="col-md-4">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="fa fa-user input-group-text"></span>
                                </div>
                                <select class="form-control" id="gender" name="gender">
                                        <option value="">Select Options</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>                               
                                    </select>
                            </div>
                            <p class="text-danger text-md-center" id="error_gender"></p>
                        </div>
                </div>
                {{-- NINTH ROW --}}
                {{-- <div class="form-group row">
                    <div class="col-md-1"></div>                    
                    <div class="col-md-5">
                        <label for="HDMF" class="control-label text-md-center">HDMF :</label>               
                        <input id="HDMF" type="text" class="form-control" name="hdmf" placeholder="HDMF" autofocus>
                        <p class="text-danger" id="error_HDMF"></p>
                    </div>
              
                    <div class="col-md-5">
                        <label for="civil_status" class="control-label text-md-center">Civil Status :</label>
                        <select class="form-control" id="civil_status" name="civil_status">
                            <option value="">Select Options</option>
                            <option value="Single">Single</option>
                            <option value="Married">Married</option>
                            <option value="Widow">Widow</option>                                            
                        </select>
                        <p class="text-danger" id="error_civil_status"></p>
                    </div>
                    <div class="col-md-1"></div>
                </div> --}}
                <div class="form-group row">
                        <label for="HDMF" class="col-md-2 text-md-center">HDMF :</label> 
                        <div class="col-md-4">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="fa fa-address-card input-group-text"></span>
                                </div>
                                <input id="HDMF" type="text" class="form-control" name="hdmf" placeholder="HDMF" autofocus>
                            </div>
                            <p class="text-danger text-md-center" id="error_HDMF"></p>
                        </div>
                        <label for="civil_status" class="col-md-2 text-md-center">Civil Status :</label>
                        <div class="col-md-4">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="fa fa-user input-group-text"></span>
                                </div>
                                <select class="form-control" id="civil_status" name="civil_status">
                                        <option value="">Select Options</option>
                                        <option value="Single">Single</option>
                                        <option value="Married">Married</option>
                                        <option value="Widow">Widow</option>                                            
                                </select>
                            </div>
                            <p class="text-danger text-md-center" id="error_civil_status"></p>
                        </div>
                </div>
                {{-- TENTH ROW --}}
                {{-- <div class="form-group row">
                    <div class="col-md-1"></div>
                    <div class="col-md-5">
                        <label for="nid" class="control-label text-md-center">NID :</label>               
                        <input id="nid" type="text" class="form-control" name="nid" placeholder="NID" autofocus>
                        <p class="text-danger" id="error_nid"></p>
                    </div>
                
                    <div class="col-md-5">
                        <label for="payroll_schedule" class="control-label text-md-center">Payroll Schedule :</label>
                        <select class="form-control" id="payroll_schedule" name="payroll_schedule">
                            <option value="">Select Options</option>
                            <option value="Week">Weekly</option>
                            <option value="Month">Monthly</option>
                            <option value="2Month">2x Monthly</option>                                            
                        </select>
                        <p class="text-danger" id="error_payroll_schedule"></p>
                    </div>
                    <div class="col-md-1"></div>
                </div> --}}
                <div class="form-group row">
                        <label for="nid" class="col-md-2 text-md-center">NID :</label> 
                        <div class="col-md-4">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="fa fa-address-card input-group-text"></span>
                                </div>
                                <input id="nid" type="text" class="form-control" name="nid" placeholder="NID" autofocus>
                            </div>
                            <p class="text-danger text-md-center" id="error_nid"></p>
                        </div>
                        <label for="payroll_schedule" class="col-md-2 text-md-center">Payroll Schedule :</label>
                        <div class="col-md-4">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="fa fa-calendar input-group-text"></span>
                                </div>
                                <select class="form-control" id="payroll_schedule" name="payroll_schedule">
                                        <option value="">Select Options</option>
                                        <option value="Week">Weekly</option>
                                        <option value="Month">Monthly</option>
                                        <option value="2Month">2x Monthly</option>                                            
                                </select>
                            </div>
                            <p class="text-danger text-md-center" id="error_payroll_schedule"></p>
                        </div>
                </div>
                {{-- ELEVENTH ROW --}}
                {{-- <div class="form-group row">
                    <div class="col-md-1"></div>
                    <div class="col-md-5">
                        <label for="payroll_bank" class="control-label text-md-center">Payroll Bank :</label>
                        <select class="form-control" id="payroll_bank" name="payroll_bank">
                            <option value="">Select Options</option>
                            <option value="BDO">BANCO DE ORO</option>                                                              
                        </select>
                        <p class="text-danger" id="error_payroll_bank"></p>
                    </div>
           
                    <div class="col-md-5">
                        <label for="account_no" class="control-label text-md-center">Account No. :</label>               
                        <input id="account_no" type="text" class="form-control" name="account_no" placeholder="Account Number" autofocus>
                        <p class="text-danger" id="error_account_no"></p>
                    </div>
                    <div class="col-md-1"></div>                   
                </div> --}}
                <div class="form-group row">
                        <label for="payroll_bank" class="col-md-2 text-md-center">Payroll Bank :</label>
                        <div class="col-md-4">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="fa fa-address-card input-group-text"></span>
                                </div>
                                <select class="form-control" id="payroll_bank" name="payroll_bank">
                                        <option value="">Select Options</option>
                                        <option value="BDO">BANCO DE ORO</option>                                                              
                                </select>
                            </div>
                            <p class="text-danger text-md-center" id="error_payroll_bank"></p>
                        </div>
                        <label for="account_no" class="col-md-2 text-md-center">Account No. :</label>  
                        <div class="col-md-4">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="fa fa-user input-group-text"></span>
                                </div>
                                <input id="account_no" type="text" class="form-control" name="account_no" placeholder="Account Number" autofocus>
                            </div>
                            <p class="text-danger text-md-center" id="error_account_no"></p>
                        </div>
                </div>

                <hr>
                {{-- <label class="control-label text-md-center">Present Address</label>

                <div class="form-group row">
                    <div class="col-md-1"></div>                  
                    <div class="col-md-5">  
                        <label for="country" class="text-md-center">Country:</label>                
                        <select id="country" name="country" class="form-control">
                            <option value="">Choose Country</option>
                            <option value="Phillipines">Philippines</option>
                        </select>
                            <p class="text-danger" id="error_country"></p>
                    </div>
                   
                    <div class="col-md-5">
                        <label for="address_unit" class="text-md-center">Unit:</label>                      
                        <input id="address_unit" type="text" class="form-control" name="address_unit" placeholder="Address Unit"  autofocus>
                                <p class="text-danger" id="error_address_unit"></p>
                    </div>
                    <div class="col-md-1"></div>
                </div> --}}
                <label class="control-label text-md-center">Present Address</label>
                <div class="form-group row">
                        <label class="col-md-2 text-md-center">Country:</label>
                        <div class="col-md-4">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="fa fa-address-card input-group-text"></span>
                                </div>
                                <select id="country" name="country" class="form-control">
                                        <option value="">Choose Country</option>
                                        <option value="Phillipines">Philippines</option>
                                </select>
                            </div>
                            <p class="text-danger text-md-center" id="error_country"></p>
                        </div>
                        <label for="address_unit" class="col-md-2 text-md-center">Unit:</label>  
                        <div class="col-md-4">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="fa fa-user input-group-text"></span>
                                </div>
                                <input id="address_unit" type="text" class="form-control" name="address_unit" placeholder="Address Unit"  autofocus>
                            </div>
                            <p class="text-danger text-md-center" id="error_address_unit"></p>
                        </div>
                </div>

                {{-- <div class="form-group row">
                    <div class="col-md-1"></div>                  
                    <div class="col-md-5">
                        <label for="province" class="text-md-center">Province:</label>
                        <select id="province" name="province" class="form-control">
                            <option value="" selected>Choose Province</option>
                        </select>
                            <p class="text-danger" id="error_province"></p>
                    </div>
                    
                    <div class="col-md-5">
                        <label for="citytown" class="text-md-center">City/Town:</label>
                        <select id="citytown" name="citytown" class="form-control">
                            <option value="" selected>Choose City/Town</option>
                        </select>
                            <p class="text-danger" id="error_citytown"></p>
                    </div>
                                     
                    
                    <div class="col-md-1"></div>
                </div> --}}

                <div class="form-group row">
                        <label for="province" class="col-md-2 text-md-center">Province:</label>
                        <div class="col-md-4">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="fa fa-address-card input-group-text"></span>
                                </div>
                                <select id="province" name="province" class="form-control">
                                        <option value="" selected>Choose Province</option>
                                </select>
                            </div>
                            <p class="text-danger text-md-center" id="error_province"></p>
                        </div>
                        <label for="citytown" class="col-md-2 text-md-center">City/Town:</label>
                        <div class="col-md-4">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="fa fa-user input-group-text"></span>
                                </div>
                                <select id="citytown" name="citytown" class="form-control">
                                        <option value="" selected>Choose City/Town</option>
                                </select>
                            </div>
                            <p class="text-danger text-md-center" id="error_citytown"></p>
                        </div>
                </div>

                {{-- <div class="form-group row">
                    <div class="col-md-1"></div>                                   
                    <div class="col-md-5">
                        <label for="barangay" class="text-md-center">Barangay:</label>
                        <select id="barangay" name="barangay" class="form-control">
                            <option value="" selected>Choose Barangay</option>
                        </select>
                            <p class="text-danger" id="error_barangay"></p>
                    </div>
                                        
                    <div class="col-md-5">
                        <label for="zipcode" class="text-md-center">Zipcode:</label>                      
                        <input id="zipcode" type="text" class="form-control" name="zipcode" placeholder="Address Zipcode"  autofocus>
                                <p class="text-danger" id="error_zipcode"></p>
                    </div>
                    <div class="col-md-1"></div>
                </div> --}}
                <div class="form-group row">
                        <label for="barangay" class="col-md-2 text-md-center">Barangay:</label>
                        <div class="col-md-4">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="fa fa-address-card input-group-text"></span>
                                </div>
                                <select id="barangay" name="barangay" class="form-control">
                                        <option value="" selected>Choose Barangay</option>
                                </select>
                            </div>
                            <p class="text-danger text-md-center" id="error_barangay"></p>
                        </div>
                        <label for="zipcode" class="col-md-2 text-md-center">Zipcode:</label> 
                        <div class="col-md-4">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="fa fa-user input-group-text"></span>
                                </div>
                                <input id="zipcode" type="text" class="form-control" name="zipcode" placeholder="Address Zipcode"  autofocus>
                            </div>
                            <p class="text-danger text-md-center" id="error_zipcode"></p>
                        </div>
                </div>          
            </div>           
        </form>
        <div class="" id="formOverlay">
            <i class="" id="spinner"></i>
        </div>
          <!-- end loading -->
        <div class="card-footer">
            {{-- <button type="button" class="btn btn-default">Back</button> --}}
            <button type="submit" class="btn btn-primary float-right" id="submit">Submit <i id="spinner" class=""></i></button>
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
        startDate: date
    });
    /*Get Province*/
    $.ajax({
			method: 'get',
            url: '/enrollemployee/getprovince',
            dataType: 'json',
			success: function (data) {
                // console.log("success");
                // console.log(data);
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
                        // console.log("success");
                        // console.log(data);
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
                    // console.log("success");
                    // console.log(data);
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
            // console.log("labas textbox");
            $(".essid_field").removeAttr("hidden");
        }
        else if(shift == "new_employee")
        {
            //Reset The form
            $('#EmployeeForm')[0].reset();
            // console.log("wala textbox");
            $(".essid_field").attr("hidden", true)
        }
    });
    

    //submit
    $(document).on("click", "#submit", function(){
        $('#formOverlay').addClass('overlay');
        $("#spinner").addClass('fa fa-refresh fa-spin');
        
        //$("#employer_id").removeAttr("disabled");

        error = 0;
        employee_no = $("#employee_no").val();
        //employer_id = $("#employer_id").val();
        position = $("#position").val();
        department = $("#department").val();
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
                    spinnerTimout(3000);
                    toastr.success('Employee Enrolled Successfully', 'Success')
                    $('#EmployeeForm')[0].reset();
                },
                error: function (data, status) {
                    spinnerTimout(250);
                    console.log("RIG");
                    toastr.error('Employee Enrolled Failed', 'Error')
                    if(data.status === 422) {
                    //console.log("422");
                        var errors = $.parseJSON(data.responseText);
                        //console.log(errors.errors.accountname);
                        $.each(errors, function (i, errors) {
                            //console.log(errors);
                            /**/
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
        function spinnerTimout(time){
            setTimeout(function (){
                $("#spinner").removeClass('fa fa-refresh fa-spin');
                $('#formOverlay').removeClass('overlay');
            }, time);
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
                $("#hidden_essid").val(data.ess_id);
                $('#employee_no').val(data.employee_no);
                $('#enrollment_date').val(data.enrollment_date);
                $('#department').val(data.department);
                $('#employment_status').val(data.employment_status);
                $('#payroll_schedule').val(data.payroll_schedule);
                $('#payroll_bank').val(data.payroll_bank);
                $('#account_no').val(data.account_no);
                $('#position').val(data.position);
                

                $('#citytown option[value="'+data.citytown+'"]').prop('selected', true);
                $('#barangay option[value="'+data.barangay+'"]').prop('selected', true);
                $('#province option[value="'+data.province+'"]').prop('selected', true);
            }
        });
    });
});
</script>
@endsection