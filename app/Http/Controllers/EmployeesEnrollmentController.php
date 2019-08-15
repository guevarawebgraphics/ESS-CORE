<?php

namespace App\Http\Controllers;

/**
 * @ Packages Facades
 *  */
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
                'employee_no' => ['required','min:5','numeric', Rule::unique('employee')->where((function ($query) use ($request){
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
                    'name' => $request->input('lastname') . ", " . $request->input('firstname') . ", " . $request->input('middlename'),
                    'username' => $employee_ess_id,
                    'password' => Hash::make($password),
                    'expiry_date' => Carbon::now()->addCentury(), // Default for 1 Century
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
                    'password' => $password,
                    'mobile_no' => $request->input('mobile_no'),
                    'user_activation_id' => $useractivation_id
                );


            /*Email Template*/
            $mail_template = DB::table('notification')
                            //->where('employer_id', auth()->user()->id)
                            ->where('employer_id', auth()->user()->employer_id)
                            ->where('notification_type', 1)
                            ->select('notification_message')
                            ->first();
            
            // Enviroment Variable
            $enviroment = config('app.url');


            $activation_link = $enviroment."/Account/Activation/".$useractivation_id;


            // Replace All The String in the Notification Message
            $search = ["name", "username", "mobile", "url", "password"];
            $replace = [$user->name, $user->name, $request->input('mobile_no'), "<a href=".$activation_link.">Click Here</a>", $password];                
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
                'employee_no' => 'required|min:5|unique:employee',
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
            'employee_no' => 'required|numeric|min:5|unique:employee,employee_no,'.$request->input('employee_id'),
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
}
