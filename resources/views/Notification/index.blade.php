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
            <li class="breadcrumb-item active">Manage Notifications</li>
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
    <div class="card card-info card-outline">
        <div class="card-header">
            <h3 class="card-title"><i class="fa fa-bell"></i> System Notification</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            @if(auth()->user()->user_type_id == 1)
            <div class="form-group row">
                {{-- <label for="searchbox" class="col-md-2 text-md-center" style="margin-top: 5px;"><i class="fa fa-search"></i>Search:</label> --}}
                <div class="col-md-6">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="fa fa-search input-group-text" style="background-color: #fff;"></span>
                            </div>
                            <input id="searchbox" type="text" class="form-control" name="searchbox" placeholder="Search">
                    </div>
                </div>
                <div class="col-md-6">
                    <a href="#Add" class="btn btn-primary float-md-right" id="btn_addnotification" data-toggle="modal" data-target="#AddNotificationModal" {{$add}}><i class="fa fa-plus-square"></i> Add System Notification</a>
                </div>
            </div>
            @endif
            <table id="Notification" class="table table-boredered table-striped">
                <thead>
                    <tr>
                        {{-- <th>ID</th> --}}
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
<div class="modal fade" id="AddNotificationModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="overflow:hidden;">
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
                    <div class="form-group">
                    {{-- <label for="notification_message" class="control-label col-md-4 text-md-center">Notification Message:</label> --}}
                        <div class="col-md-12">
                            
                            <textarea id="notification_message" class="form-control" name="notification_message" rows="10" placeholder="Notification Message"   autofocus></textarea>
                                    <p class="text-danger" id="error_notification_message"></p>
                        </div>
                    </div>
                    @if(auth()->user()->user_type_id == 1)
                    <div class="form-group row">
                            <label for="employer_id" class="control-label col-md-4 text-md-center">Select Employer:</label>
                            {{-- <select class="form-control col-md-4" name="employer_id" id="employer_id">
                                <option value="" selected>Select Employer</option>>
                            </select> --}}

                            {{-- <input id="employer_id" type="text" class="form-control" name="employer_id" list="business_name" placeholder="Employer" style="width: 260px !important;"   autofocus>
                                <p class="text-danger" id="error_employer_id"></p>
                                <datalist id="business_name">
                                    <option value="1">
                                </datalist> --}}

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
    CKEDITOR.replace( 'notification_message' );
    // CKEDITOR Config
    // let notification_message;
    // ClassicEditor
    //     .create( document.querySelector( '#notification_message' ) )
    //     .then( newNotification_message => {
    //         notification_message = newNotification_message;
    //     } )
    //     .catch( error => {
    //         console.error( error );
    //     } );
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
            "pageLength": 10000,
            scrollY: 500,
            //  scrollX: true,
            "autoWidth": true,
            lengthChange: false,
            responsive: true,
            fixedColumns: true,
            "order": [[0, "desc"]]
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
        $('#notification_form')[0].reset();
        //notification_message.setData('');
        CKEDITOR.instances.notification_message.setData('');
        $('#select2-employer_id-container').attr('title', '').text('--Select Employer--');
        $('#select2-message_type_id-container').attr('title', '').text('--Select Message Type--');
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
        if($('#employer_id').val() == ""){
            $('#employer_id').addClass('is-invalid');
            $('#error_employer_id').html('Employer Field is Required');
            spinnerTimout();
        }
        if($('#notification_title').val() == ""){
            $('#notification_title').addClass('is-invalid');
            $('#error_notification_title').html('Notification Field is Required');
            spinnerTimout();
        }
        //if(notification_message.getData() == ""){
        if(CKEDITOR.instances.notification_message.getData() == ""){
            $('#notification_message').addClass('is-invalid');
            $('#error_notification_message').html('Notification Message is Required ');
            spinnerTimout();
        }
        if($('#message_type_id').val()== ""){
            $('#message_type_id').addClass('is-invalid');
            $('#error_message_type_id').html('Message Type is Required ');
            spinnerTimout();
        }
        if($('#notification_type').val()== ""){
            $('#notification_type').addClass('is-invalid');
            $('#error_notification_type').html('Notification Type is Required ');
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
                    }, 400);
                    // Display a success toast, with a title
                    toastr.success('Notification Saved Successfully', 'Success')
                    setTimeout(function (){
                        $("#spinner").removeClass('fa fa-refresh fa-spin');
                    }, 1000);
                    // Show All Data
                    showAllNotification();
                    InitDatatable();
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
                            $('#error_notification_type').html('Notification Type is Required');
                        }
                        if(errors.employer_id)
                        {
                            $('#employer_id').addClass('is-invalid');
                            $('#error_employer_id').html('Employer Field is Required');
                        }
                        if(errors.message_type_id){
                            $('#message_type_id').addClass('is-invalid');
                            $('#error_message_type_id').html('Message Type Field is Required');
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
                console.log('Error');
            }
        });
    });

    //Delete a Notification
    $('#showdata').on('click', '.notification-delete', function(){
        var id = $(this).attr('data');
        // $('#DeleteNotificationModal').modal('show');
        // $('#DeleteNotificationModal').find('#title_modal').text('Delete Notification');
        // $('#notification_form').attr('hidden', true);
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
        //$('.modal-dialog').removeClass('modal-lg');
        // Prevent Previous handler - unbind()
        // $('#DeleteNotification').unbind().click(function(){
        //     $("#spinner_delete").addClass('fa fa-refresh fa-spin');
            
        // });
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
                                    // '<td>'+data[i].id+'</td>'+
                                     '<td>'+data[i].business_name+'</td>'+
                                     '<td>'+data[i].notification_title+'</td>'+
                                     '<td>'+(notification_message.length > 10 ? notification_message.substring(0, 10)+'...' : data[i].notification_message)+'</td>'+
                                     '<td>'+data[i].message_type+'</td>'+
                                     '<td>'+type+'</td>'+
                                     '@if(auth()->user()->user_type_id == 1)<td>'+
                                        // '<a href="javascript:;" class="btn btn-sm btn-info" id="ShowNotification" data-toggle="modal" data-target="#AddNotificationModal" data="'+data[i].id+'"><span class="icon is-small"><i class="fa fa-eye"></i></span>&nbsp;View</a>'+' '+
                                        '<a href="javascript:;" class="btn btn-sm btn-secondary notification-edit" data="'+data[i].id+'" {{$edit}}><span class="icon is-small"><i class="fa fa-edit"></i></span>&nbsp;Edit</a>'+' '+
                                        '<a href="javascript:;" class="btn btn-sm btn-danger notification-delete" data="'+data[i].id+'" {{$delete}}><span class="icon is-small"><i class="fa fa-trash"></i></span>&nbsp;Delete</a>'+
                                    '</td>@endif'+
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

    function spinnerTimout(){
        setTimeout(function (){
                    $("#spinner").removeClass('fa fa-refresh fa-spin');
        }, 250);
    }
});
</script>
@endsection