<?php

namespace App\Http\Controllers;
use App\Notifications;
use DB;
use App\Logs;
use Response;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        //$Notification = Notifications::all();
        return view('Notification.index');
    }

    public function get_all_notifications(){
        $Notification = DB::table('notification')
                            ->join('employer', 'employer.account_id', '=', 'notification.employer_id')
                            ->select('notification.id', 'notification.notification_title', 'notification.notification_message', 'notification.notification_type', 'employer.business_name')
                            ->get();
        return json_encode($Notification);
    }

    public function store_notification(Request $request)
    {

        /*Validate Request*/
        $this->validate($request, [
            'employer_id' => 'required',
            'notification_title' => 'required',
            'notification_message' => 'required',
            'notification_type' => 'required'
        ]);

        /*Insert To Notification Table*/
        $Notification = Notifications::create([
            // Array Fields Here
            'account_id' => auth()->user()->id,
            'employer_id' => $request->input('employer_id'),
            'notification_title' => $request->input('notification_title'),
            'notification_message' => $request->input('notification_message'),
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
                            ->select('notification.id', 'notification.employer_id', 'notification.notification_title', 'notification.notification_message', 'notification.notification_type', 'employer.business_name')
                            ->where('notification.id', $Notification_id)
                            ->get();
        return json_encode($Notification);
    }

    public function update_notification(Request $request, $id)
    {
        /*Validate Request*/
        $this->validate($request, [
            'employer_id' => 'required',
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
