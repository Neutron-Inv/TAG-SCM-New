<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{Companies, User, Clients, Log, RfqNumbers, Employers,ClientRfq, ShipperQuote, Shippers, SupplierQuote, ClientContact, ScmStatus, 
    RfqHistory, Vendors, ClientPo, LineItem, VendorContact, PricingHistory, MailTray};
use Illuminate\Support\Facades\{Auth, Hash, File, Mail, Gate};
use App\Repositories\RfqRepository;
use Storage;
use DB; 
use Str;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PHPExcel_Style_Border;
use PDF; 
use Dompdf\FontMetrics;
use Illuminate\Http\UploadedFile;
use App\Notifications\{EmployerRFQCreated, RFQAcknowledge, ShipperEmail};
use App\Mail\{Quotation, ApproveBreakdown, Submission, QuotationTagEnergy, QuotationTagLines, QuotationEnabledSolution, QuotationEnabledContractors, QuotationTestCompany, ClientContactRFQCreated, QuoteRequest};

class ClientRFQController extends Controller
{
    protected $model;
    public function __construct(ClientRfq $rfq)
    {
        // set the model
        $this->model = new RfqRepository($rfq);
        $this->middleware('auth');
        $this->middleware(['role:SuperAdmin|Admin|Employer|Contact|Client|HOD|Shipper|Supplier']);
    }/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     
    public function getnote(Request $request)
    {  
        $rfq_id = $request->input('rfq_id');

            $query = ClientRfq::select('note')
                ->where('rfq_id', $rfq_id)
                ->first();
    
            return $query;

    }
    
    public function chart()
    {  
        if (Gate::allows('SuperAdmin', auth()->user())) {
            $clients = Clients::orderBy('client_name', 'asc')->get();
            return view('dashboard.chart.monthly')->with(['clients' => $clients]);

        } else {
            return redirect()->back()->with([
                'error' => "You Dont have Access To This Page",
            ]);
        }


    }

    public function weekly()
    {  
        if (Gate::allows('SuperAdmin', auth()->user())) {
            $clients = Clients::orderBy('client_name', 'asc')->get();
            return view('dashboard.chart.weekly')->with(['clients' => $clients]);

        } else {
            return redirect()->back()->with([
                'error' => "You Dont have Access To This Page",
            ]);
        }


    }

    public function supplierChart()
    {
        if (Gate::allows('SuperAdmin', auth()->user())) {
            $supplier = Vendors::orderBy('vendor_name', 'asc')->paginate(30);
            return view('dashboard.chart.supplier')->with(['supplier' => $supplier]);

        } else {
            return redirect()->back()->with([
                'error' => "You Dont have Access To This Page",
            ]);
        }
    }

    public function shipperChart()
    {
        if (Gate::allows('SuperAdmin', auth()->user())) {
            $shipper = Shippers::orderBy('shipper_name', 'asc')->paginate(15);
            return view('dashboard.chart.shipper')->with(['shipper' => $shipper]);

        } else {
            return redirect()->back()->with([
                'error' => "You Dont have Access To This Page",
            ]);
        }
    }

    public function companyChart()
    {
        if (Gate::allows('SuperAdmin', auth()->user())) {
            $company = Companies::orderBy('company_name', 'asc')->paginate(15);
            return view('dashboard.chart.companies')->with(['company' => $company]);

        } else {
            return redirect()->back()->with([
                'error' => "You Dont have Access To This Page",
            ]);
        }
    }

    public function clientChart()
    {
        if (Gate::allows('SuperAdmin', auth()->user())) {
            $client = Clients::orderBy('client_name', 'asc')->paginate(20);
            return view('dashboard.chart.clients')->with(['client' => $client]);

        } else {
            return redirect()->back()->with([
                'error' => "You Dont have Access To This Page",
            ]);
        }
    }

    public function employerChart()
    {
        if (Gate::allows('SuperAdmin', auth()->user())) {
            $employer = Employers::orderBy('full_name', 'asc')->paginate(20);
            return view('dashboard.chart.employers')->with(['employer' => $employer]);
        } else {
            return redirect()->back()->with([
                'error' => "You Dont have Access To This Page",
            ]);
        }
    }

    public function createFolders()
    {
        $rfq = ClientRfq::orderBy('created_at','desc')->get();
        $dir = base_path("email/rfq/");
        $dirs = base_path("email/po/");
        $po = ClientPo::orderBy('po_id', 'desc')->get();
        foreach ($rfq as $key) {
            ClientPo::where('rfq_id', $key->rfq_id)->update([
                'shipper_id' => $key->shipper_id
            ]);
        }
        // foreach ($po as $item) {
        //     ClientPo::where('po_id', $item->po_id)->update([
        //         'created_at' => date('Y-m-d H:i:s'),
        //     ]);
            
        // }
        foreach ($rfq as $key) {
            
            !file_exists(File::makeDirectory($dir.$key->refrence_no, $mode = 0777, true, true));
            !file_exists(File::makeDirectory($dirs.$key->refrence_no, $mode = 0777, true, true));
        }
        return redirect()->route('rfq.index')->with('success', 'Folders Created Successfuly');
    }

    public function populateShortCode()
    {
        $rfq = ClientRfq::orderBy('created_at','asc')->paginate(700);
       
        foreach ($rfq as $key) {
    
            $ref_number = $key->refrence_no;
            if(!empty($ref_number)){
                
                if(strlen($ref_number) == 9){
                    $shortCode = substr($ref_number, 0, 22);
                }elseif(strlen($ref_number) == 10){
                    $shortCode = substr($ref_number, 1, 22);
                }elseif(strlen($ref_number) == 11) {
                    $shortCode = substr($ref_number, 2, 22);
                }elseif(strlen($ref_number) == 12) {
                    $shortCode = substr($ref_number, 3, 22);
                }elseif (strlen($ref_number) == 13) {
                    $shortCode = substr($ref_number, 4, 22);
                }elseif(strlen($ref_number) == 14) {
                    $shortCode = substr($ref_number, 5, 22);
                }elseif(strlen($ref_number) == 15) {
                    $shortCode = substr($ref_number, 6, 22);

                }elseif(strlen($ref_number) == 17) {
                    $shortCode = substr($ref_number, 7, 22);

                }elseif(strlen($ref_number) == 18) {
                    $shortCode = substr($ref_number, 8, 22);

                }elseif(strlen($ref_number) == 19) {
                    $shortCode = substr($ref_number, 10, 22);
                }else{
                    $shortCode = $ref_number;
                }

                ClientRFQ::where('rfq_id', $key->rfq_id)->update([
                    'short_code' => $shortCode
                ]);

                
            }else{

            }
            
        }
        
        return redirect()->route('rfq.index')->with('success', 'Short Code Populated Successfuly');
    }

    public function index()
    {
        if (Gate::allows('SuperAdmin', auth()->user())) {
            $employer = Employers::orderBy('full_name', 'asc')->get();
            $rfq = ClientRfq::orderBy('created_at','desc')->get();
            $company = Companies::orderBy('company_name','asc')->get();
            
            return view('dashboard.rfq.index')->with([
                'employer' => $employer, "rfq" => $rfq, "company" => $company
            ]);
        }elseif(Auth::user()->hasRole('Admin')){

            $company = Companies::where('email', Auth::user()->email)->first();
            $employer = Employers::where('company_id', $company->company_id)->orderBy('full_name', 'asc')->get();
            $rfq = ClientRfq::where('company_id', $company->company_id)->orderBy('created_at','desc')->get();
            return view('dashboard.rfq.index')->with([
                'employer' => $employer, "rfq" => $rfq, "company" => $company
            ]);

        }elseif(auth()->user()->hasRole('Employer') OR (auth()->user()->hasRole('HOD'))){

            $employer = Employers::where('email', Auth::user()->email)->first();
            $company = Companies::where('company_id', $employer->company_id)->first();
            $rfq = ClientRfq::where('company_id', $company->company_id)->orderBy('created_at','desc')->get();

            return view('dashboard.rfq.index')->with([
                'employer' => $employer, "rfq" => $rfq, 'company' => $company
            ]);

        }elseif(Auth::user()->hasRole('Contact')){

            $contact = ClientContact::where('email', Auth::user()->email)->first();
            $rfq = ClientRfq::where('contact_id', $contact->contact_id)->orderBy('created_at','desc')->get();

            return view('dashboard.rfq.index')->with([
                'contact' => $contact, "rfq" => $rfq,
            ]);

        }elseif(Auth::user()->hasRole('Client')){

            $client = Clients::where('email', Auth::user()->email)->first();
            $rfq = ClientRfq::where('client_id', $client->client_id)->orderBy('created_at','desc')->get();

            return view('dashboard.rfq.index')->with([
                'client' => $client, "rfq" => $rfq,
            ]);
        }elseif(auth()->user()->hasRole('Shipper')){
            $shipper = Shippers::where('contact_email', Auth::user()->email)->first();
            $rfq = ClientRfq::where('shipper_id', $shipper->shipper_id)->orderBy('created_at','desc')->get();

            return view("dashboard.rfq.index")->with([
                "rfq" => $rfq, "shipper" => $shipper,
            ]);

        }elseif(auth()->user()->hasRole('Supplier')){

            $vendor = Vendors::where('contact_email', Auth::user()->email)->first();
            $line_item = LineItem::where('vendor_id', $vendor->vendor_id)->select('rfq_id')->groupBy('rfq_id')->get();
            $rfq = ClientRfq::where('company_id', $vendor->company_id)->orderBy('created_at','desc')->get();
            return view("dashboard.rfq.index")->with([

                "vendor" => $vendor, 'rfq' => $rfq, "line_item" => $line_item
            ]);

        } else {

            return view('errors.403');
        }
    }

    public function list()
    {
        if (Gate::allows('SuperAdmin', auth()->user())) {
            $rfq = ClientRfq::orderBy('created_at','desc')->get();
            return view('dashboard.rfq.list')->with([
                "rfq" => $rfq,
            ]);

        } else {

            return view('errors.403');
        }
    }

    public function history()
    {
        if (Gate::allows('SuperAdmin', auth()->user())) {
            $hist= RfqHistory::orderBy('created_at','desc')->get();
            return view('dashboard.rfq.history')->with([
                "hist" => $hist,
            ]);

        } else {

            return view('errors.403');
        }
    }

    public function singleHistory($rfq_id)
    {
        if(ClientRfq::where('rfq_id', $rfq_id)->exists()){
            if (Gate::allows('SuperAdmin', auth()->user())) {
                $rfq = RfqHistory::where('rfq_id', $rfq_id)>-orderBy('created_at','desc')->get();
                return view('dashboard.rfq.log')->with([
                    "rfq" => $rfq,
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function clientRfq($client_id)
    {

        if(Clients::where('client_id', $client_id)->exists()){

            $rfq = ClientRfq::where('client_id', $client_id)->orderBy('created_at','desc')->get();
            $client = Clients::where('client_id', $client_id)->first();
            return view('dashboard.rfq.client')->with(["rfq" => $rfq, "client" => $client]);

        }else{
            return redirect()->back()->with([
            'error' => "$client_id does not Exist for any Client",
            ]);
        }
    }
    public function create($client_id)
    {
        if(Clients::where('client_id', $client_id)->exists()){
            function generateRandomHash($length)
            {
                return strtoupper(substr(md5(uniqid(rand())), 0, (-32 + $length)));
            }


            $former_number = RfqNumbers::max('numbers');
            $new_rfq = ClientRfq::count();
            $new_ref = $new_rfq + 1;
            $cli = Clients::where('client_id', $client_id)->first();
            $date = date('dmy'); 
            $refrence_number = ($cli->short_code.''.$date.$new_ref);

            $rfq_number = strtoupper(generateRandomHash(6));
            $status = ScmStatus::where('type', 'RFQ')->orderBy('name', 'asc')->get();
            if (Gate::allows('SuperAdmin', auth()->user()) OR (Auth::user()->hasRole('Admin'))){
                $clienting = Clients::where('client_id', $client_id)->first();
                $company_id = $clienting->company_id;
                $company = Companies::where('company_id',$company_id)->get();
                $employer = Employers::where('company_id', $company_id)->orderBy('full_name', 'asc')->get();
                $contact = ClientContact::where('client_id', $client_id)->orderBy('first_name', 'asc')->get();
                $shipper = Shippers::where('company_id', $company_id)->orderBy('shipper_name', 'asc')->orWhere('shipper_name', 'Test Shipper')->get();
                $vendor = Vendors::where('company_id', $company_id)->orderBy('vendor_name', 'asc')->orWhere('vendor_name', 'TEST VENDOR')->get();
                return view('dashboard.rfq.create')->with([
                    'employer' => $employer, "company" => $company, "contact" => $contact, "shipper" => $shipper, "clienting" => $clienting,
                    'refrence_number' => $refrence_number, 'status' => $status, "rfq_number" => $rfq_number, 'vendor' => $vendor,
                ]);
            }elseif(Auth::user()->hasRole('Client')){

                $clienting = Clients::where('email', Auth::user()->email)->first();
                $company_id = $clienting->company_id;
                $company = Companies::where('company_id',$company_id)->get();
                $employer = Employers::where('company_id', $company_id)->orderBy('full_name', 'asc')->get();
                $contact = ClientContact::where('client_id', $client_id)->orderBy('first_name', 'asc')->get();
                $shipper = Shippers::where('company_id', $company_id)->orderBy('shipper_name', 'asc')->orWhere('shipper_name', 'Test Shipper')->get();
                $vendor = Vendors::where('company_id', $company_id)->orderBy('vendor_name', 'asc')->orWhere('vendor_name', 'TEST VENDOR')->get();
                return view('dashboard.rfq.create')->with([
                    'employer' => $employer, "company" => $company, "contact" => $contact, "shipper" => $shipper, "clienting" => $clienting,
                    'refrence_number' => $refrence_number, 'status' => $status,  "rfq_number" => $rfq_number, 'vendor' => $vendor,
                ]);

            }elseif(Auth::user()->hasRole('Employer') OR (Auth::user()->hasRole('HOD'))){

                $employ = Employers::where('email', Auth::user()->email)->first();
                $company = Companies::where('company_id', $employ->company_id)->first();
                $company_id = $company->company_id;
                $employer = Employers::where('company_id', $company_id)->orderBy('full_name', 'asc')->get();
                $contact = ClientContact::where('client_id', $client_id)->orderBy('first_name', 'asc')->get();
                $shipper = Shippers::where('company_id', $company_id)->orderBy('shipper_name', 'asc')->orWhere('shipper_name', 'Test Shipper')->get();
                $clienting = Clients::where('client_id', $client_id)->first();
                $vendor = Vendors::where('company_id', $company_id)->orderBy('vendor_name', 'asc')->orWhere('vendor_name', 'TEST VENDOR')->get();
                return view('dashboard.rfq.create')->with([
                    'employer' => $employer, "company" => $company, "contact" => $contact, "shipper" => $shipper, 'vendor' => $vendor,
                    'refrence_number' => $refrence_number, 'status' => $status, "clienting" => $clienting,  "rfq_number" => $rfq_number
                ]);

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

    public function generateReport(Request $request)
    {
        $this->validate($request, [
            'product' => ['required', 'string', 'max:199'],
            'client_id' => ['required'],
        ]);
        $product = $request->input('product');
        $id = $request->input('client_id');
        $client_id = implode(', ', $id);
        // 114, 280, 281, 136
        $data =DB::table('client_rfqs')->whereIn('client_id', explode(', ', $client_id))->where([['product', '=', $product],['product', 'like', '%' . $product . '%'],])->get();
        if(count($data) > 0){

            $report = DB::table('client_rfqs')->whereIn('client_id', explode(', ', $client_id))->where([['product', '=', $product],['product', 'like', '%' . $product . '%'],])->select('rfq_id','company_id', 'refrence_no', 'rfq_number', 'description', 'product', 'client_id')->orderBy('client_id', 'asc')->get();

            $spreadsheet = new Spreadsheet();
            $date = date('Y-m-d');
            $spreadsheet->getActiveSheet()->setCellValue('A2', 'COMPANY NAME');
            $spreadsheet->getActiveSheet()->setCellValue('B2', 'CLIENT NAME');
            $spreadsheet->getActiveSheet()->setCellValue('C2', 'RFQ NUMBER');
            $spreadsheet->getActiveSheet()->setCellValue('D2', 'PO NUMBER');
            $spreadsheet->getActiveSheet()->setCellValue('E2', 'PRODUCT');
            $spreadsheet->getActiveSheet()->setCellValue('F2', 'REFRENCE NUMBER');
            $spreadsheet->getActiveSheet()->setCellValue('G2', 'DESCRIPTION');

            foreach(range('A','G') as $columnID) {
                $spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
            }

            $num = 3;
            foreach ($report as $key ) {
                $rfq_id = $key->rfq_id;
                if(count(po($rfq_id)) > 0){
                    $details = poSee($rfq_id);
                    $po_number = $details->po_number;
                }else{
                    $po_number = 'N/A';
                }
                if(count(comp($key->company_id)) > 0){
                    $com = cops($key->company_id);
                    $company_name = $com->company_name;
                }else{
                    $company_name = 'No Company Name';
                }

                if(count(clis($key->client_id)) > 0){
                    $cris = clits($key->client_id);
                    $client_name = $cris->client_name;
                }else{
                    $client_name = 'No Client Name';
                }

                $cellD ='A'.$num;
                $spreadsheet->getActiveSheet()->setCellValue($cellD, $company_name);

                $cellD ='B'.$num;
                $spreadsheet->getActiveSheet()->setCellValue($cellD, $client_name);

                $cellD ='C'.$num;
                $spreadsheet->getActiveSheet()->setCellValue($cellD, $key->rfq_number);

                $cellD ='D'.$num;
                $spreadsheet->getActiveSheet()->setCellValue($cellD, $po_number);

                $cellD ='E'.$num;
                $spreadsheet->getActiveSheet()->setCellValue($cellD, $key->product);

                $cellD ='F'.$num;
                $spreadsheet->getActiveSheet()->setCellValue($cellD, $key->refrence_no);

                $cellD ='G'.$num;
                $spreadsheet->getActiveSheet()->setCellValue($cellD, $key->description);

                $num++;
            }

            $writer = new Xlsx($spreadsheet);
            if(file_exists('Reports/'.$product.'.xlsx')){
                unlink('Reports/'.$product.'.xlsx');
            }
            $writer->save('Reports/'.$product.'.xlsx');
            header("Content-Length: " . filesize('Reports/'.$product.'.xlsx'));
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=report.xlsx');
            readfile('Reports/'.$product.'.xlsx');
            return redirect()->back()->with([
                'success' => "you have generated the report Successfully",
            ]);
        }else{
            return redirect()->back()->with([
                'error' => "No Product was found for $product in the selected companies",
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function submitBreakdown(Request $request)
    {
        $this->validate($request, [
            'rec_email' => ['required', 'string'],
            'quotation_recipient' => ['required'],
            // 'quotation_file' => ['required'],
        ]);
        $rfq_id = $request->input("rfq_id");
        $rfq = $this->model->show($rfq_id);
        $shi = ShipperQuote::where('rfq_id', $rfq_id)->first();
        $ship = Shippers::where("shipper_id", $rfq->shipper_id)->first();
        $shiname = $ship->shipper_name;

        $rec_mail = $request->input("rec_email");
        $quotation_recipient = $request->input("quotation_recipient");
        $extra_note = $request->input('extra_note');

        
        $file = $request->quotation_file;
        $arrFile = array();
        $number = rand(1,200);
        $refrence = $rfq->refrence_no;
        $dest = date('Y'.'d'.'m').$refrence.$number;

        $cut = explode("; ", $quotation_recipient);
        $users = [];

        if (ClientRfq::where('rfq_id', $rfq_id)->exists()) {
            $ref = ClientRfq::where('rfq_id', $rfq_id)->first();
            $rfq = $this->model->show($rfq_id);
            $line_items = LineItem::where(['rfq_id' => $rfq_id])->orderBy('created_at', 'asc')->get();
    
            if (count($line_items) > 0) {
                $pdf = PDF::loadView('dashboard.printing.check', compact('rfq', 'line_items'))->setPaper('a4', 'portrait');
                
            $cli_title = clis($rfq->client_id);
            $resultt = json_decode($cli_title, true);
            $client_name = $resultt[0]['client_name'];
            $assigned_details = empDetails($rfq->employee_id);
            $assigned = $assigned_details->full_name;
            $pdfname = "TAG Energy Quotation TE-" . $resultt[0]['short_code'] . '-RFQ' . preg_replace('/[^0-9]/', '', $rfq->refrence_no) . ", " . $rfq->description;
            $rfqcode = "TE-". $resultt[0]['short_code'] . '-RFQ' . preg_replace('/[^0-9]/', '', $rfq->refrence_no);
            
            // Replace "/" with "-"
            $pdfname = str_replace("/", "-", $pdfname);
     
                // Temporary file path to store the PDF
                $tempFilePath = storage_path($pdfname . '.pdf');
    
                // Save the PDF temporarily
                $pdf->save($tempFilePath);
            }
    
        foreach($cut as $key => $ut){
            $ua = [];
            $ua['email'] = $ut;
            $split = $cut = explode("@", $ut);
            $ua['name'] = strtoupper(str_replace(".","",$split[0]));
            $users[$key] = (object)$ua;
        }
        try{
            
            if ($request->hasFile('quotation_file')) { // Change to 'files' which corresponds to the input field name
                $files = $request->file('quotation_file'); // Get uploaded files
        
                // Array to store temporary file paths
                $tempFileDirs = [];
                // Array to store original file names
                $fileNames = [];
        
            // Save uploaded files temporarily and get file paths
            foreach ($files as $file) {
                // Generate a unique file name
                $fileName = time() . '_' . $file->getClientOriginalName();
                // Move uploaded file to temporary storage path
                $tempFileDir = storage_path('temp') . '/' . $fileName;
                $file->move(storage_path('temp'), $fileName);
                // Store temporary file path in array
                $tempFileDirs[] = $tempFileDir;
                // Store original file name in array
                $fileNames[] = $file->getClientOriginalName();
                }
            }else{
                $tempFileDirs = "";
                $fileNames = "";
            }
            
            $line_items = LineItem::where('rfq_id', $rfq_id)->get();
            $tq = 0;
            foreach($line_items as $line){
                $tq = ($line->quantity * $line->unit_cost) + $tq;
            }
            $data = ["rfq" => $rfq, 'company' => Companies::where('company_id', $rfq->company_id)->first(), 'tq' => $tq, 'shi' => $shi, 'shiname' => $shiname, 'tempFilePath' => $tempFilePath, 'tempFileDirs' => $tempFileDirs, 'fileNames' => $fileNames, 'rfqcode' => $rfqcode, 'extra_note' => $extra_note, 'client_name' => $client_name, 'assigned' => $assigned];
            $when = now()->addMinutes(1);
            Mail::to($rec_mail)->cc(str_replace(" ","",$users))->send( new Submission ($data));        
            if($extra_note != ""){
	        $newNote = date('d/m/Y') .' ' . Auth::user()->first_name . ' '. Auth::user()->last_name .' Sent Request Approval to '. $rec_mail . ' with an extra note stating: '.$extra_note.' and changed the status to Awaiting Approval <br/>'.$rfq->note;
            }else{
            $newNote = date('d/m/Y') .' ' . Auth::user()->first_name . ' '. Auth::user()->last_name .' Sent Request Approval to '. $rec_mail . ' and changed the status to Awaiting Approval <br/>'.$rfq->note;
            }
            DB::table('client_rfqs')->where(['rfq_id' => $rfq_id])->update(['note' => $newNote, 'status' => 'Awaiting Approval']);
            $his = new RfqHistory([
                "user_id" => Auth::user()->user_id,
                "rfq_id" => $rfq_id,
                "action" => "Send Request Approval to $rec_mail",
            ]); $his->save();
            
            unlink($tempFilePath);
            
            // Delete temporary files after email is sent
            if($tempFileDirs != ""){
                foreach ($tempFileDirs as $tempFileDir) {
                    unlink($tempFileDir);
                }
            }
            return redirect()->back()->with("success", "You have sent the approval Successfully.");
        }catch(\Exception $e){

            return redirect()->back()->with("error", "Request Approval not sent, ". $e->getMessage());
        }
   
    }

    }
    
    
    public function submitQuotation(Request $request)
    {
        $this->validate($request, [
            'email' => ['required', 'string'],
            'recipient' => ['required'],
        ]);
        $rfq_id = $request->input("rfq_id");

        $rfq = $this->model->show($rfq_id);
        $line_items = LineItem::where(['rfq_id' => $rfq_id])->orderBy('created_at','asc')->get();

        if(count($line_items) > 0){
            if($rfq->status == 'Breakdown Declined'){
                return redirect()->back()->with("error", "The Breakdown is yet to be approved.");
            }else{
                $rec_mail = $request->input("email");
                $bcc = $request->input("bcc");
                $recipient = $request->input("recipient");
                $file = $request->file;

                $number = rand(1,400);
                $refrence = $rfq->refrence_no;
                $dest = date('Y'.'d'.'m').$refrence.$number;

                $dir = base_path('/email/rfq/'.$rfq->refrence_no.'/');

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
                    $line_items = LineItem::where(['rfq_id' => $rfq_id])->orderBy('created_at','asc')->get();
                    if (count($line_items) > 0) {
                        $pdf = PDF::loadView('dashboard.printing.check', compact('rfq', 'line_items'))->setPaper('a4', 'portrait');
                            
                        $cli_title = clis($rfq->client_id);
                        $resultt = json_decode($cli_title, true);
                        $client_name = $resultt[0]['client_name'];
                        $assigned_details = empDetails($rfq->employee_id);
                        $assigned = $assigned_details->full_name;
                        $pdfname = "TAG Energy Quotation TE-" . $resultt[0]['short_code'] . '-RFQ' . preg_replace('/[^0-9]/', '', $rfq->refrence_no) . ", " . $rfq->description;
                        $rfqcode = "TE-". $resultt[0]['short_code'] . '-RFQ' . preg_replace('/[^0-9]/', '', $rfq->refrence_no);
                        
                        // Replace "/" with "-"
                        $pdfname = str_replace("/", "-", $pdfname);
                 
                            // Temporary file path to store the PDF
                            $tempFilePath = storage_path($pdfname . '.pdf');
                
                            // Save the PDF temporarily
                            $pdf->save($tempFilePath);
                    }
                    
                    if ($request->hasFile('quotation_file')) { 
                        // Change to 'files' which corresponds to the input field name
                        $files = $request->file('quotation_file'); // Get uploaded files
                
                        // Array to store temporary file paths
                        $tempFileDirs = [];
                        // Array to store original file names
                        $fileNames = [];
                
                    // Save uploaded files temporarily and get file paths
                    foreach ($files as $file) {
                        // Generate a unique file name
                        $fileName = time() . '_' . $file->getClientOriginalName();
                        // Move uploaded file to temporary storage path
                        $tempFileDir = storage_path('temp') . '/' . $fileName;
                        $file->move(storage_path('temp'), $fileName);
                        // Store temporary file path in array
                        $tempFileDirs[] = $tempFileDir;
                        // Store original file name in array
                        $fileNames[] = $file->getClientOriginalName();
                        }
                    }else{
                        $tempFileDirs = "";
                        $fileNames = "";
                    }
                    
                    // $inReplyTo = $request->input('message_id');
                    // $references = $request->input('references');
                    $extra_note = $request->input('extra_note');
            // 'inReplyTo' => $inReplyTo, 'references' => $references, 
                    $data = ["rfq" => $rfq, 'dir' => $dir, 'company' => Companies::where('company_id', $rfq->company_id)->first(), 'tempFilePath' => $tempFilePath, 'tempFileDirs' => $tempFileDirs, 'fileNames' => $fileNames, 'rfqcode' => $rfqcode, 'extra_note' => $extra_note];
                    $when = now()->addMinutes(1);
                    $company_id = $rfq->company_id;
                    
                    
                    if(empty($bcc)){
                    Mail::to($rec_mail)->cc(str_replace(" ","",$users))->send( new Quotation ($data));               
                    }else{
                    Mail::to($rec_mail)->cc(str_replace(" ","",$users))->bcc($bcc)->send( new Quotation ($data));
                    }
                    $newNote = date('d/m/Y') .' ' . Auth::user()->first_name . ' '. Auth::user()->last_name .' Sent Quotation  to '. $rec_mail . ' and changed the status to Quotation Submitted <br/><br/>'.$rfq->note;
                    DB::table('client_rfqs')->where(['rfq_id' => $rfq_id])->update(['note' => $newNote, 'status' => 'Quotation Submitted']);
                    $his = new RfqHistory([
                        "user_id" => Auth::user()->user_id,
                        "rfq_id" => $rfq_id,
                        "action" => "Sent Quotation to $rec_mail",
                    ]); $his->save();
                    
                    unlink($tempFilePath);
            
                    // Delete temporary files after email is sent
                    if($tempFileDirs != ""){
                        foreach ($tempFileDirs as $tempFileDir) {
                            unlink($tempFileDir);
                        }
                    }
                    return redirect()->back()->with("success", "Quotation Email was sent to the buyer successfully.");
                }catch(\Exception $e){
                    return redirect()->back()->with("error", "Email not sent, ". $e->getMessage());
                }

            }
        }else{
            return redirect()->back()->with([
                'error' => "No Line Items was found for this RFQ",
            ]);
        }

    }
    
    
    public function downloadQuote($rfq_id)
    {
        if(ClientRfq::where('rfq_id', $rfq_id)->exists()){ 
            $rfq = $this->model->show($rfq_id);
            $line_items = LineItem::where(['rfq_id' => $rfq_id])->orderBy('created_at','asc')->get();
            if(count($line_items) > 0){
                return view('dashboard.rfq.viewPDF')->with([
                    'rfq' => $rfq, 'line_items' => $line_items,
                ]);
            }else{
                return redirect()->back()->with([
                    'error' => "No Line Items was found for this RFQ",
                ]);
            }
        }else{
            return redirect()->back()->with([
            'error' => "$id does not Exist for any RFQ",
            ]);
        }

    }
    

    public function approveReason($refrence_no)
    {
        if(ClientRfq::where('refrence_no', $refrence_no)->exists()){
            if (Gate::allows('SuperAdmin', auth()->user()) OR (Auth::user()->hasRole('Admin')) OR (Auth::user()->hasRole('HOD'))){
                $rfq = ClientRfq::where('refrence_no', $refrence_no)->first();
                return view('dashboard.rfq.approve')->with([
                    'refrence_no' => $refrence_no, 'rfq' => $rfq,
                    'success' => 'Please enter the note for the Approval',
                ]);
            }else{
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

    public function approveBreakdown(Request $request)
    {
        $this->validate($request, [
            'refrence_no' => ['required', 'string'],
            'reason' => ['required', 'string'],
        ]);

        $refrence_no = $request->input('refrence_no');
        $reason = $request->input('reason');
            
        if(ClientRfq::where('refrence_no', $refrence_no)->exists()){
            if (Gate::allows('SuperAdmin', auth()->user()) OR (Auth::user()->hasRole('Admin')) OR (Auth::user()->hasRole('HOD'))){
                $rfq = ClientRfq::where('refrence_no', $refrence_no)->first();
                $cli_title = clis($rfq->client_id);
                $resultt = json_decode($cli_title, true);
                $client_name = $resultt[0]['client_name'];
                $assigned_details = empDetails($rfq->employee_id);
                $assigned = $assigned_details->full_name;
                $rfqcode = "TE-". $resultt[0]['short_code'] . '-RFQ' . preg_replace('/[^0-9]/', '', $rfq->refrence_no);
                $emp = Employers::where('employee_id', $rfq->employee_id)->first();
                $newNote = date('d/m/Y') .' ' . Auth::user()->first_name . ' '. Auth::user()->last_name. " Changed the Status to Breakdown Approved, The Reason for Approval: <b> $reason  </b>" . ' <br>'.$rfq->note;
                DB::table('client_rfqs')->where(['rfq_id' => $rfq->rfq_id])->update(['note' => $newNote, "status" => 'Breakdown Approved',]);
                $his = new RfqHistory([
                    "user_id" => Auth::user()->user_id,
                    "rfq_id" => $rfq->rfq_id,
                    "action" => "Approved Breakdown for ".$refrence_no,
                ]); $his->save();
                $data = ['rfq' => $rfq, 'reason' => $reason, 'status' => 'Approved', 'company' => Companies::where('company_id', $rfq->company_id)->first(), 'assigned' => $assigned, 'rfqcode' => $rfqcode];
                // dd($data);
                Mail::to($emp->email)->cc(['contact@tagenergygroup.net', 'sales@tagenergygroup.net'])->send( new ApproveBreakdown ($data));   
                return redirect()->route('rfq.edit', [$refrence_no])->with([
                    'refrence_no' => $refrence_no,
                    'success' => 'You have approved the breakdown for approval successfully',
                ]);
            }else{
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

    public function disapproveReason($refrence_no)
    {
        if(ClientRfq::where('refrence_no', $refrence_no)->exists()){
            if (Gate::allows('SuperAdmin', auth()->user()) OR (Auth::user()->hasRole('Admin')) OR (Auth::user()->hasRole('HOD'))){
                $rfq = ClientRfq::where('refrence_no', $refrence_no)->first();
                return view('dashboard.rfq.disapprove')->with([
                    'refrence_no' => $refrence_no, 'rfq' => $rfq,
                    'success' => 'Please enter the reason for the Disapproval',
                ]);
            }else{
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

    public function disapproveBreakdown(Request $request)
    {
        $this->validate($request, [
            'refrence_no' => ['required', 'string'],
            'reason' => ['required', 'string'],
        ]);

        $refrence_no = $request->input('refrence_no');
        $reason = $request->input('reason');
        if(ClientRfq::where('refrence_no', $refrence_no)->exists()){
            if (Gate::allows('SuperAdmin', auth()->user()) OR (Auth::user()->hasRole('Admin')) OR (Auth::user()->hasRole('HOD'))){
                $rfq = ClientRfq::where('refrence_no', $refrence_no)->first();
                $cli_title = clis($rfq->client_id);
                $resultt = json_decode($cli_title, true);
                $client_name = $resultt[0]['client_name'];
                $assigned_details = empDetails($rfq->employee_id);
                $assigned = $assigned_details->full_name;
                $rfqcode = "TE-". $resultt[0]['short_code'] . '-RFQ' . preg_replace('/[^0-9]/', '', $rfq->refrence_no);
                $emp = Employers::where('employee_id', $rfq->employee_id)->first();
                $newNote = date('d/m/Y') .' ' . Auth::user()->first_name . ' '. Auth::user()->last_name. " Changed the Status to Breakdown Not Approved, The Reason for Not Approving: <b> $reason  </b>" . ' <br>'.$rfq->note;
                DB::table('client_rfqs')->where(['rfq_id' => $rfq->rfq_id])->update(['note' => $newNote, "status" => 'Breakdown Not Approved',]);
                $his = new RfqHistory([
                    "user_id" => Auth::user()->user_id,
                    "rfq_id" => $rfq->rfq_id,
                    "action" => "Not Approved Breakdown for ".$refrence_no,
                ]); $his->save();
                $data = ['rfq' => $rfq, 'reason' => $reason, 'status' => 'Not Approved', 'company' => Companies::where('company_id', $rfq->company_id)->first(), 'assigned' => $assigned, 'rfqcode' => $rfqcode];
                Mail::to($emp->email)->cc(['contact@tagenergygroup.net', 'sales@tagenergygroup.net'])->send( new ApproveBreakdown ($data));   
                return redirect()->route('rfq.edit', [$refrence_no])->with([
                    'refrence_no' => $refrence_no,
                    'success' => 'You have Not Approved the breakdown successfully',
                ]);
            }else{
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

    public function printPriceQuote($refrence_no)
    {
        if(ClientRfq::where('refrence_no', $refrence_no)->exists()){
            $ref = ClientRfq::where('refrence_no', $refrence_no)->first();
            $rfq = $this->model->show($ref->rfq_id);
            $line_items = LineItem::where(['rfq_id' => $ref->rfq_id])->orderBy('created_at','asc')->get();
            if(count($line_items) > 0){
                
                $pdf = PDF::loadView('dashboard.printing.check', compact('rfq', 'line_items'))->setPaper('a4', 'portrait');
                $fileName = "TAG Energy Quotation " .$rfq->refrence_no . ", ". $rfq->description.'.pdf';

                return $pdf->stream();
                
            }else{
                return redirect()->back()->with(['error' => "No Line Items was found"]);
            }
        }else{
            return redirect()->back()->with([
            'error' => "$refrence_no does not Exist for any RFQ",
            ]);
        }
    }
    
    public function printBHAQuote($refrence_no)
    {
        if(ClientRfq::where('refrence_no', $refrence_no)->exists()){
            $ref = ClientRfq::where('refrence_no', $refrence_no)->first();
            $rfq = $this->model->show($ref->rfq_id);
            $line_items = LineItem::where(['rfq_id' => $ref->rfq_id])->orderBy('created_at','asc')->get();
            if(count($line_items) > 0){
                
                $pdf = PDF::loadView('dashboard.printing.bha', compact('rfq', 'line_items'))->setPaper('a4', 'portrait');
                $fileName = "BHA Quotation " .$rfq->refrence_no . ", ". $rfq->description.'.pdf';

                return $pdf->stream();
                
            }else{
                return redirect()->back()->with(['error' => "No Line Items was found"]);
            }
        }else{
            return redirect()->back()->with([
            'error' => "$refrence_no does not Exist for any RFQ",
            ]);
        }
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'client_id' => ['required', 'string', 'max:199'],
            'company_id' => ['required', 'string', 'max:199'],
            'status' => ['required', 'string', 'max:200'],
            'employee_id' => ['required', 'string', 'max:199'],
            'refrence_number' => ['required', 'string', 'max:199'],
            'rfq_date' => ['required', 'string', 'max:199'],
            'rfq_number' => ['required', 'string', 'max:199'],
            'description' =>['required', 'string'],
            'product' => ['required', 'string', 'max:199'],
            'contact_id' => ['required', 'string', 'max:199'],

            'delivery_due_date' => ['required', 'string', 'max:199'],
            'note' => ['required', 'string'],
            'vendor_id' => ['required', 'string'],
            'online_submission' => ['required', 'string'],
        ]);
        
        $new = 1;
        $date = date('dmy');
        //$former_number = RfqNumbers::max('numbers')->first();
        //$new_ref = $former_number + 1;
        $new_rfq = ClientRfq::count();
        $new_ref = $new_rfq + 1;
        if(RfqNumbers::where(['numbers' => $new_ref, 'rfq' => 'RFQ'])->exists()){

            // $bring = RfqNumbers::where(['numbers' => $date, 'rfq' => 'RFQ'])->orderBy('id', 'desc')->first();
            // $new = $bring->rfq_number + 1;
            // $numbs = new RfqNumbers([
            //     "numbers" => $new_rfq,
            //     "rfq" => 'RFQ',
            //     "rfq_number" => $new,
            // ]);
            // $numbs->save();
        }else{
            $new = 1;
            $numbs = new RfqNumbers([
                "numbers" => $new_ref,
                "rfq" => 'RFQ',
                "rfq_number" => $new,
            ]);$numbs->save();
        }

        if(Str::length($new) < 2){
            $conc = '00'.$new;
        }elseif(Str::length($new) == 2){
            $conc = '0'.$new;
        }else{
            $conc = $new;
        }

        $cli = Clients::where('client_id', $request->input('client_id'))->first();
        $refrence_number = substr($request->input("refrence_number"), 0, -4).''.$new_ref;
        // dd($refrence_number);
        $data = new ClientRfq([
            "client_id" => $request->input("client_id"),
            "company_id" => $request->input("company_id"),
            "status" => $request->input("status"),
            "employee_id" => $request->input("employee_id"),
            "refrence_no" => $request->input("refrence_number"),
            "rfq_date" =>   $request->input("rfq_date"),
            "rfq_number" =>$request->input("rfq_number"),
            "product" => $request->input("product"),
            "description" => $request->input("description"),
            "value_of_quote_usd" => 1,
            "value_of_quote_ngn" => 1,
            "freight_charges" => 0,
            "local_delivery" => 0,
            "fund_transfer" => 0,
            "cost_of_funds" => 0,
            "wht" => 0,
            "ncd" => 0,
            "other_cost" => 0,
            "net_value" => 0,
            "net_percentage" => 1,
            "total_weight" => 0,
            "contact_id" => $request->input("contact_id"),
            "shipper_id" => $request->input("shipper_id"),
            "delivery_due_date" => $request->input("delivery_due_date"),
            "note" => $request->input("note"),
            "contract_po_value_usd" => 0,
            "percent_margin" => 0,
            "shipper_mail" => "NO",
            "shipper_submission_date" => $request->input("shipper_submission_date"),
            "supplier_quote_usd" => 0,
            "vendor_id" => $request->input('vendor_id'),
            "oversized" => 'NO',
            "intrest_rate" => 0,
            "duration" => 0,
            "intrest_logistics" =>0,
            "duration_logistics" => 0,
            "online_submission" => $request->input("online_submission"),
            "currency" => 'USD', 'contract_po_value_ngn' => 0,
            "fund_transfer_charge" => 0, 'vat_transfer_charge' => 0, 'offshore_charges' => 0, 'swift_charges' => 0,
            "shipper_currency" => 'NGN',  'freight_cost_option' => 'NO',
            'end_user' => 'N/A', 
            'clearing_agent' => 'N/A',
            'short_code' =>$date.$new_ref,
        ]);

        $log = new Log([
            "user_id" => Auth::user()->user_id,
            "activities" => 'Added RFQ ' . $request->input('rfq_number') . ' details ',
        ]);

        if($data->save()){
            $rfq_id = $data->rfq_id;
            if($request->hasFile('document')) {
                $file = $request->document;

                foreach ($file as $files) {
                    $filenameWithExt = $files->getClientOriginalName();
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    $extension = $files->getClientOriginalExtension();
                    $fileNameToStore = $filename.'_'.time().'.'.$extension;
                    if (!file_exists('document/rfq/'.$rfq_id.'/')) {
                        $dir = mkdir('document/rfq/'.$rfq_id.'/');
                    }else{
                        $dir = 'document/rfq/'.$rfq_id.'/';
                    }

                    //Offline
                    $path=$files->move(base_path('document/rfq/'.$rfq_id.'/'), $fileNameToStore);
                    //Online
                    // $path=$files->move(('document/rfq/'.$rfq_id.'/'), $fileNameToStore);
                    $conc = ClientContact::where('contact_id', $request->input("contact_id"))->first();
                    $emp = Employers::where('employee_id', $request->input("employee_id"))->first();
                }
                $log->save();

            }
            $conc = ClientContact::where('contact_id', $request->input("contact_id"))->first();
            $emp = Employers::where('employee_id', $request->input("employee_id"))->first();
            $arr = [
                "conc" => $conc,
                "emp" => $emp,
                "rfq" => $this->model->show($rfq_id)
            ];
            // $conc->notify(new ClientContactRfqCreated($arr));

            $emp->notify(new EmployerRFQCreated($arr));

            $his = new RfqHistory([
                "user_id" => Auth::user()->user_id,
                "rfq_id" => $rfq_id,
                "action" => "Created RFQ for " .$cli->client_name . " and Assigned The RFQ to ". $emp->full_name,
            ]); $his->save();
            $rfq = $this->model->show($rfq_id);
            $vendor = Vendors::where('company_id', $rfq->company_id)->orderBy('vendor_name', 'asc')->get();

            $sups = new ShipperQuote([
                "rfq_id" => $rfq_id,
                "customs_duty" => 0,
                "clearing_and_documentation" => 0,
                "bmi_charges" => 0,
                "soncap_charges" => 0,
                "trucking_cost" => 0,
                "shipper_id" => $request->input("shipper_id"),
                "status" => 'Submitted',
                "mode" => 'Air',
                "currency" => 'NGN'
            ]);
            $sups->save();
            // dd($savedRfq);
            $rfqDir = base_path("email/rfq/$refrence_number/");
            $poDir = base_path("email/po/$refrence_number/");
            
            if (!is_dir($rfqDir)) {
                mkdir($rfqDir, 0777, true);
            }
            
            if (!is_dir($poDir)) {
                mkdir($poDir, 0777, true);
            }
            return redirect()->route("line.create",[$rfq->rfq_id])->with("success", "You Have Added The RQF Successfully, Please Kindly Create the Line Item Below");

        } else {
            return redirect()->back()->with("error", "Network Failure");
        }


    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($refrence_no)
    {
        if(ClientRfq::where('refrence_no', $refrence_no)->exists()){
            if (Gate::allows('SuperAdmin', auth()->user()) OR (Auth::user()->hasRole('Admin'))){
                $refrence = ClientRfq::where('refrence_no', $refrence_no)->first();
                $details = $this->model->show($refrence->rfq_id);

                $clienting = Clients::where('client_id', $details->client_id)->first();
                $company_id = $clienting->company_id;
                $company = Companies::where('company_id',$company_id)->get();

                $employer = Employers::where('company_id', $company_id)->orderBy('full_name', 'asc')->get();
                $rfq = ClientRfq::where('company_id', $company_id)->orderBy('created_at','desc')->get();
                $client = ClientContact::where('client_id', $details->client_id)->orderBy('first_name', 'asc')->get();
                $shipper = Shippers::where('company_id', $company_id)->orderBy('shipper_name', 'asc')->get();
                return view('dashboard.rfq.details')->with([
                    'employer' => $employer, "rfq" => $rfq, "company" => $company, "client" => $client, "shipper" => $shipper, "clienting" => $clienting,
                    'details' => $details
                ]);
            }elseif(Auth::user()->hasRole('Employer') OR (Auth::user()->hasRole('Contact')) OR (Auth::user()->hasRole('Client'))
            OR (Auth::user()->hasRole('HOD')) OR (Auth::user()->hasRole('Shipper'))){
                $refrence = ClientRfq::where('refrence_no', $refrence_no)->first();
                // dd($refrence);
                $details = $this->model->show($refrence->rfq_id);
                return view('dashboard.rfq.details')->with([

                    'details' => $details
                ]);

            }else{

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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($refrence_no)
    {
        if(ClientRfq::where('refrence_no', $refrence_no)->exists()){
                $refrence = ClientRfq::where('refrence_no', $refrence_no)->first();
                $details = $this->model->show($refrence->rfq_id);
            // dd($details);
            $status = ScmStatus::where('type', 'RFQ')->orderBy('name', 'asc')->get();
            $supply = SupplierQuote::where('rfq_id', $refrence->rfq_id)->get();
            $che = ShipperQuote::where('rfq_id', $refrence->rfq_id)->get();

            $line_items = LineItem::where('rfq_id', $details->rfq_id)->get();
            $tq = 0;
            foreach($line_items as $line){
                $tq = ($line->quantity * $line->unit_cost) + $tq;
            }

            // $sup = SupplierQUote::where('vendor_id', $vendor->vendor_id)->get();

            if(count($che) > 0){
                $ship = ShipperQuote::where('rfq_id', $refrence->rfq_id)->first();
                $shipperQuote = $ship->soncap_charges + $ship->customs_duty +  $ship->clearing_and_documentation +  $ship->trucking_cost + $ship->bmi_charges;
            }else{
                $shipperQuote = 0;
            }
            // dd($total);

            if(count($supply) > 0){
                $supplier_quote = DB::table('supplier_quotes')->where('rfq_id', $refrence->rfq_id)->sum('price');
            }else{
                $supplier_quote = 0;
            }
	    if (Gate::allows('SuperAdmin', auth()->user()) OR (Auth::user()->hasRole('Admin'))){

                $clienting = Clients::where('client_id', $details->client_id)->first();
                $company_id = $clienting->company_id;
                $company = Companies::where('company_id',$company_id)->get();
                $employer = Employers::where('company_id', $company_id)->orderBy('full_name', 'asc')->get();
                $rfq = ClientRfq::where('company_id', $company_id)->orderBy('created_at','desc')->get();
                $contact = ClientContact::where('client_id', $details->client_id)->orderBy('first_name', 'asc')->get();
                $shipper = Shippers::where('company_id', $company_id)->orderBy('shipper_name', 'asc')->orWhere('shipper_name', 'Test Shipper')->get();
                $vendor = Vendors::where('company_id', $company_id)->orderBy('vendor_name', 'asc')->orWhere('vendor_name', 'TEST VENDOR')->get();
                return view('dashboard.rfq.edit')->with([ 'vendor' => $vendor,
                    'employer' => $employer, "rfq" => $rfq, "company" => $company, "contact" => $contact, "shipper" => $shipper, "clienting" => $clienting, 'details' => $details, "status" => $status, "supplier_quote" => $supplier_quote, "che" => $che, "shipperQuote" => $shipperQuote, "tq" => $tq
                ]);
            }elseif(Auth::user()->hasRole('Client')){

                $clienting = Clients::where('email', Auth::user()->email)->first();
                $company_id = $clienting->company_id;
                $company = Companies::where('company_id',$company_id)->get();
                $employer = Employers::where('company_id', $company_id)->orderBy('full_name', 'asc')->get();
                $contact = ClientContact::where('client_id', $clienting->client_id)->orderBy('first_name', 'asc')->get();
                $shipper = Shippers::where('company_id', $company_id)->orderBy('shipper_name', 'asc')->orWhere('shipper_name', 'Test Shipper')->get();
                $vendor = Vendors::where('company_id', $company_id)->orderBy('vendor_name', 'asc')->orWhere('vendor_name', 'TEST VENDOR')->get();
                return view('dashboard.rfq.edit')->with([ 'vendor' => $vendor,
                    'employer' => $employer, "company" => $company, "contact" => $contact, "shipper" => $shipper, "clienting" => $clienting, 'details' => $details,  "status" => $status, "supplier_quote" => $supplier_quote, "che" => $che, "shipperQuote" => $shipperQuote, "tq" => $tq
                ]);
            }elseif((Auth::user()->hasRole('Employer')) OR (Auth::user()->hasRole('HOD'))){

                $employ = Employers::where('email', Auth::user()->email)->first();
                $company = Companies::where('company_id', $employ->company_id)->first();
                $company_id = $company->company_id;
                $employer = Employers::where('company_id', $company_id)->orderBy('full_name', 'asc')->get();
                $contact = ClientContact::where('client_id', $details->client_id)->orderBy('first_name', 'asc')->get();
                $shipper = Shippers::where('company_id', $company_id)->orderBy('shipper_name', 'asc')->orWhere('shipper_name', 'Test Shipper')->get();
                $clienting = Clients::where('client_id', $details->client_id)->first();
                $vendor = Vendors::where('company_id', $company_id)->orderBy('vendor_name', 'asc')->orWhere('vendor_name', 'TEST VENDOR')->get();
                return view('dashboard.rfq.edit')->with([ 'vendor' => $vendor,
                    'employer' => $employer, "company" => $company, "contact" => $contact, "shipper" => $shipper,
                    'details' => $details,  "status" => $status, "clienting" => $clienting, "supplier_quote" => $supplier_quote, "che" => $che, "shipperQuote" => $shipperQuote, "tq" => $tq
                ]);
            }else{

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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function update(Request $request, $refrence_no)
        {
        // if (Gate::allows('SuperAdmin', auth()->user()) OR (Auth::user()->hasRole('Admin'))  OR (Auth::user()->hasRole('Client'))){
            $refrence = ClientRfq::where('refrence_no', $refrence_no)->first();
            $details = $this->model->show($refrence->rfq_id);
            $this->validate($request, [
                'client_id' => ['required', 'string', 'max:199'],
                'company_id' => ['required', 'string', 'max:199'],
                'status' => ['required', 'string', 'max:200'],
                'employee_id' => ['required', 'string', 'max:199'],
                'refrence_number' => ['required', 'string', 'max:199'],
                'rfq_date' => ['required', 'string', 'max:199'],
                'rfq_number' => ['required', 'string', 'max:199'],
                'description' =>['required', 'string'],
                'product' => ['required', 'string', 'max:199'],

                'freight_charges' => ['required', 'string', 'max:199'],
                'local_delivery' => ['required', 'string', 'max:199'],
                'shipper_id' => ['required', 'string', 'max:199'],
                'cost_of_funds' => ['required', 'string', 'max:199'],
                'wht' => ['required', 'string', 'max:199'],
                'ncd' => ['required', 'string', 'max:199'],
                'other_cost' => ['required', 'string', 'max:199'],
                'net_value' => ['required', 'string', 'max:200'],
                'net_percentage' => ['required', 'string', 'max:199'],
                'percent_margin' => ['required', 'string', 'max:199'],
                'total_weight' =>['required', 'string', 'max:199'],
                'contact_id' => ['required', 'string', 'max:199'],
                'freight_cost_option' => ['required', 'string', 'max:199'],
                'delivery_due_date' => ['required', 'string', 'max:199'],
                'note' => ['required', 'string'],
                'vendor_id' => ['required', 'string'],
                'online_submission' => ['required', 'string'],
                'currency' => ['required', 'string'],
                'fund_transfer_charge' => ['required', 'string'],
                'vat_transfer_charge' => ['required', 'string'],
                'offshore_charges' => ['required', 'string'],
                'swift_charges' => ['required', 'string'],
                'send_image' => ['required', 'string', 'max:3'],

            ]);
            $lumpsum_checkbox = $request->input('lumpsum_checkbox');
            $custom = $request->input('customs_duty');
            $clearing = $request->input("clearing_and_documentation");
            $soncap = $request->input("soncap_charges");
            $trucking = $request->input("trucking_cost");
            $shipper_currency = $request->input("shipper_currency");
            

            // Check if the "lumpsum" checkbox is checked
            if ($request->has('lumpsum_checkbox') && $lumpsum_checkbox == 1) {
                $lumpsum = $request->input("lumpsum"); // Get the lumpsum value from the request
                $loc = $lumpsum; // If checked, use lumpsum value
            } else {
                $lumpsum_checkbox = 0;
                $lumpsum = NULL; // Otherwise, sum of other charges
                $loc = $soncap + $trucking + $custom + $clearing;
            }

            $subTotalCost = $request->input("supplier_quote") + $request->input("freight_charges") + $request->input("other_cost") + $loc;
            $fund_transfer_charge = $request->input("fund_transfer_charge");
            $vat_transfer_charge = $request->input("vat_transfer_charge");
            $offshore_charges = $request->input("offshore_charges");
            $swift_charges =  $request->input("swift_charges");
            $fundTransfer = $request->input("fund_transfer");
            if($request->input("client_id") == 114){
                $newWht = $request->input("wht");
		        $newNcd = $request->input("ncd");
            }else{
                $newWht = $request->input("wht");
                $newNcd = $request->input("ncd");
            }
            
	        $percent = $request->input("intrest_percent");
	        $intrest = $request->input("intrest_rate");
            $duration = $request->input("duration");

            $supplier_cof = [];

            // Loop through one of the arrays (assuming they have the same length)
            foreach ($percent as $key => $sp_cof) {
                // Check if the corresponding index exists in the other array
                if (isset($intrest[$key])) {
                    // Add the values to the data array
                    $supplier_cof[] = [
                        'percent' => $sp_cof,
                        'interest' => $intrest[$key],
                        'duration' => $duration[$key]
                    ];
                }
            }

	        $percent_logistics = $request->input("percent_logistics");
            $intrest_logistics = $request->input("intrest_logistics");
            $duration_logistics = $request->input("duration_logistics");
            $costOfFunds =$request->input("cost_of_funds");

            $logistics_cof = [];

            // Loop through one of the arrays (assuming they have the same length)
            foreach ($percent_logistics as $key => $lg_cof) {
                // Check if the corresponding index exists in the other array
                if (isset($intrest_logistics[$key])) {
                    // Add the values to the data array
                    $logistics_cof[] = [
                        'percent' => $lg_cof,
                        'interest' => $intrest_logistics[$key],
                        'duration' => $duration_logistics[$key]
                    ];
                }
            }
            
            $percent_others = $request->input("percent_others");
            $intrest_others = $request->input("intrest_others");
            $duration_others = $request->input("duration_others");

            $others_cof = [];

            // Loop through one of the arrays (assuming they have the same length)
            foreach ($percent_others as $key => $ot_cof) {
                // Check if the corresponding index exists in the other array
                if (isset($intrest_others[$key])) {
                    // Add the values to the data array
                    $others_cof[] = [
                        'percent' => $ot_cof,
                        'interest' => $intrest_others[$key],
                        'duration' => $duration_others[$key]
                    ];
                }
            }
            

            // Assuming you have retrieved the values from the form
            $miscCostSupplierValues = $_POST['misc_cost_supplier'];
            $miscAmountSupplierValues = $_POST['misc_amount_supplier'];

            // Create an array to hold the values
            $data_supplier = [];

            // Loop through one of the arrays (assuming they have the same length)
            foreach ($miscCostSupplierValues as $key => $costValue) {
                // Check if the corresponding index exists in the other array
                if (isset($miscAmountSupplierValues[$key])) {
                    // Add the values to the data array
                    $data_supplier[] = [
                        'desc' => $costValue,
                        'amount' => $miscAmountSupplierValues[$key],
                    ];
                }
            }

            // Assuming you have retrieved the values from the form
            $logisticsCostSupplierValues = $request->input('misc_cost_logistics');
            $logisticsAmountSupplierValues = $request->input('misc_amount_logistics');

            // Create an array to hold the values
            $data_logistics = [];

            // Loop through one of the arrays (assuming they have the same length)
            foreach ($logisticsCostSupplierValues as $key => $costValue) {
                // Check if the corresponding index exists in the other array
                if (isset($logisticsAmountSupplierValues[$key])) {
                    // Add the values to the data array
                    $data_logistics[] = [
                        'desc' => $costValue,
                        'amount' => $logisticsAmountSupplierValues[$key],
                    ];
                }
            }
            
            // Assuming you have retrieved the values from the form
            $othersCostSupplierValues = $request->input('misc_cost_others');
            $othersAmountSupplierValues = $request->input('misc_amount_others');

            // Create an array to hold the values
            $data_others = [];

            // Loop through one of the arrays (assuming they have the same length)
            foreach ($othersCostSupplierValues as $key => $otherValue) {
                // Check if the corresponding index exists in the other array
                if (isset($othersAmountSupplierValues[$key])) {
                    // Add the values to the data array
                    $data_others[] = [
                        'desc' => $otherValue,
                        'amount' => $othersAmountSupplierValues[$key],
                    ];
                }
            }

            $Json_supplier = json_encode($data_supplier);
            $Json_logistics = json_encode($data_logistics);
            $Json_others = json_encode($data_others);
            $json_supplier_cof = json_encode($supplier_cof);
            $json_logistics_cof = json_encode($logistics_cof);
            $json_others_cof = json_encode($others_cof);

            
            if($request->input("currency") == 'USD'){
                $total_dollar_quote = $request->input("total_quote");
                $total_naira_quote = 0;
            }elseif($request->input("currency") == 'NGN'){
                $total_dollar_quote = 0;
                $total_naira_quote = $request->input("total_quote");
            }else{
                $total_dollar_quote = $request->input("total_quote");
                $total_naira_quote = 0;
            }

            $data = ([
                "rfq" => $this->model->show($refrence->rfq_id),
                "client_id" => $request->input("client_id"),
                "company_id" => $request->input("company_id"),
                "status" => $request->input("status"),
                "employee_id" => $request->input("employee_id"),
                "refrence_no" => $refrence_no,
                "rfq_date" => $request->input("rfq_date"),
                "rfq_number" => $request->input("rfq_number"),
                "product" => $request->input("product"),
                "is_lumpsum" => $lumpsum_checkbox,
                "lumpsum" => $request->input("lumpsum"),
                "description" => $request->input("description"),
                "value_of_quote_usd" => $total_dollar_quote,
                "value_of_quote_ngn" => $total_naira_quote,

                "freight_charges" => $request->input("freight_charges"),
                "local_delivery" => $loc,
                "fund_transfer" => $request->input("fund_transfer"),
                "cost_of_funds" => $request->input("cost_of_funds"),
                "wht" => $request->input("wht"),
                "ncd" => $request->input("ncd"),
                "other_cost" => $request->input("other_cost"),
                "net_value" => $request->input("net_value"),
                "net_percentage" => $request->input("net_percentage"),
                "total_weight" => $request->input("total_weight"),
                "contact_id" => $request->input("contact_id"),
                "shipper_id" => $request->input("shipper_id"),
                "delivery_due_date" => $request->input("delivery_due_date"),
                "note" => $request->input("note"),
                "contract_po_value_usd" => $request->input("total_quote") * $request->input("rate"),
                "total_quote" => $request->input("total_quote"),
                "incoterm" => $request->input("incoterm"),
                "percent_margin" => $request->input("percent_margin"),
                "percent_net" => $request->input("net_percentage_margin"),
                "shipper_mail" => $request->input("shipper_mail"),
                "shipper_submission_date" => $request->input("shipper_submission_date"),
                "supplier_quote_usd" => $request->input("supplier_quote"),
                "transport_mode" => $request->input("transport_mode"),
                "estimated_package_weight" => $request->input("estimated_package_weight"),
                "estimated_package_dimension" => $request->input("estimated_package_dimension"),
                "hs_codes" => $request->input("hs_codes"),
                "estimated_delivery_time" => $request->input("estimated_delivery_time"),
                "certificates_offered" => $request->input("certificates_offered"),
                "validity" => $request->input("validity"),
                "delivery_location" => $request->input("delivery_location"),
                "payment_term" => $request->input("payment_term"),
                "technical_note" => $request->input("technical_note"),
                "vendor_id" => $request->input('vendor_id'),
                "oversized" => $request->input('oversized'),
                "supplier_cof" => $json_supplier_cof,
                "logistics_cof" => $json_logistics_cof,
                "others_cof" => $json_others_cof,
                "misc_cost_supplier" => $Json_supplier,
                "misc_cost_logistics" => $Json_logistics,
                "misc_cost_others" => $Json_others,
                "online_submission" => $request->input("online_submission"),
                "currency" => $request->input("currency"),
                "fund_transfer_charge" => $request->input("fund_transfer_charge"),
                'vat_transfer_charge' => $request->input("vat_transfer_charge"),
                'offshore_charges' =>  $request->input("offshore_charges"),
                'swift_charges' => $request->input("swift_charges"),
                "send_image" => $request->input("send_image"),
                'contract_po_value_ngn' => $details->contract_po_value_ngn,

                "shipper_currency" => $shipper_currency,
                'freight_cost_option' => $request->input("freight_cost_option"),
                'end_user' => $request->input("end_user"), 
                'clearing_agent' => $request->input("clearing_agent"),

                'short_code' =>$refrence->short_code,
                'mark_up' =>$request->input("mark_up"),
                'auto_calculate' =>$request->input("auto_calculate") ?? 0,
                'ncd_others' =>$request->input("ncd_others") ?? 0,
            ]);
            // dd($data);

            $log = new Log([
                "user_id" => Auth::user()->user_id,
                "activities" => 'Updated RFQ ' . $refrence_no . ' details ',
            ]);


            function generateRandomHash($length)
            {
                return strtoupper(substr(md5(uniqid(rand())), 0, (-32 + $length)));
            }
            $po_number = preg_replace("/[^0-9]/", "", $refrence_no);
            $cal = ($request->input("percent_margin") * 100);
            $unitMar = $cal / 100 * sumTotalQuote($details->rfq_id);

            if($this->model->update($data, $details->rfq_id)){

                $rfq_id = $details->rfq_id;
                $lok = LineItem::where('rfq_id', $details->rfq_id)->get();
                $oldNote = $request->input('note');
                $auto_calculate = $request->input('auto_calculate');
                
                if($refrence->status != $request->input('status')){
                $newNote = date('d/m/Y') .' ' . Auth::user()->first_name . ' '. Auth::user()->last_name .' Changed the RFQ Status to '. $request->input('status') . '. <br> <br/>'. $oldNote;
                }else{
                    $newNote = $oldNote;
                }
                DB::table('client_rfqs')->where(['rfq_id' => $rfq_id])->update(['note' => $newNote]);

                if ($auto_calculate == 1){
                foreach($lok as $slow){
                    $unitCost = $slow->unit_cost;
                    $unitMargin= $slow->unit_margin;
                    $newUnitMargin = $request->input("mark_up") * $slow->unit_cost;
                    
                    $low = LineItem::where('line_id', $slow->line_id)->update([
                        "unit_frieght" =>$request->input("percent_margin"),
                        "unit_margin" => $newUnitMargin,
                        "unit_quote" => $newUnitMargin + $unitCost,
                        "total_margin" => $newUnitMargin * $slow->quantity,
                        "total_quote" => ($newUnitMargin + $unitCost) * $slow->quantity,
                        "vendor_id" => $request->input("vendor_id"),
                    ]);
                }
            }
                $grossMargin = sumTotalQuote($details->rfq_id) - $request->input("supplier_quote");
                $adding = $request->input("supplier_quote") + $request->input("freight_charges") + $loc + $request->input("fund_transfer") + $request->input("cost_of_funds") + $request->input("other_cost") + $request->input("wht") + $request->input("ncd");

                $upd = ClientRfq::where('rfq_id', $details->rfq_id)->update([
                    "value_of_quote_ngn" => sumTotalQuote($details->rfq_id),
                    "net_percentage" => $request->input("net_percentage"),
                    "net_value" => $request->input("net_value"),
                ]);

                if($request->hasFile('document')) {
                    $file = $request->document;
                    foreach ($file as $files) {
                        $filenameWithExt = $files->getClientOriginalName();
                        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                        $extension = $files->getClientOriginalExtension();
                        $fileNameToStore = $filename.'_'.time().'.'.$extension;
                        if (!file_exists('document/rfq/'.$rfq_id.'/')) {
                            $dir = mkdir('document/rfq/'.$rfq_id.'/');
                        }else{
                            $dir = 'document/rfq/'.$rfq_id.'/';
                        }
			            $path=$files->move(('document/rfq/'.$rfq_id.'/'), $fileNameToStore);

                    }
                    $log->save();
                }

                if($request->hasFile('images')) {
                    $img = $request->images;
                    foreach ($img as $filing) {
                        $filenameWithExt = $filing->getClientOriginalName();
                        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                        $extension = $filing->getClientOriginalExtension();
                        $ext = array('png', 'PNG', 'jpg', 'jpeg', 'JPG', 'JPEG', 'svg', 'SVG');
                        if (in_array($extension, $ext))
                        {
                            $fileNameToStore = $filename.'_'.time().'.'.$extension;
                            if (!file_exists('document/rfq/files/'.$rfq_id.'/')) {
                                $dir = mkdir('document/rfq/files/'.$rfq_id.'/');
                            }else{
                                $dir = 'document/rfq/files/'.$rfq_id.'/';
                            }
                            $path=$filing->move(('document/rfq/files/'.$rfq_id.'/'), $fileNameToStore);
                        }else{
                            return redirect()->back()->with("error", "The Selected file $filenameWithExt is not an image");
                        }
                    }
                    $log->save();
                }

                $conc = ClientContact::where('contact_id', $request->input("contact_id"))->first();
                $emp = Employers::where('employee_id', $request->input("employee_id"))->first();
                $vendor = '';
                $ship = Shippers::where("shipper_id", $request->input("shipper_id"))->first();

                if ($ship) {
                    // Check if $ship is not null
                    $vendor = User::where("email", $ship->contact_email)->first();
                
                    if ($vendor) {

                        if ($request->input("shipper_mail") == "YES"){
                            // $vendor->notify(new ShipperEmail($arr2));
                            $his = new RfqHistory([
                                "user_id" => Auth::user()->user_id,
                                "rfq_id" => $rfq_id,
                                "action" => "Sent Email to " .$ship->vendor_name . " About RFQ with the reference number  $refrence_no",
                            ]); $his->save();
        
                        }

                    } else {
                        $vendor = "";
                    }

                } else {
                    $ship = "";
                }

                $arr = [
                    "conc" => $conc,
                    "emp" => $emp,
                    "rfq" => $this->model->show($rfq_id)
                ];
                if($request->input('status') == 'RFQ Acknowledged'){
                    $emp->notify(new RFQAcknowledge($arr));
                }

                if(ClientPo::where('rfq_id', $rfq_id)->exists()){
                    $po = ClientPo::where('rfq_id', $rfq_id)->first();
                    ClientPo::where('po_id', $po->po_id)->update([
                        "contact_id" => $request->input("contact_id")
                    ]);
                }

                $arr2 = ["vendor" => $vendor, "rfq" => $this->model->show($rfq_id), "ship" => $ship];

                $cli = Clients::where('client_id', $request->input('client_id'))->first();
                $his = new RfqHistory([
                    "user_id" => Auth::user()->user_id,
                    "rfq_id" => $rfq_id,
                    "action" => "Updated RFQ for " .$cli->client_name . " and Assigned The RFQ to ". $emp->full_name,
                ]); $his->save();

                if(ShipperQuote::where('rfq_id', $rfq_id)->exists()){
                    $shi = ShipperQuote::where('rfq_id', $rfq_id)->first();
                    ShipperQuote::where('rfq_id', $rfq_id)->update([
                        "rfq_id" => $rfq_id,
                        "customs_duty" => $custom,
                        "clearing_and_documentation" => $clearing,
                        "bmi_charges" =>  $shi->bmi_charges,
                        "soncap_charges" => $soncap,
                        "trucking_cost" => $trucking,
                        "shipper_id" => $request->input("shipper_id"),
                        "status" => $shi->status,
                        "mode" => $shi->mode,
                        "currency" => $shipper_currency,
                    ]);
                }else{
                    $sups = new ShipperQuote([
                        "rfq_id" => $rfq_id,
                        "customs_duty" => $custom,
                        "clearing_and_documentation" => $clearing,
                        "bmi_charges" =>  0,
                        "soncap_charges" => $soncap,
                        "trucking_cost" => $trucking,
                        "shipper_id" => $request->input("shipper_id"),
                        "status" => 'Submitted',
                        "mode" => 'Air',
                        "currency" => 'NGN'
                    ]);
                    $sups->save();
                }

                if($request->input("status") == 'PO Issued'){

                    if(ClientPo::where('rfq_id', $rfq_id)->exists()){
                        $po = ClientPo::where('rfq_id', $rfq_id)->first();
                        $po_id = $po->po_id;
                        $po_update = DB::table('client_pos')->where(['po_id' => $po_id])->update([
                            "client_id" => $po->client_id,
                            "company_id" => $po->company_id,
                            "rfq_id" => $rfq_id,
                            "rfq_number" => $po->rfq_number,
                            "status" => 'PO Issued',
                            "description" => $po->description,
                            "product" => $request->input("product"),
                            "po_date" => $po->po_date,
                            "po_number" => $po->po_number,
                            "delivery_due_date" => $po->delivery_due_date,
                            "delivery_location" => $po->delivery_location,
                            "delivery_terms" => $po->delivery_terms,
                            "contact_id" => $po->contact_id,
                            "po_value_foreign" => $po->po_value_foreign,
                            "po_value_naira" => $po->po_value_naira,
                            "payment_terms" => $po->payment_terms,
                            "note" => $po->note,
                            "po_receipt_date" => $po->po_receipt_date,
                            "est_production_time" => $po->est_production_time,
                            "est_ddp_lead_time" => $po->est_ddp_lead_time,
                            "est_delivery_date" => $po->est_delivery_date,
                            "supplier_proforma_foreign" => $po->supplier_proforma_foreign,
                            "supplier_proforma_naira" => $po->supplier_proforma_naira,
                            "shipping_cost" => $po->shipping_cost,
                            "po_issued_to_supplier" => $po->po_issued_to_supplier,
                            "payment_details_received" => $po->payment_details_received,
                            "payment_made" => $po->payment_made,
                            "payment_confirmed" => $po->payment_confirmed,
                            "work_order" => $po->work_order,
                            "shipment_initiated" => $po->shipment_initiated,
                            "shipment_arrived" => $po->shipment_arrived,
                            "docs_to_shipper" => $po->docs_to_shipper,
                            "delivered_to_customer" => $po->delivered_to_customer,
                            "delivery_note_submitted" => $po->delivery_note_submitted,
                            "customer_paid" => $po->customer_paid,
                            "payment_due" => $po->payment_due,
                            "status_2" => $po->status_2,
                            "employee_id" => $details->employee_id,
                            "contact_id" => $details->contact_id,
                            'ex_works_date' => $po->ex_works_date, 
                            'transport_mode' => $request->input("transport_mode"), 
                            'shipping_reliability' => $po->shipping_reliability,
                            'shipping_on_time_delivery' => $po->shipping_on_time_delivery, 
                            'shipping_pricing' => $po->shipping_pricing, 
                            'shipping_communication' => $po->shipping_communication,
                    
                    
                            'shipping_rater' => Auth::user()->first_name . ' '. Auth::user()->last_name,
                            'shipping_comment' => $po->shipping_comment, 
                            'shipping_overall_rating' => $po->shipping_overall_rating,
                            'survey_sent' => $po->survey_sent, 
                            'survey_sent_date' => $po->survey_sent_date, 
                            'survey_completed' => $po->survey_completed,
                            'survey_completion_date' => date('Y-m-d'), 
                            'tag_comment' => $po->tag_comment,
                            'supplier_ref_number' => $po->supplier_ref_number,
                            'actual_delivery_date'  => $po->actual_delivery_date, 
                            'timely_delivery' => $po->timely_delivery,
                            "shipper_id" => $request->input("shipper_id"),

                            'delivery' => $po->delivery, 'technical_notes' => $po->technical_notes, 
                            'hs_codes'=> $po->technical_notes, 'total_packaged_weight' => $po->total_packaged_weight,
                            'estimated_packaged_dimensions' => $po->estimated_packaged_dimensions,
                            'delivery_location_po' => $po->delivery_location_po,
                            'hs_codes_po' => $po->hs_codes_po,
                            'port_of_discharge' =>  $po->port_of_discharge,
                            'payment_terms_client' => $po->payment_terms_client,
                            'freight_charges_suplier' => $po->freight_charges_suplier,


                        ]);
                        $hi = new RfqHistory([
                            "user_id" => Auth::user()->user_id,
                            "rfq_id" => $rfq_id,
                            "action" => "Updated RFQ $refrence_no for PO Number" .$po->po_number,
                        ]); $hi->save();
                        return redirect()->route('po.edit',[$po->po_id])->with("success", "You Have Updated The PO With PO Number $po->po_number Successfully");

                    }else{
                        
                        $po_value_foreign = 0;
                        $po_value_naira = 0;
                        
                        if($request->input("currency") == 'NGN'){
                            $po_value_naira = $request->input("total_quote");
                        }else{
                            $po_value_foreign = $request->input("total_quote");
                        }
                        
                        $po_insert = new ClientPo([
                            "client_id" => $details->client_id,
                            "company_id" => $details->company_id,
                            "rfq_id" => $rfq_id,
                            "rfq_number" => $details->rfq_number,
                            "status" => 'PO Issued',
                            "description" => $details->description,
                            'product' => $request->input("product"),
                            "po_date" => date('Y-m-d'),
                            "po_number" => $po_number,
                            "delivery_location" => $request->input("delivery_location"),
                            "delivery_terms" => $request->input("payment_term"),
                            "contact_id" => $request->input("contact_id"),
                            "po_value_foreign" => $po_value_foreign,
                            "po_value_naira" => $po_value_naira,
                            "payment_terms" => $request->input("payment_term"),
                            "note" => $details->note,
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
                            "employee_id" => $request->input("employee_id"),
                            "contact_id" => $request->input("contact_id"),
                            
                            'ex_works_date' => date('Y-m-d'),
                            'transport_mode' => $request->input("transport_mode"), 
                            'shipping_reliability' => 0,
                            'shipping_on_time_delivery' => 0,
                            'shipping_pricing' => 0,
                            'shipping_communication' => 0,
                            'shipping_comment' => 'N/A', 
                            'shipping_rater' => Auth::user()->first_name . ' '. Auth::user()->last_name,
                            'shipping_comment' => 'N/A', 'shipping_overall_rating' => 0,
                            'survey_sent' => 0, 'survey_sent_date' => date('Y-m-d'), 'survey_completed' => 0,
                            'survey_completion_date' => date('Y-m-d'),
                            'supplier_ref_number' => 'Null',
                            'tag_comment' => 'N/A',
                            'timely_delivery' => 'YES',
                            "shipper_id" => $request->input("shipper_id"),

                            'delivery' => 'N/A', 
                            'technical_notes' => 'N/A', 
                            'hs_codes'=> $request->input("hs_codes"),
                            'total_packaged_weight' => $request->input("estimated_package_weight"),
                            'estimated_packaged_dimensions' => $request->input("estimated_package_dimension"),

                            'delivery_location_po' => 'N/A',
                            'hs_codes_po' => 'N/A',
                            'port_of_discharge' => 'N/A',
                            'freight_charges_suplier' => 0,
                            

                        ]);
                        $dir = base_path("email/po/".$refrence_no."/");
                        !file_exists(File::makeDirectory($dir, $mode = 0777, true, true));
                        $po_insert->save();
                        $hi = new RfqHistory([
                            "user_id" => Auth::user()->user_id,
                            "rfq_id" => $rfq_id,
                            "action" => "Created PO Number" .$po_number. " For RFQ ". $refrence_no,
                        ]); $hi->save();
                        $po = ClientPo::where('rfq_id', $rfq_id)->first();
                        return redirect()->route('po.edit',[$po->po_id])->with("success", "You Have Created The PO WIth The PO Number $po_number Successfully");
                    }

                }else{

                    return redirect()->back()->with([
                        "success" => 'You Have Updated The RFQ  ' . $refrence_no. " Successfully"
                    ]);

                }

                

            } else {
                return redirect()->back()->with("error", "Network Failure");
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

    public function sendEnq(Request $request, $reference_no)
    {
        
        $rfq_id = $request->input('rfq_id');

        if (Gate::allows('SuperAdmin', auth()->user()) OR (Auth::user()->hasRole('Admin')) OR  (Auth::user()->hasRole('HOD')) OR  (Auth::user()->hasRole('Employer'))){
            $rfq = ClientRfq::where('rfq_id', $rfq_id)->first();
            
            $cli_title = clis($rfq->client_id);
            $resultt = json_decode($cli_title, true);
            $client_name = $resultt[0]['client_name'];
            $assigned_details = empDetails($rfq->employee_id);
            $assigned = $assigned_details->full_name;
            $pdfname = "TAG Energy Quotation TE-" . $resultt[0]['short_code'] . '-RFQ' . preg_replace('/[^0-9]/', '', $rfq->refrence_no) . ", " . $rfq->description;
            $rfqcode = "TE-". $resultt[0]['short_code'] . '-RFQ' . preg_replace('/[^0-9]/', '', $rfq->refrence_no);
            
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
                    "rfq_no" => $rfq->rfq_number,
                    "reference_no" => $rfqcode,
                    "description" => $rfq->description,
                ];
        
                // Send email using the data
                $when = now()->addMinutes(1);
                Mail::to($rec_mail)->cc(str_replace(" ", "", $users))->send(new ClientContactRFQCreated($data));
        
                return redirect()->back()->with([
                    'success' => 'Email Sent Successfully'
                ]);
            } catch (\Exception $e) {
                return redirect()->back()->with("error", "Email not sent, " . $e->getMessage());
            }

        }else{
            return redirect()->back()->with([
            'error' => "You Dont have Access To This Page",
            ]);
        }
    }

    public function price($refrence_no)
    {

        $rfq = ClientRfq::where('refrence_no', $refrence_no)->first();

        if(ClientRfq::where('rfq_id', $rfq->rfq_id)->exists()){
            $rfq_id = $rfq->rfq_id;
            function generateRandomHash($length)
            {
                return strtoupper(substr(md5(uniqid(rand())), 0, (-32 + $length)));
            }
            $number = strtoupper(generateRandomHash(6));
            $line_items = LineItem::where([
                'rfq_id' => $rfq_id
            ])->orderBy('created_at','asc')->get();
            $rfq = $this->model->show($rfq_id);
            $check = SupplierQuote::where([
                'rfq_id' => $rfq->rfq_id,
                'status' => 'Picked'
            ])->get();

            $shipQuote = ShipperQuote::where([
                'rfq_id' => $rfq->rfq_id,
            ])->get();

            if (Gate::allows('SuperAdmin', auth()->user())) {
                return view('dashboard.rfq.price_quotation')->with([
                    "line_items" => $line_items, "rfq" => $rfq, 'check' => $check, "number" => $number, "shipQuote" => $shipQuote
                ]);
            }elseif(auth()->user()->hasRole('Admin')){
                $company = Companies::where('email', Auth::user()->email)->first();
                return view('dashboard.rfq.price_quotation')->with([
                    "line_items" => $line_items, "rfq" => $rfq, 'check' => $check, "number" => $number, "shipQuote" => $shipQuote, 'company' => $company
                ]);
            }elseif(auth()->user()->hasRole('Employer') OR (auth()->user()->hasRole('HOD'))){
                $employee = Employers::where('email', Auth::user()->email)->first();
                return view('dashboard.rfq.price_quotation')->with([
                    "line_items" => $line_items, "rfq" => $rfq, 'check' => $check, "number" => $number, "shipQuote" => $shipQuote,
                    'employee' => $employee
                ]);
            }else{
                return view('dashboard.rfq.price_quotation')->with([
                    "line_items" => $line_items, "rfq" => $rfq, 'check' => $check, "number" => $number, "shipQuote" => $shipQuote
                ]);
            }

        }else{
            return redirect()->back()->with([
            'error' => "$rfq_id does not Exist for any RFQ",
            ]);
        }
    }

    public function removeFile($rfq_id, $filename){
       if(!empty(unlink('document/rfq/'.$rfq_id.'/'.$filename))){
            return redirect()->back()->with(['success' => "File Deleted Successfully "]);
       }else{
            return redirect()->back()->with(['error' => "Unable to delete file at the moment, Please try again later"  ]);
       }

    }

    public function removeImage($rfq_id, $filename){
        if(!empty(unlink('document/rfq/files/'.$rfq_id.'/'.$filename))){
             return redirect()->back()->with(['success' => "Image Deleted Successfully "]);
        }else{
             return redirect()->back()->with(['error' => "Unable to delete the image at the moment, Please try again later"  ]);
        }

    }


    public function removeAllFile($rfq_id){

        if (file_exists('document/rfq/'.$rfq_id.'/')){
            $files = glob('document/rfq/'.$rfq_id.'/*');
            foreach($files as $file){
                if(!empty(unlink($file))){

                }
            }
            return redirect()->back()->with(['success' => "All Files Deleted Successfully "]);
        }else{
            return redirect()->back()->with(['error' => "Unable to delete all the files at the moment, Please try again later"  ]);
        }

     }

    public function testUpdate(Request $request, $po_id)
    {
       $details = $this->model->show($po_id);
        dd($details);
    }
    
    
    
    
    
    
    
        public function submitRfqToVendor(Request $request)
        {
            $this->validate($request, [
                'vendor_id' => ['required', 'string'],
                'report_recipient' => ['required'],
                'contact_id' => ['nullable'],
                'line_items' => ['nullable'],
                'send_all' => 'nullable',
            ]);
            
            $rfq_id = $request->input("rfq_id");
            $rfq = $this->model->show($rfq_id);
            $vendor = Vendors::where('vendor_id', $request->input("vendor_id"))->first();
            $vendor_contact = VendorContact::where('contact_id', $request->input("contact_id"))->first();
            $mail_id = Str::random(30);

            //dd($vendor);
            if($request->input("send_all") == 1){
                $line_items = LineItem::where('rfq_id', $rfq_id)->orderBy('item_serialno', 'asc')->get();
                $line_items_input = [];
                foreach($line_items as $line_item){
                    $line_items_input = $line_item->item_serialno;
                }
            }else {
                // Retrieve the "line_items" input
                $line_items_input = $request->input("line_items");
                
                // Initialize an empty array to hold the serial numbers
                $serial_numbers = [];
            
                if ($line_items_input) {
                    // Split the input by commas to get each range or individual number
                    $ranges = explode(',', $line_items_input);
                    
                    foreach ($ranges as $range) {
                        // Check if the range contains a dash (e.g., "1-3")
                        if (strpos($range, '-') !== false) {
                            list($start, $end) = explode('-', $range);
                            // Add all numbers in the range to the array
                            $serial_numbers = array_merge($serial_numbers, range((int)$start, (int)$end));
                        } else {
                            // If there's no dash, just add the single number
                            $serial_numbers[] = (int)$range;
                        }
                    }
                }
                
                // Now use `whereIn` to select items based on the expanded serial numbers array
                $line_items = LineItem::where('rfq_id', $rfq_id)
                                      ->whereIn('item_serialno', $serial_numbers)
                                      ->orderBy('item_serialno', 'asc')
                                      ->get();
            }
            
             
            
            $report_recipient = $request->input("report_recipient");
            $extra_note = $request->input('extra_note');
    
            $file = $request->quotation_file;
            $arrFile = array();
            $number = rand(1,200);
            $refrence = $rfq->refrence_no;
            $dest = date('Y'.'d'.'m').$refrence.$number;
    
            $cut = explode("; ", $report_recipient);
            $users = [];
    
            if (ClientRfq::where('rfq_id', $rfq_id)->exists()) {
                $ref = ClientRfq::where('rfq_id', $rfq_id)->first();
                $rfq = $this->model->show($rfq_id);
        
                if (count($line_items) > 0) {
                    $pdf = PDF::loadView('dashboard.printing.supplierRFQ', compact('rfq', 'line_items', 'vendor', 'vendor_contact'))->setPaper('a4', 'portrait');
                     
                          
                //dd($line_items);
                $cli_title = clis($rfq->client_id);
                $resultt = json_decode($cli_title, true);
                $client_name = $resultt[0]['client_name'];
                $assigned_details = empDetails($rfq->employee_id);
                $assigned = $assigned_details->full_name;
                $pdfname = "TAG Energy Request for Quotation TE-" . $resultt[0]['short_code'] . '-RFQ' . preg_replace('/[^0-9]/', '', $rfq->refrence_no) . ", " . $rfq->description;
                $rfqcode = "TE-". $resultt[0]['short_code'] . '-RFQ' . preg_replace('/[^0-9]/', '', $rfq->refrence_no);
                
                // Replace "/" with "-"
                $pdfname = str_replace("/", "-", $pdfname);
         
                    // Temporary file path to store the PDF
                    $tempFilePath = storage_path($pdfname . '.pdf');
                    // Save the PDF temporarily
                    $pdf->save($tempFilePath);
                }else{
                    $tempFilePath = "";
                }
            //dd($line_items);
            foreach($cut as $key => $ut){
                $ua = [];
                $ua['email'] = $ut;
                $split = $cut = explode("@", $ut);
                $ua['name'] = ucwords(str_replace("."," ",$split[0]));
                $users[$key] = (object)$ua;
            }

            $users[] = (object) [
                'email' => $vendor_contact->email,
                'name' => $vendor_contact->first_name . ' ' . $vendor_contact->last_name
            ];
            //dd($users);
            try{
                
                if ($request->hasFile('quotation_file')) { // Change to 'files' which corresponds to the input field name
                    $files = $request->file('quotation_file'); // Get uploaded files
            
                    // Array to store temporary file paths
                    $tempFileDirs = [];
                    // Array to store original file names
                    $fileNames = [];
             
                // Save uploaded files temporarily and get file paths
                foreach ($files as $file) {
                    // Generate a unique file name
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    // Move uploaded file to temporary storage path
                    $tempFileDir = storage_path('temp') . '/' . $fileName;
                    $file->move(storage_path('temp'), $fileName);
                    // Store temporary file path in array
                    $tempFileDirs[] = $tempFileDir;
                    // Store original file name in array
                    $fileNames[] = $file->getClientOriginalName();
                    }
                }else{
                    $tempFileDirs = "";
                    $fileNames = "";
                }
                //str_replace(" ","",$users) 
                //$rec_mail
                $mail_subject = "Request for Pricing Information: - " .$rfqcode." ".$rfq->description;
                $data = ["rfq" => $rfq, 'company' => Companies::where('company_id', $rfq->company_id)->first(), 'tempFilePath' => $tempFilePath, 'tempFileDirs' => $tempFileDirs, 'fileNames' => $fileNames, 'rfqcode' => $rfqcode, 'extra_note' => $extra_note, 'client_name' => $client_name, 'assigned' => $assigned, "vendor_contact" => $vendor_contact, "mail_id" => $mail_id];
                $when = now()->addMinutes(1);
                Mail::to('emmanuel.idowu@tagenergygroup.net')->cc('emmanuel@enabledgroup.net')->send( new QuoteRequest ($data));        
                if($extra_note != ""){
    	        $newNote = date('d/m/Y') .' ' . Auth::user()->first_name . ' '. Auth::user()->last_name .' Sent Request for Quotation to '. $vendor->vendor_name . ' with an extra note stating: '.$extra_note.' and changed the status to Awaiting Pricing <br/>'.$rfq->note;
                }else{
                $newNote = date('d/m/Y') .' ' . Auth::user()->first_name . ' '. Auth::user()->last_name .' Sent Request for Quotation to '. $vendor->vendor_name . ' and changed the status to Awaiting Pricing <br/>'.$rfq->note;
                }
                DB::table('client_rfqs')->where(['rfq_id' => $rfq_id])->update(['note' => $newNote, 'status' => 'Awaiting Pricing']);
                $his = new RfqHistory([
                    "user_id" => Auth::user()->user_id,
                    "rfq_id" => $rfq_id,
                    "action" => "Sent Request for Pricing to $vendor->vendor_name",
                ]); $his->save();
                
                unlink($tempFilePath);
                
                // Delete temporary files after email is sent
                if($tempFileDirs != ""){
                    foreach ($tempFileDirs as $tempFileDir) {
                        unlink($tempFileDir);
                    }
                }

                $pricing_history = new PricingHistory();

                $pricing_history->rfq_id = $request->input('rfq_id');
                $pricing_history->vendor_id = $request->input('vendor_id');
                $pricing_history->contact_id = $request->input('contact_id');
                $pricing_history->line_items = json_encode($line_items_input);
                $pricing_history->mail_id = $mail_id;
                $pricing_history->status = "Awaiting Pricing";

                $pricing_history->save();

                $mail_tray = new MailTray([
                    "rfq_id" => $rfq_id,
                    "vendor_id" => $request->input('vendor_id'),
                    "contact_id" => $request->input('contact_id'),
                    "mail_id" =>  $mail_id,
                    "subject" => $mail_subject,
                    "body" => "Pricing Request",
                    "recipient_email" => $vendor->contact_email,
                    "cc_email" => $users,
                    "date_sent" => date("Y-m-d H:i:s"),
                    "sent_by" => Auth::user()->user_id,
                ]);
                $mail_tray->save();

                return redirect()->back()->with("success", "You have sent the Request Successfully.");
            }catch(\Exception $e){
    
                return redirect()->back()->with("error", "Request Approval not sent, ". $e->getMessage());
            }
       
        }
    
        }





}
