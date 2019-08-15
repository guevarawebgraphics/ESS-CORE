<?php

namespace App\Http\Controllers;

/**
 *  Packages Facades
 *  */
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 *  Insert Packages Here
 *  */
use DB;
use Session;
use Response;


/**
 *  Insert Model Here
 *  */
use App\Template;
use App\Logs;


class TemplateController extends Controller
{
    private $add = '';
    private $edit = '';
    private $delete = '';
    public function getaccount()// call for every function for security of the system
    { 
        if(Session::get('	
manage_docs') == 'all'){
            $this->add = '';
            $this->edit = '';
            $this->delete = '';
        }
        elseif(Session::get('	
manage_docs') == 'view'){
            $this->add = 'disabled';
            $this->edit = 'disabled';
            $this->delete = 'disabled';
        }
        elseif(Session::get('	
manage_docs') == 'add'){
            $this->add = '';
            $this->edit = 'disabled';
            $this->delete = 'disabled';
        }
        elseif(Session::get('	
manage_docs') == 'edit'){
            $this->add = '';
            $this->edit = '';
            $this->delete = 'disabled';
        }
        elseif(Session::get('	
manage_docs') == 'delete'){
            $this->add = '';
            $this->edit = 'disabled';
            $this->delete = '';
        }else{
            $this->add = 'disabled';
            $this->edit = 'disabled';
            $this->delete = 'disabled';
        } 
    }
    // Security Authentication
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('revalidate'); // Revalidate back history Security For Back Button
        $this->middleware(function($request, $next){
            if(Session::get("manage_docs") == "none")
            {
                return redirect('error')->send();
            }
            else
            {
                return $next($request);
            }
        }); 
    }

    public function index(){
        //$Notification = Notifications::all();
        $employers = DB::table('employer')->select('id', 'business_name')->get();
        return view('Template.index', compact('employers'));
    }

    public function get_all_template(){
        $Template = DB::table('template')
                            ->join('employer', 'employer.id', '=', 'template.account_id')
                            ->select('template.id',
                            'template.document_code',
                            'template.document_description',
                            'template.document_file',
                            'employer.business_name')
                            ->latest('template.created_at')
                            ->get();
        return json_encode($Template);
    }

    public function store_template(Request $request){
        $this->getaccount();
        /*Validate Request*/
        $this->validate($request, [
            'employer_id' => 'required',
            'document_code' => 'required',
            'document_description' => 'required',
            'document_file' => 'required|file',
        ]);

        // Handle File Upload
        if($request->hasFile('document_file')){
            // Get filename with the extension
            $filenameWithExt_document_file = $request->file('document_file')->getClientOriginalName();
            // Get just filename
            $filename_document_file = pathinfo($filenameWithExt_document_file, PATHINFO_FILENAME);
            // Get just ext
            $extension_document_file = $request->file('document_file')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore_document_file= $filename_document_file.'_'.time().'.'.$extension_document_file;
            // Upload Image
            $path_document_file = $request->file('document_file')->storeAs('public/Documents/templates', $fileNameToStore_document_file);
        } else {
            $fileNameToStore_document_file = 'noifile.txt';
        }

        /*Check if all Request is not null*/
        if($request->all() != null){
            /*Create Template Document*/
            $template = Template::create([
                'account_id' => $request->input('employer_id'),
                'document_code' => $request->input('document_code'),
                'document_description' => $request->input('document_description'),
                'document_file' => $fileNameToStore_document_file,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id
            ]);
        } 

        // Insert Log
        $this->insert_log("Create Template");
        return Response::json($template);
    }

    public function edit_template(Request $request){
        $Template_id = $request->id;
        $Template = DB::table('template')
                        ->join('employer', 'employer.id', '=', 'template.account_id')
                        ->select('template.id',
                        'template.document_code',
                        'template.document_description',
                        'template.document_file',
                        'employer.business_name')
                        ->where('template.id', $Template_id)
                        ->get();
        return json_encode($Template);
    }

    public function update_template(Request $request, $id){
        $this->getaccount();
        /*Validate Request*/
        $this->validate($request, [
            'document_code' => 'required',
            'document_description' => 'required',
        ]);

        // Handle File Upload
        if($request->hasFile('document_file')){
            // Get filename with the extension
            $filenameWithExt_document_file = $request->file('document_file')->getClientOriginalName();
            // Get just filename
            $filename_document_file = pathinfo($filenameWithExt_document_file, PATHINFO_FILENAME);
            // Get just ext
            $extension_document_file = $request->file('document_file')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore_document_file= $filename_document_file.'_'.time().'.'.$extension_document_file;
            // Upload Image
            $path_document_file = $request->file('document_file')->storeAs('public/Documents/templates', $fileNameToStore_document_file);
        }

        /*Get Current Template File*/
        $get_user_file = DB::table('template')
                        ->select('document_file')
                        ->where('id', $id)
                        ->get();

        /*Check if all Request is not null*/
        if($request->all() != null){
            /*Update Template Document*/
            $Template = DB::table('template')->where('id', '=', $id)
                                ->update(array(
                                    //'account_id' => $request->input('employer_id'), /*Temporary Account ID*/ Remove comment in the next update
                                    'document_code' => $request->input('document_code'),
                                    'document_description' => $request->input('document_description'),
                                    'document_file' => ($request->hasFile('document_file') ? $fileNameToStore_document_file : $get_user_file[0]->document_file),
                                    'created_by' => auth()->user()->id,
                                    'updated_by' => auth()->user()->id
                                ));
        } 

        // Insert Log
        $this->insert_log("Update Template");
        return Response::json($Template);
    }

    public function destroy_template(Request $request){
        $this->getaccount();
        $id = $request->id;
        /*Delete Template*/
        $template = Template::where('id', '=', $id)->delete();
        // Insert Log
        $this->insert_log("Delete Template");
        return response()->json($template);
    } 
    //Docs (view) restriction 
    public function viewtemplates(){
        $Templates = DB::table('template')
        ->join('employer', 'employer.id', '=', 'template.account_id')
        ->select('template.id',
        'template.document_code',
        'template.document_description',
        'template.document_file',
        'employer.business_name')
        ->where('template.account_id','=',auth()->user()->id)
        ->latest('template.created_at')
        ->get();
        return view('Template.view', compact('Templates'));
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
