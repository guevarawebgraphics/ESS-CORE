@extends('layouts.master')

@section('content')
    <!-- general form elements -->
    <div class="card card-info card-outline">
        <div class="card-header">
          <h3 class="card-title">Create Account</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form id="AccountForm">
            @method('PATCH') 
            {{ csrf_field() }}
          <div class="card-body">
          <input type="hidden" id="EmployerId" value="{{ $Account[0]->account_id }}">
                <div class="form-group row">
                        <label for="business_name" class="control-label col-md-2 text-md-center">Business Name:</label>
                        <div class="col-md-4">
                            
                            <input id="business_name" type="text" class="form-control" name="business_name" value="{{ $Account[0]->business_name }}"  autofocus>
                                        <p class="text-danger" id="error_business_name"></p>
                        </div>
                        <label for="contactperson" class="col-md-2 text-md-center">Contact Person: </label>
                        <div class="col-md-4">
                            
                            <input id="contact_person" type="text" class="form-control" name="contact_person" value="{{ $Account[0]->contact_person }}"  autofocus>
                                        <p class="text-danger" id="error_contact_person"></p>
                        </div>
                </div>

                <div class="form-group row">
                        <label for="accountname" class="col-md-2 text-md-center">Account Name:</label>
                        <div class="col-md-4">
                            
                            <input id="accountname" type="text" class="form-control" name="accountname" value="{{ $Account[0]->accountname }}"  autofocus>
                                        <p class="text-danger" id="error_accountname"></p>
                        </div>
                        <label for="contact_phone" class="col-md-2 text-md-center">Phone: </label>
                        <div class="col-md-4">
                            
                            <input id="contact_phone" type="text" class="form-control" name="contact_phone" value="{{ $Account[0]->contact_phone }}"  autofocus>
                                        <p class="text-danger" id="error_contact_phone"></p>
                        </div>
                </div>

                <div class="form-group row">
                        <label for="address_unit" class="col-md-2 text-md-center">Unit:</label>
                        <div class="col-md-4">
                            
                            <input id="address_unit" type="text" class="form-control" name="address_unit" value="{{ $Account[0]->address_unit }}"  autofocus>
                                        <p class="text-danger" id="error_address_unit"></p>
                        </div>
                        <label for="contact_mobile" class="col-md-2 text-md-center">Mobile: </label>
                        <div class="col-md-4">
                            
                            <input id="contact_mobile" type="text" class="form-control" name="contact_mobile" value="{{ $Account[0]->contact_mobile }}"  autofocus>
                                        <p class="text-danger" id="error_contact_mobile"></p>
                        </div>
                </div>

                <div class="form-group row">
                        <label for="address_country" class="col-md-2 text-md-center">Country:</label>
                        <div class="col-md-4">
                            
                                <select id="address_country" name="address_country" class="form-control">
                                    {{-- <option value="" selected>Choose Country...</option> --}}
                                    <option>Philippines</option>
                                </select>
                                        <p class="text-danger" id="error_address_country"></p>
                        </div>

                        <label for="contact_email" class="col-md-2 text-md-center">Email: </label>
                        <div class="col-md-4">
                            
                            <input id="contact_email" type="contact_email" class="form-control" name="contact_email" value="{{ $Account[0]->contact_email }}"  autofocus>
                                        <p class="text-danger" id="error_contact_email"></p>
                        </div>
                </div>

                <div class="form-group row">
                        <label for="address_cityprovince" class="col-md-2 text-md-center">Province:</label>
                        <div class="col-md-4">
                                {{-- <input type="text" id="provCode" value="{{ $Account->address_cityprovince}}" hidden> --}}
                                <select id="address_cityprovince" name="address_cityprovince" class="form-control">
                                    {{-- <option value="" selected>Choose Province...</option> --}}
                                    <option value="{{ $Account[0]->provCode}}" selected>{{ $Account[0]->provDesc}}</option>
                                    {{-- <option id="province">Province</option> --}}
                                </select>
                                        <p class="text-danger" id="error_address_cityprovince"></p>
                        </div>
                        
                        <label for="tin" class="col-md-2 text-md-center">Tin: </label>
                        <div class="col-md-4">
                            
                            <input id="tin" type="text" class="form-control" name="tin" value="{{ $Account[0]->tin }}"  autofocus>
                                        <p class="text-danger" id="error_tin"></p>
                        </div>
                </div>

                <div class="form-group row">
                        <label for="address_town" class="col-md-2 text-md-center">City/Town:</label>
                        <div class="col-md-4">
                            
                                <select id="address_town" name="address_town" class="form-control{{ $errors->has('address_town') ? ' is-invalid' : '' }}">
                                    {{-- <option value="" selected>Choose CityTown...</option> --}}
                                    <option value="{{ $Account[0]->citymunCode}}" selected>{{ $Account[0]->citymunDesc}}</option>
                                    {{-- <option>CityTown</option> --}}
                                </select>
                                        <p class="text-danger" id="error_address_town"></p>
                        </div>
                        
                        <label for="sss" class="col-md-2 text-md-center">SSS/GSIS: </label>
                        <div class="col-md-4">
                            
                            <input id="sss" type="text" class="form-control" name="sss" value="{{ $Account[0]->sss }}"  autofocus>
                                        <p class="text-danger" id="error_sss"></p>
                        </div>
                </div>

                <div class="form-group row">
                        <label for="address_barangay" class="col-md-2 text-md-center">Barangay:</label>
                        <div class="col-md-4">
                            
                                <select id="address_barangay" name="address_barangay" class="form-control">
                                    {{-- <option value="" selected>Choose Barangay...</option> --}}
                                    <option value="{{ $Account[0]->refbrgy_id}}">{{ $Account[0]->brgyDesc}}</option>
                                    {{-- <option>Barangay</option> --}}
                                </select>
                                        <p class="text-danger" id="error_address_barangay"></p>
                        </div>
                        
                        <label for="phic" class="col-md-2 text-md-center">Phic: </label>
                        <div class="col-md-4">
                            
                            <input id="phic" type="text" class="form-control" name="phic" value="{{ $Account[0]->phic }}"  autofocus>
                                        <p class="text-danger" id="error_phic"></p>
                        </div>
                </div>

                <div class="form-group row">
                        <label for="address_zipcode" class="col-md-2 text-md-center">ZipCode: </label>
                        <div class="col-md-4">
                            
                            <input id="address_zipcode" type="text" class="form-control" name="address_zipcode" value="{{ $Account[0]->address_zipcode }}"  autofocus>
                                        <p class="text-danger" id="error_address_zipcode"></p>
                        </div>
                        
                        <label for="hdmf" class="col-md-2 text-md-center">HDMF: </label>
                        <div class="col-md-4">
                            
                            <input id="hdmf" type="text" class="form-control" name="hdmf" value="{{ $Account[0]->hdmf }}"  autofocus>
                                        <p class="text-danger" id="error_hdmf"></p>

                        </div>
                </div>

                <div class="form-group row">
                        <label for="user_type" class="col-md-2 text-md-center">Account Type:</label>
                        <div class="col-md-4">
                            
                                <select id="user_type" name="user_type" class="form-control">
                                    <option value="" selected>Choose Account Type...</option>
                                    <option value="{{ $Account[0]->user_type_id }}" selected>{{ $Account[0]->type_name }}</option>
                                    {{-- <option>accounttype</option> --}}
                                </select>
                                        <p class="text-danger" id="error_user_type"></p>
                        </div>
                        
                        <label for="nid" class="col-md-2 text-md-center">NID: </label>
                        <div class="col-md-4">
                            
                            <input id="nid" type="nid" class="form-control" name="nid" value="{{ $Account[0]->nid }}"  autofocus>
                                        <p class="text-danger" id="error_nid"></p>
                        </div>
                </div>

                <div class="form-group row">
                    <label for="enrollmentdate" class="col-md-2 text-md-center">Enrollment Date: </label>
                    <div class="col-md-4">
                        
                        <input id="enrollmentdate" type="date" class="form-control" name="enrollmentdate"  autofocus>
                        @if ($errors->has('enrollmentdate'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('enrollmentdate') }}</strong>
                            </span>
                        @endif
                    </div>

                    <label for="expirydate" class="col-md-2 text-md-center">Expiry Date:</label>
                    <div class="col-md-4">
                        
                    <input id="expirydate" type="date" class="form-control" name="expirydate"   autofocus>
                        @if ($errors->has('expirydate'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('expirydate') }}</strong>
                            </span>
                        @endif
                    </div>
            </div>

                <div class="form-group row">
                        <label for="accountstatus" class="col-md-2 text-md-center">Upload Documents:</label>
                        <div class="col-xs-2">
                            
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="customFile" name="sec">
                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                </div>
                                
                        </div>
                        
                        <label for="accountstatus" class="col-md-2 text-md-center">Select File BIR COR:</label>
                        <div class="col-xs-2">
                            
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="customFile" name="bir">
                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                </div>
                        </div>
                </div>
                
        
          </div>
          <!-- /.card-body -->

          <div class="card-footer">
              <button type="button" class="btn btn-default">Back</button>
            <button type="submit" class="btn btn-primary float-right">Submit <i id="spinner" class=""></i></button>
          </div>
        </form>
      </div>
      <!-- /.card -->
{{-- </div> --}}

<script type="text/javascript">
$(document).ready(function (){
    /*Get Province*/
    let provCode = $('#provCode').val();
    $.ajax({
			method: 'get',
            url: '/Account/get_province',
            dataType: 'json',
            // data: {code: provCode},
			success: function (data) {
                // console.log("success");
                // console.log(data);
                $.each(data, function (i, data) {
                    $("#address_cityprovince").append('<option value="' + data.provCode + '">' + data.provDesc + '</option>');
                });
                // $('#address_cityprovince').click(function (){
                //     $.ajax({
                //         method: 'get',
                //         url: '/Account/get_province',
                //         dataType: 'json',
                //         success: function (data){
                //             $.each(data, function (i, data) {
                //                 $("#address_cityprovince").append('<option value="' + data.provCode + '">' + data.provDesc + '</option>');
                //             });
                //         },
                //         error: function (data){
                //             console.log("Error");
                //         }
                //     });
                // });
                
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
                url: '/Account/get_barangay/' + $code,
                dataType: 'json',
                success: function (data) {
                    // console.log("success");
                    // console.log(data);
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
            console.log("Error cannot be");
        }
    });


    /*Remove Errors*/
    $('#business_name').keypress(function (){
        $('#business_name').removeClass('is-invalid');
        $('#error_business_name').attr('hidden', true);
    });
    $('#contact_person').keypress(function (){
        $('#contact_person').removeClass('is-invalid');
        $('#error_contact_person').attr('hidden', true);
    });
    $('#accountname').keypress(function (){
        $('#accountname').removeClass('is-invalid');
        $('#error_accountname').attr('hidden', true);
    });
    $('#contact_phone').keypress(function (){
        $('#contact_phone').removeClass('is-invalid');
        $('#error_contact_phone').attr('hidden', true);
    });
    $('#address_unit').keypress(function (){
        $('#address_unit').removeClass('is-invalid');
        $('#error_address_unit').attr('hidden', true);
    });
    $('#contact_mobile').keypress(function (){
        $('#contact_mobile').removeClass('is-invalid');
        $('#error_contact_mobile').attr('hidden', true);
    });
    $('#address_country').change(function (){
        $('#address_country').removeClass('is-invalid');
        $('#error_address_country').attr('hidden', true);
    });
    $('#contact_email').keypress(function (){
        $('#contact_email').removeClass('is-invalid');
        $('#error_contact_email').attr('hidden', true);
    });
    $('#address_cityprovince').change(function (){
        $('#address_cityprovince').removeClass('is-invalid');
        $('#error_address_cityprovince').attr('hidden', true);
    });
    $('#tin').keypress(function (){
        $('#tin').removeClass('is-invalid');
        $('#error_tin').attr('hidden', true);
    });
    $('#address_town').change(function (){
        $('#address_town').removeClass('is-invalid');
        $('#error_address_town').attr('hidden', true);
    });
    $('#sss').keypress(function (){
        $('#sss').removeClass('is-invalid');
        $('#error_sss').attr('hidden', true);
    });
    $('#address_barangay').change(function (){
        $('#address_barangay').removeClass('is-invalid');
        $('#error_address_barangay').attr('hidden', true);
    });
    $('#phic').keypress(function (){
        $('#phic').removeClass('is-invalid');
        $('#error_phic').attr('hidden', true);
    });
    $('#address_zipcode').change(function (){
        $('#address_zipcode').removeClass('is-invalid');
        $('#error_address_zipcode').attr('hidden', true);
    });
    $('#hdmf').keypress(function (){
        $('#hdmf').removeClass('is-invalid');
        $('#error_hdmf').attr('hidden', true);
    });
    $('#user_type').change(function (){
        $('#user_type').removeClass('is-invalid');
        $('#error_user_type').attr('hidden', true);
    });
    $('#nid').keypress(function (){
        $('#nid').removeClass('is-invalid');
        $('#error_nid').attr('hidden', true);
    });

    /*Update Account*/
    $('#AccountForm').submit(function (e){
        e.preventDefault();
        $("#spinner").addClass('fa fa-refresh fa-spin');
        var formData = new FormData($(this)[0]);
        var EmployerId = $('#EmployerId').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
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
                console.log("success");
                //Reset Form
                $('#AccountForm')[0].reset();
                // Display a success toast, with a title
                toastr.success('Successfully Updated', 'Success')
                //Redirect
                setTimeout(function (){
                    $("#spinner").removeClass('fa fa-refresh fa-spin');
                }, 3000);
            },
            error: function(data){
                console.log("Error");
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
    });


 
});
</script>
@endsection 