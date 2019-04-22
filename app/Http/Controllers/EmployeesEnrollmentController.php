<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

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
}
