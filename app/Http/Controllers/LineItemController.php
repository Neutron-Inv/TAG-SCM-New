<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{Companies, User, Clients, SupplierDocument, Log, Employers,ClientRfq, SupplierQuote, ClientPo, RfqHistory, Shippers, ClientContact, LineItem, Vendors, RfqMeasurement};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

use App\Repositories\LineItemRepository;
use Illuminate\Support\Facades\Gate;
use Storage;
use Illuminate\Http\UploadedFile;
use PDF; use DB;
class LineItemController extends Controller
{
    protected $model;
    public function __construct(LineItem $line_item)
    {
        // set the model
        $this->model = new LineItemRepository($line_item);
        $this->middleware('auth');
        $this->middleware(['role:SuperAdmin|Admin|Employer|HOD|Shipper|Supplier']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $unit = RfqMeasurement::orderBy('unit_name', 'asc')->get();
        if (Gate::allows('SuperAdmin', auth()->user())) {
            $line_items = LineItem::orderBy('created_at', 'desc')->get();
            return view('dashboard.line_items.index')->with([
                "line_items" => $line_items, "unit" => $unit
            ]);
        }elseif(Auth::user()->hasRole('Admin')){

            $company = Companies::where('email', Auth::user()->email)->first();
            $client = Clients::where('company_id', $company->company_id)->get();

            return view('dashboard.line_items.index')->with([
                "company" => $company, "client" => $client, "unit" => $unit
            ]);
        }elseif(Auth::user()->hasRole('Client')){
            $client = Clients::where('email', Auth::user()->email)->first();
            $line_items = LineItem::where('client_id', $client->client_id)->orderBy('created_at','desc')->get();
            return view('dashboard.line_items.index')->with([
                "line_items" => $line_items, "client" => $client, "unit" => $unit
            ]);

        }elseif(Auth::user()->hasRole('Employer') OR (Auth::user()->hasRole('HOD')) OR (Auth::user()->hasRole('Admin'))){

            $employer = Employers::where('email', Auth::user()->email)->first();
            $company = Companies::where('company_id', $employer->company_id)->first();
            $client = Clients::where('company_id', $company->company_id)->get();
            return view('dashboard.line_items.index')->with([
                "company" => $company, "client" => $client, "unit" => $unit
            ]);


        } else {

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
        if(ClientRfq::where('rfq_id', $rfq_id)->exists()){
            $unit = RfqMeasurement::orderBy('unit_name', 'asc')->get();
            if (Auth::user()->hasRole('Employer') OR(Auth::user()->hasRole('HOD')) OR(Auth::user()->hasRole('Admin')) OR (Gate::allows('SuperAdmin', auth()->user()))){
                $rfq = ClientRfq::where('rfq_id', $rfq_id)->first();
                $vendor = Vendors::where('company_id', $rfq->company_id)->orderBy('vendor_name', 'asc')->get();

                return view('dashboard.line_items.create')->with([
                    "rfq" => $rfq, "vendor" => $vendor, "unit" => $unit
                ]);
            } else {
                return redirect()->back()->with([
                    'error' => "You Dont have Access To This Page",
                ]);
            }
        }else{
            return redirect()->back()->with([
            'error' => "$rfq_id does not Exist for any RFQ",
            ]);
        }

    }

    public function testing()
    {
        return view("dashboard.line_items.test");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::user()->hasRole('Employer') OR(Auth::user()->hasRole('HOD'))  OR(Auth::user()->hasRole('Admin')) OR (Gate::allows('SuperAdmin', auth()->user()))){

            $this->validate($request, [
                'client_id' => ['required', 'string', 'max:199'],
                'rfq_id' => ['required', 'string', 'max:199'],
                'item_name' => ['required', 'string', 'max:200'],
                'item_number' => ['required', 'string', 'max:199'],
                'vendor_id' => ['required', 'string', 'max:199'],
                'uom' => ['required', 'string', 'max:199'],
                'quantity' => ['required', 'string', 'max:199'],
                'unit_margin' =>['required', 'string', 'max:199'],
                'unit_cost' => ['required', 'string', 'max:199'],
                'item_description' => ['required', 'string'],
            ]);


            $unit_quote = $request->input("unit_cost")  + $request->input("unit_margin");
            $total_cost = $request->input("unit_cost") * $request->input("quantity");
            $total_margin = $request->input("quantity") * $request->input("unit_margin");
            $totalquote = $unit_quote * $request->input("quantity");

            if(empty($request->input("mesc_code"))){
                $mesc_code = 0;
            }else{
                $mesc_code = $request->input("mesc_code");
            }

            if($totalquote < 1){ $total_quote = 1; }else { $total_quote = $totalquote; }
            $data = new LineItem([

                "client_id" => $request->input("client_id"),
                "rfq_id" => $request->input("rfq_id"),
                "item_name" => $request->input("item_name"),
                "item_number" => $request->input("item_number"),
                "vendor_id" => $request->input("vendor_id"),
                "uom" => $request->input("uom"),
                "quantity" => $request->input("quantity"),
                "unit_margin" => $request->input("unit_margin"),
                "unit_quote" => $unit_quote,
                "total_quote" => $total_quote,
                "total_margin" => $total_margin,
                "total_cost" => $total_cost,
                "unit_frieght" => 0,
                "total_frieght" => 0,
                "unit_price" => 0,
                "unit_cost_naira" => 0,
                "total_cost_naira" => 0,
                "total_price" => 0,
                "unit_cost" => $request->input("unit_cost"),
                "mesc_code" => $mesc_code,
                "item_description" => $request->input("item_description"),

            ]);

            $log = new Log([
                "user_id" => Auth::user()->user_id,
                "activities" => 'Created Line Item for RFQ  ' . $request->input('refrence_no'),
            ]);

            $rfq = ClientRfq::where('rfq_id', $request->input("rfq_id"))->first();
            if(($data->save()) AND ($log->save())){
                $datas = new SupplierQuote([
                    "rfq_id" => $request->input("rfq_id"),
                    "vendor_id" => $request->input("vendor_id"),
                    "quantity" => $request->input("quantity"),
                    "price" => 0,
                    "line_id" => $data->line_id,
                    "status" => 'Submitted',
                    "weight" => 0,
                    "dimension" => "Null",
                    "note" => "Null",
                    "oversize" => "No",
                    "currency" => 'Null',
                    "location" => 'Null',
                ]);
                $datas->save();
                $line_items = LineItem::where(['rfq_id' => $request->input("rfq_id")])->orderBy('created_at','desc')->get();
                if(count($line_items) > 0){

                    if (Gate::allows('SuperAdmin', auth()->user())) {
                        $pdf = PDF::loadView('dashboard.printing.check', compact('rfq', 'line_items'))->setPaper('ledger', 'portrait');
                    }elseif(auth()->user()->hasRole('Admin')){
                        $company = Companies::where('email', Auth::user()->email)->first();
                        $pdf = PDF::loadView('dashboard.printing.check', compact('rfq', 'line_items', 'company'))->setPaper('ledger', 'portrait');
                    }elseif(auth()->user()->hasRole('Employer') OR (auth()->user()->hasRole('HOD'))){
                        $employee = Employers::where('email', Auth::user()->email)->first();
                        $pdf = PDF::loadView('dashboard.printing.check', compact('rfq', 'line_items', 'employee'))->setPaper('ledger', 'portrait');
                    }else{
                        $pdf = PDF::loadView('dashboard.printing.check', compact('rfq', 'line_items'))->setPaper('ledger', 'portrait');
                    }

                    $name = cops($rfq->company_id);
                    $fileName = "$name->company_name Quotation " .$rfq->refrence_no . ", ". $rfq->description.'.pdf';
                    $pdf->getDomPDF()->set_option("enable_php", true);
                    $output = $pdf->output();
                    $dir = base_path("email/rfq/".$rfq->refrence_no."/");
                    !file_exists(File::makeDirectory($dir, $mode = 0777, true, true));		        
                    $pdf->save($dir .'/'.$fileName);

                }
                return redirect()->route("line.preview",[$rfq->rfq_id])->with(["success" => 'You Have Created Line Item for RFQ  ' . $request->input('refrence_no'). " Successfully"]);

            } else {
                return redirect()->back()->with("error", "Network Failure");
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
    public function show($line_id)
    {
        if(LineItem::where('line_id', $line_id)->exists()){

            $line_items = $this->model->show($line_id);
            return view('dashboard.line_items.details')->with([
                'line_items' => $line_items
            ]);

        }else{
            return redirect()->back()->with([
            'error' => "$line_id does not Exist for any Line Item",
            ]);
        }
    }

    public function preview($rfq_id)
    {
        if(LineItem::where('rfq_id', $rfq_id)->exists()){
            $line_items = LineItem::where('rfq_id', $rfq_id)->orderBy('created_at','asc')->get();

            $rfq = ClientRfq::where("rfq_id", $rfq_id)->get();
            $rfqs = ClientRfq::where("rfq_id", $rfq_id)->first();
            return view('dashboard.line_items.view')->with([
                "line_items" => $line_items, "rfq" => $rfq, "rfqs" => $rfqs
            ]);
        }else{
            return redirect()->route('line.create',[$rfq_id])->with([
                'error' => "No Line Items was found for this RFQ, Please create the line item below",
            ]);
        }
    }

    public function list($rfq_id)
    {
        if(SupplierQuote::where('rfq_id', $rfq_id)->exists()){
            $line_items = LineItem::where('rfq_id', $rfq_id)->orderBy('created_at','asc')->get();
            $rfq = ClientRfq::where("rfq_id", $rfq_id)->first();
            $quote = SupplierQuote::where('rfq_id', $rfq_id)->get();
            $req = ClientRfq::where("rfq_id", $rfq_id)->get();
            $files = SupplierDocument::where(['rfq_id' => $rfq->rfq_id, 'vendor_id' => $rfq->vendor_id])->get();
            return view('dashboard.line_items.list')->with([
                "rfq" => $rfq,"quote"=> $quote, "req" => $req, 'files' => $files
            ]);
        }else{
            return redirect()->back()->with([
            'error' => "$rfq_id does not Exist for any Line Item",
            ]);
        }
    }

    public function duplicate($line_id)
    {
        if(LineItem::where('line_id', $line_id)->exists()){

            if (Auth::user()->hasRole('Employer') OR(Auth::user()->hasRole('HOD')) OR(Auth::user()->hasRole('Admin')) OR (Gate::allows('SuperAdmin', auth()->user()))){
                // Get the count parameter from the URL
                $count = request('count');

                for ($i = 0; $i < $count; $i++) {
                    $line_items = $this->model->show($line_id);
                    $rfq_idd = $line_items->rfq_id;
                    // Find the maximum item number and item serial number for the given rfq_id
                    $max_itemno = LineItem::where('rfq_id', $rfq_idd)->max('item_number');
                    $fitem_sn = LineItem::where('rfq_id', $rfq_idd)->max('item_serialno');
                
                    // Check if the maximum values are null (no existing records)
                    if ($max_itemno === null) {
                        $max_itemno = 0;
                    }
                    if ($fitem_sn === null) {
                        $fitem_sn = 0;
                    }
                    if (!is_numeric($max_itemno) OR $max_itemno !== "") {
                        $max_itemno = 0;
                    }
                
                    // Calculate new values for item number and item serial number
                    $new_itemno = $max_itemno + 1;
                    $item_sn = $fitem_sn + 1;

                $data = new LineItem ([
                    // "line_item" =>new LineItem,
                    "client_id" =>$line_items->client_id,
                    "rfq_id" => $line_items->rfq_id,
                    "item_serialno" => $item_sn,
                    "item_name" => $line_items->item_name,
                    "item_number" => $new_itemno,
                    "vendor_id" => $line_items->vendor_id,
                    "uom" => $line_items->uom,

                    "quantity" => $line_items->quantity,
                    "unit_price" => $line_items->unit_price,
                    "total_price" => $line_items->total_price,
                    "unit_quote" => $line_items->unit_quote,
                    "total_quote" => $line_items->total_quote,

                    "unit_margin" => $line_items->unit_margin,
                    "total_margin" => $line_items->total_margin,
                    "unit_frieght" => $line_items->unit_frieght,
                    "total_frieght" => $line_items->total_frieght,
                    "unit_cost" => $line_items->unit_cost,
                    "total_cost" => $line_items->total_cost,

                    "unit_cost_naira" => $line_items->unit_cost_naira,
                    "total_cost_naira" => $line_items->total_cost_naira,
                    "item_description" => $line_items->item_description,
                    "mesc_code" => $line_items->mesc_code,

                ]);

                $data->save();
            }

                $log = new Log([
                    "user_id" => Auth::user()->user_id,
                    "activities" => 'Duplicated Line Item for RFQ  ',
                ]);

                if($log->save()){
                    $rfq = ClientRfq::where('rfq_id', $line_items->rfq_id)->first();

                    $datas = new SupplierQuote([
                        "rfq_id" => $line_items->rfq_id,
                        "vendor_id" => $line_items->vendor_id,
                        "quantity" => $line_items->quantity,
                        "price" => 0,
                        "line_id" => $data->line_id,
                        "status" => 'Submitted',
                        "weight" => 0,
                        "dimension" => "Null",
                        "note" => "Null",
                        "oversize" => "No",
                        "currency" => 'Null',
                        "location" => '',
                    ]); $datas->save();
                    
                    $supQuote = $rfq->supplier_quote_usd;
                    $newSup = $line_items->quantity * 0;
                    $his = new RfqHistory([
                        "user_id" => Auth::user()->user_id,
                        "rfq_id" => $line_items->rfq_id,
                        "action" => "Duplicated a Line Item for RFQ  ". $rfq->refrence_no,
                    ]); $his->save();
                    $line_items = LineItem::where(['rfq_id' => $line_items->rfq_id])->orderBy('created_at','desc')->get();
                    if(count($line_items) > 0){
                        if (Gate::allows('SuperAdmin', auth()->user())) {
                            $pdf = PDF::loadView('dashboard.printing.check', compact('rfq', 'line_items'))->setPaper('ledger', 'portrait');
                        }elseif(auth()->user()->hasRole('Admin')){
                            $company = Companies::where('email', Auth::user()->email)->first();
                            $pdf = PDF::loadView('dashboard.printing.check', compact('rfq', 'line_items', 'company'))->setPaper('ledger', 'portrait');
                        }elseif(auth()->user()->hasRole('Employer') OR (auth()->user()->hasRole('HOD'))){
                            $employee = Employers::where('email', Auth::user()->email)->first();
                            $pdf = PDF::loadView('dashboard.printing.check', compact('rfq', 'line_items', 'employee'))->setPaper('ledger', 'portrait');
                        }else{
                            $pdf = PDF::loadView('dashboard.printing.check', compact('rfq', 'line_items'))->setPaper('ledger', 'portrait');
                        }
                        $name = cops($rfq->company_id);
                        $fileName = "$name->company_name Quotation " .$rfq->refrence_no . ", ". $rfq->description.'.pdf';
                        $pdf->getDomPDF()->set_option("enable_php", true);
                        $output = $pdf->output();

                        $dir = base_path("email/rfq/".$rfq->refrence_no."/");
                        !file_exists(File::makeDirectory($dir, $mode = 0777, true, true));		                     
                        $pdf->save($dir .'/'.$fileName);

                    }
                    return redirect()->back()->with("success", 'You Have Duplicated Line Item Successfully');
                } else {
                    return redirect()->back()->with("error", "Network Failure");
                }
            } else {
                return redirect()->back()->with([
                    'error' => "You Dont have Access To This Page",
                ]);
            }
        }else{
            return redirect()->back()->with([
            'error' => "$line_id does not Exist for any Line Item",
            ]);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($line_id)
    {
        if(LineItem::where('line_id', $line_id)->exists()){
            if (Auth::user()->hasRole('Employer') OR(Auth::user()->hasRole('HOD')) OR(Auth::user()->hasRole('Admin')) OR (Gate::allows('SuperAdmin', auth()->user()))){
                $line_items = $this->model->show($line_id);
                // dd($line_items);
                $rfq = ClientRfq::where('rfq_id', $line_items->rfq_id)->first();
                // dd($rfq);
                $vendor = Vendors::where('company_id', $rfq->company_id)->orderBy('vendor_name', 'asc')->get();
                // $vendor = Vendors::orderBy('vendor_name', 'asc')->get();
                $line_item = LineItem::where('rfq_id', $rfq->rfq_id)->orderBy('created_at','asc')->get();
                $rfqs = ClientRfq::where("rfq_id", $rfq->rfq_id)->get();
                $unit = RfqMeasurement::orderBy('unit_name', 'asc')->get();
                $unitPercent = $rfq->percent_margin;
                return view('dashboard.line_items.edit')->with([
                    "rfq" => $rfq, "vendor" => $vendor, 'line_items' => $line_items, "unitPercent" => $unitPercent
                    ,"line_item" => $line_item, "rfqs" => $rfqs, "unit" => $unit
                ]);
            } else {
                return redirect()->back()->with([
                    'error' => "You Dont have Access To This Page",
                ]);
            }
        }else{
            return redirect()->back()->with([
            'error' => "$line_id does not Exist for any Line Item",
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
    public function update(Request $request, $line_id)
    {
        if (Auth::user()->hasRole('Employer') OR(Auth::user()->hasRole('HOD')) OR(Auth::user()->hasRole('Admin')) OR (Gate::allows('SuperAdmin', auth()->user()))){

            $this->validate($request, [
                'client_id' => ['required', 'string', 'max:199'],
                'item_serialno' => ['required', 'string', 'max:199'],
                'rfq_id' => ['required', 'string', 'max:199'],
                'item_name' => ['required', 'string', 'max:200'],
                'item_number' => ['required', 'string', 'max:199'],
                'vendor_id' => ['required', 'string', 'max:199'],
                'uom' => ['required', 'string', 'max:199'],
                'quantity' => ['required', 'string', 'max:199'],

                'total_price' => ['string', 'max:199'],
                'unit_quote' => ['string', 'max:200'],
                'total_quote' =>['required', 'string', 'max:199'],
                'unit_margin' =>['required', 'string', 'max:199'],
                'total_margin' =>['required', 'string', 'max:199'],
                'unit_cost' => ['required', 'string', 'max:199'],
                'total_cost' => ['required', 'string', 'max:199'],
                'item_description' => ['required'],

            ]);

            $unit_quote = $request->input("unit_cost")  + $request->input("unit_margin");
            $total_cost = $request->input("unit_cost") * $request->input("quantity");
            $total_margin = $request->input("quantity") * $request->input("unit_margin");
            $total_quote = $unit_quote * $request->input("quantity");

            if(empty($request->input("mesc_code"))){
                $mesc_code = 0;
            }else{
                $mesc_code = $request->input("mesc_code");
            }

            $data = ([
                "line_item" => $this->model->show($line_id),
                "client_id" => $request->input("client_id"),
                "rfq_id" => $request->input("rfq_id"),
                "item_serialno" => $request->input("item_serialno"),
                "item_name" => $request->input("item_name"),
                "item_number" => $request->input("item_number"),
                "vendor_id" => $request->input("vendor_id"),
                "uom" => $request->input("uom"),
                "quantity" => $request->input("quantity"),
                "unit_margin" => $request->input("unit_margin"),
                "unit_quote" => $unit_quote,
                "total_quote" => $total_quote,
                "total_margin" => $total_margin,
                "total_cost" => $total_cost,
                "unit_frieght" => $request->input('unit_percent'),
                "total_frieght" => 0,
                "unit_price" => $unit_quote,
                "unit_cost_naira" => $unit_quote,
                "total_cost_naira" => $total_cost,
                "total_price" => $total_quote,
                "unit_cost" => $request->input("unit_cost"),
                "item_description" => $request->input("item_description"),
                "mesc_code" => $mesc_code

            ]);

            $log = new Log([
                "user_id" => Auth::user()->user_id,
                "activities" => 'Updated Line Item for RFQ  ' . $request->input('refrence_no'),
            ]);

            $line = $this->model->show($line_id);
            
            $rfq = ClientRfq::where('rfq_id', $line->rfq_id)->first();

            $num =1;
            $wej = array();
            $sup = SupplierQuote::where([
                'rfq_id' => $request->input("rfq_id"),
            ])->get();
            if($this->model->update($data, $line_id) OR ($log->save())){

                foreach($sup as $list){
                    $owo = $list->price;
                    $qty = $list->quantity;
                    $sum = $owo * $qty;
                    array_push($wej, $sum);
                }
                $supQ = array_sum($wej) + 0;
                $datu = ClientRfq::where('rfq_id', $request->input("rfq_id"))->update([
                    "supplier_quote_usd" => array_sum($wej) + 0
                ]);
		        $low = LineItem::where('rfq_id', $request->input("rfq_id"))->update([
                    "unit_frieght" => $line->rfq->percent_margin
                ]);
		        $his = new RfqHistory([
                    "user_id" => Auth::user()->user_id,
                    "rfq_id" => $request->input("rfq_id"),
                    "action" => "Updated a Line Item for RFQ  ". $rfq->refrence_no,
                ]); $his->save();
                $line_items = LineItem::where(['rfq_id' => $request->input("rfq_id")])->get();
                if(count($line_items) > 0){
                    if (Gate::allows('SuperAdmin', auth()->user())) {
                        $pdf = PDF::loadView('dashboard.printing.check', compact('rfq', 'line_items'))->setPaper('ledger', 'portrait');
                    }elseif(auth()->user()->hasRole('Admin')){
                        $company = Companies::where('email', Auth::user()->email)->first();
                        $pdf = PDF::loadView('dashboard.printing.check', compact('rfq', 'line_items', 'company'))->setPaper('ledger', 'portrait');
                    }elseif(auth()->user()->hasRole('Employer') OR (auth()->user()->hasRole('HOD'))){
                        $employee = Employers::where('email', Auth::user()->email)->first();
                        $pdf = PDF::loadView('dashboard.printing.check', compact('rfq', 'line_items', 'employee'))->setPaper('ledger', 'portrait');
                    }else{
                        $pdf = PDF::loadView('dashboard.printing.check', compact('rfq', 'line_items'))->setPaper('ledger', 'portrait');
                    }
                    $name = cops($rfq->company_id);
                    // dd($name);
                    $fileName = "$name->company_name Quotation " .$rfq->refrence_no . ", ". $rfq->description.'.pdf';
                    $pdf->getDomPDF()->set_option("enable_php", true);
                    $output = $pdf->output();

                    $dir = base_path("email/rfq/".$rfq->refrence_no."/");
                    !file_exists(File::makeDirectory($dir, $mode = 0777, true, true));		           
                    $pdf->save($dir .'/'.$fileName);

                }
                return redirect()->route("line.preview",[$request->input("rfq_id")])->with([
                    "success" => 'You Have Updated Line Item for RFQ  ' . $request->input('refrence_no'). " Successfully"
                ]);

	    } else {
                return redirect()->back()->with("error", "Network Failure");
            }

        } else {

            return view('errors.403');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($line_id)
    {
        if(LineItem::where('line_id', $line_id)->exists()){
            $details = $this->model->show($line_id);
            if(DB::table('line_items')->where(['line_id' => $line_id])->delete()){
                DB::table('supplier_quotes')->where(['line_id' => $line_id])->delete();
                return redirect()->back()->with([
                    'success' => "You Have Deleted The Line Item Successfully",
                ]);
            }else{
                return redirect()->back()->with([
                    'error' => "Network Failure, Please Try again Later",
                ]);
            }
        }else{
            return redirect()->back()->with([
            'error' => "$line_id does not Exist for any Line Item",
            ]);
        }
    }

    public function saveFiles(Request $request)
    {
        $this->validate($request, [
            'document' => ['required'],
        ]);
        $vendor_id = $request->input('vendor_id');
        $rfq_id = $request->input('rfq_id');
        if($request->hasFile('document')) {
            $file = $request->document;
            foreach ($file as $files) {
                $filenameWithExt = $files->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $files->getClientOriginalExtension();
                $fileNameToStore = $filename.'_'.time().'.'.$extension;
                $dir ='supplier-document/';
                if(is_dir($dir) === false )
                {
                    mkdir($dir);
                }
                $path=$files->move(($dir), $fileNameToStore);
                $doc = new SupplierDocument([
                    'vendor_id' => $vendor_id, 
                    'rfq_id' => $rfq_id, 'file' => $fileNameToStore
                ]);
                $doc->save();
            }
            return redirect()->back()->with(['success' => "File Uploaded Successfully"  ]);
        }else{
            return redirect()->back()->with(['error' => "Please Select a file to upload"  ]);
        }
    }

    public function removeFile($id, $vendor_id){
        $files = SupplierDocument::where(['id' => $id, 'vendor_id' => $vendor_id])->get();
        if(count($files) > 0){
            $doc =SupplierDocument::where(['id' => $id, 'vendor_id' => $vendor_id])->first();
            if((!empty(unlink('supplier-document/'.$doc->file))) AND (SupplierDocument::where(['id' => $id, 'vendor_id' => $vendor_id])->delete())){
                return redirect()->back()->with(['success' => "File Deleted Successfully "]);
            }else{
                return redirect()->back()->with(['error' => "Unable to delete file at the moment, Please try again later"  ]);
            }
        }else{
            return redirect()->back()->with(['error' => "The Selected File is not associated to your account"  ]);
        }
 
     }
}
