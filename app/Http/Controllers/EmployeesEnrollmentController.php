<?php

namespace App\Http\Controllers;

/**
 * @ Packages Facades
 *  */
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Arr;
/**
 * @ Insert Packages Here
 *  */
use Keygen;
use Carbon\Carbon;
use Twilio\Rest\Client;
use Twilio\Jwt\ClientToken;
use LasseRafn\Initials\Initials;
use Maatwebsite\Excel\Facades\Excel;

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
use App\employee_personal_information_preview;


/**
 *  Laravel
 *  */
use DB;
use Mail;
use Session;
use DateTime;
use Response;
use Uppercase;


/**
 *  @ Use App Imports
 *  */
use App\Imports\EmployeesImport;
use App\Imports\EmployeesImportPreview;

class EmployeesEnrollmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');   
        $this->middleware('revalidate'); // Revalidate back history Security For Back Button  
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
    //show the index page
    public function index()
    {

        $employee_info = DB::table('employer_and_employee')
                            ->join('employee', 'employer_and_employee.employee_id', 'employee.id')
                            ->join('employee_personal_information', 'employee.employee_info', '=', 'employee_personal_information.id')
                            ->select('employer_and_employee.id as eneid',
                                    'employee.id as emp_id',
                                    'employee.employee_no',
                                    'employee.enrollment_date',
                                    'employee.department',
                                    'employee.employment_status',
                                    'employee.payroll_schedule',
                                    'employee.payroll_bank',
                                    'employee.account_no',
                                    'employee.AccountStatus as AccountStatus',
                                    'employee.position',
                                    'employee_personal_information.id',
                                    'employee_personal_information.lastname',
                                    'employee_personal_information.firstname',
                                    'employee_personal_information.middlename',
                                    'employee_personal_information.suffix',
                                    'employee_personal_information.TIN',
                                    'employee_personal_information.SSSGSIS',
                                    'employee_personal_information.PHIC',
                                    'employee_personal_information.HDMF',
                                    'employee_personal_information.NID',
                                    'employee_personal_information.mobile_no',
                                    'employee_personal_information.email_add',
                                    'employee_personal_information.birthdate',
                                    'employee_personal_information.gender',
                                    'employee_personal_information.civil_status',
                                    'employee_personal_information.country',
                                    'employee_personal_information.address_unit',
                                    'employee_personal_information.citytown',
                                    'employee_personal_information.barangay',
                                    'employee_personal_information.province',
                                    'employee_personal_information.zipcode')
                            ->where('employer_and_employee.employer_id', '=', auth()->user()->employer_id)
                            ->latest('employer_and_employee.created_at')
                            ->get();
        /**
         * @ Employees Upload Template
         * */
        $Employees_upload_template = DB::table('template')
                                        ->where('id', '=', 25)
                                        ->select(
                                            'document_code',
                                            'document_file')
                                        ->get();

        return view('employer_modules.employees_enrollment.index', compact('employee_info', 'Employees_upload_template'));
    }
    //refresh table employee
    public function refresh_table_employee()
    {
        $employee_info = DB::table('employer_and_employee')
                            ->join('employee', 'employer_and_employee.employee_id', 'employee.id')
                            ->join('employee_personal_information', 'employee.employee_info', '=', 'employee_personal_information.id')
                            ->select('employer_and_employee.id as eneid',
                                    'employee.id as emp_id',
                                    'employee.employee_no',
                                    'employee.enrollment_date',
                                    'employee.department',
                                    'employee.employment_status',
                                    'employee.payroll_schedule',
                                    'employee.payroll_bank',
                                    'employee.account_no',
                                    'employee.AccountStatus as AccountStatus',
                                    'employee.position',
                                    'employee_personal_information.id',
                                    'employee_personal_information.lastname',
                                    'employee_personal_information.firstname',
                                    'employee_personal_information.middlename',
                                    'employee_personal_information.suffix',
                                    'employee_personal_information.TIN',
                                    'employee_personal_information.SSSGSIS',
                                    'employee_personal_information.PHIC',
                                    'employee_personal_information.HDMF',
                                    'employee_personal_information.NID',
                                    'employee_personal_information.mobile_no',
                                    'employee_personal_information.email_add',
                                    'employee_personal_information.birthdate',
                                    'employee_personal_information.gender',
                                    'employee_personal_information.civil_status',
                                    'employee_personal_information.country',
                                    'employee_personal_information.address_unit',
                                    'employee_personal_information.citytown',
                                    'employee_personal_information.barangay',
                                    'employee_personal_information.province',
                                    'employee_personal_information.zipcode')
                            ->where('employer_and_employee.employer_id', '=', auth()->user()->employer_id)
                            ->latest('employer_and_employee.created_at')
                            ->get();

        return view('employer_modules.employees_enrollment.table.encodetable')->with('employee_info', $employee_info);
    }

    // Get Employees Details Preview
    public function get_employees_details_preview(Request $request){
        $employee_info_preview = DB::table('employer_and_employee')
                            ->join('employee', 'employer_and_employee.employee_id', 'employee.id')
                            ->join('employee_personal_information_preview', 'employee.employee_info', '=', 'employee_personal_information_preview.id')
                            ->select('employer_and_employee.id as eneid',
                                    'employee.id as emp_id',
                                    'employee.employee_no',
                                    'employee.enrollment_date',
                                    'employee.department',
                                    'employee.employment_status',
                                    'employee.payroll_schedule',
                                    'employee.payroll_bank',
                                    'employee.account_no',
                                    'employee.AccountStatus as AccountStatus',
                                    'employee.position',
                                    'employee_personal_information_preview.id',
                                    'employee_personal_information_preview.lastname',
                                    'employee_personal_information_preview.firstname',
                                    'employee_personal_information_preview.middlename',
                                    'employee_personal_information_preview.TIN',
                                    'employee_personal_information_preview.SSSGSIS',
                                    'employee_personal_information_preview.PHIC',
                                    'employee_personal_information_preview.HDMF',
                                    'employee_personal_information_preview.NID',
                                    'employee_personal_information_preview.mobile_no',
                                    'employee_personal_information_preview.email_add',
                                    'employee_personal_information_preview.birthdate',
                                    'employee_personal_information_preview.gender',
                                    'employee_personal_information_preview.civil_status',
                                    'employee_personal_information_preview.country',
                                    'employee_personal_information_preview.address_unit',
                                    'employee_personal_information_preview.citytown',
                                    'employee_personal_information_preview.barangay',
                                    'employee_personal_information_preview.province',
                                    'employee_personal_information_preview.zipcode')
                            ->where('employer_and_employee.employer_id', '=', auth()->user()->employer_id)
                            ->latest('employer_and_employee.created_at')
                            ->get();
        // return json_encode([
        //     'message' => 'OK',
        //     'status' => 'true',
        //     'rest' => $employee_info
        // ]);
        return json_encode($employee_info_preview);
    }
    //show encode employees
    public function encode()
    {          
        return view('employer_modules.employees_enrollment.encode');
    }
    //show upload employees
    public function upload()
    {          
        $Employees_upload_template = DB::table('template')
                                        ->where('id', '=', 25)
                                        ->select(
                                            'document_code',
                                            'document_file')
                                        ->get();

        return view('employer_modules.employees_enrollment.upload', compact('Employees_upload_template'));
    }  

    //searching of existing employee with ess id
    public function search_existing_employee(Request $request)
    {
        $ess_id = $request->essid;
        $data = array();
        $employee_info = '';

        $search_ess_employee = DB::table('ess_basetable')
                                    ->where('ess_id', '=', $ess_id)
                                    ->get();
        /**
         * @ Get Username
         * */
        $get_user_profile_picture = DB::table('users')
                                    ->join('user_picture', 'users.id', '=', 'user_picture.user_id')
                                    ->where('username', '=', $ess_id)
                                    ->get();
        /**
         * @ Check User Picture
         *  */
        $check_user_picture = DB::table('user_picture')
                                    ->join('users', 'user_picture.user_id', '=', 'users.id')
                                    ->where('users.username', '=', $ess_id)
                                    ->count() > 0;
        
        if(!empty($search_ess_employee)){


            $employee_info = DB::table('employee_personal_information')
                            ->join('employee', 'employee_personal_information.id', '=', 'employee.employee_info')
                            ->join('refprovince', 'employee_personal_information.province', '=', 'refprovince.provCode')
                            ->join('refbrgy', 'employee_personal_information.barangay', '=', 'refbrgy.id')
                            ->join('refcitymun', 'employee_personal_information.citytown', '=', 'refcitymun.citymunCode')
                            ->select('employee.employee_no',
                                    'employee.enrollment_date',
                                    'employee.department',
                                    'employee.employment_status',
                                    'employee.payroll_schedule',
                                    'employee.payroll_bank',
                                    'employee.account_no',
                                    'employee.position',
                                    'employee_personal_information.id',
                                    'employee_personal_information.lastname',
                                    'employee_personal_information.firstname',
                                    'employee_personal_information.middlename',
                                    'employee_personal_information.suffix',
                                    'employee_personal_information.TIN',
                                    'employee_personal_information.SSSGSIS',
                                    'employee_personal_information.PHIC',
                                    'employee_personal_information.HDMF',
                                    'employee_personal_information.NID',
                                    'employee_personal_information.mobile_no',
                                    'employee_personal_information.email_add',
                                    'employee_personal_information.birthdate',
                                    'employee_personal_information.gender',
                                    'employee_personal_information.civil_status',
                                    'employee_personal_information.country',
                                    'employee_personal_information.address_unit',
                                    'employee_personal_information.citytown',
                                    'employee_personal_information.barangay',
                                    'employee_personal_information.province',
                                    'employee_personal_information.zipcode',
                                    'refprovince.provDesc',
                                    'refbrgy.brgyDesc',
                                    'refcitymun.citymunDesc')
                            ->where('employee_personal_information.id', '=', $search_ess_employee[0]->employee_info)
                            ->get();

            $ess_id = DB::table('ess_basetable')
            ->select('ess_id')
            ->where('employee_info', '=', $employee_info[0]->id)
            ->get();
        }
        else{

            echo "No Employee";
        }

        if(!empty($employee_info))
        {
            $essid = $ess_id[0]->ess_id;
            $id = $employee_info[0]->id;
            $lastname = $employee_info[0]->lastname;
            $firstname = $employee_info[0]->firstname;
            $middlename = $employee_info[0]->middlename;
            $middlename = $employee_info[0]->suffix;
            $TIN = $employee_info[0]->TIN;
            $SSSGSIS = $employee_info[0]->SSSGSIS;
            $PHIC = $employee_info[0]->PHIC;
            $HDMF = $employee_info[0]->HDMF;
            $NID = $employee_info[0]->NID;
            $mobile_no = $employee_info[0]->mobile_no;
            $email_add = $employee_info[0]->email_add;
            $birthdate = $employee_info[0]->birthdate;
            $gender = $employee_info[0]->gender;
            $civil_status = $employee_info[0]->civil_status;
            $country = $employee_info[0]->country;
            $address_unit = $employee_info[0]->address_unit;
            $citytown = $employee_info[0]->citytown;
            $barangay = $employee_info[0]->barangay;
            $province = $employee_info[0]->province;
            $zipcode = $employee_info[0]->zipcode;
            $employee_no = $employee_info[0]->employee_no;
            $enrollment_date = $employee_info[0]->enrollment_date;
            $department = $employee_info[0]->department;
            $employment_status = $employee_info[0]->employment_status;
            $payroll_schedule = $employee_info[0]->payroll_schedule;
            $payroll_bank = $employee_info[0]->payroll_bank;
            $account_no = $employee_info[0]->account_no;
            $position = $employee_info[0]->position;
            $provDesc = $employee_info[0]->provDesc;
            $brgyDesc = $employee_info[0]->brgyDesc;
            $citymunDesc = $employee_info[0]->citymunDesc;
            if($check_user_picture)
            {
                $get_user_profile_picture = $get_user_profile_picture[0]->profile_picture;
            }
            

        }
        else
        {
            echo "no data/ employee doesnt exist";
        }

        $data = array(
            'ess_id'=>$essid,
            'id'=>$id,
            'lastname'=>$lastname,
            'firstname' => $firstname,
            'middlename' => $middlename,
            'suffix' => $middlename,
            'TIN' => $TIN,
            'SSSGSIS' => $SSSGSIS,
            'PHIC' => $PHIC,
            'HDMF' => $HDMF,
            'NID' => $NID,
            'mobile_no' => $mobile_no,
            'email_add' => $email_add,
            'birthdate' => $birthdate,
            'gender' => $gender,
            'civil_status' => $civil_status,
            'country' => $country,
            'address_unit' => $address_unit,
            'citytown' => $citytown,
            'barangay' => $barangay,
            'province' => $province,
            'zipcode' => $zipcode,
            'employee_no' => $employee_no,
            'enrollment_date' => $enrollment_date,
            'department' => $department,
            'employment_status' => $employment_status,
            'payroll_schedule' => $payroll_schedule,
            'payroll_bank' => $payroll_bank,
            'account_no' => $account_no,
            'position' => $position,
            'provDesc' => $provDesc,
            'brgyDesc' => $brgyDesc,
            'citymunDesc' => $citymunDesc,
            'profifle_picture' => ($check_user_picture) ? $get_user_profile_picture : null
        );

        echo json_encode($data);

        
    }

    //function for post encode employee
    public function encode_post(Request $request)
    {
        $this->getaccount();

        $password = Keygen::alphanum(10)->generate();
        $UserActivation = Keygen::length(6)->numeric()->generate();
        $useractivation_id = $this->generateUserActivationId();

        $birthdate = Carbon::parse($request->birthdate)->format('Y-m-d');
        $enrollment_date = Carbon::parse($request->enrollment_date)->format('Y-m-d');

        //Generated ESS ID
        $initial = (new Initials)->length(3)->generate($request->input('lastname') . ' ' . $request->input('firstname') . ' ' . $request->input('middlename'));    
        $employee_ess_id = $initial . $this->generateESSID();

        $fullname = $request->input('last_name') . ", " . $request->input('first_name') . ", " . $request->input('middle_name');

        /// NEW FUNCTION

        //check if the checked checkbox is new employee
        if($request->input('rbn_emp') == 'new_employee')
        {
            /*Validate Request*/
            $customMessages = [
                'required' => 'The :attribute field is required.',
                'unique' => 'The ' . strtoupper(':attribute') . ' is already taken.'
            ];
            $this->validate($request, [
                'employee_no' => ['required','numeric', Rule::unique('employee')->where((function ($query) use ($request){
                    return $query
                            ->where('employee_no', '=', $request->employee_no)
                            ->where('employer_id', '=', auth()->user()->employer_id);
                }))],
                'position' => 'required|min:2',
                'department' => 'required|min:2',
                'lastname' => 'required|min:1',
                'firstname' => 'required|min:1',
                'middlename' => 'required|min:1',
                'mobile_no' => 'required|numeric|unique:employee_personal_information|min:11',      
                'email_add' => 'required|email|unique:employee_personal_information',         
                'enrollment_date' => 'required',          
                'employment_status' => 'required',
                'tin' => 'required|unique:employee_personal_information',
                'sssgsis' => 'required|unique:employee_personal_information',
                'phic' => 'required|unique:employee_personal_information',
                'hdmf' => 'required|unique:employee_personal_information',
                'birthdate' => 'required',
                'nid' => 'required|unique:employee_personal_information',
                'gender' => 'required',        
                'civil_status' => 'required',          
                'payroll_schedule' => 'required',
                'payroll_bank' => 'required',
                'account_no' => 'required|numeric|min:3',
                'country' => 'required',
                'address_unit' => 'required',
                'province' => 'required',
                'citytown' => 'required',
                'barangay' => 'required',
                'zipcode' => 'required|min:3|numeric',
            ], $customMessages);

            if($request->all() != null){
   
                //Insert data into employee personal information table
                $employee_personal_info = EmployeePersonalInfo::create([              
                    'lastname' => $request->input('lastname'),
                    'firstname' => $request->input('firstname'),
                    'middlename' => $request->input('middlename'),
                    'suffix' => $request->input('suffix'),
                    'mobile_no' => $request->input('mobile_no'),      
                    'email_add' => $request->input('email_add'),
                    'TIN' => $request->input('tin'), 
                    'SSSGSIS' => $request->input('sssgsis'), 
                    'PHIC' => $request->input('phic'), 
                    'HDMF' => $request->input('hdmf'), 
                    'birthdate' => $birthdate, 
                    'NID' => $request->input('nid'), 
                    'gender' => $request->input('gender'),         
                    'civil_status' => $request->input('civil_status'),           
                    'country' => $request->input('country'), 
                    'address_unit' => $request->input('address_unit'), 
                    'province' => $request->input('province'), 
                    'citytown' => $request->input('citytown'), 
                    'barangay' => $request->input('barangay'), 
                    'zipcode' => $request->input('zipcode'),
                    'created_by' => auth()->user()->id,
                    'updated_by' => auth()->user()->id  
                ]);

                //get the employee personal info id
                $personal_info_id = $employee_personal_info->id;

                //insert into employee table
                $employee = EmployeeEnrollment::create([              
                    'employee_info' => $personal_info_id,
                    'employee_no' => $request->input('employee_no'),
                    'employer_id' => auth()->user()->employer_id,
                    'position' => $request->input('position'),
                    'department' => $request->input('department'),             
                    'enrollment_date' => $enrollment_date,           
                    'employment_status' => $request->input('employment_status'),                          
                    'payroll_schedule' => $request->input('payroll_schedule'),
                    'payroll_bank' => $request->input('payroll_bank'), 
                    'account_no' => $request->input('account_no'), 
                    'created_by' => auth()->user()->id,
                    'updated_by' => auth()->user()->id    
                ]);

                //get the employee id in employee table
                $employee_id = $employee->id;

                //insert into ess base table
                $insert_ess = new ESSBase;
                $insert_ess->account_id = $employee_id;
                $insert_ess->ess_id = $employee_ess_id;
                $insert_ess->employee_info = $personal_info_id;
                $insert_ess->user_type_id = 4;            
                $insert_ess->created_by = auth()->user()->id;
                $insert_ess->updated_by = auth()->user()->id;
                $insert_ess->save();
                
                

                //insert into table user
                $user = User::create([
                    'user_type_id' => 4,
                    'user_type_for' => 7,
                    'employer_id' => auth()->user()->employer_id,//Session::get("employer_id"),//$request->input('employer_id'),
                    'employee_id' => $employee_id,
                    'name' => $request->input('lastname') . ", " . $request->input('firstname') . ", " . $request->input('middlename') . ", " . $request->input('suffix'),
                    'username' => $employee_ess_id,
                    'password' => Hash::make($password),
                    'expiry_date' => Carbon::now()->addDays(14), // Default for 1 Century
                    'enrollment_date' => $enrollment_date,
                    'created_by' => auth()->user()->id,
                    'updated_by' => auth()->user()->id,
                ]);

                //insert into employer to employee table           
                $insert_employee = new EmployerEmployee;
                $insert_employee->ess_id = $employee_ess_id;
                $insert_employee->employee_id = $employee_id;
                $insert_employee->employer_id = auth()->user()->employer_id;//Session::get("employer_id");
                $insert_employee->employee_no = $employee_id;
                $insert_employee->save();

                //get employer name
                $get_employer_name = DB::table('employer')
                    ->select('business_name')
                    ->where('id', '=', auth()->user()->employer_id/*Session::get("employer_id")*/)
                    ->get();

                $data = array(
                    'employer_name' => $get_employer_name[0]->business_name,
                    'username' =>  $employee_ess_id,
                    'firstname' => $request->input('firstname'),
                    'middlename' => $request->input('middlename'), 
                    'lastname' => $request->input('lastname'), 
                    'suffix' => $request->input('suffix'),
                    'password' => $password,
                    'mobile_no' => $request->input('mobile_no'),
                    'user_activation_id' => $useractivation_id
                );

            
            //Check
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


            $activation_link = $enviroment."/Account/Activation/".$useractivation_id;


            // Replace All The String in the Notification Message
            $search = ["name", "userid", "mobile", "url", "password"];
            $replace = [$user->name, $user->username, $request->input('mobile_no'), "<a href=".$activation_link.">Click Here</a>", $password];                
            $template_result = str_replace($search, $replace, $mail_template->notification_message); 
                             

            /*Send Mail */
            $data = array('username' => $user->name, "password" => $password, "template" => $template_result);

            Mail::send('Email.mail', $data, function($message) use($employee_personal_info, $mail_template){
                $message->to($employee_personal_info->email_add)
                        ->subject("ESS Successfully Registered ");
                $message->from('esssample@gmail.com', "ESS");
            });

                // $this->sendSms($request->input('mobile_no'), $OTP, $get_employer_name[0]->business_name, $request->input('firstname'));

                //$date = new DateTime();
                $date_unitl = date("Y-m-d H:i:s", strtotime('+5 minutes'));

                $UserActivation = UserActivation::create([
                    'account_id' => $user->id,
                    'activation_code' => $UserActivation,
                    'user_activation_id' => $useractivation_id,
                    'expiration_date' => Carbon::now()->addCentury(), // Default for 1 Century 5,//this means 5 minutes or according to sir meo
                    'created_by' => auth()->user()->id,
                    'updated_by' => auth()->user()->id
                ]);

                // Random Profile Picture for Employee
                if( $request->input('gender') === "Male")
                    $arrayPicture = 
                    ["ESS_male1.png",
                    "ESS_male2.png",
                    "ESS_male3.png",
                    "ESS_male4.png",
                    "ESS_male5.png",
                    "ESS_male6.png",
                    "ESS_male7.png",
                    "ESS_male8.png",
                    "ESS_male9.png"
                    ];
                else 
                {
                    $arrayPicture = 
                    ["ESS_female1.png",
                    "ESS_female2.png",
                    "ESS_female3.png",
                    "ESS_female4.png",
                    "ESS_female5.png",
                    "ESS_female6.png",
                    "ESS_female7.png"
                    ];
                }
                $default_profile = Arr::random($arrayPicture);

                DB::table('user_picture')->insert([
                    'user_id' => $user->id,
                    'employer_id' => auth()->user()->employer_id,
                    'profile_picture' =>  $default_profile,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                 ]);

            }
        }
        else if($request->input('rbn_emp') == 'existing_employee')
        {
            /*Validate Request*/
            $customMessages = [
                'required' => 'The :attribute field is required.',
                'unique' => 'The ' . strtoupper(':attribute') . ' is already taken.'
            ];
            $this->validate($request, [
                'employee_no' => 'required|unique:employee',
                //'employer_id' => 'required',
                'position' => 'required|min:2',
                'department' => 'required|min:2',              
                'enrollment_date' => 'required',          
                'employment_status' => 'required',      
                // 'payroll_schedule' => 'required',
                // 'payroll_bank' => 'required',
                'account_no' => 'required|numeric|min:3',
            ], $customMessages);

            /**
             * Check if the Employee is Currently Employed to the current employer
             * 
             * */
            $find_employee = DB::table('employee')->where('employee_info', '=', $request->input('hidden_personalinfo_id'))->first();
            $current_employer = DB::table('employer_employee')->where('employee_no', '=', $find_employee->employee_no);
            $check_employement = DB::table('employer_and_employee')
                                    ->where('ess_id', '=', $request->input('hidden_essid'))
                                    ->where('employer_id', '=', auth()->user()->employer_id)
                                    ->count() > 0;
            /**
             * Check if the current employer variable is true
             * it will fall to the success function in javascript
             * */
            if($check_employement) {
                return Response::json('error');
            }
            else {
                // return Response::json('LOL');

                  //insert into employee table
             $employee = EmployeeEnrollment::create([              
                'employee_info' => $request->input('hidden_personalinfo_id'),
                'employee_no' => $request->input('employee_no'),
                'employer_id' => auth()->user()->employer_id,
                'position' => $request->input('position'),
                'department' => $request->input('department'),             
                'enrollment_date' => $enrollment_date,           
                'employment_status' => $request->input('employment_status'),                          
                'payroll_schedule' => "2xMonthly",
                'payroll_bank' => "File", 
                'account_no' => "BDO", 
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id    
            ]);

            $employee_id = $employee->id;

            //insert into employer to employee table           
            $insert_employee = new EmployerEmployee;
            $insert_employee->ess_id = $request->input('hidden_essid');
            $insert_employee->employer_id = auth()->user()->employer_id;//Session::get("employer_id");
            $insert_employee->employee_id = $employee_id;
            $insert_employee->employee_no = $employee_id;
            $insert_employee->save();           

            //insert into ess base table
            $insert_ess = new ESSBase;
            $insert_ess->account_id = $employee_id;
            $insert_ess->ess_id = $employee_ess_id;
            $insert_ess->employee_info = $request->input('hidden_personalinfo_id');
            $insert_ess->user_type_id = 4;            
            $insert_ess->created_by = auth()->user()->id;
            $insert_ess->updated_by = auth()->user()->id;
            $insert_ess->save();
            }

            
        }
       
    }

    /**
     * @ Update Employee
     * */

     public function update_employee(Request $request, $id)
     {
        /**
         * @ Validation All Request
         * */
        $customMessages = [
            'required' => 'The :attribute field is required.',
            'unique' => 'The ' . strtoupper(':attribute') . ' is already taken.'
        ];
        $this->validate($request, [
            'employee_no' => 'required|numeric|unique:employee,employee_no,'.$request->input('employee_id'),
            'position' => 'required|min:2',
            'department' => 'required|min:2',
            'lastname' => 'required|min:1',
            'firstname' => 'required|min:1',
            'middlename' => 'required|min:1',
            'mobile_no' => 'required|numeric|min:11|unique:employee_personal_information,mobile_no,'.$request->input('employee_info_id'),     
            'email_add' => 'required|email|unique:employee_personal_information,email_add,'.$request->input('employee_info_id'),         
            'enrollment_date' => 'required',          
            'employment_status' => 'required',
            'tin' => 'required|unique:employee_personal_information,tin,'.$request->input('employee_info_id'),     
            'sssgsis' => 'required|unique:employee_personal_information,sssgsis,'.$request->input('employee_info_id'),   
            'phic' => 'required|unique:employee_personal_information,phic,'.$request->input('employee_info_id'),   
            'hdmf' => 'required|unique:employee_personal_information,hdmf,'.$request->input('employee_info_id'),   
            'birthdate' => 'required',
            'nid' => 'required|unique:employee_personal_information,nid,'.$request->input('employee_info_id'),
            'gender' => 'required',        
            'civil_status' => 'required',          
            'payroll_schedule' => 'required',
            'payroll_bank' => 'required',
            'account_no' => 'required|numeric|min:3',
            'country' => 'required',
            'address_unit' => 'required',
            'province' => 'required',
            'citytown' => 'required',
            'barangay' => 'required',
            'zipcode' => 'required|min:3|numeric',
        ], $customMessages);



        $birthdate = Carbon::parse($request->birthdate)->format('Y-m-d');
        $enrollment_date = Carbon::parse($request->enrollment_date)->format('Y-m-d');

        /**
         * @ Update Employee Personal Information
         * */
        DB::table('employee_personal_information')
                ->where('id', '=', $request->input('employee_info_id'))
                        ->update(array(
                            'lastname' => $request->input('lastname'),
                            'firstname' => $request->input('firstname'),
                            'middlename' => $request->input('middlename'),
                            'suffix' => $request->input('suffix'),
                            'mobile_no' => $request->input('mobile_no'),      
                            'email_add' => $request->input('email_add'),
                            'TIN' => $request->input('tin'), 
                            'SSSGSIS' => $request->input('sssgsis'), 
                            'PHIC' => $request->input('phic'), 
                            'HDMF' => $request->input('hdmf'), 
                            'birthdate' => $birthdate, 
                            'NID' => $request->input('nid'), 
                            'gender' => $request->input('gender'),         
                            'civil_status' => $request->input('civil_status'),           
                            'country' => $request->input('country'), 
                            'address_unit' => $request->input('address_unit'), 
                            'province' => $request->input('province'), 
                            'citytown' => $request->input('citytown'), 
                            'barangay' => $request->input('barangay'), 
                            'zipcode' => $request->input('zipcode'),
                            'updated_by' => auth()->user()->id 
                        ));

        /**
         * @ Update Employee
         * */
        DB::table('employee')
            ->where('id', '=', $request->input('employee_id'))
            ->update(array(
                'employee_no' => $request->input('employee_no'),
                'position' => $request->input('position'),
                'department' => $request->input('department'),             
                'enrollment_date' => $enrollment_date,           
                'employment_status' => $request->input('employment_status'),                          
                'payroll_schedule' => $request->input('payroll_schedule'),
                'payroll_bank' => $request->input('payroll_bank'), 
                'account_no' => $request->input('account_no'), 
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id 
            ));
       

        $this->insert_log("Updated Employee Information ");
        return Response::json();
     }

    //send sms
    public function sendSms($message_to, $otp, $employer_name, $firstname)
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
                    'body' => 'Congratulations ' . $firstname . '! You have been enrolled by your Employer ' . $employer_name . '.' . 
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

    //Edit employee
    public function edit_encode($id)
    {
        if($id == "")
        {
            echo "No Employee Data";
        }
        /**
         * @ Security for No Employee Found
         * */
        else if(!EmployerEmployee::where('id', '=', $id)->count() > 0)
        {
            abort(404);
        }
        else if($id != "")
        {

            $employee = DB::table('employer_and_employee')
                            ->join('employee', 'employer_and_employee.employee_id', 'employee.id')
                            ->join('employee_personal_information', 'employee.employee_info', '=', 'employee_personal_information.id')
                            ->join('refbrgy', 'employee_personal_information.barangay', '=', 'refbrgy.id')
                            ->join('refcitymun', 'employee_personal_information.citytown', '=', 'refcitymun.citymunCode')
                            ->join('refprovince', 'employee_personal_information.province', '=', 'refprovince.provCode')
                            ->select('employer_and_employee.id as eneid',
                                'employee_personal_information.id as employee_info_id',
                                'employee_personal_information.lastname',
                                'employee_personal_information.firstname',
                                'employee_personal_information.middlename',
                                'employee_personal_information.suffix',
                                'employee_personal_information.TIN',
                                'employee_personal_information.SSSGSIS',
                                'employee_personal_information.PHIC',
                                'employee_personal_information.HDMF',
                                'employee_personal_information.NID',
                                'employee_personal_information.mobile_no',
                                'employee_personal_information.email_add',
                                'employee_personal_information.birthdate',
                                'employee_personal_information.gender',
                                'employee_personal_information.civil_status',
                                'employee_personal_information.country',
                                'employee_personal_information.address_unit',
                                'employee_personal_information.citytown',
                                'employee_personal_information.barangay',
                                'employee_personal_information.province',
                                'employee_personal_information.zipcode',
                                'employee.id as employee_id',
                                'employee.employee_no',
                                'employee.position',
                                'employee.payroll_bank',
                                'employee.department',
                                'employee.enrollment_date',
                                'employee.employment_status',
                                'employee.payroll_schedule',
                                'employee.account_no',
                                'refprovince.provDesc',
                                'refprovince.provCode',
                                'refcitymun.citymunDesc',
                                'refcitymun.citymunCode',
                                'refbrgy.brgyDesc',
                                'refbrgy.id as refbrgy_id'
                            )
                            ->where('employer_and_employee.id', '=', $id)
                            ->get();

            return view('employer_modules.employees_enrollment.editencode')->with('employee', $employee);
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

    /*This unique Activation ID will serves as mask to the users id*/
    protected function generateUserActivationId() {
        $user_activation_id = Keygen::length(11)->alphanum()->generate();

        return $user_activation_id;
    }

    // Update Account Status
    public function UpdateAccountStatus(Request $request, $id){

        /**
         * @ Update Employee Account Status on Employee Table
         * */
        DB::table('employee')->where('id', '=', $id)
                ->update(array(
                    'AccountStatus' => $request->input('AccountStatus')
                ));
    
        if ($id == null && $request->input('AccountStatus') == null){
            $msg = 'Error';
        }
        else {
            $msg = 'Success';
        }
    
        $this->insert_log("Updated Account");
    
    
        return Response::json($msg);
    }

    /*Upload Employees*/
    public function upload_employees(Request $request){
        $this->validate($request, [
            'file'  => 'required|mimes:xls,xlsx'
        ]);
      
        $path = $request->file('file')->getRealPath();

        $import = Excel::import(new EmployeesImport, $path);

        return Response::json();
    }

    /**
     * @ Check if Employee Register Exists in table
     **/
    public function check_employee_details_exists_in_excel(Request $request){
        
        $check_employee_exists_in_excel = DB::table('employee_personal_information_preview')
                                            ->join('employee', 'employee_personal_information_preview.id', '=', 'employee.employee_info')
                                            ->where('employee.employee_no', '=', $request->employee_no)
                                            ->where('employee.account_no', '=', $request->account_no)
                                            ->orWhere('employee_personal_information_preview.TIN', '=', $request->TIN)
                                            ->orWhere('employee_personal_information_preview.SSSGSIS', '=', $request->SSSGSIS)
                                            ->orWhere('employee_personal_information_preview.PHIC', '=', $request->PHIC)
                                            ->orWhere('employee_personal_information_preview.HDMF', '=', $request->HDMF)
                                            ->orWhere('employee_personal_information_preview.NID', '=', $request->NID)
                                            ->orWhere('employee_personal_information_preview.mobile_no', '=', $request->mobile_no)
                                            ->orWhere('employee_personal_information_preview.email_add', '=', $request->email_add)
                                            ->Where('employee.created_by', '=', auth()->user()->id)
                                            ->count() > 1;
        /**
         * @ Check for Employee Number
         * */
        $check_employee_no_for_employer = DB::table('employee')
                                            ->where('employee_no', '=', $request->employee_no)
                                            ->where('employer_id', '=', auth()->user()->employer_id)
                                            //->where('employee_info', '!=', $request->id)
                                            ->count() > 1;

        // foreach($request->all() as $key => $value){
        //     if($key == 'employee_no'){
        //         $check_employee_exists_in_excel = DB::table('employee_personal_information_preview')
        //                                     ->join('employee', 'employee_personal_information_preview.id', '=', 'employee.employee_info')
        //                                     ->where('employee.employee_no', '=', $request->employee_no)
        //                                     ->Where('employee.created_by', '=', auth()->user()->id)
        //                                     ->count() > 1;
        //     }
        // }

        /**
         * @ Check for Employee Details
         * */
        if($check_employee_exists_in_excel == true){
            /*Validate Request*/
         $customMessages = [
            'required' => 'The :attribute field is required.',
            'unique' => 'The ' . str_replace(' ', '', strtolower(':attribute')) .' is already taken.',
            'regex' => 'The Mobile Number is Invalid'
        ];
        $validator = $this->validate($request, [
                    'employee_no' => ['required','numeric', Rule::unique('employee')->where((function ($query) use ($request){
                        return $query
                                ->where('employee_no', '=', $request->employee_no)
                                ->where('employer_id', '=', auth()->user()->employer_id);
                    }))],
                    'account_no' => ['required','numeric', Rule::unique('employee')->where((function ($query) use ($request){
                        return $query
                                ->where('account_no', '=', $request->account_no)
                                ->where('employer_id', '=', auth()->user()->employer_id);
                    }))],
                    'account_no' => 'unique:employee,account_no,'.$request->account_no,
                    'TIN' => 'unique:employee_personal_information_preview,TIN,'.$request->id,
                    'SSSGSIS' => 'unique:employee_personal_information_preview,SSSGSIS,'.$request->id,
                    'PHIC' => 'unique:employee_personal_information_preview,PHIC,'.$request->id,
                    'HDMF' => 'unique:employee_personal_information_preview,HDMF,'.$request->id,
                    'NID' => 'unique:employee_personal_information_preview,NID,'.$request->id,
                    'mobile_no' => 'numeric|regex:/(09)[0-9]{9}/|unique:employee_personal_information_preview,mobile_no,'.$request->id,
                    'email_add' => 'email|unique:employee_personal_information_preview,email_add,'.$request->id,
            ], $customMessages);

            return json_encode([
                'message' => 'OK',
                'status'  => 'true',
                'result'  => $validator
            ]);
        }




        // if($check_employee_no_for_employer) {
        //     /*Validate Request*/
        //     $customMessages = [
        //         'required' => 'The :attribute field is required.',
        //         'unique' => 'The Employee No ' . $request->employee_no .' is already taken.',
        //         'regex' => 'The Mobile Number is Invalid'
        //     ];
        //     $check_employee_no = $this->validate($request, [
                
        //     ], $customMessages);
        //     return json_encode([
        //         'message' => 'OK',
        //         'status'  => 'true',
        //         'result'  => $check_employee_no
        //     ]);
        // }

        

        if($check_employee_exists_in_excel == false){
            return json_encode([
                'message' => 'OK',
                'status'  => 'true',
                'result'  => $check_employee_exists_in_excel
            ]);
        }

        
        
    }

    /**
     * @ Update Employees Preview Details
     * */
    public function update_employees_details_preview(Request $request){

        /*Validate Request*/
         $customMessages = [
            'required' => 'The :attribute field is required.',
            'unique' => 'The ' . str_replace(' ', '', strtolower(':attribute')) .' is already taken.',
            'regex' => 'The Mobile Number is Invalid'
        ];
        $validator = $this->validate($request, [
            'employee_no' => ['required','numeric', Rule::unique('employee')->where((function ($query) use ($request){
                return $query
                        ->where('employee_no', '=', $request->employee_no)
                        ->where('employer_id', '=', auth()->user()->employer_id);
            }))],
            'account_no' => ['required','numeric', Rule::unique('employee')->where((function ($query) use ($request){
                return $query
                        ->where('account_no', '=', $request->account_no)
                        ->where('employer_id', '=', auth()->user()->employer_id);
            }))],
            'TIN' => 'required|unique:employee_personal_information,TIN,'.$request->employee_preview_id,
            'SSSGSIS' => 'required|unique:employee_personal_information,SSSGSIS,'.$request->employee_preview_id,
            'PHIC' => 'required|unique:employee_personal_information,PHIC,'.$request->employee_preview_id,
            'HDMF' => 'required|unique:employee_personal_information,HDMF,'.$request->employee_preview_id,
            'NID' => 'required|unique:employee_personal_information,NID,'.$request->employee_preview_id,
            'mobile_no' => 'required|numeric|regex:/(09)[0-9]{9}/|unique:employee_personal_information,mobile_no,'.$request->employee_preview_id,
            'email_add' => 'required|email|unique:employee_personal_information,email_add,'.$request->employee_preview_id,
        ], $customMessages);

        $update_employee = DB::table('employee')
                            ->where('employee_info', '=', $request->employee_preview_id)
                            ->update(array(
                                'employee_no' => $request->employee_no,
                                'account_no' => $request->account_no
                            ));

        $update_details = DB::table('employee_personal_information_preview')
                            ->where('id', '=', $request->employee_preview_id)
                            ->where('created_by', '=', auth()->user()->id)
                            ->update(array(
                                //'employee_no' => $request->employee_no,
                                'TIN' => $request->TIN,
                                'SSSGSIS' => $request->SSSGSIS,
                                'PHIC' => $request->PHIC,
                                'HDMF' => $request->HDMF,
                                'NID' => $request->NID,
                                'mobile_no' => $request->mobile_no,
                                'email_add' => $request->email_add
                            ));
        // if($update_details){
        //     return json_encode([
        //         'message' => 'ok',
        //         'status' => 'true'
        //     ]);
        // }

        if($update_employee || $update_details){
            return json_encode([
                'message' => 'ok',
                'status' => 'true',
                'result' => $update_details
            ]);
        }
        // else{
        //     return json_encode([
        //         'message' => 'FAILED',
        //         'status' => 'false'
        //     ]);
        // }


    }


    /**
     * @ Delete Employee Details Preview
     * */
    public function delete_employee_details(Request $request){
        $id = $request->id;

        /**
         * @ Get Employee ID
         * */
        $get_employee_id = DB::table('employee')
                            ->where('employee_info', '=', $request->id)
                            ->where('created_by', '=', auth()->user()->id)
                            ->select('id')
                            ->first();

        /**
         * @ Delete Employee Personal Information Preview
         * */
        $delete_employee_detail = DB::table('employee_personal_information_preview')
                                    ->where('id', '=', $request->id)
                                    ->where('created_by', '=', auth()->user()->id)
                                    ->delete();
        /**
         * @ Delete Employee
         * */
        $delete_employee = DB::table('employee')
                                ->where('employee_info', '=' , $request->id)
                                ->where('created_by', '=', auth()->user()->id)
                                ->delete();
        /**
         * @ Delete ESS employer_and_employee
         * */
        $employer_and_employee = DB::table('employer_and_employee')
                                    ->where('employee_id', '=' , $get_employee_id->id)
                                    ->delete();

        /**
         * @ Delete ESS Base Table
         * */
        $delete_ess_base_table = DB::table('ess_basetable')
                                    ->where('account_id', '=', $get_employee_id->id)
                                    ->delete();
        /**
         * @ Delete User
         * */
        $delete_user = DB::table('users')
                        ->where('employee_id', '=', $get_employee_id->id)
                        ->delete();

        if($delete_employee_detail){
            return json_encode([
                'message' => 'OK',
                'status' => 'true'
            ]); 
        }
        
        if(!$delete_employee_detail){
            return json_encode([
                'message' => 'FAILEd',
                'status' => 'false'
            ]);
        }
    }


    /**
     * @ Save Employees Preview
     * */
    public function save_employees_preview(Request $request){
        
        $password = Keygen::alphanum(10)->generate();
        $UserActivation = Keygen::length(6)->numeric()->generate();
        $useractivation_id = $this->generateUserActivationId();

        // Get Preview Employees
        $get_employees_preview = DB::table('employee_personal_information_preview')
                                    ->join('employee', 'employee.employee_info', '=', 'employee_personal_information_preview.id')
                                    ->join('employer_and_employee', 'employer_and_employee.employee_id', '=', 'employee.id')
                                    ->where('employee_personal_information_preview.created_by', '=', auth()->user()->id)
                                    ->select(
                                        'employee_personal_information_preview.id',
                                        'employee_personal_information_preview.lastname',
                                        'employee_personal_information_preview.firstname',
                                        'employee_personal_information_preview.middlename',
                                        'employee_personal_information_preview.suffix',
                                        'employee_personal_information_preview.TIN',
                                        'employee_personal_information_preview.SSSGSIS',
                                        'employee_personal_information_preview.PHIC',
                                        'employee_personal_information_preview.HDMF',
                                        'employee_personal_information_preview.NID',
                                        'employee_personal_information_preview.mobile_no',
                                        'employee_personal_information_preview.email_add',
                                        'employee_personal_information_preview.birthdate',
                                        'employee_personal_information_preview.gender',
                                        'employee_personal_information_preview.civil_status',
                                        'employee_personal_information_preview.country',
                                        'employee_personal_information_preview.address_unit',
                                        'employee_personal_information_preview.citytown',
                                        'employee_personal_information_preview.barangay',
                                        'employee_personal_information_preview.province',
                                        'employee_personal_information_preview.zipcode',
                                        'employee_personal_information_preview.created_by',
                                        'employee_personal_information_preview.updated_by',
                                        'employee_personal_information_preview.created_at',
                                        'employee_personal_information_preview.updated_at',
                                        'employer_and_employee.ess_id',
                                        'employee.id as emp_id',
                                        'employee.account_no',
                                        'employee.employee_no'
                                    )
                                    ->get();
        /**
         * @ Check if there is a pending Employee in Preview Table
         * */
       if($get_employees_preview->count() > 0){
            foreach($get_employees_preview as $employees_preview){ 
                $employee_no = $employees_preview->employee_no;
                $array = [
                    'TIN' => $employees_preview->TIN,
                    'SSSGSIS' => $employees_preview->SSSGSIS,
                    'HDMF' => $employees_preview->HDMF,
                    'PHIC' => $employees_preview->HDMF,
                    'NID' => $employees_preview->NID,
                    'mobile_no' =>$employees_preview->mobile_no,
                    'email_add' =>$employees_preview->email_add,
                    'employee_no' =>$employees_preview->employee_no,
                    ];
                
                    validator::make($array, [
                    'TIN' => 'required|unique:employee_personal_information',
                    'HDMF' => 'required|unique:employee_personal_information',
                    'SSSGSIS' => 'required|unique:employee_personal_information',
                    'PHIC' => 'required|unique:employee_personal_information',
                    'NID' => 'required|unique:employee_personal_information',
                    'mobile_no' => 'required|unique:employee_personal_information',
                    'email_add' => 'required|unique:employee_personal_information',
                    'employee_no' => ['required', Rule::unique('employee')->where((function ($query) use ($employee_no){
                        return $query
                                ->where('employee_no', '=',$employee_no)
                                ->where('employer_id', '=', auth()->user()->employer_id);
                    }))]
                    
                    ],
                    //hii
                    [
                     'TIN.unique' => 'The TIN of Employee No: '.$employees_preview->employee_no.' has already been taken.',
                     'HDMF.unique' => 'The HDMF of Employee No: '.$employees_preview->employee_no.' has already been taken.',
                     'SSSGSIS.unique' => 'The SSSGSIS of Employee No: '.$employees_preview->employee_no.' has already been taken.',
                     'PHIC.unique' => 'The PHIC of Employee No: '.$employees_preview->employee_no.' has already been taken.',
                     'NID.unique' => 'The NID of Employee No: '.$employees_preview->employee_no.' has already been taken.',
                     'mobile_no.unique' => 'The mobile_no of Employee No: '.$employees_preview->employee_no.' has already been taken.',
                     'email_add.unique' => 'The email_add of Employee No: '.$employees_preview->employee_no.' has already been taken.'
                    ])->validate(); 

                  
                /**
                 * @ Insert to the Main Table
                 * */
                $employee_personal_info = EmployeePersonalInfo::create([
                            'id' => $employees_preview->id,
                            'lastname' => $employees_preview->lastname,
                            'firstname' => $employees_preview->firstname,
                            'middlename' => $employees_preview->middlename,
                            'suffix' => $employees_preview->suffix,
                            'TIN' => $employees_preview->TIN,
                            'SSSGSIS' => $employees_preview->SSSGSIS,
                            'PHIC' => $employees_preview->PHIC,
                            'HDMF' => $employees_preview->HDMF, 
                            'birthdate' => $employees_preview->birthdate, 
                            'NID' => $employees_preview->NID, 
                            'mobile_no' => $employees_preview->mobile_no,    
                            'email_add' => $employees_preview->email_add,
                            'gender' => $employees_preview->gender,        
                            'civil_status' => $employees_preview->civil_status,             
                            'country' => $employees_preview->country,
                            'address_unit' => $employees_preview->address_unit,
                            'province' => $employees_preview->province,
                            'citytown' => $employees_preview->citytown,
                            'barangay' => $employees_preview->barangay, 
                            'zipcode' => $employees_preview->zipcode,
                            'created_by' => auth()->user()->id,
                            'updated_by' => auth()->user()->id,
                            'created_at' => $employees_preview->created_at,
                            'updated_at' => $employees_preview->updated_at
                ]);
                /**
                 * 
                 * Create Account User
                 */
                //insert into table user
                $user = User::create([
                    'user_type_id' => 4,
                    'user_type_for' => 7,
                    'employer_id' => auth()->user()->employer_id,//Session::get("employer_id"),//$request->input('employer_id'),
                    'employee_id' => $employees_preview->emp_id,
                    'name' => $employees_preview->lastname . ", " . $employees_preview->firstname . ", " . $employees_preview->middlename . ", " . $employees_preview->suffix,
                    'username' => $employees_preview->ess_id,
                    'password' => Hash::make($password),
                    'expiry_date' => Carbon::now()->addDays(14), // Default for 1 Century
                    'enrollment_date' => Carbon::now(),
                    'created_by' => auth()->user()->id,
                    'updated_by' => auth()->user()->id,
                ]);

                
                UserActivation::where('account_id', '=', $employees_preview->emp_id)->update(array('account_id' => $user->id));
                DB::table('user_picture')->where('user_id', '=', $employees_preview->emp_id)->update(array('user_id' => $user->id));


            //Check
            // $check_notification = DB::table('notification')
            //         //->where('employee_no', '=', $request->employee_no)
            //         ->where('employer_id', '=', auth()->user()->employer_id)
            //         ->count() > 0;
            // if($check_notification == true){
            // $mail_template = DB::table('notification')
            //         //->where('employer_id', auth()->user()->id)
            //         ->where('employer_id', auth()->user()->employer_id)
            //         ->where('notification_type', 1)
            //         ->select('notification_message')
            //         ->first();
            // }
            // if($check_notification == false){

            //}  
            


            // Get Employees Details
            $employee_details = DB::table('employee')
                                ->join('users', 'employee.id', '=', 'users.employee_id')
                                ->join('user_activation', 'users.id', '=', 'user_activation.account_id')
                                ->join('employee_personal_information_preview', 'employee_personal_information_preview.id', 'employee.employee_info')
                                ->join('employer_and_employee', 'employer_and_employee.employee_id', '=', 'employee.id')
                                ->where('employee_info', '=', $employees_preview->id)
                                ->select('employee.id as emp_id',
                                        'users.id as users_id',
                                        'users.name',
                                        'users.username',
                                        'users.password',
                                        'user_activation.user_activation_id',
                                        'employee_personal_information_preview.lastname',
                                        'employee_personal_information_preview.firstname',
                                        'employee_personal_information_preview.middlename',
                                        'employee_personal_information_preview.suffix',
                                        'employer_and_employee.ess_id'
                                        
                                )
                                ->get();


            foreach($employee_details as $emp_details){
                // Enviroment Variable
                $enviroment = config('app.url');

                // Activation Link
                $activation_link = $enviroment."/Account/Activation/".$emp_details->user_activation_id;
                /*Email Template*/
                $mail_template = DB::table('notification')
                            //->where('employer_id', auth()->user()->id)
                            //->where('employer_id', auth()->user()->employer_id)
                            ->where('id', '=', 31)
                            ->where('notification_type', 1)
                            ->select('notification_message')
                            ->first();
                // Replace All The String in the Notification Message
                $search = ["name", "userid", "mobile", "url", "password"];
                $replace = [$emp_details->name, $emp_details->username, $request->input('mobile_no'), "<a href=".$activation_link.">Click Here</a>", $password];                
                $template_result = str_replace($search, $replace, $mail_template->notification_message); 
                                

                /*Send Mail */
                $data = array('username' => $emp_details->name, "password" => $password, "template" => $template_result);

                Mail::send('Email.mail', $data, function($message) use($employee_personal_info, $mail_template){
                    $message->to($employee_personal_info->email_add)
                            ->subject("ESS Successfully Registered ");
                    $message->from('esssample@gmail.com', "ESS");
                });
            // /**
            //  * @ Create A Activation
            //  * */
            // $UserActivation = UserActivation::create([
            //     'account_id' => $emp_details->users_id,
            //     'activation_code' => $UserActivation,
            //     'user_activation_id' => $useractivation_id,
            //     'expiration_date' => Carbon::now(), // Default for 1 Century 5,//this means 5 minutes or according to sir meo
            //     'created_by' => auth()->user()->id,
            //     'updated_by' => auth()->user()->id
            // ]);
            }


            

           

                /**
                 * @ Delete Employees Preview
                 * */
                employee_personal_information_preview::where('id', '=', $employees_preview->id)->where('created_by', '=', auth()->user()->id)->delete();
                
            }
            // return json_encode([
            //     'message' => 'OK',
            //     'status' => 'true'
            // ]);
            // }
            // else {
            //     return json_encode([
            //         'message' => 'FAILED to Save',
            //         'status' => 'false',
            //         // 'rest' => $employee_personal_info
            //     ]);
        }

        if($get_employees_preview->count() > 0){
            return response()->json([
                'message' => 'OK',
                'status' => true
            ]);
        }
        else {
            return response()->json([
                'message' => 'Upload Employee First',
                'status' => false
            ]);
        }
    }

    /*Upload Employees*/
    public function upload_employees_preview(Request $request){
        $this->validate($request, [
            'file'  => 'required|mimes:xls,xlsx'
        ]);
      
        $path = $request->file('file')->getRealPath();

        $import = Excel::import(new EmployeesImportPreview, $path);

        return Response::json();
    }
}
