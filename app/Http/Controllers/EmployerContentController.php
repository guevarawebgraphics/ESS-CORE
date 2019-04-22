<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class EmployerContentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');      
        $this->middleware(function($request, $next){
            if(Session::get("employer_content") == "none")
            {
                return redirect('error')->send();
            }
            else
            {
                return $next($request);
            }
        });     
    }
    //show create content
    public function create()
    {          
        return view('employer_modules.employer_content.create');
    }
    //show manage content
    public function manage()
    {          
        return view('employer_modules.employer_content.manage');
    }
}
