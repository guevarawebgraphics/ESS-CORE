<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use App\FinancialTip;
use Carbon\Carbon;

class FinancialTipsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');      
        $this->middleware(function($request, $next){
            if(Session::get("financial_tips") == "none")
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
        return view('employee_modules.financial_tips.index');
    } 
    public function manage()
    { 
        $FinancialTipsTable = DB::table('financial_tips')->latest('created_at')->get();
        return view('employer_modules.financial_tips.manage',compact(['FinancialTipsTable']));
    }
    public function FinancialTipsTableManage()
    {   
        $FinancialTipsTable = DB::table('financial_tips')->latest('created_at')->get();
        return view('employer_modules.financial_tips.tablemanage',compact(['FinancialTipsTable']));
    }
    public function post_financial_tips(request $Request)
    {   

        $id = $Request->id;
        $financial_tips = DB::table('financial_tips')->where('id', '=', $id)
        ->update(array(
            'status' => 1,
        ));
        
    }
    public function delete_financial_tips(request $Request)
    {
        $id = $Request->id;
        $financial_tips = DB::table('financial_tips')->where('id','=',$id)->delete();
        $message = "Successfully Deleted";
        return response()->json($message);
    }
    public function refreshmanage()
    {
        $FinancialTipsTable = DB::table('financial_tips')->get();
        return view('employer_modules.financial_tips.tablemanage',compact(['FinancialTipsTable']));
  
    }
    public function create_financial_tips(request $Request)
    {
     
        $this->validate($Request, [
            'title' => 'required',
            'description' => 'required',
        ]);

        $title = $Request->title;
        $description = $Request->description;

        $create_financial_tips = FinancialTip::create([
            'account_id'=>auth()->user()->id,
            'financial_tips_title'=>$title,
            'financial_tips_description'=>$description,
            'status'=>0,
            'created_by'=>auth()->user()->id,
            'updated_by'=>auth()->user()->id,
            'created_at'=>Carbon::now(),

        ]);

        return response()->json($create_financial_tips,200);
    }
    public function edit_financial_tips(request $Request)
    {
        $this->validate($Request, [
            'id' => 'required',
            'title' => 'required',
            'description' => 'required',
        ]);
        $id = $Request->id;
        $title = $Request->title;
        $description = $Request->description;
        
        $edit_financial_tips = DB::table('financial_tips')->where('id','=',$id) 
                            ->update(array(
                                'financial_tips_title'=>$title,
                                'financial_tips_description'=>$description,
                                'updated_by'=>auth()->user()->id,
                             ));

    }
}
