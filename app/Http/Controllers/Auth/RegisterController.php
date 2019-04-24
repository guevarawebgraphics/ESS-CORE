<?php

namespace App\Http\Controllers\Auth;

use DB;
use Session;
use App\User;
use App\Logs;
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
        $this->insert_log("Created new user");
        $user = User::create([
            'name' => $data['name'],
            'user_type_id' => $data['cmbUser_type'],
            'username' => $data['username'],       
            'user_type_for' => $user_type_for,
            'employer_id' => "default",     
            'password' => Hash::make($data['password']),
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id
        ]);

        $id = $user->id;
        
        if($counter > 0)
        {
            DB::table('users')->where('id', '=', $id)
            ->update(array(
                'employer_id' => Session::get("employer_id")
            )); 
        }
            
    }

    public function updateuser_post(Request $request)
    {
        $userId = $request->id;
        $name = $request->name;
        $userName = $request->userName;
        $userType = $request->userType;
        $password = $request->password;

        $check_username = DB::connection('mysql')->select("SELECT username FROM users WHERE username = '$userName' ");

        if(count($check_username) > 0)
        {
            echo json_encode("taken");
        }
        else
        {
            echo json_encode("suc");
            $update_query = User::find($userId);
            $update_query->name = $name;
            $update_query->user_type_id = $userType;
            $update_query->username = $userName;
            $update_query->password = Hash::make($password);
            $update_query->updated_by = auth()->user()->id;
            $update_query->save();

            $this->insert_log("Updated user");
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
}
