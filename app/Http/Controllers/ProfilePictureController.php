<?php

namespace App\Http\Controllers;

use DB;
use Session;
use Auth;
use Response;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ProfilePictureController extends Controller
{
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


    /**
     * @ Get Profile Picture
     * */
    public function get_profile_picture(Request $request)
    {
        $user_picture = DB::table('user_picture')->where('user_id', '=', auth()->user()->id)->pluck('profile_picture');

        return response()->json($user_picture);
    }
}
