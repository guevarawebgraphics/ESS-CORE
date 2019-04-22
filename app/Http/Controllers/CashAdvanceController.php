<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class CashAdvanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');      
        $this->middleware(function($request, $next){
            if(Session::get("cash_advance") == "none")
            {
                return redirect('error')->send();
            }
            else
            {
                return $next($request);
            }
        });     
    }
    //show index 
    public function index()
    {          
        return view('employee_modules.cashadvance.index');
    }
    
}
