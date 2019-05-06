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
        <div class="card-header">
            <center><strong>Encode Employees</strong></center>
        </div>
        <form id="EmployeeForm">
        @csrf
            <div class="card-body">          
                {{-- FIRST ROW --}}
                <div class="form-group row">
                    <div class="col-md-1"></div>      
                    <div class="col-md-5">               
                        <label for="employee_no" class="control-label text-md-center">Employee No. </label>
                        <input id="employee_no" type="text" class="form-control" name="employee_no" placeholder="Employee No"   autofocus>
                        <p class="text-danger" id="error_employee_no"></p>
                    </div>               
                    
                    <div class="col-md-5">
                        <label for="employer_id" class="control-label text-md-center">Employer ID :</label>
                        <input id="employer_id" type="text" class="form-control" name="employer_id" placeholder="Employer Id"   autofocus>
                        <p class="text-danger" id="error_employer_id"></p>
                    </div>
                    <div class="col-md-1"></div>  
                </div>
                {{-- SECOND ROW --}}
                <div class="form-group row">
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
                </div>
                {{-- THIRD ROW --}}
                <div class="form-group row">                   
                    <div class="col-md-1"></div>
                    <div class="col-md-5">
                        <label for="last_name" class="control-label text-md-center">Last Name :</label>               
                        <input id="last_name" type="text" class="form-control" name="last_name" placeholder="Last Name"   autofocus>
                        <p class="text-danger" id="error_last_name"></p>
                    </div>

                    <div class="col-md-5">
                        <label for="mobile" class="control-label text-md-center">Mobile No. :</label>
                        <input id="mobile" type="number" maxlength="11" class="form-control" name="mobile" placeholder="Mobile No."   autofocus>
                        <p class="text-danger" id="error_mobile"></p>
                    </div>
                    <div class="col-md-1"></div>
                </div>
                {{-- FOURTH ROW --}}
                <div class="form-group row">                  
                    <div class="col-md-1"></div> 
                    <div class="col-md-5">
                        <label for="last_name" class="control-label text-md-center">First Name :</label>               
                        <input id="first_name" type="text" class="form-control" name="first_name" placeholder="First Name"   autofocus>
                        <p class="text-danger" id="error_first_name"></p>
                    </div>
                                       
                    <div class="col-md-5">
                        <label for="email_add" class="control-label text-md-center">Email :</label>
                        <input id="email_add" type="email" class="form-control" name="email_add" placeholder="Email"   autofocus>
                        <p class="text-danger" id="error_email_add"></p>
                    </div>
                    <div class="col-md-1"></div>
                </div>
                {{-- FIFTH ROW --}}
                <div class="form-group row">
                    <div class="col-md-1"></div>                    
                    <div class="col-md-5">
                        <label for="middle_name" class="control-label text-md-center">Middle Name :</label>               
                        <input id="middle_name" type="text" class="form-control" name="middle_name" placeholder="Middle Name"   autofocus>
                        <p class="text-danger" id="error_middle_name"></p>
                    </div>
                  
                    <div class="col-md-5">
                        <label for="enrollment_date" class="control-label text-md-center">Enrollment Date :</label>
                        <input id="enrollment_date" type="date" class="form-control" name="enrollment_date" placeholder="Enrollment Date"   autofocus>
                        <p class="text-danger" id="error_enrollment_date"></p>
                    </div>
                    <div class="col-md-1"></div>
                </div>
                {{-- SIXTH ROW --}}
                <div class="form-group row">                 
                    <div class="col-md-1"></div>
                    <div class="col-md-5">
                        <label for="tin" class="control-label text-md-center">TIN :</label>               
                        <input id="tin" type="text" class="form-control" name="tin" placeholder="TIN"   autofocus>
                        <p class="text-danger" id="error_tin"></p>
                    </div>
                                     
                    <div class="col-md-5">
                        <label for="employment_status" class="control-label text-md-center">Employment Status :</label>
                        <select class="form-control" id="cmb_employment_status" name="cmb_employment_status">
                            <option value="">Select Options</option>
                            <option value="Contractual">Contractual</option>
                            <option value="Probationary">Probationary</option>
                            <option value="Permanent">Permanent</option>
                            <option value="Regular">Regular</option>
                        </select>
                        <p class="text-danger" id="error_cmb_employment_status"></p>
                    </div>
                    <div class="col-md-1"></div>
                </div>
                {{-- SEVENTH ROW --}}
                <div class="form-group row">                 
                    <div class="col-md-1"></div>
                    <div class="col-md-5">               
                        <label for="sss" class="control-label text-md-center">SSS/GSIS :</label>
                        <input id="sss" type="text" class="form-control" name="sss" placeholder="SSS"   autofocus>
                        <p class="text-danger" id="error_sss"></p>
                    </div>
                   
                    <div class="col-md-5">
                        <label for="bithdate" class="control-label text-md-center">Birthdate :</label>
                        <input id="bithdate" type="date" class="form-control" name="bithdate" placeholder="Birthdate"   autofocus>
                        <p class="text-danger" id="error_bithdate"></p>
                    </div>
                    <div class="col-md-1"></div>
                </div>
                {{-- EIGHT ROW --}}
                <div class="form-group row">                   
                    <div class="col-md-1"></div>
                    <div class="col-md-5">
                        <label for="phic" class="control-label text-md-center">PHIC :</label>               
                        <input id="phic" type="text" class="form-control" name="phic" placeholder="PHIC" autofocus>
                        <p class="text-danger" id="error_phic"></p>
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
                </div>
                {{-- NINTH ROW --}}
                <div class="form-group row">
                    <div class="col-md-1"></div>                    
                    <div class="col-md-5">
                        <label for="hdmf" class="control-label text-md-center">HDMF :</label>               
                        <input id="hdmf" type="text" class="form-control" name="hdmf" placeholder="HDMF" autofocus>
                        <p class="text-danger" id="error_hdmf"></p>
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
                </div>
                {{-- TENTH ROW --}}
                <div class="form-group row">
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
                </div>
                {{-- ELEVENTH ROW --}}
                <div class="form-group row">
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
                </div>

                <hr>
                <label class="control-label text-md-center">Present Address</label>

                <div class="form-group row">
                    <div class="col-md-1"></div>                  
                    <div class="col-md-5">  
                        <label for="address_country" class="text-md-center">Country:</label>                
                        <select id="address_country" name="address_country" class="form-control">
                            <option value="">Choose Country</option>
                            <option value="Phillipines">Philippines</option>
                        </select>
                            <p class="text-danger" id="error_address_country"></p>
                    </div>
                   
                    <div class="col-md-5">
                        <label for="address_unit" class="text-md-center">Unit:</label>                      
                        <input id="address_unit" type="text" class="form-control" name="address_unit" placeholder="Address Unit"  autofocus>
                                <p class="text-danger" id="error_address_unit"></p>
                    </div>
                    <div class="col-md-1"></div>
                </div>

                <div class="form-group row">
                    <div class="col-md-1"></div>                  
                    <div class="col-md-5">
                        <label for="address_cityprovince" class="col-md-2 text-md-center">Province:</label>
                        <select id="address_cityprovince" name="address_cityprovince" class="form-control">
                            <option value="" selected>Choose Province</option>
                        </select>
                            <p class="text-danger" id="error_address_cityprovince"></p>
                    </div>
                    
                    <div class="col-md-5">
                        <label for="address_town" class="text-md-center">City/Town:</label>
                        <select id="address_town" name="address_town" class="form-control">
                            <option value="" selected>Choose City/Town</option>
                        </select>
                            <p class="text-danger" id="error_address_town"></p>
                    </div>
                                     
                    
                    <div class="col-md-1"></div>
                </div>

                <div class="form-group row">
                    <div class="col-md-1"></div>                                   
                    <div class="col-md-5">
                        <label for="address_barangay" class="text-md-center">Barangay:</label>
                        <select id="address_barangay" name="address_barangay" class="form-control">
                            <option value="" selected>Choose Barangay</option>
                        </select>
                            <p class="text-danger" id="error_address_barangay"></p>
                    </div>
                                        
                    <div class="col-md-5">
                        <label for="address_zipcode" class="text-md-center">Zipcode:</label>                      
                        <input id="address_zipcode" type="text" class="form-control" name="address_zipcode" placeholder="Address Zipcode"  autofocus>
                                <p class="text-danger" id="error_address_zipcode"></p>
                    </div>
                    <div class="col-md-1"></div>
                </div>          
            </div>
            <div class="card-footer">
                <button type="button" class="btn btn-default">Back</button>
                <button type="submit" class="btn btn-primary float-right" id="submit">Submit <i id="spinner" class=""></i></button>
            </div>  
        </form>            
    </div>      
</div>
<script>
$(document).ready(function(){
    /*Get Province*/
    $.ajax({
			method: 'get',
            url: '/enrollemployee/getprovince',
            dataType: 'json',
			success: function (data) {
                // console.log("success");
                // console.log(data);
                $.each(data, function (i, data) {
                    $("#address_cityprovince").append('<option value="' + data.provCode + '">' + data.provDesc + '</option>');
                });
			},
			error: function (response) {
					console.log("Error cannot be");
			}
    });

    /*Get City town*/
    $('#address_cityprovince').change(function (){
        $("#address_town").empty();
        $code = $('#address_cityprovince').val();
        $.ajax({
                method: 'get',
                url: '/enrollemployee/getcity/' + $code,
                dataType: 'json',
                success: function (data) {
                    // console.log("success");
                    // console.log(data);
                    $("#address_town").append('<option value="">Choose City/Town</option>');
                    $.each(data, function (i, data) {
                        $("#address_town").append('<option value="' + data.citymunCode + '">' + data.citymunDesc + '</option>');
                    });
                },
                error: function (response) {
                        console.log("Error cannot be");
                }
        });
    });

    /*Get Barangay*/
    $('#address_town').change(function (){
        $("#address_barangay").empty();
        $code = $('#address_town').val();
        $.ajax({
                method: 'get',
                url: '/enrollemployee/getbarangay/' + $code,
                dataType: 'json',
                success: function (data) {
                    // console.log("success");
                    // console.log(data);
                    $("#address_barangay").append('<option value="">Choose Barangay</option>');
                    $.each(data, function (i, data) {
                        $("#address_barangay").append('<option value="' + data.id + '">' + data.brgyDesc + '</option>');
                    });
                },
                error: function (response) {
                        console.log("Error cannot be");
                }
        });
    });
});
</script>
@endsection