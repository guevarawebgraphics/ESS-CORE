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
            <li class="breadcrumb-item active">Index</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="card"> 
            
        <div class="card-header">
        
                        <div class="container">
                                <div class="row">
                                    <div class="col"> 
                                                <div class="form-group row">
                                                    <label for="staticEmail" class="col-sm-2 col-form-label">Month</label>
                                                    <div class="col-sm-10">
                                                                    <select class="custom-select" name="months" id="Months">
                                                                    
                                                                    </select>
                                                    </div>
                                                </div>
                                    </div>
                                    <div class="col">
                                                <div class="form-group row">
                                                    <label for="staticEmail" class="col-sm-2 col-form-label">Year:</label>
                                                    <div class="col-sm-10">
                                                                    <select class="custom-select" name="years" id="Years">
                                                                   
                                                                    </select>
                                                    </div>
                                                </div>
                                    </div> 
                                    <div class="col">   
                                        
                                            <button type="button" class="btn btn-info" id="generate">Generate</button> 
                                    </div>
                                </div>
                        </div> 
                    <hr>
                    <center><strong>Payslips List</strong></center>  

        </div>
        <div class="card-body"> 
            <div class="container">
                <table class="table table-light" id="payslip_table">
                <thead>
                    <tr>
                        <th>Date Released</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="showpayslips">
                    
                    {{--@forelse($payslip as $payslips)
                    <tr>
                        <td> {{ \Carbon\Carbon::parse($payslips->payroll_release_date)->isoFormat('LL')}}  </td>
                        <td> <a href="/payslips/view/{{$payslips->id}} ">View </a>   </td>
                    </tr>
                    @empty 
                    <tr>
                       <td colspan="2">  No payslip available </td> 
                    </tr>
                    @endforelse--}}   
                
                </tbody>
                </table> 
                <footer class="table-light text-center">  This payslip is system-generated</footer>
            </div>                                                                 
        </div>              
    </div>      
</div> 
<script type="text/javascript">
    $(document).ready(function () {
         initDataTable();
         function initDataTable(){
            /*DataTable*/ 
            var table = $("#payslip_table").DataTable({
                // "searching": false,
                "sDom": '<"customcontent">rt<"row"<"col-lg-6" i><"col-lg-6" p>><"clear">',
                "paging": true,
                "pageLength": 10000,
                scrollY: 400,
                //  scrollX: true,
                "autoWidth": true,
                lengthChange: false,
                responsive: true,
                fixedColumns: true,
                "ordering": false,
            }); 
            /*Custom Search For DataTable*/
            $("#searchbox").on("keyup search input paste cut", function () {
                    table.search(this.value).draw();
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
                    for(i=0; i<data.length; i++){
                        html +='<tr>'+
                                    '<td>'+moment(data[i].payroll_release_date).format('MMMM DD, YYYY')+'</td>'+
                                     '<td><a class="btn btn-sm label label-info" href="/payslips/view/'+data[i].id+'"> View </a></td>'+  
                                '</tr>'; 
                    }   
                        if(i===0)
                        {

                            $('#showpayslips').html(" <tr> <td colspan='2'>No Avaible Payslips </td> </tr>");
                            return false
                        }        
                        $('#showpayslips').html(html);

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
                    $('#Months').html(list);
        }
        listYears()
        function listYears()
        {
            years = [];
            var currentYear = new Date().getFullYear();
            var YearBegin =  1990; 
            var i;
            var list= '';
            while ( YearBegin <= currentYear ) {
                years.push(YearBegin++); 
            }   
            for(i=0;i<years.length;i++)
            {
                list+= '<option value="'+years[i]+'">'+years[i]+'</option>';
            }
            $('#Years').html(list);
        }
  
    }); 
    $(document).ready(function(){
        $( "#generate" ).on( "click", function(e){
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
                  success: function(data){
   
                           var html='';
                            var i;
                            for(i=0;i<data.length;i++)
                            {
                                html +='<tr>'+
                                    '<td>'+moment(data[i].payroll_release_date).format('MMMM DD, YYYY')+'</td>'+
                                     '<td><a class="btn btn-sm label label-info" href="/payslips/view/'+data[i].id+'"> View </a></td>'+  
                                '</tr>'; 
                                     

                            }
                            $('#showpayslips').html(html); 
                            if(i===0)
                            {

                                $('#showpayslips').html(" <tr> <td colspan='2'>No Avaible Payslips </td> </tr>");
                                return false
                            }        
                            $('#showpayslips').html(html);
                 
                  },
              
                  }); 
                  
               }); 
    });
    
</script>
@endsection