<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{RfqMeasurement, Log};
use Illuminate\Support\Facades\Auth;
use App\Repositories\UnitRepository;
use Illuminate\Support\Facades\Gate;

class RfqMeasurementController extends Controller
{
    protected $model;
    public function __construct(RfqMeasurement $unit)
    {
        // set the model
        $this->model = new UnitRepository($unit);
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
            $unit = RfqMeasurement::orderBy('unit_name', 'asc')->get();
            return view('dashboard.uom.index')->with([
                'unit' => $unit
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
            $unit = RfqMeasurement::onlyTrashed()->get();
            return view('dashboard.uom.recyclebin')->with([
                'unit' => $unit,
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
        if(RfqMeasuremnt::where('unti_id', $unit_is)->exists()){
            if (Gate::allows('SuperAdmin', auth()->user())) {
                RfqMeasuremnt::withTrashed()->where('unit_id', $unit_id)->restore();
                $indo = $this->model->show($unit_id);
                $name = $indo->unit_name;
                $log = new Log([
                    "user_id" => Auth::user()->user_id,
                    "activities" => 'Restored $name UOM ',
                ]);
                $log->save();

                return redirect()->back()->with([
                    'success' => " You Have Restored $name  UOM Successfully",

                ]);
            } else {
                return redirect()->back()->with("error", "You Dont Have Access To This Page");
            }
        }else{
            return redirect()->back()->with([
                'error' => "$unit_id does not Exist for any Industry",
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
                'unit_name' => ['required', 'string', 'unique:rfq_measurements'],
            ]);

            $data = ([
                "unit" => new RfqMeasurement,
                "unit_name" => $request->input("unit_name"),
            ]);

            $log = new Log([
                "user_id" => Auth::user()->user_id,
                "activities" => 'Created UOM ' . $request->input("unit_name"),
            ]);
            if ($this->model->create($data) and ($log->save())) {
                return redirect()->route("unit.index")->with("success", "You Have Added " . $request->input("unit_name") . " Successfully");
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
    public function edit($unit_id)
    {
        $check = RfqMeasurement::where('unit_id', $unit_id)->get();
        if(count($check)< 1){

            return redirect()->back()->with([
                'error' => "$unit_id does not exist for any UOM",
            ]);
        }else{
            if (Gate::allows('SuperAdmin', auth()->user())) {
                $unit = RfqMeasurement::orderBy('unit_name', 'asc')->get();
                $uni = $this->model->show($unit_id);
                return view('dashboard.uom.edit')->with([
                    'unit' => $unit, 'uni' => $uni
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
    public function update(Request $request, $unit_id)
    {

        $check = RfqMeasurement::where('unit_id', $unit_id)->get();
        if(count($check)< 1){
            return redirect()->back()->with([
                'error' => "$unit_id does not exist for any uom",
            ]);
        }else{
            if (Gate::allows('SuperAdmin', auth()->user())) {

                $this->validate($request, [
                    'unit_name' => ['required', 'string'],
                ]);
                $uni = $this->model->show($unit_id);

                $data = ([
                    "unit" => $this->model->show($unit_id),
                    "unit_name" => $request->input("unit_name"),
                ]);

                $log = new Log([
                    "user_id" => Auth::user()->user_id,
                    "activities" => 'Changed Unit name from ' . $request->input("prev_name") . ' to '. $request->input('unit_name'),
                ]);
                if ($this->model->update($data, $unit_id) and ($log->save())) {
                    return redirect()->route("unit.index")->with("success", "You Have Updated " . $request->input("unit_name") . " Successfully");
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
    public function destroy($unit_id)
    {
        $check = RfqMeasurement::where('unit_id', $unit_id)->get();
        if(count($check)< 1){
            return redirect()->back()->with([
                'error' => "$unit_id does not exist for any Industry",
            ]);
        }else{
            if (Gate::allows('SuperAdmin', auth()->user())) {
                $unit =  $this->model->show($unit_id);
                $log = new Log([
                    "user_id" => Auth::user()->user_id,
                    "activities" => 'Deleted UOM ' . $unit->unit_name,
                ]);
                if (($unit->delete($unit_id)) and ($unit->trashed())) {
                    return redirect()->back()->with([
                        'success' => "You Have Deleted The UOM $unit->unit_name Successfully",
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
