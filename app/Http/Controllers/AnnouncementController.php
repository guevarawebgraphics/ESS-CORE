<?php

namespace App\Http\Controllers;

/**
 * Packages Facades
 *  */
use Illuminate\Http\Request;

/**
 *  @ Insert Packages Here
 *  */
use Redis;
use Carbon\Carbon;

/**
 *  Insert Model Here
 *  */
use App\Logs;
use App\Announcement;

/**
 * Laravel
 *  */
use DB;
use Mail;
use Session;
use Response;

class AnnouncementController extends Controller
{
    private $add = '';
    private $edit = '';
    private $delete = '';
    public function getaccount()// call for every function for security of the system
    { 
        if(Session::get('send_announcement') == 'all'){
            $this->add = '';
            $this->edit = '';
            $this->delete = '';
        }
        elseif(Session::get('send_announcement') == 'view'){
            $this->add = 'disabled';
            $this->edit = 'disabled';
            $this->delete = 'disabled';
        }
        elseif(Session::get('send_announcement') == 'add'){
            $this->add = '';
            $this->edit = 'disabled';
            $this->delete = 'disabled';
        }
        elseif(Session::get('send_announcement') == 'edit'){
            $this->add = '';
            $this->edit = '';
            $this->delete = 'disabled';
        }
        elseif(Session::get('send_announcement') == 'delete'){
            $this->add = '';
            $this->edit = 'disabled';
            $this->delete = '';
        }else{
            $this->add = 'disabled';
            $this->edit = 'disabled';
            $this->delete = 'disabled';
        } 
    }
     // Security Authentication
     public function __construct()
     {
         $this->middleware('auth', ['except' => 'get_all_announcement_to_notification']);
         $this->middleware('revalidate'); // Revalidate back history Security For Back Button
         $this->middleware(function($request, $next){
             if(Session::get("send_announcement") == "none")
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
        $employers = DB::table('employer')->select('id', 'business_name')->get();
        // If the user is Admin
        if(auth()->user()->user_type_id == 1){
            $notification_message_type = DB::table('notification_message_type')->select('id', 'message_type')->get();
        }
        // If The user is Employer
        if(auth()->user()->user_type_id == 3){
            $notification_message_type = DB::table('notification_message_type')
                                        ->select('id', 'message_type')->whereNotIn('account_id', array('1'))->get();
        }

        /**
          *  @ Guard if The User is Employee
          *
         **/
          if(auth()->user()->user_type_id != 4){
            return view('Announcement.index', compact('employers'));
          }
          else {
              return abort(403);
          }
        
     }

     public function get_all_announcement(Request $request){
         if(auth()->user()->user_type_id === 1){
            $Announcement = DB::table('announcement')
                            ->join('employer', 'employer.id', '=', 'announcement.account_id')
                            ->select('announcement.id',
                             'announcement.announcement_title',
                             'announcement.announcement_description',
                             'announcement.announcement_status',
                             'employer.business_name',
                             '.announcement.created_at')
                             ->latest('announcement.created_at')
                            ->get();
         }
         if(auth()->user()->user_type_id === 3){
            $Announcement = DB::table('announcement')
                            ->select('announcement.id',
                            'announcement.announcement_title',
                            'announcement.announcement_description',
                            'announcement.announcement_status',
                            '.announcement.created_at')
                            ->where('announcement.created_by', '=', auth()->user()->id)
                            ->latest('announcement.created_at')
                            ->get();
         }
        

        /*Protection for Data View as Json*/
        if($request->ajax()){
            //return json_encode($Announcement);
            return response()->json($Announcement,200);
        }
        else {
            abort(404);
        }
        
     }

     public function get_all_announcement_to_notification(Request $request){
         /*Announcement for Admin*/
        if(auth()->user()->user_type_id === 1){
            // $Announcement = DB::table('announcement')
            //                 ->join('employer', 'employer.id', '=', 'announcement.account_id')
            //                 //->join('user_type', 'announcement.announcement_type', '=', 'user_type.id')
            //                 ->select('announcement.id',
            //                  'announcement.announcement_title',
            //                  'announcement.announcement_description',
            //                  'announcement.announcement_status',
            //                  //'announcement.announcement_type',
            //                  'employer.business_name',
            //                  ////'user_type.type_name',
            //                  //'user_type.id as user_type_id',
            //                  'announcement.created_at',
            //                  'announcement.updated_at')
            //                  ->orderBy('announcement.created_at','desc')
            //                  ->whereNotIn('announcement.account_id', auth()->user()->id)
            //                 ->get();
            if(auth()->user()->user_type_id == 1){
                return abort(200);
            }                  
         }
         /*Announcement For Employer*/
         if(auth()->user()->user_type_id === 3){
            $Announcement = DB::table('announcement')
                            ->join('employer', 'employer.id', '=', 'announcement.account_id')
                            ->select('announcement.id',
                             'announcement.announcement_title',
                             'announcement.announcement_description',
                             'announcement.announcement_status',
                             'employer.business_name',
                             'announcement.created_at',
                             'announcement.updated_at')
                             ->where('announcement.employer_id', '=', auth()->user()->employer_id)
                             ->where('announcement.announcement_type', '=', '1')
                             ->orderBy('announcement.created_at','desc')
                            ->get();
         }
         /*Announcement For Employee*/
         if(auth()->user()->user_type_id === 4){
             $Announcement = DB::table('announcement')
                            ->join('employer', 'employer.id', '=', 'announcement.account_id')
                            ->join('employer_and_employee', 'employer_and_employee.employer_id', '=', 'announcement.employer_id')
                            ->select('announcement.id',
                                    'announcement.announcement_title',
                                    'announcement.announcement_description',
                                    'announcement.announcement_status',
                                    'employer.business_name',
                                    'announcement.created_at',
                                    'announcement.updated_at')
                            ->where('announcement.announcement_type', '=', '3')
                            ->orderBy('announcement.created_at', 'desc')
                            ->get();
                            
         }
        

        /*Protection for Data View as Json*/
        if($request->ajax()){
            foreach ($Announcement as $key => $value){
                if($value->announcement_status == 1){

                    /**
                     * @ If user is Employer
                     * */
                        if(auth()->user()->user_type_id == 3){
                            $Announcement1 = DB::table('announcement')
                                        ->join('employer', 'employer.id', '=', 'announcement.account_id')
                                        ->select('announcement.id',
                                        'announcement.announcement_title',
                                        'announcement.announcement_description',
                                        'announcement.announcement_status',
                                        'employer.business_name',
                                        'announcement.created_at',
                                        'announcement.updated_at')
                                        ->orderBy('announcement.created_at','desc')
                                        ->where('announcement.announcement_status', '=', '1')
                                        ->where('announcement.announcement_type', '=', '1')
                                        ->get();
                        }
                        
                        /**
                         * @ If User is Employee
                         * */
                        if(auth()->user()->user_type_id == 4){
                            $Announcement1 = DB::table('announcement')
                                        ->join('employer', 'employer.id', '=', 'announcement.account_id')
                                        ->join('employer_and_employee', 'announcement.employer_id', '=', 'employer_and_employee.employer_id')
                                        ->join('user_picture', 'employer.id', '=', 'user_picture.employer_id')
                                        ->select('announcement.id',
                                        'announcement.announcement_title',
                                        'announcement.announcement_description',
                                        'announcement.announcement_status',
                                        'employer.business_name',
                                        'announcement.created_at',
                                        'announcement.updated_at',
                                        'user_picture.profile_picture')
                                        //->orderBy('announcement.created_at','desc')
                                        ->where('announcement.announcement_status', '=', '1')
                                        ->where('announcement.announcement_type', '=', '3')
                                        ->where('employer_and_employee.ess_id', '=', auth()->user()->username)
                                        ->latest()
                                        //->take(6)
                                        ->get();
                        }
                        return json_encode($Announcement1);
                }
            }
            
            
        }
        else {
            abort(404);
        }
        
     }

     public function store_announcement(Request $request){
         $this->getaccount();
         /**
          * @ Get The Employer ID 
          **/
         $employer_id = DB::table('employer')
                        ->where('id', '=', auth()->user()->employer_id)
                        ->select('id')
                        ->first();
                        
        /*Validate Request*/
        if(auth()->user()->user_type_id === 1){
            $this->validate($request, [
                'announcement_title' => 'required',
                'announcement_description' => 'required',
            ]);

            $emp = array();


            /**
             * @ Get All Employers From Multiple Select 
             * 
             * */
            $employers_id = $request->input('employer_id');
            foreach($employers_id as $employers => $value) {

                //array_push($emp, $value);
                /*Check if all Request is not null*/
                if($request->all() != null){
                    /*Create Announcement*/
                    $Announcement = Announcement::create([
                        'account_id' => $value, //Temporary Account Id
                        'employer_id' => $value,
                        'announcement_title' => $request->input('announcement_title'),
                        'announcement_description' => $request->input('announcement_description'),
                        'announcement_status' => 0, //0 Means Pending Staus
                        'announcement_type' => (auth()->user()->user_type_id === 1) ? 1 : 3 ,// 0 is Temporary for Employee
                        'created_by' => auth()->user()->id,
                        'updated_by' => auth()->user()->id,
    
                    ]);
    
                    // Insert Log
                    $this->insert_log("Create Announcement");
                }
            }
            //dd($emp);
            
            
        }
        if(auth()->user()->user_type_id === 3){
            $this->validate($request, [
                'announcement_title' => 'required',
                'announcement_description' => 'required',
            ]);

            /*Check if all Request is not null*/
            if($request->all() != null){
                /*Create Announcement*/
                $Announcement = Announcement::create([
                    'account_id' => $employer_id->id, //Temporary Account Id
                    'employer_id' => $employer_id->id,
                    'announcement_title' => $request->input('announcement_title'),
                    'announcement_description' => $request->input('announcement_description'),
                    'announcement_status' => 0, //0 Means Pending Staus
                    'announcement_type' => 3 ,// 0 is Temporary for Employee
                    'created_by' => auth()->user()->id,
                    'updated_by' => auth()->user()->id,

                ]);

                // Insert Log
                $this->insert_log("Create Announcement");
            }
        }

         return Response::json($Announcement);
     }

     public function edit_announcement(Request $request){
         $Announcement_id = $request->id;
         $Announcement = DB::table('announcement')
                            ->join('employer', 'employer.id', '=', 'announcement.account_id')
                            ->select('announcement.id',
                             'announcement.announcement_title',
                             'announcement.announcement_description',
                             'announcement.announcement_status',
                             'announcement.employer_id',
                             'employer.business_name'
                             )
                            ->where('announcement.id', $Announcement_id)
                            ->get();
        return json_decode($Announcement);
     }

     public function update_announcement(Request $request, $id){
        $this->getaccount();
         /*Validate Request*/
        $this->validate($request, [
            'announcement_title' => 'required',
            'announcement_description' => 'required',
        ]);

        /*Check if all Request is not null*/
        if($request->all() != null){
            /*Update Announcement*/
            $Announcement = DB::table('announcement')->where('id', '=', $id)
                                ->update(array(
                                    //'account_id' => 2, // Temporary
                                    'announcement_title' => $request->input('announcement_title'),
                                    'announcement_description' => $request->input('announcement_description'),
                                    'announcement_status' => 0, //0 Means Pending Staus
                                    'created_by' => auth()->user()->id,
                                    'updated_by' => auth()->user()->id,
                        ));

             // Insert Log
            $this->insert_log("Update Announcement");
        }

        
         return Response::json($Announcement);
     }

     public function update_announcement_status(Request $request){
        $this->getaccount();
         $Announcement_id = $request->id;
         //$announcement_type = $request->announcement_type;
         /*Validate Request*/
        //  $this->validate($request, [
        //     'id' => 'required',
        //  ]);

         /*Check if all the Request is not null*/
         if($request->all() != null){
            $Announcement = DB::table('announcement')->where('id', '=', $Announcement_id)
                                ->update(array(
                                    'announcement_status' => 1,
                                    'updated_at' => Carbon::now(),
                                ));
         }

         // Insert Log
         $this->insert_log("Post Announcement");
         // Get Template
         $template_result = DB::table('announcement')
                                ->where('id', $Announcement_id)
                                ->select('announcement_description')
                                ->get();
        // Get all emails of employers Should be Employees
        // $type = DB::table('employer')
        //                         ->where('user_type', $announcement_type)
        //                         ->pluck('contact_email');

        //  /*Send Mail */
        //  $data = array("template" => strip_tags($template_result[0]->announcement_description), "emails" => $type);
        //  // Note in Blast Email Use Gmail smtp
        //  foreach ($type as $key => $tests) {
        //     Mail::send('Email.mail', $data, function($message) use($tests){
        //         $message->to($tests, 'ess announcement')
        //                 ->subject("ESS Announcement ");
        //         $message->from('esssample@gmail.com', "ESS");
        //     });
        //  }
         
         // Insert Log
        //  $this->insert_log("Post Announcement");
        //  return Response::json();
        // $redis = Redis::connection();
        // $redis->publish('message',json_encode($Announcement));
        event(new \App\Events\Announcement("New Announcement"));
        
        return response()->json($Announcement,200);
     }

     /*
      *  Update Notification SEEN(READ) is true
      */
    public function update_notification_show(Request $request){
        $seen = DB::table('notification_show')
                    ->insert(array(
                        'notification_id' => $request->input('notification_id'),
                        'user_id' => auth()->user()->id,
                        'read' => true,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ));
        return Response::json();
    }

     /*
      *  Show Notification if UNSEAN(READ) is FALSE
      */
    public function get_notification_show(Request $request){
        $read_notification = DB::table('notification_show')
                                ->where('user_id', '=', auth()->user()->id)
                                ->select('read')
                                ->first();
        if($read_notification){
            $tmp = $read_notification->read;
        }
        else {
            $tmp = 0;
        }
        

        return Response::json($tmp);
    }

     public function destroy_announcement(Request $request){
        $this->getaccount();
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
