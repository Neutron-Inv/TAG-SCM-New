<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{Companies, User,Log,ClientRfq, ClientPo, Clients, Shippers, ShipperQuote, LineItem};
use Illuminate\Support\Facades\Auth;
use DB; 
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Gate;
use App\Mail\{POYearReport};
use App\Mail\{RfqPoMonthlyReport};
use App\Mail\{SaipemReport};
use App\Mail\{WeeklyReport};
use App\Mail\{RfqReport};
use App\Mail\{CustomReport};
use App\Mail\{ClientPoReport};
use Storage;
use Illuminate\Http\UploadedFile;
class ReportController extends Controller
{
    protected $model;
    public function createReport()
    {
        $po = ClientPo::where('status', 'Delivered')->orderBy('created_at','desc')->get();
        $shipper = ClientPo::select('shipper_id')->groupBy('shipper_id')->get();
        return view('dashboard.reports.index')->with([
            'po' => $po, 'shipper' => $shipper
        ]);
    }

    public function weekly()
    {
        // Calculate the dates for the current week's Monday and Friday
        $currentWeekMonday = now()->startOfWeek(); // Monday of the current week
        $currentWeekFriday = now()->startOfWeek()->addDays(4); // Friday of the current week
       
        $po = ClientPo::whereBetween('po_date', [$currentWeekMonday, $currentWeekFriday])
        ->select('client_id', \DB::raw('count(*) as count'))
        ->groupBy('client_id')
        ->get();

        $pototal = ClientPo::whereBetween('po_date', [$currentWeekMonday, $currentWeekFriday])
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
            'grn' => $grn
        ]);
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
        // Calculate the dates for the current week's Monday and Friday
        $currentWeekMonday = now()->startOfWeek(); // Monday of the current week
        $currentWeekFriday = now()->startOfWeek()->addDays(4); // Friday of the current week
       
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
            'saipem' => $saipem
        ]);
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


    public function sendReport()
    {
        
        $po = ClientPo::where('status', 'Delivered')->orderBy('created_at','desc')->get();
        $shipper = ClientPo::select('shipper_id')->groupBy('shipper_id')->get();
        // return view('emails.po.yearly')->with([
        //     'po' => $po, 'shipper' => $shipper
        // ]);

        // $rec_mail = $request->input("rec_email");
        // $quotation_recipient = $request->input("quotation_recipient");
        // $file = $request->quotation_file;
        // $arrFile = array();
        // $number = rand(1,200);
        // $refrence = $rfq->refrence_no;
        // $dest = date('Y'.'d'.'m').$refrence.$number;

        // $cut = explode("; ", $quotation_recipient);
        // $users = [];
        // foreach($cut as $key => $ut){
        //     $ua = [];
        //     $ua['email'] = $ut;
        //     $split = $cut = explode("@", $ut);
        //     $ua['name'] = strtoupper(str_replace(".","",$split[0]));
        //     $users[$key] = (object)$ua;
        // }
        try{
            $data = ["po" => $po, 'shipper'=> $shipper];
            $when = now()->addMinutes(1);
            Mail::to('emmanuel@enabledgroup.net')->cc(['jackomega.idnoble@gmail.com'])->send( new POYearReport ($data));    
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
            $data = ["po" => $po, 'rfq'=> $rfq];
            $when = now()->addMinutes(1);
            Mail::to($rec_mail)->cc(str_replace(" ","",$users))->send( new RfqPoMonthlyReport ($data));    
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

    public function sendWeeklyReport(Request $request)
    {
        $this->validate($request, [
            'rec_email' => ['required', 'string'],
            'report_recipient' => ['required']
        ]);
        
        // Calculate the dates for the current week's Monday and Friday
        $currentWeekMonday = now()->startOfWeek(); // Monday of the current week
        $currentWeekFriday = now()->startOfWeek()->addDays(4); // Friday of the current week
       
        $po = ClientPo::whereBetween('po_date', [$currentWeekMonday, $currentWeekFriday])
        ->select('client_id', \DB::raw('count(*) as count'))
        ->groupBy('client_id')
        ->get();

        $pototal = ClientPo::whereBetween('po_date', [$currentWeekMonday, $currentWeekFriday])
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
