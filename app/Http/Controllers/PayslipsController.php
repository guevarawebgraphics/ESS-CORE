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
            $payslip = DB::Table('payroll_register_details') 
            ->where('account_id','=',auth()->user()->employee_id) 
            ->orderBy('payroll_release_date', 'desc')
            ->get();
           
            if($Request->ajax()){ 
                    return response()->json($payslip,200);
            }
          
        }

    }

    public function viewpayslips($id) 
    {       
                //checks if id on url belongs to the user logged in
                $check = DB::Table('payroll_register_details') 
                            ->where('id','=',$id)
                            ->where('account_id','=',auth()->user()->employee_id)
                            ->get();
                if(count($check)) 
                {
                    //prd as payroll_register_details table
                    //e as employee table
                    //epi as employee_personal_information
                    
                    $viewpayslips = DB::Table('payroll_register_details as prd') 
                    ->Join('employee as e','prd.account_id','=','e.id')
                    ->Join('employee_personal_information as epi','e.employee_info','=','epi.id')
                    ->where('prd.id','=',$id)
                    ->get();
                    return view('employee_modules.payslips.view')
                                ->with('information',$viewpayslips);
                }
               return abort(404);
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

            $payslip = DB::Table('payroll_register_details') 
            ->where('account_id','=',auth()->user()->employee_id) 
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
