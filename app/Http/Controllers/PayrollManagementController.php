<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Execel\Facades\Execel;

use DB;
use Response;
use Carbon\Carbon;
use Session;

class PayrollManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');      
        $this->middleware(function($request, $next){
            if(Session::get("payroll_management") == "none")
            {
                return redirect('error')->send();
            }
            else
            {
                return $next($request);
            }
        });     
    }
    //show upload register
    public function upload()
    {          
        return view('employer_modules.payroll_management.upload');
    }
    //show view register
    public function view()
    {          
        return view('employer_modules.payroll_management.view');
    }
}
