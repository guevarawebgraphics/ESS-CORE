 /*Function to get Filename*/
 function processSelectedFilesProfileImage(fileInput) {
    var files = fileInput.files;

    for (var i = 0; i < files.length; i++) {
        if(files[i].name.length > 50){
            $('#profile_image_filename').html(files[i].name.substr(0,50));
        }
        else {
            $('#profile_image_filename').html(files[i].name);
        }
        $("#Upload").attr('data-image',files[i].name.toLowerCase()); 
        $("#Upload").attr('data-file',files[i].name);
    } 
}
$(document).ready(function (){
    
    $('#profile_picture').click(function (){
      $("#Upload").removeAttr("disabled");
      $("#spinner").removeClass('fa fa-refresh fa-spin');
      $.ajax({
        type: 'GET',
        url: '/ProfilePicture/get_profile_picture',
        async: false,
        dataType: 'json',
        success: function(data){
          //console.log(data);
          $('#image_preview').attr('src', '/storage/profile_picture/' + data);
        },
        error: function(data){

        }
      });
        $('#upload_profile_picture').modal('show');
    });

   
    /*Function for read Image*/ 
    function readURL(input) {

        if (input.files && input.files[0]) {
          var reader = new FileReader();
      
          reader.onload = function(e) {
            $('#image_preview').attr('src', e.target.result);
          }
      
          reader.readAsDataURL(input.files[0]);
        }
      }
      
      $("#imgInp").change(function() {
        readURL(this);
      });

      // $('#Upload').click(function (){
      //   console.log("Test1");
      //   $('#formOverlay').addClass('overlay');
      //   $("#spinner").addClass('fa fa-refresh fa-spin');
      // }); 
      
            $('#upload_image').submit(function (e){ 
                toastr.remove() 
                $("#Upload").attr("disabled",true);
                $('#spinner').addClass('fa fa-refresh fa-spin');
                value_image = $("#Upload").attr('data-image');
                extension_checker = value_image.substr( (value_image.lastIndexOf('.') +1));
                
                if(value_image === "empty")
                {
                 
                  toastr.error('Please select an image', 'Failed')
                  spinnerTimout()
                  $("#Upload").removeAttr("disabled");
                  return false;
                } 
                if(extension_checker == "jpg" || extension_checker == "jpeg" || extension_checker == "png")
                {

                          e.preventDefault();
                          toastr.remove()
                          var formData = new FormData($(this)[0]);
                          $.ajaxSetup({
                              headers: {
                                  'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                              }
                          });
                          $.ajaxSetup({
                            headers: {
                              'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                            }
                          });

                          $.ajax({
                              url: '/ProfilePicture/UpdatePicture',
                              method: 'POST',
                              async: false,
                              dataType: 'json',
                              data: formData,
                              cache: false,
                              contentType: false,
                              enctype: 'multipart/form-data',
                              processData: false,
                              success: function(data){
                                toastr.success('Picture Updated Successfully', 'Success') 
                                console.log("UPLOADED");
                            //    get_profile_picture()  
                                get_profile_picture_settings() 
                                get_profile_picture_refresh()
                                spinnerTimout() 
                                setTimeout(function (){
                                  $("#upload_profile_picture").modal('hide');
                                }, 1000);
                             
                              },
                              error: function(data){
                                console.log("ERROR"); 
                                $("#Upload").removeAttr("disabled"); 
                                spinnerTimout() 
                              }
                              
                          });
                                     
                          
                }
                else {

                  toastr.error('Please upload JPG or PNG file', 'Failed')
                  return false;

                    } 
             
            });
  
      
      
        function get_profile_picture_settings(){
          $.ajax({
            type: 'GET',
            url: '/ProfilePicture/get_profile_picture',
            async: false,
            dataType: 'json',
            success: function(data){
              //console.log(data);
              $('#settings_profile_picture').attr('src', '/storage/profile_picture/' + data);
            },
            error: function(data){
  
            }
    
          });
        } 
        /* Refresh profile picture after uploading */
        function get_profile_picture_refresh(){
          $.ajax({
            type: 'GET',
            url: '/ProfilePicture/get_profile_picture',
            async: false,
            dataType: 'json',
            success: function(data){
            $('#user_profile_picture').attr('src', '/storage/profile_picture/' + data);
      
             },
            error: function(data){
  
            }
          });
        } 
      //  get_profile_picture()
        /**
         * @ Get Profile Picture
         * */
     /*   function get_profile_picture(){
          $.ajax({
            type: 'GET',
            url: '/ProfilePicture/get_profile_picture',
            async: false,
            dataType: 'json',
            success: function(data){
         //     $('#user_profile_picture').attr('src', '/storage/profile_picture/' + data);
                 if (data=="essfemale.png" || data=="essmale.png") 
                   {
                       $('#data_to_do').val("add");
                   }
                   else
                   {
                       $('#data_to_do').val("update");
                   }
              
             },
            error: function(data){
  
            }
          });
        }
       */ 
    function spinnerTimout(){
      setTimeout(function (){
                  $("#spinner").removeClass('fa fa-refresh fa-spin');
      }, 1000);
    } 
});