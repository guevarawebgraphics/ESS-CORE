<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Twilio\Rest\Client;
use Twilio\Jwt\ClientToken;

use Session;
use DB;
use Response;
use Mail;
use Keygen;
use Uppercase;
use DateTime;
use App\User;
use App\EmployeeEnrollment;
use App\ESSBase;
use App\Logs;
use App\OTP;

class EmployeesEnrollmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');      
        $this->middleware(function($request, $next){
            if(Session::get("employee_enrollment") == "none")
            {
                return redirect('error')->send();
            }
            else
            {
                return $next($request);
            }
        });     
    }
    private $add = '';
    private $edit = '';
    private $delete = '';
    public function getaccount()// call for every function for security of the system
    { 
        if(Session::get('employee_enrollment') == 'all'){
            $this->add = '';
            $this->edit = '';
            $this->delete = '';
        }
        elseif(Session::get('employee_enrollment') == 'view'){
            $this->add = 'disabled';
            $this->edit = 'disabled';
            $this->delete = 'disabled';
        }
        elseif(Session::get('employee_enrollment') == 'add'){
            $this->add = '';
            $this->edit = 'disabled';
            $this->delete = 'disabled';
        }
        elseif(Session::get('employee_enrollment') == 'edit'){
            $this->add = '';
            $this->edit = '';
            $this->delete = 'disabled';
        }
        elseif(Session::get('employee_enrollment') == 'delete'){
            $this->add = '';
            $this->edit = 'disabled';
            $this->delete = '';
        }else{
            $this->add = 'disabled';
            $this->edit = 'disabled';
            $this->delete = 'disabled';
        } 
    }
    public function index()
    {
        return view('employer_modules.employees_enrollment.index');
    }
    //show encode employees
    public function encode()
    {          
        return view('employer_modules.employees_enrollment.encode');
    }
    //show upload employees
    public function upload()
    {          
        return view('employer_modules.employees_enrollment.upload');
    }  

    //function for post encode employee
    public function encode_post(Request $request)
    {
        $this->getaccount();

        $password = Keygen::alphanum(10)->generate();
        $OTP = Keygen::alphanum(6)->generate();
        /*Validate Request*/
        $customMessages = [
            'required' => 'The :attribute field is required.',
            'unique' => 'The ' . strtoupper(':attribute') . ' is already taken.'
        ];
        // $this->validate($request, [
        //     'employee_no' => 'required|min:5',
        //     //'employer_id' => 'required',
        //     'position' => 'required|min:2',
        //     'department' => 'required|min:2',
        //     'lastname' => 'required|min:1',
        //     'firstname' => 'required|min:1',
        //     'middlename' => 'required|min:1',
        //     'mobile_no' => 'required|numeric|unique:employee|min:11',      
        //     'email_add' => 'required|email|unique:employee',         
        //     'enrollment_date' => 'required',          
        //     'employment_status' => 'required',
        //     'tin' => 'required|unique:employee',
        //     'sssgsis' => 'required|unique:employee',
        //     'phic' => 'required|unique:employee',
        //     'hdmf' => 'required|unique:employee',
        //     'birthdate' => 'required',
        //     'nid' => 'required|unique:employee',
        //     'gender' => 'required',        
        //     'civil_status' => 'required',          
        //     'payroll_schedule' => 'required',
        //     'payroll_bank' => 'required',
        //     'account_no' => 'required|numeric|min:3|unique:employee',
        //     'country' => 'required',
        //     'address_unit' => 'required',
        //     'province' => 'required',
        //     'citytown' => 'required',
        //     'barangay' => 'required',
        //     'zipcode' => 'required|min:3|numeric',
        // ], $customMessages);

        // if($request->all() != null){

            //Create User
            // $user = User::create([
            //     'user_type_id' => 4,
            //     'user_type_for' => 7,
            //     'employer_id' => Session::get("employer_id"),//$request->input('employer_id'),
            //     'name' => $request->input('last_name') . ", " . $request->input('first_name') . " " . $request->input('middle_name'),
            //     'username' => $request->input('employee_no'),
            //     'password' => Hash::make($password),
            //     'enrollment_date' => $request->input('enrollment_date'),
            //     'created_by' => auth()->user()->id,
            //     'updated_by' => auth()->user()->id,
            // ]);

            //Gett the Id of User
            // $Account_id = $user->id;
                
            // //Create a User In Base Table
            // $insert_ess = new ESSBase;
            // $insert_ess->account_id = $Account_id;
            // $insert_ess->ess_id = "ESSID" . $this->generateESSID();
            // $insert_ess->user_type_id = 4;            
            // $insert_ess->created_by = auth()->user()->id;
            // $insert_ess->updated_by = auth()->user()->id;
            // $insert_ess->save();

            //Insert on Employee Table
            $employer = EmployeeEnrollment::create([
                'account_id' => 1, //$Account_id,
                'employee_no' => $request->input('employee_no'),
                'employer_id' => Session::get("employer_id"), //$request->input('employer_id'),
                'position' => $request->input('position'),
                'department' => $request->input('department'),
                'lastname' => $request->input('lastname'),
                'firstname' => $request->input('firstname'),
                'middlename' => $request->input('middlename'),
                'mobile_no' => $request->input('mobile_no'),      
                'email_add' => $request->input('email_add'),
                'enrollment_date' => $request->input('enrollment_date'),           
                'employment_status' => $request->input('employment_status'), 
                'TIN' => $request->input('tin'), 
                'SSSGSIS' => $request->input('sssgsis'), 
                'PHIC' => $request->input('phic'), 
                'HDMF' => $request->input('hdmf'), 
                'birthdate' => $request->input('birthdate'), 
                'NID' => $request->input('nid'), 
                'gender' => $request->input('gender'),         
                'civil_status' => $request->input('civil_status'),           
                'payroll_schedule' => $request->input('payroll_schedule'),
                'payroll_bank' => $request->input('payroll_bank'), 
                'account_no' => $request->input('account_no'), 
                'country' => $request->input('country'), 
                'address_unit' => $request->input('address_unit'), 
                'province' => $request->input('province'), 
                'citytown' => $request->input('citytown'), 
                'barangay' => $request->input('barangay'), 
                'zipcode' => $request->input('zipcode'),
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id         
            ]);

            //get employer name
            $get_employer_name = DB::table('employer')
                ->select('business_name')
                ->where('id', '=', Session::get("employer_id"))
                ->get();

            $data = array(
                'employer_name' => $get_employer_name[0]->business_name,
                'username' =>  $request->input('employee_no'),
                'firstname' => $request->input('firstname'),
                'middlename' => $request->input('middlename'),
                'lastname' => $request->input('lastname'),
                'password' => $password,
                'mobile_no' => $request->input('mobile_no')
            );
            
            //Sending Email
            Mail::send('Email.employee_email', $data, function($message) use ($employer){
                $message->to($employer->email_add)
                        ->subject("ESS Employee Successfully Registered ");
                $message->from('esssample@gmail.com', "ESS Employee Registration");
            });

            $this->sendSms($request->input('mobile_no'), $OTP, $get_employer_name[0]->business_name);
            
            //$date = new DateTime();
            $date_unitl = date("Y-m-d H:i:s", strtotime('+5 minutes'));

            $otp = OTP::create([
                'account_id' => 1,
                'otp' => $OTP,
                'valid_until' => $date_unitl
            ]);
            
        // }
        // else{
        //     echo "Error input";
        // }
    }

    //send sms
    public function sendSms($message_to, $otp, $employer_name)
    {
        $accountSid = config('app.twilio')['TWILIO_ACCOUNT_SID'];
        $authToken  = config('app.twilio')['TWILIO_AUTH_TOKEN'];

        if( preg_match('/^(09|\+639)\d{9}$/', $message_to))
        {
            $message_to = preg_replace('/^09/', '+639', $message_to);
        }
        
        $client = new Client($accountSid, $authToken);
        try
        {
            // Use the client to do fun stuff like send text messages!
            $client->messages->create(
            // the number you'd like to send the message to
                $message_to,
            array(
                    // A Twilio phone number you purchased at twilio.com/console
                    'from' => '+15186204736',
                    // the body of the text message you'd like to send
                    'body' => 'Congratulations! You have been enrolled by your Employer ' . $employer_name . '.' . 
                                "\n" . 'This is your One-Time-Pin (OTP) to activate your ESS Account ' . $otp . '.' . 
                                "\n" . 'This OTP will expire after 5 mins.' . 
                                "\n" . 'Thank you!' . 
                                "\n" . 'Sincerely' . 
                                "\n" . 'MyCASHere Team'
                )
            );
        }
        catch (Exception $e)
        {
            echo "Error: " . $e->getMessage();
        }
    }


    public function get_province(Request $request){
        $code = $request->code;
        $query = DB::table('refprovince')->select('id', 'provDesc', 'provCode')->orderBy('provDesc', 'ASC')->get();
        if ($code != null){
            $query = DB::table('refprovince')->select('id', 'provDesc', 'provCode')->where('provCode', $code)->get();
        }
         /*Protection for Data View as Json*/
        if($request->ajax()){
            return Response::json($query);
        }
        else {
            abort(404);
        }
        
    }

    public function get_citytown(Request $request, $provCode){
        $query = DB::table('refcitymun')->select('id', 'citymunDesc', 'provCode', 'citymunCode')->where('provCode', $provCode)->get();
        /*Protection for Data View as Json*/
        if($request->ajax()){
            return Response::json($query);
        }
        else {
            abort(404);
        }
    }

    public function get_barangay(Request $request, $citymunCode){
        $query = DB::table('refbrgy')->select('id', 'brgyDesc', 'citymunCode')->where('citymunCode', $citymunCode)->get();
        /*Protection for Data View as Json*/
        if($request->ajax()){
            return Response::json($query);
        }
        else {
            abort(404);
        }
    }

    // Method for inserting into logs
    public function insert_log($event)
    {
        $inserlog = new Logs;
        $inserlog->account_id = auth()->user()->id;
        $inserlog->log_event = $event;
        $inserlog->save();
    }

    /*Generate Key*/
    protected function generateESSKey(){
        // prefixes the key with a random integer between 1 - 9 (inclusive)
        return Keygen::numeric(7)->prefix(mt_rand(1, 9))->generate(true);
    }

    /*Generate ESS ID*/
    protected function generateESSID(){

        $ess_id = $this->generateESSKey();

        // Ensure ID does not exist
        // Generate new one if ID already exists
        while (ESSBase::where('ess_id', $ess_id)->count() > 0){
            $ess_id = $this->generateESSKey();
        }

        return $ess_id;
    }
}
