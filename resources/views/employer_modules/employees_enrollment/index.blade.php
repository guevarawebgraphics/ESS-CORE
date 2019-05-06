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
        <div class="card-body">
            <div class="pull-right">
                <a href="/enrollemployee/encode" class="btn btn-primary" id="btnCreateEmployee"><i
                        class="fa fa-plus-square" ></i> Encode Employee</a>
            </div>
            <br>
            <br>

            <div class="form-group row">
                <label for="address_zipcode" class="col-md-2 text-md-center">Search: </label>
                <div class="col-md-4">
                    <input id="searchbox" type="text" class="form-control" name="searchbox" placeholder="Search"
                        autofocus>
                </div>
            </div>

            <div class="table_encodeemployee">
                @include('employer_modules.employees_enrollment.table.encodetable')  
            </div>
            
        </div>
    </div>      
</div>
@endsection