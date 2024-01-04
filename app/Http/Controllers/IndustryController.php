<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{Industries, Log};
use Illuminate\Support\Facades\Auth;
use App\Repositories\IndustryRepository;
use Illuminate\Support\Facades\Gate;

class IndustryController extends Controller
{
    protected $model;
    public function __construct(Industries $industry)
    {
        // set the model
        $this->model = new IndustryRepository($industry);
        $this->middleware('auth');
        $this->middleware(['role:SuperAdmin']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::allows('SuperAdmin', auth()->user())) {
            $industry = Industries::orderBy('industry_name', 'asc')->get();
            return view('dashboard.industries.index')->with([
                'industry' => $industry
            ]);
        } else {
            // return redirect()->back()->with([
            //     'error' => "You Dont have Access To This Page",
            // ]);
            return view('errors.403');
        }
    }

    public function bin()
    {
        if (Gate::allows('SuperAdmin', auth()->user())) {
            $industry = Industries::onlyTrashed()->get();
            return view('dashboard.industries.recyclebin')->with([
                'industry' => $industry,
            ]);
        } else {
            // return redirect()->back()->with([
            //     'error' => "You Dont have Access To This Page",
            // ]);
            return view('errors.403');
        }
    }

    public function restore($industry_id)
    {
        if(Industries::where('industry_id', $industry_id)->exists()){
            if (Gate::allows('SuperAdmin', auth()->user())) {
                Industries::withTrashed()->where('industry_id', $industry_id)->restore();
                $indo = $this->model->show($industry_id);
                $name = $indo->industry_name;
                $log = new Log([
                    "user_id" => Auth::user()->user_id,
                    "activities" => 'Restored $name Industry ',
                ]);
                $log->save();

                return redirect()->back()->with([
                    'success' => " You Have Restored $name  Industry Successfully",

                ]);
            } else {
                return redirect()->back()->with("error", "You Dont Have Access To This Page");
            }
        }else{
            return redirect()->back()->with([
                'error' => "$industry_id does not Exist for any Industry",
            ]);
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
        if (Gate::allows('SuperAdmin', auth()->user())) {

            $this->validate($request, [
                'industry_name' => ['required', 'string', 'unique:industries'],
            ]);

            $data = ([
                "industries" => new Industries,
                "industry_name" => $request->input("industry_name"),
            ]);

            $log = new Log([
                "user_id" => Auth::user()->user_id,
                "activities" => 'Created Industry ' . $request->input("industry_name"),
            ]);
            if ($this->model->create($data) and ($log->save())) {
                return redirect()->route("industry.index")->with("success", "You Have Added " . $request->input("industry_name") . " Successfully");
            } else {
                return redirect()->back()->with("error", "Network Failure, Please try again later");
            }
        } else {
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
    public function edit($industry_id)
    {
        $check = Industries::where('industry_id', $industry_id)->get();
        if(count($check)< 1){

            return redirect()->back()->with([
                'error' => "$industry_id does not exist for any Industry",
            ]);
        }else{
            if (Gate::allows('SuperAdmin', auth()->user())) {
                $industry = Industries::orderBy('industry_name', 'asc')->get();
                $indust = $this->model->show($industry_id);
                return view('dashboard.industries.edit')->with([
                    'industry' => $industry, 'indust' => $indust
                ]);
            } else {
                return redirect()->back()->with([
                    'error' => "You Dont have Access To This Page",
                ]);
            }
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $industry_id)
    {

        $check = Industries::where('industry_id', $industry_id)->get();
        if(count($check)< 1){
            return redirect()->back()->with([
                'error' => "$industry_id does not exist for any Industry",
            ]);
        }else{
            if (Gate::allows('SuperAdmin', auth()->user())) {

                $this->validate($request, [
                    'industry_name' => ['required', 'string'],
                ]);
                $indust = $this->model->show($industry_id);

                $data = ([
                    "industries" => $this->model->show($industry_id),
                    "industry_name" => $request->input("industry_name"),
                ]);

                $log = new Log([
                    "user_id" => Auth::user()->user_id,
                    "activities" => 'Changed Industry name from ' . $request->input("prev_name") . ' to '. $request->input('industry_name'),
                ]);
                if ($this->model->update($data, $industry_id) and ($log->save())) {
                    return redirect()->route("industry.index")->with("success", "You Have Updated " . $request->input("industry_name") . " Successfully");
                } else {
                    return redirect()->back()->with("error", "Network Failure, Please try again later");
                }
            } else {
                return redirect()->back()->with([
                    'error' => "You Dont have Access To This Page",
                ]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($industry_id)
    {
        $check = Industries::where('industry_id', $industry_id)->get();
        if(count($check)< 1){
            return redirect()->back()->with([
                'error' => "$industry_id does not exist for any Industry",
            ]);
        }else{
            if (Gate::allows('SuperAdmin', auth()->user())) {
                $industry =  $this->model->show($industry_id);
                $log = new Log([
                    "user_id" => Auth::user()->user_id,
                    "activities" => 'Deleted Industry ' . $industry->industry_name,
                ]);
                if (($industry->delete($industry_id)) and ($industry->trashed())) {
                    return redirect()->back()->with([
                        'success' => "You Have Deleted The Industry $industry->industry_name Successfully",
                    ]);
                } else {
                    return redirect()->back()->with([
                        'error' => "Network Failure, Please Try again Later",
                    ]);
                }
            } else {
                return redirect()->back()->with([
                    'error' => "You Dont have Access To This Page",
                ]);
            }
        }
    }
}
