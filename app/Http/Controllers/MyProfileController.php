<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Account;
use App\User;
use App\Logs;
use Session;
use DB;

class MyProfileController extends Controller
{
    private $add = '';
    private $edit = '';
    private $delete = '';
    public function getaccount()// call for every function for security of the system
    { 
        if(Session::get('my_profile') == 'all'){
            $this->add = '';
            $this->edit = '';
            $this->delete = '';
        }
        elseif(Session::get('my_profile') == 'view'){
            $this->add = 'disabled';
            $this->edit = 'disabled';
            $this->delete = 'disabled';
        }
        elseif(Session::get('my_profile') == 'add'){
            $this->add = '';
            $this->edit = 'disabled';
            $this->delete = 'disabled';
        }
        elseif(Session::get('my_profile') == 'edit'){
            $this->add = '';
            $this->edit = '';
            $this->delete = 'disabled';
        }
        elseif(Session::get('my_profile') == 'delete'){
            $this->add = '';
            $this->edit = 'disabled';
            $this->delete = '';
        }else{
            $this->add = 'disabled';
            $this->edit = 'disabled';
            $this->delete = 'disabled';
        } 
    }
    public function __construct()
    {
        $this->middleware('auth');      
        $this->middleware(function($request, $next){
            if(Session::get("my_profile") == "none")
            {
                return redirect('error')->send();
            }
            else
            {
                return $next($request);
            }
        });     
    }
    //show view settings
    public function settings()
    {          
        return view('admin_modules.myprofile.settings');
    }
    //show information on settings
    public function settings_info()
    {
        $Account = '';
        $Account_info = '';
        $data = array();
        if(auth()->user()->user_type_id == "3" || auth()->user()->user_type_id == "8" || auth()->user()->user_type_id == "9")
        {
            $Account = DB::table('employer')
                    ->join('users', 'employer.id', '=', 'users.employer_id')
                    ->join('refprovince', 'employer.address_cityprovince', '=', 'refprovince.provCode')  
                    ->join('refcitymun', 'employer.address_town', '=', 'refcitymun.citymunCode')
                    ->join('refbrgy', 'employer.address_barangay', '=', 'refbrgy.id')       
                    ->select('employer.id',
                    'employer.business_name',
                    'employer.contact_mobile',
                    'employer.contact_email',
                    'employer.address_unit',
                    'refprovince.provDesc'
                    , 'refcitymun.citymunDesc', 'refbrgy.brgyDesc')
                    ->where('employer.id', '=', auth()->user()->employer_id)
                    ->get();
            $Account_info = DB::table('user_type')
                    ->join('users', 'user_type.id', '=', 'users.user_type_id')
                    ->select('user_type.type_name')
                    ->where('users.id', '=', auth()->user()->id)
                    ->get();
                
                if(!empty($Account_info))
                {
                    $info = $Account_info[0]->type_name;
                }
                else
                {
                    $info = "";
                }

                if(!empty($Account))
                {
                    $id = $Account[0]->id;
                    $shortname = $Account[0]->business_name;
                    $contact = $Account[0]->contact_mobile;
                    $email = $Account[0]->contact_email;
                    $unit = $Account[0]->address_unit;
                    $prov = $Account[0]->provDesc;
                    $mun = $Account[0]->citymunDesc;
                    $brgy = $Account[0]->brgyDesc;
                }
                else
                {
                    $id = "";
                    $shortname = "";
                    $contact = "";
                    $email = "";
                    $unit = "";
                    $prov ="";
                    $mun = "";
                    $brgy = "";            
                }

                $data = array(
                    'type_name'=>$info,           
                    'id'=>$id,
                    'shortname'=>$shortname,
                    'contact'=>$contact,
                    'email'=>$email,
                    'unit'=>$unit,
                    'prov'=>$prov,
                    'mun'=>$mun,
                    'brgy'=>$brgy
                );         
        }

        


        if(auth()->user()->user_type_id == "4")
        {
            $Account = DB::table('employee')
                    ->join('users', 'employee.id', '=', 'users.employee_id')
                    ->join('employee_personal_information', 'employee.employee_info', '=', 'employee_personal_information.id')
                    ->join('refprovince', 'employee_personal_information.province', '=', 'refprovince.provCode')  
                    ->join('refcitymun', 'employee_personal_information.citytown', '=', 'refcitymun.citymunCode')
                    ->join('refbrgy', 'employee_personal_information.barangay', '=', 'refbrgy.id')      
                    ->select('employee.id',
                            'employee_personal_information.mobile_no',
                            'employee_personal_information.email_add',
                            'employee_personal_information.address_unit',
                            // 'employee_personal_information.citytown',
                            // 'employee_personal_information.province',
                            // 'employee_personal_information.barangay',
                            'refprovince.provDesc',
                            'refcitymun.citymunDesc',
                            'refbrgy.brgyDesc')
                    ->where('users.employee_id', '=', auth()->user()->employee_id)
                    ->get();
                    
            $Account_info = DB::table('user_type')
                    ->join('users', 'user_type.id', '=', 'users.user_type_id')
                    ->select('user_type.type_name')
                    ->where('users.id', '=', auth()->user()->id)
                    ->get();
                
                if(!empty($Account_info))
                {
                    $info = $Account_info[0]->type_name;
                }
                else
                {
                    $info = "";
                }

                if(!empty($Account))
                {
                    $id = $Account[0]->id;
                    //$shortname = $Account[0]->business_name;
                    $contact = $Account[0]->mobile_no;
                    $email = $Account[0]->email_add;
                    $unit = $Account[0]->address_unit;
                    $prov = $Account[0]->provDesc;
                    $mun = $Account[0]->citymunDesc;
                    $brgy = $Account[0]->brgyDesc;
                }
                else
                {
                    $id = "";
                    $shortname = "";
                    $contact = "";
                    $email = "";
                    $unit = "";
                    $prov ="";
                    $mun = "";
                    $brgy = "";            
                }

                $data = array(
                    'type_name'=>$info,           
                    'id'=>$id,
                    //'shortname'=>$shortname,
                    'contact'=>$contact,
                    'email'=>$email,
                    'unit'=>$unit,
                    'prov'=>$prov,
                    'mun'=>$mun,
                    'brgy'=>$brgy
                );
        }

        echo json_encode($data);
    }
    //settings update
    public function settingsupdate_post(Request $request)
    {
        $this->getaccount();
        $id_to_update = $request->id;
        $email = $request->email;
        $contact = $request->contact;

        if($email == "-" || $contact == "-")
        {

        }
        else
        {
            $update_query = Account::find($id_to_update);

            $update_query->contact_mobile = $contact;
            $update_query->contact_email = $email;     
            $update_query->save();
        }
        
        $this->insert_log("Updated My Settings");
    }
    //show view change password
    public function changepassword()
    {
        return view('admin_modules.myprofile.changepassword');
        // return view('auth.passwords.reset');
    }
    //check current password
    public function checkcurpass(Request $request)
    {
        $old = $request->oldPass;
        // echo Hash::make($old);
        $oldPass = DB::table('users')
        ->select('password', 'id')
        ->where('id', '=', auth()->user()->id)
        ->get();

        if(!empty($oldPass))
        {
            if (Hash::check($old, $oldPass[0]->password)) 
            {
                echo "1";
            }
            else
            {
                echo "0";
            }
        }
    }
    //change password post
    public function changepassword_post(Request $request)
    {   
        $this->getaccount();   
        $newPassword = $request->newPass;

        $update_query = User::find(auth()->user()->id);

        $update_query->password = Hash::make($newPassword); 
        $update_query->updated_by = auth()->user()->id;
        $update_query->ischange = 0;     
        $update_query->save();    
        
        $this->insert_log("Change My Password");
    }
    // Method for inserting into logs
    public function insert_log($event)
    {
        $inserlog = new Logs;
        $inserlog->account_id = auth()->user()->id;
        $inserlog->log_event = $event;
        $inserlog->save();
    }
    //show view system logs
    public function systemlogs()
    {
        $system_logs = Logs::where('account_id', auth()->user()->id)->orderBy('created_at', 'DESC')->get();
        // $system_logs = DB::connection('mysql')->select("SELECT * FROM logs WHERE account_id = '".auth()->user()->id."' ORDER BY created_at DESC ");
        //$time_record = DTR::where('company_id', auth()->user()->company_id)->get();
        // $system_logs = Logs::all();
        return view('admin_modules.myprofile.systemlogs')->with('logs', $system_logs);
    }
}
