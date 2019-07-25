@extends('layouts.master')
@section('crumb')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="m-0 text-dark">Send Announcements</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
                <a href="#">Send Announcements</a>
            </li>
            <li class="breadcrumb-item active">Manage Announement</li>
        </ol>
    </div>
</div>
@endsection
@section('content')
@php
if(Session::get('send_announcement') == 'all'){
    $add = '';
    $edit = '';
    $delete = '';
}
elseif(Session::get('send_announcement') == 'view'){
    $add = 'disabled';
    $edit = 'disabled';
    $delete = 'disabled';
}
elseif(Session::get('send_announcement') == 'add'){
    $add = '';
    $edit = 'disabled';
    $delete = 'disabled';
}
elseif(Session::get('send_announcement') == 'edit'){
    $add = '';
    $edit = '';
    $delete = 'disabled';
}
elseif(Session::get('send_announcement') == 'delete'){
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
        <h3 class="card-title"><i class="fa fa-bullhorn"></i> Announcements</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="form-group row">
            {{-- <label for="searchbox" class="col-md-2 text-md-center" style="margin-top: 5px;"><i class="fa fa-search"></i> Search:</label> --}}
            <div class="col-md-6">
                <div class="input-group">
                  <div class="input-group-prepend">
                      <span class="fa fa-search input-group-text" style="background-color: #fff;"></span>
                    </div>
                    <input id="searchbox" type="text" class="form-control" name="searchbox" placeholder="Search">
              </div>
            </div>
            <div class="col-md-6">
                <a href="#Add" class="btn btn-outline-primary btn-flat float-md-right" id="btn_addannouncement" data-toggle="modal" data-target="#AddAnnouncementModal"><i class="fa fa-plus-square" {{$add}}></i> Create Announcement</a>
            </div>
        </div>

        <table id="AnnouncementTable" class="table table-boredered table-striped">
            <thead>
                <tr>
                    {{-- <th>ID</th> --}}
                    @if(auth()->user()->user_type_id === 1)
                    <th>Employer</th>
                    @endif
                    <th>Announcement Title</th>
                    {{-- <th>Announcement Description</th> --}}
                    <th>Announcement Status</th>
                    {{-- <th>Announcement Type</th> --}}
                    <th>Send Announcement</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="showdata">
                {{-- Showdata --}}
            </tbody>
        </table>
    </div>
</div>

<!-- Add Announcement -->
<div class="modal fade" id="AddAnnouncementModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content card-info card-outline">
        <div class="modal-header">
          <h5 class="modal-title" id="title_modal"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form id="annoucement_form">
            {{-- CSRF --}}
                @csrf
                <div class="form-group row">
                <label for="announcement_title" class="control-label col-md-4 text-md-center">Announcement Title:</label>
                    <div class="col-md-6">
                        
                        <input id="announcement_title" type="text" class="form-control" name="announcement_title" placeholder="Announcement Title"   autofocus>
                                <p class="text-danger" id="error_announcement_title"></p>
                    </div>
                </div>
                <div class="form-group row">
                <label for="announcement_description" class="control-label col-md-4 text-md-center">Announcement Description:</label>
                    <div class="col-md-12">
                        
                        <textarea id="announcement_description" type="text" class="form-control" name="announcement_description" placeholder="Announcement Description" autofocus></textarea>
                                <p class="text-danger" id="error_annoucement_description"></p>
                    </div>
                </div>
                @if(auth()->user()->user_type_id == 1)
                <div class="form-group row">
                    {{-- <label for="announcement_type" class="col-md-4 text-md-center">Announcement Type:</label>
                    <div class="col-md-6">
                        
                            <select id="announcement_type" name="announcement_type" class="form-control">
                                <option value="" selected>Choose Announcement Type...</option>
                            </select>
                            <input class="form-control" type="text" id="announcement_type" name="announcement_type" placeholder="Announcement Type">
                                <p class="text-danger" id="error_announcement_type"></p>
                    </div> --}}
                </div>
                
                    <div class="form-group row">
                            <label for="employer_id" class="control-label col-md-4 text-md-center">Select Employer:</label>

                                <div class="col-md-8">
                                    {{-- <select class="form-control select2" style="width: 67%; padding-right: 250px !important;" name="employer_id" id="employer_id">
                                        <option selected value="">--Select Employer</option>
                                        @foreach($employers as $employer)
                                            <option value="{{$employer->id}}">{{$employer->business_name}}</option>
                                        @endforeach
                                    </select> --}}
                                    <select class="form-control select2" multiple="multiple" data-placeholder="Select a Employers" style="width: 100%;" name="employer_id[]" id="employer_id">
                                        @foreach($employers as $employer)
                                            <option value="{{$employer->id}}">{{$employer->business_name}}</option>
                                        @endforeach
                                    </select>
                                    <p class="text-danger" id="error_employer_id"></p>
                                </div>
                    </div>
                    @endif
                
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary btn-flat" id="CancelAnnouncement" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-outline-primary btn-flat" id="SaveAnnoucement" {{$add}}>Save <i id="spinner" class=""></button>
        </div>
    
      </div>
    </div>
  </div>


  <!-- Delete Announcement -->
<div class="modal fade" id="DeleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="title_modal"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <h1>This is Sparta!!!!!!!! DELETE THIS!</h1>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="DeleteAnnouncement">Confirm <i id="spinner_delete" class=""></button>
        </div>
      </div>
    </div>
  </div>

    <!-- Post Announcement -->
<div class="modal fade" id="PostModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="title_modal"></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <h1>Post This Announcement</h1>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary btn-flat" id="PostCancel" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline-primary btn-flat" id="PostAnnouncement">Confirm <i id="spinner_post" class=""></button>
            </div>
          </div>
        </div>
      </div>

<script>
$(document).ready(function (){
    // CKEDITOR.replace( 'announcement_description', {
    //     filebrowserBrowseUrl: '/browser/browse.php',
    //     filebrowserUploadUrl: '../../public/Documents/announcement_image/'
    // });
    var editor = CKEDITOR.replace( 'announcement_description' );
    CKFinder.setupCKEditor( editor );
    //CKFinder.config( { connectorPath: '/ckeditor/ckfinder/core/connector/php/connector.php' } );
    $('.select2').select2()
    //Get Scripts
    // $.getScript( "js/scripts.js" )
    //     .done(function( script, textStatus ) {
    //         //console.log( textStatus );
    //     })
    //     .fail(function( jqxhr, settings, exception ) {
    //         //console.log("Error")
    // });
    // Show All Data
    showAllAnnouncement();
    initDataTableAnnouncement();
    function initDataTableAnnouncement(){
        /*DataTable*/ 
        var table = $("#AnnouncementTable").DataTable({
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
        url: '/Account/get_user_type',
        dataType: 'json',
        success: function (data) {
            $.each(data, function (i, data) {
                $("#announcement_type").append('<option value="' + data.id + '">' + data.type_name + '</option>');
            });
        },
        error: function (response) {
            //console.log("Error cannot be");
        }
    });


    $('#btn_addannouncement').click(function (){
        $('#annoucement_form')[0].reset();
        $('#annoucement_form').attr('action', '/Announcement/store_announcement');
        $('#AddAnnouncementModal').find('#title_modal').text('Add Announcement');
        $('#annoucement_form').removeAttr('hidden');
        CKEDITOR.instances.announcement_description.setData('');
        $('#select2-employer_id-container').attr('title', '').text('--Select Employer--');
        $("#SaveAnnoucement").removeAttr('disabled');
        $('#CancelAnnouncement').removeAttr('disabled');
    });

    /*Save Announcement*/
    $('#SaveAnnoucement').click(function (e){
        $("#SaveAnnoucement").attr('disabled', true);
        $('#CancelAnnouncement').attr('disabled', true);
        var url = $('#annoucement_form').attr('action');
        var employer_selected = [];
        $('#employer_id :selected').each(function() {
            employer_selected.push($(this).val());
        });
        //var data = $('#annoucement_form').serialize();
        $("#spinner").addClass('fa fa-refresh fa-spin');
        e.preventDefault();
        toastr.remove();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        if($('#announcement_title').val() == ""){
            $('#announcement_title').addClass('is-invalid');
            $('#error_announcement_title').html('Annoucement Title is Required');
            $("#SaveAnnoucement").removeAttr('disabled');
            spinnerTimout();
        }
        if(CKEDITOR.instances.announcement_description.getData() == ""){
            $('#announcement_description').addClass('is-invalid');
            $('#error_annoucement_description').html('Annoucement Description is Required');
            $("#SaveAnnoucement").removeAttr('disabled');
            spinnerTimout();
        }
        // if($('#announcement_type').val() == ""){
        //     $('#announcement_type').addClass('is-invalid');
        //     $('#error_announcement_type').html('Annoucement Type is Required');
        //     spinnerTimout();
        // }
        if($('#announcement_title').val() != "" &&
            CKEDITOR.instances.announcement_description.getData()  != "") {
                    $.ajax({
                    type: 'ajax',
                    url: url,
                    method: 'POST',
                    dataType: 'json',
                    async: false,
                    data: {
                        _token:     '{{ csrf_token() }}',
                        employer_id: ({{ auth()->user()->user_type_id }} === 1 ? employer_selected : null),
                        announcement_title: $('#announcement_title').val(),
                        announcement_description: CKEDITOR.instances.announcement_description.getData(),
                        // announcement_type: $('#announcement_type').val(),
                    },
                    success: function(data){
                        $('#annoucement_form')[0].reset();
                        $('#AnnouncementTable').DataTable().destroy();
                        // Show All Data
                        showAllAnnouncement();
                        initDataTableAnnouncement();
                        // Modal hide
                        //$('#AddNotificationModal').modal('hide');
                        setTimeout(function (){
                                $('#AddAnnouncementModal').modal('hide');
                        }, 1000);
                        // Display a success toast, with a title
                        toastr.success('Announcement Saved Successfully', 'Success')
                        setTimeout(function (){
                            $("#spinner").removeClass('fa fa-refresh fa-spin');
                        }, 1500);
                    },
                    error: function(data, status){
                        //console.log(employer_selected);
                        $("#SaveAnnoucement").removeAttr('disabled');
                        toastr.error('Error. Please Complete the fields', 'Error!')
                        setTimeout(function (){
                            $("#spinner").removeClass('fa fa-refresh fa-spin');
                        }, 250);
                        /*Add Error Field*/
                        var errors = $.parseJSON(data.responseText);
                        $.each(errors, function(i, errors){
                            if(errors.announcement_title){
                                $('#announcement_title').addClass('is-invalid');
                                $('#error_announcement_title').html('Annoucement Title is Required');
                                $("#SaveAnnoucement").removeAttr('disabled');
                            }
                            if(errors.announcement_description){
                                $('#announcement_description').addClass('is-invalid');
                                $('#error_annoucement_description').html('Annoucement Description is Required');
                                $("#SaveAnnoucement").removeAttr('disabled');
                            }
                            // if(errors.announcement_type){
                            //     $('#announcement_type').addClass('is-invalid');
                            //     $('#error_announcement_type').html('Annoucement Type is Required');
                            // }
                        });
                    }
                });
           }
        
    });

    // Edit Announcement
    $('#showdata').on('click', '.announcement-edit', function(){
        var id = $(this).attr('data');
        console.log(id);
        $('#AddAnnouncementModal').modal('show');
        $('#AddAnnouncementModal').find('#title_modal').text('Edit Announcement');
        $('#annoucement_form').attr('action', '/Announcement/update_announcement/' + id);
        $('#annoucement_form').removeAttr('hidden');
        /*Remove Error Field*/
        $('#announcement_title').removeClass('is-invalid');
        $('#error_announcement_title').remove();
        $('#announcement_description').removeClass('is-invalid');
        $('#error_annoucement_description').remove();
        toastr.remove()
        $.ajax({
            type: 'ajax',
            method: 'get',
            url: '/Announcement/edit_announcement',
            data: {id: id},
            dataType: 'json',
            success: function(data){
                $('#announcement_title').val(data[0].announcement_title);
                $('#announcement_description').val(data[0].announcement_description);
               // $('#announcement_type option[value="'+data[0].announcement_type+'"]').prop('selected', true);
                CKEDITOR.instances.announcement_description.setData(data[0].announcement_description);
                $('#select2-employer_id-container').attr('title', data[0].employer_id).text(data[0].business_name);
                //$('#announcement_type').val(data[0].announcement_type);
            },
            error: function(){
                console.log("Error");
            }
        });
    });


    /*Post Announcement*/
    $('#showdata').on('click', '.announcement-post', function(){
        var id = $(this).attr('data');
        //var announcement_type = $(this).attr('data-announcementtype');
        $('#PostModal').modal('show');
        $('#PostModal').find('#title_modal').text('Post Announcement');
        $('#PostAnnouncement').removeAttr('disabled');
        $('#PostCancel').removeAttr('disabled');
        // console.log(id);
        // console.log(announcement_type);
        toastr.remove()
        $('#PostAnnouncement').unbind().click(function(){
            $('#PostAnnouncement').attr('disabled', true);
            $('#PostAnnouncement').addClass('PostAnnouncement');
            $('.PostAnnouncement').removeAttr('id');
            $('#PostCancel').attr('disabled', true);
            $('#spinner_post').addClass('fa fa-refresh fa-spin');
            $.ajax({
                type: 'POST',
                url: '/Announcement/update_announcement_status',
                data: {
                    id: id,
                    //announcement_type: announcement_type,
                    '_token': $('input[name=_token]').val(),
                },
                success: function(data){
                    $('#PostAnnouncement').removeAttr('disabled');
                    $('#PostAnnouncement').removeClass('PostAnnouncement');
                    $('.PostAnnouncement').attr('id', 'PostAnnouncement');
                    $('#AnnouncementTable').DataTable().destroy();
                    showAllAnnouncement();
                    showAllAnnouncementToNotification();
                    initDataTableAnnouncement();
                    // Modal hide
                    //$('#AddNotificationModal').modal('hide');
                    setTimeout(function (){
                            $('#PostModal').modal('hide');
                    }, 400);
                    // Display a success toast, with a title
                    toastr.success('Announcement Successfully Posted', 'Success')
                    setTimeout(function (){
                        $("#spinner_post").removeClass('fa fa-refresh fa-spin');
                    }, 300);
                },
                error: function(){
                    toastr.error('Error Deleting Announcement')
                    setTimeout(function (){
                        $("#spinner_post").removeClass('fa fa-refresh fa-spin');
                    }, 250);
                    $('#PostAnnouncement').removeAttr('disabled');
                }
            });
        });
        
    });


    // Delete Announcement
    $('#showdata').on('click', '.annoucement-delete', function(){
        var id = $(this).attr('data');
        // $('#DeleteModal').modal('show');
        // $('#DeleteModal').find('#title_modal').text('Delete Announcement');
        // $('#annoucement_form').attr('hidden', true);
        toastr.remove()
        // Remove current toasts using animation
        toastr.clear()
        swal({
                title: "Do you wanna Delete This Announcement?",
                type: "error",
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes",
                showCancelButton: true,
                closeOnConfirm: true,
        },
            function(){
                $.ajax({
                    type: 'POST',
                    url: '/Announcement/destroy_announcement',
                    data: {
                        id: id,
                        '_token': $('input[name=_token]').val(),
                    },
                    success: function(data){
                        // Modal hide
                        setTimeout(function (){
                                $('#DeleteModal').modal('hide');
                        }, 400);
                        // Display a success toast, with a title
                        toastr.success('Announcement Deleted', 'Success')
                        setTimeout(function (){
                            $("#spinner_delete").removeClass('fa fa-refresh fa-spin');
                        }, 300);
                        showAllAnnouncement();
                        showAllAnnouncementToNotification();
                    },
                    error: function(data){
                        toastr.error('Error Deleting Announcement')
                        setTimeout(function (){
                            $("#spinner_delete").removeClass('fa fa-refresh fa-spin');
                        }, 250);
                    }

                });
            }
        );
        // Prevent Previous handler - unbind()
        $('#DeleteAnnouncement').click(function(){
            $("#spinner_delete").addClass('fa fa-refresh fa-spin');
           
        });
    });


    //Show Data
    function showAllAnnouncement(){
        $.ajax({
            type: 'GET',
            url: '/Announcement/get_all_announcement',
            async: false,
            dataType: 'json',
            success: function(data){
                var html = '';
                var i;
                for(i=0; i<data.length; i++){
                    var AnnouncementStatus = (data[i].announcement_status == 0 ? '<span class="badge badge-warning">'+"Pending"+'</span>': data[i].announcement_status == 1 ? '<span class="badge badge-success">'+"Posted"+'</span>': null);
                    var posted = (data[i].announcement_status == 1 ? "disabled": "");
                        html +='<tr>'+
                                    // '<td>'+data[i].id+'</td>'+
                                     '@if(auth()->user()->user_type_id === 1)<td>'+data[i].business_name+'</td>@endif'+
                                     '<td>'+data[i].announcement_title+'</td>'+
                                    //  '<td>'+data[i].announcement_description+'</td>'+
                                     '<td>'+AnnouncementStatus+'</td>' +
                                     //'<td>'+data[i].type_name+'</td>'+
                                     '<td>' + '<a href="#send" class="send btn btn-sm btn-outline-info btn-flat announcement-post '+posted+'" data-toggle="modal" data-target="#sendModal" data="'+data[i].id+'"  {{$edit}}><i class="fa fa-paper-plane"></i> POST</a>' + '</td>'+
                                     '<td>'+
                                        '<a href="javascript:;" class="btn btn-sm btn-outline-info btn-flat announcement-edit '+posted+'" data="'+data[i].id+'" {{$edit}}><span class="icon is-small"><i class="fa fa-edit"></i></span>&nbsp;Edit</a>'+' '+
                                        '<a href="javascript:;" class="btn btn-sm btn-outline-danger btn-flat annoucement-delete" data="'+data[i].id+'" {{$delete}}><span class="icon is-small"><i class="fa fa-trash"></i></span>&nbsp;Delete</a>'+
                                    '</td>'+
                                '</tr>';
                    }
                     //if(AnnouncementStatus != null){
                        $('#showdata').html(html);
                     //}
                    //console.log('success');
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


    /*
        Extended Excript for Get All Announcement To Notification
    */
    // showAllAnnouncementToNotification();

    // $('#announcement').click(function (){
    //     showAllAnnouncementToNotification();
    // });

    // $('#announcementdesc').on('click', '.show_announcement_notification',function (){
    //     var title = $(this).attr('data-title');
    //     var description = $(this).attr('data-description');
    //     swal({

    //             title: title,
    //             text: jQuery(description).text(), // Strip Tag
    //             showCancelButton: true,
    //         },



    //     );
    // });
    function showAllAnnouncementToNotification(){
        // Show Notification
        $.ajax({
            type: 'ajax',
            method: 'get',
            url: '/Announcement/get_all_announcement_to_notification',
            async: false,
            dataType: 'json',
            success: function (data) {
                var html = '';
                var i;
                var count = 1;
                for(i=0; i<data.length; i++){
                    var status = (data[i].announcement_status == 1 ? 'Posted' : data[i].announcement_status == 0 ? 'Pending' : null);
                    const date = new Date(data[i].updated_at);
                    $('#notif').html(count++);
                    html += '<a class="dropdown-item show_announcement_notification" href="#" id="Announcement_Notification"  data-title="'+data[i].announcement_title+'" data-description="'+data[i].announcement_description+'"><!-- Message Start -->'+
                            '<div class="media">'+
                            '<img alt="User Avatar" class="img-size-50 mr-3 img-circle" src="../dist/img/user3-128x128.jpg">'+
                            '<div class="media-body">'+
                            '<h3 class="dropdown-item-title">'+data[i].announcement_title+'<span class="float-right text-sm text-danger"><i class="fa fa-star"></i></span></h3>'+
                            '<p class="text-sm">'+data[i].announcement_description+'</p>'+
                            '<p class="text-sm text-muted"><i class="fa fa-clock-o mr-1"></i>'+date.toDateString()+'</p>'+
                            '</div>'+
                            '</div><!-- Message End --></a>'+
                            '<div class="dropdown-divider"></div><a class="dropdown-item" href="#"><!-- Message Start -->';
                }
                if(status == 'Posted'){
                    $('#announcementdesc').html(html);
                    
                }
                else if(status == 'Pending'){
                    $('#announcementdesc').html('No Announcement Found');
                }
                
                //console.log("success");
            },
            error: function (response) {
                
            }
        });
    }
});
</script>
@endsection