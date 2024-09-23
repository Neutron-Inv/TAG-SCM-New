<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{Companies, User, Clients, Log, Employers,ClientRfq, ClientPo, Shippers, ClientContact, ScmStatus, LineItem, Vendors, RfqHistory};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use DB; 
use PDF; use Dompdf\FontMetrics;
use Illuminate\Support\Facades\Mail;
use App\Repositories\ClientPORepository;
use Illuminate\Support\Facades\Gate;
use App\Mail\{POAcknowledge, POReport, SupplierQuotation};

use Storage;
use Illuminate\Http\UploadedFile;
class ClientPOController extends Controller
{
    protected $model;
    public function __construct(ClientPo $po)
    {
        // set the model
        $this->model = new ClientPORepository($po);
        $this->middleware('auth');
        $this->middleware(['role:SuperAdmin|Admin|Client|HOD|Employer|Contact|Shipper']);
    }
    /*
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::allows('SuperAdmin', auth()->user())) {

            $company = Companies::orderBy('company_name','asc')->get();
            $po = ClientPo::join('client_rfqs', 'client_pos.rfq_id', '=', 'client_rfqs.rfq_id')
                            ->orderBy('client_pos.created_at', 'desc')
                            ->get(['client_pos.*', 'client_rfqs.refrence_no']);
           
            return view('dashboard.po.index')->with([
                "company" => $company, 'po' => $po
            ]);
        }elseif(Auth::user()->hasRole('Admin')){

            $company = Companies::where('email', Auth::user()->email)->first();
            $po = ClientPo::join('client_rfqs', 'client_pos.rfq_id', '=', 'client_rfqs.rfq_id')
            ->where('client_pos.company_id', $company->company_id)
            ->orderBy('client_pos.created_at', 'desc')
            ->get(['client_pos.*', 'client_rfqs.refrence_no']);
            return view('dashboard.po.index')->with([

                "company" => $company, 'po' => $po
            ]);

        }elseif((Auth::user()->hasRole('Employer')) OR (Auth::user()->hasRole('HOD'))){

            $employer = Employers::where('email', Auth::user()->email)->first();
            $company = Companies::where('company_id', $employer->company_id)->first();
            $po = ClientPo::join('client_rfqs', 'client_pos.rfq_id', '=', 'client_rfqs.rfq_id')
                            ->where('client_pos.company_id', $employer->company_id)
                            ->orderBy('client_pos.created_at', 'desc')
                            ->get(['client_pos.*', 'client_rfqs.refrence_no']);

            return view('dashboard.po.index')->with([
                'employer' => $employer, 'po' => $po, 'company' => $company
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
    public function create($refrence_no)
    {
        if(ClientRfq::where('refrence_no', $refrence_no)->exists()){
            if (Auth::user()->hasRole('Employer') OR(Auth::user()->hasRole('HOD'))){
                $status = ScmStatus::where('type', 'PO')->orderBy('name', 'asc')->get();
                $rfq = ClientRfq::where('refrence_no', $refrence_no)->first();
                
                $client_id = $rfq->client_id;
                $company_id = $rfq->company_id;
                $company = Companies::where('company_id',$company_id)->get();
                $po = ClientPo::where('client_id', $client_id)->get();
                
                $employer = Employers::where('company_id', $company_id)->orderBy('full_name', 'asc')->get();
                $client = ClientContact::where('client_id', $client_id)->orderBy('first_name', 'asc')->get();
                $shipper = Shippers::where('company_id', $company_id)->orderBy('shipper_name', 'asc')->get();

                return view('dashboard.po.create')->with([
                    'employer' => $employer, "rfq" => $rfq, "company" => $company, "client" => $client,
                    'po' => $po, "shipper" => $shipper, "status" => $status
                ]);


            } else {
                return redirect()->back()->with([
                    'error' => "You Dont have Access To This Page",
                ]);
            }
        }else{
            return redirect()->back()->with([
            'error' => "$refrence_no does not Exist for any RFQ",
            ]);
        }
    }

    public function downloadQuote($po_id)
    {
        if(ClientPO::where('po_id', $po_id)->exists()){ 

            $po = ClientPO::where('po_id', $po_id)->first();
            $rfq = ClientRfq::where('rfq_id', $po->rfq_id)->first();
            $line_items = LineItem::where(['rfq_id' => $rfq->rfq_id])->orderBy('created_at','asc')->get();
            $sup = Vendors::where('vendor_id', $rfq->supplier_id)->get();
            if(count($line_items) > 0){
                
                return view('dashboard.po.viewPDF')->with([
                    'rfq' => $rfq, 'line_items' => $line_items, 'sup' => $sup, 'po' => $po
                ]);
                
            }else{
                return redirect()->back()->with(['error' => "No Line Items was found"]);
            }

        }else{
            return redirect()->back()->with([
                'error' => "$id does not Exist for any RFQ",
            ]);
        } 

    }

    public function printPriceQuote($po_id)
    {
        if(ClientPO::where('po_id', $po_id)->exists()){
            $po = ClientPO::where('po_id', $po_id)->first();
            $rfq = ClientRfq::where('rfq_id', $po->rfq_id)->first();
            
            $sup = Vendors::where('vendor_id', $rfq->vendor_id)->get();
            $line_items = LineItem::where(['rfq_id' => $rfq->rfq_id])->orderBy('created_at','asc')->get();
            $tq = 0;
            foreach($line_items as $line){
                $tq = ($line->quantity * $line->unit_cost) + $tq;
            }
            if(count($line_items) > 0){
                $customPaper = array(0, 0, 566.929133858, 283.464566929 );
                $pdf = PDF::loadView('dashboard.printing.supplier_quote', compact('rfq', 'line_items', 'sup', 'po', 'tq'))->setPaper('ledger', 'portrait');
                $name = cops($rfq->company_id);
                $fileName = "Purchase Order " .$rfq->refrence_no . ", ". $rfq->product.'.pdf';
                $pdf->getDomPDF()->set_option("enable_php", true);
                $output = $pdf->output();
                $dir = base_path("email/po/".$rfq->refrence_no."/");
                !file_exists(File::makeDirectory($dir, $mode = 0777, true, true));
                $pdf->save($dir.$fileName);
                return redirect()->route('po.pdf',[$po_id])->with("success", "PDF Generated successfully.");
            }else{
                return redirect()->back()->with(['error' => "No Line Items was found"]);
            }
        
        }else{
            return redirect()->back()->with([
            'error' => "$po_id does not Exist for any PO",
            ]);
        }
    }

    public function submitSupplierQuotation(Request $request)
    {
        $this->validate($request, [
            'email' => ['required', 'string'],
            'recipient' => ['required'],
           
        ]);
        $rfq_id = $request->input("rfq_id");
        $po_id = $request->input("po_id");
        $po = $this->model->show($po_id);
        $line_items = LineItem::where(['rfq_id' => $rfq_id])->orderBy('created_at','asc')->get();
        $sup = Vendors::where('vendor_id', $rfq_id)->get();
        $rfq = ClientRfq::where('rfq_id', $rfq_id)->first();
        if(count($line_items) > 0){
            
            $rec_mail = $request->input("email");
            $recipient = $request->input("recipient");
            
            $cut = explode("; ", $recipient);
            $users = [];
            foreach($cut as $key => $ut){
                $ua = [];
                $ua['email'] = $ut;
                $split = $cut = explode("@", $ut);
                $ua['name'] = strtoupper(str_replace(".","",$split[0]));
                $users[$key] = (object)$ua;
            }
            try{
                $tq = 0;
                foreach($line_items as $line){
                    $tq = ($line->quantity * $line->unit_cost) + $tq;
                }
                $pdf = PDF::loadView('dashboard.printing.supplier_quote', compact('rfq', 'line_items', 'sup', 'po', 'tq'))->setPaper('ledger', 'portrait');
                $name = cops($rfq->company_id);
                $fileName = "Purchase Order " .$rfq->refrence_no . ", ". $rfq->product.'.pdf';
                $pdf->getDomPDF()->set_option("enable_php", true);
                $output = $pdf->output();
                
                $dir = base_path("email/po/".$rfq->refrence_no."/");
                !file_exists(File::makeDirectory($dir, $mode = 0777, true, true));
                // $pdf->save($dir.$fileName); 
                $vendor = Vendors::where('vendor_id', $rfq->vendor_id)->first();
                $data = ['vendor' => $vendor,'dir' => $dir, 'company' => Companies::where('company_id', $rfq->company_id)->first(), 'po' => $po, 'rfq' => $rfq];
                $when = now()->addMinutes(1);
                $company_id = $rfq->company_id;

                Mail::to('taiwo@enabledgroup.net')->cc(str_replace(" ","",$users))->send( new SupplierQuotation ($data));  

                $newNote = $po->note . '<br>'. date('d/m/Y') .' ' . Auth::user()->first_name . ' '. Auth::user()->last_name .' Send Quotation  to '. $rec_mail . ' and changed the status to Quotation Submitted <br>';
                DB::table('client_pos')->where(['rfq_id' => $rfq_id])->update(['note' => $newNote, 'status' => 'PO Issued to Supplier']);
                $his = new RfqHistory([
                    "user_id" => Auth::user()->user_id,
                    "rfq_id" => $rfq_id,
                    "action" => "Sent Quotation to $rec_mail",
                ]); $his->save();
                return redirect()->back()->with("success", "Quotation Was Sent to The Shipper successfully.");
            }catch(\Exception $e){
                return redirect()->back()->with("error", "Email not sent, ". $e->getMessage());
            }

            
        }else{
            return redirect()->back()->with([
                'error' => "No Line Items was found for this PO",
            ]);
        }

    }


    public function new($rfq_id)
    {
        if(ClientRfq::where('rfq_id', $rfq_id)->exists()){
            $po = ClientPo::where('rfq_id', $rfq_id)->get();
            $rfq = ClientRfq::where('rfq_id', $rfq_id)->first();
            // dd($po);
            return view('dashboard.po.newList')->with([
                'po' => $po, "rfq" => $rfq
            ]);
        }else{
            return redirect()->back()->with([
            'error' => "$rfq_id does not Exist for any RFQ",
            ]);
        }

    }

    public function report()
    {
        if (Gate::allows('SuperAdmin', auth()->user())) {
            $client = DB::table('client_pos')->select('client_id')->groupBy('client_id')->get();

            return view('dashboard.po.reports')->with([
                'client' => $client,
            ]);
        }elseif(Auth::user()->hasRole('Admin')){
            $company = Companies::where('email', Auth::user()->email)->first();
            $client = DB::table('client_pos')->select('client_id', 'company_id')->groupBy('client_id', 'company_id')->where('company_id', $company->company_id)->get();

            return view('dashboard.po.reports')->with([
                'client' => $client,
            ]);

        }elseif((Auth::user()->hasRole('Employer') OR (Auth::user()->hasRole('HOD')))){

            $employer = Employers::where('email', Auth::user()->email)->first();
            $company = Companies::where('company_id', $employer->company_id)->first();
            $client =  DB::table('client_pos')->select('client_id', 'company_id')->groupBy('client_id', 'company_id')->where('company_id', $company->company_id)->get();
            return view('dashboard.po.reports')->with([
                "client" => $client,
            ]);
        } else {

            return view('errors.403');
        }
    }

    public function reportClient($client_id)
    {
        if(Clients::where('client_id', $client_id)->exists()){

            if (Gate::allows('SuperAdmin', auth()->user())) {
                $client = Clients::where('client_id', $client_id)->first();
                $po = ClientPo::where('client_id', $client_id)->get();
                return view('dashboard.po.clientReport')->with([
                    'client' => $client, 'po' => $po
                ]);
            }elseif(Auth::user()->hasRole('Admin')){

                $company = Companies::where('email', Auth::user()->email)->first();
                if(Clients::where(['company_id' => $company->company_id, 'client_id' => $client_id])->exists()){
                    $client = Clients::where(['company_id' => $company->company_id, 'client_id' => $client_id])->first();
                    $po = ClientPo::where(['client_id' => $client_id, 'company_id' => $company->company_id])->get();
                    return view('dashboard.po.clientReport')->with([
                        'client' => $client, 'po' => $po
                    ]);
                }else{
                    return redirect()->back()->with([
                        'error' => "$client_id does not Exist for any of your Clients",
                    ]);
                }


            }elseif((Auth::user()->hasRole('Employer') OR (Auth::user()->hasRole('HOD')))){
                $employer = Employers::where('email', Auth::user()->email)->first();
                $company = Companies::where('company_id', $employer->company_id)->first();
                if(Clients::where(['company_id' => $company->company_id, 'client_id' => $client_id])->exists()){
                    $client = Clients::where(['company_id' => $company->company_id, 'client_id' => $client_id])->first();
                    $po = ClientPo::where(['client_id' => $client_id, 'company_id' => $company->company_id])->get();
                    return view('dashboard.po.clientReport')->with([
                        'client' => $client, 'po' => $po
                    ]);
                }else{
                    return redirect()->back()->with([
                        'error' => "$client_id does not Exist for any of your Clients",
                    ]);
                }

            } else {
                return redirect()->back()->with([
                    'error' => "You Dont have Access To This Page",
                ]);
            }
        }else{
            return redirect()->back()->with([
                'error' => "$client_id does not Exist for any Client",
            ]);
        }
    }



    public function sendReport(Request $request)
    {
        $this->validate($request, [
            'company_name' => ['required', 'string', 'max:199'],
            'client_name' => ['required', 'string', 'max:199'],
            'email' => ['required', 'string',],
            'receipients' => ['required',],
        ]);
        $client_id = $request->input('client_id');
        $company_id = $request->input('company_id');
        $receipients = $request->input('receipients');
        $company = Companies::where('company_id', $company_id)->first();
        $client = Clients::where('client_id', $client_id)->first();
        $email = $request->input('email');

        $cut = explode("; ", $receipients);
        $users = [];
        foreach($cut as $key => $ut){
            $ua = [];
            $ua['email'] = $ut;
            $split = $cut = explode("@", $ut);
            $ua['name'] = strtoupper(str_replace("."," ",$split[0]));
            $users[$key] = (object)$ua;
        }
        $company_name = $request->input('company_name');
        $client_name = $request->input('client_name');
        $po = ClientPo::where('client_id', $client_id)->get();
        try{
            $data = ["client" => $client, 'company' => $company, 'company_name' => $company_name, 'client_name' => $client_name, 'po' => $po];
            $when = now()->addMinutes(1);
            Mail::to($email)->cc(str_replace(" ","",$users))->send( new POReport ($data));
	        $log = new Log([
                "user_id" => Auth::user()->user_id,
                "activities" => 'Sent PO Report to '. $client_name,
            ]);
            return redirect()->route('po.reports')->with("success", "Report Sent to $client_name Successfully");
        }catch(\Exception $e){
            return redirect()->back()->with("error", "Email not sent, ". $e->getMessage());
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
        if (Auth::user()->hasRole('Employer')){

            $this->validate($request, [
                'client_id' => ['required', 'string', 'max:199'],
                'company_id' => ['required', 'string', 'max:199'],
                'status' => ['required', 'string', 'max:200'],
                'employee_id' => ['required', 'string', 'max:199'],
                'product' => ['required', 'string', 'max:199'],
                'contact_id' => ['required', 'string', 'max:199'],
                'rfq_number' => ['required', 'string', 'max:199'],
                'delivery_due_date' => ['required', 'string', 'max:199'],
                'po_date' => ['string', 'max:199'],
                'po_number' => ['string', 'max:200'],
                'total_po_usd' =>['required', 'string', 'max:199'],
                'total_po_ngn' =>['required', 'string', 'max:199'],
                'description' =>['required', 'string', 'max:199'],
                'payment_terms' => ['required', 'string', 'max:199'],
                'contact_id' => ['required', 'string', 'max:199'],
                'delivery_location' => ['required', 'string', 'max:199'],
                'delivery_terms' => ['required', 'string', 'max:199'],
                'frieght_charges' => ['required', 'string', 'max:199'],
                'local_delivery' => ['required', 'string', 'max:199'],
                'fund_transfer' => ['required', 'string', 'max:199'],
                'cost_of_funds' => ['required', 'string', 'max:199'],
                'wht' => ['required', 'string', 'max:199'],
                'ncd' => ['required', 'string', 'max:199'],
                'other_cost' => ['required', 'string', 'max:199'],
                'total_weight' =>['required', 'string', 'max:199'],
                'shipper_id' => ['required', 'string', 'max:199'],
                'note' => ['required', 'string', 'max:199'],
            ]);

            $data = new ClientPo([
                "client_id" => $request->input("client_id"),
                "company_id" => $request->input("company_id"),
                "rfq_id" => $request->input("rfq_id"),
                "rfq_number" => $request->input("rfq_number"),
                "status" => $request->input("status"),
                // "po_number" => $request->input("po_number"),
                "description" => $request->input("description"),
                "po_date" => $request->input("po_date"),
                "po_number" => $request->input("po_number"),
                "delivery_due_date" => $request->input("delivery_due_date"),
                "delivery_location" => $request->input("delivery_location"),
                "delivery_terms" => $request->input("delivery_terms"),
                "contact_id" => $request->input("contact_id"),
                "po_value_foreign" => $request->input("total_po_usd"),
                "po_value_naira" => $request->input("total_po_ngn"),
                "payment_terms" => $request->input("payment_terms"),
                "employee_id" => $request->input("employee_id"),
                "note" => $request->input("note"),


                "po_receipt_date" => 'Null',
                "est_production_time" => 'Null',
                "est_ddp_lead_time" => 'Null',
                "est_delivery_date" => 'Null',
                "supplier_proforma_foreign" => 'Null',
                "supplier_proforma_naira" => 'Null',
                "shipping_cost" => 'Null',
                "po_issued_to_supplier" => 'Null',
                "payment_details_received" => 'Null',
                "payment_made" => 'Null',
                "payment_confirmed" => 'Null',
                "work_order" => 'Null',
                "shipment_initiated" => 'Null',
                "shipment_arrived" => 'Null',
                "docs_to_shipper" => 'Null',
                "delivered_to_customer" => 'Null',
                "delivery_note_submitted" => 'Null',
                "customer_paid" => 'Null',
                "payment_due" => 'Null',
                "status_2" => 'Null',

            ]);
            // dd($data);
            $log = new Log([
                "user_id" => Auth::user()->user_id,
                "activities" => 'Added PO for RFQ  ' . $request->input('refrence_number'),
            ]);

            $deed = ClientRfq::where('rfq_id', $request->input("rfq_id"))->first();

            $datu = ClientRfq::where('rfq_id', $deed->rfq_id)->update([
                "employee_id" => $request->input("employee_id"),
                "freight_charges" => $request->input("frieght_charges"),
                "local_delivery" => $request->input("local_delivery"),
                "fund_transfer" => $request->input("fund_transfer"),
                "cost_of_funds" => $request->input("cost_of_funds"),
                "wht" => $request->input("wht"),
                "ncd" => $request->input("ncd"),
                "other_cost" => $request->input("other_cost"),
                "total_weight" => $request->input("total_weight"),

            ]);
            // dd($datu);

            if($data->save() AND (!empty($datu))){
                $po_id = $data->po_id;
                if($request->hasFile('document')) {
                     $file = $request->document;
                    foreach ($file as $files) {
                         $filenameWithExt = $files->getClientOriginalName();
                         $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                         $extension = $files->getClientOriginalExtension();
                         $fileNameToStore = $filename.'_'.time().'.'.$extension;
                        //  if (!file_exists('document/po/'.$po_id.'/')) {
                        //      $dir = mkdir('document/po/'.$po_id.'/');
                        //  }else{
                        //      $dir = 'document/po/'.$po_id.'/';
                        //  }
                        $dir = base_path("document/po/".$po_id."/");
                        !file_exists(File::makeDirectory($dir, $mode = 0777, true, true));
                        $path=$files->move(('document/po/'.$po_id.'/'), $fileNameToStore);
                    }
                    $log->save();
                 }
                return redirect()->route("po.index")->with("success", 'You have Updated PO for RFQ  ' . $request->input('refrence_number'). " Successfully");
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
    public function show($po_id)
    {
        if(ClientPo::where('po_id', $po_id)->exists()){
            $details = $this->model->show($po_id);

            return view('dashboard.po.details')->with([
                'details' => $details
            ]);
        }else{
            return redirect()->route('po.index')->with([
            'error' => "$po_id does not Exist for any PO",
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($po_id)
    {
        if(ClientPo::where('po_id', $po_id)->exists()){
            if (Auth::user()->hasRole('Employer') OR(Auth::user()->hasRole('HOD')) OR (Auth::user()->hasRole('Admin'))  OR (Gate::allows('SuperAdmin', auth()->user()))){
                $details = $this->model->show($po_id);

                $rfq = ClientRfq::where('rfq_id', $details->rfq_id)->first();
                $status = ScmStatus::where('type', 'PO')->orderBy('name', 'asc')->get();

                $client_id = $rfq->client_id;
                $company_id = $rfq->company_id;
                $company = Companies::where('company_id',$company_id)->get();
                $employer = Employers::where('company_id', $company_id)->orderBy('full_name', 'asc')->get();
                $client = ClientContact::where('client_id', $client_id)->orderBy('first_name', 'asc')->get();
                $shipper = Shippers::where('company_id', $company_id)->orderBy('shipper_name', 'asc')->get();
                $sup = Vendors::where('vendor_id', $rfq->vendor_id)->get();

                $line_items = LineItem::where('rfq_id', $details->rfq_id)->get();
                $tq = 0;
                foreach($line_items as $line){
                    $tq = ($line->quantity * $line->unit_cost) + $tq;
                }
                
                return view('dashboard.po.edit')->with([
                    'employer' => $employer, "rfq" => $rfq, "company" => $company, "client" => $client, "shipper" => $shipper, "details" => $details,
                    "status" => $status, 'sup' => $sup, 'tq' => $tq
                ]);
            } else {
                return redirect()->back()->with([
                    'error' => "You Dont have Access To This Page",
                ]);
            }
        }else{
            return redirect()->back()->with([
            'error' => "$po_id does not Exist for any PO",
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
    public function update(Request $request, $po_id)
    {
        if (Auth::user()->hasRole('Employer') OR(Auth::user()->hasRole('HOD')) OR (Auth::user()->hasRole('Admin'))  OR (Gate::allows('SuperAdmin', auth()->user()))){
            $details = $this->model->show($po_id);
            $this->validate($request, [
                'client_id' => ['required', 'string', 'max:199'],
                'company_id' => ['required', 'string', 'max:199'],
                'status' => ['required', 'string', 'max:200'],
                'employee_id' => ['required', 'string', 'max:199'],
                'product' => ['required', 'string', 'max:199'],
                'contact_id' => ['required', 'string', 'max:199'],
                'rfq_number' => ['required', 'string', 'max:199'],
                'delivery_due_date' => ['required', 'string', 'max:199'],
                'po_date' => ['string', 'max:199'],
                'po_number' => ['string', 'max:200', 'required'],
                'total_po_usd' =>['required', 'string', 'max:199'],
                'total_po_ngn' =>['required', 'string', 'max:199'],
                'description' =>['required', 'string', 'max:199'],
                'payment_terms' => ['required', 'string', 'max:199'],
                'contact_id' => ['required', 'string', 'max:199'],
                'delivery_location' => ['required', 'string', 'max:199'],
                'delivery_terms' => ['required', 'string', 'max:199'],
                'frieght_charges' => ['required', 'string', 'max:199'],
                'local_delivery' => ['required', 'string', 'max:199'],
                'fund_transfer' => ['required', 'string', 'max:199'],
                'cost_of_funds' => ['required', 'string', 'max:199'],
                'wht' => ['required', 'string', 'max:199'],
                'ncd' => ['required', 'string', 'max:199'],
                'other_cost' => ['required', 'string', 'max:199'],
                'total_packaged_weight' =>['required', 'string', 'max:199'],
                'hs_codes' => ['required'],
                'delivery' => ['required'],
                'shipper_id' => ['required', 'string', 'max:199'],
                'note' => ['required', 'string',],
                'rfq_note' => ['required', 'string',],
                'supplier_ref_number' =>['required', 'string'],
                'currency' => ['required', 'string',],
                'timely_delivery' => ['required', 'string', 'max:199'],
                'schedule' => ['required', 'string', 'max:199'],

            ]);
            

            $data = ([
                "po" => $this->model->show($po_id),
                "client_id" => $request->input("client_id"),
                "company_id" => $request->input("company_id"),
                "rfq_id" => $request->input("rfq_id"),
                "rfq_number" => $request->input("rfq_number"),
                "status" => $request->input("status"),
                "po_number" => $request->input("po_number"),
                "description" => $request->input("description"),
                "po_date" => $request->input("po_date"),
                "po_number" => $request->input("po_number"),
                "delivery_due_date" => $request->input("delivery_due_date"),
                "delivery_location" => $request->input("delivery_location"),
                "delivery_terms" => $request->input("delivery_terms"),
                "contact_id" => $request->input("contact_id"),
                "po_value_foreign" => $request->input("total_po_usd"),
                "po_value_naira" => $request->input("total_po_ngn"),
                "payment_terms" => $request->input("payment_terms"),
                "employee_id" => $request->input("employee_id"),
                "note" => $request->input("note"),

                "po_receipt_date" => $details->po_receipt_date,
                "est_production_time" => $details->est_production_time,
                "est_ddp_lead_time" => $details->est_ddp_lead_time,
                "est_delivery_date" => $details->est_delivery_date,
                "supplier_proforma_foreign" => $details->supplier_proforma_foreign,
                "supplier_proforma_naira" => $details->supplier_proforma_naira,
                "shipping_cost" => $details->shipping_cost,
                "po_issued_to_supplier" => $details->po_issued_to_supplier,
                "payment_details_received" => $details->payment_details_received,
                "payment_made" => $details->payment_made,
                "payment_confirmed" => $details->payment_confirmed,
                "work_order" => $details->work_order,
                "shipment_initiated" => $details->shipment_initiated,
                "shipment_arrived" => $details->shipment_arrived,
                "docs_to_shipper" => $details->docs_to_shipper,
                "delivered_to_customer" => $details->delivered_to_customer,
                "delivery_note_submitted" => $details->delivery_note_submitted,
                "customer_paid" => $details->customer_paid,
                "payment_due" => $details->payment_due,
                "status_2" => $details->status_2,
                "employee_id" => $details->employee_id,
                "contact_id" => $details->contact_id,

                'ex_works_date' => $request->input("ex_works_date"), 'transport_mode' => $request->input("transport_mode"),
                'shipping_reliability' => $details->shipping_reliability,
                'shipping_on_time_delivery' => $details->shipping_on_time_delivery,
                'shipping_pricing' => $details->shipping_pricing, 'shipping_communication' => $details->shipping_communication,
                'shipping_comment' => $details->shipping_comment, 'shipping_rater' => Auth::user()->first_name . ' '. Auth::user()->last_name,
                'shipping_overall_rating' => $details->shipping_overall_rating,
                'survey_sent' => 0, 'survey_sent_date' => $details->survey_sent_date,
                'survey_completed' => 0,'survey_completion_date' => $details->survey_completion_date, 
                'tag_comment' => $request->input("tag_comment"),
                'supplier_ref_number' =>  $request->input("supplier_ref_number"),
                'actual_delivery_date'  => $request->input("actual_delivery_date"), 
                'timely_delivery' =>  $request->input("timely_delivery"),

                "shipper_id" => $request->input("shipper_id"),

                
                'delivery' => $request->input("delivery"), 'technical_notes' => $request->input("technical_note"), 
                'hs_codes'=> $request->input("hs_codes"), 'total_packaged_weight' => $request->input("total_packaged_weight"),
                'estimated_packaged_dimensions' => $request->input("estimated_packaged_dimensions"),

                'delivery_location_po' => $request->input("delivery_location_po"),
                'hs_codes_po' => $request->input("hs_codes_po"), 
                'port_of_discharge' =>  $request->input("port_of_discharge"), 
                'payment_terms_client' => $request->input("payment_terms_client"),
                'freight_charges_suplier' => $request->input("freight_charges_suplier"),
                'schedule' => $request->input("schedule"),

            ]);

            // dd($data);
            $log = new Log([
                "user_id" => Auth::user()->user_id,
                "activities" => "Updated PO ID ". $details->po_number ." for RFQ  ". $request->input('refrence_number'),
            ]);
            $deed = ClientRfq::where('rfq_id', $request->input("rfq_id"))->first();
    
            $datu = ClientRfq::where('rfq_id', $deed->rfq_id)->update([
                "employee_id" => $request->input("employee_id"),
                "freight_charges" => $request->input("frieght_charges"),
                "local_delivery" => $request->input("local_delivery"),
                "fund_transfer" => $request->input("fund_transfer"),
                "cost_of_funds" => $request->input("cost_of_funds"),
                "wht" => $request->input("wht"),
                "ncd" => $request->input("ncd"),
                "other_cost" => $request->input("other_cost"),
                "note" => $request->input("rfq_note"),
                "description" => $request->input("description"),
                "supplier_quote_usd" => $request->input("supplier_quote"),
                "transport_mode" => $request->input("transport_mode"),
                // "total_weight" => $request->input("total_weight"),
                "contact_id" => $request->input("contact_id"),
                "shipper_id" => $request->input("shipper_id"),
                "currency" => $request->input("currency"),
                'freight_cost_option' => $request->input("freight_cost_option"),
                // 'freight_cost_option' => $request->input("freight_cost_option"),

            ]);
            if ($this->model->update($data, $po_id) and ($log->save()) AND (!empty($datu))) {

                if(!empty($request->input("shipping_reliability"))){

                    ClientPo::where('po_id', $po_id)->update([
                        'shipping_reliability' => $request->input("shipping_reliability"),
                        'shipping_on_time_delivery' => $request->input("shipping_on_time_delivery"),
                        'shipping_pricing' => $request->input("shipping_pricing"),
                        'shipping_communication' => $request->input("shipping_communication"),
                        'shipping_comment' => $request->input("shipping_comment"),
                        'shipping_rater' => Auth::user()->first_name . ' '. Auth::user()->last_name,
                        'shipping_overall_rating' =>  (intval($request->input("shipping_reliability"))) + (intval($request->input("shipping_on_time_delivery"))) + (intval($request->input("shipping_pricing"))) + (intval($request->input("shipping_communication"))),
                    ]);
                }
                if($request->hasFile('document')) {
                     $file = $request->document;
                    foreach ($file as $files) {
                         $filenameWithExt = $files->getClientOriginalName();
                         $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                         $extension = $files->getClientOriginalExtension();
                         $fileNameToStore = $filename.'_'.time().'.'.$extension;
                         if (!file_exists('document/po/'.$po_id.'/')) {
                             $dir = mkdir('document/po/'.$po_id.'/');
                         }else{
                             $dir = 'document/po/'.$po_id.'/';
                         }

                         $path=$files->move(('document/po/'.$po_id.'/'), $fileNameToStore);
                    }

                }
                $oldNote = $request->input('note');
                
            if($request->input("status") == $details->status){
                $newNote = $request->input('note');
            }else{
                $newNote = date('d/m/Y') .' ' . Auth::user()->first_name . ' '. Auth::user()->last_name .' Changed the PO Status to '. $request->input('status') . '. <br>'.$oldNote;
            }
                
                DB::table('client_pos')->where(['po_id' => $po_id])->update(['note' => $newNote]);
                $po =  $this->model->show($po_id);
                $contact_id =$request->input("contact_id");
                $conct = DB::table('client_contacts')->where(["contact_id" => $contact_id])->first();
                $emp = DB::table('employers')->where(["employee_id" => $po->employee_id])->first();
                $vendor = DB::table('vendors')->where(["vendor_id" => $deed->vendor_id])->first();
                $rfq = ClientRfq::where('rfq_id', $request->input("rfq_id"))->first();
                $sup = DB::table('vendors')->where(["vendor_id" => $deed->vendor_id])->get();
                $data = ["po" => $po, 'emp' => $emp, 'vendor' => $vendor, 'rfq' => $deed, 'conct' => $conct];
                $line_items = LineItem::where(['rfq_id' => $deed->rfq_id])->orderBy('created_at','asc')->get();
                if(count($line_items) > 0){
                    
                    // $pdf = PDF::loadView('dashboard.printing.supplier_quote', compact('rfq', 'line_items', 'sup', 'po'))->setPaper('ledger', 'portrait');
                    $customPaper = array(0,0,7200,14400);
                    
                    $tq = 0;
                    foreach($line_items as $line){
                        $tq = ($line->quantity * $line->unit_cost) + $tq;
                    }
                    $pdf = PDF::loadView('dashboard.printing.supplier_quote', compact('rfq', 'line_items', 'sup', 'po', 'tq'))->setPaper('ledger', 'portrait');
                    $name = cops($deed->company_id);
                    $fileName = "Purchase Order " .$deed->refrence_no . ", ". $deed->product.'.pdf';
                    $pdf->getDomPDF()->set_option("enable_php", true);
                    $output = $pdf->output();
                    
                    $dir = base_path("email/po/".$deed->refrence_no."/");
                    !file_exists(File::makeDirectory($dir, $mode = 0777, true, true));
                    $pdf->save($dir.$fileName);
                    
                }
                if($request->input('status') == 'PO Acknowledged'){
                    try{
                        Mail::to('contact@tagenergygroup.net')->cc(['sales@tagenergygroup.net','mary.nwaogwugwu@tagenergygroup.net'])->send( new POAcknowledge ($data));
                        return redirect()->route("po.details",[$details->po_id])->with("success", "You have Updated PO Successfully");
                    }catch(PDOException $e){
                        return redirect()->route("po.details",[$details->po_id])->with("success", "You have Updated PO Successfully. Mail could not be sent because ". $e->getMessage());
                    }

                }else{
                    return redirect()->back()->with("success", "You have Updated PO Successfully");
                }

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
    public function destroy($id)
    {
        //
    }

    public function removeFile($po_id, $filename){
        if(!empty(unlink('document/po/'.$po_id.'/'.$filename))){
             return redirect()->back()->with(['success' => "File Deleted Successfully "]);
        }else{
             return redirect()->back()->with(['error' => "Unable to delete file at the moment, Please try again later"  ]);
        }

     }

     public function removeAllFile($po_id){

        if (file_exists('document/po/'.$po_id.'/')){
            $files = glob('document/po/'.$po_id.'/*');
            foreach($files as $file){
                if(!empty(unlink($file))){

                }
            }
            return redirect()->back()->with(['success' => "All Files Deleted Successfully "]);
        }else{
            return redirect()->back()->with(['error' => "Unable to delete all the files at the moment, Please try again later"  ]);
        }

     }
}
