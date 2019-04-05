<?php

namespace App\Http\Controllers;
use App\Account;
use DB;
use Response;

use Illuminate\Http\Request;

class AccountController extends Controller
{
    // Security Authentication
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $Account = Account::all();
        return view('Account.index', compact('Account'));
    }

    public function create()
    {
        return view('Account.create');
    }

    public function store()
    {
        // Custome Message
        $customMessages = [
            'required' => 'The :attribute field is required.'
        ];
        Account::create(request()->validate([
            // Array Fields Here
            'shortname' => ['required', 'min:3'],
            'accountname' => ['required', 'min:3'],
            'user_type' => ['required'],
            'address_unit' => ['required', 'min:3'],
            'address_country' => ['required', 'min:3'],
            'address_town' => ['required', 'min:3'],
            'address_cityprovince' => ['required', 'min:3'],
            'address_barangay' => ['required', 'min:3'],
            'address_zipcode' => ['required', 'min:3', 'numeric', 'min:5'],
            'contact_person' => ['required', 'min:3'],
            'contact_phone' => ['required', 'min:3', 'numeric', 'min:5'],   
            'contact_mobile' => ['required', 'min:3', 'numeric', 'min:5'],
            'contact_email' => ['required', 'min:3', 'unique:employer'],
            'tin' => ['required', 'min:3', 'numeric', 'min:5'],
            'sss' => ['required', 'min:3', 'numeric', 'min:5'],
            'phic' => ['required', 'min:3', 'numeric', 'min:5'],
            'hdmf' => ['required', 'min:3', 'numeric', 'min:5'],
            'nid' => ['required', 'min:3', 'numeric', 'min:5'],
        ], $customMessages));

        return redirect('Account');
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
        $query = DB::table('user_type')->select('id', 'type_description')->get();
        /*Protection for Data View as Json*/
        if($request->ajax()){
            return Response::json($query);
        }
        else {
            abort(404);
        }
    }
}
