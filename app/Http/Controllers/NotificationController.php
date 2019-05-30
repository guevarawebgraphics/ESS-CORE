<?php

namespace App\Http\Controllers;
use App\Notifications;
use DB;
use App\Logs;
use Response;
use Session;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    private $add = '';
    private $edit = '';
    private $delete = '';
    public function getaccount()// call for every function for security of the system
    { 
        if(Session::get('system_notifications') == 'all'){
            $this->add = '';
            $this->edit = '';
            $this->delete = '';
        }
        elseif(Session::get('system_notifications') == 'view'){
            $this->add = 'disabled';
            $this->edit = 'disabled';
            $this->delete = 'disabled';
        }
        elseif(Session::get('system_notifications') == 'add'){
            $this->add = '';
            $this->edit = 'disabled';
            $this->delete = 'disabled';
        }
        elseif(Session::get('system_notifications') == 'edit'){
            $this->add = '';
            $this->edit = '';
            $this->delete = 'disabled';
        }
        elseif(Session::get('system_notifications') == 'delete'){
            $this->add = '';
            $this->edit = 'disabled';
            $this->delete = '';
        }else{
            $this->add = 'disabled';
            $this->edit = 'disabled';
            $this->delete = 'disabled';
        } 
    }
    public function __construct(){
        $this->middleware('auth');
        $this->middleware(function($request, $next){
            if(Session::get("system_notifications") == "none")
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
        //$Notification = Notifications::all();
        $employers = DB::table('employer')->select('account_id', 'business_name')->get();
        // If the user is Admin
        if(auth()->user()->user_type_id == 1){
            $notification_message_type = DB::table('notification_message_type')->select('id', 'message_type')->get();
        }
        // If The user is Employer
        if(auth()->user()->user_type_id == 3){
            $notification_message_type = DB::table('notification_message_type')->select('id', 'message_type')->whereNotIn('account_id', array('1'))->get();
        }
        return view('Notification.index', compact('employers', 'notification_message_type'));
    }

    public function get_all_notifications(Request $request){
        // If the user is Admin
        if(auth()->user()->user_type_id == 1){
            $Notification = DB::table('notification')
                            ->join('employer', 'employer.id', '=', 'notification.employer_id')
                            ->join('notification_message_type', 'notification_message_type.id', '=', 'notification.message_type_id')
                            ->select('notification.id', 'notification.notification_title',
                            'notification.notification_message',
                            'notification_message_type.message_type',
                            'notification.notification_type',
                            'employer.business_name')
                            ->get();
        }
        // If The user is Employer
        if(auth()->user()->user_type_id == 3){
            $Notification = DB::table('notification')
                            ->join('employer', 'employer.id', '=', 'notification.employer_id')
                            ->join('notification_message_type', 'notification_message_type.id', '=', 'notification.message_type_id')
                            ->select('notification.id',
                            'notification.notification_title',
                            'notification.notification_message',
                            'notification_message_type.message_type',
                            'notification.notification_type',
                            'employer.business_name')
                            ->where('notification.employer_id', auth()->user()->id)
                            //->whereNotIn('notification.account_id', array('1', '2', '3'))
                            ->where('notification_message_type.account_id', array('0'))
                            ->get();
        }

        if($request->ajax()){
            return Response($Notification);
        }
        else {
            abort(404);
        }
        
        
    }

    public function store_notification(Request $request)
    {
        $this->getaccount();
        /*Validate Request*/
        $this->validate($request, [
            (auth()->user()->user_type_id == 1 ? "'employer_id' => 'required',": ""),
            'notification_title' => 'required',
            'notification_message' => 'required',
            'message_type_id' => 'required',
            'notification_type' => 'required'
        ]);

        $employer = DB::table('employer')
                        ->select('account_id')
                        ->where('business_name', '=', $request->employer_id)
                        ->first();

        /*Insert To Notification Table*/
        $Notification = Notifications::create([
            // Array Fields Here
            'account_id' => auth()->user()->id,
            'employer_id' => (auth()->user()->user_type_id == 3 ? auth()->user()->id : $request->input('employer_id')),
            'notification_title' => $request->input('notification_title'),
            'notification_message' => $request->input('notification_message'),
            'message_type_id' => $request->input('message_type_id'),
            'notification_type' => $request->input('notification_type'),
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id 
        ]);
        $msg = 'Success!';
        // Insert Log
        $this->insert_log("Create Notification");
        return response::json($msg);
    }

    public function edit_notification(Request $request)
    {
        $Notification_id = $request->id;
        $Notification = DB::table('notification')
                            ->join('employer', 'employer.account_id', '=', 'notification.employer_id')
                            ->join('notification_message_type', 'notification_message_type.id', '=', 'notification.message_type_id')
                            ->select('notification.id',
                            'notification.employer_id',
                            'notification.notification_title',
                            'notification.notification_message',
                            'notification.message_type_id',
                            'notification_message_type.message_type',
                            'notification.notification_type',
                            'employer.business_name')
                            ->where('notification.id', $Notification_id)
                            ->get();
        return json_encode($Notification);
    }

    public function update_notification(Request $request, $id)
    {
        $this->getaccount();
        /*Validate Request*/
        $this->validate($request, [
            //'employer_id' => 'required',
            'notification_title' => 'required',
            'notification_message' => 'required',
            'notification_type' => 'required'
        ]);


        // Update Notification
        DB::table('notification')->where('id', '=', $id)
                                ->update(array(
                                        // Array Fields Here
                                        'employer_id' => $request->input('employer_id'),
                                        'notification_title' => $request->input('notification_title'),
                                        'notification_message' => $request->input('notification_message'),
                                        'message_type_id' => $request->input('message_type_id'),
                                        'notification_type' => $request->input('notification_type'),
                                        'created_by' => auth()->user()->id,
                                        'updated_by' => auth()->user()->id 
                                ));
        $msg = 'Updated!';
        // Insert Log
        $this->insert_log("Update Notification");
        return response::json($msg);
    }

    public function destroy_notification(Request $request)
    {
        $this->getaccount();
        $Notification_id = $request->id;

        $Notification = Notifications::where('id', '=', $Notification_id)->delete();

        return response()->json($Notification);
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
