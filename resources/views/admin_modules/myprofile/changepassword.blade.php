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
            <li class="breadcrumb-item active">Change Password</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <center><strong>Change Password</strong></center>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <label for="txtcurpass" class="col-form-label col-md-2">Current Password</label>
                <div class="col-md-6">
                    <input type="text" id="txtcurpass" class="form-control" name="curpass">            
                </div>
            </div>   
            <div class="form-group row">
                <label for="txtnewpass" class="col-form-label col-md-2">New Password</label>
                <div class="col-md-6">
                    <input type="text" id="txtnewpass" class="form-control" name="newpass">            
                </div>
            </div>  
            <div class="form-group row">
                <label for="txtconpass" class="col-form-label col-md-2">Confirm Password</label>
                <div class="col-md-6">
                    <input type="text" id="txtconpass" class="form-control" name="conpass">            
                </div>
            </div>
            <button type="button" class="btn btn-secondary">Update Password</button>                                                                      
        </div>              
    </div>      
</div>
@endsection