@extends('layouts.master')
@section('crumb')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="m-0 text-dark">System Notifications</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
                <a href="#">System Notifications</a>
            </li>
            <li class="breadcrumb-item active-notification text-secondary">Manage Notifications</li>
        </ol>
    </div>
</div>
@endsection
@section('content')
@php
if(Session::get('system_notifications') == 'all'){
    $add = '';
    $edit = '';
    $delete = '';
}
elseif(Session::get('system_notifications') == 'view'){
    $add = 'disabled';
    $edit = 'disabled';
    $delete = 'disabled';
}
elseif(Session::get('system_notifications') == 'add'){
    $add = '';
    $edit = 'disabled';
    $delete = 'disabled';
}
elseif(Session::get('system_notifications') == 'edit'){
    $add = '';
    $edit = '';
    $delete = 'disabled';
}
elseif(Session::get('system_notifications') == 'delete'){
    $add = '';
    $edit = 'disabled';
    $delete = '';
}else{
    $add = 'disabled';
    $edit = 'disabled';
    $delete = 'disabled';
}                   
@endphp
    <div class="card card-custom-blue card-outline">
        <div class="card-header">
            <h3 class="card-title"><i class="fa fa-bell"></i> System Notification</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body" >
            @if(auth()->user()->user_type_id == 1)
            <div class="form-group row">
                <div class="col-md-6">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="fa fa-search input-group-text" style="background-color: #fff;"></span>
                            </div>
                            <input id="searchbox" type="text" class="form-control" name="searchbox" placeholder="Search">
                    </div>
                </div>
                <div class="col-md-6">
                    <a href="#Add" class="btn btn-outline-primary float-md-right btn-flat" id="btn_addnotification" data-toggle="modal" data-target="#AddNotificationModal" {{$add}}><i class="fa fa-plus-square"></i> Add System Notification</a>
                </div>
            </div>
            @endif
            <table id="Notification" class="table table-boredered table-striped">
                <thead>
                    <tr>
                        <th>Employer</th>
                        <th>Notificatiion Title</th>
                        <th>Notification Message</th>
                        <th>Notification Message Type</th>
                        <th>Notification Type</th>
                        @if(auth()->user()->user_type_id == 1)
                        <th>Action</th>
                        @endif
                    </tr>
                </thead>
                <tbody id="showdata">

                </tbody>
            </table>
        </div>
    </div>


    <!-- Add System Notification -->
    <div class="modal fade" id="AddNotificationModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content card-custom-blue card-outline">
            <div class="modal-header">
              <h5 class="modal-title" id="title_modal"></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body modalbody">
                <form id="notification_form">
                    @csrf
                    <div class="form-group row">
                    <label for="notification_title" class="control-label col-md-4 text-md-center">Notification Title:</label>
                        <div class="col-md-6">
                            
                            <input id="notification_title" type="text" class="form-control" name="notification_title" placeholder="Notification Title"   autofocus>
                                    <p class="text-danger" id="error_notification_title"></p>
                        </div>
                    </div>
                    <div class="form-group">
                    <label for="notification_description" class="control-label col-md-4 text-md-center">Notification Description:</label>
                        <div class="col-md-12">
                               <textarea id="notification_message" class="form-control" name="notification_message" rows="10" placeholder="Notification Message"   autofocus></textarea>
                                    <p class="text-danger" id="error_notification_message"></p>
                        </div>
                    </div>
                    @if(auth()->user()->user_type_id == 1)
                    <div class="form-group row">
                            <label for="employer_id" class="control-label col-md-4 text-md-center">Select Employer:</label>

                                <div class="col-md-8">
                                    <select class="form-control select2" style="width: 67%; padding-right: 250px !important;" name="employer_id" id="employer_id">
                                        <option selected value="">--Select Employer</option>
                                        @foreach($employers as $employer)
                                            <option value="{{$employer->id}}">{{$employer->business_name}}</option>
                                        @endforeach
                                    </select>
                                    <p class="text-danger" id="error_employer_id"></p>
                                </div>
                    </div>
                    @endif
                    <div class="form-group row">
                        <label for="message_type_id" class="control-label col-md-4 text-md-center">Message Type:</label>
                        <div class="col-md-8">
                            <select class="form-control select2" style="width: 67%; padding-right: 250px !important;" name="message_type_id" id="message_type_id">
                                <option selected value="">--Select Message Type</option>
                                @foreach($notification_message_type as $notification_message_types)
                                    <option value="{{$notification_message_types->id}}">{{$notification_message_types->message_type}}</option>
                                @endforeach
                            </select>
                            <p class="text-danger" id="error_message_type_id"></p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="notification_type" class="control-label col-md-4 text-md-center">Notification Type:</label>
                        <div class="col-md-8">
                            <select class="form-control col-md-8" name="notification_type" id="notification_type">
                                <option value="" selected>Select Notification Type</option>
                                <option value="1">Email</option>
                                <option value="2">SMS</option>
                            </select>
                            <p class="text-danger" id="error_notification_type"></p>
                        </div>
                    </div>
                    <div class="col-md-4 float-right">
                        <p class="text-danger" id="error_notification_type"></p>
                    </div>
                </form>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-info btn-flat" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline-primary btn-flat" id="AddNotification">Save <i id="spinner_add" class=""></button>
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
    CKEDITOR.replace( 'notification_message' );
    //Initialize Select2 Elements
    $('.select2').select2()
    // Show All Notification
    showAllNotification();
    InitDatatable();
    function InitDatatable(){
        /*DataTable*/ 
        var table = $("#Notification").DataTable({
            // "searching": false,
            "sDom": '<"customcontent">rt<"row"<"col-lg-6" i><"col-lg-6" p>><"clear">',
            "paging": true,
            "pageLength": 10,
            scrollY: 600,
            //  scrollX: true,
            "autoWidth": true,
            lengthChange: false,
            responsive: true,
            fixedColumns: true,
            //"order": [[0, "desc"]]
        }); 
        /*Custom Search For DataTable*/
        $("#searchbox").on("keyup search input paste cut", function () {
            table.search(this.value).draw();
        });
    }

    // Get User Type
    $.ajax({
        method: 'get',
        url: '/Account/get_all_employer',
        dataType: 'json',
        success: function (data) {
            $.each(data, function (i, data) {
                $("#business_name").append('<option value="' + data.business_name + '">');
            });
        },
        error: function (response) {
            //console.log("Error cannot be");
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
        $('#notification_form')[0].reset();
        //notification_message.setData('');
        CKEDITOR.instances.notification_message.setData('');
        $('#select2-employer_id-container').attr('title', '').text('--Select Employer--');
        $('#select2-message_type_id-container').attr('title', '').text('--Select Message Type--');
        $('#AddNotification').removeAttr('disabled');
        $('#employer_id').removeClass('is-invalid');
        $('#error_employer_id').remove('Employer Field is Required');
    });

    // Store Notification
    $('#AddNotification').click(function () {
        $("#spinner_add").addClass('fa fa-refresh fa-spin');
        $('#AddNotification').attr('disabled', true);
        var url = $('#notification_form').attr('action');
        var data = $('#notification_form');
        toastr.remove()
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        if($('#employer_id').val() == ""){
            $('#employer_id').addClass('is-invalid');
            $('#error_employer_id').html('Employer Field is Required');
            $('#AddNotification').removeAttr('disabled');
            spinnerTimout();
        }
        if($('#notification_title').val() == ""){
            $('#notification_title').addClass('is-invalid');
            $('#error_notification_title').html('Notification Field is Required');
            $('#AddNotification').removeAttr('disabled');
            spinnerTimout();
        }
        //if(notification_message.getData() == ""){
        if(CKEDITOR.instances.notification_message.getData() == ""){
            $('#notification_message').addClass('is-invalid');
            $('#error_notification_message').html('Notification Message is Required ');
            $('#AddNotification').removeAttr('disabled');
            spinnerTimout();
        }
        if($('#message_type_id').val()== ""){
            $('#message_type_id').addClass('is-invalid');
            $('#error_message_type_id').html('Message Type is Required ');
            $('#AddNotification').removeAttr('disabled');
            spinnerTimout();
        }
        if($('#notification_type').val()== ""){
            $('#notification_type').addClass('is-invalid');
            $('#error_notification_type').html('Notification Type is Required ');
            $('#AddNotification').removeAttr('disabled');
            spinnerTimout();
        }
        
        if($('#employer_id').val() != "" &&
           $('#notification_title').val() != "" &&
           //notification_message.getData() != "" &&
           CKEDITOR.instances.notification_message.getData() != "" &&
           $('#message_type_id').val() != "" &&
           $('#notification_type').val() != "") {
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
                    notification_message: CKEDITOR.instances.notification_message.getData(),//notification_message.getData(),//$('#notification_message').val(),
                    message_type_id: $('#message_type_id').val(),
                    notification_type: $('#notification_type').val(),
                    
                },
                success: function (data){
                    $('#notification_form')[0].reset();
                    $("#Notification").DataTable().destroy();
                    // Modal hide
                    //$('#AddNotificationModal').modal('hide');
                    setTimeout(function (){
                            $('#AddNotificationModal').modal('hide');
                    }, 1000);
                    // Display a success toast, with a title
                    toastr.success('Notification Saved Successfully', 'Success')
                    setTimeout(function (){
                        $("#spinner_add").removeClass('fa fa-refresh fa-spin');
                        $('#AddNotification').removeAttr('disabled');
                    }, 1000);
                    // Show All Data
                    showAllNotification();
                    InitDatatable();
                },
                error: function (data, status){ 
                    console.clear();
                    toastr.error('Error. Please Choose a Option', 'Error!')
                    setTimeout(function (){
                        $("#spinner_add").removeClass('fa fa-refresh fa-spin');
                    }, 250);
                    /*Add Error Field*/
                    var errors = $.parseJSON(data.responseText);
                    $.each(errors, function (i, errors){
                        if(errors.notification_title)
                        {
                            $('#notification_title').addClass('is-invalid');
                            $('#error_notification_title').html('Notification Title is Required');
                            $('#AddNotification').removeAttr('disabled');
                        }
                        if(errors.notification_message)
                        {
                            $('#notification_message').addClass('is-invalid');
                            $('#error_notification_message').html('Notification Message is Required ');
                            $('#AddNotification').removeAttr('disabled');
                        }
                        if(errors.notification_type)
                        {
                            $('#notification_type').addClass('is-invalid');
                            $('#error_notification_type').html('Notification Type is Required');
                            $('#AddNotification').removeAttr('disabled');
                        }
                        if(errors.employer_id)
                        {
                            $('#employer_id').addClass('is-invalid');
                            $('#error_employer_id').html(errors.employer_id);
                            $('#AddNotification').removeAttr('disabled');
                        }
                        if(errors.message_type_id){
                            $('#message_type_id').addClass('is-invalid');
                            $('#error_message_type_id').html('Message Type Field is Required');
                            $('#AddNotification').removeAttr('disabled');
                        }
                    });
                    
                }
            });
        }
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
                CKEDITOR.instances.notification_message.setData(data[0].notification_message);
                //notification_message.setData(data[0].notification_message);
                //$('#employer_id').val(data[0].business_name);
                // $('#employer_id').attr('disabled', true);
                // $('#employer_id').addClass('disabled');
                $('#select2-employer_id-container').attr('title', data[0].employer_id).text(data[0].business_name);
                $('#select2-message_type_id-container').attr('title', data[0].message_type_id).text(data[0].message_type);
                $('#employer_id option[value="'+data[0].employer_id+'"]').prop('selected', true);
                $('#message_type_id option[value="'+data[0].message_type_id+'"]').prop('selected', true);
                $('#notification_type option[value="'+data[0].notification_type+'"]').prop('selected', true);
                
            },
            error: function(){
                //console.log('Error');
                console.clear();
            }
        });
    });

    //Delete a Notification
    $('#showdata').on('click', '.notification-delete', function(){
        var id = $(this).attr('data');
        toastr.remove()
        toastr.clear()
        swal({
            title: "Do you wanna Delete This Notification",
            type: "error",
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes",
            showCancelButton: true,
            closeOnConfirm: true,
        },

            function(){
                $.ajax({
                    type: 'POST',
                    url: '/Notification/destroy_notification',
                    data: {
                        id: id,
                        '_token': $('input[name=_token]').val(),
                    },
                    success: function(data){
                        $('#notification_form')[0].reset();
                        $("#Notification").DataTable().destroy();
                        setTimeout(function (){
                            $('#DeleteNotificationModal').modal('hide');
                        }, 400);
                        // Display a success toast, with a title
                        toastr.success('Notification Deleted Successfully', 'Success')
                        setTimeout(function (){
                            $("#spinner_delete").removeClass('fa fa-refresh fa-spin');
                        }, 1000);
                        showAllNotification();
                        InitDatatable();
                    },
                    error: function(data){ 
                        
                        toastr.error('Error Deleting Account')
                    }
                });
            }
        
        );
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
                        var notification_message = data[i].notification_message;
                        html +='<tr>'+
                                     '<td>'+data[i].business_name+'</td>'+
                                     '<td>'+data[i].notification_title+'</td>'+
                                     '<td>'+(notification_message.length > 10 ? notification_message.substring(0, 10)+'...' : data[i].notification_message)+'</td>'+
                                     '<td>'+data[i].message_type+'</td>'+
                                     '<td>'+type+'</td>'+
                                     '@if(auth()->user()->user_type_id == 1)<td>'+
                                        '<a href="javascript:;" class="btn btn-sm btn-outline-info btn-flat notification-edit" data="'+data[i].id+'" {{$edit}}><span class="icon is-small"><i class="fa fa-edit"></i></span>&nbsp;Edit</a>'+' '+
                                        '<a href="javascript:;" class="btn btn-sm btn-outline-danger btn-flat notification-delete" data="'+data[i].id+'" {{$delete}}><span class="icon is-small"><i class="fa fa-trash"></i></span>&nbsp;Delete</a>'+
                                    '</td>@endif'+
                                '</tr>';
                    }
                    if(type != null){
                        $('#showdata').html(html);
                    }
                },
                error: function(){
                    //console.log('Could not get data from database');
                }
            });
    }

    function spinnerTimout(){
        setTimeout(function (){
                    $("#spinner_add").removeClass('fa fa-refresh fa-spin');
        }, 250);
    }
});
</script>
@endsection