<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\UserType;
use App\UserModuleAccess;
use App\Logs;
use Session;
use DB;

class ManageUserController extends Controller
{
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
        $users = DB::connection('mysql')->select("SELECT * FROM users WHERE AccountStatus = '1' AND created_by = 'default' OR created_by = '".auth()->user()->id."' "); //--> meron dapat diton g where clause para ma filter kung ano lang ang dapat nyang ishow
        return view('admin_modules.createuser')->with('users', $users);
    }

    //show user types on table for Manage User Access View
    public function manageusertypes()
    {       
        $user_type = DB::connection('mysql')->select("SELECT * FROM user_type WHERE deleted = '0' AND account_id = 'default' OR account_id = '".auth()->user()->id."' ");
        return view ('admin_modules.manageusers')->with('user_type', $user_type);              
    }

    //refresh user table
    public function refreshtable_user()
    {
        $users = DB::connection('mysql')->select("SELECT * FROM users WHERE AccountStatus = '1'  AND created_by = 'default' OR created_by = '".auth()->user()->id."' "); //--> Same sa create user function
        return view ('admin_modules.table.tableuser')->with('users', $users);        
    }

    //refresh user type table
    public function refreshtable_usertype()
    {
        $user_type = DB::connection('mysql')->select("SELECT * FROM user_type WHERE deleted = '0' AND account_id = 'default' OR account_id = '".auth()->user()->id."' ");
        return view ('admin_modules.table.tableusertype')->with('user_type', $user_type);        
    }

    //load user types for dropdown in register
    public function load_usertype()
    {       
        $data = "";
        $i = 1;
        $user_type = DB::connection('mysql')->select("SELECT * FROM user_type WHERE deleted = '0' AND account_id = 'default' OR account_id = '".auth()->user()->id."' ");

        if(count($user_type) > 0)
        {
            foreach($user_type as $user)
            {   
                $data .= '<option value="'. $i .'">'. $user->type_name .'</option>';

                $i++;
            }
        }
        else 
        {
            $data .= '<option value="">No User Type</option>';
        }

        echo $data;      
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
        $userId = $request->input('hidden_id');
        $module_name = DB::connection('mysql')->select("SELECT module_code,module_name FROM user_modules WHERE deleted = '0'");
        
        $moduleRow[] = '';
        foreach($module_name as $um)
        {
            $valType = $request->get($um->module_code);  
            $userAccess = DB::connection("mysql")->select("UPDATE user_module_access SET ". $um->module_code ." = '$valType' WHERE user_type_id = '$userId'");           
        }
        
        $this->insert_log("Update manage access");
    }

    //create user type post
    public function createusertype_post(Request $request)
    {
        $typename = $request->input('type_name');
        $typedesc = $request->input('type_desc');
       
        $insert_query = new UserType;
        $insert_query->type_name = $typename;
        $insert_query->type_description = $typedesc;
        $insert_query->deleted = 0;
        $insert_query->account_id = auth()->user()->id;
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
        
        $this->insert_log("Created user type");
    }

    //update user type post
    public function updateusertype_post(Request $request)
    {
        $typeName = $request->typeName;
        $typeDesc = $request->typeDesc;
        $userTypeID = $request->userTypeID;

        $update_query = UserType::find($userTypeID);
        $update_query->type_name = $typeName;
        $update_query->type_description = $typeDesc;
        $update_query->updated_by = auth()->user()->id;
        $update_query->save();

        $this->insert_log("Updated user type");
    }

    //delete user type post
    public function deleteusertype_post(Request $request)
    {
        $userTypeID = $request->userTypeID;
        
        $update_query = UserType::find($userTypeID);
        $update_query->deleted = 1;
        $update_query->updated_by = auth()->user()->id;
        $update_query->save();

        $this->insert_log("Deleted user type");
    }

    //delete user post
    public function deleteuser_post(Request $request)
    {
        $userTypeID = $request->userTypeID;
        
        $update_query = User::find($userTypeID);
        $update_query->AccountStatus = 0;
        $update_query->updated_by = auth()->user()->id;
        $update_query->save();

        $this->insert_log("Deleted user");
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
