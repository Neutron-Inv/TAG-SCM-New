<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{ClientReport , Clients, Log};
use Illuminate\Support\Facades\Auth;
use App\Repositories\ClientReportRepository;
use Illuminate\Support\Facades\Gate;

class ClientReportController extends Controller
{

    protected $model;
    public function __construct(ClientReport $report)
    {
        // set the model
        $this->model = new CLientReportRepository($report);
        $this->middleware('auth');
        $this->middleware(['role:SuperAdmin|Admin|Client']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($client_id)
    {
        if (Gate::allows('SuperAdmin', auth()->user()) OR (Auth::user()->hasRole('Admin')) OR (Auth::user()->hasRole('Client'))){
            $client = Clients::where('client_id', $client_id)->first();
            $report = ClientReport::where('client_id', $client_id)->orderBy('created_at', 'desc')->get();
            return view('dashboard.clients.report')->with([
                'client' => $client, "report" => $report
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
        if (Gate::allows('SuperAdmin', auth()->user()) OR (Auth::user()->hasRole('Admin'))){

            $this->validate($request, [

                'client_id' => ['required', 'string', 'max:199'],
                'note' => ['required', 'string'],

            ]);

            $data =([
                "report" =>  new ClientReport,
                "client_id" => $request->input("client_id"),
                "user_id" => Auth::user()->user_id,
                "note" => $request->input("note"),
            ]);

            $log = new Log([
                "user_id" => Auth::user()->user_id,
                "activities" => 'Added Report for ' . $request->input('client_name'),
            ]);
            if ($this->model->create($data) and ($log->save())) {
                return redirect()->back()->with("success", "You Have Added Report for  " . $request->input("client_name") . " Successfully");
            } else {
                return redirect()->back()->with("error", "Network Failure");
            }
        }else{
            // return redirect()->back()->with([
            //     'error' => "You Dont have Access To This Page",
            // ]);
            return view('errors.403');
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
    public function edit($report_id)
    {
        if (Gate::allows('SuperAdmin', auth()->user()) OR (Auth::user()->hasRole('Admin')) OR (Auth::user()->hasRole('Client'))){
            $repo = $this->model->show($report_id);
            $client = Clients::where('client_id', $repo->client_id)->first();
            $report = ClientReport::where('client_id', $repo->client_id)->orderBy('created_at', 'desc')->get();
            return view('dashboard.clients.edit_report')->with([
                'client' => $client, "report" => $report, 'repo' => $repo
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
    public function update(Request $request, $report_id)
    {
        if (Gate::allows('SuperAdmin', auth()->user()) OR (Auth::user()->hasRole('Admin'))){

            $repo = $this->model->show($report_id);

            $this->validate($request, [

                'client_id' => ['required', 'string', 'max:199'],
                'note' => ['required', 'string'],

            ]);

            $data =([
                "report" =>  $this->model->show($report_id),
                "client_id" => $request->input("client_id"),
                "user_id" => Auth::user()->user_id,
                "note" => $request->input("note"),
            ]);

            $log = new Log([
                "user_id" => Auth::user()->user_id,
                "activities" => 'Added Report for ' . $request->input('client_name'),
            ]);
            if ($this->model->update($data, $report_id) and ($log->save())) {
                return redirect()->back()->with("success", "You Have Updated Report for  " . $request->input("client_name") . " Successfully");
            } else {
                return redirect()->back()->with("error", "Network Failure");
            }
        }else{
            // return redirect()->back()->with([
            //     'error' => "You Dont have Access To This Page",
            // ]);
            return view('errors.403');
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
