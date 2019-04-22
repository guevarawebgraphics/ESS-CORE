<?php

namespace App\Http\Controllers;
use App\Account;
use App\UserType;
use App\User;
use App\ESSBase;
use App\Logs;
use Session;
use DB;
use Response;
use Mail;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class AccountController extends Controller
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

    public function index()
    {
        //$Account = Account::all();
        //$user_type = UserType::all();
        $Account = DB::table('employer')
                        ->join('user_type', 'employer.user_type', '=', 'user_type.id')
                        ->join('users', 'employer.account_id', '=', 'users.id')
                        ->select('employer.id', 'employer.business_name', 'employer.accountname', 'employer.contact_email', 'employer.sec', 'employer.bir', 'user_type.type_name', 'users.AccountStatus', 'employer.account_id')
                        ->get();
        return view('Account.index', compact('Account'));
    }

    public function create()
    {
        return view('Account.create');
    }

    public function store(Request $request)
    {
        $business_name = Input::get('business_name');
        $password = $this->generate_password(8);

        // Custom Message
        $customMessages = [
            'required' => 'The :attribute field is required.'
        ];

        /*Validate Request*/
        $this->validate($request, [
            'user_type' => 'required|min:3',
            'accountname' => 'required|unique:employer|min:3',
            'business_name' => 'required|unique:employer|min:3',
            'user_type' => 'required',
            'address_unit' => 'required|min:3',
            'address_country' => 'required|min:3',
            'address_town' => 'required|min:3',
            'address_cityprovince' => 'required|min:3',
            'address_barangay' => 'required|min:3',
            'address_zipcode' => 'required|min:3',
            'contact_person' => 'required|min:3',
            'contact_phone' => 'required|unique:employer',
            'contact_mobile' => 'required|unique:employer',
            'contact_email' => 'required|unique:employer|email',
            'sss' => 'required|unique:employer|min:3',
            'tin' => 'required|unique:employer|min:3',
            'phic' => 'required|unique:employer|min:3',
            'hdmf' => 'required|unique:employer|min:3',
            'nid' => 'required|unique:employer|min:3',
        ]);

        // Handle File Upload
        if($request->hasFile('sec') && $request->hasFile('bir')){
            // Get filename with the extension
            $filenameWithExt_sec = $request->file('sec')->getClientOriginalName();
            $filenameWithExt_bir = $request->file('bir')->getClientOriginalName();
            // Get just filename
            $filename_sec = pathinfo($filenameWithExt_sec, PATHINFO_FILENAME);
            $filename_bir = pathinfo($filenameWithExt_bir, PATHINFO_FILENAME);
            // Get just ext
            $extension_sec = $request->file('sec')->getClientOriginalExtension();
            $extension_bir = $request->file('bir')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore_sec= $filename_sec.'_'.time().'.'.$extension_sec;
            $fileNameToStore_bir= $filename_bir.'_'.time().'.'.$extension_bir;
            // Upload Image
            $path_sec = $request->file('sec')->storeAs('public/Documents/sec', $fileNameToStore_sec);
            $path_bir = $request->file('bir')->storeAs('public/Documents/bir', $fileNameToStore_bir);
        } else {
            $fileNameToStore_sec = 'noifile.txt';
            $fileNameToStore_bir = 'noifile.txt';
        }

        

        if ($business_name == 'business_name'){
            /*Do Somethin or ....*/
        }
        else {

            /*Check if All Request is not null*/
            if($request->all() != null){
                /*Create User*/
                $user = User::create([
                    'user_type_id' => $request->input('user_type'),
                    'name' => $request->input('accountname'),
                    'username' => $request->input('accountname'),
                    'password' => Hash::make($password),
                    'created_by' => auth()->user()->id,
                    'updated_by' => auth()->user()->id,
                ]);

                /*Gett the Id of User*/
                $Account_id = $user->id;
                
                /*Create a User In Base Table*/
                $insert_ess = new ESSBase;
                $insert_ess->account_id = $Account_id;
                /*Temporary ESS ID 12345*/
                $insert_ess->ess_id = 12345;
                $insert_ess->user_type_id = $request->input('user_type');            
                $insert_ess->created_by = auth()->user()->id;
                $insert_ess->updated_by = auth()->user()->id;
                $insert_ess->save();
            }
            


            
            /*Check if the request is Employer*/
            if ($request->input('user_type') == 3){
                /*Create Account Employer*/
                $employer = Account::create([
                    // Array Fields Here
                    'account_id' => $Account_id,
                    'business_name' => $request->input('business_name'),
                    'accountname' => $request->input('accountname'),
                    'user_type' => $request->input('user_type'),
                    'address_unit' => $request->input('address_unit'),
                    'address_country' => $request->input('address_country'),
                    'address_town' => $request->input('address_town'),
                    'address_cityprovince' => $request->input('address_cityprovince'),
                    'address_barangay' => $request->input('address_barangay'),
                    'address_zipcode' => $request->input('address_zipcode'),
                    'contact_person' => $request->input('contact_person'),
                    'contact_phone' => $request->input('contact_phone'),   
                    'contact_mobile' => $request->input('contact_mobile'),
                    'contact_email' => $request->input('contact_email'),
                    'tin' =>$request->input('tin'),
                    'sss' => $request->input('sss'),
                    'phic' => $request->input('phic'),
                    'hdmf' => $request->input('hdmf'),
                    'nid' => $request->input('nid'),
                    'sec' => $fileNameToStore_sec,
                    'bir' => $fileNameToStore_bir
                ]);
            }

            //$account_id = $employer->id;

            

            //$ess_id = $insert_ess->id;
            

            
            /*Send Mail */
            /*Tmp*/
            $data = array('name' => $user->name, "body" => $password);

            Mail::send('Email.mail', $data, function($message) use($employer, $user){
                $message->to($employer->contact_email, $employer->business_name)
                        ->subject("ESS Successfully Registered ");
                $message->from('esssample@gmail.com', "ESS");
            });

            $msg = 'Success';

            $this->insert_log("Create Account");

            // return redirect('Account')->with('success', 'Account Successfully Created');
            return Response::json($msg);
        }
        

        
    }

    public function edit($id){
        $Account = DB::table('employer')
                        ->join('user_type', 'employer.user_type', '=', 'user_type.id')
                        ->join('refprovince', 'employer.address_cityprovince', '=', 'refprovince.provCode')
                        ->join('refcitymun', 'employer.address_town', '=', 'refcitymun.citymunCode')
                        ->join('refbrgy', 'employer.address_barangay', '=', 'refbrgy.id')    
                        ->join('users', 'employer.account_id', '=', 'users.id')
                        ->select('employer.id', 'employer.business_name',
                         'employer.accountname',
                          'employer.address_unit',
                          'employer.address_cityprovince',
                          'employer.address_barangay',
                          'employer.address_zipcode',
                          'employer.contact_email', 
                          'employer.contact_person', 
                          'employer.contact_phone',
                          'employer.contact_mobile',
                          'employer.tin',
                          'employer.sss',
                          'employer.phic',
                          'employer.hdmf',
                          'employer.nid',
                          'employer.sec', 'employer.bir', 
                          'user_type.type_name', 
                          'user_type.id as user_type_id',
                          'users.AccountStatus', 
                          'employer.account_id',
                          'refprovince.provDesc',
                          'refprovince.provCode',
                          'refcitymun.citymunDesc',
                          'refcitymun.citymunCode',
                          'refbrgy.brgyDesc',
                          'refbrgy.id as refbrgy_id')
                        ->where('employer.account_id', $id)
                        ->get();
        return view('Account.edit', compact('Account'));
    }

    public function update(Request $request, $id){

        /*Validate Request*/
        $this->validate($request, [
            'user_type' => 'required|min:3',
            'accountname' => 'required|min:3',
            'business_name' => 'required|min:3',
            'user_type' => 'required',
            'address_unit' => 'required|min:3',
            'address_country' => 'required|min:3',
            'address_town' => 'required|min:3',
            'address_cityprovince' => 'required|min:3',
            'address_barangay' => 'required|min:3',
            'address_zipcode' => 'required|min:3',
            'contact_person' => 'required|min:3',
            'contact_phone' => 'required',
            'contact_mobile' => 'required',
            'contact_email' => 'required',
            'sss' => 'required|min:3',
            'tin' => 'required|min:3',
            'phic' => 'required|min:3',
            'hdmf' => 'required|min:3',
            'nid' => 'required|min:3',
        ]);

        // Handle File Upload
         if($request->hasFile('sec') && $request->hasFile('bir')){
            // Get filename with the extension
            $filenameWithExt_sec = $request->file('sec')->getClientOriginalName();
            $filenameWithExt_bir = $request->file('bir')->getClientOriginalName();
            // Get just filename
            $filename_sec = pathinfo($filenameWithExt_sec, PATHINFO_FILENAME);
            $filename_bir = pathinfo($filenameWithExt_bir, PATHINFO_FILENAME);
            // Get just ext
            $extension_sec = $request->file('sec')->getClientOriginalExtension();
            $extension_bir = $request->file('bir')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore_sec= $filename_sec.'_'.time().'.'.$extension_sec;
            $fileNameToStore_bir= $filename_bir.'_'.time().'.'.$extension_bir;
            // Upload Image
            $path_sec = $request->file('sec')->storeAs('public/Documents/sec', $fileNameToStore_sec);
            $path_bir = $request->file('bir')->storeAs('public/Documents/bir', $fileNameToStore_bir);
        } else {
            $fileNameToStore_sec = 'noifile.txt';
            $fileNameToStore_bir = 'noifile.txt';
        }

        /*Update Account Employer*/
        DB::table('employer')->where('account_id', '=', $id)
                            ->update(array(
                                'business_name' => $request->input('business_name'),
                                'accountname' => $request->input('accountname'),
                                'user_type' => $request->input('user_type'),
                                'address_unit' => $request->input('address_unit'),
                                'address_country' => $request->input('address_country'),
                                'address_town' => $request->input('address_town'),
                                'address_cityprovince' => $request->input('address_cityprovince'),
                                'address_barangay' => $request->input('address_barangay'),
                                'address_zipcode' => $request->input('address_zipcode'),
                                'contact_person' => $request->input('contact_person'),
                                'contact_phone' => $request->input('contact_phone'),   
                                'contact_mobile' => $request->input('contact_mobile'),
                                'contact_email' => $request->input('contact_email'),
                                'tin' =>$request->input('tin'),
                                'sss' => $request->input('sss'),
                                'phic' => $request->input('phic'),
                                'hdmf' => $request->input('hdmf'),
                                'nid' => $request->input('nid'),
                                'sec' => $fileNameToStore_sec,
                                'bir' => $fileNameToStore_bir
                            ));

        $msg = 'Success';

        // return redirect('Account')->with('success', 'Account Successfully Updated');

        $this->insert_log("Updated Account ");

        return Response::json($msg);
    }

    public function destroy(Request $request){
        $Account_id = $request->id;
        /*Delete User From Users*/
        $user = User::where('id','=',$Account_id)->delete();
        /*Delete User From Employer*/
        $employer = Account::where('account_id','=', $Account_id)->delete();
        /*Delete User From ESS Base Table*/
        $base = ESSBase::where('account_id','=',$Account_id)->delete();

        return response()->json(array(
            $user,
            $employer,
            $base
        ));

    }

    public function get_province(Request $request){
        $code = $request->code;
        $query = DB::table('refprovince')->select('id', 'provDesc', 'provCode')->orderBy('provDesc', 'ASC')->get();
        if ($code != null){
            $query = DB::table('refprovince')->select('id', 'provDesc', 'provCode')->where('provCode', $code)->get();
        }
         /*Protection for Data View as Json*/
        if($request->ajax()){
            return Response::json($query);
        }
        else {
            abort(404);
        }
        
    }

    public function get_citytown(Request $request, $provCode){
        $query = DB::table('refcitymun')->select('id', 'citymunDesc', 'provCode', 'citymunCode')->where('provCode', $provCode)->get();
        /*Protection for Data View as Json*/
        if($request->ajax()){
            return Response::json($query);
        }
        else {
            abort(404);
        }
    }

    public function get_barangay(Request $request, $citymunCode){
        $query = DB::table('refbrgy')->select('id', 'brgyDesc', 'citymunCode')->where('citymunCode', $citymunCode)->get();
        /*Protection for Data View as Json*/
        if($request->ajax()){
            return Response::json($query);
        }
        else {
            abort(404);
        }
    }

    public function get_user_type(Request $request){
        /*Get All Type Name Where Id = 3 => Employer, 8 => Merchant, 9 => Agent*/
        $query = DB::table('user_type')->select('id', 'type_name')->whereIn('id', array(3, 8, 9))->get();
        /*Protection for Data View as Json*/
        if($request->ajax()){
            return Response::json($query);
        }
        else {
            abort(404);
        }
    }

    /*Generate a Users Password*/
    public function generate_password($limit)
    {
        return substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $limit);
    }

    // Method for inserting into logs
    public function insert_log($event)
    {
        $inserlog = new Logs;
        $inserlog->account_id = auth()->user()->id;
        $inserlog->log_event = $event;
        $inserlog->save();
    }

    // Update Account Status
    public function UpdateAccountStatus(Request $request, $id){
        /*Update Account Employer*/
        $user = User::findOrFail($id);
        $user->AccountStatus = $request->input('AccountStatus');
        $user->save();

        if ($id == null && $request->input('AccountStatus') == null){
            $msg = 'Error';
        }
        else {
            $msg = 'Success';
        }

        $this->insert_log("Updated Account");


        return Response::json($msg);
    }
}
