@extends('layouts.master')

@section('content')
{{-- <div class="col-md-4">
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
</div> --}}
{{-- <div class="container"> --}}
    <!-- general form elements -->
    <div class="card card-info card-outline">
        <div class="card-header">
          <h3 class="card-title">Create Account</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form action="/Account" method="POST">
            {{ csrf_field() }}
          <div class="card-body">

                <div class="form-group row">
                        <label for="shortname" class="control-label col-md-2 text-md-center">Short Name:</label>
                        <div class="col-md-4">
                            
                            <input id="shortname" type="text" class="form-control{{ $errors->has('shortname') ? ' is-invalid' : '' }}" name="shortname" value="{{ old('shortname') }}"  autofocus>
                            @if ($errors->has('shortname'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('shortname') }}</strong>
                                </span>
                            @endif
                        </div>
                        <label for="contactperson" class="col-md-2 text-md-center">Contact Person: </label>
                        <div class="col-md-4">
                            
                            <input id="contact_person" type="text" class="form-control{{ $errors->has('contact_person') ? ' is-invalid' : '' }}" name="contact_person" value="{{ old('contact_person') }}"  autofocus>
                            @if ($errors->has('contact_person'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('contact_person') }}</strong>
                                </span>
                            @endif
                        </div>
                </div>

                <div class="form-group row">
                        <label for="accountname" class="col-md-2 text-md-center">Account Name:</label>
                        <div class="col-md-4">
                            
                            <input id="accountname" type="text" class="form-control{{ $errors->has('accountname') ? ' is-invalid' : '' }}" name="accountname" value="{{ old('accountname') }}"  autofocus>
                            @if ($errors->has('accountname'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('accountname') }}</strong>
                                </span>
                            @endif
                        </div>
                        <label for="contact_phone" class="col-md-2 text-md-center">Phone: </label>
                        <div class="col-md-4">
                            
                            <input id="contact_phone" type="text" class="form-control{{ $errors->has('contact_phone') ? ' is-invalid' : '' }}" name="contact_phone" value="{{ old('contact_phone') }}"  autofocus>
                            @if ($errors->has('contact_phone'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('contact_phone') }}</strong>
                                </span>
                            @endif
                        </div>
                </div>

                <div class="form-group row">
                        <label for="address_unit" class="col-md-2 text-md-center">Unit:</label>
                        <div class="col-md-4">
                            
                            <input id="address_unit" type="text" class="form-control{{ $errors->has('address_unit') ? ' is-invalid' : '' }}" name="address_unit" value="{{ old('address_unit') }}"  autofocus>
                            @if ($errors->has('address_unit'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('address_unit') }}</strong>
                                </span>
                            @endif
                        </div>
                        <label for="contact_mobile" class="col-md-2 text-md-center">Mobile: </label>
                        <div class="col-md-4">
                            
                            <input id="contact_mobile" type="text" class="form-control{{ $errors->has('contact_mobile') ? ' is-invalid' : '' }}" name="contact_mobile" value="{{ old('contact_mobile') }}"  autofocus>
                            @if ($errors->has('contact_mobile'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('contact_mobile') }}</strong>
                                </span>
                            @endif
                        </div>
                </div>

                <div class="form-group row">
                        <label for="address_country" class="col-md-2 text-md-center">Country:</label>
                        <div class="col-md-4">
                            
                                <select id="address_country" name="address_country" class="form-control">
                                    <option selected>Choose Country...</option>
                                    <option>Philippines</option>
                                </select>
                            @if ($errors->has('address_country'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('address_country') }}</strong>
                                </span>
                            @endif
                        </div>

                        <label for="contact_email" class="col-md-2 text-md-center">Email: </label>
                        <div class="col-md-4">
                            
                            <input id="contact_email" type="contact_email" class="form-control{{ $errors->has('contact_email') ? ' is-invalid' : '' }}" name="contact_email" value="{{ old('contact_email') }}"  autofocus>
                            @if ($errors->has('contact_email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('contact_email') }}</strong>
                                </span>
                            @endif
                        </div>
                </div>

                <div class="form-group row">
                        <label for="address_cityprovince" class="col-md-2 text-md-center">Province:</label>
                        <div class="col-md-4">
                            
                                <select id="address_cityprovince" name="address_cityprovince" class="form-control">
                                    <option selected>Choose Province...</option>
                                    <option>Province</option>
                                </select>
                            @if ($errors->has('proviaddress_cityprovincence'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('address_cityprovince') }}</strong>
                                </span>
                            @endif
                        </div>
                        
                        <label for="tin" class="col-md-2 text-md-center">Tin: </label>
                        <div class="col-md-4">
                            
                            <input id="tin" type="text" class="form-control{{ $errors->has('tin') ? ' is-invalid' : '' }}" name="tin" value="{{ old('tin') }}"  autofocus>
                            @if ($errors->has('tin'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('tin') }}</strong>
                                </span>
                            @endif
                        </div>
                </div>

                <div class="form-group row">
                        <label for="address_town" class="col-md-2 text-md-center">City/Town:</label>
                        <div class="col-md-4">
                            
                                <select id="address_town" name="address_town" class="form-control">
                                    <option selected>Choose CityTown...</option>
                                    <option>CityTown</option>
                                </select>
                            @if ($errors->has('address_town'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('address_town') }}</strong>
                                </span>
                            @endif
                        </div>
                        
                        <label for="sss" class="col-md-2 text-md-center">SSS/GSIS: </label>
                        <div class="col-md-4">
                            
                            <input id="sss" type="text" class="form-control{{ $errors->has('sss') ? ' is-invalid' : '' }}" name="sss" value="{{ old('sss') }}"  autofocus>
                            @if ($errors->has('sss'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('sss') }}</strong>
                                </span>
                            @endif
                        </div>
                </div>

                <div class="form-group row">
                        <label for="address_barangay" class="col-md-2 text-md-center">Barangay:</label>
                        <div class="col-md-4">
                            
                                <select id="address_barangay" name="address_barangay" class="form-control">
                                    <option selected>Choose Barangay...</option>
                                    <option>Barangay</option>
                                </select>
                            @if ($errors->has('address_barangay'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('address_barangay') }}</strong>
                                </span>
                            @endif
                        </div>
                        
                        <label for="phic" class="col-md-2 text-md-center">Phic: </label>
                        <div class="col-md-4">
                            
                            <input id="phic" type="text" class="form-control{{ $errors->has('phic') ? ' is-invalid' : '' }}" name="phic" value="{{ old('phic') }}"  autofocus>
                            @if ($errors->has('phic'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('phic') }}</strong>
                                </span>
                            @endif
                        </div>
                </div>

                <div class="form-group row">
                        <label for="address_zipcode" class="col-md-2 text-md-center">ZipCode: </label>
                        <div class="col-md-4">
                            
                            <input id="address_zipcode" type="text" class="form-control{{ $errors->has('address_zipcode') ? ' is-invalid' : '' }}" name="address_zipcode" value="{{ old('address_zipcode') }}"  autofocus>
                            @if ($errors->has('address_zipcode'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('address_zipcode') }}</strong>
                                </span>
                            @endif
                        </div>
                        
                        <label for="hdmf" class="col-md-2 text-md-center">HDMF: </label>
                        <div class="col-md-4">
                            
                            <input id="hdmf" type="text" class="form-control{{ $errors->has('hdmf') ? ' is-invalid' : '' }}" name="hdmf" value="{{ old('hdmf') }}"  autofocus>
                            @if ($errors->has('hdmf'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('hdmf') }}</strong>
                                </span>
                            @endif
                        </div>
                </div>

                <div class="form-group row">
                        <label for="accounttype" class="col-md-2 text-md-center">Account Type:</label>
                        <div class="col-md-4">
                            
                                <select id="accounttype" class="form-control">
                                    <option selected>Choose Account Type...</option>
                                    <option>accounttype</option>
                                </select>
                            @if ($errors->has('accounttype'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('accounttype') }}</strong>
                                </span>
                            @endif
                        </div>
                        
                        <label for="nid" class="col-md-2 text-md-center">NID: </label>
                        <div class="col-md-4">
                            
                            <input id="nid" type="nid" class="form-control{{ $errors->has('nid') ? ' is-invalid' : '' }}" name="nid" value="{{ old('nid') }}"  autofocus>
                            @if ($errors->has('hdmf'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('nid') }}</strong>
                                </span>
                            @endif
                        </div>
                </div>

                <div class="form-group row">
                        <label for="accountstatus" class="col-md-2 text-md-center">Account Status:</label>
                        <div class="col-md-4">
                            
                                <select id="accountstatus" class="form-control">
                                    <option selected>Active</option>
                                    <option>accountstatus</option>
                                </select>
                            @if ($errors->has('accountstatus'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('accountstatus') }}</strong>
                                </span>
                            @endif
                        </div>
                        
                        <label for="enrollmentdate" class="col-md-2 text-md-center">Enrollment Date: </label>
                        <div class="col-md-4">
                            
                            <input id="enrollmentdate" type="enrollmentdate" class="form-control{{ $errors->has('enrollmentdate') ? ' is-invalid' : '' }}" name="enrollmentdate" value="{{ old('enrollmentdate') }}"  autofocus>
                            @if ($errors->has('enrollmentdate'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('enrollmentdate') }}</strong>
                                </span>
                            @endif
                        </div>
                </div>


                <div class="form-group row">
                        <label for="expirydate" class="col-md-2 text-md-center">Expiry Date:</label>
                        <div class="col-md-4">
                            
                        <input id="expirydate" type="expirydate" class="form-control{{ $errors->has('expirydate') ? ' is-invalid' : '' }}" name="expirydate" value="{{ old('expirydate') }}"  autofocus>
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
                                    <input type="file" class="custom-file-input" id="customFile">
                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                </div>
                                
                        </div>
                        
                        <label for="accountstatus" class="col-md-2 text-md-center">Select File BIR COR:</label>
                        <div class="col-xs-2">
                            
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="customFile">
                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                </div>
                        </div>
                </div>
                
        
          </div>
          <!-- /.card-body -->

          <div class="card-footer">
              <button type="button" class="btn btn-default">Back</button>
            <button type="submit" class="btn btn-primary float-right">Submit</button>
          </div>
        </form>
      </div>
      <!-- /.card -->
{{-- </div> --}}
@endsection 