@extends('layouts.master')

@section('crumb')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="m-0 text-dark">My Profile</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
                <a href="#">My Profile</a>
            </li>
            <li class="breadcrumb-item active">Settings</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <center><strong>Admin</strong></center>
                </div>
                <div class="card-body">
                    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                        <div class="image"><img alt="User Image" class="img-circle elevation-2" src="../storage/pic.jpg"></div>
                       
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <center><strong>About Me</strong></center>
                </div>
                <div class="card-body">
                    <h6 class="card-title"><strong>Account Info</strong></h6>
                    <p class="card-text">Employer</p>       
                    <h6 class="card-title"><strong>Location</strong></h6>
                    
                    {{-- <p class="card-text" style="text-transform:uppercase">{{$info[0]->address_unit . " " . $info[0]->brgyDesc  . " " . $info[0]->citymunDesc . ", " . $info[0]->provDesc}}</p> --}}
                   
                    <h6 class="card-title"><strong>Notes</strong></h6>
                    <p class="card-text">Notes</p>     
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <center><strong>Account Settings</strong></center>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label for="txtusername" class="col-form-label col-md-2">Username</label>
                        <div class="col-md-6">
                            <input type="text" id="txtusername" class="form-control" name="username" disabled value="{{auth()->user()->username}}">            
                        </div>
                    </div>   
                    <div class="form-group row">
                        <label for="txtmobile" class="col-form-label col-md-2">Mobile Number</label>
                        <div class="col-md-6">
                         
                                {{-- <input type="text" id="txtmobile" class="form-control" name="mobile" value="{{$info[0]->contact_mobile}}"> --}}
                              
                        </div>
                    </div>  
                    <div class="form-group row">
                        <label for="txtemail" class="col-form-label col-md-2">Email</label>
                        <div class="col-md-6">
                          
                                {{-- <input type="text" id="txtemail" class="form-control" name="email" value="{{$info[0]->contact_email}}">    --}}
                          
                        </div>
                    </div>
                    <button type="button" class="btn btn-secondary">Update Account</button>                                                                      
                </div>              
            </div>           
        </div>
    </div>    
</div>
@endsection