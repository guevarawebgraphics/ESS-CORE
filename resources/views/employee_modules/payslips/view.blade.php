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
                <center><strong>Payslips</strong></center>
            </div>
            <div class="card-body"  style="background: #f2f2f2 !important;"> 
                    <div class="container border" style="background: white !important;">
                    
                        <div class="container">
                              
                                <table class="table ">
                                        <tr>
                                          <th>
                                                <ul class="list-unstyled float-left" >
                                                        <li> 
                                                               Employee's Payslip
                                                        </li>
                                                        <li> 
                                                             <h3 style="text-transform: capitalize;color:#3C8DBC;">   {{$information[0]->firstname}} {{$information[0]->middlename}} {{$information[0]->lastname}}</h3>
                                                        </li>
                                                        <li> 
                                                                <p class="text-muted"> Employment Status:  {{$information[0]->employment_status}}  </p>
                                                        </li>
                                                 </ul>
                                          </th>
                                          <th></th>
                                          <td>
                                                <ul class="list-unstyled float-right" >
                                                        <li> 
                                                             <p>  Employee #: </p>
                                                        </li>
                                                        <li> 
                                                             <h3>   {{$information[0]->employee_no}} </h3>
                                                        </li> 
                                                 </ul>
                                              
                                          </td>
                                        </tr>
                                   
                                        
                                        <tr>
                                          <td ><p class="float-left"></p></td>
                                          <td></td>
                                          <td>
                                            <ul class="list-unstyled float-right" >
                                            <li> 
                                                    Release Date:
                                            </li>
                                            <li style="color:#3C8DBC;"> 
                                                 <h5>   {{ \Carbon\Carbon::parse($information[0]->payroll_release_date)->isoFormat('LL')}}</h5>
                                            </li>

                                            </ul>
                                          
                                          </td>
                                        </tr>
                                 </table>
                                      
                                <div class="row">
                                    <div class="col"> 
                                        <div class="container">
                                                <table class="table table-hover border-right border-left table-light no-spacing border-bottom" cellspacing="0">
                                                        <thead>
                                                          <tr>
                                                           <p>Earnings: </p>
                                                          </tr>
                                                        </thead>
                                                        <tbody>
                                                          <tr>
                                                            <th scope="row"><p class="float-left">Basic Pay</p></th>
                                                            <td></td>
                                                            <td></td>
                                                            <td><p class="float-right">{{$information[0]->basic}}</p></td>
                                                          </tr>
                                                          <tr>
                                                            <th scope="row"><p class="float-left">Absent</p></th>
                                                            <td></td>
                                                            <td></td>
                                                            <td><p class="float-right">{{$information[0]->absent}}</p></td>
                                                          </tr>
                                                   
                                                        </tbody>
                                                </table>
                                        </div> 
                                        <div class="container">
                                            <table class="table table-borderless"> 
                                                    <tr> 
                                                        <th><p class="float-left text-muted">Total Earnings:</p></th>
                                                        <th><p class="float-right font-weight-bold"></p></th>
                                                    </tr>
                                                    <tr> 
                                                        <td><p class="float-left font-weight-bold">Total Gross Pay:</p></td>
                                                        <td><p class="float-right font-weight-bold">{{$information[0]->grosspay}}</p></td>
                                                    </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="container ">
                                            <table class="table table-hover border-right border-left table-light no-spacing border-bottom" cellspacing="0">
                                                    <thead>
                                                      <tr>
                                                       <p>Deductions: </p>
                                                      </tr>
                                                    </thead>
                                                    <tbody>
                                                      <tr >
                                                        <th scope="row"><p class="float-left">SSS</p></th>
                                                        <td></td>
                                                        <td></td>
                                                        <td><p class="float-right">{{$information[0]->sss}}</p></td>
                                                      </tr>
                                                      <tr>
                                                        <th scope="row"><p class="float-left">WTax</p></th>
                                                        <td></td>
                                                        <td></td>
                                                        <td><p class="float-right">{{$information[0]->wtax}}</p></td>
                                                      </tr>
                                                      <tr>
                                                            <th scope="row"><p class="float-left">PHIC</p></th>
                                                            <td></td>
                                                            <td></td>
                                                            <td><p class="float-right">{{$information[0]->phic}}</p></td>
                                                          </tr>
                                               
                                                    </tbody>
                                            </table>
                                            <div class="container">
                                                    <div class="row">
                                                      <div class="col-sm">
                                                            <h5 class="float-left">Total Deductions:</h5>
                                                      </div>
                                                      <div class="col-sm">
                                                            <p class="float-right">{{$information[0]->total_deduction}}</p>
                                                      </div>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                              
                                        
                                    </div>  
                              
                                    <div class="container">  
                                        <hr>              
                                    <div class="row"> 
                                            <div class="col">
                                            </div>
                                            <div class="col">
                                                <p class="float-right text-lg"> Net Pay: </p>
                                            </div>
                                            <div class="col">
                                                <p class="float-right text-lg"> {{$information[0]->net_pay}} </p>
                                            </div>
                                    </div>
                                    </div> 
                                    <hr> 
                                  <div class="table-responsive">
                                  <table class="table table-borderless">
                                      <colgroup>
                                        <col span="1" style="background-color:#f2f2f2">
                                      </colgroup>
                                      <tr>
                                        <th colspan="1">Government Numbers: </th>
                                        <th></th>
                                        <th></th>
                                      </tr>
                                      <tr class="border-bottom">
                                        <td><p class="float-center">SSS:</p></td>
                                        <td colspan="2"><input type="text" value="{{$information[0]->SSSGSIS}}" placeholder="" class="border" style="color: #3C8DBC;padding: 4px 4px;" readonly></td>
                                      </tr> 
                                      <tr class="border-bottom">
                                          <td padding="10"><p class="float-center">TIN</p></td>
                                          <td colspan="2"><input type="text" value="{{$information[0]->TIN}}" placeholder="" class="border"  style="color: #3C8DBC;padding: 4px 4px;" readonly></td>
                                      </tr>
                                      <tr>
                                          <td padding="10"><p class="float-center">PHIC</p></td>
                                          <td colspan="2"><input type="text" value="{{$information[0]->PHIC}}" placeholder="" class="border transparent-input"  style="color: #3C8DBC;padding: 4px 4px;" readonly></td>
                                      </tr>
                                  </table>
                                  </div>
                                    
                         </div>
                         <footer class="table-light text-center">  <small class="form-text text-muted">This is system-generated payslip.</small></footer>
                    </div>                                                                   
            </div>              
        </div>      
    </div> 
@endsection 