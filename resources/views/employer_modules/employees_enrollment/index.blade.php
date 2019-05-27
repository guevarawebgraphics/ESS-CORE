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
    <div class="card card-info card-outline">
        <div class="card-header">
            <h3 class="card-title"><i class="fa fa-edit"></i> Encode Employees</h3>
        </div>
        <div class="card-body">
            <div class="form-group row">
                {{-- <label for="address_zipcode" class="col-md-2 text-md-center">Search: </label> --}}
                <div class="col-md-6">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="fa fa-search input-group-text"></span>
                        </div>
                        <input id="searchbox" type="text" class="form-control" name="searchbox" placeholder="Search" autofocus>
                    </div>
                </div>
                <div class="col-md-6">
                    <a href="/enrollemployee/encode" class="btn btn-primary float-md-right" id="btnCreateEmployee"><i class="fa fa-plus-square" ></i> Encode Employee</a>
                </div>
            </div>

            <table class="table table-bordered table-striped" id="employee_table">
                <thead>
                    <tr>
                        <th>Employee No</th>
                        <th>Employee Name</th>
                        <th>Department</th>
                        <th>Position</th>
                        <th>Status</th>
                        <th>Change Status</th>
                        <th>Action</th>                 
                    </tr>
                </thead>
                <tbody>
                    @if(count($employee_info) > 0)
                        @foreach($employee_info as $info)
                        <tr>
                            <td>{{$info->employee_no}}</td>
                            <td>{{ucfirst($info->lastname) . ", " . ucfirst($info->firstname) . " " . ucfirst($info->middlename)}}</td>
                            <td>{{ucfirst($info->department)}}</td>
                            <td>{{ucfirst($info->position)}}</td>
                            <td>
                                @if($info->AccountStatus == 1)
                                    <span class="badge badge-success">Active</span>
                                @endif
                                @if($info->AccountStatus == 2)
                                    <span class="badge badge-secondary">In-Active</span>
                                @endif
                                @if($info->AccountStatus == 3)
                                    <span class="badge badge-danger">Deactivated</span>
                                @endif
                                @if($info->AccountStatus == 0)
                                    <span class="badge badge-danger">Deleted</span>
                                @endif
                            </td>
                            <td>
                                <button class="CS btn btn-sm btn-info" id="change_status" data-id="{{$info->employee_id}}">Change Status</button>
                            </td>
                            <td>
                                <a href="/enrollemployee/edit/{{$info->id}}" class="btn btn-sm btn-primary" id="btn_editemployee">Edit Employee</a>
                            </td>
                        </tr>
                        @endforeach
                    @else
                    @endif
                </tbody>
            </table>       
        
        </div>
    </div>      
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
         initDataTable();
         function initDataTable(){
            /*DataTable*/ 
            var table = $("#employee_table").DataTable({
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
            }); 
            /*Custom Search For DataTable*/
            $("#searchbox").on("keyup search input paste cut", function () {
                    table.search(this.value).draw();
            });
       }


      //function Refresh User table
      function refreshUserTable() {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "/enrollemployee/refresh_table_employee",
                method: "GET",
                data: {},
                success: function (data) {
                    $("#employee_table").DataTable().destroy();
                    $('#employee_table').html(data);
                    initDataTable();
                }
            });
        }

        $("#employee_table").on('click', '.CS', function(){
            $('#csModal').modal('show');
            var id = $(this).attr("data-id");
            $('#account_id').val(id);
            toastr.remove()
            console.log(id);
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
                    url: "/enrollemployee/UpdateAccountStatus/" + Account_id,
                    method: 'PATCH',
                    async: false,
                    dataType: 'json',
                    data: {
                      AccountStatus: $('#AccountStatus').val(),
                      _token:     '{{ csrf_token() }}'
                    },
                    success: function (data, response){
                      refreshUserTable();
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
    });
</script>
@endsection


