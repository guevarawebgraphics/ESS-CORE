<?php

namespace App\Http\Controllers;

/**
 *  Packages Facades
 * */
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Execel\Facades\Execel;

/**
 * Maat Excel Package 3.1
 * */
use Maatwebsite\Excel\Facades\Excel;

use DB;
use Mail;
use Response;
use Session;

/**
 *  Insert Packages Here
 *  */
use Carbon\Carbon;

/**
 *  Insert Models Here
 * */
use App\payrollregister;
use App\payrollregisterdetails;

/**
 * @ Excel Imports
 * */
use App\Imports\PayrollImport;


/**
 * @ Use App Imports
 * */


class PayrollManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');      
        $this->middleware('revalidate'); // Revalidate back history Security For Back Button
        $this->middleware(function($request, $next){
            if(Session::get("payroll_management") == "none")
            {
                return redirect('error')->send();
            }
            else
            {
                return $next($request);
            }
        });     
    }
    //show upload register
    public function upload()
    {          
        return view('employer_modules.payroll_management.upload');
    }
    //show view register
    public function view()
    {          
        $Employees_upload_template = DB::table('template')
                                        ->where('id', '=', 26)
                                        ->select(
                                            'document_code',
                                            'document_file')
                                        ->get();
        
        return view('employer_modules.payroll_management.view', compact('Employees_upload_template'));
    }

    public function get_payroll_register(Request $request)
    {
        $payrollregister = DB::table('payrollregister')
                        ->where('account_id', '=', auth()->user()->employer_id)
                        ->select('id',
                                 'account_id',
                                 'period_from',
                                 'period_to',
                                 'payroll_schedule_id',
                                 'batch_no',
                                 'payroll_file',
                                 'account_status',
                                 'account_status_date_time',
                                 'created_by',
                                 'created_at',
                                 'updated_by',
                                 'updated_at')
                                 ->get();
        return Response::json($payrollregister);
    }

    /**
     * Upload Pay Register
     * */
    public function upload_payregister(Request $request){
        /**
         * 
         * Validate Requests
         */

        
        $validator = $this->validate($request, [
            'file' => 'required|mimes:xls,xlsx',
            'batch_no' => 'required',
            'payroll_schedule' => 'required',
            'period_from' => 'required',
            'period_to' => 'required'
        ]);
        
    
        $path = $request->file('file')->getRealPath();

        // Handle File Upload
        if($request->hasFile('file') && $request->hasFile('file')){
            // Get filename with the extension
            $filenameWithExt_file = $request->file('file')->getClientOriginalName();
            // Get just filename
            $filename_file = pathinfo($filenameWithExt_file, PATHINFO_FILENAME);
            // Get just ext
            $extension_file = $request->file('file')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore_file = $request->input('file').'_'.time().'_'.'file'.'.'.$extension_file;
            // Upload Image
            $extension_file = $request->file('file')->storeAs('public/Employees/', $fileNameToStore_file);
        } 

        /**
         * @ Create payrollregisterdetails 
         * */
        $period_from = Carbon::parse($request->period_from)->format('Y-m-d'); 
        $period_to = Carbon::parse($request->period_to)->format('Y-m-d');
        $payrollregister = payrollregister::create([
            'account_id' => auth()->user()->employer_id,
            'period_from' => $period_from,
            'period_to' => $period_to,
            'payroll_schedule_id' => $request->payroll_schedule,
            'batch_no' => $request->input('batch_no'),
            'payroll_file' => $fileNameToStore_file,
            'account_status' => '0',
            'account_status_date_time' => Carbon::now(),
            'created_by' => auth()->user()->employer_id,
            'created_at' => Carbon::now(),
            'updated_by' => auth()->user()->employer_id,
            'updated_at' => Carbon::now()
        ]);

        /**
         * @ Get PayrollRegister Id 
         **/
        $payregisterid = $payrollregister->id; 

        $import = Excel::import(new PayrollImport($payregisterid), $path);

        return Response::json();
    }

    /**
     * Post Payroll 
     * 
     * 
     *  Side Note if the account_status is 0 = pending 
     *  and if 1 = Posted
     * */
    public function post_payroll_register(Request $request){
        /**
         * @ Validate Request
         **/
        $this->validate($request, [
            'id' => 'required'
        ]);

        $check_payroll_status = DB::table('payrollregister')
                        ->where('id', '=', $request->input('id'))
                        ->select('account_status')
                        ->first();
        /**
         * @ Check if the Payrollregister is already Posted
         * */
        if($check_payroll_status->account_status == 0)
        {
        /**
         * @ Send Email Payslip Notification Configuration
         * */
        $get_employees_email = DB::table('payroll_register_details')
                                    ->join('employee', 'payroll_register_details.account_id', '=', 'employee_no')
                                    ->join('employee_personal_information', 'employee.employee_info', '=', 'employee_personal_information.id')
                                    ->join('payrollregister', 'payroll_register_details.PayRegisterId', '=', 'payrollregister.id')
                                    ->where('payroll_register_details.PayRegisterId', '=', $request->input('id'))
                                    ->select('employee_personal_information.email_add',
                                            'employee_personal_information.lastname',
                                            'employee_personal_information.firstname',
                                            'payrollregister.period_from',
                                            'payrollregister.period_to')
                                    ->get();

        /*Email Template*/
        $mail_template = DB::table('notification')
                ->where('id', '39')
                ->where('notification_type', 1)
                ->select('notification_message')
                ->first();

        $ess_link = "http://127.0.0.1:8000/payslips";



        /**
         * Loop through $get_employees_email
         * */
        foreach($get_employees_email as $key)
        {
            // // Replace All The String in the Notification Message
            $search = ["name",
                       "Datefrom",
                       "Dateto",
                       "url"];
            $replace = [$key->lastname . $key->firstname,
                         Carbon::parse($key->period_from)->format('m-d-Y'),
                         Carbon::parse($key->period_to)->format('m-d-Y'),
                         "<a href=".$ess_link.">Click Here</a>"];                
            $template_result = str_replace($search, $replace, $mail_template->notification_message); 
                            

            // /*Send Mail */
            $data = array('username' => 'test', "template" => $template_result);

            Mail::send('Email.mail', $data, function($message) use($get_employees_email, $mail_template, $key){
                $message->to($key->email_add)
                        ->subject("ESS Payslip ");
                $message->from('esssample@gmail.com', "ESS");
            });
        }

        

        /**
         *  Update Query
         * */
        DB::table('payrollregister')->where('id', '=', $request->input('id'))
                                ->update(array(
                                    'account_status' => '1',
                                ));
        }
        else{
            return response()->json([
                'error' => 500,
                'message' => 'Already Posted'
            ]);
        }
     }

}
