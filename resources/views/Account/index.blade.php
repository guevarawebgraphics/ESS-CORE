@extends('layouts.master')
@section('crumb')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="m-0 text-dark">Create Profile</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
                <a href="#">Create Profile</a>
            </li>
            <li class="breadcrumb-item active">Update Profile</li>
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
@if(session('success'))
    <div class="alert alert-success">
        {{session('success')}}
    </div>
@endif
<div class="card card-info card-outline">
    <div class="card-header">
      <h3 class="card-title"><i class="fa fa-edit"></i> Manage Accounts</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
      {{-- <input type="text" id="searchbox" class="form-control col-md-4"> --}}
      <div class="form-group row">
          {{-- <label for="search" class="col-md-2 text-md-center" style="margin-top: 5px;"><i class="fa fa-search"></i>Search: </label> --}}
          <div class="col-md-6">
              <div class="input-group">
                  <div class="input-group-prepend">
                      <span class="fa fa-search input-group-text" style="background-color: #fff;"></span>
                    </div>
                  <input id="searchbox" type="text" class="form-control" name="searchbox" placeholder="Search">
              </div>
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
          {{-- <th>Id</th> --}}
          <th>Business Name</th>
          <th>AccountName</th>
          <th>Account Type</th>
          <th>Email</th>
          {{-- <th>Account Status</th> --}}
          <th>Document Sec</th>
          <th>Document Bir</th>
          {{-- <th>Change Status</th> --}}
          <th>Action</th>
        </tr>
        </thead>
        <tbody id="showdata">
            {{-- @foreach($Account as $Accounts)
                <tr> updated develop
                    <td>{{ $Accounts->id }}</td>
                    <td>{{ $Accounts->business_name }}</td>
                    <td>{{ $Accounts->accountname }}</td>
                    <td>{{ $Accounts->type_name}}</td>
                    <td>{{ $Accounts->contact_email}}</td>
                    <td>
                      @if($Accounts->AccountStatus == 1)
                        Active
                      @endif
                      @if($Accounts->AccountStatus == 2)
                        In-Active
                      @endif
                      @if($Accounts->AccountStatus == 3)
                        Deactivated
                      @endif
                    </td>
                    <td><a href="/storage/Documents/sec/{{$Accounts->sec}}" download>{{$Accounts->sec}}</a></td>
                    <td><a href="/storage/Documents/bir/{{$Accounts->bir}}" download>{{$Accounts->bir}}</a></td>
                    <td>
                      <a href="#ChangeStatus" class="CS btn-sm btn btn-info" data-toggle="modal" data-target="#csModal" data-id="{{ $Accounts->account_id }}" data-business_name="{{ $Accounts->business_name}}"><i class="fa fa-info"></i> Change Status</a>
                    </td>
                    <td> <a href="/Account/edit/{{ $Accounts->account_id }}" class="btn btn-sm btn-secondary"><i class="fa fa-edit"></i> Edit</a> 
                    <a href="#Delete" class="Delete btn-sm btn btn-danger" id="delete-btn" data-toggle="modal" data-target="#deleteModal" data-id="{{ $Accounts->account_id }}" data-business_name="{{ $Accounts->business_name}}"><i class="fa fa-trash"></i> Delete</a>
                    </td>
                </tr>
            @endforeach --}}
        </tbody>
        <tfoot>
            <tr>
                {{-- <th>Id</th> --}}
                <th>Business Name</th>
                <th>AccountName</th>
                <th>Account Type</th>
                <th>Email</th>
                {{-- <th>Account Status</th> --}}
                <th>Document Sec</th>
                <th>Document Bir</th>
                {{-- <th>Change Status</th> --}}
                <th>Action</th>
            </tr>
        </tfoot>
      </table>
      {{-- {{ $Account->links() }} --}}
    </div>


<!-- Modal For Change Status -->
<div class="modal fade" id="csModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" >Change Status</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="text" id="account_id" hidden>
        <select class="form-control col-md-4" name="AccountStatus" id="AccountStatus">
          <option value="" selected>Changed Status</option>
          <option value="1">Active</option>
          <option value="2">In-Active</option>
          <option value="3">Deactivated</option>
        </select>
        <p class="text-danger" id="error_cs" hidden>Please Choose Option</p>
        <label id="CS-id"></label>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="ChangeStatusConfirm">Confirm <i id="spinner" class=""></button>
      </div>
    </div>
  </div>
</div>
    
<script type="text/javascript">
    $(document).ready(function () {
      showAllAccount();
      initDataTable();
      function initDataTable(){
        /*DataTable*/ 
        var table = $("#Accounts").DataTable({
          // "searching": false,
          "sDom": '<"customcontent">rt<"row"<"col-lg-6" i><"col-lg-6" p>><"clear">',
          "paging": true,
          "pageLength": 10000,
           scrollY: 500,
          //  scrollX: true,
          "autoWidth": true,
          lengthChange: false,
          responsive: true,
          fixedColumns: true,
          "order": [[4, "asc"]]
        }); 
        /*Custom Search For DataTable*/
        $("#searchbox").on("keyup search input paste cut", function () {
                table.search(this.value).draw();
        });
      }
        

        // Delete Function
        $('#showdata').on('click', '.Delete', function (){
          var id = $(this).attr("data-id");
          var business_name = $(this).attr("data-business_name");
          $("#DeleteForm").attr('action', '/Account/' + id);
           $("#business_name").html(business_name);
           toastr.remove()
           console.log(id);
           swal({
                title: "Do you wanna Delete This Employer?",
                type: "error",
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes",
                showCancelButton: true,
                closeOnConfirm: true,
           },
            function(){
              $.ajax({
                  type: 'POST',
                  url: '/Account/destroy',
                  data: {
                    id: id,
                    '_token': $('input[name=_token]').val(),
                  },
                  success: function(data){
                    toastr.success('Successfully Deleted!')
                    setTimeout(function (){
                            $("#spinner").removeClass('fa fa-refresh fa-spin');
                        }, 250);
                        // Hide Modal
                        setTimeout(function (){
                          $('#csModal').modal('hide');
                        }, 550);
                    //Close Modal
                    $('#deleteModal').modal('hide');
                    //Reinitialize Table
                    //if ($.fn.dataTable.isDataTable('#Accounts')) {
                        $("#Accounts").DataTable().destroy();
                      //}
                    //Show All Account
                    showAllAccount();
                    initDataTable();
                  },
                  error: function(data){
                    toastr.error('Error Deleting Account')
                  }
              });
            }
           
           );
        });


        // Change Status
        $('#showdata').on('click', '.CS', function (){
          var id = $(this).attr("data-id");
          //console.log(id);
          $('#account_id').val(id);
          toastr.remove()
        });
        //Change Status
        $('#ChangeStatusConfirm').click(function (){
          $("#spinner").addClass('fa fa-refresh fa-spin');
          let Account_id = $('#account_id').val();
          let AccountStatus = $('#AccountStatus').val();
          toastr.remove()
          $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
          });
            if (AccountStatus == ""){
              $('#AccountStatus').addClass('is-invalid');
              $('#error_cs').removeAttr('hidden');
              toastr.error('Error. Please Choose a Option', 'Error!')
                setTimeout(function (){
                        $("#spinner").removeClass('fa fa-refresh fa-spin');
                  }, 250);
            }
            else {
              $.ajax({
                    url: "/Account/UpdateAccountStatus/" + Account_id,
                    method: 'PATCH',
                    async: false,
                    dataType: 'json',
                    data: {
                      AccountStatus: $('#AccountStatus').val(),
                      _token:     '{{ csrf_token() }}'
                    },
                    success: function (data, response){
                      //if ($.fn.dataTable.isDataTable('#Accounts')) {
                        $("#Accounts").DataTable().destroy();
                      //}
                      //Show All Account
                      showAllAccount();
                      initDataTable();
                      //Set the dropdown to the default selected
                      $('#AccountStatus option[value=""]').prop('selected', true);
                      //console.log('Success');
                      // Display a success toast, with a title
                      toastr.success('Account Updated Successfully', 'Success')
                      setTimeout(function (){
                            $("#spinner").removeClass('fa fa-refresh fa-spin');
                        }, 250);
                        // Hide Modal
                        setTimeout(function (){
                          $('#csModal').modal('hide');
                        }, 550);
                    },
                    error: function (data, e){
                      if(data.status == 500){
                        //console.log('Error');
                        toastr.error('Error. Please Choose a Option', 'Error!')
                        setTimeout(function (){
                                $("#spinner").removeClass('fa fa-refresh fa-spin');
                          }, 250);
                      }
                    }
                });
            }
        });

        function showAllAccount(){
          $.ajax({
            type: 'GET',
            url: '/Account/get_all_account',
            async: false,
            dataType: 'json',
            success: function(data){
              var html = '';
              var i;
              for(i=0; i<data.length; i++){
                var AccountStatus = (data[i].AccountStatus == 1 ? '<span class="badge badge-success">'+"Active"+'</span>' : data[i].AccountStatus == 2 ? '<span class="badge badge-secondary">'+"In-Active"+'</span>' : data[i].AccountStatus == 3 ? '<span class="badge badge-danger">'+"Deactivated"+'</span>' : data[i].AccountStatus == 0 ? '<span class="badge badge-danger">'+"Deleted"+'</span>' : null);
                var bir = data[i].bir;
                var sec = data[i].sec;
                html +='<tr>'+
                        // '<td>'+data[i].id+'</td>'+
                        '<td>'+data[i].business_name+'</td>'+
                        '<td>'+data[i].accountname+'</td>'+
                        '<td>'+data[i].type_name+'</td>'+
                        '<td>'+data[i].contact_email+'</td>'+
                        //'<td>'+AccountStatus+'</td>'+
                        '<td>' + '<a href="/storage/Documents/sec/'+data[i].sec+'" data-toggle="tooltip" data-placement="top" title="Click To Download This File" download>' +(sec.length > 10 ? sec.substring(0, 10)+'<div class="float-right"><i class="fa fa-download"></i></div>' : data[i].sec) +'</a>' + '</td>'+
                        '<td>' + '<a href="/storage/Documents/bir/'+data[i].bir+'" data-toggle="tooltip" data-placement="top" title="Click To Download This File" download>' +(bir.length > 10 ? bir.substring(0, 10)+'<div class="float-right"><i class="fa fa-download"></i></div>' : data[i].bir) +'</a>' + '</td>'+
                        // '<td>' + '<a href="#ChangeStatus" class="CS btn-sm btn btn-info '+(data[i].AccountStatus == 0 ? 'disabled' : "") +'" data-toggle="modal" data-target="#csModal" data-id="'+data[i].id+'" data-business_name="'+data[i].business_name+'" {{$edit}}><i class="fa fa-info"></i> Change Status</a>' +'</td>'+
                        '<td>' + '<a href="/Account/edit/'+data[i].id+'" class="btn btn-sm btn-secondary" {{$edit}}><i class="fa fa-edit"></i> Edit</a> ' +
                          '<a href="#Delete" class="Delete btn-sm btn btn-danger" id="delete-btn" data-toggle="modal" data-target="#deleteModal" data-id="'+data[i].id+'" data-business_name="'+data[i].business_name+'" {{$delete}}><i class="fa fa-trash"></i> Delete</a>' +
                         '</td>'+
                        '</tr>';

              }
              // if(AccountStatus != null){
                $('#showdata').html(html);
              // }
            },
            error: function(){
              console.log('Could not get data from database');
            }
          });
        }

        $('#AccountStatus').on('change', function(){
          $('#AccountStatus').removeClass('is-invalid');
          $('#error_cs').attr('hidden', true);
        });

        
    });
</script>

@endsection