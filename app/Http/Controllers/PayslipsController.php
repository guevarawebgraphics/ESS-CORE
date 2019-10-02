<?php

namespace App\Http\Controllers;

/**
 *  Packages Facades
 * */
use Illuminate\Http\Request;

use Session;
use DB;
use Response;

/**
 *  Insert Packages Here
 *  */
use Carbon\carbon;

/**
 *  Insert Models Here
 * */
use App\User;
use App\payrollregisterdetails;


class PayslipsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('revalidate'); // Revalidate back history Security For Back Button      
        $this->middleware(function($request, $next){
            if(Session::get("payslips") == "none")
            {
                return redirect('error')->send();
            }
            else
            {
                return $next($request);
            }
        });     
    }
    //show index 
    public function index()
    {        
        return view('employee_modules.payslips.index');  
 
    } 
    
    //Request payslip table
    public function getPayslipsList(request $Request) 
    {
        if(auth()->user()->user_type_id===4)
        {
          /*  $payslip = DB::Table('payroll_register_details') 
            ->where('account_id','=',auth()->user()->employee_id) 
            ->orderBy('payroll_release_date', 'desc')
            ->get();*/
             /* $payslip = DB::Table('employee as e')
                            ->Join('users as u','u.employee_id','=','e.id')
                            ->Join('payroll_register_details as prd','prd.employee_no','=','e.employee_no') 
                            ->join('payrollregister as pr','pr.id','=','prd.PayRegisterId')
                            ->join('employer as er','er.id','=','pr.employer_id')
                            ->where('u.employee_id','=',auth()->user()->employee_id)
                            ->where('pr.employer_id','=',auth()->user()->employer_id)
                            ->where('pr.account_status','=',1)
                            ->latest('prd.created_at')
                            ->select('prd.employee_no','prd.id','prd.payroll_release_date','er.business_name','pr.period_from','pr.period_to','prd.net_pay')
                            ->get();*/ 
                            // $payslip = DB::Table('employer_and_employee as ee')
                            // ->Join('employee as e','e.id','=','ee.employee_id')
                            // ->Join('employer as er','ee.employer_id','=','er.id')
                            // ->Join('payroll_register_details as prd','prd.employee_no','=','e.employee_no')
                            // ->Join('payrollregister as pr','prd.PayRegisterId','=','pr.id')
                            // ->where('ee.ess_id','=',auth()->user()->username) 
                            // ->where('pr.account_status','=',1)  
                            // ->latest('prd.created_at')
                            // ->select('prd.employee_no','prd.id','prd.payroll_release_date','er.business_name','pr.period_from','pr.period_to','prd.net_pay')
                            // ->get();
                            $payslip = DB::table('payroll_register_details')
                                        ->Join('payrollregister','payroll_register_details.PayRegisterId','=','payrollregister.id')
                                        ->Join('employer','payrollregister.employer_id','=','employer.id')
                                        ->where('ess_id', '=', auth()->user()->username)
                                        ->where('payrollregister.account_status','=',1)  
                                        ->latest('payroll_register_details.created_at')
                                        ->select('payroll_register_details.employee_no',
                                        'payroll_register_details.id',
                                        'payroll_register_details.payroll_release_date',
                                        'employer.business_name',
                                        'payrollregister.period_from',
                                        'payrollregister.period_to',
                                        'payroll_register_details.net_pay')
                                        ->get();
            if($Request->ajax()){ 
                    return response()->json($payslip,200);
            }
          
        }
        else 
        {
            return abort(404);
        }   

    }

    public function viewpayslips($id) 
    {       
                            
        if(auth()->user()->user_type_id !== 4)
        {
            return abort(404);
        }
        if(!payrollregisterdetails::where('id', '=', $id)->count() > 0){
            abort(404);
        }    
        //gets status of the payslip
       /* $status = DB::table('payroll_register_details as prd')
                    ->join('payrollregister as pr','prd.PayRegisterId','=','pr.id')
                    ->where('prd.id','=',$id)
                    ->first();
                    $status_value = $status->account_status;
        if($status_value===0)
        {
            return abort(404);
        }*/
                        //gets the employee number
                        $get_employee_no = DB::Table('payroll_register_details')
                        ->where('id','=',$id)
                        ->first();
                        $employee_no = $get_employee_no->employee_no;
                        //checks if employee belongs to user logged in
                      /*  $check = DB::Table('employee') 
                                    ->where('id','=',auth()->user()->employee_id)
                                    ->where('employee_no','=',$employee_no)
                                    ->get();*/
                       /*  $check = DB::Table('payroll_register_details as prd')
                                        ->Join('employee as e','e.employee_no','=','prd.employee_no')
                                        ->Join('payrollregister as pr','prd.PayRegisterId','=','pr.id')
                                        ->where('prd.id','=',$id)
                                        ->where('pr.employer_id','=',auth()->user()->employer_id)
                                        ->where('e.id','=',auth()->user()->employee_id)
                                        ->get();*/ 
                        
                        $check = DB::table('employer_and_employee')
                                        ->where('employer_and_employee.employee_no','=',$employee_no)
                                        ->where('employer_and_employee.ess_id','=',auth()->user()->username)
                                        ->get();    
                        if(count($check))
                            {
                            $viewpayslips = DB::Table('payroll_register_details as prd') 
                            ->Join('employee as e','prd.employee_no','=','e.employee_no')
                            ->Join('employee_personal_information as epi','e.employee_info','=','epi.id')
                            ->join('payrollregister as pr','pr.id','=','prd.PayRegisterId')
                            ->Join('employer as emr','emr.id','=','pr.employer_id')
                            ->where('prd.id','=',$id)
                            ->select('epi.firstname',
                                    'epi.middlename',
                                    'epi.lastname',
                                    'e.employment_status',
                                    'e.department',
                                    'e.position',
                                    'e.employee_no',
                                    'emr.accountname',
                                    'prd.sss',
                                    'prd.hdmf',
                                    'prd.phic',
                                    'prd.wtax',
                                    'pr.period_from',
                                    'pr.period_to',
                                    'prd.payroll_release_date',
                                    'prd.basic',
                                    'prd.regular_ot',
                                    'prd.meal_allowance',
                                    'prd.grosspay',
                                    'prd.sss',
                                    'prd.hdmf',
                                    'prd.phic',
                                    'prd.wtax',
                                    'prd.total_deduction',
                                    'prd.net_pay',
                                    'epi.SSSGSIS',
                                    'epi.TIN',
                                    'epi.PHIC'
                                    )
                            ->get();
             
    
                             return view('employee_modules.payslips.view')
                                ->with('information',$viewpayslips);
                            //   return $viewpayslips;
                       }
                        else 
                        {
                            return abort(404);
                        }
                    
                                               
    }
    public function filter(Request $Request) //for generating table
    {
        if(auth()->user()->user_type_id===4)
        {   
            //sets the value of a month to 1-12 value

            if($Request->month=="January")
            {
                $month=1;
            }
            else if($Request->month=="February")
            {
                $month=2;
            }
            else if($Request->month=="March")
            {
                $month=3;
            }
            else if($Request->month=="April")
            {
                $month=4;
            }
            else if($Request->month=="May")
            {
                $month=5;
            }
            else if($Request->month=="June")
            {
                $month=6;
            }
            else if($Request->month=="July")
            {
                $month=7;
            }
            else if($Request->month=="August")
            {
                $month=8;
            }
            else if($Request->month=="September")
            {
                $month=9;
            }
            else if($Request->month=="October")
            {
                $month=10;
            }
            else if($Request->month=="November")
            {
                $month=11;
            }
            else if($Request->month=="December")
            {
                $month=12;
            }

           /* $payslip = DB::Table('employee as e')
            ->Join('users as u','u.employee_id','=','e.id')
            ->Join('payroll_register_details as prd','prd.employee_no','=','e.employee_no')
            ->join('payrollregister as pr','prd.PayRegisterId','=','pr.id') 
            ->join('employer as er','er.id','=','pr.employer_id')
            ->where('pr.account_status','=',1)
            ->where('u.employee_id','=',auth()->user()->employee_id)
            ->whereMonth('prd.payroll_release_date', '=', $month)
            ->whereYear('prd.payroll_release_date', '=', $Request->year) 
            ->orderBy('prd.payroll_release_date', 'desc')
            ->select('prd.employee_no','prd.id','prd.payroll_release_date','er.business_name','pr.period_from','pr.period_to','prd.net_pay')
            ->get(); */
            $payslip = DB::Table('employer_and_employee as ee')
            ->Join('employee as e','e.id','=','ee.employee_id')
            ->Join('employer as er','ee.employer_id','=','er.id')
            ->Join('payroll_register_details as prd','prd.employee_no','=','e.employee_no')
            ->Join('payrollregister as pr','prd.PayRegisterId','=','pr.id')
            ->where('ee.ess_id','=',auth()->user()->username)  
            ->where('pr.account_status','=',1)  
            ->whereMonth('prd.payroll_release_date', '=', $month)
            ->whereYear('prd.payroll_release_date', '=', $Request->year) 
            ->latest('prd.created_at')
            ->select('prd.employee_no','prd.id','prd.payroll_release_date','er.business_name','pr.period_from','pr.period_to','prd.net_pay')
            ->get();
           
            if($Request->ajax()){ 
                    return response()->json($payslip,200);
            }
          
        }
    } 

}
