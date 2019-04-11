<?php

namespace App\Http\Controllers;
use App\Account;
use App\UserType;
use App\User;
use App\ESSBase;
use Session;
use DB;
use Response;

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
                        ->select('employer.id', 'employer.shortname', 'employer.accountname', 'employer.contact_email', 'user_type.type_name')
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
            'contact_phone' => 'required|unique:employer',
            'contact_mobile' => 'required|unique:employer',
            'contact_email' => 'required|unique:employer',
            'sss' => 'required|min:3',
            'tin' => 'required|min:3',
            'phic' => 'required|min:3',
            'hdmf' => 'required|min:3',
            'nid' => 'required|min:3',
        ]);

        // Custom Message
        $customMessages = [
            'required' => 'The :attribute field is required.'
        ];

        if ($shortname == 'shortname'){

        }
        else {
            
            /*Check if the request is Employer*/
            if ($request->input('user_type') == 3){
                /*Create Account Employer*/
                $employer = Account::create([
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
                ]);
            }

            $account_id = $employer->id;

            $insert_ess = new ESSBase;
            $insert_ess->account_id = $account_id;
            $insert_ess->user_type_id = $request->input('user_type');            
            $insert_ess->created_by = auth()->user()->name;
            $insert_ess->updated_by = auth()->user()->name;

            $insert_ess->save();

            $ess_id = $insert_ess->id;
            

            /*Creat User*/
            User::create([
                'user_type_id' => $request->input('user_type'),
                'name' => $request->input('shortname'),
                'username' => $request->input('shortname'),
                'password' => Hash::make($request['shortname']),
                'created_by' => auth()->user()->name,
                'updated_by' => auth()->user()->name,
            ]);

            return redirect('Account')->with('success', 'Account Successfully Created');
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
        ]);

        return redirect('Account')->with('success', 'Account Successfully Updated');
    }

    public function destroy(Account $Account){
        $Account->delete();

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
}
