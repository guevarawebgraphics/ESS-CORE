<?php

namespace App\Http\Controllers;

use DB;
use Session;
use Auth;
use Response;

/**
 *  Insert Packages Here
 *  */

use Carbon\Carbon;

/**
 *  Packages Facades
 * */

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage; 

class ProfilePictureController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');      
        $this->middleware('revalidate'); // Revalidate back history Security For Back Button
    }
    
    public function UploadPicture(Request $request)
    {
        /**
         * @ Validate Images
         * */
        $this->validate($request, [
            'profile_picture' => 'mimes:jpeg,png,jpg|dimensions:min_width=501,min_height=500|max:2048'
        ]);

        // Handle File Upload
        if($request->hasFile('profile_picture')){
            // Get filename with the extension
            $filenameWithExt_profile_picture = $request->file('profile_picture')->getClientOriginalName();

            // Get just filename
            $filename_profile_picture = pathinfo($filenameWithExt_profile_picture, PATHINFO_FILENAME);

            // Get just ext
            $extension_profile_picture = $request->file('profile_picture')->getClientOriginalExtension();

            // Filename to store
            $fileNameToStore_profile_picture = $filename_profile_picture.'_'.time().'_'.'profile_picture'.'.'.$extension_profile_picture;

            // Upload Image
            $path_profile_picture = $request->file('profile_picture')->storeAs('public/profile_picture', $fileNameToStore_profile_picture);

            /**
             * @ Create User Profile Picture
             **/
            DB::table('user_picture')->insert([
                'user_id' => auth()->user()->id,
                'profile_picture' => $fileNameToStore_profile_picture,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
 
        }

    
        return response()->json();
    }
    public function UpdatePicture(Request $request)
    {
         /**
         * @ Validate Images
         * */
        $this->validate($request, [
            'profile_picture' => 'mimes:jpeg,png,jpg|dimensions:min_width=501,min_height=500|max:2048'
        ]);

        // Handle File Upload
        if($request->hasFile('profile_picture')){

                    // Get existing filename with the extension
                    $get_exist_filename = DB::table('user_picture')
                                            ->select('user_id','profile_picture')
                                            ->where('user_id','=',auth()->user()->id)
                                            ->first();

                    $old_filename =  $get_exist_filename->profile_picture;  //get old profile name to delete
                     
                    Storage::delete('public/profile_picture/'.$old_filename); //delete file inside the storage
   
            
                    $filenameWithExt_profile_picture = $request->file('profile_picture')->getClientOriginalName();

                    // Get just filename
                    $filename_profile_picture = pathinfo($filenameWithExt_profile_picture, PATHINFO_FILENAME);

                    // Get just ext
                    $extension_profile_picture = $request->file('profile_picture')->getClientOriginalExtension();

                    // Filename to store
                    $fileNameToStore_profile_picture = $filename_profile_picture.'_'.time().'_'.'profile_picture'.'.'.$extension_profile_picture;

                    // Upload Image
                    $path_profile_picture = $request->file('profile_picture')->storeAs('public/profile_picture', $fileNameToStore_profile_picture);

            /**
             * @ Create User Profile Picture
             **/
                    DB::table('user_picture')->where('user_id','=',auth()->user()->id)
                                                    ->update(array(
                                                            'profile_picture' => $fileNameToStore_profile_picture,
                                                            'created_at' => Carbon::now(),
                                                            'updated_at' => Carbon::now()
                                                    ));
 
        }

        return response()->json();

    }


    /**
     * @ Get Profile Picture
     * */
    public function get_profile_picture(Request $request)
    {
      $user_picture = DB::table('user_picture')->where('user_id', '=', auth()->user()->id)->pluck('profile_picture')->first();
        if($user_picture){

            return response::json($user_picture);
        }
        else 
        {
                //Employer should be always have male profile as default
                if(auth()->user()->employee_id=="none"){
                    
                    $user_picture = "essmale.png";
                    return response::json($user_picture);

                }
                else 
                {  
                    //Joining tables 
                    //e as Employee Table 
                    //epi as Employee_personal_information Table 

                    $employee_table = DB::table('employee as e')
                                            ->join('employee_personal_information as epi','e.employee_info','=','epi.id')
                                            ->select('e.id as idno','epi.gender as gender')
                                            ->where('e.id','=',auth()->user()->employee_id)
                                            ->first();
                                            
                                            $user_picture = $employee_table->gender; //gets the gender of the user 
                                            
                                            //providing default picture 
                                            if($user_picture == "Female") 
                                            {
                                                        $user_picture = "essfemale.png";
                                            }
                                            else
                                            {
                                                        $user_picture = "essmale.png";
                                            }
                                            return response::json($user_picture);
                }                          
        }
                
    }
}
