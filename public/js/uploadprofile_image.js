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
    $('#profile_picture').click(function (){
        console.log("Test");
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

      $('#Upload').click(function (){
        console.log("Test1");
        $('#formOverlay').addClass('overlay');
        $("#spinner").addClass('fa fa-refresh fa-spin');
      });
});