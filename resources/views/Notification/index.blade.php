@extends('layouts.master')

@section('content')
    <div class="card card-info card-outline">
        <div class="card-header">
            <h3 class="card-title"><i class="fa fa-bell"></i> System Notification</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="form-group row">
                <label for="searchbox" class="col-md-2 text-md-center" style="margin-top: 5px;"><i class="fa fa-search"></i>Search:</label>
                <div class="col-md-4">
                    <input id="searchbox" type="text" class="form-control" name="searchbox" placeholder="Search">
                </div>
                <div class="col-md-6">
                    <a href="#Add" class="btn btn-primary float-md-right" id="btn_addnotification" data-toggle="modal" data-target="#AddNotificationModal"><i class="fa fa-plus-square"></i> Add System Notification</a>
                </div>
            </div>

            <table id="Notification" class="table table-boredered table-striped">
                <thead>
                    <tr>
                        {{-- <th>ID</th> --}}
                        <th>Employer</th>
                        <th>Notificatiion Title</th>
                        <th>Notification Message</th>
                        <th>Notification Type</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="showdata">
                    {{-- @foreach($Notification as $Notifications)
                    <tr>
                        <td>{{ $Notifications->id }}</td>
                        <td>{{ $Notifications->account_id }}</td>
                        <td>{{ $Notifications->notification_title }}</td>
                        <td>{{ $Notifications->notification_message }}</td>
                        <td>{{ $Notifications->notification_type }}</td>
                        <td>EDIT | DELETE</td>
                    </tr>
                    @endforeach --}}
                </tbody>
            </table>
        </div>
    </div>


    <!-- Add System Notification -->
<div class="modal fade" id="AddNotificationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="title_modal"></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form id="notification_form">
                    @csrf
                    <div class="form-group row">
                    <label for="notification_title" class="control-label col-md-4 text-md-center">Notification Title:</label>
                        <div class="col-md-6">
                            
                            <input id="notification_title" type="text" class="form-control" name="notification_title" placeholder="Notification Title"   autofocus>
                                    <p class="text-danger" id="error_notification_title"></p>
                        </div>
                    </div>
                    <div class="form-group row">
                    <label for="notification_message" class="control-label col-md-4 text-md-center">Notification Message:</label>
                        <div class="col-md-6">
                            
                            <textarea id="notification_message" type="text" class="form-control" name="notification_message" placeholder="Notification Message"   autofocus></textarea>
                                    <p class="text-danger" id="error_notification_message"></p>
                        </div>
                    </div>
                    <div class="form-group row">
                            <label for="employer_id" class="control-label col-md-4 text-md-center">Select Employer:</label>
                            <select class="form-control col-md-4" name="employer_id" id="employer_id">
                                <option value="" selected>Select Employer</option>>
                            </select>
                        </div>
                    <div class="form-group row">
                        <label for="notification_type" class="control-label col-md-4 text-md-center">Notification Type:</label>
                        <select class="form-control col-md-4" name="notification_type" id="notification_type">
                            <option value="" selected>Select Notification Type</option>
                            <option value="1">Email</option>
                            <option value="2">SMS</option>
                        </select>
                    </div>
                    <div class="col-md-4 float-right">
                        <p class="text-danger" id="error_notification_type"></p>
                    </div>
                </form>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="AddNotification">Save <i id="spinner" class=""></button>
            </div>
          </div>
        </div>
      </div>
  

<!-- Delete System Notification -->
<div class="modal fade" id="DeleteNotificationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="title_modal"></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
               <h4>Do You wanna Delete This Notification?</h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="DeleteNotification">Confirm <i id="spinner_delete" class=""></button>
            </div>
          </div>
        </div>
      </div>

<script>
$(document).ready(function (){
    // Show All Notification
    showAllNotification();

    /*DataTable*/ 
    var table = $("#Notification").DataTable({
          // "searching": false,
          "sDom": '<"customcontent">rt<"row"<"col-lg-6" i><"col-lg-6" p>><"clear">',
          "paging": true,
          "pageLength": 10000,
           scrollY: 300,
          //  scrollX: true,
          "autoWidth": true,
          lengthChange: false,
          responsive: true,
          "order": [[0, "desc"]]
    }); 
    /*Custom Search For DataTable*/
    $("#searchbox").on("keyup search input paste cut", function () {
        table.search(this.value).draw();
    });

    // Get User Type
    $.ajax({
        method: 'get',
        url: '/Account/get_all_employer',
        dataType: 'json',
        success: function (data) {
            $.each(data, function (i, data) {
                $("#employer_id").append('<option value="' + data.account_id + '">' + data.business_name + '</option>');
            });
        },
        error: function (response) {
            console.log("Error cannot be");
        }
    });

    // Show Notification
    $('#ShowNotification').click(function (){
        $('#notification_form').attr('hidden', true);
        $('#AddNotification').attr('hidden', true);
        $('#title_modal').html('Notification');
    });

    $('#btn_addnotification').click(function (){
        $('#notification_form')[0].reset();
        $('#notification_form').removeAttr('hidden');
        $('#AddNotification').removeAttr('hidden');
        $('#title_modal').html('Add System Notification');
        $('#notification_form').attr('action', '/Notification/store_notification');
    });

    // Store Notification
    $('#AddNotification').click(function () {
        var url = $('#notification_form').attr('action');
        var data = $('#notification_form');
        $("#spinner").addClass('fa fa-refresh fa-spin');
        toastr.remove()
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            type: 'ajax',
            url: url,
            method: 'POST',
            dataType: 'json',
            async: false,
            data: {
                _token:     '{{ csrf_token() }}',
                employer_id: $('#employer_id').val(),
                notification_title: $('#notification_title').val(),
                notification_message: $('#notification_message').val(),
                notification_type: $('#notification_type').val(),
                
            },
            success: function (data){
                $('#notification_form')[0].reset();
                // Show All Data
                showAllNotification();
                // Modal hide
                //$('#AddNotificationModal').modal('hide');
                setTimeout(function (){
                          $('#AddNotificationModal').modal('hide');
                }, 400);
                // Display a success toast, with a title
                toastr.success('Notification Saved Successfully', 'Success')
                setTimeout(function (){
                    $("#spinner").removeClass('fa fa-refresh fa-spin');
                }, 1500);
            },
            error: function (data, status){
                toastr.error('Error. Please Choose a Option', 'Error!')
                setTimeout(function (){
                    $("#spinner").removeClass('fa fa-refresh fa-spin');
                }, 250);
                /*Add Error Field*/
                var errors = $.parseJSON(data.responseText);
                $.each(errors, function (i, errors){
                    if(errors.notification_title)
                    {
                        $('#notification_title').addClass('is-invalid');
                        $('#error_notification_title').html('Notification Title is Required');
                    }
                    if(errors.notification_message)
                    {
                        $('#notification_message').addClass('is-invalid');
                        $('#error_notification_message').html('Notification Message is Required ');
                    }
                    if(errors.notification_type)
                    {
                        $('#notification_type').addClass('is-invalid');
                        // $('#error_notification_type').html('Notification Type is Required');
                    }
                });
                
            }
        });
    });

    // Edit Notification
    $('#showdata').on('click', '.notification-edit', function(){
        var id = $(this).attr('data');
        $('#AddNotificationModal').modal('show');
        $('#AddNotificationModal').find('#title_modal').text('Edit Notification');
        $('#notification_form').attr('action', '/Notification/update_notification/' + id);
        $('#notification_form').removeAttr('hidden');
        /*Remove Errors Error Field*/
        $('#notification_title').removeClass('is-invalid');
        $('#error_notification_title').remove();
        $('#notification_message').removeClass('is-invalid');
        $('#error_notification_message').remove();
        $('#notification_type').removeClass('is-invalid');
        toastr.remove()
        $.ajax({
            type: 'ajax',
            method: 'get',
            url: '/Notification/edit_notification',
            data: {id: id},
            dataType: 'json',
            success: function(data){
                $('#notification_title').val(data[0].notification_title);
                $('#notification_message').val(data[0].notification_message);
                $('#employer_id option[value="'+data[0].employer_id+'"]').prop('selected', true);
                $('#notification_type option[value="'+data[0].notification_type+'"]').prop('selected', true);
                
            },
            error: function(){
                console.log('Error');
            }
        });
    });

    //Delete a Notification
    $('#showdata').on('click', '.notification-delete', function(){
        var id = $(this).attr('data');
        $('#DeleteNotificationModal').modal('show');
        $('#DeleteNotificationModal').find('#title_modal').text('Delete Notification');
        $('#notification_form').attr('hidden', true);
        toastr.remove()
        //$('.modal-dialog').removeClass('modal-lg');
        // Prevent Previous handler - unbind()
        $('#DeleteNotification').unbind().click(function(){
            $("#spinner_delete").addClass('fa fa-refresh fa-spin');
            $.ajax({
                type: 'POST',
                url: '/Notification/destroy_notification',
                data: {
                    id: id,
                    '_token': $('input[name=_token]').val(),
                },
                success: function(data){
                    setTimeout(function (){
                          $('#DeleteNotificationModal').modal('hide');
                    }, 400);
                    // Display a success toast, with a title
                    toastr.success('Notification Deleted Successfully', 'Success')
                    setTimeout(function (){
                        $("#spinner_delete").removeClass('fa fa-refresh fa-spin');
                    }, 1500);
                    showAllNotification();
                  },
                  error: function(data){
                    toastr.error('Error Deleting Account')
                  }
            });
        });
    });

    


    //Show Data
    function showAllNotification(){
            $.ajax({
                type: 'GET',
                url: '/Notification/get_all_notifications',
                async: false,
                dataType: 'json',
                success: function (data){
                    var html = '';
                    var i;
                    for(i=0; i<data.length; i++){
                        var type = (data[i].notification_type == 1 ? "Email" : data[i].notification_type == 2 ? "SMS" : null);
                        html +='<tr>'+
                                    // '<td>'+data[i].id+'</td>'+
                                     '<td>'+data[i].business_name+'</td>'+
                                     '<td>'+data[i].notification_title+'</td>'+
                                     '<td>'+data[i].notification_message+'</td>'+
                                     '<td>'+type+'</td>'+
                                     '<td>'+
                                        // '<a href="javascript:;" class="btn btn-sm btn-info" id="ShowNotification" data-toggle="modal" data-target="#AddNotificationModal" data="'+data[i].id+'"><span class="icon is-small"><i class="fa fa-eye"></i></span>&nbsp;View</a>'+' '+
                                        '<a href="javascript:;" class="btn btn-sm btn-secondary notification-edit" data="'+data[i].id+'"><span class="icon is-small"><i class="fa fa-edit"></i></span>&nbsp;Edit</a>'+' '+
                                        '<a href="javascript:;" class="btn btn-sm btn-danger notification-delete" data="'+data[i].id+'"><span class="icon is-small"><i class="fa fa-trash"></i></span>&nbsp;Delete</a>'+
                                    '</td>'+
                                '</tr>';
                    }
                    if(type != null){
                        $('#showdata').html(html);
                    }
                },
                error: function(){
                    console.log('Could not get data from database');
                }
            });
    }
});
</script>
@endsection