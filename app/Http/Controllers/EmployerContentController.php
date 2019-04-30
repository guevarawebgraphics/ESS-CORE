<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\EmployerContent;
use App\Logs;

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
    
    //show manage content
    public function manage()
    {          
        return view('employer_modules.employer_content.manage');
    }
    //refresh manage content
    public function refresh_manage()
    {
        return view('employer_modules.employer_content.tablemanage');
    }
    //create employer content
    public function create_employercontent(Request $request)
    {
        /*Validate Request*/
        $this->validate($request, [
            'content_title' => 'required',
            'content_description' => 'required',
            'content_type' => 'required',
        ]);

        /*Check if all Request is not null*/
        if($request->all() != null){
            /*Create Announcement*/
            $Announcement = EmployerContent::create([
                'account_id' => 2, //Temporary Account Id
                'content_title' => $request->input('content_title'),
                'content_description' => $request->input('content_description'),
                'content_status' => 0, //0 Means Pending Staus
                'content_type' => $request->input('content_type'),
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,

            ]);

             // Insert Log
            $this->insert_log("Create Employer Content");
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
