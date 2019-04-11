<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;

class MyProfileController extends Controller
{
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
        $Account = '';
        if(auth()->user()->user_type_id == "3")
        {
            $Account = DB::table('employer')
            ->join('users', 'employer.id', '=', 'users.ess_id')
            ->join('refprovince', 'employer.address_cityprovince', '=', 'refprovince.provCode')  
            ->join('refcitymun', 'employer.address_town', '=', 'refcitymun.citymunCode')
            ->join('refbrgy', 'employer.address_barangay', '=', 'refbrgy.id')             
            ->select('employer.id', 'employer.shortname', 'employer.contact_mobile', 'employer.contact_email', 'employer.address_unit','refprovince.provDesc'
            , 'refcitymun.citymunDesc', 'refbrgy.brgyDesc')
            ->get();
        }
        else
        {
            $Account = "";
        }
        
        return view('admin_modules.myprofile.settings')->with('info', $Account);
    }
    //show view change password
    public function changepassword()
    {
        return view('admin_modules.myprofile.changepassword');
    }
    //show view system logs
    public function systemlogs()
    {
        return view('admin_modules.myprofile.systemlogs');
    }
}
