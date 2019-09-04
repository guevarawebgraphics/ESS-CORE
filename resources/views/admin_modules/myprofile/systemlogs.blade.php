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
            <li class="breadcrumb-item active-systemlogs text-secondary">System Logs</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="card card-custom-blue card-outline">
        <div class="card-header">
            <center><strong>System Logs</strong></center>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped" id="system_logs_table">
                <thead>
                    <tr>
                        <th scope="col">Log Description</th>
                        <th scope="col">Time</th>     
                    </tr>
                </thead>
                <tbody>
                    @if(count($logs) > 0)
                        @foreach($logs as $log)
                        <tr>
                            <td>{{$log->log_event}}</td>
                            <td>{{$log->created_at}}</td>
                        </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
         /*DataTable*/ 
         var table = $("#system_logs_table").DataTable({
            "sDom": '<"customcontent">rt<"row"<"col-lg-6" i><"col-lg-6" p>><"clear">',
            "paging": true,
            "pageLength": 22,
            "ordering": false,
            scrollY: 600,
            "autoWidth": true,
            lengthChange: false,
            responsive: true,
        });
    });
</script>
@endsection