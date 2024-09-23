<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{User, Log, Warehouse, UserWarehouse, Inventory, InventoryImage};
use DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use App\Repositories\InventoryRepository;
use Illuminate\Support\Facades\Gate;

class InventoryController extends Controller
{
    protected $model;
    public function __construct(Inventory $inventory)
    {
        // set the model
        $this->middleware('auth');
        $this->model = new InventoryRepository($inventory);
        $this->middleware(['role:SuperAdmin|Admin|Warehouse User']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->hasRole('Warehouse User')){
            $deed = getUserWareHouse(Auth::user()->user_id);
            $warehouse_id = $deed->warehouse_id;
            $rest = getWareHouse($warehouse_id);
            $inventory= Inventory::where('warehouse_id', $warehouse_id)->orderBy('created_at', 'desc')->get();
            return view('dashboard.inventory.index')->with([
                'inventory' => $inventory, 'rest' => $rest
            ]);
        } else {
            return view('errors.403');
        }

    }

    public function products($warehouse_id)
    {
        if(Inventory::where('warehouse_id', $warehouse_id)->exists()){
            // if(Auth::user()->hasRole('Warehouse User')){
                $rest = getWareHouse($warehouse_id);
                $inven = Inventory::where('warehouse_id', $warehouse_id)->orderBy('created_at', 'desc')->get();
                return view('dashboard.warehouse.inventory')->with([
                    'inven' => $inven, 'rest' => $rest, 'warehouse_id' => $warehouse_id
                ]);
            // } else {
            //     return view('errors.403');
            // }
        }else{
            return redirect()->back()->with(['error' => "No Inventory was found for The Warehouse"]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->hasRole('Warehouse User')){
            return view('dashboard.inventory.create')->with([

            ]);
        } else {
            return view('errors.403');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->hasRole('Warehouse User')){
            $this->validate($request, [
                'approved_by' => ['required', 'string', 'max:199'],
                'material_number' => ['required', 'string', 'max:199'],
                'oem' => ['required', 'string', 'max:199'],
                'oem_number' => ['required', 'string', 'max:199'],
                'storage_location' => ['required', 'string', 'max:199'],
                'quantity' => ['required', 'string', 'max:199'],
                'material_condition' => ['required', 'string', 'max:199'],
                'preservation_required' => ['required', 'string', 'max:199'],
                'short_description' => ['required', 'string', 'max:199'],
                'complete_description' => ['required', 'string', 'max:199'],
                'warehouse_id' => ['required', 'string', 'max:199'],
                'recommended_changes' => ['required', 'string', 'max:199'],
            ]);

            $data = new Inventory([
                "approved_by" => $request->input("approved_by"),
                "user_email" => Auth::user()->email,
                "material_number" => $request->input("material_number"),
                "oem" => $request->input("oem"),
                "oem_part_number" => $request->input("oem_number"),
                "storage_location" => $request->input("storage_location"),
                "warehouse_id" => $request->input("warehouse_id"),
                "quantity_location" => $request->input("quantity"),
                "material_condition" => $request->input("material_condition"),
                "preservations_required" => $request->input("preservation_required"),
                "short_description" => $request->input("short_description"),
                "complete_description" => $request->input("complete_description"),
                "recommended_changes" => $request->input("recommended_changes"),
            ]);

            if($data->save()){
                if($request->hasFile('image')) {
                    $file = $request->image;
                    foreach ($file as $files) {
                        $filenameWithExt = $files->getClientOriginalName();
                        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                        $extension = $files->getClientOriginalExtension();
                        $ext = array('png', 'PNG', 'jpg', 'jpeg', 'JPG', 'JPEG', 'svg', 'SVG');
                        if (in_array($extension, $ext))
                        {
                            $fileNameToStore = $filename.'_'.time().'.'.$extension;
                            $path=$files->move('inventory-file/', $fileNameToStore);
                            $newImage = new InventoryImage([
                                'inventory_id' => $data->inventory_id,
                                'image' => $fileNameToStore
                            ]);
                            $newImage->save();
                        }else{
                            return redirect()->back()->with("error", "The Selected file $filenameWithExt is not an image");
                        }
                    }
                    $log = new Log([
                        "user_id" => Auth::user()->user_id,
                        "activities" => 'Added Inventory ID' . $data->inventory_id,
                    ]);

                    return redirect()->route('inventory.index')->with(["success" => 'Inventory Added Successfully']);
                }else{
                    return redirect()->route('inventory.index')->with(["success" => 'Inventory Added Successfully']);
                }

            }
        } else {
            return view('errors.403');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function show($inventory_id)
    {
        if(Inventory::where('inventory_id', $inventory_id)->exists()){
            if(Auth::user()->hasRole('Warehouse User')){
                //Link Inventory to ware house
                $inventory = $this->model->show($inventory_id);
            }else{
                $inventory = Inventory::where('inventory_id', $inventory_id)->first();
            }
            return view('dashboard.inventory.details')->with([
                'inventory' => $inventory
            ]);
        }else{
            return redirect()->back()->with;(['error' => 'No Inventory was found for ID'. $inventory_id]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function edit($inventory_id)
    {
        if(Inventory::where('inventory_id', $inventory_id)->exists()){
            if(Auth::user()->hasRole('Warehouse User')){
                $inven = $this->model->show($inventory_id);
                return view('dashboard.inventory.edit')->with([
                    'inven' => $inven
                ]);
            } else {
                return view('errors.403');
            }
        }else{
            return redirect()->back()->with;(['error' => 'No Inventory was found for ID'. $inventory_id]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $inventory_id)
    {
        if(Inventory::where('inventory_id', $inventory_id)->exists()){
            if(Auth::user()->hasRole('Warehouse User')){
                $this->validate($request, [
                    'approved_by' => ['required', 'string', 'max:199'],
                    'material_number' => ['required', 'string', 'max:199'],
                    'oem' => ['required', 'string', 'max:199'],
                    'oem_number' => ['required', 'string', 'max:199'],
                    'storage_location' => ['required', 'string', 'max:199'],
                    'quantity' => ['required', 'string', 'max:199'],
                    'material_condition' => ['required', 'string', 'max:199'],
                    'preservation_required' => ['required', 'string', 'max:199'],
                    'short_description' => ['required', 'string', 'max:199'],
                    'complete_description' => ['required', 'string', 'max:199'],
                    'warehouse_id' => ['required', 'string', 'max:199'],
                    'recommended_changes' => ['required', 'string', 'max:199'],
                ]);

                $data = ([
                    "inventory" => $this->model->show($inventory_id),
                    "approved_by" => $request->input("approved_by"),
                    "user_email" => Auth::user()->email,
                    "material_number" => $request->input("material_number"),
                    "oem" => $request->input("oem"),
                    "oem_part_number" => $request->input("oem_number"),
                    "storage_location" => $request->input("storage_location"),
                    "warehouse_id" => $request->input("warehouse_id"),
                    "quantity_location" => $request->input("quantity"),
                    "material_condition" => $request->input("material_condition"),
                    "preservations_required" => $request->input("preservation_required"),
                    "short_description" => $request->input("short_description"),
                    "complete_description" => $request->input("complete_description"),
                    "recommended_changes" => $request->input("recommended_changes"),
                ]);

                if($this->model->update($data, $inventory_id)){
                    if($request->hasFile('image')) {
                        $file = $request->image;
                        foreach ($file as $files) {
                            $filenameWithExt = $files->getClientOriginalName();
                            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                            $extension = $files->getClientOriginalExtension();
                            $ext = array('png', 'PNG', 'jpg', 'jpeg', 'JPG', 'JPEG', 'svg', 'SVG');
                            if (in_array($extension, $ext))
                            {
                                $fileNameToStore = $filename.'_'.time().'.'.$extension;
                                $path=$files->move('inventory-file/', $fileNameToStore);
                                $newImage = new InventoryImage([
                                    'inventory_id' => $inventory_id,
                                    'image' => $fileNameToStore
                                ]);
                                $newImage->save();
                            }else{
                                return redirect()->back()->with("error", "The Selected file $filenameWithExt is not an image");
                            }
                        }
                        $log = new Log([
                            "user_id" => Auth::user()->user_id,
                            "activities" => 'Updated Inventory ID' . $inventory_id,
                        ]);

                        return redirect()->route('inventory.index')->with(["success" => 'Inventory Updated Successfully']);
                    }else{
                        return redirect()->route('inventory.index')->with(["success" => 'Inventory Updated Successfully']);
                    }

                }

            } else {
                return view('errors.403');
            }
        }else{
            return redirect()->back()->with;(['error' => 'No Inventory was found for ID'. $inventory_id]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function destroy($inventory_id)
    {
        $check = Inventory::where('inventory_id', $inventory_id)->get();
        if(count($check)< 1){
            return redirect()->back()->with([
                'error' => "$industry_id does not exist for any Inventory",
            ]);
        }else{
            if ((Gate::allows('SuperAdmin', auth()->user())) OR (Auth::user()->hasRole('Warehouse User'))) {
                $inventory =  $this->model->show($inventory_id);
                $log = new Log([
                    "user_id" => Auth::user()->user_id,
                    "activities" => 'Deleted Inventory Id ' . $inventory_id,
                ]);
                if (($inventory->delete($inventory_id)) and ($inventory->trashed())) {
                    return redirect()->back()->with([
                        'success' => "You Have Deleted The Inventory Successfully",
                    ]);
                } else {
                    return redirect()->back()->with([
                        'error' => "Network Failure, Please Try again Later",
                    ]);
                }
            } else {
                return view('errors.403');
            }
        }
    }
}
