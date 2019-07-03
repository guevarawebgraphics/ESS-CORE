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
            
    }
}
$(document).ready(function (){
    get_profile_picture();
    $('#profile_picture').click(function (){
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
            url: '/ProfilePicture/UploadPicture',
            method: 'POST',
            async: false,
			      dataType: 'json',
            data: formData,
            cache: false,
            contentType: false,
            enctype: 'multipart/form-data',
            processData: false,
            success: function(data){
              console.log("UPLOADED");
            },
            error: function(data){
              console.log("ERROR");
            }
            
        });
      });

      /**
       * @ Get Profile Picture
       * */
      function get_profile_picture(){
        $.ajax({
          type: 'GET',
          url: '/ProfilePicture/get_profile_picture',
          async: false,
          dataType: 'json',
          success: function(data){
            //console.log(data);
            $('#user_profile_picture').attr('src', '/storage/profile_picture/' + data);
          },
          error: function(data){

          }
        });
      }
});