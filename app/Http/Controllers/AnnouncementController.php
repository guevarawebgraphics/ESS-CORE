<?php

namespace App\Http\Controllers;
use App\Announcement;
use Session;
use App\Logs;
use Response;
use DB;

use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
     // Security Authentication
     public function __construct()
     {
         $this->middleware('auth');
         $this->middleware(function($request, $next){
             if(Session::get("create_profile") == "none")
             {
                 return redirect('error')->send();
             }
             else
             {
                 return $next($request);
             }
         }); 
     }


     public function index(){

        return view('Announcement.index');
     }

     public function get_all_announcement(){
        $Announcement = DB::table('announcement')
                            ->join('employer', 'employer.account_id', '=', 'announcement.account_id')
                            ->join('user_type', 'announcement.announcement_type', '=', 'user_type.id')
                            ->select('announcement.id',
                             'announcement.announcement_title',
                             'announcement.announcement_description',
                             'announcement.announcement_status',
                             'employer.business_name',
                             'user_type.type_name',
                             'user_type.id as user_type_id',)
                            ->get();
        return json_encode($Announcement);
     }

     public function store_announcement(Request $request){
        /*Validate Request*/
        $this->validate($request, [
            'announcement_title' => 'required',
            'announcement_description' => 'required',
            'announcement_type' => 'required',
        ]);

        /*Check if all Request is not null*/
        if($request->all() != null){
            /*Create Announcement*/
            $Announcement = Announcement::create([
                'account_id' => 2, //Temporary Account Id
                'announcement_title' => $request->input('announcement_title'),
                'announcement_description' => $request->input('announcement_description'),
                'announcement_status' => 0, //0 Means Pending Staus
                'announcement_type' => $request->input('announcement_type'),
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,

            ]);

             // Insert Log
            $this->insert_log("Create Announcement");
        }

        
         return Response::json($Announcement);
     }

     public function edit_announcement(Request $request){
         $Announcement_id = $request->id;
         $Announcement = DB::table('announcement')
                            ->join('employer', 'employer.account_id', '=', 'announcement.account_id')
                            ->join('user_type', 'announcement.announcement_type', '=', 'user_type.id')
                            ->select('announcement.id',
                             'announcement.announcement_title',
                             'announcement.announcement_description',
                             'announcement.announcement_status',
                             'announcement.announcement_type',
                             'employer.business_name',
                             'user_type.type_name',
                             'user_type.id as user_type_id',)
                            ->where('announcement.id', $Announcement_id)
                            ->get();
        return json_decode($Announcement);
     }

     public function update_announcement(Request $request, $id){
         /*Validate Request*/
        $this->validate($request, [
            'announcement_title' => 'required',
            'announcement_description' => 'required',
            'announcement_type' => 'required',
        ]);

        /*Check if all Request is not null*/
        if($request->all() != null){
            /*Update Announcement*/
            $Announcement = DB::table('announcement')->where('id', '=', $id)
                                ->update(array(
                                    'account_id' => 2, // Temporary
                                    'announcement_title' => $request->input('announcement_title'),
                                    'announcement_description' => $request->input('announcement_description'),
                                    'announcement_status' => 0, //0 Means Pending Staus
                                    'announcement_type' => $request->input('announcement_type'),
                                    'created_by' => auth()->user()->id,
                                    'updated_by' => auth()->user()->id,
                        ));

             // Insert Log
            $this->insert_log("Update Announcement");
        }

        
         return Response::json($Announcement);
     }

     public function update_announcement_status(Request $request){
         $Announcement_id = $request->id;
         /*Validate Request*/
         $this->validate($request, [
            'id' => 'required',
         ]);

         /*Check if all the Request is not null*/
         if($request->all() != null){
            $Announcement = DB::table('announcement')->where('id', '=', $Announcement_id)
                                ->update(array(
                                    'announcement_status' => 1,
                                ));
         }

         // Insert Log
         $this->insert_log("Post Announcement");

         return Response::json();
     }

     public function destroy_announcement(Request $request){
         $id = $request->id;
         /*Delete Announcement*/
         $Announcement = Announcement::where('id', '=', $id)->delete();
         $message = 'Successfully Deleted';
         return response()->json($message);
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
