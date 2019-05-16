<?php

namespace App\Http\Controllers\Auth;

use DB;
use Session;
use App\User;
use App\Logs;
use App\ESSBase;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $add = '';
    private $edit = '';
    private $delete = '';
    public function getaccount()// call for every function for security of the system
    { 
        if(Session::get('manage_users') == 'all'){
            $this->add = '';
            $this->edit = '';
            $this->delete = '';
        }
        elseif(Session::get('manage_users') == 'view'){
            $this->add = 'disabled';
            $this->edit = 'disabled';
            $this->delete = 'disabled';
        }
        elseif(Session::get('manage_users') == 'add'){
            $this->add = '';
            $this->edit = 'disabled';
            $this->delete = 'disabled';
        }
        elseif(Session::get('manage_users') == 'edit'){
            $this->add = '';
            $this->edit = '';
            $this->delete = 'disabled';
        }
        elseif(Session::get('manage_users') == 'delete'){
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
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */

    public function register(Request $request)
    {
        $this->getaccount();
        $username = $request->input('username');       
        $check_username = DB::connection('mysql')->select("SELECT username FROM users WHERE username = '$username' ");

        if(count($check_username) > 0)
        {
            echo json_encode("taken");
        }
        else
        {
            echo json_encode("suc");
            event(new Registered($user = $this->create($request->all())));
            //return Redirect::to(URL::previous() . '/');
        }          
    }

    protected function create(array $data)
    {
        $this->getaccount();
        $user_type_for = "";
        $counter = 0;
        $check_type = DB::connection('mysql')->select("SELECT id,user_type_for FROM user_type WHERE id = '".auth()->user()->user_type_id."' " );
        if(!empty($check_type))
        {
            if($check_type[0]->user_type_for == "1" || $check_type[0]->user_type_for == "2")
            {
                $user_type_for = "2";
            }
            else if($check_type[0]->user_type_for == "3" || $check_type[0]->user_type_for == "4")
            {
                $user_type_for = "4";
                $counter++;
            }
            else if($check_type[0]->user_type_for == "5" || $check_type[0]->user_type_for == "6")
            {
                $user_type_for = "6";
            }
        }
        
        // $user = User::create([
        //     'name' => $data['name'],
        //     'user_type_id' => $data['cmbUser_type'],
        //     'username' => $data['username'],       
        //     'user_type_for' => $user_type_for,
        //     'employer_id' => "none",     
        //     'password' => Hash::make($data['password']),
        //     'created_by' => auth()->user()->id,
        //     'updated_by' => auth()->user()->id
        // ]);

        // $id = $user->id;
        
        // if($counter > 0)
        // {
        //     DB::table('users')->where('id', '=', $id)
        //     ->update(array(
        //         'employer_id' => Session::get("employer_id")
        //     )); 
        // }
        //echo $data['cmbEmployer'];

        DB::table('users')->where('id', '=', $data['hidden_account_id'])
            ->update(array(
                'name' => $data['name'],
                //'user_type_id' => $data['cmbUser_type'],
                'username' => $data['username'],       
                //'user_type_for' => $user_type_for,
                'employer_id' => $data['cmbEmployer'],     
                'password' => Hash::make($data['password']),
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
        ));

        //Inserting into ESS BASE TABLE
        $insert_ess = new ESSBase;
        $insert_ess->account_id = $data['hidden_account_id'];
        $insert_ess->employer_id = $data['cmbEmployer'];
        $insert_ess->ess_id = $data['username'];
        $insert_ess->user_type_id = $data['cmbUser_type'];            
        $insert_ess->created_by = auth()->user()->id;
        $insert_ess->updated_by = auth()->user()->id;
        $insert_ess->save();

        $this->insert_log("Created '". $data['username'] ."' User Account");
            
    }

    //update user 
    public function updateuser_post(Request $request)
    {
        $this->getaccount();
        $userId = $request->id;
        $name = $request->name;
        $userName = $request->userName;
        $userType = $request->userType;
        //$password = $request->password;  
           
        $update_query = User::find($userId);
        $update_query->name = $name;
        $update_query->user_type_id = $userType;
        $update_query->username = $userName;
        //$update_query->password = Hash::make($password);
        $update_query->updated_by = auth()->user()->id;
        $update_query->save();
        $update_username = $update_query->username;

        $this->insert_log("Updated '". $update_username ."' User Account");                  
    }
    //reset_password
    public function reset_password(Request $request)
    {
        $this->getaccount();
        $userId = $request->id;
        $password = $request->password;

        if($userId == "" && $password == "")
        {
            echo "No Input";
        }
        else
        {
            $update_query = User::find($userId);
            $update_query->password = Hash::make($password);
            $update_query->updated_by = auth()->user()->id;
            $update_query->save();
    
            $update_username = $update_query->username;
    
            $this->insert_log("Reset Password of '". $update_username ."' User Account");      
        }
         
    }
    //check username
    public function checkusername(Request $request)
    {
        $userName = $request->userName;
        $count = 0;
        
        $check_username = DB::connection('mysql')->select("SELECT username FROM users WHERE username = '$userName' ");
        if(count($check_username) > 0)
        {
            echo "taken";
        }
        else
        {
            echo "not";
        }

        // if($count > 0)
        // {
        //     echo "taken";
        // }
        // else
        // {
        //     echo "suc";
        // }
    }
    // Method for inserting into logs
    public function insert_log($event)
    {
        $inserlog = new Logs;
        $inserlog->account_id = auth()->user()->id;
        $inserlog->log_event = $event;
        $inserlog->save();
    }
}
