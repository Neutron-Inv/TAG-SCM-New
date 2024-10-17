<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{ClientProject , Clients, Log, ClientReport};
use Illuminate\Support\Facades\Auth;
use App\Repositories\ClientReportRepository;
use Illuminate\Support\Facades\Gate;

class ClientProjectController extends Controller
{

    protected $model;
    public function __construct(ClientReport $project)
    {
        // set the model
        $this->model = new ClientReportRepository($project);
        $this->middleware('auth');
        $this->middleware(['role:SuperAdmin|Admin|HOD|Employer']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($client_id)
    {
        if (Gate::allows('SuperAdmin', auth()->user()) OR (Auth::user()->hasRole('Admin')) OR (Auth::user()->hasRole('HOD'))){
            $client = Clients::where('client_id', $client_id)->first();
            $project = ClientProject::where('client_id', $client_id)->orderBy('created_at', 'desc')->get();
            return view('dashboard.clients.projects')->with([
                'client' => $client, "project" => $project
            ]);
        }else{
            // return redirect()->back()->with([
            //     'error' => "You Dont have Access To This Page",
            // ]);
            return view('errors.403');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Gate::allows('SuperAdmin', auth()->user()) OR (Auth::user()->hasRole('Admin')) OR (Auth::user()->hasRole('HOD')) OR (Auth::user()->hasRole('Employer'))) {
    
            // Validate incoming request
            $this->validate($request, [
                'client_id' => ['required', 'string', 'max:199'],
                'project_name' => ['required', 'string'],
                'document.*' => 'nullable|mimes:jpg,jpeg,png,pdf,docx,xlsx|max:2048' // Validation for files
            ]);
            
            // Get client name
            $client_name = Clients::where('client_id', $request->input('client_id'))->value('client_name');
    
            // Create a new project
            $project = new ClientProject();
            $project->client_id = $request->input("client_id");
            $project->project_name = $request->input("project_name");
    
            // Save project to get the ID
            if ($project->save()) {
    
                // Directory structure: 'client/{client_id}/{project_id}/project_files'
                $project_id = $project->id; // Get the newly created project ID
                $client_id = $request->input("client_id");
                $dir = 'document/client/' . $client_id . '/' . $project_id . '/';
    
                // Check if the directory exists, if not create it
                if (!file_exists($dir)) {
                    mkdir($dir, 0777, true);
                }
    
                // Handle file uploads if files are present
                if ($request->hasFile('document')) {
                    foreach ($request->file('document') as $file) {
                        $filename = time() . '_' . $file->getClientOriginalName(); // Create a unique file name
                        $file->move(('document/client/'.$client_id.'/'.$project_id.'/'), $filename); // Move file to the directory
                    }
                }
    
                // Log activity
                $log = new Log([
                    "user_id" => Auth::user()->user_id,
                    "activities" => 'Added Project for ' . $client_name,
                ]);
    
                // Save the log
                if ($log->save()) {
                    return redirect()->back()->with("success", "You have added a project for " . $client_name . " successfully, and files have been uploaded.");
                } else {
                    return redirect()->back()->with("error", "Project saved but log creation failed.");
                }
            } else {
                return redirect()->back()->with("error", "Network failure while saving project.");
            }
        } else {
            return view('errors.403'); // Unauthorized access error page
        }
    }




    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Gate::allows('SuperAdmin', auth()->user()) OR (Auth::user()->hasRole('Admin')) OR (Auth::user()->hasRole('HOD'))){
            $current_project = ClientProject::where('id', $id)->first();
            $client = Clients::where('client_id', $current_project->client_id)->first();
            $project = ClientProject::where('client_id', $current_project->client_id)->orderBy('created_at', 'desc')->get();
            return view('dashboard.clients.project_edit')->with([
                'client' => $client, "project" => $project, "current_project" => $current_project
            ]);
        }else{
            // return redirect()->back()->with([
            //     'error' => "You Dont have Access To This Page",
            // ]);
            return view('errors.403');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $project_id)
    {
        if (Gate::allows('SuperAdmin', auth()->user()) OR (Auth::user()->hasRole('Admin')) OR (Auth::user()->hasRole('HOD')) OR (Auth::user()->hasRole('Employer'))) {
    
            // Validate incoming request
            $this->validate($request, [
                'client_id' => ['required', 'string', 'max:199'],
                'project_name' => ['required', 'string'],
                'document.*' => 'nullable|mimes:jpg,jpeg,png,pdf,docx,xlsx|max:2048' // Validation for files
            ]);
            
            // Get client name
            $client_name = Clients::where('client_id', $request->input('client_id'))->value('client_name');
    
            // Create a new project
            $project = ClientProject::findorfail($project_id);
            $project->client_id = $request->input("client_id");
            $project->project_name = $request->input("project_name");
    
            // Save project to get the ID
            if ($project->save()) {
    
                // Directory structure: 'client/{client_id}/{project_id}/project_files'
                $project_id = $project->id; // Get the newly created project ID
                $client_id = $request->input("client_id");
                $dir = 'document/client/' . $client_id . '/' . $project_id . '/';
    
                // Check if the directory exists, if not create it
                if (!file_exists($dir)) {
                    mkdir($dir, 0777, true);
                }
    
                // Handle file uploads if files are present
                if ($request->hasFile('document')) {
                    foreach ($request->file('document') as $file) {
                        $filename = time() . '_' . $file->getClientOriginalName(); // Create a unique file name
                        $file->move(('document/client/'.$client_id.'/'.$project_id.'/'), $filename); // Move file to the directory
                    }
                }
    
                // Log activity
                $log = new Log([
                    "user_id" => Auth::user()->user_id,
                    "activities" => 'Added Project for ' . $client_name,
                ]);
    
                // Save the log
                if ($log->save()) {
                    return redirect()->back()->with("success", "You have Edited a project for " . $client_name . " successfully, and files have been uploaded.");
                } else {
                    return redirect()->back()->with("error", "Project saved but log creation failed.");
                }
            } else {
                return redirect()->back()->with("error", "Network failure while saving project.");
            }
        } else {
            return view('errors.403'); // Unauthorized access error page
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($report_id)
    {
        if (Gate::allows('SuperAdmin', auth()->user()) OR (Auth::user()->hasRole('Admin'))){

            $cli = $this->model->show($report_id);
            $re = $cli->note;
            $id = $cli->client_id;
            //Delete from Single Table
            $log = new Log([
                "user_id" => Auth::user()->user_id,
                "activities" => 'Deleted Report for ' . $id,
            ]);
            if (($cli->delete($report_id)) and ($cli->trashed())) {
                return redirect()->back()->with([
                    'success' => "You Have Deleted Client Report Successfully",
                ]);
            } else {
                return redirect()->back()->with([
                    'error' => "Operation Failed, Please Try again Later",
                ]);
            }

        }else{
            // return redirect()->back()->with([
            //     'error' => "You Dont have Access To This Page",
            // ]);
            return view('errors.403');
        }
    }
}
