<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * @ 
 * */
use DB;
use Keygen;
use Response;
use Session;

/**
 * @ Laravel Packages
 * */
use Carbon\Carbon;

class FinancialCalendarController extends Controller
{
    private $add = '';
    private $edit = '';
    private $delete = '';
    public function getaccount()// call for every function for security of the system
    { 
        if(Session::get('financial_calendar') == 'all'){
            $this->add = '';
            $this->edit = '';
            $this->delete = '';
        }
        elseif(Session::get('financial_calendar') == 'view'){
            $this->add = 'disabled';
            $this->edit = 'disabled';
            $this->delete = 'disabled';
        }
        elseif(Session::get('financial_calendar') == 'add'){
            $this->add = '';
            $this->edit = 'disabled';
            $this->delete = 'disabled';
        }
        elseif(Session::get('financial_calendar') == 'edit'){
            $this->add = '';
            $this->edit = '';
            $this->delete = 'disabled';
        }
        elseif(Session::get('financial_calendar') == 'delete'){
            $this->add = '';
            $this->edit = 'disabled';
            $this->delete = '';
        }else{
            $this->add = 'disabled';
            $this->edit = 'disabled';
            $this->delete = 'disabled';
        } 
    }

    public function __construct()
    {
        $this->middleware('auth');      
        $this->middleware('revalidate'); // Revalidate back history Security For Back Button
        $this->middleware(function($request, $next){
            if(Session::get("financial_calendar") == "none")
            {
                /**
                 * UnAuthorized Access 
                 * With Temporary Session Flash
                 **/
                // Via a request instance...
                $request->session()->flash('code', '403');
                return redirect('403')->send();
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

    /**
     * @ Get Events
     * */
    public function get_events(Request $request){
        $cash_now = DB::table('financial_calendar_events')
                        ->join('cash_now', 'financial_calendar_events.calendar_event_id', '=', 'cash_now.cash_now_id')
                        ->select(
                            'cash_now.id',
                            'cash_now.cash_now_amount',
                            'cash_now.cash_now_description',
                            'cash_now.cash_now_date',
                            'cash_now.cash_now_theme_color'
                        )
                        ->where('cash_now.account_id', '=', auth()->user()->id)
                        ->get();
        return Response::json($cash_now);
    }

    /**
     * @ Get Collection
     * */
    public function get_collection(Request $request){
        $get_collection = DB::table('financial_calendar_events')
                            ->join('collection', 'financial_calendar_events.calendar_event_id', '=', 'collection.collection_id')
                            ->select(
                                'collection.id',
                                'collection.collection_amount',
                                'collection.collection_cash_source',
                                'collection.collection_amount',
                                'collection.collection_date',
                                'collection.collection_theme_color'
                            )
                            ->where('collection.account_id', '=', auth()->user()->id)
                            ->get();
        return Response::json($get_collection);
    }
    public function get_payment(Request $request){
        $get_payment = DB::table('financial_calendar_events')
                            ->join('payment', 'financial_calendar_events.calendar_event_id', '=', 'payment.payment_id')
                            ->select(
                                'payment.id',
                                'payment.payment_amount',
                                'payment.payment_source',
                                'payment.payment_amount',
                                'payment.payment_date',
                                'payment.payment_theme_color'
                            )
                            ->where('payment.account_id', '=', auth()->user()->id)
                            ->get();
        return Response::json($get_payment);
    }

    /**
     * @ Save Cash Now 
     * */
    public function save_cash_now(Request $request){
        /**
         * @ Custome Error Message
         * */
        $cusomMessage = [
            'required' => 'The :attribute field is required.'
        ];

        /**
         * @ Validate Request
         * */
        $this->validate($request, [
            'cash_now_amount' => 'required',
            'cash_now_description' => 'required',
            'cash_now_date' => 'required'
        ]);

       /**
        * @ Variables 
        */
       $current_time = carbon::now();
       $cash_now_unique_id = $this->generate_id($table = "cash_now");

      /**
        * @ Save financial Calendar events
        **/
        $save_financial_calendar_events = DB::table('financial_calendar_events')
                                            ->insert(array(
                                                'calendar_event_id' => $cash_now_unique_id,
                                                'created_by' => auth()->user()->id,
                                                'updated_by' => auth()->user()->id,
                                                'created_at' => carbon::now(),
                                                'updated_at' => carbon::now()
                                            ));

        /**
         * @ Save Cash Now
         * */
        $save_cash_now = DB::table('cash_now')
                        ->insert(array(
                            'cash_now_id' => $cash_now_unique_id,
                            'account_id' => auth()->user()->id,
                            'employee_id' => auth()->user()->employee_id,
                            'cash_now_amount' => $request->cash_now_amount,
                            'cash_now_description' => $request->cash_now_description,
                            'cash_now_date' => carbon::parse($request->cash_now_date)->format('Y-m-d'),
                            'cash_now_theme_color' => '#007BFF', // blue
                            'created_at' => carbon::now(),
                            'updated_at' => carbon::now()
                        ));



        return json_encode([
            'message' => 'Cash Now Saved',
            'status' => 200,
        ]);
    }

    /**
     * @ Update Cash now
     * */
    public function update_cash_now(Request $request){
        $this->validate($request, [
            'cash_now_amount' => 'required',
            'cash_now_description' => 'required',
            'cash_now_date' => 'required'
        ]);

        $current_time = carbon::now();
        /**
         * @ Update Cash Now
         * */
        $save_cash_now = DB::table('cash_now')
                ->where('id', '=', $request->id)
                ->update(array(
                    'employee_id' => auth()->user()->employee_id,
                    'cash_now_amount' => $request->cash_now_amount,
                    'cash_now_description' => $request->cash_now_description,
                    'cash_now_date' => carbon::parse($request->cash_now_date)->format('Y-m-d')
                    ));


        return json_encode([
            'message' => 'Cash Now Updated',
            'status' => 200,
        ]);
    }

    /**
     * @ Save Collection
     * */
    public function save_collection(Request  $request){
        /**
         * @ Custome Error Message
         * */
        $cusomMessage = [
            'required' => 'The :attribute field is required.'
        ];

        /**
         * @ Validate Request
         * */
        $this->validate($request, [
            'collection_amount' => 'required',
            'collection_cash_source' => 'required',
            'collection_date' => 'required'
        ]);

        /**
        * @ Variables 
        */
       $current_time = carbon::now();
       $collection_unique_id = $this->generate_id($table = "collection");

       /**
        * @ Save financial Calendar events
        **/
        $save_financial_calendar_events = DB::table('financial_calendar_events')
                                            ->insert(array(
                                                'calendar_event_id' => $collection_unique_id,
                                                'created_by' => auth()->user()->id,
                                                'updated_by' => auth()->user()->id,
                                                'created_at' => carbon::now(),
                                                'updated_at' => carbon::now()
                                            ));
        /**
         * @ Save collection
         * */
        $save_collection = DB::table('collection')
                            ->insert(array(
                                'collection_id' => $collection_unique_id,
                                'account_id' => auth()->user()->id,
                                'employee_id' => auth()->user()->employee_id,
                                'collection_cash_source' => $request->collection_cash_source,
                                'collection_amount' => $request->collection_amount,
                                'collection_date' => carbon::parse($request->collection_date)->format('Y-m-d', $current_time->hour .':'. $current_time->minute. ':'. $current_time->second),
                                'collection_theme_color' => '#6C757D', // grey
                                'created_at' => carbon::now(),
                                'updated_at' => carbon::now()
                            ));


         return json_encode([
            'message' => 'Collection Saved',
            'status' => 200,
        ]);


    }

    /**
     * @ Update Collection
     * */
    public function update_collection(Request $request){
        /**
         * @ Validate Request
         * */
        $this->validate($request, [
            'collection_amount' => 'required',
            'collection_cash_source' => 'required',
            'collection_date' => 'required'
        ]);

        /**
        * @ Variables 
        */
       $current_time = carbon::now();

        /**
         * @ Update collection
         * */
        $update_collection = DB::table('collection')
                            ->where('id', '=', $request->id)
                            ->update(array(
                                'employee_id' => auth()->user()->employee_id,
                                'collection_cash_source' => $request->collection_cash_source,
                                'collection_amount' => $request->collection_amount,
                                'collection_date' => carbon::parse($request->collection_date)->format('Y-m-d', $current_time->hour .':'. $current_time->minute. ':'. $current_time->second)
                            ));


         return json_encode([
            'message' => 'Collection Updated',
            'status' => 200,
            'rest' => $update_collection
        ]);

    } 
      /**
     * @ Update Payment
     * */
    public function save_payment(Request $request){
        /**
         * @ Custome Error Message
         * */
        $cusomMessage = [
            'required' => 'The :attribute field is required.'
        ];

        /**
         * @ Validate Request
         * */
        $this->validate($request, [
            'payment_amount' => 'required',
            'payment_source' => 'required',
            'payment_date' => 'required'
        ]);

        /**
        * @ Variables 
        */
       $current_time = carbon::now();
       $payment_unique_id = $this->generate_id($table = "payment");

    
        /**
        * @ Save financial Calendar events
        **/
        $save_financial_calendar_events = DB::table('financial_calendar_events')
                                            ->insert(array(
                                                'calendar_event_id' => $payment_unique_id,
                                                'created_by' => auth()->user()->id,
                                                'updated_by' => auth()->user()->id,
                                                'created_at' => carbon::now(),
                                                'updated_at' => carbon::now()
                                            ));
        /**
         * @ Save collection
         * */
        $save_payment = DB::table('payment')
                            ->insert(array(
                                'payment_id' => $payment_unique_id,
                                'account_id' => auth()->user()->id,
                                'employee_id' => auth()->user()->employee_id,
                                'payment_source' => $request->payment_source,
                                'payment_amount' => $request->payment_amount,
                                'payment_date' => carbon::parse($request->payment_date)->format('Y-m-d', $current_time->hour .':'. $current_time->minute. ':'. $current_time->second),
                                'payment_theme_color' => '#17A2B8', // cyan
                                'created_at' => carbon::now(),
                                'updated_at' => carbon::now()
                            ));


         return json_encode([
            'message' => 'Payment Saved',
            'status' => 200,
        ]);

    }
      /**
     * @ Update Payment
     * */
    public function update_payment(Request $request){
        /**
         * @ Validate Request
         * */
        $this->validate($request, [
            'payment_amount' => 'required',
            'payment_source' => 'required',
            'payment_date' => 'required'
        ]);

        /**
        * @ Variables 
        */
       $current_time = carbon::now();

        /**
         * @ Update collection
         * */
        $update_payment = DB::table('payment')
                            ->where('id', '=', $request->id)
                            ->update(array(
                                'employee_id' => auth()->user()->employee_id,
                                'payment_source' => $request->payment_source,
                                'payment_amount' => $request->payment_amount,
                                'payment_date' => carbon::parse($request->payment_date)->format('Y-m-d', $current_time->hour .':'. $current_time->minute. ':'. $current_time->second)
                            ));


         return json_encode([
            'message' => 'Payment Updated',
            'status' => 200,
            'rest' => $update_payment
        ]);
    }
    

    /**
     *  Generate Key
     * */
    protected function generate_unique_id(){
        //prefixes the key with a random integer between 1 - 9 (inclusive)
        //return Keygen::length(6)->numeric()->generate();
        return Keygen::numeric(6)->prefix(mt_rand(1, 9))->generate(true);
    }

    /**
     * @ Generate ID
     * */
    protected function generate_id($table){

        $unique_id = $this->generate_unique_id();

        /**
         * @ Check table
         * */ 
        if($table == "cash_now") {
            // Ensure ID does not exist
            // Generate a new one if ID already exists
            while (DB::table('cash_now')->where('id', '=', $unique_id)->count() > 0){
                $unique_id = $this->generate_unique_id();
            }
        }
        if($table == "collection"){
            // Ensure ID does not exist
            // Generate a new one if ID already exists
            while (DB::table('collection')->where('id', '=', $unique_id)->count() > 0){
                $unique_id = $this->generate_unique_id();
            }
        }
        if($table == "payment"){
            // Ensure ID does not exist
            // Generate a new one if ID already exists
            while (DB::table('payment')->where('id', '=', $unique_id)->count() > 0){
                $unique_id = $this->generate_unique_id();
            }
        }
        

        return $unique_id;
    }
}
