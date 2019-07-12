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
        $this->validate($request, [
            'file' => 'required|mimes:xls,xlsx',
            'batch_no' => 'required'
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
        $payrollregister = payrollregister::create([
            'account_id' => auth()->user()->employer_id,
            'period_from' => Carbon::now(),
            'period_to' => Carbon::now(),
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

        /**
         *  Update Query
         * */
        DB::table('payrollregister')->where('id', '=', $request->input('id'))
                                ->update(array(
                                    'account_status' => '1',
                                ));
     }

}
