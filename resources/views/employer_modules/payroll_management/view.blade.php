@extends('layouts.master')

@section('crumb')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="m-0 text-dark">Payroll Management</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
                <a href="#">Payroll Management</a>
            </li>
            <li class="breadcrumb-item active">View Payroll Register</li>
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
@section('content')
<div class="container-fluid">
    <div class="card card-info card-outline">
        <div class="card-header">
            <center><strong>View Payroll Register</strong></center>
        </div>
        <div class="card-body">

            <div class="form-group row">
                <div class="col-md-6">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="fa fa-search input-group-text" style="background-color: #fff;"></span>
                        </div>
                        <input type="text" id="searchbox" class="form-control" placeholder="Search">
                    </div>
                </div>
                <div class="col-md-6">
                    <a href="#" class="btn btn-primary float-md-right mr-4"><i class="fa fa-file"></i> Generate Template</a>
                    <a href="#" class="btn btn-primary float-md-right mr-4"><i class="fa fa-upload"></i> Upload Payroll Register</a>
                </div>
            </div>  
            
            <table id="payroll_register_table" class="table table-bordered table-striped">
                <thead>
                    <th>Data 1</th>
                    <th>Data 2</th>
                    <th>Data 3</th>
                    <th>Data 4</th>
                    <th>Data 5</th>
                    <th>Data 6</th>
                    <th>Data 7</th>
                    <th>Data 8</th>
                    <th>Data 9</th>
                    <th>Data 10</th>
                    <th>Data 11</th>
                    <th>Data 12</th>
                    <th>Data 13</th>
                    <th>Data 14</th>
                    <th>Data 15</th>
                </thead>
                <tbody>
                    <td>H</td>
                    <td>H</td>
                    <td>H</td>
                    <td>H</td>
                    <td>H</td>
                    <td>H</td>
                    <td>H</td>
                    <td>H</td>
                    <td>H</td>
                    <td>H</td>
                    <td>H</td>
                    <td>H</td>
                    <td>H</td>
                    <td>H</td>
                    <td>H</td>
                </tbody>
            </table>
        </div>              
    </div>      
</div>
<script type="text/javascript">
    $(document).ready(function () {
        initDataTable();
         function initDataTable(){
            /*DataTable*/ 
            var table = $("#payroll_register_table").DataTable({
                // "searching": false,
                "sDom": '<"customcontent">rt<"row"<"col-lg-6" i><"col-lg-6" p>><"clear">',
                "paging": true,
                "pageLength": 10000,
                scrollY: 500,
                scrollX: false,
                "autoWidth": true,
                lengthChange: false,
                responsive: true,
                fixedColumns: true,
            }); 
            /*Custom Search For DataTable*/
            $("#searchbox").on("keyup search input paste cut", function () {
                    table.search(this.value).draw();
            });
       }
    });
</script>
@endsection
