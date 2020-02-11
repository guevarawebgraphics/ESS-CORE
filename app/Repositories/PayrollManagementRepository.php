<?php

namespace App\Repositories;

use DB;
use Carbon\Carbon;
use App\Events\NewPayrollRegisterEvent;

class PayrollManagementRepository
{
    /**
     * @ Post Payregister
     * @return  
     **/
    public function postPayrollRegister($payrollData)
    {

        $check_payroll_status = DB::table('payrollregister')
                ->where('id', '=', $payrollData->input('id'))
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
                            ->where('payroll_register_details.PayRegisterId', '=', $payrollData->id)
                            ->where('employee.created_by', '=', auth()->user()->id)
                            ->select('employee_personal_information.email_add',
                                    'employee_personal_information.lastname',
                                    'employee_personal_information.firstname',
                                    'payrollregister.period_from',
                                    'payrollregister.period_to')
                            ->get();

        //Check
        $check_notification = DB::table('notification')
                //->where('employee_no', '=', $payrollData->employee_no)
                ->where('employer_id', '=', auth()->user()->employer_id)
                ->count() > 0;
        if($check_notification == true){
        $mail_template = DB::table('notification')
                    //->where('employer_id', auth()->user()->id)
                    ->where('employer_id', auth()->user()->employer_id)
                    ->where('notification_type', 1)
                    ->select('notification_message')
                    ->first();
        }
        if($check_notification == false) {
                /*Email Template*/
                $mail_template = DB::table('notification')
                ->where('id', '39')
                ->where('notification_type', 1)
                ->select('notification_message')
                ->first();
                }

        }
        // Enviroment Variable
        $enviroment = config('app.url');
        // Ess Link
        $ess_link = $enviroment."/payslips";



        foreach($get_employees_email as $data) {
            // Replace All The String in the Notification Message
            $search = ["name",
                       "Datefrom",
                       "Dateto",
                       "url"];
            $replace = [$data->lastname . $data->firstname,
                         Carbon::parse($data->period_from)->format('m-d-Y'),
                         Carbon::parse($data->period_to)->format('m-d-Y'),
                         "<a href=".$ess_link.">Click Here</a>"];                
            $template_result = str_replace($search, $replace, $mail_template->notification_message); 
                            

            // /*Send Mail */
            $data_email = array('username' => 'test', 'email' => $data->email_add, "template" => $template_result);
            event(new NewPayrollRegisterEvent($data_email));
        }

        /**
         *  Update Query
         * */
        DB::table('payrollregister')->where('id', '=', $payrollData->input('id'))
                                ->update(array(
                                    'account_status' => '1',
                                ));
        return $payrollData;
    }
}