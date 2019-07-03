	//for showing description 
    $(document).ready(function(){
        $('.showfulldescription').click(function(e){ 
            var id = $(this).attr('id');
            var data_description = $(this).attr('data-description'); 
            var data_title = $(this).attr('data-title');  
  
         
            $('#contentdescription').html(data_description); 
            $('#contenttitle').html(data_title);
            }); 
            $('.carousel').carousel()

    });