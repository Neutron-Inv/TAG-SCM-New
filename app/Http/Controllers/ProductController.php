<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{Product, Log};
use Illuminate\Support\Facades\Auth;
use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\Gate;

class ProductController extends Controller
{
    protected $model;
    public function __construct(Product $product)
    {
        // set the model
        $this->model = new ProductRepository($product);
        $this->middleware('auth');
        $this->middleware(['role:SuperAdmin|Employer|HOD|Admin']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
            $product = Product::orderBy('product_name', 'asc')->get();
            return view('dashboard.products.index')->with([
                'product' => $product
            ]);
    }

    public function bin()
    {
            $product = Product::onlyTrashed()->get();
            return view('dashboard.product.recyclebin')->with([
                'product' => $product,
            ]);
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
            $this->validate($request, [
                'product_name' => ['required', 'string', 'unique:products'],
            ]);

            $data = ([
                "product" => new Product,
                "product_name" => $request->input("product_name"),
            ]);

            $log = new Log([
                "user_id" => Auth::user()->user_id,
                "activities" => 'Created Product ' . $request->input("product_name"),
            ]);
            if ($this->model->create($data) and ($log->save())) {
                return redirect()->route("product.index")->with("success", "You Have Added " . $request->input("product_name") . " Successfully");
            } else {
                return redirect()->back()->with("error", "Network Failure, Please try again later");
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
    public function edit($product_id)
    {
        $check = Product::where('product_id', $product_id)->get();
        if(count($check)< 1){

            return redirect()->back()->with([
                'error' => "Requested ID does not exist for any product",
            ]);
        }else{
                $product = Product::orderBy('product_name', 'asc')->get();
                $prod = $this->model->show($product_id);
                return view('dashboard.products.edit')->with([
                    'product' => $product, 'prod' => $prod
                ]);
        }
    }
    
    public function getCompanyProducts($companyId)
    {
        $products = Product::where('company_id', $companyId)->get(['product_id', 'product_name']);
        return response()->json($products);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $product_id)
    {

        $check = Product::where('product_id', $product_id)->get();
        if(count($check)< 1){
            return redirect()->back()->with([
                'error' => "Requested ID does not exist for any Product",
            ]);
        }else{

                $this->validate($request, [
                    'product_name' => ['required', 'string'],
                ]);
                $prod = $this->model->show($product_id);

                $data = ([
                    "product" => $this->model->show($product_id),
                    "product_name" => $request->input("product_name"),
                ]);

                $log = new Log([
                    "user_id" => Auth::user()->user_id,
                    "activities" => 'Changed Product name from ' . $request->input("prev_name") . ' to '. $request->input('product_name'),
                ]);
                if ($this->model->update($data, $product_id) and ($log->save())) {
                    return redirect()->route("product.index")->with("success", "You Have Updated " . $request->input("product_name") . " Successfully");
                } else {
                    return redirect()->back()->with("error", "Network Failure, Please try again later");
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
