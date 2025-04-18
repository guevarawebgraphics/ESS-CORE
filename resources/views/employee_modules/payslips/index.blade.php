@extends('layouts.master')

@section('crumb')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="m-0 text-dark">Payslips</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
                    <a href="{{Route('payslips')}}">Payslips</a>
            </li>
            <li class="breadcrumb-item active-payslip text-secondary">Index</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="card card-custom-blue card-outline"> 
            
        <div class="card-header">
        
                        <div class="container">
                                <div class="row">
                                    <div class="col"> 
                                                <div class="form-group row">
                                                    <label for="staticEmail" class="col-sm-4 col-form-label"><p class="float-right"> Month:</p></label>
                                                    <div class="col-sm-8">
                                                                    <select class="custom-select" name="months" id="Months">
                                                            
                                                                    </select> 
                                                                    <p class="text-danger" id="error_month" hidden>Choose Month</p>
                                                    </div>
                                                </div>
                                    </div>
                                    <div class="col">
                                                <div class="form-group row">
                                                    <label for="staticEmail" class="col-sm-4 col-form-label float-right"><p class="float-right"> Year:</p></label>
                                                    <div class="col-sm-8">
                                                                    <select class="custom-select" name="years" id="Years">
                                                                   
                                                                    </select> 
                                                                    <p class="text-danger" id="error_year" hidden>Choose Year</p>
                                                    </div>
                                                </div>
                                    </div> 
                                    <div class="col">   
                                            <div class="form-group row"> 
                                                    <div class="col-sm-12">
                                            <button type="button" class="btn btn-outline-info" id="generate">Generate</button>  
                                                    </div>
                                            </div>
                                    </div>
                                </div>
                        </div> 
               
                    <center><strong>Payslips List</strong></center>  

        </div>
        <div class="card-body"> 
            <div class="container">
                <table class="table table-light" id="payslip_table">
                <thead>
                    <tr> 
                        <th>Employer Name</th>
                        <th>Date Released</th> 
                        <th>Period Covered</th> 
                        <th>Net Pay</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="showpayslips">

                
                </tbody>
                </table> 
                <footer class="table-light text-center">  This payslip is system-generated</footer>
            </div>                                                                 
        </div>              
    </div>      
</div> 
<script type="text/javascript">
    $(document).ready(function () { 
   
         function initDataTable(){
            /*DataTable*/ 
            var table = $("#payslip_table").DataTable({
                // "searching": false,
                "sDom": '<"customcontent">rt<"row"<"col-lg-6" i><"col-lg-6" p>><"clear">',
                "paging": true,
                "pageLength": 10,
                scrollY: 600,
                //  scrollX: true,
                "autoWidth": true,
                lengthChange: false,
                responsive: true,
                fixedColumns: true,
                "ordering": false, 
            }); 
       
 
       } 

       showPayslips()
       function showPayslips(){
        $.ajax({
            type: 'GET',
            url: '/payslips/get',
            async: false,
            dataType: 'json',
            success: function(data){
                var html = '';
                var i; 
                console.log(data);
                    for(i=0; i<data.length; i++){ 

                        html +='<tr>'+ 
                                    '<td>'+data[i].business_name+' </td>'+
                                    '<td>'+moment(data[i].payroll_release_date).format('MMMM DD, YYYY')+'</td>'+ 
                                    '<td> '+moment(data[i].period_from).format('MMMM DD')+'-'+moment(data[i].period_to).format('MMMM DD')+'</td>'+ 
                                    '<td> '+data[i].net_pay+'</td>'+
                                    '<td><a class="btn btn-sm btn-outline-secondary btn-flat" href="/payslips/view/'+data[i].id+'/'+data[i].employee_id+'"> View </a></td>'+  
                                '</tr>';  
                           
                    }   
                        if(i===0)
                        {

                            $('#showpayslips').html(" <tr> <td colspan='5'>No Available Payslips </td> </tr>");
                            return false
                        }        
                        $('#showpayslips').html(html); 
                        initDataTable();

            },
            error: function(){
                    console.log('Could not get data from database');
            }
        });
    }   
        showMonth()  
        function showMonth() 
        {
            var month = moment.months();
            var i;
            var list ='';
                for(i=0;i<month.length;i++) 
                    {
                        list+= '<option value="'+month[i]+'">'+month[i]+'</option>';
                    }
                    $('#Months').html('<option selected value=""> Month</option>'+list);
        }
        listYears() 
        function listYears()
        {
            years = [];
            var currentYear = new Date().getFullYear();
            var YearEnds =  1990; 
            var i;
            var list= '';
            while ( currentYear >= YearEnds ) {
                years.push(currentYear--); 
            }   
           for(i=0;i<years.length;i++)
            {
                list+= '<option value="'+years[i]+'">'+years[i]+'</option>';
            }
            
           $('#Years').html('<option selected value=""> Year </option>'+list);
        }
  
    }); 
    $(document).ready(function(){
        $("#generate" ).on( "click", function(e){ 
              var filterval = {
                  month :$('#Months').val(),
                  year : $('#Years').val()
              } 
             
              if(filterval.month === "") {
                  $('#error_month').removeAttr('hidden') 
              }
              if(filterval.year === ""){
                  $('#error_year').removeAttr('hidden')
              }
              if(filterval.month != "") {
                  $('#error_month').attr("hidden",true);
              }
              if(filterval.year != "") {
                  $('#error_year').attr("hidden",true);
              }  
              
              if( filterval.month ==="" || filterval.year === ""){ 
                  $('#showpayslips').html(" <tr> <td colspan='5'>No Available Payslips </td> </tr>");
                  return false;
              }
          
               $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
                });
               $.ajax({
                  url: "/payslips/filter",
                  method: 'post',
                  data: {
                     month: $('#Months').val(),
                     year: $('#Years').val()
                  },
                  beforeSend:function(data){
                    $('#showpayslips').html("<tr> <td colspan='5'>Loading... </td> </tr>"); 
                    
                  },
                  success: function(data){
                  
                           var html='';
                            var i;
                            for(i=0;i<data.length;i++)
                            {
                                html +='<tr>'+ 
                                    '<td>'+data[i].business_name+' </td>'+
                                    '<td>'+moment(data[i].payroll_release_date).format('MMMM DD, YYYY')+'</td>'+ 
                                    '<td> '+moment(data[i].period_from).format('MMMM DD')+'-'+moment(data[i].period_to).format('MMMM DD')+'</td>'+ 
                                    '<td> '+data[i].net_pay+'</td>'+
                                    '<td><a class="btn btn-sm btn-outline-secondary btn-flat" href="/payslips/view/'+data[i].id+'/'+data[i].employee_id+'"> View </a></td>'+  
                                '</tr>';  
                                     

                            }
                            $('#showpayslips').html(html);  
                            
                            if(i===0)
                            {

                                $('#showpayslips').html(" <tr> <td colspan='5'>No Available Payslips </td> </tr>");
                                return false
                            }        
                            $('#showpayslips').html(html);
                            $('#error_year').attr("hidden",true);
                            $('#error_month').attr("hidden",true);
                 
                  },
              
                  }); 
                  
               }); 
    });
    
</script>
@endsection