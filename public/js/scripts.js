 $(document).ready(function (){
    var session_notification = true;
    var session = localStorage.setItem(session_notification, true);
    showAllAnnouncementToNotification();

    $('#announcement').click(function (){
        showAllAnnouncementToNotification();
        if(session_notification){
            session_notification = false;
        }
        if(session_notification == false){
            $('#notif').attr('hidden', true);
            session_notification = false;
        }
    });

    $('#announcementdesc').on('click', '.show_announcement_notification',function (){
        var announcement_id = $(this).attr('data-id');
        var title = $(this).attr('data-title');
        var description = $(this).attr('data-description');
        swal({
                title: title,
                text: jQuery(description).text(), // Strip Tag
                showCancelButton: true,
            },
        );
        $.ajax({
            type: 'POST',
            url: '/Announcement/update_notification_show',
            data: {
                notification_id: announcement_id,
                '_token': $('input[name=_token]').val(),
            },
            success: function(){
                // console.log('Success');
            },
            error: function(){
                // console.log("Err");
            }
        });
        get_show_announcement_notification_toggle();
        
    });


    /*Announcement Notification Toggle*/
    function get_show_announcement_notification_toggle(){
        $.ajax({
            type: 'GET',
            url: '/Announcement/get_notification_show',
            async: false,
            dataType: 'json',
            success: function (data){
                console.log(data);
            }
        })
    }
    
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
                var check_my_notification = get_show_announcement_notification_toggle();
                for(i=0; i<data.length; i++){
                    var status = (data[i].announcement_status == 1 ? 'Posted' : data[i].announcement_status == 0 ? 'Pending' : null);
                    const date = new Date(data[i].updated_at);
                    if(check_my_notification == 1){
                        session_notification = false;
                    }
                    if(check_my_notification == 0){
                        $('#notif').html(count++);
                    }
                    html += '<a class="dropdown-item show_announcement_notification" href="#" id="Announcement_Notification" data-id="'+data[i].id+'"  data-title="'+data[i].announcement_title+'" data-description="'+data[i].announcement_description+'"><!-- Message Start -->'+
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

    // function toggle_notification(){
    //     $.
    // }
 });