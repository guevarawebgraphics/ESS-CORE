@extends('layouts.master')
@section('crumb')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="m-0 text-dark">Create Profile</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
                <a href="#">Create Profile</a>
            </li>
            <li class="breadcrumb-item active-create-account text-secondary">Create Account</li>
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
    <!-- general form elements -->
    <div class="card card-custom-blue card-outline">
        <div class="card-header">
          <h3 class="card-title"><i class="fa fa-edit"></i> Create Account</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form id="AccountForm">
            <!-- CSRF Token -->
            @csrf
          <div class="card-body">
                <label class="custom-flat-label">Business Information</label>
                <div class="form-group row mt-4">
                        
                        <div class="col-md-5">
            
                            <div class="input-group mb-3">
                                {{-- <div class="input-group-prepend">
                                    <span class="fa fa-user input-group-text"></span>
                                </div> --}}
                                <label for="business_name" class="control-label col-md-12 text-md-left custom-flat-label">Business Name:</label>
                                <input id="business_name" type="text" class="form-control custom-flat-input " name="business_name" placeholder="Business Name"   autofocus>
                            </div>
                            <p class="text-danger" id="error_business_name"></p>
                            
                        </div>
                        
                        <div class="col-md-5">
                            
                            <div class="input-group mb-3">
                                {{-- <div class="input-group-prepend">
                                    <span class="fa fa-user input-group-text"></span>
                                </div> --}}
                                <label for="accountname" class="col-md-12 text-md-left custom-flat-label">Account Name:</label>
                                <input id="accountname" type="text" class="form-control custom-flat-input" name="accountname" placeholder="Account Name"  autofocus>
                            </div>
                            <p class="text-danger" id="error_accountname"></p>
                            
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
                            
                        </div> --}}
                </div>

                <div class="form-group row">
                       
                        {{-- <label for="contact_phone" class="col-md-2 text-md-center">Phone: </label>
                        <div class="col-md-4">
                            
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="fa fa-phone input-group-text"></span>
                                </div>
                                <input id="contact_phone" type="text" class="form-control" name="contact_phone" placeholder="Contact Phone"  autofocus>
                            </div>
                            <p class="text-danger" id="error_contact_phone"></p>
                            
                        </div> --}}
                </div>
                {{-- Business Address Row --}}
                <hr>
                <label class="custom-flat-label">Business Address</label>
                <div class="form-group row mt-4">
                   
                        
                        <div class="col-md-5">
                            
                            <div class="input-group mb-3">
                                {{-- <div class="input-group-prepend">
                                    <span class="fa fa-address-card input-group-text"></span>
                                </div> --}}
                                <label for="address_unit" class="col-md-12 text-md-left custom-flat-label">Unit:</label>
                                <input id="address_unit" type="text" class="form-control custom-flat-input" name="address_unit" placeholder="Address Unit"  autofocus>
                            </div>
                            <p class="text-danger" id="error_address_unit"></p>
                            
                        </div>

                        
                            <div class="col-md-5">
                                
                                <div class="input-group mb-3">
                                    {{-- <div class="input-group-prepend">
                                        <span class="fa fa-globe input-group-text"></span>
                                    </div> --}}
                                    <label for="address_country" class="col-md-12 text-md-left custom-flat-label">Country:</label>
                                    <select id="address_country" name="address_country" class="form-control custom-flat-select">
                                            {{-- <option value="" selected>Choose Country...</option> --}}
                                            <option>Philippines</option>
                                    </select>
                                </div>
                                <p class="text-danger" id="error_address_country"></p>
                                    
                            </div>

                        
                            <div class="col-md-5">
                                
                                <div class="input-group mb-3">
                                    {{-- <div class="input-group-prepend">
                                        <span class="fa fa-globe input-group-text"></span>
                                    </div> --}}
                                    <label for="address_cityprovince" class="col-md-12 text-md-left custom-flat-label">Province:</label>
                                    <select id="address_cityprovince" name="address_cityprovince" class="form-control custom-flat-select">
                                            <option value="" selected>Choose Province...</option>
                                    </select>
                                </div>
                                <p class="text-danger" id="error_address_cityprovince"></p>
                                    
                            </div>

                        
                            <div class="col-md-5">
                                
                                <div class="input-group mb-3">
                                    {{-- <div class="input-group-prepend">
                                        <span class="fa fa-globe input-group-text"></span>
                                    </div> --}}
                                    <label for="address_town" class="col-md-12 text-md-left custom-flat-label">City/Town:</label>
                                    <select id="address_town" name="address_town" class="form-control custom-flat-select">
                                        <option value="" selected>Choose CityTown...</option>
                                    </select>
                                </div>
                                <p class="text-danger" id="error_address_town"></p>
                            </div>


                        
                            <div class="col-md-5">

                                    <div class="input-group mb-3">
                                        {{-- <div class="input-group-prepend">
                                            <span class="fa fa-globe input-group-text"></span>
                                        </div> --}}
                                        <label for="address_barangay" class="col-md-12 text-md-left custom-flat-label">Barangay:</label>
                                        <select id="address_barangay" name="address_barangay" class="form-control custom-flat-select">
                                                <option value="" selected>Choose Barangay...</option>
                                        </select>
                                    </div>
                                    <p class="text-danger" id="error_address_barangay"></p>
                            </div>
                         
                            <div class="col-md-5">
                                
                                <div class="input-group mb-3">
                                    {{-- <div class="input-group-prepend">
                                        <span class="fa fa-address-card input-group-text"></span>
                                    </div> --}}
                                    <label for="address_zipcode" class="col-md-12 text-md-left custom-flat-label">ZipCode: </label>
                                    <input id="address_zipcode" type="text" class="form-control custom-flat-input" name="address_zipcode" placeholder="Address Zipcode"  autofocus>
                                </div>
                                <p class="text-danger" id="error_address_zipcode"></p>
                            </div>
                </div>
                

                {{-- ----------------------------------------------------------------------------------------------------- --}}
                {{-- Contact Information Row --}}
                <hr>
                <label class="custom-flat-label">Contact Information</label>
                <div class="form-group row mt-4">

                    
                    <div class="col-md-5">
                        
                        <div class="input-group mb-3">
                            {{-- <div class="input-group-prepend">
                                <span class="fa fa-phone input-group-text"></span>
                            </div> --}}
                            <label for="contact_mobile" class="col-md-12 text-md-left custom-flat-label">Mobile: </label>
                            <input id="contact_mobile" type="text" class="form-control custom-flat-input" name="contact_mobile" placeholder="Contact Mobile" maxlength="11"  autofocus>
                        </div>
                        <p class="text-danger" id="error_contact_mobile"></p>
                        
                    </div>

                   
                    <div class="col-md-5">
                        
                        <div class="input-group mb-3">
                            {{-- <div class="input-group-prepend">
                                <span class="fa fa-phone input-group-text"></span>
                            </div> --}}
                            <label for="contact_phone" class="col-md-12 text-md-left custom-flat-label">Phone: </label>
                            <input id="contact_phone" type="text" class="form-control custom-flat-input" name="contact_phone" placeholder="Contact Phone"  autofocus>
                        </div>
                        <p class="text-danger" id="error_contact_phone"></p>
                        
                    </div>

                    
                    <div class="col-md-5">
                        
                        <div class="input-group mb-3">
                            {{-- <div class="input-group-prepend">
                                <span class="fa fa-envelope input-group-text"></span>
                            </div> --}}
                            <label for="contact_email" class="col-md-12 text-md-left custom-flat-label">Email: </label>
                            <input id="contact_email" type="email" class="form-control custom-flat-input" name="contact_email" placeholder="Contact Email"  autofocus>
                        </div>
                        <p class="text-danger" id="error_contact_email"></p>
                        
                    </div>

                    
                        <div class="col-md-5">
                            
                            <div class="input-group mb-3">
                                {{-- <div class="input-group-prepend">
                                    <span class="fa fa-user input-group-text"></span>
                                </div> --}}
                                <label for="contactperson" class="col-md-12 text-md-left custom-flat-label">Contact Person: </label>
                                <input id="contact_person" type="text" class="form-control custom-flat-input" name="contact_person" placeholder="Contact Person"  autofocus>
                            </div>
                            <p class="text-danger" id="error_contact_person"></p>
                            
                        </div>

                </div>

                {{-- ----------------------------------------------------------------------------------------------------- --}}
                {{-- Goverment Numbers Row --}}
                <hr>
                <label class="custom-flat-label">Government Number</label>
                <div class="form-group row mt-4">
                        
                        <div class="col-md-5">
                            

                            <div class="input-group mb-3">
                                {{-- <div class="input-group-prepend">
                                    <div class="span fa fa-address-card input-group-text"></div>
                                </div> --}}
                                <label for="tin" class="col-md-12 text-md-left custom-flat-label">Tin: </label>
                                <input id="tin" type="text" class="form-control custom-flat-input" name="tin" placeholder="Tin" autofocus>
                            </div>
                            <p class="text-danger" id="error_tin"></p>
                        </div>

                        
                        <div class="col-md-5">
                            
                            <div class="input-group mb-3">
                                {{-- <div class="input-group-prepend">
                                    <span class="fa fa-address-card input-group-text"></span>
                                </div> --}}
                                <label for="sss" class="col-md-12 text-md-left custom-flat-label">SSS/GSIS: </label>
                                <input id="sss" type="text" class="form-control custom-flat-input" name="sss" placeholder="SSS"  autofocus>
                            </div>
                            <p class="text-danger" id="error_sss"></p>
                        </div>

                        
                        <div class="col-md-5">
                            
                            <div class="input-group mb-3">
                                {{-- <div class="input-group-prepend">
                                    <span class="fa fa-address-card input-group-text"></span>
                                </div> --}}
                                <label for="phic" class="col-md-12 text-md-left custom-flat-label">Phic: </label>
                                <input id="phic" type="text" class="form-control custom-flat-input" name="phic" placeholder="Phic"  autofocus>
                            </div>
                            <p class="text-danger" id="error_phic"></p>
                        </div>

                        
                        <div class="col-md-5">
                            
                            <div class="input-group mb-3">
                                {{-- <div class="input-group-prepend">
                                    <span class="fa fa-address-card input-group-text"></span>
                                </div> --}}
                                <label for="hdmf" class="col-md-12 text-md-left custom-flat-label">HDMF: </label>
                                <input id="hdmf" type="text" class="form-control custom-flat-input" name="hdmf" placeholder="Hdmf"  autofocus>
                            </div>
                            <p class="text-danger" id="error_hdmf"></p>
                        </div>

                        
                        <div class="col-md-5">
                            
                            <div class="input-group mb-3">
                                {{-- <div class="input-group-prepend">
                                    <span class="fa fa-address-card input-group-text"></span>
                                </div> --}}
                                <label for="nid" class="col-md-12 text-md-left custom-flat-label">NID: </label>
                                <input id="nid" type="nid" class="form-control custom-flat-input" name="nid" placeholder="Nid"  autofocus>
                            </div>
                            <p class="text-danger" id="error_nid"></p>
                        </div>
                </div>


                {{-- ---------------------------------------------------------------------- --}}
                {{-- Account Information Row --}}
                <hr>
                <label class="custom-flat-label">Account Information</label>
                <div class="form-group row mt-4">
                        
                        <div class="col-md-5">
                            
                                <div class="input-group mb-3">
                                    {{-- <div class="input-group-prepend">
                                        <span class="fa fa-user input-group-text"></span>
                                    </div> --}}
                                    <label for="user_type" class="col-md-12 text-md-left custom-flat-label">Account Type:</label>
                                    <select id="user_type" name="user_type" class="form-control custom-flat-select">
                                            <option value="" selected>Choose Account Type...</option>
                                    </select>
                                </div>
                                <p class="text-danger" id="error_user_type"></p>
                        </div>
                        
                        
                        <div class="col-md-5">
                            
                            <div class="input-group mb-3">
                                {{-- <div class="input-group-prepend">
                                    <span class="fa fa-calendar input-group-text"></span>
                                </div> --}}
                                <label for="enrollmentdate" class="col-md-12 text-md-left custom-flat-label">Enrollment Date: </label>
                                <input id="enrollmentdate" type="date" class="form-control datepicker custom-flat-input" name="enrollmentdate" disabled="true"  style="background-color: #c4c0c0 !important;">
                            </div>
                            @if ($errors->has('enrollmentdate'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('enrollmentdate') }}</strong>
                                </span>
                            @endif
                        </div>

                        
                        <div class="col-md-5">
                            
                            <div class="input-group mb-3">
                                {{-- <div class="input-group-prepend">
                                    <span class="fa fa-calendar input-group-text"></span>
                                </div> --}}
                                <label for="expirydate" class="col-md-12 text-md-left custom-flat-label">Expiry Date:</label>
                                <input id="expirydate" type="text" class="form-control custom-flat-input" name="expirydate" placeholder="MM/DD/YYYY"  autofocus>
                            </div>
                            <p class="text-danger" id="error_expirydate"></p>
                                @if ($errors->has('expirydate'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('expirydate') }}</strong>
                                    </span>
                                @endif
                            </div>
                </div>

                {{-- ------------------------------------------------------------------- --}}
                {{-- Account Files Row --}}
                <hr>
                <label class="customf-flat-label">Business Files</label>
                <div class="form-group row mt-4">
                        
                        <div class="col-md-5">
                            
                            <div class="input-group mb-3">
                                {{-- <div class="input-group-prepend">
                                    <span class="fa fa-folder input-group-text"></span>
                                </div> --}}
                                <label for="accountstatus" class="col-md-12 text-md-left custom-flat-label">Select File SEC/DTI:</label>
                                <div class="custom-file custom-flat-file">
                                    <input type="file" class="custom-file-input" id="sec" name="sec" multiple onchange="processSelectedFilesSec(this)">
                                    <label class="custom-file-label" for="validatedCustomFile" id="sec_filename">Choose file...</label>
                                </div>
                            </div>
                                
                        </div>
                        
                       
                        <div class="col-md-5">
                            
                            <div class="input-group mb-3">
                                {{-- <div class="input-group-prepend">
                                    <span class="fa fa-folder input-group-text"></span>
                                </div> --}}
                                <label for="accountstatus" class="col-md-12 text-md-left custom-flat-label">Select File BIR COR:</label>
                                <div class="custom-file custom-flat-file">
                                    <input type="file" class="custom-file-input" id="bir" name="bir" multiple onchange="processSelectedFilesBir(this)">
                                    <label class="custom-file-label" for="validatedCustomFile" id="bir_filename">Choose file...</label>
                                </div>
                            </div>
                                
                        </div>
                </div>

          </div>
          <!-- /.card-body -->

          <div class="card-footer">
              {{-- <button type="button" class="btn btn-default">Back</button> --}}
            <button type="submit" class="btn btn-outline-primary float-right btn-flat" id="submit" {{$add}}>Submit <i  class=""></i></button>
          </div>
        </form>
        <!-- Loading (remove the following to stop the loading)-->
        <div class="" id="formOverlay">
            <i id="spinnercreate" class=""></i>
          </div>
          <!-- end loading -->
      </div>
      <!-- /.card -->
{{-- </div> --}}

<script type="text/javascript">
    /*Function to get Filename*/
    function processSelectedFilesSec(fileInput) {
        var files = fileInput.files;

        for (var i = 0; i < files.length; i++) {
                $('#sec_filename').html(files[i].name.substr(0,22));
        }
    }
    /*Function to get Filename*/
    function processSelectedFilesBir(fileInput) {
        var files = fileInput.files;

        for (var i = 0; i < files.length; i++) {
                $('#bir_filename').html(files[i].name.substr(0,22));
        }
    }
$(document).ready(function (){

    setExpiryDate();
    
    /*Check if the Date is Past*/
    $("#expirydate").on('change', function (selected) {
        var now = new Date();
        if ($( "#expirydate" ).val() < now){
                $( "#expirydate" ).val('');
        }
    });

    // Config Restriction for Pass Date
    var date = new Date();
    date.setDate(date.getDate());
    $('#expirydate').datepicker({
        autoclose: true,
        startDate: date
    });
    //setExpiryDate();
    SetEnrollmentDate();
    function setExpiryDate(){
            var today = new Date();
            var dd = today.getDate() + 14;
            var mm = today.getMonth()+1; //January is 0!

            var yyyy = today.getFullYear();
            if(dd<10){dd='0'+dd} 
            if(mm<10){mm='0'+mm} 
            var today = yyyy+'-'+mm+'-'+dd;   
            //$('#expirydate').val(today);  
    }

    function SetEnrollmentDate(){
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth()+1; //January is 0!

            var yyyy = today.getFullYear();
            if(dd<10){dd='0'+dd} 
            if(mm<10){mm='0'+mm} 
            var today = yyyy+'-'+mm+'-'+dd;   
            $('#enrollmentdate').val(today);  
    }

    /*Get Province*/
    $.ajax({
			method: 'get',
            url: '/Account/get_province',
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
                url: '/Account/get_citytown/' + $code,
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
                        //console.log("Error cannot be");
                }
        });
    });

    /*Get Barangay*/
    $('#address_town').change(function (){
        $("#address_barangay").empty();
        $code = $('#address_town').val();
        $.ajax({
                method: 'get',
                url: '/Account/get_barangay/' + $code,
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


    // Get User Type
    $.ajax({
        method: 'get',
        url: '/Account/get_user_type',
        dataType: 'json',
        success: function (data) {
            $.each(data, function (i, data) {
                $("#user_type").append('<option value="' + data.id + '">' + data.type_name + '</option>');
            });
        },
        error: function (response) {
            //console.log("Error cannot be");
        }
    });


    /*Add Account*/
    $('#AccountForm').submit(function (e){
        $('#formOverlay').addClass('overlay');
        $("#spinnercreate").addClass('fa fa-refresh fa-spin');
        e.preventDefault();
        RemoveErrors();
        toastr.remove();
        var formData = new FormData($(this)[0]);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        if($('#business_name').val() == ""){
            $('#error_business_name').html('Business Name is Required');
            $('#error_business_name').attr('hidden', false);
            $('#business_name').addClass('is-invalid');
            spinnerTimout();
        }
        else if ($('#business_name').val() == 0 || $('#business_name').val() < 0){
            $('#error_business_name').html('Business Name is Invalid');
            $('#error_business_name').attr('hidden', false);
            $('#business_name').addClass('is-invalid');
            spinnerTimout();
        }
        if($('#contact_person').val() == ""){
            $('#error_contact_person').html('Contact Person is Required');
            $('#error_contact_person').attr('hidden', false);
            $('#contact_person').addClass('is-invalid');
            spinnerTimout();
        }
        else if ($('#contact_person').val() == 0 || $('#contact_person').val() < 0) {
            $('#error_contact_person').html('Contact Person is Invalid');
            $('#error_contact_person').attr('hidden', false);
            $('#contact_person').addClass('is-invalid');
            spinnerTimout();
        }
        if($('#accountname').val() == ""){
            $('#error_accountname').html('Account Name is Required');
            $('#error_accountname').attr('hidden', false);
            $('#accountname').addClass('is-invalid');
            spinnerTimout();
        }
        else if ($('#accountname').val() == 0 || $('#accountname').val() < 0) {
            $('#error_accountname').html('Account Name is Invalid');
            $('#error_accountname').attr('hidden', false);
            $('#accountname').addClass('is-invalid');
            spinnerTimout();
        }
        if($('#contact_phone').val() == ""){
            $('#error_contact_phone').html('Contact Phone is Required');
            $('#error_contact_phone').attr('hidden', false);
            $('#contact_phone').addClass('is-invalid');
            spinnerTimout();
        }
        else if ($('#contact_phone').val() == 0 || $('#contact_phone').val() < 0) {
            $('#error_contact_phone').html('Contact Phone is Invalid');
            $('#error_contact_phone').attr('hidden', false);
            $('#contact_phone').addClass('is-invalid');
            spinnerTimout();
        }
        if($('#contact_phone').val() == ""){
            $('#error_contact_phone').html('Contact Phone is Required');
            $('#error_contact_phone').attr('hidden', false);
            $('#contact_phone').addClass('is-invalid');
            spinnerTimout();
        }
        else if(isNaN($('#contact_phone').val())) {
            $('#error_contact_phone').html('Contact Phone  Must be Number');
            $('#error_contact_phone').attr('hidden', false);
            $('#contact_phone').addClass('is-invalid');
            spinnerTimout();
        }
        if($('#address_unit').val() == ""){
            $('#error_address_unit').html('Address Unit is Required');
            $('#error_address_unit').attr('hidden', false);
            $('#address_unit').addClass('is-invalid');
            spinnerTimout();
        }
        else if ($('#address_unit').val() == 0 || $('#address_unit').val() < 0) {
            $('#error_address_unit').html('Address Unit is Invalid');
            $('#error_address_unit').attr('hidden', false);
            $('#address_unit').addClass('is-invalid');
            spinnerTimout();
        }            
        if($('#contact_mobile').val() == ""){
            $('#error_contact_mobile').html('Contact Mobile is Required');
            $('#error_contact_mobile').attr('hidden', false);
            $('#contact_mobile').addClass('is-invalid');
            spinnerTimout();
        }
        else if ($('#contact_mobile').val() == 0 || $('#contact_mobile').val() < 0) {
            $('#error_contact_mobile').html('Contact Mobile is Invalid');
            $('#error_contact_mobile').attr('hidden', false);
            $('#contact_mobile').addClass('is-invalid');
            spinnerTimout();
        } 
        else if (isNaN($('#contact_mobile').val())){
            $('#error_contact_mobile').html('Contact Mobile  Must Be Number');
            $('#error_contact_mobile').attr('hidden', false);
            $('#contact_mobile').addClass('is-invalid');
            spinnerTimout();
        }
        if($('#address_country').val() == ""){
            $('#error_address_country').html('Address Country is Required');
            $('#error_address_country').attr('hidden', false);
            $('#address_country').addClass('is-invalid');
            spinnerTimout();
        }
        else if ($('#address_country').val() == 0 || $('#address_country').val() < 0) {
            $('#error_address_country').html('Address Country is Invalid');
            $('#error_address_country').attr('hidden', false);
            $('#address_country').addClass('is-invalid');
            spinnerTimout();
        } 
        if($('#contact_email').val() == ""){
            $('#error_contact_email').html('Contact Email is Required');
            $('#error_contact_email').attr('hidden', false);
            $('#contact_email').addClass('is-invalid');
            spinnerTimout();
        }
        else if ($('#contact_email').val() == 0 || $('#contact_email').val() < 0) {
            $('#error_contact_email').html('Contact Email is invalid');
            $('#error_contact_email').attr('hidden', false);
            $('#contact_email').addClass('is-invalid');
            spinnerTimout();
        }
        if($('#address_cityprovince').val() == ""){
            $('#error_address_cityprovince').html('Address City Province is Required');
            $('#error_address_cityprovince').attr('hidden', false);
            $('#address_cityprovince').addClass('is-invalid');
            spinnerTimout();
        }
        if($('#tin').val() == ""){
            $('#error_tin').html('tin is Required');
            $('#error_tin').attr('hidden', false);
            $('#tin').addClass('is-invalid');
            spinnerTimout();
        }
        else if ($('#tin').val() == 0 || $('#tin').val() < 0) {
            $('#error_tin').html('tin is Invalid');
            $('#error_tin').attr('hidden', false);
            $('#tin').addClass('is-invalid');
            spinnerTimout();
        }
        else if (isNaN($('#tin').val())){
            $('#error_tin').html('tin Must be Number');
            $('#error_tin').attr('hidden', false);
            $('#tin').addClass('is-invalid');
            spinnerTimout();
        }
        if($('#address_town').val() == ""){
            $('#error_address_town').html('Town is Required');
            $('#error_address_town').attr('hidden', false);
            $('#address_town').addClass('is-invalid');
            spinnerTimout();
        }
        if($('#sss').val() == ""){
            $('#error_sss').html('sss is Required');
            $('#error_sss').attr('hidden', false);
            $('#sss').addClass('is-invalid');
            spinnerTimout();
        }
        else if ($('#sss').val() == 0 || $('#sss').val() < 0) {
            $('#error_sss').html('sss is Invalid');
            $('#error_sss').attr('hidden', false);
            $('#sss').addClass('is-invalid');
            spinnerTimout();
        }
        else if (isNaN($('#sss').val())){
            $('#error_sss').html('sss Must Be Number');
            $('#error_sss').attr('hidden', false);
            $('#sss').addClass('is-invalid');
            spinnerTimout();
        }
        if($('#address_barangay').val() == ""){
            $('#error_address_barangay').html('Address Barangay is Required');
            $('#error_address_barangay').attr('hidden', false);
            $('#address_barangay').addClass('is-invalid');
            spinnerTimout();
        }
        if($('#phic').val() == ""){
            $('#error_phic').html('phic is Required');
            $('#error_phic').attr('hidden', false);
            $('#phic').addClass('is-invalid');
            spinnerTimout();
        }
        else if ($('#phic').val() == 0 || $('#phic').val() < 0) {
            $('#error_phic').html('phic is Invalid');
            $('#error_phic').attr('hidden', false);
            $('#phic').addClass('is-invalid');
            spinnerTimout();
        }
        else if (isNaN($('#phic').val())){
            $('#error_phic').html('phic Must be Number');
            $('#error_phic').attr('hidden', false);
            $('#phic').addClass('is-invalid');
            spinnerTimout();
        }
        if($('#address_zipcode').val() == ""){
            $('#error_address_zipcode').html('Zip Code is Required');
            $('#error_address_zipcode').attr('hidden', false);
            $('#address_zipcode').addClass('is-invalid');
            spinnerTimout();
        }
        else if ($('#address_zipcode').val() == 0 || $('#address_zipcode').val() < 0) {
            $('#error_address_zipcode').html('Zip Code is Invalid');
            $('#error_address_zipcode').attr('hidden', false);
            $('#address_zipcode').addClass('is-invalid');
            spinnerTimout();
        }
        else if (isNaN($('#address_zipcode').val())){
            $('#error_address_zipcode').html('Zip Code Must be Number');
            $('#error_address_zipcode').attr('hidden', false);
            $('#address_zipcode').addClass('is-invalid');
            spinnerTimout();
        }
        if($('#hdmf').val() == ""){
            $('#error_hdmf').html('hdmf is Required');
            $('#error_hdmf').attr('hidden', false);
            $('#hdmf').addClass('is-invalid');
            spinnerTimout();
        }
        else if ($('#hdmf').val() == 0 || $('#hdmf').val() < 0) {
            $('#error_hdmf').html('hdmf is Invalid');
            $('#error_hdmf').attr('hidden', false);
            $('#hdmf').addClass('is-invalid');
            spinnerTimout();
        }
        else if (isNaN($('#hdmf').val())){
            $('#error_hdmf').html('hdmf Must be Number');
            $('#error_hdmf').attr('hidden', false);
            $('#hdmf').addClass('is-invalid');
            spinnerTimout();
        }
        if($('#user_type').val() == ""){
            $('#error_user_type').html('Account Type is Required');
            $('#error_user_type').attr('hidden', false);
            $('#user_type').addClass('is-invalid');
            spinnerTimout();
        }
        if($('#nid').val() == ""){
            $('#error_nid').html('nid is Required');
            $('#error_nid').attr('hidden', false);
            $('#nid').addClass('is-invalid');
            spinnerTimout();
        }
        else if ($('#nid').val() == 0 || $('#nid').val() < 0) {
            $('#error_nid').html('nid is Invalid');
            $('#error_nid').attr('hidden', false);
            $('#nid').addClass('is-invalid');
            spinnerTimout();
        }
        else if(isNaN($('#nid').val())){
            $('#error_nid').html('nid must be Number');
            $('#error_nid').attr('hidden', false);
            $('#nid').addClass('is-invalid');
            spinnerTimout();
        }
        if($('#expirydate').val() == ""){
            $('#error_expirydate').html('Expiry Date is Required');
            $('#error_expirydate').attr('hidden', false);
            $('#expirydate').addClass('is-invalid');
            spinnerTimout();
        }
        else if ($('#expirydate').val() == 0 || $('#expirydate').val() < 0) {
            $('#error_expirydate').html('Expiry Date is Invalid');
            $('#error_expirydate').attr('hidden', false);
            $('#expirydate').addClass('is-invalid');
            spinnerTimout();
        }
        

        if($('#business_name').val() != "" &&
         $('#contact_person').val() != "" &&
         $('#accountname').val() != "" &&
         $('#contact_phone').val() != "" &&
         $('#address_unit').val() != "" &&
         $('#contact_mobile').val() != "" &&
         $('#address_country').val() != "" &&
         $('#contact_email').val() != ""  &&
         $('#address_cityprovince').val() != "" &&
         $('#tin').val() != "" &&
         $('#address_town').val() != "" &&
         $('#sss').val() != "" &&
         $('#address_barangay').val() != "" &&
         $('#phic').val() != "" &&
         $('#address_zipcode').val() != "" &&
         $('#hdmf').val() != "" &&
         $('#user_type').val() != "" &&
         $('#nid').val() != "" &&
         $('#expirydate').val() != ""){
            $.ajax({
            url: "{{ url('/Account') }}",
            method: 'POST',
            async: false,
			dataType: 'json',
            data: formData,
            cache: false,
            contentType: false,
            enctype: 'multipart/form-data',
            processData: false,
            success: function(data){
                //console.log("success");
                //Reset Form
                $('#AccountForm')[0].reset();
                // Display a success toast, with a title
                toastr.success('Account Created Successfully', 'Success')
                // Set Timeout For Loading in Submit button
                setTimeout(function (){
                    $("#spinner").removeClass('fa fa-refresh fa-spin');
                    $('#formOverlay').removeClass('overlay');
                    /*Redirect To Account*/
                    window.location.replace('{{ config('app.url') }}/Account');
                }, 3000);
                //Remove Errors
                $('.form-control').each(function(i, obj){
                    $('.form-control').removeClass('is-invalid');
                    $('.text-danger').attr('hidden', true);
                });
                //Clear The Filename textbox
                $('#sec_filename').text('');
                $('#bir_filename').text('');
            },
            error: function(data, status){
                console.clear();
                //console.log("Error");
                // Display an error toast, with a title
                toastr.error('Error. Please Complete The Fields', 'Error!')
                // Set Timeout For Loading in Submit button
                setTimeout(function (){
                    $("#spinnercreate").removeClass('fa fa-refresh fa-spin');
                    $('#formOverlay').removeClass('overlay');
                }, 250);
                // Handle a 422 Status Code
                if(data.status === 422) {
                    //console.log("422");
                    var errors = $.parseJSON(data.responseText);
                    //console.log(errors.errors.accountname);
                    $.each(errors, function (i, errors) {
                        //console.log(errors);
                        /**/
                        if(errors.business_name){
                            $('#error_business_name').html(errors.business_name);
                            $('#error_business_name').attr('hidden', false);
                            $('#business_name').addClass('is-invalid');
                        }
                        if(errors.contact_person){
                            $('#error_contact_person').html(errors.contact_person);
                            $('#error_contact_person').attr('hidden', false);
                            $('#contact_person').addClass('is-invalid');
                        }
                        if(errors.accountname){
                            $('#error_accountname').html(errors.accountname);
                            $('#error_accountname').attr('hidden', false);
                            $('#accountname').addClass('is-invalid');
                        }
                        if(errors.contact_phone){
                            $('#error_contact_phone').html(errors.contact_phone);
                            $('#error_contact_phone').attr('hidden', false);
                            $('#contact_phone').addClass('is-invalid');
                        }
                        if(errors.address_unit){
                            $('#error_address_unit').html(errors.address_unit);
                            $('#error_address_unit').attr('hidden', false);
                            $('#address_unit').addClass('is-invalid');
                        }
                        if(errors.contact_mobile){
                            $('#error_contact_mobile').html(errors.contact_mobile);
                            $('#error_contact_mobile').attr('hidden', false);
                            $('#contact_mobile').addClass('is-invalid');
                        }
                        if(errors.address_country){
                            $('#error_address_country').html(errors.address_country);
                            $('#error_address_country').attr('hidden', false);
                            $('#address_country').addClass('is-invalid');
                        }
                        if(errors.contact_email){
                            $('#error_contact_email').html(errors.contact_email);
                            $('#error_contact_email').attr('hidden', false);
                            $('#contact_email').addClass('is-invalid');
                        }
                        if(errors.address_cityprovince){
                            $('#error_address_cityprovince').html(errors.address_cityprovince);
                            $('#error_address_cityprovince').attr('hidden', false);
                            $('#address_cityprovince').addClass('is-invalid');
                        }
                        if(errors.tin){
                            $('#error_tin').html(errors.tin);
                            $('#error_tin').attr('hidden', false);
                            $('#tin').addClass('is-invalid');
                        }
                        if(errors.address_town){
                            $('#error_address_town').html(errors.address_town);
                            $('#error_address_town').attr('hidden', false);
                            $('#address_town').addClass('is-invalid');
                        }
                        if(errors.sss){
                            $('#error_sss').html(errors.sss);
                            $('#error_sss').attr('hidden', false);
                            $('#sss').addClass('is-invalid');
                        }
                        if(errors.address_barangay){
                            $('#error_address_barangay').html(errors.address_barangay);
                            $('#error_address_barangay').attr('hidden', false);
                            $('#address_barangay').addClass('is-invalid');
                        }
                        if(errors.phic){
                            $('#error_phic').html(errors.phic);
                            $('#error_phic').attr('hidden', false);
                            $('#phic').addClass('is-invalid');
                        }
                        if(errors.address_zipcode){
                            $('#error_address_zipcode').html(errors.address_zipcode);
                            $('#error_address_zipcode').attr('hidden', false);
                            $('#address_zipcode').addClass('is-invalid');
                        }
                        if(errors.hdmf){
                            $('#error_hdmf').html(errors.hdmf);
                            $('#error_hdmf').attr('hidden', false);
                            $('#hdmf').addClass('is-invalid');
                        }
                        if(errors.user_type){
                            $('#error_user_type').html(errors.user_type);
                            $('#error_user_type').attr('hidden', false);
                            $('#user_type').addClass('is-invalid');
                        }
                        if(errors.nid){
                            $('#error_nid').html(errors.nid);
                            $('#error_nid').attr('hidden', false);
                            $('#nid').addClass('is-invalid');
                        }
                    });
                }
            }
        });
        }
    });

    /*Function For Spinner*/
    function spinnerTimout(){
        setTimeout(function (){
            $("#spinnercreate").removeClass('fa fa-refresh fa-spin');
            $('#formOverlay').removeClass('overlay');
        }, 250);
    }

    /*Function to Remove Errors*/
    function RemoveErrors(){
        $('.form-control').each(function(i, obc){
            $('.form-control').removeClass('is-invalid');
            $('.text-danger').attr('hidden', true);
        });
    }

 
});
</script>
@endsection 