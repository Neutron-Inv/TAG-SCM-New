<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\{Companies, User,Log,ClientRfq, ClientPo, Clients, Shippers, ShipperQuote, LineItem, Employers, Product};
use Illuminate\Support\Facades\Auth;
use DB; 
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Gate;
use App\Mail\{POYearReport};
use App\Mail\{RfqPoMonthlyReport};
use App\Mail\{SaipemReport};
use App\Mail\{BHAReport};
use App\Mail\{WeeklyReport};
use App\Mail\{RfqReport};
use App\Mail\{CustomReport};
use App\Mail\{ClientPoReport};
use App\Mail\{OutstandingReport};
use Storage;
use Illuminate\Http\UploadedFile;
class ReportController extends Controller
{
    protected $model;
    public function createReport()
    {
        $po = ClientPo::whereIn('status', ['Delivered', 'Partial Delivery', 'Awaiting GRN', 'Invoicing', 'Invoiced', 'Paid'])->whereYear('actual_delivery_date',date('Y'))->orderBy('created_at','desc')->get();
        $shipper = ClientPo::select('shipper_id')->whereYear('actual_delivery_date',date('Y'))->groupBy('shipper_id')->get();
        return view('dashboard.reports.index')->with([
            'po' => $po, 'shipper' => $shipper
        ]);
    }
    
     public function outstanding()
    {
        if (Gate::allows('SuperAdmin', auth()->user())) {
            
        $rfqs = ClientRfq::whereNotIn('status', ['Quotation Submitted', 'PO Issued', 'Bid Closed', 'No Bid', 'Technical Bid Submitted'])
        ->orderBy('rfq_date', 'desc')->get();
        return view('dashboard.reports.outstanding')->with([
            'rfqs' => $rfqs
        ]);
        
        }else{
            $employee = Employers::where('email', Auth::user()->email)->first();
            $company_id = $employee->company_id;
            
            $rfqs = ClientRfq::whereNotIn('status', ['Quotation Submitted', 'PO Issued', 'Bid Closed', 'No Bid', 'Technical Bid Submitted'])
        ->orderBy('rfq_date', 'desc')
        ->where('company_id',$company_id)->get();
        return view('dashboard.reports.outstanding')->with([
            'rfqs' => $rfqs
        ]);
        }
    }
    
    public function sendOutstandingReport(Request $request)
    {
        
         if (Gate::allows('SuperAdmin', auth()->user())) {
        $rfqs = ClientRfq::whereNotIn('status', ['Quotation Submitted', 'PO Issued', 'Bid Closed', 'No Bid', 'Technical Bid Submitted'])
        ->orderBy('rfq_date', 'desc')->get();

         $rec_mail = $request->input("rec_email");
         $report_recipient = $request->input("report_recipient");

         $cut = explode("; ", $report_recipient);
         $users = [];
         foreach($cut as $key => $ut){
             $ua = [];
             $ua['email'] = $ut;
             $split = $cut = explode("@", $ut);
             $ua['name'] = strtoupper(str_replace(".","",$split[0]));
             $users[$key] = (object)$ua;
         }
        try{
            $data = ["rfqs" => $rfqs];
            $when = now()->addMinutes(1);
            Mail::to($rec_mail)->cc(str_replace(" ","",$users))->send( new OutstandingReport ($data));    
            return redirect()->back()->with([
                'rfqs' => $rfqs,
                'success' => 'Email Sent Successfully'
            ]);
        }catch(\Exception $e){
            return redirect()->back()->with("error", "Email not sent, ". $e->getMessage());
        }
         }else{
             
            $employee = Employers::where('email', Auth::user()->email)->first();
            $company_id = $employee->company_id;
            
            $rfqs = ClientRfq::whereNotIn('status', ['Quotation Submitted', 'PO Issued', 'Bid Closed', 'No Bid', 'Technical Bid Submitted'])
        ->orderBy('rfq_date', 'desc')
        ->where('company_id',$company_id)->get();

         $rec_mail = $request->input("rec_email");
         $report_recipient = $request->input("report_recipient");

         $cut = explode("; ", $report_recipient);
         $users = [];
         foreach($cut as $key => $ut){
             $ua = [];
             $ua['email'] = $ut;
             $split = $cut = explode("@", $ut);
             $ua['name'] = strtoupper(str_replace(".","",$split[0]));
             $users[$key] = (object)$ua;
         }
        try{
            $data = ["rfqs" => $rfqs];
            $when = now()->addMinutes(1);
            Mail::to($rec_mail)->cc(str_replace(" ","",$users))->send( new OutstandingReport ($data));    
            return redirect()->back()->with([
                'rfqs' => $rfqs,
                'success' => 'Email Sent Successfully'
            ]);
        }catch(\Exception $e){
            return redirect()->back()->with("error", "Email not sent, ". $e->getMessage());
        }
         }
    }

    public function weekly()
    {
        if (Gate::allows('SuperAdmin', auth()->user())) {
        // Calculate the dates for the current week's Monday and Friday
        $currentWeekMonday = now()->startOfWeek(); // Monday of the current week
        $currentWeekFriday = now()->startOfWeek()->addDays(4); // Friday of the current week
        $product = Product::get();
        $currentWeekMonday = Carbon::now()->startOfWeek()->format('Y-m-d H:i:s');
        $currentWeekFriday = Carbon::now()->endOfWeek()->format('Y-m-d H:i:s');
       
        $po = ClientPo::whereBetween('po_date', [$currentWeekMonday, $currentWeekFriday])
        ->where('status', '!=', 'PO Cancelled')
        ->select('client_id', \DB::raw('count(*) as count'))
        ->groupBy('client_id')
        ->get();

        $pototal = ClientPo::whereBetween('po_date', [$currentWeekMonday, $currentWeekFriday])
        ->where('status', '!=', 'PO Cancelled')
        ->count();

        $rfq = ClientRfq::whereBetween('rfq_date', [$currentWeekMonday, $currentWeekFriday])
        ->select('client_id', \DB::raw('count(*) as count'))
        ->groupBy('client_id')
        ->get();

        $grn = ClientPo::where('status', 'Awaiting GRN')
        ->get();

        $rfqtotal = ClientRfq::whereBetween('rfq_date', [$currentWeekMonday, $currentWeekFriday])->count();

        $nlng = ClientPo::where('client_id', '114')
        ->whereYear('po_date', now()->year)
        ->orderBy('po_number', 'asc')
        ->get();

        return view('dashboard.reports.weekly')->with([
            'po' => $po, 
            'rfq' => $rfq, 
            'rfqtotal' => $rfqtotal,
            'pototal' => $pototal,
            'nlng' => $nlng,
            'grn' => $grn,
            'start_date' => $currentWeekMonday,
            'end_date' => $currentWeekFriday,
            'product'=> $product
        ]);
    }else{
        $employee = Employers::where('email', Auth::user()->email)->first();
        $company_id = $employee->company_id;
        $product = Product::where('company_id', $employee->company_id)->get();
        // Calculate the dates for the current week's Monday and Friday
        $currentWeekMonday = now()->startOfWeek(); // Monday of the current week
        $currentWeekFriday = now()->startOfWeek()->addDays(4); // Friday of the current week
        
        $currentWeekMonday = Carbon::now()->startOfWeek()->format('Y-m-d H:i:s');
        $currentWeekFriday = Carbon::now()->endOfWeek()->format('Y-m-d H:i:s');
       
        $po = ClientPo::whereBetween('po_date', [$currentWeekMonday, $currentWeekFriday])
        ->select('client_id', \DB::raw('count(*) as count'))
        ->where('company_id', $company_id)
        ->where('status', '!=', 'PO Cancelled')
        ->groupBy('client_id')
        ->get();

        $pototal = ClientPo::whereBetween('po_date', [$currentWeekMonday, $currentWeekFriday])
        ->where('company_id', $company_id)
        ->where('status', '!=', 'PO Cancelled')
        ->count();

        $rfq = ClientRfq::whereBetween('rfq_date', [$currentWeekMonday, $currentWeekFriday])
        ->select('client_id', \DB::raw('count(*) as count'))
        ->where('company_id', $company_id)
        ->groupBy('client_id')
        ->get();

        $grn = ClientPo::where('status', 'Awaiting GRN')
        ->where('company_id', $company_id)
        ->get();

        $rfqtotal = ClientRfq::whereBetween('rfq_date', [$currentWeekMonday, $currentWeekFriday])->where('company_id', $company_id)->count();

        $nlng = ClientPo::where('client_id', '114')
        ->whereYear('po_date', now()->year)
        ->orderBy('po_number', 'asc')
        ->get();

        return view('dashboard.reports.weekly')->with([
            'po' => $po, 
            'rfq' => $rfq, 
            'rfqtotal' => $rfqtotal,
            'pototal' => $pototal,
            'nlng' => $nlng,
            'grn' => $grn,
            'start_date' => $currentWeekMonday,
            'end_date' => $currentWeekFriday,
            'product'=> $product
        ]);
    }
    }


    public function weeklyedit(Request $request)
    {
        if (Gate::allows('SuperAdmin', auth()->user())) {
        // Calculate the dates for the current week's Monday and Friday
        $currentWeekMonday = $request->input('start_date'); // Monday of the current week
        $currentWeekFriday = $request->input('end_date'); // Friday of the current week
        
        $currentWeekMonday = $request->input('start_date');
        $currentWeekFriday = $request->input('end_date');
       
        $po = ClientPo::whereBetween('po_date', [$currentWeekMonday, $currentWeekFriday])
        ->select('client_id', \DB::raw('count(*) as count'))
        ->where('status', '!=', 'PO Cancelled')
        ->groupBy('client_id')
        ->get();

        $pototal = ClientPo::whereBetween('po_date', [$currentWeekMonday, $currentWeekFriday])
        ->where('status', '!=', 'PO Cancelled')
        ->count();

        $rfq = ClientRfq::whereBetween('rfq_date', [$currentWeekMonday, $currentWeekFriday])
        ->select('client_id', \DB::raw('count(*) as count'))
        ->groupBy('client_id')
        ->get();

        $grn = ClientPo::where('status', 'Awaiting GRN')
        ->get();

        $rfqtotal = ClientRfq::whereBetween('rfq_date', [$currentWeekMonday, $currentWeekFriday])->count();

        $nlng = ClientPo::where('client_id', '114')
        ->whereYear('po_date', now()->year)
        ->orderBy('po_number', 'asc')
        ->get();

        return view('dashboard.reports.weekly')->with([
            'po' => $po, 
            'rfq' => $rfq, 
            'rfqtotal' => $rfqtotal,
            'pototal' => $pototal,
            'nlng' => $nlng,
            'grn' => $grn,
            'start_date' => $currentWeekMonday,
            'end_date' => $currentWeekFriday
        ]);
    }else{
        $employee = Employers::where('email', Auth::user()->email)->first();
        $company_id = $employee->company_id;
        // Calculate the dates for the current week's Monday and Friday
        $currentWeekMonday = $request->input('start_date'); // Monday of the current week
        $currentWeekFriday = $request->input('end_date'); // Friday of the current week
        
        $currentWeekMonday = $request->input('start_date');
        $currentWeekFriday = $request->input('end_date');
       
        $po = ClientPo::whereBetween('po_date', [$currentWeekMonday, $currentWeekFriday])
        ->select('client_id', \DB::raw('count(*) as count'))
        ->where('company_id', $company_id)
        ->where('status', '!=', 'PO Cancelled')
        ->groupBy('client_id')
        ->get();

        $pototal = ClientPo::whereBetween('po_date', [$currentWeekMonday, $currentWeekFriday])
        ->where('company_id', $company_id)
        ->where('status', '!=', 'PO Cancelled')
        ->count();

        $rfq = ClientRfq::whereBetween('rfq_date', [$currentWeekMonday, $currentWeekFriday])
        ->select('client_id', \DB::raw('count(*) as count'))
        ->where('company_id', $company_id)
        ->groupBy('client_id')
        ->get();

        $grn = ClientPo::where('status', 'Awaiting GRN')
        ->where('company_id', $company_id)
        ->get();

        $rfqtotal = ClientRfq::whereBetween('rfq_date', [$currentWeekMonday, $currentWeekFriday])->where('company_id', $company_id)->count();

        $nlng = ClientPo::where('client_id', '114')
        ->whereYear('po_date', now()->year)
        ->orderBy('po_number', 'asc')
        ->get();

        return view('dashboard.reports.weekly')->with([
            'po' => $po, 
            'rfq' => $rfq, 
            'rfqtotal' => $rfqtotal,
            'pototal' => $pototal,
            'nlng' => $nlng,
            'grn' => $grn,
            'start_date' => $currentWeekMonday,
            'end_date' => $currentWeekFriday
        ]);
    }
    }
    
    
    public function clientPo()
    {
        $clients = Clients::get();
        $client = null;
        $client_id = null;

        return view('dashboard.reports.clientPo')->with([
            'clients' => $clients,
            'client_id' => $client_id,
            'client' => $client
        ]);
    }

public function ClientPoEdit(Request $request)
{
    $this->validate($request, [
        'client' => ['required']
    ]);
    $client_id = $request->input('client');

    $clients = Clients::get();
    $clients_det = Clients::where('client_id', $client_id)
    ->first();
    $client = ClientPo::where('client_id', $client_id)
    ->whereNotIn('status', ['paid', 'invoicing', 'invoiced','declined', 'PO Cancelled' ])
    ->orderBy('created_at', 'desc')
    ->get();

    return view('dashboard.reports.clientPo')->with([
        'clients' => $clients,
        'client' => $client,
        'client_id' => $client_id,
        'clients_det' => $clients_det
    ]);
    }

    public function sendClientPoReport(Request $request)
    {
    // Extract all the required variables from the request
    $this->validate($request, [
        'client' => ['required']
    ]);
    $client_id = $request->input('client');

    $clients = Clients::get();
    $clients_det = Clients::where('client_id', $client_id)
    ->first();
    $client = ClientPo::where('client_id', $client_id)
    ->whereNotIn('status', ['paid', 'invoicing', 'invoiced','declined', 'PO Cancelled' ])
    ->orderBy('created_at', 'desc')
    ->get();

    // Now you have all the required variables, proceed to sending the email
    $rec_mail = $request->input("rec_email");
    $report_recipient = $request->input("report_recipient");
    $cut = explode("; ", $report_recipient);
    $users = [];
    foreach ($cut as $key => $ut) {
        $ua = [];
        $ua['email'] = $ut;
        $split = explode("@", $ut);
        $ua['name'] = strtoupper(str_replace(".", "", $split[0]));
        $users[$key] = (object)$ua;
    }

    try {
        $data = [
            "clients" => $clients,
            "client" => $client,
            "client_id" => $client_id,
            "clients_det" => $clients_det
        ];

        // Send email using the data
        $when = now()->addMinutes(1);
        Mail::to($rec_mail)->cc(str_replace(" ", "", $users))->send(new ClientPoReport($data));

        return redirect()->back()->with([
            'success' => 'Email Sent Successfully'
        ]);
    } catch (\Exception $e) {
        return redirect()->back()->with("error", "Email not sent, " . $e->getMessage());
    }
    }

    public function custom()
    {
        // Calculate the dates for the current week's Monday and Friday
        $start_date = now()->startOfWeek(); // Monday of the current week
        $end_date = now()->startOfWeek()->addDays(4); // Friday of the current week
       
        $po = ClientPo::whereBetween('po_date', [$start_date, $end_date])
        ->select('client_id', \DB::raw('count(*) as count'))
        ->groupBy('client_id')
        ->get();

        $pototal = ClientPo::whereBetween('po_date', [$start_date, $end_date])
        ->count();

        $rfq = ClientRfq::whereBetween('rfq_date', [$start_date, $end_date])
        ->select('client_id', \DB::raw('count(*) as count'))
        ->groupBy('client_id')
        ->get();

        $client = "";

        $clients = Clients::get();

        $grn = ClientPo::where('status', 'Awaiting GRN')
        ->get();

        $rfqtotal = ClientRfq::whereBetween('rfq_date', [$start_date, $end_date])->count();

        $nlng = ClientPo::where('client_id', '114')
        ->whereYear('po_date', now()->year)
        ->orderBy('po_number', 'asc')
        ->get();

        return view('dashboard.reports.custom')->with([
            'po' => $po, 
            'rfq' => $rfq, 
            'rfqtotal' => $rfqtotal,
            'pototal' => $pototal,
            'nlng' => $nlng,
            'grn' => $grn,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'clients' => $clients,
            'client' => $client
        ]);
    }

    public function customedit(Request $request)
    {
        $this->validate($request, [
            'start_date' => ['required'],
            'end_date' => ['required'],
            'client' => ['required']
        ]);

        // Calculate the dates for the current week's Monday and Friday
        $start_datex = $request->input('start_date');
        $start_date = \Carbon\Carbon::parse($start_datex); // Monday of the current week
        $end_datex = $request->input('end_date'); // Friday of the current week
        $end_date = \Carbon\Carbon::parse($end_datex); // Friday of the current week
        $clientx = $request->input('client');

        $po = ClientPo::whereBetween('po_date', [$start_date, $end_date])
        ->select('client_id', \DB::raw('count(*) as count'))
        ->groupBy('client_id')
        ->where('client_id', $clientx)
        ->get();

        $pototal = ClientPo::whereBetween('po_date', [$start_date, $end_date])
        ->where('client_id', $clientx)
        ->count();

        $rfq = ClientRfq::whereBetween('rfq_date', [$start_date, $end_date])
        ->where('client_id', $clientx)
        ->select('client_id', \DB::raw('count(*) as count'))
        ->groupBy('client_id')
        ->get();

        $client = Clients::where('client_id', $clientx)
        ->first();

        $clients = Clients::get();

        $grn = ClientPo::where('status', 'Awaiting GRN')
        ->where('client_id', $clientx)
        ->get();

        $rfqtotal = ClientRfq::whereBetween('rfq_date', [$start_date, $end_date])
        ->where('client_id', $clientx)
        ->count();

        return redirect()->back()->with([
            'po' => $po, 
            'rfq' => $rfq, 
            'rfqtotal' => $rfqtotal,
            'pototal' => $pototal,
            'grn' => $grn,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'clients' => $clients,
            'client' => $clientx
        ]); 
    }

    public function sendCustomReport(Request $request)
    {
    // Extract all the required variables from the request
    $start_date = $request->input('start_date');
    $end_date = $request->input('end_date');
    $clientx = $request->input('client');

    $po = ClientPo::whereBetween('po_date', [$start_date, $end_date])
    ->select('client_id', \DB::raw('count(*) as count'))
    ->groupBy('client_id')
    ->where('client_id', $clientx)
    ->get();

    $pototal = ClientPo::whereBetween('po_date', [$start_date, $end_date])
    ->where('client_id', $clientx)
    ->count();

    $rfq = ClientRfq::whereBetween('rfq_date', [$start_date, $end_date])
    ->where('client_id', $clientx)
    ->select('client_id', \DB::raw('count(*) as count'))
    ->groupBy('client_id')
    ->get();

    $clients = Clients::get();

    $grn = ClientPo::where('status', 'Awaiting GRN')
    ->where('client_id', $clientx)
    ->get();

    $rfqtotal = ClientRfq::whereBetween('rfq_date', [$start_date, $end_date])
    ->where('client_id', $clientx)
    ->count();

    // Now you have all the required variables, proceed to sending the email
    $rec_mail = $request->input("rec_email");
    $report_recipient = $request->input("report_recipient");
    $cut = explode("; ", $report_recipient);
    $users = [];
    foreach ($cut as $key => $ut) {
        $ua = [];
        $ua['email'] = $ut;
        $split = explode("@", $ut);
        $ua['name'] = strtoupper(str_replace(".", "", $split[0]));
        $users[$key] = (object)$ua;
    }

    try {
        $data = [
            "po" => $po,
            "rfq" => $rfq,
            "rfqtotal" => $rfqtotal,
            "pototal" => $pototal,
            "grn" => $grn,
            "start_date" => $start_date,
            "end_date" => $end_date,
            "clients" => $clients,
            "client" => $clientx
        ];

        // Send email using the data
        $when = now()->addMinutes(1);
        Mail::to($rec_mail)->cc(str_replace(" ", "", $users))->send(new CustomReport($data));

        return redirect()->back()->with([
            'success' => 'Email Sent Successfully'
        ]);
    } catch (\Exception $e) {
        return redirect()->back()->with("error", "Email not sent, " . $e->getMessage());
    }
}

    public function monthly()
    {
        if (Gate::allows('SuperAdmin', auth()->user())) {
        // Calculate the dates for the current week's Monday and Friday
        $currentWeekMonday = now()->startOfWeek(); // Monday of the current week
        $currentWeekFriday = now()->startOfWeek()->addDays(4); // Friday of the current week
       
        $po = ClientPo::whereYear('po_date', now()->year )
        ->select('client_id', \DB::raw('count(*) as count'))
        ->groupBy('client_id')
        ->orderBy('count', 'desc')
        ->get();

        $pototal = ClientPo::whereYear('po_date', now()->year)
        ->count();

        $rfq = ClientRfq::whereYear('rfq_date', now()->year)
        ->select('client_id', \DB::raw('count(*) as count'))
        ->groupBy('client_id')
        ->orderBy('count', 'desc')
        ->get();
        
        $topclients = ClientRfq::whereYear('rfq_date', now()->year)
        ->select('client_id')
        ->selectRaw('count(*) as count')
        ->where('company_id', '2')
        ->groupBy('client_id')
        ->orderBy('count', 'desc')
        ->limit(5)
        ->pluck('client_id');
        
        //dd($topclients[0]);
        
        $product = Product::orderBy('product_name')->pluck('product_name');

        $rfqtotal = ClientRfq::whereyear('rfq_date', now()->year)->count();
        $saipem = ClientRfq::where('client_id', '266')
        ->whereyear('rfq_date', now()->year)
        ->get();
        
        $bha = ClientRfq::leftjoin('client_pos', 'client_rfqs.rfq_id', '=', 'client_pos.rfq_id')
        ->select(
            'client_rfqs.refrence_no as refrence_no',
            'client_rfqs.rfq_number as rfq_number',
            'client_rfqs.contact_id as contact_id',
            'client_rfqs.description as description',
            'client_rfqs.client_id as client_id',
            'client_rfqs.rfq_date as rfq_date',
            'client_pos.po_date as po_date',
            'client_rfqs.delivery_due_date as delivery_due_date',
            'client_rfqs.currency as currency',
            'client_rfqs.total_quote as total_quote',
            'client_rfqs.status as status',
            'client_pos.status as po_status',
            'client_pos.po_number as po_number',
            'client_pos.po_value_foreign as po_value_foreign'
            )
        ->where('client_rfqs.product', 'BHA')
        ->where(function($query){
            $query->whereyear('client_rfqs.rfq_date', now()->year)
                  ->orWhereYear('client_pos.po_date', now()->year);
        })
        ->get();

        $nlng = ClientPo::where('client_id', '114')
        ->whereYear('po_date', now()->year)
        ->orderBy('po_number', 'asc')
        ->get();

        return view('dashboard.reports.monthly')->with([
            'po' => $po, 
            'rfq' => $rfq, 
            'rfqtotal' => $rfqtotal,
            'pototal' => $pototal,
            'nlng' => $nlng,
            'saipem' => $saipem,
            'product'=> $product,
            'bha' => $bha,
            'topclients' => $topclients
        ]);
    }else{
        
        $employee = Employers::where('email', Auth::user()->email)->first();
        $company_id = $employee->company_id;
        
        $product = Product::where('company_id', $company_id)->orderBy('product_name')->pluck('product_name');
        
        // Calculate the dates for the current week's Monday and Friday
        $currentWeekMonday = now()->startOfWeek(); // Monday of the current week
        $currentWeekFriday = now()->startOfWeek()->addDays(4); // Friday of the current week
       
        $po = ClientPo::whereYear('po_date', now()->year )
        ->select('client_id', \DB::raw('count(*) as count'))
        ->where('company_id', $company_id)
        ->groupBy('client_id')
        ->orderBy('count', 'desc')
        ->get();

        $pototal = ClientPo::whereYear('po_date', now()->year)
        ->where('company_id', $company_id)
        ->count();

        $rfq = ClientRfq::whereYear('rfq_date', now()->year)
        ->select('client_id', \DB::raw('count(*) as count'))
        ->where('company_id', $company_id)
        ->groupBy('client_id')
        ->orderBy('count', 'desc')
        ->get();
        
        $topclients = ClientRfq::whereYear('rfq_date', now()->year)
        ->select('client_id')
        ->selectRaw('count(*) as count')
        ->where('company_id', $company_id)
        ->groupBy('client_id')
        ->orderBy('count', 'desc')
        ->limit(5)
        ->pluck('client_id');

        $rfqtotal = ClientRfq::whereyear('rfq_date', now()->year)->where('company_id', $company_id)->count();
        
        $saipem = ClientRfq::where('client_id', '266')
        ->where('company_id', $company_id)
        ->whereyear('rfq_date', now()->year)
        ->get();
        
        $bha = ClientRfq::leftjoin('client_pos', 'client_rfqs.rfq_id', '=', 'client_pos.rfq_id')
        ->select(
            'client_rfqs.refrence_no as refrence_no',
            'client_rfqs.rfq_number as rfq_number',
            'client_rfqs.contact_id as contact_id',
            'client_rfqs.description as description',
            'client_rfqs.client_id as client_id',
            'client_rfqs.rfq_date as rfq_date',
            'client_rfqs.delivery_due_date as delivery_due_date',
            'client_rfqs.currency as currency',
            'client_rfqs.total_quote as total_quote',
            'client_rfqs.status as status',
            'client_pos.status as po_status',
            'client_pos.po_number as po_number',
            'client_pos.po_value_foreign as po_value_foreign'
            )
        ->where('client_rfqs.company_id', $company_id)
        ->where('client_rfqs.product', 'BHA')
        ->where(function($query){
            $query->whereyear('client_rfqs.rfq_date', now()->year)
                  ->orWhereYear('client_pos.po_date', now()->year);
        })
        ->get();

        $nlng = ClientPo::where('client_id', '114')
        ->whereYear('po_date', now()->year)
        ->orderBy('po_number', 'asc')
        ->get();

        return view('dashboard.reports.monthly')->with([
            'po' => $po, 
            'rfq' => $rfq, 
            'rfqtotal' => $rfqtotal,
            'pototal' => $pototal,
            'nlng' => $nlng,
            'saipem' => $saipem,
            'product'=> $product,
            'bha' => $bha,
            'topclients' => $topclients
        ]);
    }
    }

    public function rfq(Request $request)
    {
        if ($request->has("reference_no")) {
        $requested = "rfq";
        $reference_no = $request->input("reference_no");
        $rfq = ClientRfq::where('refrence_no', $reference_no)
        ->orWhere('rfq_number', $reference_no)
        ->first();       
        if($rfq != null){
        $po = ClientPo::where('rfq_id', $rfq->rfq_id)
        ->first();
        if($po != null){
            $po_number = $po->po_number;
        }else{
            $po_number = "";
        }
    $shi = ShipperQuote::where('rfq_id', $rfq->rfq_id)->first() ?? '';
    $ship = $shi ? Shippers::where("shipper_id", $rfq->shipper_id)->first() : '';
    $shiname = $ship ? $ship->shipper_name : '';

        $line_items = LineItem::where('rfq_id', $rfq->rfq_id)->get();
            $tq = 0;
            foreach($line_items as $line){
                $tq = ($line->quantity * $line->unit_cost) + $tq;
            }
            $company = Companies::where('company_id', $rfq->company_id)->first();
        }else{
            $company = "";
            $rfq = "";
            $tq = "";
            $shi = "";
            $shiname = "";
            $reference_no = "";
            $line_items = "";
            $po = "";
            $po_number = "";
        }
        }elseif($request->has("po_number")){
        $requested = "po";
        $po_number = $request->input("po_number");
        $po = ClientPo::where('po_number', $po_number)
            ->first();
        if($po != null){
        $reference_no = $po->rfq_number;
        $rfq = ClientRfq::where('refrence_no', $reference_no)
        ->orWhere('rfq_number', $reference_no)
        ->first();       
        if($rfq != null){
        $shi = ShipperQuote::where('rfq_id', $rfq->rfq_id)->first() ?? '';
        $ship = $shi ? Shippers::where("shipper_id", $rfq->shipper_id)->first() : '';
        $shiname = $ship ? $ship->shipper_name : '';

        $line_items = LineItem::where('rfq_id', $rfq->rfq_id)->get();
            $tq = 0;
            foreach($line_items as $line){
                $tq = ($line->quantity * $line->unit_cost) + $tq;
            }
            $company = Companies::where('company_id', $rfq->company_id)->first();
        }else{
            $rfq = null;
        }
        }else{
            $company = "";
            $rfq = "";
            $tq = "";
            $shi = "";
            $shiname = "";
            $reference_no = "";
            $line_items = "";
            $po = "";
            $po_number = "";
        }
            
        
        }else{
            $company = "";
            $rfq = "";
            $tq = "";
            $shi = "";
            $shiname = "";
            $reference_no = "";
            $line_items = "";
            $po = "";
            $po_number = "";
            $requested = "";
        }

        return view('dashboard.reports.rfq')->with([
            'company' => $company,
            'rfq' => $rfq, 
            'tq' => $tq,
            'shi' => $shi,
            'shiname' => $shiname,
            'reference_no' => $reference_no,
            "line_items" => $line_items,
            "po" => $po,
            "po_number" => $po_number,
            "requested" => $requested
        ]);
    }

    public function sendRfqReport(Request $request)
    {
        
        if ($request->has("reference_no")) {
            $reference_no = $request->input("reference_no");
            $rfq = ClientRfq::where('refrence_no', $reference_no)
            ->orWhere('rfq_number', $reference_no)
            ->first();       
            if($rfq != null){
            $po = ClientPo::where('rfq_id', $rfq->rfq_id)
            ->first();
            if($po != null){
                $po_number = $po->po_number;
            }else{
                $po_number = "";
            }
        $shi = ShipperQuote::where('rfq_id', $rfq->rfq_id)->first() ?? '';
        $ship = $shi ? Shippers::where("shipper_id", $rfq->shipper_id)->first() : '';
        $shiname = $ship ? $ship->shipper_name : '';
    
            $line_items = LineItem::where('rfq_id', $rfq->rfq_id)->get();
                $tq = 0;
                foreach($line_items as $line){
                    $tq = ($line->quantity * $line->unit_cost) + $tq;
                }
                $company = Companies::where('company_id', $rfq->company_id)->first();
            }else{
                $company = "";
                $rfq = "";
                $tq = "";
                $shi = "";
                $shiname = "";
                $reference_no = "";
                $line_items = "";
                $po = "";
                $po_number = "";
            }
            }elseif($request->has("po_number")){
            $po_number = $request->input("po_number");
            $po = ClientPo::where('po_number', $po_number)
                ->first();
            if($po != null){
            $reference_no = $po->rfq_number;
            $rfq = ClientRfq::where('refrence_no', $reference_no)
            ->orWhere('rfq_number', $reference_no)
            ->first();       
            if($rfq != null){
            $shi = ShipperQuote::where('rfq_id', $rfq->rfq_id)->first() ?? '';
            $ship = Shippers::where("shipper_id", $rfq->shipper_id)->first() ?? '';
            $shiname = $ship->shipper_name;
    
            $line_items = LineItem::where('rfq_id', $rfq->rfq_id)->get();
                $tq = 0;
                foreach($line_items as $line){
                    $tq = ($line->quantity * $line->unit_cost) + $tq;
                }
                $company = Companies::where('company_id', $rfq->company_id)->first();
            }else{
                $rfq = null;
            }
            }else{
                $company = "";
                $rfq = "";
                $tq = "";
                $shi = "";
                $shiname = "";
                $reference_no = "";
                $line_items = "";
                $po = "";
                $po_number = "";
            }
                
            
            }else{
                $company = "";
                $rfq = "";
                $tq = "";
                $shi = "";
                $shiname = "";
                $reference_no = "";
                $line_items = "";
                $po = "";
                $po_number = "";
            }

        $rec_mail = $request->input("rec_email");
        $report_recipient = $request->input("report_recipient");
        $cut = explode("; ", $report_recipient);
        $users = [];
        foreach($cut as $key => $ut){
            $ua = [];
            $ua['email'] = $ut;
            $split = $cut = explode("@", $ut);
            $ua['name'] = strtoupper(str_replace(".","",$split[0]));
            $users[$key] = (object)$ua;
        }

        try{
            $data = ["company" => $company, "rfq" => $rfq, "tq" => $tq, "shi" => $shi, "shiname" => $shiname, "reference_no" => $reference_no,
            "line_items" => $line_items,
            "po" => $po,
            "po_number" => $po_number];
            $when = now()->addMinutes(1);
            Mail::to($rec_mail)->cc(str_replace(" ","",$users))->send( new RfqReport ($data));    
            return redirect()->back()->with([
                'success' => 'Email Sent Successfully'
            ]);
        }catch(\Exception $e){
            return redirect()->back()->with("error", "Email not sent, ". $e->getMessage());
        }
    }


    public function sendReport(Request $request)
    {
        $year = $request->input('year');
        $po = ClientPo::whereIn('status',['Delivered', 'Partial Delivery', 'Awaiting GRN', 'Invoicing', 'Invoiced', 'Paid'])->whereYear('actual_delivery_date',date('Y'))->orderBy('created_at','desc')->get();
        $shipper = ClientPo::select('shipper_id')->whereIn('status',['Delivered', 'Partial Delivery', 'Awaiting GRN', 'Invoicing', 'Invoiced', 'Paid'])->whereYear('actual_delivery_date',date('Y'))->groupBy('shipper_id')->get();
        // return view('emails.po.yearly')->with([
        //     'po' => $po, 'shipper' => $shipper
        // ]);

         $rec_mail = $request->input("rec_email");
         $report_recipient = $request->input("report_recipient");
        // $file = $request->quotation_file;
        // $arrFile = array();
        // $number = rand(1,200);
        // $refrence = $rfq->refrence_no;
        // $dest = date('Y'.'d'.'m').$refrence.$number;

         $cut = explode("; ", $report_recipient);
         $users = [];
         foreach($cut as $key => $ut){
             $ua = [];
             $ua['email'] = $ut;
             $split = $cut = explode("@", $ut);
             $ua['name'] = strtoupper(str_replace(".","",$split[0]));
             $users[$key] = (object)$ua;
         }
        try{
            $data = ["po" => $po, 'shipper'=> $shipper];
            $when = now()->addMinutes(1);
            Mail::to($rec_mail)->cc(str_replace(" ","",$users))->send( new POYearReport ($data));    
            return redirect()->back()->with([
                'po' => $po, 'shipper' => $shipper,
                'success' => 'Email Sent Successfully'
            ]);
        }catch(\Exception $e){
            return redirect()->back()->with("error", "Email not sent, ". $e->getMessage());
        }
    }

    public function sendRfqPoMonthlyReport(Request $request)
    {
        if (Gate::allows('SuperAdmin', auth()->user())) {
        $this->validate($request, [
            'rec_email' => ['required', 'string'],
            'report_recipient' => ['required']
        ]);
        
        $po = ClientPo::whereYear('po_date', now()->year )
        ->select('client_id', \DB::raw('count(*) as count'))
        ->groupBy('client_id')
        ->get();

        $pototal = ClientPo::whereYear('po_date', now()->year)
        ->count();

        $rfq = ClientRfq::whereYear('rfq_date', now()->year)
        ->select('client_id', \DB::raw('count(*) as count'))
        ->groupBy('client_id')
        ->get();
        
        $topclients = ClientRfq::whereYear('rfq_date', now()->year)
        ->select('client_id')
        ->selectRaw('count(*) as count')
        ->where('company_id', '2')
        ->groupBy('client_id')
        ->orderBy('count', 'desc')
        ->limit(5)
        ->pluck('client_id');
        
        $product = Product::orderBy('product_name')->pluck('product_name');

        $rfqtotal = ClientRfq::whereyear('rfq_date', now()->year)->count();
        $saipem = ClientRfq::where('client_id', '266')
        ->get();

        $nlng = ClientPo::where('client_id', '114')
        ->whereYear('po_date', now()->year)
        ->orderBy('po_number', 'asc')
        ->get();

        $rec_mail = $request->input("rec_email");
        $report_recipient = $request->input("report_recipient");
        $cut = explode("; ", $report_recipient);
        $users = [];
        foreach($cut as $key => $ut){
            $ua = [];
            $ua['email'] = $ut;
            $split = $cut = explode("@", $ut);
            $ua['name'] = strtoupper(str_replace(".","",$split[0]));
            $users[$key] = (object)$ua;
        }
        try{
            $data = ["po" => $po, 'rfq'=> $rfq, 'product' => $product, 'topclients' => $topclients];
            $when = now()->addMinutes(1);
            Mail::to($rec_mail)->cc(str_replace(" ","",$users))->send( new RfqPoMonthlyReport ($data));    
            return redirect()->back()->with([
                'po' => $po, 
                'rfq' => $rfq, 
                'rfqtotal' => $rfqtotal,
                'pototal' => $pototal,
                'nlng' => $nlng,
                'saipem' => $saipem,
                'product'=> $product,
                'topclients' => $topclients,
                'success' => 'Email Sent Successfully'
            ]);
        }catch(\Exception $e){
            return redirect()->back()->with("error", "Email not sent, ". $e->getMessage());
        }
    }else{
        $employee = Employers::where('email', Auth::user()->email)->first();
        $company_id = $employee->company_id;
        
        $product = Product::where('company_id', $company_id)->orderBy('product_name')->pluck('product_name');
        
        $this->validate($request, [
            'rec_email' => ['required', 'string'],
            'report_recipient' => ['required']
        ]);
        
        $po = ClientPo::whereYear('po_date', now()->year )
        ->select('client_id', \DB::raw('count(*) as count'))
        ->where('company_id', $company_id)
        ->groupBy('client_id')
        ->get();

        $pototal = ClientPo::whereYear('po_date', now()->year)
        ->where('company_id', $company_id)
        ->count();

        $rfq = ClientRfq::whereYear('rfq_date', now()->year)
        ->select('client_id', \DB::raw('count(*) as count'))
        ->where('company_id', $company_id)
        ->groupBy('client_id')
        ->get();
        
        $topclients = ClientRfq::whereYear('rfq_date', now()->year)
        ->select('client_id')
        ->selectRaw('count(*) as count')
        ->where('company_id', $company_id)
        ->groupBy('client_id')
        ->orderBy('count', 'desc')
        ->limit(5)
        ->pluck('client_id');

        $rfqtotal = ClientRfq::whereyear('rfq_date', now()->year)->where('company_id', $company_id)->count();
        $saipem = ClientRfq::where('client_id', '266')
        ->get();

        $nlng = ClientPo::where('client_id', '114')
        ->whereYear('po_date', now()->year)
        ->orderBy('po_number', 'asc')
        ->get();

        $rec_mail = $request->input("rec_email");
        $report_recipient = $request->input("report_recipient");
        $cut = explode("; ", $report_recipient);
        $users = [];
        foreach($cut as $key => $ut){
            $ua = [];
            $ua['email'] = $ut;
            $split = $cut = explode("@", $ut);
            $ua['name'] = strtoupper(str_replace(".","",$split[0]));
            $users[$key] = (object)$ua;
        }
        try{
            $data = ["po" => $po, 'rfq'=> $rfq, 'product' => $product, 'topclients' => $topclients];
            $when = now()->addMinutes(1);
            Mail::to($rec_mail)->cc(str_replace(" ","",$users))->send( new RfqPoMonthlyReport ($data));    
            return redirect()->back()->with([
                'po' => $po, 
                'rfq' => $rfq, 
                'rfqtotal' => $rfqtotal,
                'pototal' => $pototal,
                'nlng' => $nlng,
                'saipem' => $saipem,
                'product'=> $product,
                'topclients' => $topclients,
                'success' => 'Email Sent Successfully'
            ]);
        }catch(\Exception $e){
            return redirect()->back()->with("error", "Email not sent, ". $e->getMessage());
        }
    }
    }

    public function sendSaipemReport(Request $request)
    {
        $this->validate($request, [
            'rec_email' => ['required', 'string'],
            'report_recipient' => ['required']
        ]);
        
        $po = ClientPo::whereYear('po_date', now()->year )
        ->select('client_id', \DB::raw('count(*) as count'))
        ->groupBy('client_id')
        ->get();

        $pototal = ClientPo::whereYear('po_date', now()->year)
        ->count();

        $rfq = ClientRfq::whereYear('rfq_date', now()->year)
        ->select('client_id', \DB::raw('count(*) as count'))
        ->groupBy('client_id')
        ->get();

        $rfqtotal = ClientRfq::whereyear('rfq_date', now()->year)->count();
        $saipem = ClientRfq::where('client_id', '266')
        ->whereyear('rfq_date', now()->year)
        ->get();

        $nlng = ClientPo::where('client_id', '114')
        ->whereYear('po_date', now()->year)
        ->orderBy('po_number', 'asc')
        ->get();

        $rec_mail = $request->input("rec_email");
        $report_recipient = $request->input("report_recipient");
        $cut = explode("; ", $report_recipient);
        $users = [];
        foreach($cut as $key => $ut){
            $ua = [];
            $ua['email'] = $ut;
            $split = $cut = explode("@", $ut);
            $ua['name'] = strtoupper(str_replace(".","",$split[0]));
            $users[$key] = (object)$ua;
        }
        try{
            $data = ['rfq'=> $rfq, 'saipem' => $saipem];
            $when = now()->addMinutes(1);
            Mail::to($rec_mail)->cc(str_replace(" ","",$users))->send( new SaipemReport ($data));    
            return redirect()->back()->with([
                'po' => $po, 
                'rfq' => $rfq, 
                'rfqtotal' => $rfqtotal,
                'pototal' => $pototal,
                'nlng' => $nlng,
                'saipem' => $saipem,
                'success' => 'Email Sent Successfully'
            ]);
        }catch(\Exception $e){
            return redirect()->back()->with("error", "Email not sent, ". $e->getMessage());
        }
    }
    
    public function sendBHAReport(Request $request)
    {
        $this->validate($request, [
            'rec_email' => ['required', 'string'],
            'report_recipient' => ['required']
        ]);
        
        $po = ClientPo::whereYear('po_date', now()->year )
        ->select('client_id', \DB::raw('count(*) as count'))
        ->groupBy('client_id')
        ->get();

        $pototal = ClientPo::whereYear('po_date', now()->year)
        ->count();
        
        $bha = ClientRfq::leftjoin('client_pos', 'client_rfqs.rfq_id', '=', 'client_pos.rfq_id')
        ->select(
            'client_rfqs.refrence_no as refrence_no',
            'client_rfqs.rfq_number as rfq_number',
            'client_rfqs.contact_id as contact_id',
            'client_rfqs.description as description',
            'client_rfqs.client_id as client_id',
            'client_rfqs.rfq_date as rfq_date',
            'client_pos.po_date as po_date',
            'client_pos.po_value_foreign as po_value_foreign',
            'client_rfqs.delivery_due_date as delivery_due_date',
            'client_rfqs.currency as currency',
            'client_rfqs.total_quote as total_quote',
            'client_rfqs.status as status',
            'client_pos.status as po_status',
            'client_pos.po_number as po_number',
            'client_pos.po_value_foreign as po_value_foreign'
            )
        ->where('client_rfqs.product', 'BHA')
        ->where(function($query){
            $query->whereyear('client_rfqs.rfq_date', now()->year)
                  ->orWhereYear('client_pos.po_date', now()->year);
        })
        ->get();

        $rfq = ClientRfq::whereYear('rfq_date', now()->year)
        ->select('client_id', \DB::raw('count(*) as count'))
        ->groupBy('client_id')
        ->get();

        $rfqtotal = ClientRfq::whereyear('rfq_date', now()->year)->count();
        $saipem = ClientRfq::where('client_id', '266')
        ->whereyear('rfq_date', now()->year)
        ->get();

        $nlng = ClientPo::where('client_id', '114')
        ->whereYear('po_date', now()->year)
        ->orderBy('po_number', 'asc')
        ->get();

        $rec_mail = $request->input("rec_email");
        $report_recipient = $request->input("report_recipient");
        $cut = explode("; ", $report_recipient);
        $users = [];
        foreach($cut as $key => $ut){
            $ua = [];
            $ua['email'] = $ut;
            $split = $cut = explode("@", $ut);
            $ua['name'] = strtoupper(str_replace(".","",$split[0]));
            $users[$key] = (object)$ua;
        } 
        try{
            $data = ['rfq'=> $rfq, 'bha' => $bha];
            $when = now()->addMinutes(1);
            Mail::to($rec_mail)->cc(str_replace(" ","",$users))->send( new BHAReport ($data));    
            return redirect()->back()->with([
                'po' => $po, 
                'rfq' => $rfq, 
                'rfqtotal' => $rfqtotal,
                'pototal' => $pototal,
                'nlng' => $nlng,
                'saipem' => $saipem,
                'bha' => $bha,
                'success' => 'Email Sent Successfully'
            ]);
        }catch(\Exception $e){
            return redirect()->back()->with("error", "Email not sent, ". $e->getMessage());
        }
    }

    public function sendWeeklyReport(Request $request)
    {
        if (Gate::allows('SuperAdmin', auth()->user())) {
        $this->validate($request, [
            'rec_email' => ['required', 'string'],
            'report_recipient' => ['required'],
            'start_date_report' => ['required'],
            'end_date_report' => ['required']
        ]);
        
        // Calculate the dates for the current week's Monday and Friday
        $currentWeekMonday = Carbon::parse($request->input("start_date_report"));
        $currentWeekFriday = Carbon::parse($request->input("end_date_report"));
       
        $po = ClientPo::whereBetween('po_date', [$currentWeekMonday, $currentWeekFriday])
        ->where('status', '!=', 'PO Cancelled')
        ->select('client_id', \DB::raw('count(*) as count'))
        ->groupBy('client_id')
        ->get();

        $pototal = ClientPo::whereBetween('po_date', [$currentWeekMonday, $currentWeekFriday])
        ->where('status', '!=', 'PO Cancelled')
        ->count();

        $rfq = ClientRfq::whereBetween('rfq_date', [$currentWeekMonday, $currentWeekFriday])
        ->select('client_id', \DB::raw('count(*) as count'))
        ->groupBy('client_id')
        ->get();

        $rfqtotal = ClientRfq::whereBetween('rfq_date', [$currentWeekMonday, $currentWeekFriday])->count();

        $nlng = ClientPo::where('client_id', '114')
        ->whereYear('po_date', now()->year)
        ->orderBy('po_number', 'asc')
        ->get();

        $grn = ClientPo::where('status', 'Awaiting GRN')
        ->get();

        $rec_mail = $request->input("rec_email");
        $report_recipient = $request->input("report_recipient");
        $cut = explode("; ", $report_recipient);
        $users = [];
        foreach($cut as $key => $ut){
            $ua = [];
            $ua['email'] = $ut;
            $split = $cut = explode("@", $ut);
            $ua['name'] = strtoupper(str_replace(".","",$split[0]));
            $users[$key] = (object)$ua;
        }
        try{
            $data = ['rfq'=> $rfq, 'rfqtotal' => $rfqtotal, 'po' => $po, 'pototal' => $pototal, 'monday'=> $currentWeekMonday ,'friday' => $currentWeekFriday, 'grn' => $grn];
            $when = now()->addMinutes(1);
            Mail::to($rec_mail)->cc(str_replace(" ","",$users))->send( new WeeklyReport($data));    
            return redirect()->back()->with([
                'po' => $po, 
                'rfq' => $rfq, 
                'rfqtotal' => $rfqtotal,
                'pototal' => $pototal,
                'nlng' => $nlng,
                'grn' => $grn,
                'success' => 'Email Sent Successfully'
            ]);
        }catch(\Exception $e){
            return redirect()->back()->with("error", "Email not sent, ". $e->getMessage());
        }
    }else{
        
        $employee = Employers::where('email', Auth::user()->email)->first();
        $company_id = $employee->company_id;
        
        $this->validate($request, [
            'rec_email' => ['required', 'string'],
            'report_recipient' => ['required']
        ]);
        
    // Calculate the dates for the current week's Monday and Friday
        $currentWeekMonday = Carbon::parse($request->input("start_date_report"));
        $currentWeekFriday = Carbon::parse($request->input("end_date_report"));
       
        $po = ClientPo::whereBetween('po_date', [$currentWeekMonday, $currentWeekFriday])
        ->select('client_id', \DB::raw('count(*) as count'))
        ->where('company_id', $company_id)
        ->where('status', '!=', 'PO Cancelled')
        ->groupBy('client_id')
        ->get();

        $pototal = ClientPo::whereBetween('po_date', [$currentWeekMonday, $currentWeekFriday])
        ->where('company_id', $company_id)
        ->where('status', '!=', 'PO Cancelled')
        ->count();

        $rfq = ClientRfq::whereBetween('rfq_date', [$currentWeekMonday, $currentWeekFriday])
        ->select('client_id', \DB::raw('count(*) as count'))
        ->where('company_id', $company_id)
        ->groupBy('client_id')
        ->get();

        $rfqtotal = ClientRfq::whereBetween('rfq_date', [$currentWeekMonday, $currentWeekFriday])->where('company_id', $company_id)->count();

        $nlng = ClientPo::where('client_id', '114')
        ->whereYear('po_date', now()->year)
        ->orderBy('po_number', 'asc')
        ->get();

        $grn = ClientPo::where('status', 'Awaiting GRN')
        ->where('company_id', $company_id)
        ->get();

        $rec_mail = $request->input("rec_email");
        $report_recipient = $request->input("report_recipient");
        $cut = explode("; ", $report_recipient);
        $users = [];
        foreach($cut as $key => $ut){
            $ua = [];
            $ua['email'] = $ut;
            $split = $cut = explode("@", $ut);
            $ua['name'] = strtoupper(str_replace(".","",$split[0]));
            $users[$key] = (object)$ua;
        }
        try{
            $data = ['rfq'=> $rfq, 'rfqtotal' => $rfqtotal, 'po' => $po, 'pototal' => $pototal, 'monday'=> $currentWeekMonday ,'friday' => $currentWeekFriday, 'grn' => $grn];
            $when = now()->addMinutes(1);
            Mail::to($rec_mail)->cc(str_replace(" ","",$users))->send( new WeeklyReport($data));    
            return redirect()->back()->with([
                'po' => $po, 
                'rfq' => $rfq, 
                'rfqtotal' => $rfqtotal,
                'pototal' => $pototal,
                'nlng' => $nlng,
                'grn' => $grn,
                'success' => 'Email Sent Successfully'
            ]);
        }catch(\Exception $e){
            return redirect()->back()->with("error", "Email not sent, ". $e->getMessage());
        }
        
    }
    }

    public function searchReport(Request $request)
    {
        $this->validate($request, [
            'year' => ['required', 'string', 'max:4'],
            'start_month' => ['required', 'string', 'max:3'],
            'end_month' => ['required', 'string', 'max:3'],
        ]);
        
        $year = $request->input('year');
        $start_month = $request->input('start_month');
        $end_month = $request->input('end_month');
        // $po = ClientPo::whereYear('created_at', $start_month)->whereBeteen->orderBy('po_id','desc')->get();
        // dd($po);
    }
}
