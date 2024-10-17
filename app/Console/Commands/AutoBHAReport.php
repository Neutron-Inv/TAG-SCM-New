<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\BHAReport;
use App\ClientPo;
use App\ClientRfq;
use App\ClientContact;
use App\Employers;
use App\Automation;
use Illuminate\Support\Facades\Log;
class AutoBHAReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:AutoBHAReport';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automated BHA Report weekly';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $contact_email="";
        Log::info('BHA Report command started.');
        // Fetch the RFQ
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

        $rec_mail = 'emmanuel.idowu@tagenergygroup.net';;
        $cc_mail = [
                    'emmanuel@enabledgroup.net',
                    'emmanuel.idnoble@gmail.com',
                ];
        try{
            $data = ['rfq'=> $rfq, 'bha' => $bha];
            $when = now()->addMinutes(1);
            Mail::to($rec_mail)
            ->cc($cc_mail)
            ->send( new BHAReport ($data));
            Log::info('BHA Report mail Sent.');
        }catch(\Exception $e){
            Log::info('BHA Report mail failed, reason: '.$e);
        }
}
}