	//for showing description 
    $(document).ready(function(){
        $('.showfulldescription').click(function(e){ 
           
            var id = $(this).attr('id');
            var data_description = $(this).attr('data-description'); 
            var data_title = $(this).attr('data-title');  
            //var id = $(this).attr('data-action');
            $('#'+id+'-action').html("<span class='badge badge-primary'>Read</span>");
            
            
            $('#contentdescription').html(data_description); 
            $('#contenttitle').html(data_title);
            //checking for image and responsive
            var check_has = data_description.includes("img"); 
            e.preventDefault();
            if(check_has){
                $('#imageview img').addClass('img-fluid img-thumbnail');
            }
            else 
            {

            }
            // for changing action_taken
            $.ajax({
                headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: "get",
                dataType:'json',
                url: "/employercontent/change_action",
                data:{
                    id: id,
                },    
                success:function(data)
                {    
                                                                                
                },
                error: function(data){
                }
            });
    
        });  
        $('.financial-tips-btn').click(function(){  
                 var financial_tips = {
                        title : $(this).attr('data-title'),
                        description:  $(this).attr('data-description')
                 }
                 $('#financial-tips-title').html(financial_tips.title);
                 $('#financial-tips-description').html(financial_tips.description); 
                 var check_has = financial_tips.description.includes("img"); 
                 if(check_has){
                     $('#imageviewft img').addClass('img-fluid img-thumbnail');
                 }
                
        });

            $('.carousel').carousel()          

    });