<?php

namespace App\Http\Controllers;
use App\Account;

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
        return view('Account.index');
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
            'address_unit' => ['required', 'min:3'],
            'address_country' => ['required', 'min:3'],
            'address_town' => ['required', 'min:3'],
            'address_town' => ['required', 'min:3'],
            'address_cityprovince' => ['required', 'min:3'],
            'address_barangay' => ['required', 'min:3'],
            'address_zipcode' => ['required', 'min:3'],
            'contact_person' => ['required', 'min:3'],
            'contact_phone' => ['required', 'min:3'],
            'contact_mobile' => ['required', 'min:3'],
            'contact_email' => ['required', 'min:3'],
            'tin' => ['required', 'min:3'],
            'sss' => ['required', 'min:3'],
            'phic' => ['required', 'min:3'],
            'hdmf' => ['required', 'min:3'],
            'nid' => ['required', 'min:3'],
        ], $customMessages));

        return redirect('Account');
    }

    public function get_province(Request $request){
        $query = DB::table('refprovince')->select('provDesc');

        return respose($query);
    }
}
