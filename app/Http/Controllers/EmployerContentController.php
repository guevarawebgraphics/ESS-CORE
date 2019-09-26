<?php

namespace App\Http\Controllers;

/**
 *  Packages Facades
 * */
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Storage; 

use Session;
use Response;
use DB;
/**
 *  Insert Models Here
 * */
use App\EmployerContent;
use App\Logs; 
use App\BannerContent; 


class EmployerContentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');      
        $this->middleware('revalidate'); // Revalidate back history Security For Back Button
        $this->middleware(function($request, $next){
            if(Session::get("employer_content") == "none")
            {
                return redirect('error')->send();
            }
            else
            {
                return $next($request);
            }
        });     
    }
    private $add = '';
    private $edit = '';
    private $delete = '';
    public function getaccount()// call for every function for security of the system
    { 
        if(Session::get('employer_content') == 'all'){
            $this->add = '';
            $this->edit = '';
            $this->delete = '';
        }
        elseif(Session::get('employer_content') == 'view'){
            $this->add = 'disabled';
            $this->edit = 'disabled';
            $this->delete = 'disabled';
        }
        elseif(Session::get('employer_content') == 'add'){
            $this->add = '';
            $this->edit = 'disabled';
            $this->delete = 'disabled';
        }
        elseif(Session::get('employer_content') == 'edit'){
            $this->add = '';
            $this->edit = '';
            $this->delete = 'disabled';
        }
        elseif(Session::get('employer_content') == 'delete'){
            $this->add = '';
            $this->edit = 'disabled';
            $this->delete = '';
        }else{
            $this->add = 'disabled';
            $this->edit = 'disabled';
            $this->delete = 'disabled';
        } 
    }
    
    //show manage content
    public function manage()
    {   
        $employer_content = DB::connection('mysql')->select("SELECT * FROM employercontent ORDER BY created_at DESC");   
        return view('employer_modules.employer_content.manage')->with('employer_content', $employer_content);
    }
    public function manage_banner()
    {   
        $banner_content = DB::table('banner')->get();
        return view('employer_modules.employer_content.banner')->with('banner_content', $banner_content);
    }
    public function refresh_banner()
    {   
        $banner_content = DB::table('banner')->get();
        return view('employer_modules.employer_content.tablebanner')->with('banner_content', $banner_content);
    }  
    public function create_banner(Request $request) { 
        $this->validate($request, [
            'media_title' => 'required',
            'media_description' => 'required', 
            'banner_file' => 'required'
        ]);

        $filenameWithExt_banner_file = $request->file('banner_file')->getClientOriginalName();

        // Get just filename
        $filename_banner_file = pathinfo($filenameWithExt_banner_file, PATHINFO_FILENAME);

        // Get just ext
        $extension_banner_file = $request->file('banner_file')->getClientOriginalExtension();

        // Filename to store
        $fileNameToStore_banner_file = $filename_banner_file.'_'.time().'_'.'banner_file'.'.'.$extension_banner_file;

        // Upload Image
        $path_banner_file = $request->file('banner_file')->storeAs('public/Documents/banner_image', $fileNameToStore_banner_file); 
        $banner = BannerContent::create([
            'account_id' => auth()->user()->id, //Employer_ID
            'employer_id' => auth()->user()->employer_id, 
            'title_banner' => $request->input('media_title'),
            'description_banner' => $request->input('media_description'), 
            'media_file_banner' => $fileNameToStore_banner_file,
            'banner_status' => 0, //0 Means Pending Staus
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,

        ]); 
        return response()->json("hi");

    } 
    public function delete_banner(Request $request){
        $this->getaccount();
        $id = $request->id;
        $banner_title = $request->title;
        /*Delete Banner*/ 
        $old_filename = BannerContent::where('id','=',$id)->pluck('media_file_banner');
        Storage::delete('public/Documents/banner_image/'.$old_filename[0]); //delete file inside the storage
        $content = BannerContent::where('id', '=', $id)->delete();
        $message = 'Successfully Deleted';
        $this->insert_log("Deleted Employer Content '" . $banner_title . "'");
        return response()->json($message);    
    }
    public function post_banner(Request $request) {

        $update_banner = DB::table('banner')->where('id', '=', $request->id)
        ->update(array(
            'banner_status' => 1
        ));

    }
    //refresh manage content
    public function refresh_manage()
    {
        $employer_content = DB::connection('mysql')->select("SELECT * FROM employercontent ORDER BY created_at DESC");
        return view('employer_modules.employer_content.tablemanage')->with('employer_content', $employer_content);
    }
    //create employer content
    public function create_employercontent(Request $request)
    {
        $this->getaccount();
        /*Validate Request*/
        $this->validate($request, [
            'content_title' => 'required',
            'content_description' => 'required',
        ]);

        /*Check if all Request is not null*/
        if($request->all() != null){
            /*Create Content*/
            $Content = EmployerContent::create([
                'account_id' => auth()->user()->id, //Employer_ID
                'employer_id' => auth()->user()->employer_id, 
                'content_title' => $request->input('content_title'),
                'content_description' => $request->input('content_description'),
                'content_status' => 0, //0 Means Pending Staus
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,

            ]); 

             // Insert Log
            $this->insert_log("Create Employer Content '" . $request->input('content_title') . "'" );
        }

        return Response::json($Content);
    }
    //show edit content
    public function edit_content(Request $request)
    {
        $content_id = $request->id;
        $employer_content = EmployerContent::where('id', '=', $content_id)->get();

        return json_decode($employer_content);
    }

    //post update content
    public function update_content(Request $request)
    {       
        $this->getaccount();
        /*Validate Request*/
        $this->validate($request, [
            'content_title' => 'required',
            'content_description' => 'required',
        ]);

        /*Check if all Request is not null*/
        if($request->all() != null){
            /*Update Content*/
            $update_content = DB::table('employercontent')->where('id', '=', $request->input('hidden_id'))
                                ->update(array(
                                    'account_id' =>  auth()->user()->employer_id, // Employer ID
                                    'content_title' => $request->input('content_title'),
                                    'content_description' => $request->input('content_description'),
                                    'content_status' => 0, //0 Means Pending Staus
                                    'updated_by' => auth()->user()->id,
                        ));

             // Insert Log
            $this->insert_log("Update Employer Content '" . $request->input('content_title') . "'");
        }

        
         return Response::json($update_content);
    }

    //delete function
    public function delete_content(Request $request)
    {
        $this->getaccount();
        $id = $request->id;
        $content_title = $request->title;
        /*Delete Content*/
        $content = EmployerContent::where('id', '=', $id)->delete();
        $message = 'Successfully Deleted';
        $this->insert_log("Deleted Employer Content '" . $content_title . "'");
        return response()->json($message);      
    }

    //post content
    public function post_content(Request $request)
    {
        $this->getaccount();
        $post_content = EmployerContent::find($request->id);
        $post_content->content_status = 1;
        $post_content->save();
        $this->insert_log("Post Employer Content '" . $request->title . "'");
    }


    // Method for inserting into logs
    public function insert_log($event)
    {
        $inserlog = new Logs;
        $inserlog->account_id = auth()->user()->id;
        $inserlog->log_event = $event;
        $inserlog->save();
    }
    public function linkpreview(Request $request){
        $search = "href.";
        if(preg_match("/{$search}/i",$request->content)) {
         //   echo 'true'; 
            $link = ''.$request->content.'';
            preg_match_all('/<a[^>]+href=([\'"])(?<href>.+?)\1[^>]*>/i', $link, $result);
    

            if (!empty($result)) {
          
                $str =  file_get_contents("".$result['href'][0]."");
                if(strlen($str)>0){
                $str = trim(preg_replace('/\s+/', ' ', $str)); // supports line breaks inside <title>
                preg_match("/\<title\>(.*)\<\/title\>/i",$str,$title); // ignore case 
                preg_match("/\<p\>(.*)\<\/p\>/i",$str,$description);
                preg_match("/\<p\>(.*)\<\/p\>/i",$str,$description);
                if(empty($description[1])){
                    $des = ["","No Description Available On This Website"];
                }
                if(!empty($description[1])) 
                {   
                    $des = ["","".$description[1].""]; 
                    $des  = str_limit($description[1],100); 
                }
        

                $title_real = str_limit($title[1],100);
                $link_real = $result['href'][0];
                $values =  array( $title_real, $des, $link_real);
                        
              }
              return response()->json($values);
            } 
         
          } 
        
           
    }
 

}
