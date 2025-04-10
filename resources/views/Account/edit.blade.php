@extends('layouts.master')

@section('content')
    <!-- general form elements -->
    <div class="card card-custom-blue card-outline">
        <div class="card-header">
          <h3 class="card-title"><i class="fa fa-edit"></i> Update Account</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form id="AccountForm">
            @method('PATCH') 
            @csrf
          <div class="card-body">
            {{-- Business Information Row --}}
          <label class="custom-flat-label">Business Information</label>
          <input type="hidden" id="EmployerId" value="{{ $Account[0]->id }}">
          <input type="hidden" id="ess_id" name="ess_id" value="{{ $check_user ? $Account[0]->username  : "none" }}">
                <div class="form-group row">
                        
                        <div class="col-md-5">
                            
                            <div class="input-group mb-3">
                                {{-- <div class="input-group-prepend">
                                    <span class="fa fa-user input-group-text"></span>
                                </div> --}}
                                <label for="business_name" class="control-label col-md-12 text-md-left custom-flat-label">Business Name:</label>
                                <input id="business_name" type="text" class="form-control custom-flat-input" name="business_name" value="{{ $Account[0]->business_name }}"  autofocus>
                            </div>
                            <p class="text-danger" id="error_business_name"></p>
                        </div>

                        
                        <div class="col-md-5">
                            
                            <div class="input-group mb-3">
                                {{-- <div class="input-group-prepend">
                                    <span class="fa fa-user input-group-text"></span>
                                </div> --}}
                                <label for="accountname" class="col-md-12 text-md-left custom-flat-label">Account Name:</label>
                                <input id="accountname" type="text" class="form-control custom-flat-input" name="accountname" value="{{ $Account[0]->accountname }}"  autofocus>
                            </div>
                            <p class="text-danger" id="error_accountname"></p>
                        </div>
                        {{-- <label for="contactperson" class="col-md-2 text-md-center">Contact Person: </label>
                        <div class="col-md-4">
                            
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="fa fa-user input-group-text"></span>
                                </div>
                                <input id="contact_person" type="text" class="form-control" name="contact_person" value="{{ $Account[0]->contact_person }}"  autofocus>
                            </div>
                            <p class="text-danger" id="error_contact_person"></p>
                        </div> --}}
                </div>
                {{-- Business Address Row --}}
                <hr>
                <label class="custom-flat-label">Bsuiness Address</label>
                <div class="form-group row mt-4">
                        
                        <div class="col-md-5">
                            
                            <div class="input-group mb-3">
                                {{-- <div class="input-group-prepend">
                                    <span class="fa fa-address-card input-group-text"></span>
                                </div> --}}
                                <label for="address_unit" class="col-md-12 text-md-left custom-flat-label">Unit:</label>
                                <input id="address_unit" type="text" class="form-control custom-flat-input" name="address_unit" value="{{ $Account[0]->address_unit }}"  autofocus>
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
                                <label for="address_cityprovince" class="col-md-12 text-md-left customf-flat-label">Province:</label>
                                <select id="address_cityprovince" name="address_cityprovince" class="form-control custom-flat-select">
                                        <option value="{{ $Account[0]->provCode}}" selected>{{ $Account[0]->provDesc}}</option>
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
                                <select id="address_town" name="address_town" class="form-control{{ $errors->has('address_town') ? ' is-invalid' : '' }} custom-flat-select">
                                        <option value="{{ $Account[0]->citymunCode}}" selected>{{ $Account[0]->citymunDesc}}</option>
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
                                        <option value="{{ $Account[0]->refbrgy_id}}">{{ $Account[0]->brgyDesc}}</option>
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
                                <input id="address_zipcode" type="text" class="form-control custom-flat-input" name="address_zipcode" value="{{ $Account[0]->address_zipcode }}"  autofocus>
                            </div>
                            <p class="text-danger" id="error_address_zipcode"></p>
                        </div>


                </div>

                {{-- ------------------------------------------------------------ --}}
                {{-- Contact Information --}}
                <hr>
                <label class="custom-flat-label">Contact Information</label>
                <div class="form-group row mt-4">
                        
                        <div class="col-md-5">
                            
                            <div class="input-group mb-3">
                                {{-- <div class="input-group-prepend">
                                    <span class="fa fa-phone input-group-text"></span>
                                </div> --}}
                                <label for="contact_mobile" class="col-md-12 text-md-left custom-flat-label">Mobile: </label>
                                <input id="contact_mobile" type="text" class="form-control custom-flat-input" name="contact_mobile" value="{{ $Account[0]->contact_mobile }}" maxlength="11"  autofocus>
                            </div>
                            <p class="text-danger" id="error_contact_mobile"></p>
                        </div>

                        
                        <div class="col-md-5">
                            
                            <div class="input-group mb-3">
                                {{-- <div class="input-group-prepend">
                                    <span class="fa fa-phone input-group-text"></span>
                                </div> --}}
                                <label for="contact_phone" class="col-md-12 text-md-left customf-lat-label">Phone: </label>
                                <input id="contact_phone" type="text" class="form-control custom-flat-input" name="contact_phone" value="{{ $Account[0]->contact_phone }}"  autofocus>
                            </div>
                            <p class="text-danger" id="error_contact_phone"></p>
                        </div>

                        
                        <div class="col-md-5">
                            
                            <div class="input-group mb-3">
                                {{-- <div class="input-group-prepend">
                                    <span class="fa fa-envelope input-group-text"></span>
                                </div> --}}
                                <label for="contact_email" class="col-md-12 text-md-left custom-flat-label">Email: </label>
                                <input id="contact_email" type="contact_email" class="form-control custom-flat-input" name="contact_email" value="{{ $Account[0]->contact_email }}"  autofocus>
                            </div>
                            <p class="text-danger" id="error_contact_email"></p>
                        </div>

                        
                        <div class="col-md-5">
                            
                            <div class="input-group mb-3">
                                {{-- <div class="input-group-prepend">
                                    <span class="fa fa-user input-group-text"></span>
                                </div> --}}
                                <label for="contactperson" class="col-md-12 text-md-left custom-flat-label">Contact Person: </label>
                                <input id="contact_person" type="text" class="form-control custom-flat-input" name="contact_person" value="{{ $Account[0]->contact_person }}"  autofocus>
                            </div>
                            <p class="text-danger" id="error_contact_person"></p>
                        </div>


                </div>


                {{-- ----------------------------------------------------------------- --}}
                {{-- Gorvernment Number Row --}}
                <hr>
                <label class="custom-flat-label">Goverment Number</label>
                <div class="form-group row mt-4">
                    
                        
                        <div class="col-md-5">
                            
                            <div class="input-group mb-3">
                                {{-- <div class="input-group-prepend">
                                    <span class="fa fa-address-card input-group-text"></span>
                                </div> --}}
                                <label for="tin" class="col-md-12 text-md-left custom-flat-label">Tin: </label>
                                <input id="tin" type="text" class="form-control custom-flat-input" name="tin" value="{{ $Account[0]->tin }}"  autofocus>
                            </div>
                            <p class="text-danger" id="error_tin"></p>
                        </div>

                        
                        <div class="col-md-5">
                            
                            <div class="input-group mb-3">
                                {{-- <div class="input-group-prepend">
                                    <span class="fa fa-address-card input-group-text"></span>
                                </div> --}}
                                <label for="sss" class="col-md-12 text-md-left custom-flat-label">SSS/GSIS: </label>
                                <input id="sss" type="text" class="form-control custom-flat-input" name="sss" value="{{ $Account[0]->sss }}"  autofocus>
                            </div>
                            <p class="text-danger" id="error_sss"></p>
                        </div>

                        
                        <div class="col-md-5">
                            
                            <div class="input-group mb-3">
                                {{-- <div class="input-group-prepend">
                                    <span class="fa fa-address-card input-group-text"></span>
                                </div> --}}
                                <label for="phic" class="col-md-12 text-md-left custom-flat-label">Phic: </label>
                                <input id="phic" type="text" class="form-control custom-flat-input" name="phic" value="{{ $Account[0]->phic }}"  autofocus>
                            </div>
                            <p class="text-danger" id="error_phic"></p>
                        </div>

                        
                        <div class="col-md-5">
                            
                            <div class="input-group mb-3">
                                {{-- <div class="input-group-prepend">
                                    <span class="fa fa-address-card input-group-text"></span>
                                </div> --}}
                                <label for="hdmf" class="col-md-12 text-md-left custom-flat-label">HDMF: </label>
                                <input id="hdmf" type="text" class="form-control custom-flat-input" name="hdmf" value="{{ $Account[0]->hdmf }}"  autofocus>
                            </div>
                            <p class="text-danger" id="error_hdmf"></p>

                        </div>

                        
                        <div class="col-md-5">

                            <div class="input-group mb-3">
                                {{-- <div class="input-group-prepend">
                                    <span class="fa fa-address-card input-group-text"></span>
                                </div> --}}
                                <label for="nid" class="col-md-12 text-md-left custom-flat-label">NID: </label>
                                <input id="nid" type="nid" class="form-control custom-flat-input" name="nid" value="{{ $Account[0]->nid }}"  autofocus>
                            </div>
                            <p class="text-danger" id="error_nid"></p>
                        </div>
                </div>


                {{-- -------------------------------------------- --}}
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
                                        <option value="{{ $Account[0]->user_type_id }}" selected>{{ $Account[0]->type_name }}</option>
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
                                <input id="enrollmentdate" type="text" class="form-control custom-flat-input" name="enrollmentdate" value="{{ \Carbon\Carbon::parse($Account[0]->enrollment_date)->format('m/d/Y')}}" placeholder="MM/DD/YYYY" disabled="true"  autofocus>
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
                                <input id="expirydate" type="text" class="form-control custom-flat-input" name="expirydate" value="{{ \Carbon\Carbon::parse($Account[0]->expiry_date)->format('m/d/Y') }}" placeholder="MM/DD/YYYY"   autofocus>
                            </div>
                            @if ($errors->has('expirydate'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('expirydate') }}</strong>
                                </span>
                            @endif
                    </div>

                </div>

                {{-- ---------------------------------------------------------- --}}
                {{-- Business Files row --}}
                <hr>
                <label class="custom-flat-label">Business Files</label>
                <div class="form-group row mt-4">

                    
                    <div class="col-md-5">
                            <div class="input-group mb-3">
                                {{-- <div class="input-group-prepend">
                                    <span class="fa fa-folder input-group-text"></span>
                                </div> --}}
                                <label for="accountstatus" class="col-md-12 text-md-left custom-flat-label">Select File SEC/DTI:</label>
                                <div class="custom-file custom-flat-file">
                                    <input type="file" class="custom-file-input" id="sec" name="sec" multiple onchange="processSelectedFilesSec(this)">
                                    <label class="custom-file-label" for="validatedCustomFile" id="sec_filename">{{ substr($Account[0]->sec, 0, 10) }}</label>
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
                                        <label class="custom-file-label" for="validatedCustomFile" id="bir_filename">{{ substr($Account[0]->bir, 0, 10) }}</label>
                                    </div>
                                </div>
                    </div>
                </div>

                
          </div>
          <!-- /.card-body -->

          <div class="card-footer">
              {{-- <button type="button" class="btn btn-default">Back</button> --}}
            <button type="submit" class="btn btn-outline-primary float-right btn-flat">Submit <i  class=""></i></button>
          </div>
        </form>
        <!-- Loading (remove the following to stop the loading)-->
        <div class="" id="formOverlay">
            <i class="" id="spinner"></i>
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
    $('#enrollmentdate').datepicker();
    $('#expirydate').datepicker({
        autoclose: true,
        startDate: date
    });

    /*Get Province*/
    let provCode = $('#provCode').val();
    $.ajax({
			method: 'get',
            url: '/Account/get_province',
            dataType: 'json',
            // data: {code: provCode},
			success: function (data) {
                $.each(data, function (i, data) {
                    $("#address_cityprovince").append('<option value="' + data.provCode + '">' + data.provDesc + '</option>');
                });
                
			},
			error: function (response) {
					//console.log("Error cannot be");
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
                    $.each(data, function (i, data) {
                        $("#address_barangay").append('<option value="' + data.id + '">' + data.brgyDesc + '</option>');
                    });
                },
                error: function (response) {
                       // console.log("Error cannot be");
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



    /*Update Account*/
    $('#AccountForm').submit(function (e){
        e.preventDefault();
        $('#formOverlay').addClass('overlay');
        $("#spinner").addClass('fa fa-refresh fa-spin');
        toastr.remove();
        RemoveErrors();
        var formData = new FormData($(this)[0]);
        var EmployerId = $('#EmployerId').val();
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
        if($('#contact_person').val() == ""){
            $('#error_contact_person').html('Contact Person is Required');
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
        if($('#contact_phone').val() == ""){
            $('#error_contact_phone').html('Contact Phone is Required');
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
        if($('#address_unit').val() == ""){
            $('#error_address_unit').html('Address Unit is Required');
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
        if($('#address_country').val() == ""){
            $('#error_address_country').html('Address Country is Required');
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
        if($('#address_zipcode').val() == ""){
            $('#error_address_zipcode').html('Zip Code is Required');
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
                url: "/Account/" + EmployerId,
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
                    toastr.success('Successfully Updated', 'Success')
                    //Redirect
                    setTimeout(function (){
                        $("#spinner").removeClass('fa fa-refresh fa-spin');
                        $('#formOverlay').removeClass('overlay');
                    }, 500);
                    /*Redirect To Account*/
                    window.location.replace('{{ config('app.url') }}/Account/edit/'+EmployerId);
                    //Remove Errors
                    $('.form-control').each(function(i, obj){
                        $('.form-control').removeClass('is-invalid');
                        $('.text-danger').attr('hidden', true);
                    });
                },
                error: function(data){
                    console.clear();
                    //console.log("Error");
                    setTimeout(function (){
                        $("#spinner").removeClass('fa fa-refresh fa-spin');
                        $('#formOverlay').removeClass('overlay');
                    }, 250);
                    // Display an error toast, with a title
                    toastr.error('Error. Please Complete The Fields', 'Error!')
                    if(data.status === 422) {
                        setTimeout(function (){
                            $("#spinner").removeClass('fa fa-refresh fa-spin');
                        }, 250);
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
            $("#spinner").removeClass('fa fa-refresh fa-spin');
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