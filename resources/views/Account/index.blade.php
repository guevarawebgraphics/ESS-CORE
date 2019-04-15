@extends('layouts.master')

@section('content')
@if(session('success'))
    <div class="alert alert-success">
        {{session('success')}}
    </div>
@endif
<h1>Profiles</h1>
<div class="card">
    <div class="card-header">
      <h3 class="card-title">Manage Accounts</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
      {{-- <input type="text" id="searchbox" class="form-control col-md-4"> --}}
      <div class="form-group row">
          <label for="address_zipcode" class="col-md-2 text-md-center">Search: </label>
          <div class="col-md-4">
              
              <input id="searchbox" type="text" class="form-control" name="searchbox" placeholder="Search"  autofocus>
              @if ($errors->has('address_zipcode'))
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('address_zipcode') }}</strong>
                  </span>
              @endif
          </div>
          
      </div>
      <table id="Accounts" class="table table-bordered table-striped">
        <thead>
        <tr>
          <th>Id</th>
          <th>ShortName</th>
          <th>AccountName</th>
          <th>Account Type</th>
          <th>Email</th>
          {{-- <th>Account Status</th> --}}
          <th>Document Sec</th>
          <th>Document Bir</th>
          <th>Action</th>
        </tr>
        </thead>
        <tbody>
            @foreach($Account as $Accounts)
                <tr>
                    <td>{{ $Accounts->id }}</td>
                    <td>{{ $Accounts->shortname }}</td>
                    <td>{{ $Accounts->accountname }}</td>
                    <td>{{ $Accounts->type_name}}</td>
                    <td>{{ $Accounts->contact_email}}</td>
                    {{-- <td>
                      @if($Accounts->AccountStatus == 1)
                        Active
                      @endif
                    
                    </td> --}}
                    <td><a href="/storage/Documents/sec/{{$Accounts->sec}}" download>{{$Accounts->sec}}</a></td>
                    <td><a href="/storage/Documents/bir/{{$Accounts->bir}}" download>{{$Accounts->bir}}</a></td>
                    <td> <a href="/Account/edit/{{ $Accounts->id }}" class="btn btn-secondary"><i class="fa fa-edit"></i> Edit</a> 
                    <a href="#Delete" class="Delete btn btn-danger" data-toggle="modal" data-target="#deleteModal" data-id="{{ $Accounts->id }}" data-shortname="{{ $Accounts->shortname}}"><i class="fa fa-trash"></i> Delete</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>Id</th>
                <th>ShortName</th>
                <th>AccountName</th>
                <th>Account Type</th>
                <th>Email</th>
                <th>Document Sec</th>
                <th>Document Bir</th>
                <th>Action</th>
            </tr>
        </tfoot>
      </table>
      {{-- {{ $Account->links() }} --}}
    </div>

    <!-- Modal For delete -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Are You Sure You Want To DelEtE This User?
        <label id="shortname"></label>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          {{-- <form method="POST" action="" id="DeleteForm">
            @method('DELETE')
            @csrf --}}
            <button type="button" class="btn btn-primary" id="confirm">Confirm</button>
          {{-- </form> --}}
      </div>
    </div>
  </div>
</div>
    
<script type="text/javascript">
    $(document).ready(function () {
        /*DataTable*/ 
        var table = $("#Accounts").DataTable({
          // "searching": false,
          "sDom": '<"customcontent">rt<"row"<"col-lg-6" i><"col-lg-6" p>><"clear">',
          "paging": true,
          "pageLength": 10000,
           scrollY: 300,
          //  scrollX: true,
          "autoWidth": true,
          lengthChange: false,
          responsive: true,
        }); 
        /*Custom Search For DataTable*/
        $("#searchbox").on("keyup search input paste cut", function () {
                table.search(this.value).draw();
        });

        // Delete Function
        $('.Delete').click(function (){
          var id = $(this).attr("data-id");
          var shortname = $(this).attr("data-shortname");
          $("#DeleteForm").attr('action', '/Account/' + id);
           $("#shortname").html(shortname);
        });

        $('#confirm').click(function (){
          var id = $('.Delete').attr("data-id");
          $.ajax({
              type: 'DELETE',
              url: '/Account/' + id,
              data: {
                '_token': $('input[name=_token]').val(),
              },
              success: function(data){
                toastr.success('Successfully Delete!')
                //Close Modal
                $('#deleteModal').modal('hide');
              },
              error: function(data){
                toastr.error('Error Deleting Account')
              }
          });
        });

        
    });
</script>

@endsection