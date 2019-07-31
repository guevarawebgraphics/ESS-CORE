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
                                                            'employer_id' => (auth()->user()->user_type_id == 3) ? auth()->user()->employer_id : 0,
                                                            'profile_picture' => $fileNameToStore_profile_picture,
                                                            'changed_status' => 1,
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
      $status = DB::table('user_picture')->where('user_id','=',auth()->user()->id)->first();
      $changed_status = $status->changed_status;
      if($changed_status === 0)
      {
        $profile_picture_value = '/storage/profile_picture/ESS_DEFAULT_PICTURE/'.$user_picture;
      }
      else 
      {
        $profile_picture_value = '/storage/profile_picture/'.$user_picture; 
      }
            return response::json($profile_picture_value);   
    }
}
