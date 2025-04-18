<?php

namespace App\Http\Controllers;

/**
 * @ Packages Facades
 * */
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


/**
 *  Insert Packages Here
 * */
use Keygen;
use Carbon\Carbon;


/**
 *  Insert Models Here
 * */
use App\Account;
use App\UserType;
use App\User;
use App\ESSBase;
use App\Logs;
use App\UserActivation;
use App\EmployerEnrollmentHistory;


/**
 * Laravel
 * */
use DB;
use Auth;
use Mail;
use Session;
use Response;




class AccountController extends Controller
{   
    private $add = '';
    private $edit = '';
    private $delete = '';
    public function getaccount()// call for every function for security of the system
    { 
        if(Session::get('create_profile') == 'all'){
            $this->add = '';
            $this->edit = '';
            $this->delete = '';
        }
        elseif(Session::get('create_profile') == 'view'){
            $this->add = 'disabled';
            $this->edit = 'disabled';
            $this->delete = 'disabled';
        }
        elseif(Session::get('create_profile') == 'add'){
            $this->add = '';
            $this->edit = 'disabled';
            $this->delete = 'disabled';
        }
        elseif(Session::get('create_profile') == 'edit'){
            $this->add = '';
            $this->edit = '';
            $this->delete = 'disabled';
        }
        elseif(Session::get('create_profile') == 'delete'){
            $this->add = '';
            $this->edit = 'disabled';
            $this->delete = '';
        }else{
            $this->add = 'disabled';
            $this->edit = 'disabled';
            $this->delete = 'disabled';
        } 
    }
    // Security Authentication
    public function __construct()
    {
        $this->middleware('auth', ['except' => array('UserActivation', 'ActivationPage', 'ActivateUser')]);
        $this->middleware('revalidate'); // Revalidate back history Security For Back Button
        $this->middleware(function($request, $next){
            if(Session::get("create_profile") == "none")
            {
                return redirect('error')->send();
            }
            else
            {
                return $next($request);
            }
        }); 
    }

    public function index()
    {
        $Account = DB::table('employer')
                        ->join('user_type', 'employer.user_type', '=', 'user_type.id')
                        ->join('users', 'employer.account_id', '=', 'users.id')
                        ->select('employer.id',
                         'employer.business_name',
                         'employer.accountname',
                         'employer.contact_email',
                         'employer.sec',
                         'employer.bir',
                         'user_type.type_name',
                         'users.AccountStatus',
                         'employer.account_id')
                         ->latest('employer.created_at')
                        ->get();
        return view('Account.index', compact('Account'));
    }

    public function get_all_account(Request $request){
        $Account = DB::table('employer')
                        ->join('user_type', 'employer.user_type', '=', 'user_type.id')
                        ->select('employer.id',
                        'employer.business_name',
                        'employer.accountname',
                        'employer.contact_email',
                        'employer.sec',
                        'employer.bir',
                        'user_type.type_name',
                        'employer.account_id')
                        ->latest('employer.created_at')
                        ->get();
                        
        if($request->ajax()){
            return json_encode($Account);
        }
        else {
            abort(404);
        }
        
    }

    public function create()
    {
        return view('Account.create');
    }

    public function store(Request $request)
    {
        $this->getaccount();
        $business_name = Input::get('business_name');
        /*Generate A Alphanumeric Characters for Password*/
        $password = Keygen::alphanum(10)->generate();

        // Custom Message
        $customMessages = [
            'required' => 'The :Attribute field is required.',
            'regex' => 'The :Attribute can only take Letters'
        ];

        /*Validate Request*/
        $this->validate($request, [
            'user_type' => 'required|min:3',
            'accountname' => 'required|unique:employer|min:3|regex:/^[\pL\s\-]+$/u',
            'business_name' => 'required|unique:employer|min:3|regex:/^[\pL\s\-]+$/u',
            'user_type' => 'required',
            'address_unit' => 'required|min:1|alpha_num',
            'address_country' => 'required|min:3',
            'address_town' => 'required|min:3',
            'address_cityprovince' => 'required|min:3',
            'address_barangay' => 'required|min:3',
            'address_zipcode' => 'required|min:3',
            'contact_person' => 'required|min:3|alpha',
            'contact_phone' => 'required|numeric|unique:employer',
            'contact_mobile' => 'required|numeric|regex:/(09)[0-9]{9}/|unique:employer|digits:11',
            'contact_email' => 'required|unique:employer|email',
            'sss' => 'required|unique:employer|numeric|min:3',
            'tin' => 'required|unique:employer|numeric|min:3',
            'phic' => 'required|unique:employer|numeric|min:3',
            'hdmf' => 'required|unique:employer|numeric|min:3',
            'nid' => 'required|unique:employer|numeric|min:3',
        ], $customMessages);

        // Handle File Upload
        if($request->hasFile('sec') && $request->hasFile('bir')){
            // Get filename with the extension
            $filenameWithExt_sec = $request->file('sec')->getClientOriginalName();
            $filenameWithExt_bir = $request->file('bir')->getClientOriginalName();
            // Get just filename
            $filename_sec = pathinfo($filenameWithExt_sec, PATHINFO_FILENAME);
            $filename_bir = pathinfo($filenameWithExt_bir, PATHINFO_FILENAME);
            // Get just ext
            $extension_sec = $request->file('sec')->getClientOriginalExtension();
            $extension_bir = $request->file('bir')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore_sec= $request->input('business_name').'_'.time().'_'.'SEC'.'.'.$extension_sec;
            $fileNameToStore_bir= $request->input('business_name').'_'.time().'_'.'BIR'.'.'.$extension_bir;
            // Upload Image
            $path_sec = $request->file('sec')->storeAs('public/Documents/sec', $fileNameToStore_sec);
            $path_bir = $request->file('bir')->storeAs('public/Documents/bir', $fileNameToStore_bir);
        } else {
            $fileNameToStore_sec = 'noifile.txt';
            $fileNameToStore_bir = 'noifile.txt';
        }

        

        if ($business_name == 'business_name'){
            /*Do Somethin or ....*/
        }
        else {
            // Parse Enrollment Date and Expiry Date
            $enrollment_date = Carbon::parse($request->enrollmentdate)->format('Y-m-d');
            $expiry_date = Carbon::parse($request->expirydate)->format('Y-m-d');
            $current = Carbon::now();
            $ed = Carbon::parse($request->expirydate);
            $res = $current->diffInDays($ed);


            /*Check if All Request is not null*/
            if($request->all() != null && $request->has([
                'business_name',
                'accountname',
                'user_type',
                'address_unit',
                'address_country',
                'address_town',
                'address_cityprovince',
                'address_barangay',
                'address_zipcode',
                'contact_person',
                'contact_phone',
                'contact_mobile',
                'contact_email',
                'tin',
                'sss',
                'phic',
                'hdmf',
                'nid',
            ])){


                $activation_code = $this->generateActivationCode();
                $activation_id = $this->generateUserActivationId();



                /*Check if the request is Employer*/
                if ($request->input('user_type') == 3){
                    /*Create Account Employer*/
                    $employer = Account::create([
                        // Array Fields Here
                        //'account_id' => $Account_id,
                        'business_name' => $request->input('business_name'),
                        'accountname' => $request->input('accountname'),
                        'user_type' => $request->input('user_type'),
                        'address_unit' => $request->input('address_unit'),
                        'address_country' => $request->input('address_country'),
                        'address_town' => $request->input('address_town'),
                        'address_cityprovince' => $request->input('address_cityprovince'),
                        'address_barangay' => $request->input('address_barangay'),
                        'address_zipcode' => $request->input('address_zipcode'),
                        'contact_person' => $request->input('contact_person'),
                        'contact_phone' => $request->input('contact_phone'),   
                        'contact_mobile' => $request->input('contact_mobile'),
                        'contact_email' => $request->input('contact_email'),
                        'tin' =>$request->input('tin'),
                        'sss' => $request->input('sss'),
                        'phic' => $request->input('phic'),
                        'hdmf' => $request->input('hdmf'),
                        'nid' => $request->input('nid'),
                        'sec' => $fileNameToStore_sec,
                        'bir' => $fileNameToStore_bir,
                        'enrollment_date' => $enrollment_date,
                        'expiry_date' => $expiry_date
                    ]);

                    $employer_id = $employer->id;

                }
                if ($request->input('user_type') == 8){
                    /*Create Account Employer*/
                    $employer = Account::create([
                        // Array Fields Here
                        //'account_id' => $Account_id,
                        'business_name' => $request->input('business_name'),
                        'accountname' => $request->input('accountname'),
                        'user_type' => $request->input('user_type'),
                        'address_unit' => $request->input('address_unit'),
                        'address_country' => $request->input('address_country'),
                        'address_town' => $request->input('address_town'),
                        'address_cityprovince' => $request->input('address_cityprovince'),
                        'address_barangay' => $request->input('address_barangay'),
                        'address_zipcode' => $request->input('address_zipcode'),
                        'contact_person' => $request->input('contact_person'),
                        'contact_phone' => $request->input('contact_phone'),   
                        'contact_mobile' => $request->input('contact_mobile'),
                        'contact_email' => $request->input('contact_email'),
                        'tin' =>$request->input('tin'),
                        'sss' => $request->input('sss'),
                        'phic' => $request->input('phic'),
                        'hdmf' => $request->input('hdmf'),
                        'nid' => $request->input('nid'),
                        'sec' => $fileNameToStore_sec,
                        'bir' => $fileNameToStore_bir,
                        'enrollment_date' => $enrollment_date,
                        'expiry_date' => $expiry_date
                    ]);

                    $employer_id = $employer->id;

                }
                if ($request->input('user_type') == 9){
                    /*Create Account Employer*/
                    $employer = Account::create([
                        // Array Fields Here
                        //'account_id' => $Account_id,
                        'business_name' => $request->input('business_name'),
                        'accountname' => $request->input('accountname'),
                        'user_type' => $request->input('user_type'),
                        'address_unit' => $request->input('address_unit'),
                        'address_country' => $request->input('address_country'),
                        'address_town' => $request->input('address_town'),
                        'address_cityprovince' => $request->input('address_cityprovince'),
                        'address_barangay' => $request->input('address_barangay'),
                        'address_zipcode' => $request->input('address_zipcode'),
                        'contact_person' => $request->input('contact_person'),
                        'contact_phone' => $request->input('contact_phone'),   
                        'contact_mobile' => $request->input('contact_mobile'),
                        'contact_email' => $request->input('contact_email'),
                        'tin' =>$request->input('tin'),
                        'sss' => $request->input('sss'),
                        'phic' => $request->input('phic'),
                        'hdmf' => $request->input('hdmf'),
                        'nid' => $request->input('nid'),
                        'sec' => $fileNameToStore_sec,
                        'bir' => $fileNameToStore_bir,
                        'enrollment_date' => $enrollment_date,
                        'expiry_date' => $expiry_date
                    ]);

                    $employer_id = $employer->id;


                }
            }
            /*
            DB::table('user_picture')->insert([
                'user_id' => $employer->id,
                'employer_id' => $employer->id,
                'profile_picture' => "ESS_male1.png",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
             ]);
            */
            /*Email Template*/
            // $mail_template = DB::table('notification')
            //                 ->where('id', 31)
            //                 ->where('notification_type', 1)
            //                 ->select('notification_message')
            //                 ->first();


            // $activation_link = "http://127.0.0.1:8000/Account/Activation/".$activation_id;


            // // Replace All The String in the Notification Message
            // $search = ["name", "username", "url", "password"];
            // $replace = [$user->name, $user->name, "<a href=".$activation_link.">Click Here</a>", $password];                
            // $template_result = str_replace($search, $replace, $mail_template->notification_message); 
                             

            // /*Send Mail */
            // $data = array('username' => $user->name, "password" => $password, "template" => $template_result);

            // Mail::send('Email.mail', $data, function($message) use($employer, $user, $mail_template){
            //     $message->to($employer->contact_email, $employer->business_name)
            //             ->subject("ESS Successfully Registered ");
            //     $message->from('esssample@gmail.com', "ESS");
            // });

            $msg = 'Success';

            $this->insert_log("Create Account");

            // return redirect('Account')->with('success', 'Account Successfully Created');
            return Response::json($msg);
        }
        

        
    }

    public function edit($id){
        
        if(!Account::where('id', '!=', $id)){
            abort(404);
        }
        else {
           if(!Account::where('id', '=', $id)->count() > 0){
                abort(404);
           }
           else {
               if(User::where('employer_id', '=', $id)->count() > 0){
                $check_user = true;
                $Account = DB::table('employer')
                            ->join('user_type', 'employer.user_type', '=', 'user_type.id')
                            ->join('refprovince', 'employer.address_cityprovince', '=', 'refprovince.provCode')
                            ->join('refcitymun', 'employer.address_town', '=', 'refcitymun.citymunCode')
                            ->join('refbrgy', 'employer.address_barangay', '=', 'refbrgy.id')    
                            ->join('users', 'employer.id', '=', 'users.employer_id')
                            ->select('employer.id', 'employer.business_name',
                            'employer.accountname',
                            'employer.address_unit',
                            'employer.address_cityprovince',
                            'employer.address_barangay',
                            'employer.address_zipcode',
                            'employer.contact_email', 
                            'employer.contact_person', 
                            'employer.contact_phone',
                            'employer.contact_mobile',
                            'employer.tin',
                            'employer.sss',
                            'employer.phic',
                            'employer.hdmf',
                            'employer.nid',
                            'employer.sec', 'employer.bir', 
                            'employer.enrollment_date',
                            'employer.expiry_date',
                            'user_type.type_name', 
                            'user_type.id as user_type_id',
                            'employer.account_id',
                            'refprovince.provDesc',
                            'refprovince.provCode',
                            'refcitymun.citymunDesc',
                            'refcitymun.citymunCode',
                            'refbrgy.brgyDesc',
                            'refbrgy.id as refbrgy_id',
                            'users.username'
                            )
                            ->where('employer.id', $id)
                            ->get();
               }
               else {
                $check_user = false;
                $Account = DB::table('employer')
                            ->join('user_type', 'employer.user_type', '=', 'user_type.id')
                            ->join('refprovince', 'employer.address_cityprovince', '=', 'refprovince.provCode')
                            ->join('refcitymun', 'employer.address_town', '=', 'refcitymun.citymunCode')
                            ->join('refbrgy', 'employer.address_barangay', '=', 'refbrgy.id')    
                            ->select('employer.id', 'employer.business_name',
                            'employer.accountname',
                            'employer.address_unit',
                            'employer.address_cityprovince',
                            'employer.address_barangay',
                            'employer.address_zipcode',
                            'employer.contact_email', 
                            'employer.contact_person', 
                            'employer.contact_phone',
                            'employer.contact_mobile',
                            'employer.tin',
                            'employer.sss',
                            'employer.phic',
                            'employer.hdmf',
                            'employer.nid',
                            'employer.sec', 'employer.bir', 
                            'employer.enrollment_date',
                            'employer.expiry_date',
                            'user_type.type_name', 
                            'user_type.id as user_type_id',
                            'employer.account_id',
                            'refprovince.provDesc',
                            'refprovince.provCode',
                            'refcitymun.citymunDesc',
                            'refcitymun.citymunCode',
                            'refbrgy.brgyDesc',
                            'refbrgy.id as refbrgy_id'
                            )
                            ->where('employer.id', $id)
                            ->get();
               }
                
            return view('Account.edit', compact('Account', 'check_user'));
           }
        }
        
    }

    public function update(Request $request, $id){
        $this->getaccount();
         // Custom Message
         $customMessages = [
            'required' => 'The :Attribute field is required.',
            'regex' => 'The :Attribute can only take Letters'
        ];
        /*Validate Request*/
        $this->validate($request, [
            'user_type' => 'required|min:3',
            'accountname' => 'required|min:3|regex:/^[\pL\s\-]+$/u|unique:employer,accountname,'.$id,
            'business_name' => 'required|min:3|regex:/^[\pL\s\-]+$/u|unique:employer,business_name,'.$id,
            'user_type' => 'required',
            'address_unit' => 'required|min:1|alpha_num',
            'address_country' => 'required|min:3',
            'address_town' => 'required|min:3',
            'address_cityprovince' => 'required|min:3',
            'address_barangay' => 'required|min:3',
            'address_zipcode' => 'required|min:3',
            'contact_person' => 'required|min:3|regex:/^[\pL\s\-]+$/u|',
            'contact_phone' => 'required|numeric|unique:employer,contact_phone,'.$id,
            'contact_mobile' => 'required|numeric|regex:/(09)[0-9]{9}/|digits:11|unique:employer,contact_mobile,'.$id,
            'contact_email' => 'required|email|unique:employer,contact_email,'.$id,
            'sss' => 'required|min:3|numeric|unique:employer,sss,'.$id,
            'tin' => 'required|min:3|numeric|unique:employer,tin,'.$id,
            'phic' => 'required|min:3|numeric|unique:employer,phic,'.$id,
            'hdmf' => 'required|min:3|numeric|unique:employer,hdmf,'.$id,
            'nid' => 'required|min:3|numeric|unique:employer,nid,'.$id,
        ]);

        $enrollment_date = Carbon::parse($request->enrollmentdate)->format('Y-m-d');
        $expiry_date = Carbon::parse($request->expirydate)->format('Y-m-d');

        // Handle File Upload
         if($request->hasFile('sec')){
            // Get filename with the extension
            $filenameWithExt_sec = $request->file('sec')->getClientOriginalName();
            // Get just filename
            $filename_sec = pathinfo($filenameWithExt_sec, PATHINFO_FILENAME);
            // Get just ext
            $extension_sec = $request->file('sec')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore_sec= $filename_sec.'_'.time().'.'.$extension_sec;
            // Upload Image
            $path_sec = $request->file('sec')->storeAs('public/Documents/sec', $fileNameToStore_sec);

            //Deleting old sec file after user update
            $query_sec_file = DB::table('employer')->where('id','=',$id)
                        ->select('sec')
                        ->first();
            
            $old_sec_file = $query_sec_file->sec;
            Storage::delete('public/Documents/sec/'.$old_sec_file);
       
            /*Update Account Employer*/
            DB::table('employer')->where('id', '=', $id)
                                ->update(array(
                                    'business_name' => $request->input('business_name'),
                                    'accountname' => $request->input('accountname'),
                                    'user_type' => $request->input('user_type'),
                                    'address_unit' => $request->input('address_unit'),
                                    'address_country' => $request->input('address_country'),
                                    'address_town' => $request->input('address_town'),
                                    'address_cityprovince' => $request->input('address_cityprovince'),
                                    'address_barangay' => $request->input('address_barangay'),
                                    'address_zipcode' => $request->input('address_zipcode'),
                                    'contact_person' => $request->input('contact_person'),
                                    'contact_phone' => $request->input('contact_phone'),   
                                    'contact_mobile' => $request->input('contact_mobile'),
                                    'contact_email' => $request->input('contact_email'),
                                    'tin' =>$request->input('tin'),
                                    'sss' => $request->input('sss'),
                                    'phic' => $request->input('phic'),
                                    'hdmf' => $request->input('hdmf'),
                                    'nid' => $request->input('nid'),
                                    'sec' => $fileNameToStore_sec,
                                    'expiry_date' => $expiry_date
            ));

            

            DB::table('users')->where('username', '=', $request->ess_id)
                                ->update(array(
                                    'enrollment_date' => $enrollment_date,
                                    'expiry_date' => $expiry_date,
                                ));
        }
        elseif($request->hasFile('bir')) {
             // Get filename with the extension
             $filenameWithExt_bir = $request->file('bir')->getClientOriginalName();
             // Get just filename
             $filename_bir = pathinfo($filenameWithExt_bir, PATHINFO_FILENAME);
             // Get just ext
             $extension_bir = $request->file('bir')->getClientOriginalExtension();
             // Filename to store
             $fileNameToStore_bir= $filename_bir.'_'.time().'.'.$extension_bir;
             // Upload Image
             $path_bir = $request->file('bir')->storeAs('public/Documents/bir', $fileNameToStore_bir);
             
             //Deleting old BIR file after user update
             $query_bir_file = DB::table('employer')->where('id','=',$id)
                            ->select('bir')
                            ->first();

             $old_bir_file = $query_bir_file->bir;
             Storage::delete('public/Documents/bir/'.$old_bir_file);

             /*Update Account Employer*/
             DB::table('employer')->where('id', '=', $id)
                                 ->update(array(
                                     'business_name' => $request->input('business_name'),
                                     'accountname' => $request->input('accountname'),
                                     'user_type' => $request->input('user_type'),
                                     'address_unit' => $request->input('address_unit'),
                                     'address_country' => $request->input('address_country'),
                                     'address_town' => $request->input('address_town'),
                                     'address_cityprovince' => $request->input('address_cityprovince'),
                                     'address_barangay' => $request->input('address_barangay'),
                                     'address_zipcode' => $request->input('address_zipcode'),
                                     'contact_person' => $request->input('contact_person'),
                                     'contact_phone' => $request->input('contact_phone'),   
                                     'contact_mobile' => $request->input('contact_mobile'),
                                     'contact_email' => $request->input('contact_email'),
                                     'tin' =>$request->input('tin'),
                                     'sss' => $request->input('sss'),
                                     'phic' => $request->input('phic'),
                                     'hdmf' => $request->input('hdmf'),
                                     'nid' => $request->input('nid'),
                                     'bir' => $fileNameToStore_bir,
                                     'expiry_date' => $expiry_date
             ));
 
             
 
             DB::table('users')->where('username', '=', $request->ess_id)
                                 ->update(array(
                                     'enrollment_date' => $enrollment_date,
                                     'expiry_date' => $expiry_date,
                                 ));
        }
        elseif($request->hasFile('bir') && $request->hasFile('sec')) {
             // Get filename with the extension
             $filenameWithExt_sec = $request->file('sec')->getClientOriginalName();
             $filenameWithExt_bir = $request->file('bir')->getClientOriginalName();
             // Get just filename
             $filename_sec = pathinfo($filenameWithExt_sec, PATHINFO_FILENAME);
             $filename_bir = pathinfo($filenameWithExt_bir, PATHINFO_FILENAME);
             // Get just ext
             $extension_sec = $request->file('sec')->getClientOriginalExtension();
             $extension_bir = $request->file('bir')->getClientOriginalExtension();
             // Filename to store
             $fileNameToStore_sec= $filename_sec.'_'.time().'.'.$extension_sec;
             $fileNameToStore_bir= $filename_bir.'_'.time().'.'.$extension_bir;
             // Upload Image
             $path_sec = $request->file('sec')->storeAs('public/Documents/sec', $fileNameToStore_sec);
             $path_bir = $request->file('bir')->storeAs('public/Documents/bir', $fileNameToStore_bir);
             
             //Deleting old BIR file after user update
             $query_files = DB::table('employer')->where('id','=',$id)
                            ->select('bir', 'sec')
                            ->first();

             $old_bir_file = $query_files->bir;
             Storage::delete('public/Documents/bir/'.$old_bir_file);
             $old_sec_file = $query_files->sec;
            Storage::delete('public/Documents/sec/'.$old_sec_file);

             /*Update Account Employer*/
             DB::table('employer')->where('id', '=', $id)
                                 ->update(array(
                                     'business_name' => $request->input('business_name'),
                                     'accountname' => $request->input('accountname'),
                                     'user_type' => $request->input('user_type'),
                                     'address_unit' => $request->input('address_unit'),
                                     'address_country' => $request->input('address_country'),
                                     'address_town' => $request->input('address_town'),
                                     'address_cityprovince' => $request->input('address_cityprovince'),
                                     'address_barangay' => $request->input('address_barangay'),
                                     'address_zipcode' => $request->input('address_zipcode'),
                                     'contact_person' => $request->input('contact_person'),
                                     'contact_phone' => $request->input('contact_phone'),   
                                     'contact_mobile' => $request->input('contact_mobile'),
                                     'contact_email' => $request->input('contact_email'),
                                     'tin' =>$request->input('tin'),
                                     'sss' => $request->input('sss'),
                                     'phic' => $request->input('phic'),
                                     'hdmf' => $request->input('hdmf'),
                                     'nid' => $request->input('nid'),
                                     'sec' => $fileNameToStore_sec,
                                     'bir' => $fileNameToStore_bir,
                                     'expiry_date' => $expiry_date
             ));
 
             
 
             DB::table('users')->where('username', '=', $request->ess_id)
                                 ->update(array(
                                     'enrollment_date' => $enrollment_date,
                                     'expiry_date' => $expiry_date,
                                 ));
        }

        /*Update Account Employer*/
        DB::table('employer')->where('id', '=', $id)
                            ->update(array(
                                'business_name' => $request->input('business_name'),
                                'accountname' => $request->input('accountname'),
                                'user_type' => $request->input('user_type'),
                                'address_unit' => $request->input('address_unit'),
                                'address_country' => $request->input('address_country'),
                                'address_town' => $request->input('address_town'),
                                'address_cityprovince' => $request->input('address_cityprovince'),
                                'address_barangay' => $request->input('address_barangay'),
                                'address_zipcode' => $request->input('address_zipcode'),
                                'contact_person' => $request->input('contact_person'),
                                'contact_phone' => $request->input('contact_phone'),   
                                'contact_mobile' => $request->input('contact_mobile'),
                                'contact_email' => $request->input('contact_email'),
                                'tin' =>$request->input('tin'),
                                'sss' => $request->input('sss'),
                                'phic' => $request->input('phic'),
                                'hdmf' => $request->input('hdmf'),
                                'nid' => $request->input('nid'),
                                'expiry_date' => $expiry_date
                            ));
        /*Create Employer Enrollment History*/
        $employment_history = EmployerEnrollmentHistory::create([
                    'account_id' => $id,
                    'enrollment_date' => $enrollment_date,
                    'expiry_date' => $expiry_date,
                    'created_by' => auth()->user()->id,
                    'updated_by' => auth()->user()->id,
        ]);
                            
        DB::table('users')->where('username', '=', $request->ess_id)
                            ->update(array(
                                'enrollment_date' => $enrollment_date,
                                'expiry_date' => $expiry_date,
                            ));

        $msg = 'Success';


        $this->insert_log("Updated Account ");

        return Response::json($msg);
    }

    public function destroy(Request $request){
        $this->getaccount();
        $Account_id = $request->id;
        /*Delete User From Employer*/
        $employer = Account::where('id','=', $Account_id)->delete();


        return response()->json(array(
            $employer,
        ));

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

    public function get_user_type(Request $request){
        /*Get All Type Name Where Id = 3 => Employer, 8 => Merchant, 9 => Agent*/
        
        if(auth()->user()->user_type_id === 1) {
            $query = DB::table('user_type')->select('id', 'type_name')->whereIn('id', array(3, 8, 9))->get();
        }
        /*Protection for Data View as Json*/
        if($request->ajax()){
            return Response::json($query);
        }
        else {
            abort(404);
        }
    }

    /*Generate a Users Password*/
    public function generate_password($limit)
    {
        return substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $limit);
    }

    // Method for inserting into logs
    public function insert_log($event)
    {
        $inserlog = new Logs;
        $inserlog->account_id = auth()->user()->id;
        $inserlog->log_event = $event;
        $inserlog->save();
    }

    // Update Account Status
    public function UpdateAccountStatus(Request $request, $id){
        $this->getaccount();

        /*Update Account Employer*/
        DB::table('users')->where('id', '=', $id)
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

    public function get_all_employer(Request $request){

        $Account = Account::where('business_name', 'LIKE', $request->q.'%')->get();
        return response()->json($Account);
                    
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

        /* Ensure the user activation id is unique to the user*/
        while(UserActivation::where('user_activation_id', $user_activation_id)->count() > 0){
            $user_activation_id = Keygen::length(11)->alphanum()->generate();
        }

        return $user_activation_id;
    }

    /*This Code will send to mobile*/
    protected function generateActivationCode(){
        $user_activation_code = Keygen::numeric(5)->prefix(mt_rand(1, 9))->generate(true);

        /*Ensure the user activation code is unique*/
        while(UserActivation::where('activation_code', $user_activation_code)->count() > 0){
            $user_activation_code = Keygen::numeric(5)->prefix(mt_rand(1, 9))->generate(true);
        }

        return $user_activation_code;
    }

    /**
     * Activate User Via code
     * */
    public function ActivationPage(Request $request)
    {

        return view('Account.activationpage');
    }

    /**
     * @ Activate User Via Code
     * */
    public function ActivateUser(Request $request){
        
        /**
         *  Custom Validaiton Messages
         * */
        $messages = [
            'exists'    => 'The :attribute is invalid.',
        ];

        /**
         *  Validate Request
         * */
        $this->validate($request, [
            'username' => 'required|alpha_num|exists:users',
            'activation_code' => 'required|min:6|numeric|exists:user_activation,activation_code'
        ], $messages);

        /** 
         * Get Username ID Or User ID 
         * 
         */
        $get_user_id = User::where('username', '=', $request->input('username'))->pluck('id');

        /**
         *  Get Activation Code
         * */
        $get_activation_code = UserActivation::where('activation_code', '=', $request->input('activation_code'))->pluck('account_id');
        

        /**
         * @ Check if the User Id is not Null
         * */

         if(!empty($get_user_id))
         {
            /**
             * @ Check if the Username ID and Activation Code Account Id is Match
             * */
            if($get_user_id == $get_activation_code)
            {
               
                /**
                 * @ Check if the Code is Expired
                 * */
                $get_activation_code_expiration_date = UserActivation::where('activation_code', '=', $request->input('activation_code'))->first();
                $get_user_expiration_date = User::where('username', '=', $request->input('username'))->first();
                if(Carbon::parse($get_activation_code_expiration_date->expiration_date)->isPast())
                {
                    return back()->with('error', 'Code Expired');
                }
                else
                {

                     /**
                     * @ Check if the User is Already Activated
                     * */
                    if($get_user_expiration_date->email_verified_at != null)
                    {
                        return back()->with('error', 'Account Already Activated');
                    }
                    else
                    {
                        /**
                         * @ Activation User Account
                         * */
                    $activate_user = DB::table('users')
                                        ->where('id', '=', $get_user_id)
                                        ->update(array(
                                        'email_verified_at' => Carbon::now(),
                                    ));
                        return redirect('login')->with('success', 'Account Successfully Activated You can now Log in');
                    }
                    
                }

                 
            }
            /**
             *  Check if the User id is not match and Activation Code
             * */
            elseif($get_user_id != $get_activation_code) {
                return back()->with('error', 'Activation Code is Invalid');
            }
         }


        //return back();

    }

    /*Activate User*/ 
    protected function UserActivation(Request $request, $id){
        $account_id = UserActivation::where('user_activation_id', '=', $id)->pluck('account_id');
        
        if($id != null){
            
            if(empty($account_id)){
                abort(404);
            }
            else {
                if(!UserActivation::where('user_activation_id', '!=', $id)->count() > 0){
                    abort(404);
                }
                else {
                    if(!UserActivation::where('user_activation_id', '=', $id)->count() > 0) {
                        abort(404);
                    }
                    else {
                        $user = User::where('id', '=', $account_id)->first();
                        $updated_at = $user->updated_at;
                        $expiry_date = $user->expiry_date;
                        
                        $current = Carbon::now();
                        $ed = Carbon::parse($user->expiry_date);
                        $res = $current->diffInDays($ed);
                        $account_expiry_at = Carbon::parse($updated_at)->addDays($res);
                        // Check if the Account is Expired
                        if($account_expiry_at->isPast()) {
                            if($user->expiry_date) {
                                // return 'Link Expired';
                                return redirect('login')->with('error', 'Link Expired');
                            }
                            elseif($user->expiry_date != null) {
                                //return 'Account Already Activated'. $user->id;
                                return redirect('login')->with('error', 'Account Already Activated');
                            }
                            
                        }
                        else {
                            // Check if the Account is not yet Activated
                            if($user->email_verified_at == "") {
                                // Check if the User Is Logged In
                                if(Auth::check()){
                                    abort(404);
                                }
                                else {
                                    $activate_user = DB::table('users')
                                            ->where('id', '=', $account_id)
                                            ->update(array(
                                                'email_verified_at' => Carbon::now(),
                                            ));
                                    //return 'Successfully Activated';
                                    return redirect('login')->with('success', 'Account Successfully Activated You can now Log in');
                                }
                            }
                            elseif ($user->email_verified_at != "") {
                                return redirect('login')->with('error', 'Account Already Activated');
                            }
                        }
                        
                    }
                }
            }
           
        }
        
    }

    
}
