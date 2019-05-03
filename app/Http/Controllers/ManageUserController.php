<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\UserType;
use App\UserModuleAccess;
use App\Logs;
use App\Account;
use Session;
use DB;

class ManageUserController extends Controller
{
    private $add = '';
    private $edit = '';
    private $delete = '';
    public function getaccount()// call for every function for security of the system
    { 
        if(Session::get('manage_users') == 'all'){
            $this->add = '';
            $this->edit = '';
            $this->delete = '';
        }
        elseif(Session::get('manage_users') == 'view'){
            $this->add = 'disabled';
            $this->edit = 'disabled';
            $this->delete = 'disabled';
        }
        elseif(Session::get('manage_users') == 'add'){
            $this->add = '';
            $this->edit = 'disabled';
            $this->delete = 'disabled';
        }
        elseif(Session::get('manage_users') == 'edit'){
            $this->add = '';
            $this->edit = '';
            $this->delete = 'disabled';
        }
        elseif(Session::get('manage_users') == 'delete'){
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
        $this->middleware(function($request, $next){
            if(Session::get("manage_users") == "none")
            {
                return redirect('error')->send();
            }
            else
            {
                return $next($request);
            }
        });     
    }
    //show view create user
    public function createuser()
    {
        $users = "";
        // $users = DB::connection('mysql')->select("SELECT a.*, b.type_name FROM users AS a LEFT JOIN user_type AS b ON a.user_type_id = b.id WHERE a.AccountStatus = '1' AND a.created_by = 'default' OR a.created_by = '".auth()->user()->id."' "); //--> meron dapat diton g where clause para ma filter kung ano lang ang dapat nyang ishow
        if(auth()->user()->user_type_for == 1 || auth()->user()->user_type_for == 2)
        {
            $users = DB::connection('mysql')->select("SELECT a.*, b.type_name FROM users AS a LEFT JOIN user_type AS b ON a.user_type_id = b.id WHERE a.AccountStatus = '1' AND a.created_by != 'default' ");
            return view('admin_modules.createuser')->with('users', $users);
        }
        else if(auth()->user()->user_type_for == 3 || auth()->user()->user_type_for == 4)
        {
            $users = DB::connection('mysql')->select("SELECT a.*, b.type_name FROM users AS a LEFT JOIN user_type AS b ON a.user_type_id = b.id WHERE a.AccountStatus = '1' AND a.created_by != 'default' AND (a.user_type_for = '3' OR a.user_type_for = '4') AND a.employer_id = '".auth()->user()->employer_id."' ");
            return view('admin_modules.createuser')->with('users', $users);
        }
        //Wala pang cms dito pero dapat may cms
    }

    //show user types on table for Manage User Access View
    public function manageusertypes()
    {     
        // $user_type = DB::connection('mysql')->select("SELECT * FROM user_type WHERE deleted = '0' AND account_id = 'default' OR account_id = '".auth()->user()->id."' ");
        $user_type = DB::connection('mysql')->select("SELECT * FROM user_type WHERE deleted = '0' ORDER BY created_at DESC");
       
        if(Session::get("employer_id") != "admin")
        {                    
            return view('welcome');
        }
        else
        {                   
            return view ('admin_modules.manageusers')->with('user_type', $user_type);         
        } 
        // return view ('admin_modules.manageusers')->with('user_type', $user_type);        
    }

    //refresh user table
    public function refreshtable_user()
    {
        // $users = DB::connection('mysql')->select("SELECT a.*, b.type_name FROM users AS a LEFT JOIN user_type AS b ON a.user_type_id = b.id WHERE a.AccountStatus = '1' AND a.created_by = 'default' OR a.created_by = '".auth()->user()->id."' "); //--> Same sa create user function
        // $users = DB::connection('mysql')->select("SELECT a.*, b.type_name FROM users AS a LEFT JOIN user_type AS b ON a.user_type_id = b.id WHERE a.AccountStatus = '1' AND a.created_by != 'default' ");
        // return view ('admin_modules.table.tableuser')->with('users', $users);
        $users = "";
        // $users = DB::connection('mysql')->select("SELECT a.*, b.type_name FROM users AS a LEFT JOIN user_type AS b ON a.user_type_id = b.id WHERE a.AccountStatus = '1' AND a.created_by = 'default' OR a.created_by = '".auth()->user()->id."' "); //--> meron dapat diton g where clause para ma filter kung ano lang ang dapat nyang ishow
        if(auth()->user()->user_type_for == 1 || auth()->user()->user_type_for == 2)
        {
            $users = DB::connection('mysql')->select("SELECT a.*, b.type_name FROM users AS a LEFT JOIN user_type AS b ON a.user_type_id = b.id WHERE a.AccountStatus = '1' AND a.created_by != 'default' ");
            return view('admin_modules.table.tableuser')->with('users', $users);
        }
        else if(auth()->user()->user_type_for == 3 || auth()->user()->user_type_for == 4)
        {
            $users = DB::connection('mysql')->select("SELECT a.*, b.type_name FROM users AS a LEFT JOIN user_type AS b ON a.user_type_id = b.id WHERE a.AccountStatus = '1' AND a.created_by != 'default' AND (a.user_type_for = '3' OR a.user_type_for = '4') AND a.employer_id = '".auth()->user()->employer_id."' ");
            return view('admin_modules.table.tableuser')->with('users', $users);
        }        
        //Wala pang cms dito pero dapat may cms
    }

    //refresh user type table
    public function refreshtable_usertype()
    {
        // $user_type = DB::connection('mysql')->select("SELECT * FROM user_type WHERE deleted = '0' AND account_id = 'default' OR account_id = '".auth()->user()->id."' ");
        $user_type = DB::connection('mysql')->select("SELECT * FROM user_type WHERE deleted = '0' ORDER BY created_at DESC ");
        return view ('admin_modules.table.tableusertype')->with('user_type', $user_type);        
    }

    //load user types for dropdown in register
    public function load_usertype()
    {       
        $data = "";
        $query = "";
        
        if(auth()->user()->user_type_for == 1 || auth()->user()->user_type_for == 2)
        {
            // $user_type = DB::connection('mysql')->select("SELECT * FROM user_type WHERE deleted = '0' AND user_type_for = '2' ");
            $user_type = DB::connection('mysql')->select("SELECT * FROM user_type WHERE deleted = '0' ");
            if(count($user_type) > 0)
            {
                foreach($user_type as $user)
                {   
                    $data .= '<option value="'. $user->id .'">'. $user->type_name .'</option>';               
                }
            }
            else 
            {
                $data .= '<option value="">No User Type</option>';
            }
    
            echo $data;  
        }
        else if(auth()->user()->user_type_for == 3 || auth()->user()->user_type_for == 4)
        {
            //$get_employer = DB::connection('mysql')->select("SELECT id FROM employer WHERE account_id = '".auth()->user()->id."' ");
            $user_type = DB::connection('mysql')->select("SELECT * FROM user_type WHERE deleted = '0' AND user_type_for = '4' AND (employer_id = '".Session::get("employer_id")."' OR employer_id = 'default')  ");
            if(count($user_type) > 0)
            {
                foreach($user_type as $user)
                {   
                    $data .= '<option value="'. $user->id .'">'. $user->type_name .'</option>';               
                }
            }
            else 
            {
                $data .= '<option value="">No User Type</option>';
            }
    
            echo $data;  
        }
        else if(auth()->user()->user_type_for == 5 || auth()->user()->user_type_for == 6)
        {
            $user_type = DB::connection('mysql')->select("SELECT * FROM user_type WHERE deleted = '0' AND user_type_for = '6' ");
            if(count($user_type) > 0)
            {
                foreach($user_type as $user)
                {   
                    $data .= '<option value="'. $user->id .'">'. $user->type_name .'</option>';               
                }
            }
            else 
            {
                $data .= '<option value="">No User Type</option>';
            }
    
            echo $data;  
        }
    }

    //show module access on table
    public function show_module(Request $request)
    {
        $userId = $request->id;
        $module_name = DB::connection('mysql')->select("SELECT module_code,module_name FROM user_modules WHERE deleted = '0'");
        
        $moduleRow[] = '';
        foreach($module_name as $um)
        {
            $userAccess = DB::connection("mysql")->select("SELECT ". $um->module_code ." AS module_access FROM user_module_access WHERE user_type_id = '$userId' ");
            $moduleRow[$um->module_code] = $userAccess[0]->module_access;
        }
        
        return view ('admin_modules.table.tablemanageaccessmodule')->with('module_name', $module_name)->with('moduleRow', $moduleRow);      
    }

    //update module access
    public function update_module_access(Request $request)
    {
        $this->getaccount();
        $userId = $request->input('hidden_id');
        $module_name = DB::connection('mysql')->select("SELECT module_code,module_name FROM user_modules WHERE deleted = '0'");
        
        $moduleRow[] = '';
        foreach($module_name as $um)
        {
            $valType = $request->get($um->module_code);  
            $userAccess = DB::connection("mysql")->select("UPDATE user_module_access SET ". $um->module_code ." = '$valType' WHERE user_type_id = '$userId'");           
        }
        $type_name = $request->input('hidden_typename');
        $this->insert_log("Updated Manage Access of User Type '" . $type_name . "'");
    }

    //create user type post
    public function createusertype_post(Request $request)
    {
        $this->getaccount();
        $typename = $request->input('type_name');
        $typedesc = $request->input('type_desc');
        $typefor = $request->input('cmb_userTypeFor');
        $employer_id = $request->input('cmb_Employe');

        $this->validate($request, [
            'type_name' => 'required',
            'cmb_Employe' => 'required',
        ]);

        if($request->all() != null)
        {
            $insert_query = new UserType;
            $insert_query->type_name = $typename;
            $insert_query->type_description = $typedesc;
            $insert_query->user_type_for = $typefor;
            if($employer_id != "")
            {
                $insert_query->employer_id = $employer_id;
            }
            $insert_query->deleted = 0;
            //$insert_query->account_id = auth()->user()->id;
            $insert_query->created_by = auth()->user()->id;
            $insert_query->updated_by = auth()->user()->id;
    
            $insert_query->save();
    
            $user_type_id = $insert_query->id;
            
            $insert_access = new UserModuleAccess;
            $insert_access->user_type_id = $user_type_id;           
            $insert_access->deleted = 0;
            $insert_access->created_by = auth()->user()->id;
            $insert_access->updated_by = auth()->user()->id;   
            $insert_access->save();       
            
            $this->insert_log("Created User Type '" . $typename . "'");
        }
        else
        {
            echo "ERROR";
        }      
    }

    //update user type post
    public function updateusertype_post(Request $request)
    {
        $this->getaccount();
        $typeName = $request->typeName;
        $typeDesc = $request->typeDesc;
        $userTypeID = $request->userTypeID;

        $update_query = UserType::find($userTypeID);
        $update_query->type_name = $typeName;
        $update_query->type_description = $typeDesc;
        $update_query->updated_by = auth()->user()->id;
        $update_query->save();
        $usertypeid = $update_query->id;
        $this->insert_log("Updated User Type '" . $typeName . "'");
    }

    //delete user type post
    public function deleteusertype_post(Request $request)
    {
        $this->getaccount();
        $userTypeID = $request->userTypeID;
        $userTypeName = $request->userTypeName;
        
        $update_query = UserType::find($userTypeID);
        $update_query->deleted = 1;
        $update_query->updated_by = auth()->user()->id;
        $update_query->save();

        $this->insert_log("Deleted User Type '" . $userTypeName . "'");
    }

    //delete user post
    public function deleteuser_post(Request $request)
    {
        $this->getaccount();
        $userTypeID = $request->userTypeID;
        $userName = $request->userName;
        
        $update_query = User::find($userTypeID);
        $update_query->AccountStatus = 0;
        $update_query->updated_by = auth()->user()->id;
        $update_query->save();

        $this->insert_log("Deleted User '" . $userName  . "'");
    }

    // Method for inserting into logs
    public function insert_log($event)
    {
        $inserlog = new Logs;
        $inserlog->account_id = auth()->user()->id;
        $inserlog->log_event = $event;
        $inserlog->save();
    }

    //sample employer
    public function loademployer()
    {
        $data = "";
    
        $employer = DB::connection('mysql')->select("SELECT * FROM employer");

        if(count($employer) > 0)
        {
            foreach($employer as $user)
            {   
                $data .= '<option value="'. $user->id .'">'. $user->business_name .'</option>';   
            }
        }
        else 
        {
            $data .= '<option value="">No User Type</option>';
        }

        echo $data;      
    }
}
