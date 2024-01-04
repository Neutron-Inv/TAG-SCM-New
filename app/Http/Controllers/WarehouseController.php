<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{Warehouse, Log};
use Illuminate\Support\Facades\Auth;
use App\Repositories\WarehouseRepository;
use Illuminate\Support\Facades\Gate;

class WarehouseController extends Controller
{
    protected $model;
    public function __construct(Warehouse $warehouse)
    {
        // set the model
        $this->model = new WarehouseRepository($warehouse);
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
            $warehouse = Warehouse::orderBy('name', 'asc')->get();
            return view('dashboard.warehouse.index')->with([
                'warehouse' => $warehouse
            ]);
        } else {

            return view('errors.403');
        }
    }

    public function bin()
    {
        if (Gate::allows('SuperAdmin', auth()->user())) {
            $warehouse = Warehouse::onlyTrashed()->get();
            // return view('dashboard.warehouse.recyclebin')->with([
            //     'Warehouse' => $warehouse,
            // ]);
        } else {

            return view('errors.403');
        }
    }

    public function restore($warehouse_id)
    {
        if(Warehouse::where('warehouse_id', $warehouse_id)->exists()){
            if (Gate::allows('SuperAdmin', auth()->user())) {
                Warehouse::withTrashed()->where('warehouse_id', $warehouse_id)->restore();
                $indo = $this->model->show($warehouse_id);
                $name = $indo->name;
                $log = new Log([
                    "user_id" => Auth::user()->user_id,
                    "activities" => "Restored $name Warehouse ",
                ]);
                $log->save();

                return redirect()->back()->with([
                    'success' => " You Have Restored $name  Warehouse Successfully",

                ]);
            } else {
                return redirect()->back()->with("error", "You Dont Have Access To This Page");
            }
        }else{
            return redirect()->back()->with([
                'error' => "$warehouse_id does not Exist for any Warehouse",
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
                'name' => ['required', 'string', 'unique:warehouses'],
            ]);

            $data = ([
                "warehouse" => new warehouse,
                "name" => strtoupper($request->input("name")),
            ]);

            $log = new Log([
                "user_id" => Auth::user()->user_id,
                "activities" => 'Created Warehouse ' . $request->input("name"),
            ]);
            if ($this->model->create($data) and ($log->save())) {
                return redirect()->route("warehouse.index")->with("success", "You Have Added " . $request->input("name") . " Successfully");
            } else {
                return redirect()->back()->with("error", "Network Failure, Please try again later");
            }
        } else {
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
    public function edit($warehouse_id)
    {
        $check = Warehouse::where('warehouse_id', $warehouse_id)->get();
        if(count($check)< 1){

            return redirect()->back()->with([
                'error' => "$warehouse_id does not exist for any Warehouse",
            ]);
        }else{
            if (Gate::allows('SuperAdmin', auth()->user())) {
                $warehouse = Warehouse::orderBy('name', 'asc')->get();
                $ware = $this->model->show($warehouse_id);
                return view('dashboard.warehouse.edit')->with([
                    'warehouse' => $warehouse, 'ware' => $ware
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
    public function update(Request $request, $warehouse_id)
    {

        $check = Warehouse::where('warehouse_id', $warehouse_id)->get();
        if(count($check)< 1){
            return redirect()->back()->with([
                'error' => "$warehouse_id does not exist for any Warehouse",
            ]);
        }else{
            if (Gate::allows('SuperAdmin', auth()->user())) {

                $this->validate($request, [
                    'name' => ['required', 'string'],
                ]);
                $ware = $this->model->show($warehouse_id);

                $data = ([
                    "warehouse" => $this->model->show($warehouse_id),
                    "name" => strtoupper($request->input("name")),
                ]);

                $log = new Log([
                    "user_id" => Auth::user()->user_id,
                    "activities" => 'Changed Warehouse name from ' . $request->input("prev_name") . ' to '. $request->input('name'),
                ]);
                if ($this->model->update($data, $warehouse_id) and ($log->save())) {
                    return redirect()->route("warehouse.index")->with("success", "You Have Updated " . $request->input("name") . " Successfully");
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
    public function destroy($warehouse_id)
    {
        $check = Warehouse::where('warehouse_id', $warehouse_id)->get();
        if(count($check)< 1){
            return redirect()->back()->with([
                'error' => "$warehouse_id does not exist for any Warehouse",
            ]);
        }else{
            if (Gate::allows('SuperAdmin', auth()->user())) {
                $warehouse =  $this->model->show($warehouse_id);
                $log = new Log([
                    "user_id" => Auth::user()->user_id,
                    "activities" => 'Deleted Warehouse ' . $warehouse->name,
                ]);
                if (($warehouse->delete($warehouse_id)) and ($warehouse->trashed())) {
                    return redirect()->back()->with([
                        'success' => "You Have Deleted The Warehouse $warehouse->name Successfully",
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
