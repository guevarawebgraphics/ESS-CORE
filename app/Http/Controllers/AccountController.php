<?php

namespace App\Http\Controllers;
use App\Account;
use App\UserType;
use App\User;
use App\ESSBase;
use Session;
use DB;
use Response;
use Mail;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
                        // ->join('users', 'employer.account_id', '=', 'users.id')
                        ->select('employer.id', 'employer.shortname', 'employer.accountname', 'employer.contact_email', 'employer.sec', 'employer.bir', 'user_type.type_name')
                        ->get();
        return view('Account.index', compact('Account'));
    }

    public function create()
    {
        return view('Account.create');
    }

    public function store(Request $request)
    {
        $shortname = Input::get('shortname');
        $password = $this->generate_password(8);

        // Custom Message
        $customMessages = [
            'required' => 'The :attribute field is required.'
        ];

        /*Validate Request*/
        $this->validate($request, [
            'user_type' => 'required|min:3',
            'accountname' => 'required|unique:employer|min:3',
            'shortname' => 'required|unique:employer|min:3',
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

        

        if ($shortname == 'shortname'){

        }
        else {
            /*Create User*/
            $user = User::create([
                'user_type_id' => $request->input('user_type'),
                'name' => $request->input('shortname'),
                'username' => $request->input('shortname'),
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
            $insert_ess->created_by = auth()->user()->name;
            $insert_ess->updated_by = auth()->user()->name;
            $insert_ess->save();


            
            /*Check if the request is Employer*/
            if ($request->input('user_type') == 3){
                /*Create Account Employer*/
                $employer = Account::create([
                    // Array Fields Here
                    'account_id' => $Account_id,
                    'shortname' => $request->input('shortname'),
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
                $message->to($employer->contact_email, $employer->shortname)
                        ->subject("ESS Successfully Registered ");
                $message->from('esssample@gmail.com', "ESS");
            });

            $msg = 'Success';

            // return redirect('Account')->with('success', 'Account Successfully Created');
            return Response::json($msg);
        }
        

        
    }

    public function edit(Account $Account){
        return view('Account.edit', compact('Account'));
    }

    public function update(Account $Account, Request $request){

        /*Validate Request*/
        $this->validate($request, [
            'user_type' => 'required|min:3',
            'accountname' => 'required|min:3',
            'shortname' => 'required|min:3',
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
        $Account->update([
            // Array Fields Here
            'shortname' => $request->input('shortname'),
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

        $msg = 'Success';

        // return redirect('Account')->with('success', 'Account Successfully Updated');

        return Response::json($msg);
    }

    public function destroy(Account $Account){
        $Account->delete();

        /*Delete User From Users*/
        $user = DB::table('users')->where('id', $Account)->delete();
        /*Delete User From Employer*/
        $employer = DB::table('employer')->where('account_id', $Account)->delete();

        ///return redirect('Account');
        return response()->json($Account);

    }

    public function get_province(Request $request){
        $query = DB::table('refprovince')->select('id', 'provDesc', 'provCode')->orderBy('provDesc', 'ASC')->get();
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
}
