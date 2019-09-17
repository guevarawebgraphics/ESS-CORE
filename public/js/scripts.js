 $(document).ready(function (){
      /*
      * @ Announcement Notification Pusher
      */
     /**
      * @ Pusher Key
      * */
    let pusher_key = $('#pusher_key').val();
    var pusher = new Pusher(pusher_key, {
        cluster: 'ap2',
        forceTLS: true
      });
  
      var channel = pusher.subscribe('channel1');
      channel.bind('Announcement', function(data) {
        // Show Notification
        toastr.success('You have new Announcement')
        showAllAnnouncementToNotification();
      });
     /*Listen To The port then the emit message*/
     /**
      * @ Socket Real time Announcement Notification
      * */
	// var socket = io('http://127.0.0.1:6999');
	// 		socket.on('message', function (data) {
	// 		console.log(data);
    //         
    // });
        

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
        var employer_name = $(this).attr('data-business_name');
        var announcement_des = description;
        $('#Announcement_to_notification_modal').modal('show');
        $('#Announcement_to_notification_modal').find('#title_modal').text('Employer' + ' ' + 'Announcement');
        $('#announcement_title').html(title);
        $('#announcement_description').html("<div class='des-container'>"+announcement_des+"</div>");
        $('.des-container img').addClass('img-fluid img-thumbnail');
        $('.des-container').css("overflow-wrap","break-word");
        $.ajax({
            type: 'POST',
            url: '/Announcement/update_notification_show',
            async: false,
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
        // /get_show_announcement_notification_toggle();
        
    });

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
                var footer = '';
                var i;
                var count = 1;
                
                for(i=0; i<data.length; i++){
                    //var check_my_notification = get_show_announcement_notification_toggle(data[i].id);
                    var status = (data[i].announcement_status == 1 ? 'Posted' : data[i].announcement_status == 0 ? 'Pending' : null);
                    const date = new Date(data[i].updated_at);
                    let read = [];
                    $.ajax({
                        type: 'POST',
                        url: '/Announcement/get_notification_show',
                        async: false,
                        dataType: 'json',
                        data: {
                            '_token': $('input[name=_token]').val(), 
                            announcement_id : data[i].id
                        },
                        success: function (data){
                            //console.log(data);
                            read.push(data);
                            if(data == false){
                                $('#notif').html(count++); 
                                //console.log(read);
                            }
                        }
                    });
                    var announcement_des_strip = data[i].announcement_description.replace(/"/g, "'");
                    html += '<a class="dropdown-item show_announcement_notification" class="show_announcement_notification" href="#" id="Announcement_Notification" data-id="'+data[i].id+'"  data-title="'+data[i].announcement_title+'" data-description="'+announcement_des_strip +'"><!-- Message Start -->'+
                            '<div class="media">'+
                            '<img alt="User Avatar" style="heigth: 50px; width: 50px;" class="img-size-50 mr-3 img-circle" src="/storage/profile_picture/'+data[i].profile_picture+'">'+
                            '<div class="media-body">'+
                            '<h3 class="dropdown-item-title">'+data[i].announcement_title+'<span class="float-right text-sm text-danger" id="unread_notifcation"></span></h3>'+
                            // '<p class="text-sm">'+data[i].announcement_description+'</p>'+
                            '<p class="text-sm text-muted"><i class="fa fa-clock-o mr-1"></i>'+date.toDateString()+ ' <span class="badge badge-primary">'+(read[0] == false ?  'undread' : '')+'</span>'+'</p>'+
                            '</div>'+
                            '</div><!-- Message End --></a>'+
                            '<div class="dropdown-divider"></div><a class="dropdown-item" href="#"><!-- Message Start -->';
                }
                // footer += '<div class="dropdown-item dropdown-footer" id="see_more">See More Announcement</div>'+
                //             '</div>';
                if(status == 'Posted'){
                    $('#announcementdesc').html(html);
                    // Check if the Data is Greater than 5
                    if(data.length > 5){
                        $("#announcementdesc").css('height', '400px');
                    }
                    
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