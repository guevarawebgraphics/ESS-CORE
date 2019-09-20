<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class EWalletController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');      
        $this->middleware(function($request, $next){
            if(Session::get("e_wallet") == "none")
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
    public function index(Request $request)
    {          
        $request->session()->flash('code', 'under_construction');
        return redirect('underconstruction')->send();
        //return view('employee_modules.ewallet.index');
    }
}
