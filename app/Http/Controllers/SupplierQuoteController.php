<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{Companies, User, Log, ClientRfq, RfqHistory, Vendors, SupplierQuote, LineItem};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Repositories\SupplierQuoteRepository;
use Illuminate\Support\Facades\Gate;
use DB;

class SupplierQuoteController extends Controller
{
    protected $model;
    public function __construct(SupplierQuote $quote)
    {
        // set the model
        $this->model = new SupplierQuoteRepository($quote);
        $this->middleware('auth');
        $this->middleware(['role:SuperAdmin|Admin|Supplier|Employer|HOD']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::allows('SuperAdmin', auth()->user())) {

            $quote = SupplierQuote::orderBy('supplier_quote_id', 'DESC')->get();
            return view('dashboard.supplier_quotation.index')->with([
               'quote' => $quote
            ]);
            }elseif (Auth::user()->hasRole('Supplier')){

            $vendor = Vendors::where('contact_email', Auth::user()->email)->first();
            $quote = SupplierQuote::where('vendor_id', $vendor->vendor_id)->orderBy('supplier_quote_id', 'DESC')->get();
            return view('dashboard.supplier_quotation.index')->with([
                'vendor' => $vendor, 'quote' => $quote
            ]);
        } else {
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
    public function create($rfq_id)
    {
        if (Auth::user()->hasRole('Supplier')){
            if(ClientRfq::where('rfq_id', $rfq_id)->exists()){
                $rfq = ClientRfq::where('rfq_id', $rfq_id)->first();
                $vendor = Vendors::where('contact_email', Auth::user()->email)->first();
                $quote = SupplierQUote::where('vendor_id', $vendor->vendor_id)->get();
                $line_items = LineItem::where('rfq_id', $rfq_id)->orderBy('line_id', 'desc')->get();
                // dd($line_items);

                return view('dashboard.rfq.supplier_quotation')->with([
                    'vendor' => $vendor, "rfq" => $rfq, "line_items" => $line_items
                ]);
            }else{
                return redirect()->back()->with([
                    'error' => "No RFQ was found for $rfq_id",
                ]);
            }

        } else {
            // return redirect()->back()->with([
            //     'error' => "You Dont have Access To This Page",
            // ]);
            return view('errors.403');
        }
    }

    public function choose($supplier_quote_id)
    {
        if(SupplierQuote::where('supplier_quote_id', $supplier_quote_id)->exists()){
            if ((Auth::user()->hasRole('Employer')) OR (Gate::allows('SuperAdmin', auth()->user()) OR (Auth::user()->hasRole('Admin')) OR  (Auth::user()->hasRole('HOD')))){
                $quo = $this->model->show($supplier_quote_id);
                $rfq = ClientRfq::where('rfq_id', $quo->rfq_id)->first();

                if((SupplierQuote::where('rfq_id', $quo->rfq_id)) AND (SupplierQuote::where('status', 'Picked'))->exists()){
                    return redirect()->back()->with("error", "You can not pick 2 Supplier Quatation, Please Kindly UnPick, and try again");
                }else {
                    $data = ([
                        "quote" => $this->model->show($supplier_quote_id),
                        "rfq_id" => $quo->rfq_id,
                        "vendor_id" =>  $quo->vendor_id,
                        "quantity" => $quo->quantity,
                        "price" =>  $quo->price,
                        "line_id" =>  $quo->line_id,
                        "status" => 'Picked',
                    ]);
                    if($this->model->update($data, $supplier_quote_id)){

                        $his = new RfqHistory([
                            "user_id" => Auth::user()->user_id,
                            "rfq_id" => $rfq->rfq_id,
                            "action" => "Picked Supplier Quotation for RFQ  ". $rfq->refrence_no,
                        ]); $his->save();

                        return redirect()->back()->with("success", "You Have Picked The Quotation For  The RQF " . $rfq->refrence_no . " Successfully");
                    }else{
                        return redirect()->back()->with("error", "Network Failure");
                    }
                }
            }else{
                return redirect()->back()->with([
                    'error' => "You Dont have Access To This Page",
                ]);
            }
        }else{
            return redirect()->back()->with([
            'error' => "$supplier_quote_id does not Exist for any Supplier Quote",
            ]);
        }

    }

    public function unchoose($supplier_quote_id)
    {
        if(SupplierQuote::where('supplier_quote_id', $supplier_quote_id)->exists()){
            if ((Auth::user()->hasRole('Employer')) OR (Gate::allows('SuperAdmin', auth()->user()) OR (Auth::user()->hasRole('Admin')) OR  (Auth::user()->hasRole('HOD')))){
                $quo = $this->model->show($supplier_quote_id);
                $rfq = ClientRfq::where('rfq_id', $quo->rfq_id)->first();

                $data = ([

                    "quote" => $this->model->show($supplier_quote_id),
                    "rfq_id" => $quo->rfq_id,
                    "vendor_id" =>  $quo->vendor_id,
                    "quantity" => $quo->quantity,
                    "price" =>  $quo->price,
                    "line_id" =>  $quo->line_id,
                    "status" => 'Un Picked',
                ]);
                if($this->model->update($data, $supplier_quote_id)){

                    $his = new RfqHistory([
                        "user_id" => Auth::user()->user_id,
                        "rfq_id" => $rfq->rfq_id,
                        "action" => "Un Picked Supplier Quotation for RFQ  ". $rfq->refrence_no,
                    ]); $his->save();

                    return redirect()->back()->with("success", "You Have Un Picked The Quotation For  The RQF " . $rfq->refrence_no . " Successfully");
                }else{
                    return redirect()->back()->with("error", "Network Failure");
                }
            }else{
                return redirect()->back()->with([
                    'error' => "You Dont have Access To This Page",
                ]);
            }
        }else{
            return redirect()->back()->with([
            'error' => "$supplier_quote_id does not Exist for any Supplier Quote",
            ]);
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
        if (Auth::user()->hasRole('Supplier')){
            $y =  $request->input("show");
            $vendor = Vendors::where('contact_email', Auth::user()->email)->first();
            $vendor_id = $vendor->vendor_id;
            for($i = 1; $i <= $y; $i++){
                $grant = $request->input("topping$i");
                if($grant == 1){

                    $data = new SupplierQuote([
                        "rfq_id" => $request->input("rfq_id$i"),
                        "vendor_id" => $vendor->vendor_id,
                        "quantity" => $request->input("quantity$i"),
                        "price" => $request->input("price$i"),
                        "line_id" => $request->input("line_id$i"),
                        "status" => 'Submitted',
                        "weight" => $request->input("weight$i"),
                        "dimension" => $request->input("dimension$i"),
                        "note" => $request->input("note$i"),
                        "oversize" => "Null",
                        "currency" => 'Null',
                        "location" => "Null",
                    ]);

                    // Up

                    

                    if($data->save()){
                        $his = new RfqHistory([
                            "user_id" => Auth::user()->user_id,
                            "rfq_id" => $request->input("rfq_id$i"),
                            "action" => "Submitted Supplier Quotation for RFQ  ". $request->input("refrence_no$i"),
                        ]); $his->save();
                    }else{
                        return redirect()->back()->with("error", "Network Failure");
                    }

                }

            }
            return redirect()->route("line.list",[$request->input("id")])->with("success", "You Have Submitted Your Quotation For The RQF Successfully");
            // return redirect()->route("sup.quote.index")->with("success", "You Have Submitted Your Quotation For The RQF Successfully");
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
    public function show($rfq_id)
    {
        if(ClientRfq::where('rfq_id', $rfq_id)->exists()){
            // if (Auth::user()->hasRole('Supplier')){

            $vendor = Vendors::where('contact_email', Auth::user()->email)->first();
            $rfq = ClientRfq::where('rfq_id', $rfq_id)->first();
            $quote = SupplierQUote::where('rfq_id', $rfq_id)->get();
            $req = ClientRfq::where('rfq_id', $rfq_id)->get();
            return view('dashboard.supplier_quotation.details')->with([
                'vendor' => $vendor, "quote"=>$quote, "rfq" => $rfq, "req" => $req
            ]);


        }else{
            return redirect()->back()->with([
            'error' => "$rfq_id does not Exist for any RFQ",
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($supplier_quote_id)
    {
        if(SupplierQuote::where('supplier_quote_id', $supplier_quote_id)->exists()){
            if (Auth::user()->hasRole('Supplier')){
                $quote = $this->model->show($supplier_quote_id);
                $rfq = ClientRfq::where('rfq_id', $quote->rfq_id)->first();
                $vendor = Vendors::where('contact_email', Auth::user()->email)->first();
                $line_items = LineItem::where('line_id', $quote->line_id)->get();
                $sup = SupplierQUote::where('vendor_id', $vendor->vendor_id)->get();
                return view('dashboard.supplier_quotation.edit')->with([
                    'vendor' => $vendor, "rfq" => $rfq, "line_items" => $line_items, "quote" => $quote, "sup"=>$sup
                ]);

            }else{
                return redirect()->back()->with([
                    'error' => "You Dont have Access To This Page",
                ]);
            }
        }else{
            return redirect()->back()->with([
            'error' => "$supplier_quote_id does not Exist for any Supplier Quote",
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $supplier_quote_id)
    {
        if (Auth::user()->hasRole('Supplier')){

            $quote = $this->model->show($supplier_quote_id);
            $vendor = Vendors::where('contact_email', Auth::user()->email)->first();
            $data = ([
                "quote" => $this->model->show($supplier_quote_id),
                "rfq_id" => $request->input("rfq_id"),
                "vendor_id" => $vendor->vendor_id,
                "quantity" => $request->input("quantity"),
                "price" => $request->input("price"),
                "line_id" => $request->input("line_id"),
                "status" => 'Submitted',
                "weight" => $request->input("weight"),
                "dimension" => $request->input("dimension"),
                "note" => $request->input("note"),
                "oversize" => $request->input("oversize"),
                "currency" => 'Null',
                "location" => $request->input("location"),
            ]);

            $upda = SupplierQuote::where([
                'rfq_id' => $request->input("rfq_id"),
                "vendor_id" => $vendor->vendor_id])->update([
                "location" => $request->input("location"),
                "oversize" => $request->input("oversize"),
            ]);

            if($this->model->update($data, $supplier_quote_id) AND(!empty($upda))){

                $get = ClientRfq::where('rfq_id', $request->input("rfq_id"))->first();
                $all = $get->value_of_quote_ngn;

                $grossMargin = $get->net_value;

                $sup = SupplierQuote::where([
                    'rfq_id' => $request->input("rfq_id"),
                ])->get();


                $num =1;
                $wej = array();
                foreach($sup as $list){
                    $owo = $list->price;
                    $qty = $list->quantity;
                    $sum = $owo * $qty;
                    array_push($wej, $sum);

                }
                $supQ = array_sum($wej) + 0;
                $unit = $supQ / $all * 100;
                $line_items = LineItem::where('line_id', $request->input("line_id"))->first();

                $line = LineItem::where('line_id', $request->input("line_id"))->update([
                    "quantity" => $line_items->quantity,
                    "unit_price" => $request->input("price"),
                    "total_price" => $request->input("price") * $line_items->quantity,
                    "unit_quote" => $request->input("price") + $unit,
                    "total_quote" => ($request->input("price") + $unit) * $line_items->quantity,

                    "unit_margin" => $unit,
                    "total_margin" => $unit * $line_items->quantity,
                    "unit_frieght" => $line_items->unit_frieght,
                    "total_frieght" => $line_items->total_frieght,
                    "unit_cost" => $request->input("price"),
                    "total_cost" =>$request->input("price") * $line_items->quantity,

                    "unit_cost_naira" => $request->input("price"),
                    "total_cost_naira" => $request->input("price") * $line_items->quantity,

                ]);

                $low = LineItem::where('rfq_id', $request->input("rfq_id"))->update([
                    "unit_frieght" => $grossMargin / $all *100
                ]);

                $datu = ClientRfq::where('rfq_id', $request->input("rfq_id"))->update([
                    "supplier_quote_usd" => array_sum($wej) + 0
                ]);

                $his = new RfqHistory([
                    "user_id" => Auth::user()->user_id,
                    "rfq_id" => $request->input("rfq_id"),
                    "action" => "Updated Supplier Quotation for RFQ  ". $request->input("refrence_no"),
                ]); $his->save();

                if(!empty($datu)){
                    return redirect()->route("sup.quote.show",[$request->input("rfq_id")])->with("success", "You Have Updated Your Quotation For The RQF Successfully");
                }

            }else{
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
    public function destroy($id)
    {
        //
    }
}
