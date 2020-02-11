<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Hash;
/**
 *  @ Insert Model Here
 *  */
use App\User;
use App\Logs;
use App\ESSBase;
use App\UserActivation;
use App\EmployerEmployee;
use App\EmployeeEnrollment;
use App\EmployeePersonalInfo;
use App\EmployeeDetailsPreview;
use App\employee_personal_information_preview;

use DB;
use Mail;
use Keygen;
use Carbon\Carbon;

use App\Events\ResendEmployeeEmailEvent;


class EmployeesEnrollmentRepository
{

    /**
     * @ Resend Email
     * @return ResendEmail 
     **/
    public function resendEmail($emailData)
    {
                /**
         * Generate A New Password
         **/
        $password = Keygen::alphanum(10)->generate();
        $update_password = User::where('id', '=', $emailData->user_id)
                        ->update(array(
                            'password' => Hash::make($password),
                        ));
        $get_employee_info = EmployeePersonalInfo::where('id', '=', $emailData->employee_info_id)
                            ->select(
                                'email_add',
                                'mobile_no'
                            )
                            ->first();
        $get_user = User::where('id', '=', $emailData->user_id)
                            ->select(
                                'name',
                                'username'
                            )
                            ->first();
        $get_user_activation = UserActivation::where('account_id', '=', $emailData->user_id)
                                ->where('created_by', '=', auth()->user()->id)
                                ->select(
                                    'activation_code',
                                    'user_activation_id'
                                )
                                ->first();
        // return json_encode($password);
        // // //Check
            $check_notification = DB::table('notification')
                    //->where('employee_no', '=', $request->employee_no)
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
            if($check_notification == false){
            /*Email Template*/
            $mail_template = DB::table('notification')
                    //->where('employer_id', auth()->user()->id)
                    //->where('employer_id', auth()->user()->employer_id)
                    ->where('id', '=', 31)
                    ->where('notification_type', 1)
                    ->select('notification_message')
                    ->first();
            }  
            
            // Enviroment Variable
            $enviroment = config('app.url');


            $activation_link = $enviroment."/Account/Activation/".$get_user_activation->user_activation_id;


            // Replace All The String in the Notification Message
            $search = ["name", "userid", "mobile", "url", "password"];
            $replace = [$get_user->name, $get_user->username, $get_employee_info->mobile_no, "<a href=".$activation_link.">Click Here</a>", $password];                
            $template_result = str_replace($search, $replace, $mail_template->notification_message); 
                             

            /*Send Mail */
            $data_email = array('username' => $get_user->name, 'email' => $get_employee_info->email_add, "password" => $password, "template" => $template_result);
            
            // Mail::send('Email.mail', $data, function($message) use($get_employee_info, $mail_template){
            //     $message->to($get_employee_info->email_add)
            //             ->subject("ESS Successfully Registered ");
            //     $message->from('esssample@gmail.com', "ESS");
            // });

            event(new ResendEmployeeEmailEvent($data_email));

            return $emailData;
    }
}