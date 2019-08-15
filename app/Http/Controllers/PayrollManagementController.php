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
use App\payroll_register_details_preview;

/**
 * @ Excel Imports
 * */
use App\Imports\PayrollImport;
use App\Imports\PayrollImportPreview;

/**
 * @ Excel Export
 * */
use App\Exports\PayrollExport;

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
        $Employees_upload_template = DB::table('template')
                                        ->where('id', '=', 26)
                                        ->select(
                                            'document_code',
                                            'document_file')
                                        ->get();
        
        return view('employer_modules.payroll_management.upload', compact('Employees_upload_template'));
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
                        ->where('account_id', '=', auth()->user()->id)
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
                                 ->latest('created_at')
                                 ->get();
        return Response::json($payrollregister);
    }

    /**
     * @ Get Payroll Details Preview
     * */
    public function get_payroll_register_details_preview(Request $request) {
        $get_payroll_register_details_preview = DB::table('payroll_register_details_preview')
                            ->where('created_by', '=', auth()->user()->id)
                            ->select('id',
                                    'employee_no',
                                    'basic',
                                    'late',
                                    'absent',
                                    'regular_ot',
                                    'undertime',
                                    'legal_holiday',
                                    'special_holiday',
                                    'night_differencial',
                                    'adjustment_salary',
                                    'night_diff_ot',
                                    'incentives',
                                    'commision',
                                    'net_basic_taxable',
                                    'non_taxable_allowance',
                                    'rice_allowance',
                                    'meal_allowance',
                                    'telecom',
                                    'transpo',
                                    'ecola',
                                    'grosspay',
                                    'sss',
                                    'phic',
                                    'hdmf',
                                    'wtax',
                                    'sss_loan',
                                    'hdmf_loan',
                                    'bank_loan',
                                    'cash_advance',
                                    'total_deduction',
                                    'net_pay',
                                    'bank_id',
                                    'payroll_release_date',
                                    'overtime_hours',
                                    'account_status',
                                    'absences_days',
                                    'account_status_datetime')
                                    ->get();
        return Response::json($get_payroll_register_details_preview);
    }

    /**
     * Upload Pay Register 
     * This function is unusesable
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
            'account_id' => auth()->user()->id,
            'employer_id' => auth()->user()->employer_id,
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

        // Upload
        $import = Excel::import(new PayrollImport($payregisterid), $path);

        // Preview
        //$array = Excel::toCollection(new PayrollPreview, $request->file('file'), \Maatwebsite\Excel\Excel::XLSX);

        return Response::json();
    }

    /**
     * @ Upload Preview 
     * */
    public function upload_payroll_preview(Request $request) {

        /**
         * 
         * Validate Requests
         */
        $validator = $this->validate($request, [
            'file' => 'required|mimes:xls,xlsx',
        ]);
        
    
        $path = $request->file('file')->getRealPath();


        // Preview
        $result = Excel::import(new PayrollImportPreview, $path);

        return Response::json($result);
    }

    // public function PayrollExport(Request $request) {
    //     return (new PayrollExport)->download('Payroll.xlsx');
    // }

    /**
     * @ Check employee no
     **/
    public function check_employee_no(Request $request){


        $check_employee_no = DB::table('employee')
                                ->where('employee_no', '=', $request->employee_no)
                                ->where('employer_id', '=', auth()->user()->employer_id)
                                ->count() > 0;
        
        if($check_employee_no == true){
            return json_encode([
                'message' => 'OK',
                'status' => 'true',
                'result' => $check_employee_no 
            ]);
        }

        if ($check_employee_no == false) {
            return json_encode([
                'message' => 'Not Found',
                'status' => 'false',
                'result' => $check_employee_no 
            ]);
        }
    }

    /**
     * @ Check if Payroll Register Exists in table
     **/
    public function check_employee_exists_in_excel(Request $request){

        $check_employee_exists_in_excel = DB::table('payroll_register_details_preview')
                                            ->where('employee_no', '=', $request->employee_no)
                                            ->where('created_by', '=', auth()->user()->id)
                                            ->count() > 1;

        if($check_employee_exists_in_excel == true){
            return json_encode([
                'message' => 'Duplicate Entry in your Excel File',
                'status'  => 'false',
                'result'  => $check_employee_exists_in_excel
            ]);
        }

        if($check_employee_exists_in_excel == false){
            return json_encode([
                'message' => 'OK',
                'status'  => 'true',
                'result'  => $check_employee_exists_in_excel
            ]);
        }
    }

    /**
     * @ Save Payroll Register
     * */
    public function submit_payroll_register_details(Request $request) {
        /**
         * 
         * Validate Requests
         */
        $validator = $this->validate($request, [
            'batch_no' => 'required',
            'payroll_schedule' => 'required',
            'period_from' => 'required',
            'period_to' => 'required'
        ]);

        $get_payroll_register_details_preview = DB::table('payroll_register_details_preview')
                            ->join('employee', 'payroll_register_details_preview.employee_no' , '=', 'employee.employee_no')
                            ->where('payroll_register_details_preview.created_by', '=', auth()->user()->id)
                            ->select('payroll_register_details_preview.id',
                                    'payroll_register_details_preview.employee_no',
                                    'payroll_register_details_preview.basic',
                                    'payroll_register_details_preview.late',
                                    'payroll_register_details_preview.absent',
                                    'payroll_register_details_preview.regular_ot',
                                    'payroll_register_details_preview.undertime',
                                    'payroll_register_details_preview.legal_holiday',
                                    'payroll_register_details_preview.special_holiday',
                                    'payroll_register_details_preview.night_differencial',
                                    'payroll_register_details_preview.adjustment_salary',
                                    'payroll_register_details_preview.night_diff_ot',
                                    'payroll_register_details_preview.incentives',
                                    'payroll_register_details_preview.commision',
                                    'payroll_register_details_preview.net_basic_taxable',
                                    'payroll_register_details_preview.non_taxable_allowance',
                                    'payroll_register_details_preview.rice_allowance',
                                    'payroll_register_details_preview.meal_allowance',
                                    'payroll_register_details_preview.telecom',
                                    'payroll_register_details_preview.transpo',
                                    'payroll_register_details_preview.ecola',
                                    'payroll_register_details_preview.grosspay',
                                    'payroll_register_details_preview.sss',
                                    'payroll_register_details_preview.phic',
                                    'payroll_register_details_preview.hdmf',
                                    'payroll_register_details_preview.wtax',
                                    'payroll_register_details_preview.sss_loan',
                                    'payroll_register_details_preview.hdmf_loan',
                                    'payroll_register_details_preview.bank_loan',
                                    'payroll_register_details_preview.cash_advance',
                                    'payroll_register_details_preview.total_deduction',
                                    'payroll_register_details_preview.net_pay',
                                    'payroll_register_details_preview.bank_id',
                                    'payroll_register_details_preview.payroll_release_date',
                                    'payroll_register_details_preview.overtime_hours',
                                    'payroll_register_details_preview.account_status',
                                    'payroll_register_details_preview.absences_days',
                                    'payroll_register_details_preview.account_status_datetime',
                                    'employee.payroll_schedule')
                                    ->get();

        // check if the employer if there is a pending employees to upload
        if($get_payroll_register_details_preview->count() > 0){
            foreach($get_payroll_register_details_preview as $check_schedule)
            {
                /**
                 * @ Check if the Payroll Schedule is equal to the payroll schedule request
                 * */
                if($check_schedule->payroll_schedule !== $request->payroll_schedule)
                {
                    return json_encode([
                        'message' => 'Payroll Schedule is not Match',
                        'status'  => 'false',
                        'rest' => $check_schedule->employee_no
                    ]);
                }
                else {
                    /**
                     * @ Create payrollregisterdetails 
                     * */
                    $period_from = Carbon::parse($request->period_from)->format('Y-m-d'); 
                    $period_to = Carbon::parse($request->period_to)->format('Y-m-d');
                    $payrollregister = payrollregister::create([
                        'account_id' => auth()->user()->id,
                        'employer_id' => auth()->user()->employer_id,
                        'period_from' => $period_from,
                        'period_to' => $period_to,
                        'payroll_schedule_id' => $request->payroll_schedule,
                        'batch_no' => $request->input('batch_no'),
                        'payroll_file' => 'PayRegister'.'_'.carbon::now()->format('Y-m-d').'_'.$request->input('batch_no'),
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

                    foreach($get_payroll_register_details_preview as $row) {

                        /**
                         * @ Insert to the Main Table
                         * */
                        $payroll_register_details = payrollregisterdetails::create([
                            'PayRegisterId' => $payregisterid,
                            'employee_no' => $row->employee_no,
                            'basic' => $row->basic,
                            'absent' => $row->absent,
                            'late' => $row->late,
                            'regular_ot' => $row->regular_ot,
                            'undertime' => $row->undertime,
                            'legal_holiday' => $row->undertime,
                            'special_holiday' => $row->special_holiday,
                            'night_differencial' => $row->night_differencial,
                            'adjustment_salary' => $row->adjustment_salary,
                            'night_diff_ot' => $row->night_diff_ot,
                            'incentives' => $row->incentives,
                            'commision' => $row->commision,
                            'net_basic_taxable' => $row->net_basic_taxable,
                            'non_taxable_allowance' => $row->non_taxable_allowance,
                            'rice_allowance' => $row->rice_allowance,
                            'meal_allowance' => $row->meal_allowance,
                            'transpo' => $row->transpo,
                            'ecola' => $row->ecola,
                            'grosspay' => $row->grosspay,
                            'sss' => $row->sss,
                            'phic' => $row->phic,
                            'hdmf' => $row->hdmf,
                            'wtax' => $row->wtax,
                            'sss_loan' => $row->sss_loan,
                            'hdmf_loan' => $row->hdmf_loan,
                            'bank_loan' => $row->bank_loan,
                            'cash_advance' => $row->cash_advance,
                            'total_deduction' => $row->total_deduction,
                            'net_pay' => $row->net_pay,
                            'bank_id' => '1',
                            'payroll_release_date' => Carbon::now(),
                            'overtime_hours' => $row->overtime_hours,
                            'absences_days' => $row->absences_days,
                            'account_status_datetime' => Carbon::now(),
                            'created_at' => Carbon::now(),
                            'created_by' => auth()->user()->id,
                            'created_datetime' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                            'updated_datetime' => Carbon::now(),
                        ]);

                            /**
                             * @ Delete Preview
                             * */
                            payroll_register_details_preview::where('id', '=', $row->id)->where('created_by', '=', auth()->user()->id)->delete();

                    }
                    
                    return json_encode([
                        'message' => 'OK',
                        'status'  => 'true',
                        'rest' => $get_payroll_register_details_preview
                    ]);
                }
            }
        }
        else {
            return json_encode([
                'message' => 'Upload Employee First',
                'status' => 'failed',
            ]);
        }



        
    }

    public function delete_preview_details(Request $request) {
        /**
         * @ Delete Preview
         * */
        $delete_detail = payroll_register_details_preview::where('id', '=', $request->id)->where('created_by', '=', auth()->user()->id)->delete();

        if($delete_detail){
            return json_encode([
                'message' => 'OK',
                'status'  => 'true',
            ]);
        }
        else {
            return json_encode([
                'message' => 'ERROR',
                'status'  => 'false',
            ]);
        }
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
                                    ->join('employee', 'payroll_register_details.employee_no', '=', 'employee.employee_no')
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
        
        // Enviroment Variable
        $enviroment = config('app.url');
        // Ess Link
        $ess_link = $enviroment."/payslips";



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


     /**
      * @ Update Payroll Details Preview
     **/
    public function update_payroll_details_preview(Request $request) {
        /**
         * @ Validate Request
         **/
        $this->validate($request, [
            'id' => 'required',
            'employee_no' => 'required',
            'basic' => 'required',
            'late' => 'required',
            'absent' => 'required',
            'regular_ot' => 'required',
            'undertime' => 'required',
            'legal_holiday' => 'required',
            'special_holiday' => 'required',
            'night_differencial' => 'required',
            'adjustment_salary' => 'required',
            'night_diff_ot' => 'required',
            'incentives' => 'required',
            'commision' => 'required',
            'net_basic_taxable' => 'required',
            'non_taxable_allowance' => 'required',
            'rice_allowance' => 'required',
            'meal_allowance' => 'required',
            'telecom' => 'required',
            'transpo' => 'required',
            'ecola' => 'required',
            'grosspay' => 'required',
            'sss' => 'required',
            'phic' => 'required',
            'hdmf' => 'required',
            'wtax' => 'required',
            'sss_loan' => 'required',
            'hdmf_loan' => 'required',
            'bank_loan' => 'required',
            'cash_advance' => 'required',
            'total_deduction' => 'required',
            'net_pay' => 'required',
            'overtime_hours' => 'required',
            'absences_days' => 'required',
        ]);

        $update_payroll_details_preview = DB::table('payroll_register_details_preview')
                                                ->where('id', '=', $request->id)
                                                ->where('created_by', '=', auth()->user()->id)
                                                ->update(array(
                                                    'employee_no' => $request->employee_no,
                                                    'basic' => $request->basic,
                                                    'absent' => $request->absent,
                                                    'late' => $request->late,
                                                    'regular_ot' => $request->regular_ot,
                                                    'undertime' => $request->undertime,
                                                    'legal_holiday' => $request->undertime,
                                                    'special_holiday' => $request->special_holiday,
                                                    'night_differencial' => $request->night_differencial,
                                                    'adjustment_salary' => $request->adjustment_salary,
                                                    'night_diff_ot' => $request->night_diff_ot,
                                                    'incentives' => $request->incentives,
                                                    'commision' => $request->commision,
                                                    'net_basic_taxable' => $request->net_basic_taxable,
                                                    'non_taxable_allowance' => $request->non_taxable_allowance,
                                                    'rice_allowance' => $request->rice_allowance,
                                                    'meal_allowance' => $request->meal_allowance,
                                                    'transpo' => $request->transpo,
                                                    'ecola' => $request->ecola,
                                                    'grosspay' => $request->grosspay,
                                                    'sss' => $request->sss,
                                                    'phic' => $request->phic,
                                                    'hdmf' => $request->hdmf,
                                                    'wtax' => $request->wtax,
                                                    'sss_loan' => $request->sss_loan,
                                                    'hdmf_loan' => $request->hdmf_loan,
                                                    'bank_loan' => $request->bank_loan,
                                                    'cash_advance' => $request->cash_advance,
                                                    'total_deduction' => $request->total_deduction,
                                                    'net_pay' => $request->net_pay,
                                                    'overtime_hours' => $request->overtime_hours,
                                                    'absences_days' => $request->absences_days,
                                                ));
        
        
        return json_encode([
            'message' => 'OK',
            'status' => 'true',
            'rest' => $request->employee_no
        ]);
    }

}
