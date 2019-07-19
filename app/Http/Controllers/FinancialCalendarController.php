<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * @ 
 * */
use DB;
use Response;
use Session;

/**
 * @ Laravel Packages
 * */
use Carbon\Carbon;

class FinancialCalendarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');      
        $this->middleware('revalidate'); // Revalidate back history Security For Back Button
        $this->middleware(function($request, $next){
            if(Session::get("financial_calendar") == "none")
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
        return view('employee_modules.financial_calendar.index');
    }
}
