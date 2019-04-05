@extends('layouts.master')

@section('content')
<h1>Profiles</h1>
<div class="card">
    <div class="card-header">
      <h3 class="card-title">Manage Accounts</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
      <table id="Accounts" class="table table-bordered table-striped">
        <thead>
        <tr>
          <th>Id</th>
          <th>ShortName</th>
          <th>AccountName</th>
          <td>Action</td>
        </tr>
        </thead>
        <tbody>
            @foreach($Account as $Accounts)
                <tr>
                    <td>{{ $Accounts->id }}</td>
                    <td>{{ $Accounts->shortname }}</td>
                    <td>{{ $Accounts->accountname }}</td>
                    <td>Edit | Delete</td>
                </tr>
            @endforeach
        </tbody>
      </table>
    </div>

<script type="text/javascript">
    $(document).ready(function () {
        /*DataTable*/ 
        $("#Accounts").DataTable(); 

        $("#searchbox").on("keyup search input paste cut", function () {
                table.search(this.value).draw();
        });
    });
</script>

@endsection