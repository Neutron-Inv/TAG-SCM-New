<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{User, ClientRfq, Shippers, RfqHistory, ShipperQuote, SupplierQuote, LineItem};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

use App\Repositories\ShipperQuoteRepository;
use Illuminate\Support\Facades\Gate;


class ShipperQuoteController extends Controller
{
    protected $model;
    public function __construct(ShipperQuote $quote)
    {
        // set the model
        $this->model = new ShipperQuoteRepository($quote);
        $this->middleware('auth');
        $this->middleware(['role:SuperAdmin|Admin|Employer|Contact|Client|HOD|Shipper']);
    }
    /**
     *
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::allows('SuperAdmin', auth()->user())) {

            $quote = ShipperQuote::orderBy('quote_id', 'desc')->get();
            // dd($quote);
            return view('dashboard.shipper_quotation.index')->with([
                'quote' => $quote
            ]);
        }elseif (Auth::user()->hasRole('Shipper')){

            $shipper = Shippers::where('contact_email', Auth::user()->email)->first();
            $quote = ShipperQuote::where('shipper_id', $shipper->shipper_id)->orderBy('quote_id', 'desc')->get();
            return view('dashboard.shipper_quotation.index')->with([
                'shipper' => $shipper, 'quote' => $quote
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
       if (Auth::user()->hasRole('Shipper')){
            if(ClientRfq::where('rfq_id', $rfq_id)->exists()){
                $rfq = ClientRfq::where('rfq_id', $rfq_id)->first();
                $shipper = Shippers::where('contact_email', Auth::user()->email)->first();
                $quote = ShipperQuote::where('shipper_id', $shipper->shipper_id)->orderBy('quote_id', 'desc')->get();
                $sup = SupplierQuote::where('rfq_id', $rfq_id)->get();
                return view('dashboard.rfq.shipper_quotation')->with([
                    'shipper' => $shipper, "rfq" => $rfq, 'sup' => $sup
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
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::user()->hasRole('Shipper')){
            $custom = $request->input('customs_duty');
            $clearing = $request->input("clearing_and_documentation");
            $bmi = $request->input("bmi_charges");
            $soncap = $request->input("soncap_charges");
            $truck = $request->input("trucking_cost");
            $mode = $request->input("mode");
            $currency = $request->input("currency");

            if(empty($custom) OR (empty($clearing)) OR(empty($soncap)) OR(empty($truck)) OR(empty($mode))){
                $custom =0; $clearing =0; $soncap =0; $truck =0;
            }
            $check= ShipperQuote::where('rfq_id', $request->input("rfq_id"))->get();
            $check2 = ShipperQuote::where("shipper_id",  $request->input("shipper_id"))->get();

            if((count($check) > 0) AND (count($check2) > 0)){
                return redirect()->back()->with([
                    'error' => "You Submitted Your Quotation for this RFQ" .$request->input('refrence_no') . "Before",
                ]);

            }else{
                $shipper = Shippers::where('contact_email', Auth::user()->email)->first();

                $data = new ShipperQuote([
                    "rfq_id" => $request->input("rfq_id"),
                    "customs_duty" => $custom,
                    "clearing_and_documentation" => $clearing,
                    "bmi_charges" => $bmi,
                    "soncap_charges" => $soncap,
                    "trucking_cost" => $truck,
                    "shipper_id" => $shipper->shipper_id,
                    "status" => 'Submitted',
                    "mode" => $mode,
                    "currency" => $currency
                ]);

                if($data->save()){

                    
                    $ship = ShipperQuote::where([
                        'rfq_id' => $request->input("rfq_id"),
                    ])->first();
                    $shipperQuote = $ship->soncap_charges + $ship->customs_duty +  $ship->clearing_and_documentation +  $ship->trucking_cost + $ship->bmi_charges;
                
                    $datu = ClientRfq::where('rfq_id', $request->input("rfq_id"))->update([
                        "freight_charges" => $shipperQuote
                    ]);

                    $his = new RfqHistory([
                        "user_id" => Auth::user()->user_id,
                        "rfq_id" => $request->input("rfq_id"),
                        "action" => "Submitted Shipper Quotation for RFQ  ". $request->input('refrence_no'),
                    ]); $his->save();

                    return redirect()->route("ship.quote.show", [$request->input("rfq_id")])->with("success", "You Have Submitted Your Quotation For  The RQF " .$request->input('refrence_no') . " Successfully");
                }else{
                    return redirect()->back()->with("error", "Network Failure");
                }
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
    public function show($rfq_id)
    {
        if(ShipperQuote::where('rfq_id', $rfq_id)->exists()){
            $quote = ShipperQuote::where('rfq_id', $rfq_id)->get();
            $quo = ShipperQuote::where('rfq_id', $rfq_id)->first();
            $sup = SupplierQuote::where('rfq_id', $rfq_id)->get();
            $req = ClientRfq::where('rfq_id', $rfq_id)->get();
            $line_items = LineItem::where('rfq_id', $rfq_id)->orderBy('created_at','desc')->get();

            return view('dashboard.shipper_quotation.details')->with([
            'quote' => $quote, 'quo' => $quo, "req" => $req, "line_items" => $line_items
            ]);
        }else{
            return redirect()->back()->with([
            'error' => "$rfq_id does not Exist for any RFQ",
            ]);
        }
        // dd($quote);
    }

    public function choose($quote_id)
    {
        if(ShipperQuote::where('quote_id', $quote_id)->exists()){

            if ((Auth::user()->hasRole('Employer')) OR (Gate::allows('SuperAdmin', auth()->user()) OR (Auth::user()->hasRole('Admin')) OR  (Auth::user()->hasRole('HOD')))){
                $quo = $this->model->show($quote_id);
                $rfq = ClientRfq::where('rfq_id', $quo->rfq_id)->first();

                if((ShipperQuote::where('rfq_id', $quo->rfq_id)) AND (ShipperQuote::where('status', 'Picked'))->exists()){
                    return redirect()->back()->with("error", "You can not pick 2 Shipper Quatation, Please Kindly UnPick, and try again");
                }else {
                    $data = ([
                        "quote" => $this->model->show($quote_id),
                        "rfq_id" => $quo->rfq_id,
                        "customs_duty" => $quo->customs_duty,
                        "clearing_and_documentation" => $quo->clearing_and_documentation,
                        "bmi_charges" => $quo->bmi_charges,
                        "soncap_charges" => $quo->soncap_charges,
                        "trucking_cost" => $quo->trucking_cost,
                        "shipper_id" => $quo->shipper_id,
                        "status" => 'Picked',
                    ]);
                    if($this->model->update($data, $quote_id)){

                        $his = new RfqHistory([
                            "user_id" => Auth::user()->user_id,
                            "rfq_id" => $rfq->rfq_id,
                            "action" => "Picked Shipper Quotation for RFQ  ". $rfq->refrence_no,
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
            'error' => "$quote_id does not Exist for any Shipper Quote",
            ]);
        }

    }

    public function unchoose($quote_id)
    {
        if(ShipperQuote::where('quote_id', $quote_id)->exists()){
            if ((Auth::user()->hasRole('Employer')) OR (Gate::allows('SuperAdmin', auth()->user()) OR (Auth::user()->hasRole('Admin')) OR  (Auth::user()->hasRole('HOD')))){
                $quo = $this->model->show($quote_id);
                $rfq = ClientRfq::where('rfq_id', $quo->rfq_id)->first();

                $data = ([
                    "quote" => $this->model->show($quote_id),
                    "rfq_id" => $quo->rfq_id,
                    "customs_duty" => $quo->customs_duty,
                    "clearing_and_documentation" => $quo->clearing_and_documentation,
                    "bmi_charges" => $quo->bmi_charges,
                    "soncap_charges" => $quo->soncap_charges,
                    "trucking_cost" => $quo->trucking_cost,
                    "shipper_id" => $quo->shipper_id,
                    "status" => 'UnPick',
                ]);
                if($this->model->update($data, $quote_id)){

                    $his = new RfqHistory([
                        "user_id" => Auth::user()->user_id,
                        "rfq_id" => $rfq->rfq_id,
                        "action" => "Un Picked Shipper Quotation for RFQ  ". $rfq->refrence_no,
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
            'error' => "$quote_id does not Exist for any Shipper Quote",
            ]);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($quote_id)
    {
        if(ShipperQuote::where('quote_id', $quote_id)->exists()){
            if (Auth::user()->hasRole('Shipper')){

                $quo = $this->model->show($quote_id);
                $rfq = ClientRfq::where('rfq_id', $quo->rfq_id)->first();
                $shipper = Shippers::where('contact_email', Auth::user()->email)->first();
                $quote = ShipperQuote::where('shipper_id', $shipper->shipper_id)->orderBy('quote_id', 'desc')->get();
                $sup = SupplierQuote::where('rfq_id', $quo->rfq_id)->get();
                $line_items = LineItem::where('rfq_id', $quo->rfq_id)->orderBy('created_at','desc')->get();

                return view('dashboard.shipper_quotation.edit')->with([
                    'shipper' => $shipper, "rfq" => $rfq, 'quote' => $quote, "quo" => $quo, "sup" => $sup, "line_items" => $line_items
                ]);
            } else {
                return redirect()->back()->with([
                    'error' => "You Dont have Access To This Page",
                ]);
            }
        }else{
            return redirect()->back()->with([
            'error' => "$quote_id does not Exist for any Shipper Quote",
            ]);
        }
    }

    public function list($rfq_id)
    {
        if(ShipperQuote::where('quote_id', $quote_id)->exists()){
            if (Auth::user()->hasRole('Shipper')){

                $rfq = ClientRfq::where("rfq_id", $rfq_id)->first();
                $quote = SupplierQuote::where('rfq_id', $rfq_id)->get();
                $line_items = LineItem::where('rfq_id', $quo->rfq_id)->orderBy('created_at','desc')->get();
                return view('dashboard.line_items.list')->with([
                    "rfq" => $rfq,
                    "quote"=> $quote, "line_items" => $line_items
                ]);
            } else {
                return redirect()->back()->with([
                    'error' => "You Dont have Access To This Page",
                ]);
            }
        }else{
            return redirect()->back()->with([
            'error' => "$rfq_id does not Exist for any Line Item",
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
    public function update(Request $request, $quote_id)
    {
        if (Auth::user()->hasRole('Shipper')){

            $custom = $request->input('customs_duty');
            $clearing = $request->input("clearing_and_documentation");
            $bmi = $request->input("bmi_charges");
            $soncap = $request->input("soncap_charges");
            $truck = $request->input("trucking_cost");
            $mode = $request->input("mode");
            $currency = $request->input("currency");
            if(empty($custom) OR (empty($clearing)) OR(empty($soncap)) OR(empty($truck)) OR(empty($mode))){
                $custom =0; $clearing =0; $soncap =0; $truck =0;
            }

            $shipper = Shippers::where('contact_email', Auth::user()->email)->first();

                $data = ([
                    "quote" => $this->model->show($quote_id),
                    "rfq_id" => $request->input("rfq_id"),
                    "customs_duty" => $custom,
                    "clearing_and_documentation" => $clearing,
                    "bmi_charges" => $bmi,
                    "soncap_charges" => $soncap,
                    "trucking_cost" => $truck,
                    "shipper_id" => $shipper->shipper_id,
                    "status" => 'Submitted',
                    "mode" => $mode,
                    "currency" => $currency
                ]);

                if($this->model->update($data, $quote_id)){

                    $his = new RfqHistory([
                        "user_id" => Auth::user()->user_id,
                        "rfq_id" => $request->input("rfq_id"),
                        "action" => "Updated Shipper Quotation for RFQ  ". $request->input('refrence_no'),
                    ]); $his->save();

                    $ship = ShipperQuote::where([
                        'rfq_id' => $request->input("rfq_id"),
                    ])->first();
                    $shipperQuote = $ship->soncap_charges + $ship->customs_duty +  $ship->clearing_and_documentation +  $ship->trucking_cost + $ship->bmi_charges;
                
                    $datu = ClientRfq::where('rfq_id', $request->input("rfq_id"))->update([
                        "freight_charges" => $shipperQuote
                    ]);

                    return redirect()->route("ship.quote.show", [$request->input("rfq_id")])->with("success", "You Have Updated The Quotation For  The RQF " .$request->input('refrence_no') . " Successfully");
                    
                }else{
                    return redirect()->back()->with("error", "Network Failure");
                }

        } else {
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
