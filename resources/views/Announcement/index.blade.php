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
            <label for="searchbox" class="col-md-2 text-md-center" style="margin-top: 5px;"><i class="fa fa-search"></i> Search:</label>
            <div class="col-md-4">
                <input id="searchbox" type="text" class="form-control" name="searchbox" placeholder="Search">
            </div>
            <div class="col-md-6">
                <a href="#Add" class="btn btn-primary float-md-right" id="btn_addannouncement" data-toggle="modal" data-target="#AddAnnouncementModal"><i class="fa fa-plus-square" {{$add}}></i> Create Announcement</a>
            </div>
        </div>

        <table id="AnnouncementTable" class="table table-boredered table-striped">
            <thead>
                <tr>
                    {{-- <th>ID</th> --}}
                    <th>Employer</th>
                    <th>Announcement Title</th>
                    <th>Announcement Description</th>
                    <th>Announcement Status</th>
                    <th>Announcement Type</th>
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
<div class="modal fade" id="AddAnnouncementModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
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
                    <div class="col-md-6">
                        
                        <textarea id="announcement_description" type="text" class="form-control" name="announcement_description" placeholder="Announcement Description" autofocus></textarea>
                                <p class="text-danger" id="error_annoucement_description"></p>
                    </div>
                </div>
                <div class="form-group row">
                        <label for="announcement_type" class="col-md-4 text-md-center">Announcement Type:</label>
                        <div class="col-md-6">
                            
                                <select id="announcement_type" name="announcement_type" class="form-control">
                                    <option value="" selected>Choose Announcement Type...</option>
                                </select>
                                    <p class="text-danger" id="error_announcement_type"></p>
                        </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="SaveAnnoucement" {{$add}}>Save <i id="spinner" class=""></button>
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
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="PostAnnouncement">Confirm <i id="spinner_post" class=""></button>
            </div>
          </div>
        </div>
      </div>

<script>
$(document).ready(function (){
    //Get Scripts
    $.getScript( "js/scripts.js" )
        .done(function( script, textStatus ) {
            //console.log( textStatus );
        })
        .fail(function( jqxhr, settings, exception ) {
            //console.log("Error")
    });
    // Show All Data
    showAllAnnouncement();
    /*DataTable*/ 
    var table = $("#AnnouncementTable").DataTable({
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
        url: '/Account/get_user_type',
        dataType: 'json',
        success: function (data) {
            $.each(data, function (i, data) {
                $("#announcement_type").append('<option value="' + data.id + '">' + data.type_name + '</option>');
            });
        },
        error: function (response) {
            console.log("Error cannot be");
        }
    });


    $('#btn_addannouncement').click(function (){
        $('#annoucement_form')[0].reset();
        $('#annoucement_form').attr('action', '/Announcement/store_announcement');
        $('#AddAnnouncementModal').find('#title_modal').text('Add Announcement');
        $('#annoucement_form').removeAttr('hidden');
    });

    /*Save Announcement*/
    $('#SaveAnnoucement').click(function (e){
        var url = $('#annoucement_form').attr('action');
        var data = $('#annoucement_form').serialize();
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
            spinnerTimout();
        }
        if($('#announcement_description').val() == ""){
            $('#announcement_description').addClass('is-invalid');
            $('#error_annoucement_description').html('Annoucement Description is Required');
            spinnerTimout();
        }
        if($('#announcement_type').val() == ""){
            $('#announcement_type').addClass('is-invalid');
            $('#error_announcement_type').html('Annoucement Type is Required');
            spinnerTimout();
        }
        if($('#announcement_title').val() != "" &&
           $('#announcement_description').val() != "" &&
           $('#announcement_type').val() != "") {
                    $.ajax({
                    type: 'ajax',
                    url: url,
                    method: 'POST',
                    dataType: 'json',
                    async: false,
                    data: data,
                    success: function(data){
                        $('#annoucement_form')[0].reset();
                        // Show All Data
                        showAllAnnouncement();
                        // Modal hide
                        //$('#AddNotificationModal').modal('hide');
                        setTimeout(function (){
                                $('#AddAnnouncementModal').modal('hide');
                        }, 400);
                        // Display a success toast, with a title
                        toastr.success('Announcement Saved Successfully', 'Success')
                        setTimeout(function (){
                            $("#spinner").removeClass('fa fa-refresh fa-spin');
                        }, 1500);
                    },
                    error: function(data, status){
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
                            }
                            if(errors.announcement_description){
                                $('#announcement_description').addClass('is-invalid');
                                $('#error_annoucement_description').html('Annoucement Description is Required');
                            }
                            if(errors.announcement_type){
                                $('#announcement_type').addClass('is-invalid');
                                $('#error_announcement_type').html('Annoucement Type is Required');
                            }
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
                $('#announcement_type option[value="'+data[0].announcement_type+'"]').prop('selected', true);
            },
            error: function(){
                console.log("Error");
            }
        });
    });


    /*Post Announcement*/
    $('#showdata').on('click', '.announcement-post', function(){
        var id = $(this).attr('data');
        var announcement_type = $(this).attr('data-announcementtype');
        $('#PostModal').modal('show');
        $('#PostModal').find('#title_modal').text('Post Announcement');
        // console.log(id);
        // console.log(announcement_type);
        toastr.remove()
        $('#PostAnnouncement').unbind().click(function(){
            $('#spinner_post').addClass('fa fa-refresh fa-spin');
            $.ajax({
                type: 'POST',
                url: '/Announcement/update_announcement_status',
                data: {
                    id: id,
                    announcement_type: announcement_type,
                    '_token': $('input[name=_token]').val(),
                },
                success: function(data){
                    showAllAnnouncement();
                    showAllAnnouncementToNotification();
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
                                     '<td>'+data[i].business_name+'</td>'+
                                     '<td>'+data[i].announcement_title+'</td>'+
                                     '<td>'+data[i].announcement_description+'</td>'+
                                     '<td>'+AnnouncementStatus+'</td>' +
                                     '<td>'+data[i].type_name+'</td>'+
                                     '<td>' + '<a href="#send" class="send btn btn-sm btn-info announcement-post '+posted+'" data-toggle="modal" data-target="#sendModal" data="'+data[i].id+'" data-announcementtype="'+data[i].announcement_type+'" {{$edit}}><i class="fa fa-paper-plane"></i> POST</a>' + '</td>'+
                                     '<td>'+
                                        '<a href="javascript:;" class="btn btn-sm btn-secondary announcement-edit '+posted+'" data="'+data[i].id+'" {{$edit}}><span class="icon is-small"><i class="fa fa-edit"></i></span>&nbsp;Edit</a>'+' '+
                                        '<a href="javascript:;" class="btn btn-sm btn-danger annoucement-delete" data="'+data[i].id+'" {{$delete}}><span class="icon is-small"><i class="fa fa-trash"></i></span>&nbsp;Delete</a>'+
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
});
</script>
@endsection