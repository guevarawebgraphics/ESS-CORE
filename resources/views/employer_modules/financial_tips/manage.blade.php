@extends('layouts.master')

@section('crumb')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="m-0 text-dark">Financial Tips</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
                <a href="#">Financial Tips</a>
            </li>
            <li class="breadcrumb-item active-financialtips text-secondary">Index</li>
        </ol>
    </div>
</div>
@endsection

@section('content')

<div class="container-fluid">
        <div class="card card-custom-blue card-outline">
            <div class="card-header">
                <center><strong>Financial Tips</strong></center>
            </div>
            <div class="card-body"  style="min-height:700px;">
                    <div class="form-group row">
              
                            <div class="col-md-6">
                                    <div class="input-group show">
                                            <div class="input-group-prepend">
                                                <span class="fa fa-search input-group-text" style="background-color: #fff;"></span>
                                              </div>
                                              <input id="searchbox" type="text" class="form-control" name="searchbox" placeholder="Search">
                                    </div>
                            </div>
                            <div class="col-md-6">
                                <a href="#Add" class="btn btn-outline-primary btn-flat float-md-right " id="Add_financialtips" data-toggle="modal" data-target="#ModalFinancialTips"><i class="fa fa-plus-square"></i> Create Financial Tips</a>
                            </div>
                    </div>
                    @include("employer_modules.financial_tips.tablemanage")                                                                   
            </div>              
        </div>      
</div>
<div class="modal fade" id="ModalFinancialTips" tabindex="2" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content card-custom-blue card-outline">
            <div class="modal-header">
                <h5 class="modal-title" id="title_modal"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="content_form">
                {{-- CSRF --}}
                    @csrf
                    <input type="hidden" id="action" value="">
                    <input type="hidden" id="hidden_id" name="hidden_id" value="">
                    <div class="form-group row">
                        <label for="ft_title" class="control-label col-md-4 text-md-center custom-flat-label">Financial Tips Title:</label>     
                            <div class="col-md-6">    
                                <input id="financial_tips_title" type="text" class="form-control custom-flat-input-modal" name="financialtips_title" placeholder="Financial Tips Title" autofocus>
                                <p class="text-danger" id="error_financialtips_title"></p>
                            </div>        
                    </div>
                    <div class="form-group row">
                        <label for="ft_description" class="control-label col-md-4 text-md-center custom-flat-label">Financial Tips Description:</label>
                            <div class="col-md-12">
                                    <textarea type="text" id="financialtips_description" class="form-control custom-flat-input-modal" name="financialtips_description" placeholder="Financial Tips Description" autofocus></textarea>
                                    <p class="text-danger" id="error_financialtips_description"></p>
                                    <input type="hidden" id="action_to_do" value="">
                            </div>  
                    </div>
                </form>
            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary btn-flat" data-dismiss="modal">Close</button>  
                <button type="button" class="btn btn-outline-primary btn-flat SaveFinancialTips" data-edit-value=""></button> 
            </div>    
        </div>
    </div>
</div>

    <script>
            $(document).ready(function(){
          
                //function for refreshing table
                refreshTable();
                function refreshTable()
                {
                    $.ajax({
                        headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        url: "{{ route('refreshfinancialtips') }}",
                        method: "GET",
                        data:{},             
                        success:function(data)
                        {   
                            $('#FinancialTipsTable').html(data);                    
                            var table = $("#FinancialTipsTable").DataTable({
                                "sDom": '<"customcontent">rt<"row"<"col-6" i><"col-6" p>><"clear">',
                                "paging": true,
                                "pageLength": 10,
                                "ordering":false,
                                scrollY: 600,
                                //  scrollX: true,
                                "autoWidth": true,
                                lengthChange: false,
                                responsive: true,
                                destroy: true,
                            }); 
                            $("#searchbox").on("keyup search input paste cut", function () {
                                table.search(this.value).draw();
                            });               
                        }
                    }); 
                       
                }
                


            
                $(document).on('click','.financial-tips-post',function(){  
                        toastr.remove();
                        post_id = $(this).data("add"); 
                        console.log(post_id);
                        swal({
                        title: "Post this Financial Tips?",
                        type: "warning",             
                        confirmButtonClass: "btn-info",
                        confirmButtonText: "Yes",
                        showCancelButton: true,
                        closeOnConfirm: true,
                        },
                        function()
                        {                   
                            $.ajax({
                                headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                url: "{{ route('postfinancialtips') }}",
                                method: "POST",
                                data:{id: post_id},            
                                success:function(data)
                                {    
                                   refreshTable();                                    
                                    toastr.success('Financial Tips Posted Successfully', 'Success')                                                                  
                                }
                            });
                        }
                        );    

                });
                $(document).on('click','.financial-tips-delete',function(){
                        toastr.remove();
                        delete_id = $(this).data("add"); 
                        console.log(delete_id);
                        swal({
                        title: "Delete this Financial Tips?",
                        type: "error",             
                        confirmButtonClass: "btn-info",
                        confirmButtonText: "Yes",
                        showCancelButton: true,
                        closeOnConfirm: true,
                        },
                        function()
                        {                   
                            $.ajax({
                                headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                url: "{{ route('deletefinancialtips') }}",
                                method: "POST",
                                data:{id: delete_id},            
                                success:function(data)
                                {    
                                    refreshTable();                                 
                                    toastr.success(''+data, 'Success')                                                                      
                                }
                            });
                        }
                        );    

                }); 
                            
                            var editortwo = CKEDITOR.replace('financialtips_description');
                            CKFinder.setupCKEditor( editortwo );
                            $(document).on('click','.SaveFinancialTips',function(){
                            $('.SaveFinancialTips').attr('disabled',true);
                            $('#spinner-financial').addClass('fa fa-refresh fa-spin');
                            toastr.remove();
                            const financial_tips  = {
                                        title: $('#financial_tips_title').val(),
                                        description:  CKEDITOR.instances.financialtips_description.getData()  
                            }
                            if(financial_tips.title=="")
                            {
                                $('#error_financialtips_title').html("Financial Tips Title is Required"); 
                                $('.SaveFinancialTips').removeAttr('disabled');
                                spinnerTimeoutFinancial()
                            }
                            if(financial_tips.description=="")
                            {   
                                $('#error_financialtips_description').html("Financial Tips Description is Required");
                                $('.SaveFinancialTips').removeAttr('disabled');
                                spinnerTimeoutFinancial()
                            }
                            if(financial_tips.title=="" || financial_tips.description == "")
                            {
                                toastr.error('Error. Please Complete the fields', 'Error!') 
                                $('.SaveFinancialTips').removeAttr('disabled'); 
                                spinnerTimeoutFinancial()
                            }
                            else 
                            {   
                               
                                SaveFinancialTips();
                            }
                        
            
                        });

                        function SaveFinancialTips()
                        {
                            var action_to_do = $('#action_to_do').val();
                            const financial_tips  = {
                                        id : $('.SaveFinancialTips').attr("data-edit-value"), 
                                        title: $('#financial_tips_title').val(),
                                        description:  CKEDITOR.instances.financialtips_description.getData()  
                            }
                            if(action_to_do==="add")
                            {
                                $.ajax({
                                    headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                    url: "{{ route('createfinancialtips') }}",
                                    method: "POST",
                                    data: {
                                    _token:'{{ csrf_token() }}',
                                    title: financial_tips.title,
                                    description: financial_tips.description,
                                    },           
                                    success:function(data)
                                    {                          
                                        refreshTable(); 
                                        toastr.success('Financial Tips Created Successfully', 'Success') 
                                        setTimeout(function (){
                                            $('#ModalFinancialTips').modal('hide')
                                        }, 1000);   
                                        spinnerTimeoutFinancial()
                                    } 
                                });
                            }
                            else 
                            {
                                $.ajax({
                                    headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                    url: "{{ route('editfinancialtips') }}",
                                    method: "POST",
                                    data: {
                                    _token:'{{ csrf_token() }}',
                                    id: financial_tips.id,
                                    title: financial_tips.title,
                                    description: financial_tips.description,
                                    },           
                                    success:function(data)
                                    {                          
                                        refreshTable(); 
                                        toastr.success('Financial Tips Created Successfully', 'Success') 
                                        setTimeout(function (){
                                            $('#ModalFinancialTips').modal('hide')
                                        }, 1000);
                                        spinnerTimeoutFinancial()
                                     
                                 
                                    } 
                                });

                            }
                        
                        }
                        $(document).on('click','#Add_financialtips',function(){
                            $("#financial_tips_title").val("");
                            CKEDITOR.instances.financialtips_description.setData("");  
                            $('#error_financialtips_title').html("");
                            $('#error_financialtips_description').html("");
                            $('#action_to_do').val("add");
                            $('.SaveFinancialTips').removeAttr('disabled');
                            $('.SaveFinancialTips').html("Save Financial Tips" +" <i id='spinner-financial' class=''> </i>"); 
                            $('#title_modal').html("Create Financial Tips"); 
                        
                        });
                        $(document).on('click','.financial-tips-edit',function(){
                            $('#error_financialtips_title').html("");
                            $('#error_financialtips_description').html("");
                            $('#action_to_do').val("edit");
                            $('.SaveFinancialTips').removeAttr('disabled');
                            $('.SaveFinancialTips').attr('data-edit-value',$(this).data('add'));
                            $('.SaveFinancialTips').html("Update Financial Tips" +" <i id='spinner-financial' class=''></i>");
                            $('#title_modal').html("Edit Financial Tips");
                            var financial_tips = {
                                title : $(this).attr('data-title'),
                                description: $(this).attr('data-description'),
                            }
                            $('#financial_tips_title').val(financial_tips.title);
                            CKEDITOR.instances.financialtips_description.setData(financial_tips.description);    
                        });
                        function spinnerTimeoutFinancial(){
                        setTimeout(function (){
                                    $("#spinner-financial").removeClass('fa fa-refresh fa-spin');
                        }, 250);
                    }
            });
        </script>    

@endsection