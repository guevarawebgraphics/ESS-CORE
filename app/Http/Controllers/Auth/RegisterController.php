<?php

namespace App\Http\Controllers\Auth;

use DB;
use App\User;
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
    protected $redirectTo = '/home';

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
        return User::create([
            'name' => $data['name'],
            'user_type_id' => $data['cmbUser_type'],
            'username' => $data['username'],            
            'password' => Hash::make($data['password']),
            'created_by' => auth()->user()->name,
            'updated_by' => auth()->user()->name
        ]);
    }
}
