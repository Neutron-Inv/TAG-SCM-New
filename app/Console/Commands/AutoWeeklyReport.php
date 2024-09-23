<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\WeeklyReport;
use App\ClientPo;
use App\ClientRfq;
use App\ClientContact;
use App\Employers;
use App\Automation;
use Illuminate\Support\Facades\Log;
class AutoWeeklyReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:AutoWeeklyReport';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automated Weekly RFQs and POs Report';

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
        Log::info('Weekly Report command started.');
        // Fetch the RFQ
        // Calculate the dates for the current week's Monday and Friday
        $currentWeekMonday = now()->startOfWeek(); // Monday of the current week
        $currentWeekFriday = now()->startOfWeek()->addDays(4); // Friday of the
       
        $po = ClientPo::whereBetween('po_date', [$currentWeekMonday, $currentWeekFriday])
        ->where('status', '!=', 'PO Cancelled')
        ->where('company_id', '2')
        ->select('client_id', \DB::raw('count(*) as count'))
        ->groupBy('client_id')
        ->get();

        $pototal = ClientPo::whereBetween('po_date', [$currentWeekMonday, $currentWeekFriday])
        ->where('status', '!=', 'PO Cancelled')
        ->where('company_id', '2')
        ->count();

        $rfq = ClientRfq::whereBetween('rfq_date', [$currentWeekMonday, $currentWeekFriday])
        ->select('client_id', \DB::raw('count(*) as count'))
        ->where('company_id', '2')
        ->groupBy('client_id')
        ->get();

        $rfqtotal = ClientRfq::whereBetween('rfq_date', [$currentWeekMonday, $currentWeekFriday])->count();

        $nlng = ClientPo::where('client_id', '114')
        ->whereYear('po_date', now()->year)
        ->orderBy('po_number', 'asc')
        ->get();

        $grn = ClientPo::where('status', 'Awaiting GRN')
        ->where('company_id', '2')
        ->get();

        $rec_mail = 'emmanuel.idowu@tagenergygroup.net';;
        $cc_mail = [
                    'emmanuel@enabledgroup.net',
                    'emmanuel.idnoble@gmail.com',
                    'sales@tagenergygroup.net',
                ];
        try{
            $data = ['rfq'=> $rfq, 'rfqtotal' => $rfqtotal, 'po' => $po, 'pototal' => $pototal, 'monday'=> $currentWeekMonday ,'friday' => $currentWeekFriday, 'grn' => $grn];
            $when = now()->addMinutes(1);
            Mail::to($rec_mail)
            ->cc($cc_mail)
            ->send( new WeeklyReport($data));   
            
            Log::info('Weekly Report mail Sent.');
        }catch(\Exception $e){
            Log::info('Weekly Report mail failed, reason: '.$e);
        }
}
}