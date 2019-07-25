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
              $payslip = DB::Table('employee as e')
                            ->Join('users as u','u.employee_id','=','e.id')
                            ->Join('payroll_register_details as prd','prd.account_id','=','e.employee_no')
                            ->join('payrollregister as pr','pr.id','=','prd.PayRegisterId')
                            ->where('u.employee_id','=',auth()->user()->employee_id)
                            ->where('pr.account_status','=',1)
                            ->select('prd.account_id','prd.id')
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
    
                    //prd as payroll_register_details table
                    //e as employee table
                    //epi as employee_personal_information
                 /*
                    $employee_no = $get_employee_no->account_id;
                    $check = DB::Table('employee')
                                ->where('id','=',auth()->user()->employee_id)
                                ->where('employee_no','=',$employee_no)
                                ->get();
                    if($check)
                    {
                */                              
        if(auth()->user()->user_type_id !== 4)
        {
            return abort(404);
        }
        if(!payrollregisterdetails::where('id', '=', $id)->count() > 0){
            abort(404);
        }    
        //gets status of the payslip
        $status = DB::table('payroll_register_details as prd')
                    ->join('payrollregister as pr','prd.PayRegisterId','=','pr.id')
                    ->where('prd.id','=',$id)
                    ->first();
                    $status_value = $status->account_status;
        if($status_value===0)
        {
            return abort(404);
        }
                        //gets the employee number
                        $get_employee_no = DB::Table('payroll_register_details')
                        ->where('id','=',$id)
                        ->first();
                        $employee_no = $get_employee_no->account_id;
                        //checks if employee belongs to user logged in
                        $check = DB::Table('employee')
                                    ->where('id','=',auth()->user()->employee_id)
                                    ->where('employee_no','=',$employee_no)
                                    ->get();
                        if(count($check))
                        {
                            $viewpayslips = DB::Table('payroll_register_details as prd') 
                            ->Join('employee as e','prd.account_id','=','e.employee_no')
                            ->Join('employee_personal_information as epi','e.employee_info','=','epi.id')
                            ->join('payrollregister as pr','pr.id','=','prd.PayRegisterId')
                            ->where('prd.id','=',$id)
                            ->get();
             
    
                                return view('employee_modules.payslips.view')
                                ->with('information',$viewpayslips);
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

            $payslip = DB::Table('employee as e')
            ->Join('users as u','u.employee_id','=','e.id')
            ->Join('payroll_register_details as prd','prd.account_id','=','e.employee_no')
            ->join('payrollregister as pr','prd.PayRegisterId','=','pr.id')
            ->where('pr.account_status','=',1)
            ->where('u.employee_id','=',auth()->user()->employee_id)
            ->whereMonth('payroll_release_date', '=', $month)
            ->whereYear('payroll_release_date', '=', $Request->year) 
            ->orderBy('payroll_release_date', 'desc')
            ->get();
           
            if($Request->ajax()){ 
                    return response()->json($payslip,200);
            }
          
        }
    } 

}
